<?php
namespace Front\Model;
use Think\Model;
class remarkModel extends Model{
protected $_validate=[

		['content','6,300','内容要在6-300',1,'length'],
		['star','/^[1-5]$/','你肯定在开外挂,对不',1],
		['goods_id','/^\d+$/','你肯定在开外挂',1],
		['captcha', 'require', '验证码不能为空!',1],
		// 这个字段用这个类中的check_verify方法来验证
		['captcha', 'check_verify', '验证码不正确!', 1, 'callback'],				
				];
	/**********验证码 验证规则***************/
	function check_verify($code, $id = ''){
	    $verify = new \Think\Verify();
	    return $verify->check($code, $id);
	}

public 	$tree_validate=[
		['content','6,300','内容要在6-300',1,'length'],
		['star','/^[1-5]$/','你肯定在开外挂,对不',1],
		['goods_id','/^\d+$/','你肯定在开外挂',1],			
		];
} 