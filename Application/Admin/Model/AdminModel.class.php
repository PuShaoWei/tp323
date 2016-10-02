<?php
namespace Admin\Model;
use Think\Model;
use Exception;
class AdminModel extends Model
{
/*********表单验证规则********/
	protected $_validate=[

			['name','require','管理员名称不能为空',1],
			['name','','管理员名称已存在',1,'unique'],
			['account','require','管理员账户不能为空',1],
			['account','','管理员账户已存在',1,'unique'],
			//定义密码只是在创建的时候生效
			['password','require','密码不能为空',1,'regex','1'],
			['cpassword','password','两次密码不一致',1,'confirm'],			
			['r_id','chkPriId','管理员所在角色不能为空',1,'callback'],  //callback 使用一个回调函数来验证
	];

	//登录的时候验证这个
	public $login_validate = [
		['account', 'require', '账号不能为空！',1],
		['password', 'require', '密码不能为空!',1],
		['captcha', 'require', '验证码不能为空!',1],
		// 这个字段用这个类中的check_verify方法来验证
		['captcha', 'check_verify', '验证码不正确!', 1, 'callback'],
	];
	
	/**********验证码 验证规则***************/
	function check_verify($code, $id = ''){
	    $verify = new \Think\Verify();
	    return $verify->check($code, $id);
	}

	//判断pri_id 字段是否不为空
	public function chkPriId($priId)  //这里传值 是自动把当前的数组传进来的
	{
		return !empty($priId);
	}
	public function login()
	{
		// 获取用户提交的用户名和密码
		// 获取用户提交的用户名和密码
		/**
		I('get.title');  ==>   htmlspecialchars($_GET['title']);
		**/
		$account=I('post.account');//类似于htmlspecialchars($_POST['account']);
		$password=I('post.password');
		/***********查询数据************/
		/**********用find（）查询，只返回一条记录***limit 1*/
		$user=$this->where([
			'account'=>$account,
			])->find();
	
		//查完之后判断有没有查到
		
		if($user)
		{
			if($user['password']==md5($password.C('MD5_SALT'))) 
			{
				$_SESSION['id']=$user['id'];
				$_SESSION['account']=$user['account'];
				$_SESSION['name']=$user['name'];
			}
			else
			{
			 throw new Exception("密码不正确", 1);
			}

		}
		else
		{
			throw new Exception("没这账号", 1);
			
		}
	}
	public function adv_add()
	{
		//密码进行MD5加密  ,因为create 方法接收表单的时候会把表单中的数据保存到模型里
		$this->password=md5($this->password.C('MD5_SALT'));
		$adminId=$this->add();
		//把表单中勾选的角色保存到另一个表
		$arModel=D('admin_role');
		$rid=I('post.r_id');
	
		foreach($rid as $v)
		{
			$arModel->add([
				'admin_id'=>$adminId,
				'role_id' =>$v,
				]);
		}
	}
	public function search()
	{

		/****************搜索***********************/
		$where=[];//空数组
		$rn=I('get.rn');//接收rn参数
		if($rn)
		{
			$where['name']=['LIKE',"%$rn%"];
		}
		/********************排序*********************/
		$orderby='id';			//根据字段默认排序	
		$orderway='asc';		//默认降序
		/*******************翻页**********************/
	
		$count = $this->where($where)->count();
	    $Page = new \Think\Page($count,5);
	    //把箭头替换掉
	    $Page->setConfig('prev','上一页');	
	    $Page->setConfig('next','下一页');	
	    $Page->setConfig('first','下一页');	
	    $Page->setConfig('end','最后一页');	
	    $Page->setConfig('current','当前页');	
	    //生成翻页字符串
		$show = $Page->show();
		//取数据

$pageData=$this->where()
			->alias('a')			
			->field('a.*,GROUP_CONCAT(c.role_name SEPARATOR "<----->") as pri_name')
			->join('LEFT JOIN tzl_admin_role b ON a.id=b.admin_id  LEFT JOIN tzl_role c ON b.role_id=c.id')
			->where($where)
			->group('a.id')	
			->order("$orderby $orderway")
			->limit($Page->firstRow.','.$Page->listRows)
			->select();
/*		return var_dump($this->getLastSql());//获取我上一次SQL语句到底输入的是啥  切记 切记啊	*/

		/****************f返回数据************/

		return [
			'data'=>$pageData,	
			'page'=>$show,
		];
	}

	function adv_delete($adminId)
	{
		//删除角色管理员表中的内容
		$this->delete($adminId);
		//删除中间表（用于存这个管理员有哪些角色）的值
		//实例化中间表
		$stagingTable=D('admin_role');
		//Tp框架写WHERE 推荐我们使用一个数组在外定义一个数组
		//相当于 role_id=$roleId   ThinkPHP 当中eq代表等于的意思
		$where=['admin_id'=>['eq',$adminId]] ;
		$stagingTable->where($where)->delete();

	}
	function adv_edit($getId)
	{
		//取出管理员角色
		$admData=$this->find("$getId");
		//取出管理员拥有哪些权限
		$admRole=D('admin_role');
		//设计where条件
		
		$where=['admin_id'=>['eq',$getId]];
		$roleData=$admRole
					->field('GROUP_CONCAT(role_id) as pir_id')
					->where($where)
					->find();

		return [

		'adm'=>$admData, 
		'roleData'=>$roleData,

		];
	}

	public function adv_save()
	{
		if($this->password=='')
		{
			unset($this->password); 
			//把这个字段从模型中取出来，
			//因为create 方法会把密码和账号保存到模型内
			//删除了就不会更改表单中这个字段了
		}
		else
		{
		/************先更新 role 表的名称***********/
		$this->password=md5($this->password.C('MD5_SALT'));			
		}
		$this->save();
		/***********更新中间表信息*****************/
		$pri=D('admin_role');
		//获取post 隐藏域过来的角色ID
		$getId=(int)I('post.id',0);
		//先删除原来拥有的权限
		$where=['admin_id'=>['eq',$getId]];
		$pri->where($where)->delete();	
		//接收表单中勾选的ID
		$admId=I('post.r_id',0);
		//把新添加的权限添加到角色权限表		
		foreach($admId as $v )
		{
			$pri->add([
			'admin_id'=>$getId,//新添加的角色ID
			'role_id'=>$v,
				]);
		}
	}


/******************登录规则验证*************************/
	public function myPrivilege()
	{
		$arModel=D('admin_role');
		$priData=$arModel->alias('a')
						 ->field('DISTINCT a.admin_id,c.c_name,c.m_name,c.a_name')
						 ->join('LEFT JOIN  __ROLE_PRI__ b ON a.role_id=b.role_id LEFT JOIN __PRIVILEGE__ c ON  b.pri_id=c.id ')
						 ->where(['admin_id'=>$_SESSION['id'],'c_name'=>['neq',''],'id'=>['EXP','is not null '] ]) //c_name 不为空 就是商品管理哪些东西 顶级权限不显示出来
						 ->select();
		return $priData;				 
	}

/****************按钮操作************************/
public function getMenu()
{
	//先取出管理员所有拥有的权限
	$arModel=D('admin_role');
	if ($_SESSION['id']==1)
	 {
		$priModel=D('Privilege');
		$all=$priModel->order('sort_num ASC')->select();
	}
	else
	{

	$all=$arModel->alias('a')
				 ->field('DISTINCT c.*')
				 ->join('LEFT JOIN  __ROLE_PRI__ b ON a.role_id=b.role_id LEFT JOIN __PRIVILEGE__ c ON  b.pri_id=c.id ')			 
				 ->where(['admin_id'=>$_SESSION['id'],'id'=>['EXP','is not null '] ]) //c_name 不为空 就是商品管理哪些东西 顶级权限不显示出来
				 ->order('c.sort_num ASC')
				 ->select();
	}	


	//挑出前两级权限
	$menus=[];

	foreach($all as $v)
	{
		if ($v['parent_id']== 0 )
		{
			//再找这个顶级权限的二级权限
			foreach($all as $v1 )
			{
				if ($v1['parent_id']==$v['id'])
				{
					//把二级权限放到这个数组内
					$v['child'][]=$v1;					
				}							
			}		
		$menus[]=$v;		
		}

	}

	return $menus;

}

}