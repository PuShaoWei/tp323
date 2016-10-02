<?php
namespace Admin\Model;
use Think\Model;
use Exception;
class MemberModel extends Model
{
	//表单验证规则
	protected $_validate=[
	['account','require','用户名不能为空',1],
	['account','','用户名已存在',1,'unique'],
	['password','require','密码不能为空',1,'regex','1'],
	['cpassword','password','两次密码不一致',1,'confirm'],
	['captcha', 'check_verify', '验证码不正确!', 1, 'callback'],
	];
	//登录表单验证规则
	public $_login_validate=[
	['account','require','用户名不能为空',1],
	['password','require','密码不能为空',1,'regex','1'],
	['captcha', 'check_verify', '验证码不正确!', 1, 'callback'],
	];
	/**********验证码 验证规则***************/
	public function check_verify($code, $id = ''){
	    $verify = new \Think\Verify();
	    return $verify->check($code, $id);
	}
	public function login()
	{
		$username=$this->account;
		$password=$this->password;
		$user=$this->where([
			'account'=>$username,
		])->find();
		if($user)
		{
			if($user['password']==md5($password.C('MD5_SALT')))
			{
				$_SESSION['front']['id']=$user['id'];
				$_SESSION['front']['account']=$user['account'];

				/******************计算级别id**************/
				$mModel=M('member_level');
				$jyz=$mModel->field('id')->where([
					'jf_xx'=>['elt',$user['jyz']],
					'jf_sx'=>['egt',$user['jyz']],
					])->find();
				$_SESSION['front']['level_id']=$jyz['id'];
			}
			else
				throw new Exception('密码错误');
		}
		else
			throw new Exception('账号不存在');
	}
	
	public function log_out()
	{
		unset($_SESSION['front']);
	}

}