<?php
namespace Admin\Model;
use Think\Model;
class MemberLevelModel extends Model{
	//表单验证规则
protected $_validate=[
	['m_name','require','会员名称不能为空',1],
	['m_name','','会员名称不能重复',1,'unique'],
	['jf_sx','number','积分上限必须为数字',1],
	['jf_xx','number','积分下限必须为数字',1],
	['jf_xx','jfgz','积分下限不能大于上限',1,'callback'],
	];

	public  function jfgz()
	{
		return I('post.jf_xx')<=I('post.jf_sx');
	}
}