<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller{
	public function __construct(){
		parent::__construct();
		$this->checklogin();
	}
    
    public function checklogin(){
    	if(!isset($_SESSION['uid']) && !isset($_SESSION['username'])){
    		$this->redirect('login/index');
    	}
    }

}

?>