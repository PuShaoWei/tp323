<?php
namespace Admin\Controller;

class AdminController extends  ParentController 
{
	public function lst()
	{
		//实例化角色表
		$model=D('Admin');
		$data=$model->search();

		$this->assign([ 'data'=>$data['data'],
						'page'=>$data['page'] ]);
		$this->display();
	}
	
	public function add()
	{
		if (IS_POST)
		{		
			$rm=D('Admin');
			if($rm->create())
			{
				$rm->adv_add();
				$this->success('添加成功',U('lst'));				
			}
			else
			{

				$this->error($rm->getError());
			}
		}
		else
		{
			
			$role=D('Role');
	    $roleData=$role->select();
			$this->assign('Role',$roleData);
			$this->display();
		}

	}	
	public function delete()
	{
		//实例化模型
		$model=D('Admin');
		//接收get值
		$getId=(int)I('get.id',0);
		//禁止删除 超级管理员
		if($getId==1)
			$this->error('超级管理员不能删除');
		//调用高级删除方法
		$model->adv_delete($getId);
		//提示成功消息
		$this->success('删除成功',U('lst'));
		
	}

	public function edit()
	{
		//实例化模型
		$admModel=D('Admin');
		/**************处理表单******************/
		if(IS_POST)
		{
			if($admModel->create())
			{
				$admModel->adv_save();
				$this->success('修改成功',U('lst'));
			}
			else
			{
				$this->error($admModel->getError());
			}
		}
		else
		{

		/**************显示表单******************/

		$role=D('Role');
	    $roleData=$role->select();
		$admData=$admModel->adv_edit( (int)I('get.id',0)  );
	

		//输出到表单
		$this->assign(
			[				
				'Role'=>$roleData,
				'adm'=>$admData['adm'],
				'roleId'=>explode(',',$admData['roleData']['pir_id']),
			]);	

		$this->display();

		}
	}	


}