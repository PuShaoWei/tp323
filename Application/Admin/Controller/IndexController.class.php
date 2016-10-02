<?php
namespace Admin\Controller;

class IndexController extends  ParentController  {
 
    public function index()
    {       
		$this->display();
    }    
 
    public function top()
    {
        $account=session('name');
        $this->assign('account',$account);
		$this->display();
    }    
 
    public function menu()
    {
        $model=D('Admin');
        $menu=$model->getMenu();
		$this->assign('menu',$menu);
        $this->display();
    }    
 
    public function main()
    {
		$this->display();
    }
    public function deleteLogin()
    {
        session('[destroy]'); 
        $this->success('ÍË³ö³É¹¦',U('Login/login'));
    }    

}