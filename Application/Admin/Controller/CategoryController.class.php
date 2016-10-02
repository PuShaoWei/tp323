<?php
namespace Admin\Controller;

class CategoryController extends  ParentController 
{
	public function lst()
	{

		$model=D('Category');
		$data=$model->show();		
		$this->assign('data',$data);
		$this->display();

	}
	
	public function add()
	{
		$model=D('Category');
		$Cdata=$model->show();
		/*****表单验证******/
		if(IS_POST)
		{			
			if($model->create())
			{
				$model->add();
				$this->success('添加成功',U('lst'));
				exit;
			}
			else
			{
				$this->error($model->getError()); //从模型中显示错误信息
			}
		
		}
		else
		{
			$this->assign('data',$Cdata);
			$this->display();
		}
	}
	
	public function delete()
	{
		$model=D('Category');
		$getId=(int)I('get.id',0);
		$test=$model->subclass($getId);
		$this->success('删除成功',U('lst'));
	
	}

	public function edit()
	{
		$model=D('Category');
		$Cdata=$model->show();
		$former=$model->edit((int)I('get.id',0));
		$son=$model->son($former['id']);
		
		if(IS_POST)
		{
			if($model->create())
			{
				$model->save();
				$this->success('修改成功',U('lst'));
			}

			else
			{
				$this->error($model->getError()); //从模型中显示错误信息
			}

		}
		else
		{

			$this->assign(
				['data'=>$Cdata,'former'=>$former,'son'=>$son]);
			$this->display();	
		}	

	}	

}