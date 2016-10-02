<?php
namespace Admin\Controller;
use Think\Controller;
use Exception;
class LoginController extends  Controller
{
		// 生成验证码图片
	public function captcha()
	{
		$config = array( 'fontSize' => 30,  'length' => 5	, 'useNoise' => true,); 
		$Verify = new \Think\Verify($config);
		 $Verify->entry();
	}
	
	public function Login()
	{
		if (IS_POST)
		{
			//把咱的模型实例化new 一下
			$model = D('Admin');
			//使用 create 的动态验证方法 指定验证规则
			if ($model->validate($model->login_validate)->create()) 
			{
				try
				{
					$model->login();					
					$this->success('登录成功！', U('Index/index'));
				}
				catch(Exception $e)
				{
					$this->error($e->getMessage());
				}
			}
			else
			{
				  // 获取失败原因
				$error = $model->getError();
				$this->error($error);
			}
		}

		else
		{
			$this->display();
		}
	}
}