<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model
{
/*********表单验证规则********/
	protected $_validate=[
		['role_name','require','角色名称不能为空',1],
		['pri_id','chkPriId','权限不能为空',1,'callback'],  //callback 使用一个回调函数来验证
		['role_name','','角色名称已存在',1,'unique'],
	];

	//判断pri_id 字段是否不为空
	public function chkPriId($priId)  //这里传值 是自动把当前的数组传进来的
	{
		return !empty($priId);
	}

	public function adv_add()
	{
		//把角色名称插入角色表
		//返回新插入记录的ID
		$id=$this->add();
		//接收pri_id 传的值
		$pri=I('post.pri_id');
		//创建角色权限表模型
		$prModel=D('role_pri'); //如果不想创  就把这个表名 弄上

		//循环pri进数组，
		foreach($pri as $v )
		{
			$prModel->add([

			'role_id'=>$id,//新添加的角色ID
			'pri_id'=>$v,

				]);
		}
	}

	public function adv_save()
	{
		/************先更新 role 表的名称***********/
		$this->save();
		/***********更新中间表信息*****************/
		$pri=D('role_pri');
		//获取post 隐藏域过来的角色ID
		$getId=(int)I('post.id',0);
		//先删除原来拥有的权限
		$where=['role_id'=>['eq',$getId]];
		$pri->where($where)->delete();	
		//接收表单中勾选的ID
		$priId=I('post.pri_id',0);
		//把新添加的权限添加到角色权限表		
		foreach($priId as $v )
		{
			$pri->add([
			'role_id'=>$getId,//新添加的角色ID
			'pri_id'=>$v,
				]);
		}
	}
	public function adv_delete($roleId)
	{
		//删除角色表中的内容
		$this->delete($roleId);
		//删除中间表（用于存这个角色有哪些权限）的值
		//实例化中间表
		$stagingTable=D('role_pri');
		//Tp框架写WHERE 推荐我们使用一个数组在外定义一个数组
		//相当于 role_id=$roleId   ThinkPHP 当中eq代表等于的意思
		$where=['role_id'=>['eq',$roleId]] ;
		$stagingTable->where($where)->delete();

	}

	public function adv_edit($get)
	{

		//显示权限
		$priModel=D('Privilege');
		$priData=$priModel->show();	
		//取出角色
		$roleData=$this->find("$get");
		//取出 该角色拥有哪些权限
		$rpModel=D('role_pri');
		//设计where条件
		$where=['role_id'=>['eq',$get]];
		$priId=$rpModel
					->field('GROUP_CONCAT(pri_id) as pir_id')
					->where($where)
					->find();

		//返回数据
		return [
			'priData'=>$priData,
			'roleData'=>$roleData,
			'priId'=>$priId,
		 ];

	
	}
	public function show()
		
	{
		 $data=$this->select();
		 return $this->short($data);
	}

	private function short($data,$top=0,$buff=0)
	{

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

	/**********角色控制器 做列表做翻页****************/

	public function role_list()
	{
	
		/****************搜索***********************/
		$where=[];//空数组
		$rn=I('get.rn');//接收rn参数
		if($rn)
		{
			$where['role_name']=['LIKE',"%$rn%"];
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

$pageData=$this->where()
			->alias('a')			
			->field('a.*,GROUP_CONCAT(c.pri_name SEPARATOR "<----->") as pri_name')
			->join('LEFT JOIN tzl_role_pri b ON a.id=b.role_id  LEFT JOIN tzl_privilege c ON b.pri_id=c.id')
			->where($where)
			->group('a.id')	
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
}