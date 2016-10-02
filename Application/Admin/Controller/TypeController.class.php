<?php
namespace Admin\Controller;
class TypeController extends ParentController 
{
	
	public function add()
	{
		$Model=D('Type');
		if(IS_POST)
		{
			if ($Model->create())
			{
				$Model->add();
				$this->success('添加成功',U('lst'));		
			}
			else
			{
				$error=$Model->getError();
				$this->error($error);
			}
		}
		else
		{
			$this->display();
		}
	}

	public function edit()
	{
		$Model=D('Type');
		if(IS_POST)
		{
			if ($Model->create())
			{
				$Model->save();
				$this->success('修改成功',U('lst'));		
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
			$this->assign('data',$data);
			$this->display();
		}
	}
	public function delete()
	{
		$Model=D('Type');
		$Model->adv_delete((int)I('get.id',0));
		$this->success('删除成功',U('lst'));
	}
	public function lst()
	{
		$Model=D('Type');
		$data=$Model->search();
		$this->assign([
			'page'=>$data['page'],
			'data'=>$data['data'],
			]);
		$this->display();
	}

}