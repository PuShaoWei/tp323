<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model
{
	/*********表单验证规则********/
	protected $_validate=[
		['goods_name','require','商品名称不能为空',1],
		['market_price','currency','市场价格必须填成货币类型',1],
		['shop_price','currency','本店价格必须填成货币类型',1],
		['cat_id','require','分类名称没选择',1],
		['goods_brand','require','品牌未选择',2],
		['promote_price','require','促销价格必须填成货币类型',2],
		['promote_start','require','开始时间不能为空',2],
		['promote_end','require','结束时间不能为空',2],
		['promote_end','time','开始时间大于结束时间',2,'callback'],

	];

	public  function time()
	{
		return I('post.promote_start')<=I('post.promote_end');
	}


	public function adv_delete($id)
	{
		//从硬盘中删除这个图片 field 取出这几个字段
		$logo=$this->field('sm_logo,mid_logo,big_logo,logo')->find($id);
		//删除图片			
				@unlink(IMG_PATH.$logo['sm_logo']);
				@unlink(IMG_PATH.$logo['mid_logo']);
				@unlink(IMG_PATH.$logo['big_logo']);
				@unlink(IMG_PATH.$logo['logo']);
		//商品删除
			$this->delete($id);
		//商品相册删除
			$gbModel=M('goods_pic');
			$pic=$gbModel->where('goods_id=%d',$id)->select();
			foreach ($pic as $k => $v)
			{
				@unlink(IMG_PATH.$v['sm_photo']);
				@unlink(IMG_PATH.$v['mid_photo']);
				@unlink(IMG_PATH.$v['big_photo']);
				@unlink(IMG_PATH.$v['photo']);
			}
			$gbModel->where('goods_id=%d',$id)->delete();
		//会员价格删除
			$memberModel=M('member_price');
			$memberModel->where('goods_id=%d',$id)->delete();	
		//商品属性删除
			$attrModel=M('goods_attr');
			$attrModel->where('goods_id=%d',$id)->delete();	 
		//商品库存量删除
			$numModel=M('goods_number');
			$numModel->where('goods_id=%d',$id)->delete(); 
	}
	
	public function getPromoteGoods($limit=5)//获取正在促销的商品
	{
		//获取当前时间
		$today=date('Y-m-d H:i:s');
		return $this->field('id,goods_name,promote_price,mid_logo')
					->where([
						'is_on_sale'=>'y',
						'promote_start'=>['elt',$today],
						'promote_end'=>['egt',$today],
						])
					->limit(5)
					->select();
	}	
	public function getRecGoods($rec,$limit=5)//获取正在促销的商品
	{
		//获取当前时间
		$today=date('Y-m-d H:i:s');
		return $this->field('id,goods_name,promote_price,mid_logo')
					->where([
						'is_on_sale'=>'y',
						'is_'.$rec=>'y',
						])
					->limit(5)
					->select();
	}
	public function getAttr($Id)
	{
		header('content-type:text/html;charset=utf-8');

		$attrData=$this->alias('a')
			->field('b.*,c.attr_type,c.attr_name')
			->join('LEFT JOIN __GOODS_ATTR__ b ON a.id=b.goods_id
					LEFT JOIN __ATTRIBUTE__ c ON b.attr_id=c.id ')
			->where(['a.id'=>$Id])
			->select();
		foreach($attrData as $v)
		{
			if($v['attr_type']=='唯一')
				$attr['sole'][]=$v;
			else
			{
				$attr['noSole'][$v['attr_id']][] =$v;
			}
		}
		return $attr;
	}

	public function memberPrice($goodsId)
	{
		$price='';
		//获取当前时间
		$time=date('Y-m-d H:i:s',time());
		//获取商品数据
		$gData=$this->field('shop_price,promote_price,promote_end,promote_start')->find($goodsId);
		//取出商品本店价格
		$data= $this->field('shop_price')->find($goodsId);
		/*************根据促销时间********************/
		if($time<=$gData['promote_end'] && $time>=$gData['promote_start'])
			$price=$gData['promote_price'];
		else
			$price=$gData['shop_price'];

		/**************根据用户级别*****************/
		if(isset($_SESSION['front']['level_id']))
		{
			$mId=$_SESSION['front']['level_id'];
			$mPrice=M('member_price');
			$mGoods=$mPrice->where([
				'level_id'=>$mId,
				'goods_id'=>$goodsId,
				])->find();
			//如果设置了会员价格就取小的内个
			if(isset($mGoods['price']))
				$price=min($price,$mGoods['price']);
		}
		return $price;
	}


}