<?php
namespace Admin\Controller;

class RoleController extends ParentController 
{
	public function lst()
	{
		//实例化角色表
		$model=D('Role');
/*
		SELECT a.*,GROUP_CONCAT(c.pri_name) AS pri_name 

FROM tzl_role a 

	LEFT JOIN tzl_role_pri b ON a.id=b.role_id  

	LEFT JOIN tzl_privilege c ON b.pri_id=c.id

GROUP BY a.id; */
		$data=$model->role_list();
		
		$this->assign(['data'=>$data['data'],'page'=>$data['page']]);

		$this->display();

	}
	
	public function add()
	{
		if (IS_POST)
		{
		
			$rm=D('Role');
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
			$priModel=D('Privilege');
			$priData=$priModel->show();	
			$this->assign('priData',$priData);
			$this->display();
		}

	}
	
	public function delete()
	{
		//实例化模型
		$model=D('Role');
		//接收get值
		$getId=(int)I('get.id',0);
		//调用高级删除方法
		$model->adv_delete($getId);
		//提示成功消息
		$this->success('删除成功',U('lst'));
		
	}

	public function edit()
	{
		//实例化模型
		$priModel=D('Role');
		/**************处理表单******************/
		if(IS_POST)
		{
			if($priModel->create())
			{
				$priModel->adv_save();

				$this->success('修改成功',U('lst'));
			}
			else
			{
				$this->error($priModel->getError());
			}
		}
		else
		{

		/**************显示表单******************/


		$data=$priModel->adv_edit((int)I('get.id'));
		//输出到表单
		$this->assign(
			['priData'=>$data['priData']['data'], 
			'roleData'=>$data['roleData'],
			'priId'=>explode(',',$data['priId']['pir_id']),
			]);	

		$this->display();

		}
	}	


}