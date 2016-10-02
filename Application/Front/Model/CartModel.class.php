<?php
namespace Front\Model;
use Think\Model;
use Exception;
class CartModel extends Model
{
	//设定表单验证规则
protected $_validate=[
		['goods_id','/^[1-9][0-9]*$/','商品 id不正确 ',1],
		['goods_number','/^[1-9][0-9]*$/','库存量不正确',1],
	];
	//添加到购物车
	public function addToCart()
	{
		$al=I('post.goods_attr_id');
		//序列化属性
		sort($al);		
		$attr=implode(',',$al);
		//接收post来的数据
		$goodsId=I('post.goods_id/d');
		$goodsNumber=I('post.goods_number/d');
		//接收session中的数据
		$member=isset($_SESSION['front']['id'])?$_SESSION['front']['id']:'';
		//检查库存量
		$Num=M('goodsNumber');
		$goodsNum=$Num->where([
						'goods_id'=>$goodsId,
						'attr_list'=>$attr,
							])
						->field('goods_number')
						->find();
		if($goodsNum<$goodsNumber)
		{
			throw new \Exception('库存量不足');
		}
		else if($member)
		{
			//因为要做未登陆加入购物车,先判断有无这件商品
			$isset=$this->field('id')->where([
						'goods_id'=>$goodsId,
						'goods_attr_id'=>$attr,
						'member_id'=>$member,
				])->find();
			if($isset)
			{	
				//字段+多少	setInc(字段,+多少)
				$this->where(['id'=>$isset['id'],])
					->setInc('goods_number',$goodsNumber);
			}
			else
			{
				$this->add([
					'goods_id'=>$goodsId,
					'goods_number'=>$goodsNumber,
					'goods_attr_id'=>$attr,
					'member_id'=>$member,
						]);				
			}
		}
		else//如果没有登录就暂时存在cookie中
		{
			/****************从SESSION 取出数据**********************/
			$cart=isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):[];
			/*********************修改数组**************************/
			$key=I('post.goods_id').'-'.$attr;

			if(isset($cart[$key]))
				$cart[$key]+=I('post.goods_number/d');
			else
				$cart[$key]=I('post.goods_number/d');
			/*****************存回COOKIE***************************/
			setcookie('cart',serialize($cart),time()+30*86400,'/');
		}
	}
	public function cartList()
	{

		$goodsM=D('Admin/Goods');
		$attrM=M('goods_attr');	

		$al=I('post.goods_attr_id');
		//序列化属性
		sort($al);		
		$attr=implode(',',$al);

		//接收post来的数据
		$goodsId=I('post.goods_id/d');
		if(isset($_SESSION['front']['id']))
		{
			$cart=$this->where([
				'member_id'=>($_SESSION['front']['id'])
				])->select();
			$this->addCookie();
		}
		else
		{
			$_cart=isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):[];
			foreach($_cart as $k=>$v)
			{	
				$_k=explode('-', $k);
				$cart[]=[
				'goods_attr_id'=>$_k[1],
				'goods_id'=>(int)$_k[0],
				'goods_number'=>$v,
				];
			}
		}


		foreach($cart as $k=>$v )
		{
			//取出价格
			$priceData=$goodsM->memberPrice($v['goods_id']);
			//取出名称 图片
			$goodsData=$goodsM->field('goods_name,sm_logo')
						->find($v['goods_id']);
/***************************************************************************************/
			//取出属性			
			$attrData=$attrM->field('a.attr_value,b.attr_name')
					->alias('a')
					->join('__ATTRIBUTE__ b ON a.attr_id=b.id')
					->where(['a.id'=>['in',$v['goods_attr_id']]])
					->select();											
/***************************************************************************************/								
			//存进数据
			$cart[$k]['info']=$goodsData;
			$cart[$k]['price']=$priceData;
			$cart[$k]['attr']=$attrData;

		}
		return $cart;	
	}
	public function addCookie()
	{
		$_cart=isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):[];
		foreach($_cart as $k=>$v)
		{	
			$_k=explode('-', $k);
			// 判断表中有没有这件商品
			$id = $this->field('id')->where([
									'member_id' => $_SESSION['front']['id'],
									'goods_id' => $_k[0],
									'goods_attr_id' => $_k[1],
									'goods_number' => $v,
								])->find();
			if($id)
			{
				// setInc(字段，+几)
				$this->where([
							'id' => $id['id'],
						])->setInc('goods_number', $v);
			}
			else
			{
				$this->add([
							'member_id' => $_SESSION['front']['id'],
							'goods_id' => $_k[0],
							'goods_attr_id' => $_k[1],
							'goods_number' => $v,
						]);
			}
		}
		// 清空cookie
		setcookie('cart', '', time()-1, '/');
	}

}