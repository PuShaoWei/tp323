<?php
namespace Admin\Controller;
class BrandController extends ParentController
{
	public function add()
	{
		if(IS_POST)
		{
			$Model=D('Brand');
			if($Model->create())
			{
				/**********上传图片********/
				$upload=new \Think\Upload();//实例化上传类，找找简写
				$upload->maxSize=2*1024*1024;//设置文件大小
				$upload->exts=array('jpg','gif','png','jpeg');//设置附件上传类型
				$upload->rootPath='./Public/Uploads/';//保存图片的顶级目录【手动创建好】
				$upload->savePath='Brand/';//保存图片的二级目录【自动生成】
				//开始上传，如果上传失败 返回false，如果成功返回上传之后图片的信息
				$info=$upload->upload();
				//如果上传成功了
				if($info)
				{	
					$Model->logo=$info['logo']['savepath'].$info['logo']['savename'];				
					$Model->add();
					$this->success('添加成功',U('lst'));	
				}
				else
				{
			      $this->error($upload->getError());
				}	
					
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
		$Model=D('Brand');
		if(IS_POST)
		{
			if($Model->create())
			{

				/**********上传图片********/
				$upload=new \Think\Upload();//实例化上传类，找找简写
				$upload->maxSize=2*1024*1024;//设置文件大小
				$upload->exts=array('jpg','gif','png','jpeg');//设置附件上传类型
				$upload->rootPath='./Public/Uploads/';//保存图片的顶级目录【手动创建好】
				$upload->savePath='Brand/';//保存图片的二级目录【自动生成】
				//开始上传，如果上传失败 返回false，如果成功返回上传之后图片的信息
				$info=$upload->upload();
				//如果上传成功了
				if($info)
				{	
					//上传成功了就更改表
					$Model->logo=$info['logo']['savepath'].$info['logo']['savename'];					
					@unlink(IMG_PATH.I('post.ologo',0));					
				}
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
			$data=$Model->find();
			$this->assign('data',$data);
			$this->display();
		}
	}	
	public function lst()
	{
		$Model=D('Brand');
		$data=$Model->select();
		$this->assign('data',$data);	
		$this->display();
	}
	public function delete()
	{
		$Model=D('Brand');
		$getId=(int)I('get.id',0);
		$data=$Model->adv_delete($getId);
		$this->success('删除成功',U('lst'));
	}
}