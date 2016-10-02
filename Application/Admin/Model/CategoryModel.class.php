<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model
{
/*********表单验证规则********/
protected $_validate=[
	['cat_name','require','分类名称不能为空',1],
	['sort_num','1,3','排序字段限制在1-999',2,'length'],
	['is_show','require','是否楼层',2],
	['cat_name','','分类名称已存在',1,'unique'],

];

	public function show()
		
	{
		 $data=$this->order('sort_num ASC')->select();

		 return $this->short($data);
	}

	private function short($data,$top=0,$buff=0)
	{
		static $temp=[];		
		foreach($data as $k=>$v)
		{
			if($v['parent_id']==$top)
			{
				$v['buff']=$buff;
				$temp[]=$v;			
				$this->short($data,$v['id'],$buff+1);
			}
		}
		return $temp;
	}
	public function son($getF)
	{
		$son=$this->field('id,parent_id')->select();	
		$ret=$this->_subclass($son,$getF);	
		return $ret;
	}
	

	public function son_2($getF) //商品主页要到的查子类方法 更新后可以查两次了
	{
		$data=$this->field('id,parent_id')->select();
		// 找出子分类的ID,第三个参数是说先清空一下
		$ret=$this->_son2($data,$getF,true);	
		return $ret;
	}


	private function _son2($data,$getId,$sex=false)
	{
		static $temp=[];
		if($sex)
			$temp = [];
		foreach($data as $k=>$v)
		{
			if($v['parent_id']==$getId)
			{
				$temp[]=$v['id'];
				$this->_son2($data,$v['id']);
			}
		}
		return $temp;
	}

	public function subclass($getId,$sex=false)
	{
		$subClassData=$this->select();
		$sub=$this->_subclass($subClassData,$getId);	
		$sub[].=$getId;
		if($sex==false)
		{
			return $this->where([
				'id' => ['in', $sub],
			])->delete();
		}
		else
		{
			return $sub;
		}

	}

	private function _subclass($data,$getId)
	{
		static $semp=[];

		foreach($data as $k=>$v)
		{
			if($v['parent_id']==$getId)
			{
				$semp[]=$v['id'];
				$this->_subclass($data,$v['id']);
			}
		}
		return $semp;
	}

	public function father($getId)
	{
		$son=$this->select();	
		$ret=$this->_father($son,$getId,true);	
		return $ret;		
	}

	private function _father($data,$getId=0,$isFirst = false)
	{
		static $qemp=[];

		if($isFirst)
			$qemp = [];

		foreach($data as $k=>$v)
		{
			if($v['id']==$getId)
			{
				array_unshift($qemp,$v['cat_name']);
				$this->_father($data,$v['parent_id']);
			}
		}
		return $qemp;
	}

	public function edit($get)
	{
		return 	$this->find("$get");
	}
	public function getNavData()
	{
		$_ret=[];
		//取出所有分类
		$data =$this->select();
		//挑出顶级分类
		foreach($data as $k=>$v)
		{
			if($v['parent_id']==0)
			{
				foreach($data as $k1=>$v1)
				{
					if($v1['parent_id']==$v['id'])
					{
						foreach($data as $k2=>$v2)
						{
							if($v2['parent_id']==$v1['id'])
							{
								$v1['children'][]=$v2;
							}
						}
						//把子分类存到$v的children中
						$v['children'][]=$v1;
					}
				}				
			$_ret[]=$v; //挑出顶级分类			
			}
		}
		return $_ret;
	}

	//取出上级分类
	public function getParentCategory($goodsId)
	{
		//实例化商品表
		$gD=M('goods');		
		$goodsData=$gD->find($goodsId);		
		$catData=$this->show();
		//取出所有父级分类
		$Fdata=$this->father($goodsData['cat_id']);
		return implode(' > ',$Fdata);
	}

	//取出上级分类
	public function getCategorySear($cid)
	{
		$data =$this->show();
		$data= $this->getCategoryFather($data,$cid,$first=true);
		return implode(' > ',$data);
	}
	public function getCategoryFather($data,$cid,$first=false)	
	{
		static $temp=[];

		if($first)
			$temp=[];

	 	foreach($data as $k=>$v)
	 	{
			if($v['id']==$cid)
			{
				array_unshift($temp,$v['cat_name']);
				$this->getCategoryFather($data,$v['parent_id']);
			}
	 	}

	 	return $temp;
	
	}



	//取楼层数据
	public function getFloorData()
	{
		//先获取楼层数据
		$ret=$this->where([
			'parent_id'=>0,
			'is_show'=>'y',
			])
		->order('sort_num ASC')
		->select();
		//商品模型生成
		$goodsModel=M('goods');
		//循环每层楼，取出楼里数据
		foreach($ret as $k=>$v)
		{	
			//取出未推荐的二级分类
			$ret[$k]['children']=$this->where([
					'parent_id'=>$v['id'],			
					'is_show'=>'n',
					])->select();
			//取出未推荐的二级分类
			$ret[$k]['recChildren']=$this
									->where([
											'parent_id'=>$v['id'],			
											'is_show'=>'y',
											])
									->limit(5)
									->select(); 
			//循环推荐的二级分离
			foreach($ret[$k]['recChildren'] as $k1 => $v1)
			{
				//取出该分类的子分类
				$child =$this->son_2($v1['id']);
				$child[]=$v1['id'];
				$ret[$k]['recChildren'][$k1]['goods']
									=$goodsModel
									->field('id,goods_name,shop_price,mid_logo')
									->where([
										'is_on_sale'=>'y',
										'cat_id'=> ['in',$child],
										'is_folor'=>'y',
										])
									->limit(8)
									->select();
			}

		}

		return $ret;
	}

	public function searchInfo()
	{
		$cache='searchCache'.I('get.cid');
		$searchCache=S($cache);
		if($searchCache)
			return $searchCache;

		$goodsM=M('goods');
		$price=$goodsM->field('MAX(shop_price) as max_p,MIN(shop_price) as min_p ')
			   ->where(['cat_id'=>I('get.cid'),'is_on_sale'=>'y'])
			   ->find();
		
		$cha=$price['max_p']-$price['min_p'];
		$js=ceil($cha/7);//分几段
		$first=(int)$price['min_p'];//最小的数
		$priceSum=[];
		for($i=1;$i<7;$i++)
		{
			$new=(intval($first+$js)/10)*10-1;
			//这个区间是否有商品
			$has=$goodsM->where([
				'is_on_sale'=>'y',
				'shop_price'=>['between',[$first,$new]],

				])->count();
			if($has>0)
				$priceSum[]=$first.'-'.$new;
			$first=$new+1;
		}
		$priceSum[]=$first.'以上';
	
		$data=['price'=>$priceSum];
		S($cache,$data);
		return $data;

	}

}

