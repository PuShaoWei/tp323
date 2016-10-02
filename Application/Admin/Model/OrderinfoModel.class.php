<?php
namespace Admin\Model;
use Think\Model;
use Exception;
class OrderinfoModel extends Model
{
	/********************表单验证****************/
	protected $_validate=[
		['shrname' ,'require','收货人姓名不能为空',1],
		['province','require','省份不能为空',1],
		['city','require','市不能为空',1],
		['area','require','区不能为空',1],
		['address' ,'require','地址不能为空',1],
		['tel' ,'/^1[3456789]\d{9}$/','电话号码格式不对',1,'regex'],
		['post_method','require','快递公司不能为空',1],
		['pay','require','支付方式不能为空',1],
	];

	public function adv_add()
	{
		$cart=D('Front/Cart');
		/********************订单验证***********************/
		$data=$cart->cartList();
		if(empty($data))
			throw new \Exception('购物车中无此商品');
		/********************库存量验证********************/
		$goodsNumber=M('goodsNumber');
		//循环每件商品 并检查库存数
		$tp =0;
		/*************************************************************************************************************/
		foreach($data as $k=>$v)
		{
			$gnData=$goodsNumber->field('goods_number')					
									->where([
								'goods_id'=>$v['goods_id'],
								'attr_list'=>$v['goods_attr_id'],	//为什么这里非要弄成goods_attr_list
										])								//新发现，因为$v['goods_attr_list']根本不存在，但是我写了
									->find();							//我把前面的attr_list 前面加了一个goods_attr_list,
		/***************************************************************************************************************/
			if($gnData['goods_number']<$v['goods_number'])
			{	
				
				throw new \Exception('这件商品明明刚刚还有的');	
			}
			$tp += $v['goods_number']*$v['price'];
		}
		/**********************下单*************************/
		$orderId=$this->add([
				  'shrname' =>I('post.shrname'),
				  'province'=>I('post.province'),
				  'city'=>I('post.city'),
				  'area'=>I('post.area'),
				  'address'=>I('post.address'),
				  'tel'=>I('post.tel'),
				  'post_method'=>I('post.post_method'),
				  'pay' =>I('post.pay'),
				  'member_id'=>$_SESSION['front']['id'],
				  'total_price'=> $tp,
				]);
		/************把购物车中的商品插入到订单中**********/
		$orderGoods=M('orderGoods');
		foreach($data as $k=>$v)
		{
			$ogData=$orderGoods->add([	
						  'order_id'=>$orderId, 
						  'goods_id'=>$v['goods_id'],
						  'member_id'=>$_SESSION['front']['id'],  
						  'goods_attr_id'=>$v['goods_attr_id'],
						  'price' =>$v['price'],
						  'goods_number' =>$v['goods_number']]);
		/*******************减少库存量********************/
		$goodsNumber->where([
				'goods_id'=>$v['goods_id'],
				'attr_list'=>$v['goods_attr_id'],
			])->setDec('goods_number',$v['goods_number']);
		}
		/********************清空购物车*******************/
		$cart->where(['member_id'=>$_SESSION['front']['id']])->delete();
		/*****************返回订单的id********************/
		return $orderId;
	}
}
