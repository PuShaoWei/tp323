<?php
namespace Admin\Model;
use Think\Model;
class TypeModel extends Model
{
	protected $_validate=[
	['type_name','require','类型名称不能为空',1],
	['type_name','','类型名称已存在',1,'unique'],
	];
	public function search()
	{
		/****************搜索***********************/
		$where=[];//空数组
		$rn=I('get.rn');//接收rn参数
		if($rn)
		{
			$where['type_name']=['LIKE',"%$rn%"];
		}
		/********************排序*********************/
		$orderby='id';			//根据字段默认排序	
		$orderway='asc';		//默认降序
		/*******************翻页**********************/	
		$count = $this->where($where)->count();
	    $Page = new \Think\Page($count,5);
	    //把箭头替换掉
	    $Page->setConfig('prev','上一页');	
	    $Page->setConfig('next','下一页');	
	    $Page->setConfig('first','下一页');	
	    $Page->setConfig('end','最后一页');	
	    $Page->setConfig('current','当前页');	
	    //生成翻页字符串
		$show = $Page->show();
		//取数据

$pageData=$this
			->where($where)
			->order("$orderby $orderway")
			->limit($Page->firstRow.','.$Page->listRows)
			->select();
/*		return var_dump($this->getLastSql());//获取我上一次SQL语句到底输入的是啥  切记 切记啊	*/

		/****************f返回数据************/

		return [
			'data'=>$pageData,	
			'page'=>$show,
		];
	}
	public function adv_delete($id)
	{  
		//先删除type 的id
		$this->delete($id);
		//再删除类型下属的属性
		$this->table('__ATTRIBUTE__')->where('type_id=%s',$id)->delete();
	}
}
