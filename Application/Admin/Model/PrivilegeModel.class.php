<?php
namespace Admin\Model;
use Think\Model;
class PrivilegeModel extends Model
{
/*********表单验证规则********/
protected $_validate=[
	['pri_name','require','权限名称不能为空',1],
	['pri_name','','权限名称已存在',1,'unique'],

];

	public function show()
		
	{

		$data=$this->select();
		$data=$this->short($data);
		return $data; 
	}

	private function short($data,$top=0,$buff=0)
	{

		header('content-type:text/html;charset=utf-8');
	
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
	/******************找子分类的递归*****************/
	public function son($getF)
	{
		$son=$this->select();	
		$ret=$this->_subclass($son,$getF);	
		return $ret;
	}
	/*****************找子分类 并包括本id的递归**********/
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
/***********找父分类的递归***************/
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

}