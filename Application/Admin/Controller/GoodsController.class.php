<?php
namespace Admin\Controller;
class GoodsController extends  ParentController 
{
	public function goods_number()
	{
		//实例化库存量
		$gnModel=M('goods_number');
		//获取商品id
		$goods_id=I('get.id/d');
		if(IS_POST)
		{
			$gaid=I('post.gaid');
			$gn=I('post.gn');
			//属性值和库存量的比例
			$rate =count($gaid)/count($gn);
			//因为要执行修改操作 所以把原来的先删除掉
			$gnModel->where('goods_id=%d',$goods_id)->delete();
			foreach($gn as $k=>$v)
			{
			//循环一流程 它就清空了，然后在转换，在往里面	塞进
				$_arr=[];
			//现获取商品商品所有属性清单
				for($i=0;$i<$rate;$i++)
				{
			//弹出数组中的第一个
					$_arr[]=array_shift($gaid);
				}
			//向表中添加时候升序排列
				$gnModel->add([
					'goods_id'=>I('get.id/d'),
					'goods_number'=>$v,
					'attr_list'=>implode(',',$_arr),
					]);
			}
				$this->success('操作成功',U('Goods/lst'));
		}
		else
		{
			//取出商品所有的可选属性	
			$gAttr=M('goods_attr');
			$attrData=$gAttr
							->alias('a')
							->field('a.*,b.attr_name,b.attr_type')
							->join('LEFT JOIN  __ATTRIBUTE__  b ON a.attr_id=b.id')
							->where('a.goods_id=%d AND b.attr_type="可选"',I('get.id'))
							->select();
			$aData=[];
			foreach($attrData as $k=>$v)
			{
				$aData[$v['attr_id']][]=$v;
			}
			//将数组转换成能使用递归的有序数组
			$tempData=array_values($aData);
			//取出库存组合
			$storeGrop=$this->storeGrop($tempData);
			//查出商品库存量
			$tempData=$gnModel->where('goods_id=%d',$goods_id)->select();
			//重组数组
			foreach($tempData as $k=>$v)
			{
				$gData[$v['attr_list']]=$v['goods_number'];
			}
			//鹅散到页面
			$this->assign(['aData'=>$aData,'storeGrop'=>$storeGrop,'gData'=>$gData ] );
			$this->display();			
		}
	}
	public function storeGrop($data,$i=0,$parent=[])
	{
		static $temp=[];
		foreach($data[$i] as $k=>$v )
		{	
			if($parent 	&&	$k>0)
				$temp=array_merge( $temp , $parent );//数组合并
			$temp[]=$v['attr_value'].'-'.$v['id'];
			//当前parent值不能改变，所以先复制一份			
			$_p=$parent;
			//把值赋给它		
			$_p[]=$v['attr_value'].'-'.$v['id'];
			//只要检测到数据内还有数据就一直i++
			if(isset($data[$i+1]))	
				$this->storeGrop($data,$i+1,$_p);
		}
		return $temp;
	}


	public function ajaxGetAttr()
	{
		//处理AJAX 的请求
		$tid=I('get.tid');
		//获取这个类型下的属性
		$Model=M('attribute');
		$attr=$Model->where("type_id=%d",$tid)->select();
		//以json格式返回客户端		
		echo json_encode($attr);  //把这个二维数组转化成json  格式
	}
	public function goods_arrt()
	{
		$model=M('goods_attr');
		$gModel=M('goods');
		if(IS_POST)
		{	
			//因为现在的规矩是，预先删除点了减号的属性，现在点了减号的属性都被放在deleteId隐藏框中
			//找出来 删掉它	
			//获取deleteId 隐藏域传上来的id并去掉左右逗号
			$deleteId=trim(I('post.deleteId'),',');	
			if($deleteId)
				$model->delete($deleteId);
			//获取商品id 
			$id=I('get.id');
			//把类型id更新到商品表
			$gModel->where('id=%d',$id)->setField('type_id',I('post.type_id'));
			//把新属性放到商品属性表
			$new_attr=I('post.new_goods_attr');
			if($new_attr)
			{
				foreach($new_attr as $k=>$v)
				{
					foreach($v as $k1=>$v1)
					{
						$model->add([
						'goods_id'=>$id,
						'attr_value'=>$v1,
						'attr_id'=>$k,
							]);
					}
				}				
			}
			//修改原属性
			$oldAttr=I('post.goods_attr');
			if($oldAttr)
			{
				foreach($oldAttr as $k=>$v)
				{
					foreach($v as $k1=>$v1)
					{
						$model->where('id=%d',$k1)->setField('attr_value',$v1);
					}
				}				
			}
		$this->success('操作成功',U('lst'));

		}
		else
		{	
			//取出商品的类型
			$tid=$gModel->field('type_id')->find(I('get.id'));
			$this->assign('tid',$tid['type_id']);
			//判断如果设置了 类型，就取出商品属性的内容
			if($tid['type_id']!=0)
			{
				//取出网站中所有的属性
				$attrModel=M('attribute');
				$formerData=$attrModel->alias('a')
						  ->field('a.*,b.attr_value,b.id as goods_attr_id')
						  ->join('LEFT JOIN __GOODS_ATTR__ b ON (a.id=b.attr_id AND b.goods_id='.I('get.id').')')
						  ->where('a.type_id=%d',$tid['type_id'])
						  ->order('a.id ASC,b.id ASC')
						  ->select(); 				
				$this->assign('formerData',$formerData);
			}
/*
			//取出这个商品的属性并联属性表把属性名称取出来
			$formerData=$model
					->alias('a')
					->field('a.*,b.attr_name,b.attr_type,attr_values')
					->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id')
					->where('a.goods_id=%d',I('get.id'))
					->select();*/

			//显示表单 		
			$this->display();
		}
	}
	public function add()
	{
		if(IS_POST)  // 处理表单
		{
			// 创建模型
			$model = D('Goods');
			// 1. 接收表单中的数据并保存到模型
			// 2. 并且根据表单中定义的规则验证数据，如果验证失败把错误信息保存到模型中并返回false
			if($model->create())
			{
				/******************* 上传图片 ***********************/
				$upload = new \Think\Upload();        // 实例化上传类
			    $upload->maxSize = 2 * 1024 * 1024 ;   // 设置附件上传大小
			    $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
			    $upload->rootPath = './Public/Uploads/'; // 保存图片的顶级目录【手动创建好】
			    $upload->savePath = 'Goods/'; // 保存图片的二级目录【自动生成】
			    // 开始上传，如果上传失败返回false，如果成功返回上传之后图片的信息
			    $info = $upload->upload();
			    // 如果上传成功了

			    if($info)
			    {
			    	
			    	// 生成处理图像的类
			    	$image = new \Think\Image(); 
			    	// 打开要处理的图片
			    	$image->open('./Public/Uploads/'.$info['logo']['savepath'].$info['logo']['savename']);
			    	// 生成缩略图  -->  从大到小生成
			    	$image->thumb(350, 350)->save('./Public/Uploads/'.$info['logo']['savepath'].'big_'.$info['logo']['savename']);
			    	$image->thumb(130, 130)->save('./Public/Uploads/'.$info['logo']['savepath'].'mid_'.$info['logo']['savename']);
			    	$image->thumb(50, 50)->save('./Public/Uploads/'.$info['logo']['savepath'].'sm_'.$info['logo']['savename']);
			    	/********** 把图片的二级路径设置到模型上，然后后面调用add时就插入到表中相应的字段上了 ***********/
			    	$model->logo = $info['logo']['savepath'].$info['logo']['savename'];
			    	$model->sm_logo = $info['logo']['savepath'].'sm_'.$info['logo']['savename'];
			    	$model->mid_logo = $info['logo']['savepath'].'mid_'.$info['logo']['savename'];
			    	$model->big_logo = $info['logo']['savepath'].'big_'.$info['logo']['savename'];
			    }
			    // 用这个函数过滤的数据覆盖掉TP中原来已经过滤的数据
			    $model->goods_desc = removeXSS($_POST['goods_desc']);
				// 把接收到的数据插入到商品表，返回新插入的记录的ID
				$model->add();
				// 提示信息并在1秒之后跳到当前控制器中的lst方法
				$this->success('添加成功！', U('lst'));
			}
			else
			{
				// 从模型中获取失败的信息
				$error = $model->getError();
				// 显示错误信息并在3秒之后返回上一个页面
				$this->error($error);
			}
		}
		else
		{
			/**商品分类*********/
			$model=D('Category');
			$Cdata=$model->show();
			$brand=M('brand');
			$goods_brand=$brand->select();
			$this->assign(['data'=>$Cdata,'brand'=>$goods_brand]);
			//显示表单
			$this->display();
		}
	}
	//列表页
	public function lst()
	{

		$where=[];
		$cat_id=(int)I('get.cat_id',0);
		$brand_id=I('get.brand_id/d');
		if(isset($cat_id)) 
		{	
			$Cmodel=D('Category');
			$son=$Cmodel->subclass($cat_id,true);					
			$where['cat_id']=['in',$son];
			if($brand_id>0)
			{
				$where['goods_brand']=$brand_id;
			}
		}

		$User = D('Goods'); 
		/********取数据*************/
		// 实例化User对象 
		$count = $User->where($where)->count();
		// 查询满足要求的总记录数
		/********翻页制作*************/
	    $Page = new \Think\Page($count,5);
		// 实例化分页类 传入总记录数和每页显示的记录数(25)
		/***************  翻页替换箭头*****************/
	    $Page->setConfig('prev','上一页');	
	    $Page->setConfig('next','下一页');	
	    $Page->setConfig('first','下一页');	
	    $Page->setConfig('end','最后一页');	
	    $Page->setConfig('current','当前页');	
		$show = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $User->alias('a')
						->field('a.*,b.logo,b.site')
						->join('__BRAND__ b ON a.goods_brand=b.id')   	//因为没有goods_brand 这个字段  所以 搜索的时候就把它搜索不出来
						->where($where)									//$_FILES与$GLOBALS  提交上来的文件都显示为空  如何处理
						->order('addtime desc')
						->limit($Page->firstRow.','.$Page->listRows)
						->select();						
		$catModel=D('Category');
		$catData=$catModel->show();
		foreach($list as $k=>$v)
		{				
			$Fdata=$catModel->father($v['cat_id']);
			$fData[]=$Fdata;				
		}
		foreach($fData as $v)
		{				
			$c=implode('->',$v);
			$b[]=$c;
		}

		$len=count($list);

		for($i=0;$i<$len;$i++)
		{
			$list2[]=array_merge($list[$i],['cat_name'=>$b[$i]]);
		
		}
		$goods_num=M('goods_number');
		$sum=$goods_num
					->field('sum(goods_number) as num ,goods_id ')
					->group('goods_id')
					 ->select();	
		foreach($list2 as $k=>$v)
		{
			foreach($sum as $k1=>$v1)
			{
				if($v['id']==$v1['goods_id'])
				{
					$list2[$k]['number']=$v1['num'];
				}
			}
		}

		// 赋值数据集 
		$this->assign(['page'=>$show,'list'=>$list2,'catData'=>$catData,'fData'=>$fData]);
		
		$this->display();


	}

	public function delete()
	{
		//实例化 商品模型表
		$model=D('Goods');		
		$model->where()->adv_delete( (int)I('get.id',0) );// 第二个参数，如果没有这个参数就返回默认值：I(‘get.id’, 0)   => isset($_GET[‘id’]) ? $_GET[‘id’] : 0;

		$this->success('删除成功',U('lst'));

	}
	public function edit()
	{
		//实例化 商品模型表
		$id=(int)I('get.id',0);	
		$model=D('Goods');
		if (IS_POST)
		{
			if ($model->create()) 
			{
				
				/**********上传图片********/
				$upload=new \Think\Upload();//实例化上传类，找找简写
				$upload->maxSize=2*1024*1024;//设置文件大小
				$upload->exts=array('jpg','gif','png','jpeg');//设置附件上传类型
				$upload->rootPath='./Public/Uploads/';//保存图片的顶级目录【手动创建好】
				$upload->savePath='Goods/';//保存图片的二级目录【自动生成】
				//开始上传，如果上传失败 返回false，如果成功返回上传之后图片的信息
				$info=$upload->upload();
				//如果上传成功了				
				if($info)
				{	
					//生成处理图像的类
					$image=new \Think\Image();
					//打开要处理的图片
					$c=$image->open('./Public/Uploads/'.$info['logo']['savepath'].$info['logo']['savename']);


					//生成缩略图->从大到小生成
					$image->thumb(350,350)->save('./Public/Uploads/'.$info['logo']['savepath'].'big_'.$info['logo']['savename']);
					$image->thumb(130,130)->save('./Public/Uploads/'.$info['logo']['savepath'].'mid_'.$info['logo']['savename']);
					$image->thumb(50,50)  ->save('./Public/Uploads/'.$info['logo']['savepath'].'sm_'.$info['logo']['savename']);
					//把图片的二级目录设置到模型上，然后调用ADD时就插入到表中相应的字段中
					$model->logo=$info['logo']['savepath'].$info['logo']['savename'];
					$model->sm_logo=$info['logo']['savepath'].'sm_'.$info['logo']['savename'];
					$model->mid_logo=$info['logo']['savepath'].'mid_'.$info['logo']['savename'];
					$model->big_logo=$info['logo']['savepath'].'big_'.$info['logo']['savename'];

					/************删除原图***********/
					@unlink(IMG_PATH.I('post.ologo',0));
					@unlink(IMG_PATH.I('post.osm_logo',0));
					@unlink(IMG_PATH.I('post.omid_logo',0));
					@unlink(IMG_PATH.I('post.obig_ologo',0));			
				}
				//用原始的数据把新数据过滤掉
				$model->goods_desc=removeXSS($_POST['goods_desc']);
				$model->save();
				$this->success('修改成功',U('lst'));
			}
			else
			{
				$this->error($model->getError()); 
			}	
		}
		else
		{

		$catModel=D('Category');
		$catData=$catModel->show();
		$data=$model->find($id);
		$brand=M('brand');
		$goods_brand=$brand->select();
		$this->assign(['data'=>$data,'catData'=>$catData,'brand'=>$goods_brand]);
		$this->display();				
		}
	}
	public function goods_pic()
	{	
		$model=D('goods_pic');//实例化商品
		if(IS_POST)
		{				
		  	$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize   =     3145728 ;// 设置附件上传大小
		    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->rootPath  =     IMG_PATH; // 设置附件上传根目录
		    $upload->savePath  =     'Goods_pic/'; // 设置附件上传（子）目录
		    // 上传文件 
		    $info   =   $upload->upload();

		    if($info===FALSE)
		    	$this->error('必须要选择图片');
		    else 
		    {				    	
		    	//生成处理图像的类
				$image=new \Think\Image();
				//打开要处理的图片
				//因为传过来但是数组 所以循环整出缩略图
				foreach($info as $k=>$v):
					//先定义相册变量
					$photo   =$v['savepath'].$v['savename'];
					$sm_photo=$v['savepath'].'sm_'.$v['savename'];
					$mid_photo=$v['savepath'].'mid_'.$v['savename'];
					$big_photo=$v['savepath'].'big_'.$v['savename'];
					//打开原图
					$image->open(IMG_PATH.$photo);
					//生成缩略图->从大到小生成
					$rs1=$image->thumb(350,350)->save(IMG_PATH.$big_photo);
					$rs2=$image->thumb(130,130)->save(IMG_PATH.$mid_photo);
					$rs3=$image->thumb(50,50)  ->save(IMG_PATH.$sm_photo);
					//把图片的二级目录设置到模型上，然后调用ADD时就插入到表中相应的字段中					
					//把接收到的数据插入商品表中，返回新插入的id
					//如果磁盘空间满了 就不执行上传操作了
					if ($rs1 && $rs2 &&$rs3)
					{
						$model->add([
							'photo'=>$photo,
							'sm_photo'=>$sm_photo,
							'mid_photo'=>$mid_photo,
							'big_photo'=>$big_photo,
							'goods_id'=>I('get.id'),
							]);
					}
					else
					{	//如果磁盘空间满了 就不执行上传操作了
						@unlink(IMG_PATH.$photo);
						@unlink(IMG_PATH.$big_photo);
						@unlink(IMG_PATH.$mid_photo);
						@unlink(IMG_PATH.$sm_photo);
						continue;
					}
				endforeach;
				//提示信息并在1秒内跳到当前控制器中lst方法
				$this->success('添加成功',U('lst'));
			}	       		
		 
		}
		else
		{	
			$id=I('get.id');
			$picData=$model->where("goods_id=%s",$id)->select();
			$this->assign(['picData'=>$picData]);
			$this->display('pic');				
		}										
	}
	public function ajaxImg()
	{
		//实例化 商品相册表
		$id=(int)I('get.id',0);
		$model=D('goods_pic');	
		$deleteData=$model->find($id);
		@unlink(IMG_PATH.$deleteData['photo']);
		@unlink(IMG_PATH.$deleteData['sm_photo']);
		@unlink(IMG_PATH.$deleteData['mid_photo']);
		@unlink(IMG_PATH.$deleteData['big_photo']);
		$model->delete($id);
	}
	public function member_price()
	{
		$pModel=D('member_price');
		if(IS_POST)			
		{	
			$goodsId=(int)I('get.id');
			$price=I('post.price');
				$pModel->where([
					'goods_id'=>$goodsId,
					])->delete();

			foreach($price as $k=>$info)
			{
				$_v=(float)$info;
				$pModel->add([
					'goods_id'=>$goodsId,
					'price'=>$_v,
					'level_id'=>$k,
					]);
			}
			$this->success('添加成功',U('lst'));
		}
		else
		{
			$price=$pModel->where('goods_id=%s',(int)I('get.id'))->select();
			$mModel=D('MemberLevel');
			$level=$mModel->select();
			$this->assign(['level'=>$level,'price'=>$price]);
			$this->display();
		}
	}
}