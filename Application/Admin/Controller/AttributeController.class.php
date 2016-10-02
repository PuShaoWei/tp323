<?php
namespace Admin\Controller;
class AttributeController extends ParentController
{
	
	public function add()
	{
		$Model=D('Attribute');
		if(IS_POST)
		{
			if($Model->create())
			{
				$Model->add();
				$this->success('添加成功',U('lst?type_id='.I('get.type_id')));
			}
			else
			{
				$error=$Model->getError();
				$this->error($error);
			}
		}
		else
		{

			$tModel=D('type');
			$tData=$tModel->select();
			$this->assign('tData',$tData);
			$this->display();
		}
	}	
	public function edit()
	{
		$Model=D('Attribute');
		if(IS_POST)
		{
			if($Model->create())
			{
				$Model->save();
				$this->success('修改成功',U('lst?type_id='.I('get.type_id')));
			}
			else
			{
				$error=$Model->getError();
				$this->error($error);
			}
		}
		else
		{	
			$data=$Model->find((int)I('get.id',0));
			$tModel=D('type');
			$tData=$tModel->select();
			$this->assign('tData',$tData);
			$this->assign('data',$data);
			$this->display();
		}
	}
	public function delete()
	{
		$Model=D('Attribute');
		$Model->delete((int)I('get.id',0));
		$this->success('删除成功',U('lst?type_id='.I('get.type_id')));
	}
	public function lst()
	{
		$Model=D('Attribute');
		$data=$Model->search();
		$tModel=D('type');
		$tData=$tModel->select();

		$this->assign([
			'page'=>$data['page'],
			'data'=>$data['data'],
			'tData'=>$tData,
			]);

		$this->display();
	}
}