<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller{

	public function index(){
		if(IS_POST){
			$username = I('post.username','','string');
			$password = setpass(I('post.password','','string'));
			$code = I('post.code','');
			$result = M('User')->where(array('username'=>$username,'password'=>$password))->find();
			if(!$result){
				$this->error('登录失败!');
			}else if(check_code($code)===false){
				$this->error('验证码输入错误');
			}else{
				$_SESSION['uid'] = $result['id'];
				$_SESSION['username'] = $result['username'];
				$this->success('登录成功',U('Index/index'));
			}

		}else{
			$this->display();
		}
		
	}


	public function logout(){
		session_unset();
		session_destroy();
		$this->redirect('Login/index');
	}


}  



?>