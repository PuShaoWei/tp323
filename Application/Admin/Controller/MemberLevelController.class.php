<?php
namespace Admin\Controller;

class MemberLevelController extends  ParentController {

	public function lst()
	{
		$Model=D('MemberLevel');
		$count=$Model->count();
		$page=new \Think\Page($count,5);
		$pagestr=$page->show();

		$data=$Model->limit($page->firstRow.','.$page->listRows)->select();
		
		$this->assign(['data'=>$data,'page'=>$pagestr]);
		$this->display();
	}
	public function add()
	{
		if(IS_POST)
		{
			$Model=D('MemberLevel');
			if($Model->create())
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
			$this->display();
	}

	public function edit()
	{
		$Model=D('MemberLevel');

		if(IS_POST)
		{

			if($Model->create())
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


			$this->assign('level',$Model->find(I('get.id')));
			$this->display();
		}
	}

	public function delete()
	{
		$Model=D('MemberLevel');
		$Model->delete(I('get.id'));
		$this->success('删除成功',U('lst'));
	}

}
