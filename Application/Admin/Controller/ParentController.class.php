<?php
namespace Admin\Controller;
use Think\Controller;
class ParentController extends Controller
{

	public function __construct()
	{

		//先问问它爷爷有什么话说
		parent::__construct();

		if(!isset($_SESSION['id']) )
		{
			$this->error('请先登录哦\(^o^)/~',U('Login/login'));		
		}
		/************判断管理员有哪些权限*************/
		header('content-type:text/html;charset=utf-8');
		$admPrivilege=D('Admin');	
		$priData=$admPrivilege->myPrivilege();
		/************循环数组************************/

		foreach($priData as $v)
		{

			if ($v['admin_id']==1)
			{			
				return;	
			}	
			else if($v['m_name']==MODULE_NAME && $v['c_name']==CONTROLLER_NAME &&$v['a_name']==ACTION_NAME)
			{
				$ok = 1 ;
				break;
			}
			
		}

		//如果符合	
	if (!isset($ok))
		
		{
			$this->error('无权访问'/*,U('Login/login')*/);	
		}



	}	



}