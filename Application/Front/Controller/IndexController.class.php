<?php
namespace Front\Controller;
use Think\Controller;
use Exception;	
class IndexController extends Controller
{

	
	public  function  index()
	{
		//取出前三级的分类
		$catModel=D('Admin/Category');
		//取出疯狂抢购的商品
		$goodsModel=D('Admin/Goods');
		$goods1=$goodsModel->getPromoteGoods();
		$goods2=$goodsModel->getRecGoods('hot');
		$goods3=$goodsModel->getRecGoods('new');
		$goods4=$goodsModel->getRecGoods('rec');
		//将分类取出
		$getNavData=$catModel->getNavData();
		//取出楼层数据
		$floor=$catModel->getFloorData();
		//鹅散到页面
		$this->assign([
			'Category'=>$getNavData,
			'floor'=>$floor,
			'goods1'=>$goods1,
			'goods2'=>$goods2,
			'goods3'=>$goods3,
			'goods4'=>$goods4,
			]);
		$this->display();
	}
	public function goods()
	{
		
		$goods_id=I('get.id/d');
		$goods=D('Admin/Goods');
		$gData=$goods->find($goods_id);
		$photo=M('goods_pic');
		$pData=$photo->where(['goods_id'=> $goods_id])->select();
		//获取分类
		$attr=$goods->getAttr($goods_id);
		//获取商品价格
		$price=$goods->memberPrice($goods_id);				
		$this->assign([
					'price'=>$price,
					'goods'=>$gData,
					'photo'=>$pData,
					'attr'=>$attr,
					'Category'=>$this->_cat,
			]);
		if(!isset($_SESSION['front']['id']))
			setcookie('returnUrl',U('goods?id='.$goods_id),time()+30*86400,'/');
		$this->display();
	}
			
	public function AJAXaction()
	{
		date_default_timezone_set('RPC');
		$model=D('remark');
		//印象表
		$yxModel=M('impression');
		//图片表
		$picModel=M('remarkPic');

		$ip=$_SESSION['ip'];
		$_SESSION['ip']+=I('post.ip/d');
		$time=$_SESSION['time'];
		if($time==null)
			$time=time()+100;
		else
			$timeBad=time()-$time;
		
		if($timeBad>120)
		{
			unset($_SESSION['ip']);
			unset($_SESSION['time']);
			$ip=0;
		}
/********************************************************************/
		//处理印象
		$yx=I('post.yx');
		if($yx)
		{
			//替换所有逗号
			$yx=str_replace('，',',',$yx);
			$yx=explode(',',$yx);
			foreach($yx as $v)
			{
				$count=	$yxModel->where([
					'goods_id'=>I('post.goods_id'),
					'imp_name'=>$v,
						])->count();
					if($count>0)
					{
						$yxModel->where([
						'goods_id'=>I('post.goods_id'),
						'imp_name'=>$v,   
							])->setInc('imp_count',1);			
					}
					else
					{
						$yxModel->add([
						'goods_id'=>I('post.goods_id'),
						'imp_name'=>$v,
						'imp_count'=>1,
							]);
					}	
			}
		}
		//处理图片
		$img=I('post.pic','');
		$imgPath='';
/*********************************************************************************/
		if($ip > 3)
		{	
			$_SESSION['time']=time();
			if($model->create())
			{	
				$model->member_id=$_SESSION['front']['id'];
				//插入评论
				$remarkId=$model->add();
				if($img)
				{
					foreach($img as $v)
					{
						$picModel->add([
						 'remark_id'=>	$remarkId,
						 'pic'=>$v,
						 'sm_pic'=>$v,
							]);
						$imgPath.="<dl><img src='$v'></dl>";
					}			 			
				}
				echo json_encode([
					'ok'=>2,
					'addtime'=>date('Y-m-d H:i:s',strtotime('-1days')),
					'star'=>I('post.star'),'zan_num'=>I('post.zan_num',0),
					'name'=>$_SESSION['front']['account'],
					'content'=>I('post.content'),
					'img'=>$imgPath,
					]);	
			}
			else 
				echo json_encode(['catch'=>1,'error'=>$model->getError()]);
		}
		else if($model->validate($model->tree_validate)->create())
		{
			$model->member_id=$_SESSION['front']['id'];
			//插入评论
			$remarkId=$model->add();
			if($img)
			{
				foreach($img as $v)
				{
					$picModel->add([
					 'remark_id'=>	$remarkId,
					 'pic'=>$v,
					 'sm_pic'=>$v,		 							
						]);
					$imgPath.="<dl><img src='$v'></dl>";
				}			 			
			}

			echo json_encode([
				'ok'=>1,
				'addtime'=>date('Y-m-d H:i:s',strtotime('-1days')),
				'star'=>I('post.star'),'zan_num'=>I('post.zan_num',0),
				'name'=>$_SESSION['front']['account'],
				'content'=>I('post.content'),
				'img'=>$imgPath,
				 ]);	
		}
		else
			echo json_encode(['ok'=>0,'error'=>$model->getError()]);

	}
	public function get_reark()
	{
		$model=M('remark');
		$page=I('get.page');
		$goodsId=I('get.id/d');
		$perPage=5;
		$offset=(($page-1)*$perPage);
		//总的记录数
		$count=$model->count('id');
		//每页页数
		$pageCount=ceil($count/$perPage);	
		//总的数据
		$data=$model->alias('a')
		->field('a.zan_num,a.member_id,a.star,a.addtime,a.content,group_concat(b.pic) as  pic,b.remark_id,c.account')
		->join('LEFT JOIN __REMARK_PIC__ b ON a.id=b.remark_id')
		->join('LEFT JOIN __MEMBER__ c ON a.member_id=c.id')
		->where([
			'goods_id'=>$goodsId,
				])
			->limit($offset.','.$perPage)
			->order('a.addtime DESC')
			->group('a.id')
			->select();

		//取出映像以及好评率
		if($page==1)
		{
			$imModel=M('impression');
			$iData=$imModel->where(['goods_id'=>$goodsId])->select();
			//好评数
			$hao=$model->where([
				'goods_id'=>$goodsId,
				'star'=>['gt',3],
				])->count('id');
			//差评数
			$zhong=$model->where([
				'goods_id'=>$goodsId,
				'star'=>['eq',2],
				])->count('id');
			//差评
			$cha=$count-$hao-$zhong;

			//比例
			$hao=round($hao/$count*100,2);
			$zhong=round($zhong/$count*100,2);
			$cha=round($cha/$count*100,2);
		}

			echo json_encode(['Rdata'=>$data,'pageCount'=>$pageCount,'Idata'=>$iData,'hao'=>$hao,'zhong'=>$zhong,'cha'=>$cha,]);

	}
	public function getPrice()	
	{	
		$goods_id=$_GET['id'];
		//实例化商品模型
		$goods=D('Admin/Goods');
		//获取商品价格
		$price=$goods->memberPrice($goods_id);

			echo json_encode([
				'ok'=>1,
				'presentPrice'=>$price,
		]);

	}
	public function cart()
	{
		$this->display();
	}
	public function login()
	{
		$mModel=D('Admin/Member');
		if(IS_POST)
		{			//更换验证规则
			if($mModel->validate($mModel->_login_validate)->create())
			{
				try
				{
					$mModel->login();			
					//不提示信息直接跳转
					if(isset($_COOKIE['returnUrl']))
					{
						
						$url=$_COOKIE['returnUrl'];
						// 清空cookie
						setcookie('returnUrl', '', time()-1, '/');
						redirect($url);
					}
					else
					{
						redirect(U('index'));//不提示信息登录成功自己跳转							
					}					

				}
				catch(Exception $e)
				{
					$this->error($e->getMessage());
				}
			}
			else
			{
				$error=$mModel->getError();
				$this->error($error);
			}
		}
		else
		{
			$this->display();			
		}
	}	
	public function regist()
	{
		$mModel=D('Admin/Member');
		if(IS_POST)
		{
			if($mModel->create())
			{
				$mModel->password=md5($mModel->password.C('MD5_SALT'));
				$mModel->add();
				$this->success('注册成功',U('login'));
			}
			else
			{
				$error=$mModel->getError();
				$this->error($error);
			}
		}
		else
		{
			$this->display();			
		}
	}
	public function captcha()
	{
		$config = array( 'fontSize' => 30,  'length' => 5	, 'useNoise' => true,); 
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}
	public function log_out()
	{
		$mModel=D('Admin/Member');
		$mModel->log_out();
		redirect( U('index') );//不提示信息登录成功自己跳转	
	}
		
	public function chkLogin()
	{//判断用户有没有被登录
		if(isset($_SESSION['front']['account']))
		{//告诉客户端 当前用户名 返回
			echo json_encode([
				'ok'=>1,
				'account'=>$_SESSION['front']['account'],
				]);
		}
	}

	public function AJAXcategory()
	{
		//获取商品当前所属分类
		$goods_id=I('get.id/d');
		$Category=D('Admin/category');
		$cData=$Category->getParentCategory($goods_id);

		echo json_encode([
			'ok'=>1,
			'category'=>$cData,
			]);

	}
	public function AJAXCid()
	{
		//获取商品当前所属分类
		$c_id=I('get.cid/d');
		$Category=D('Admin/category');	
		$cData=$Category->getCategorySear($c_id);
		echo json_encode([
			'ok'=>1,
			'category'=>$cData,
			]);

	}
	public function AJAXImg()
	{
	    $upload = new \Think\Upload();// 实例化上传类
	    $upload->maxSize   =     1024*1024 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Public/Uploads'; // 设置附件上传根目录
	    $upload->savePath  =     './Remark/'; // 设置附件上传（子）目录
	    // 上传文件 
	    $info   =   $upload->upload();
	    $temp='/Public/Uploads/';
	    $file = $temp.trim($info['ajaxImg']['savepath'].$info['ajaxImg']['savename'],'./');

	    echo "<script>parent.document.getElementById('img-AJAX').innerHTML+='<img src=\"$file\">;<input type=\"hidden\" value=\"$file\" name=\"pic[]\">'</script>";
	}
	public function cartDispose()
	{
		if(IS_POST)
		{
			$cart=D('Cart');
			if($cart->create())
			{
				try
				{
					$cart->addToCart();
				}
				catch(\Exception $e)
				{
					$this->error($e->getMessage);
				}
				//重定向
				$goodsId=I('post.goods_id/d');	
				redirect(U('cartList?id='.$goodsId));
			}
			else
				$this->error($cart->getError);
		}
	}

	public function cartList()
	{
		$model=D('Cart');
		$cartData=$model->cartList();
		$this->assign('cartData',$cartData);
		$this->display();

	}
/****************************************************************************************/	
	public function orderInfo()
	{
		if(!isset($_SESSION['front']['id']))
		{
			setcookie('returnUrl',U('orderInfo'),time()+30*86400,'/');
			$this->error('必须先登录才能买东西哈',U('Login'));
		}
		else if(IS_POST)
		{
			$model=D('Admin/orderinfo');
			if($model->create())
			{ 
				try{
					$orderId=$model->adv_add();
					$this->success('下单成功',U('pay?id='.$orderId));
					}
				catch(Exception $e)
				{
					$this->error($e->getMessage());
				}
			}
			else
				$this->error($model->getError());
		}	
		else
		{			
			$model=D('Cart');
			$cartData=$model->cartList();
			$this->assign('cartData',$cartData);
			$this->display();			
		}

	}
/*************************************************************************************/	
	public function pay()
	{
		$orderId=I('get.id/d'); 
		var_dump($orderId);
	}
/************************************************************************************/	
	public function search()
	{

		$model=D('Admin/Category');

		$price=$model->searchInfo();

		var_dump($price);

		$this->assign(['price'=>$price,]);
		$this->display();

	}	

 }