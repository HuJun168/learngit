<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload;

class UserController extends Controller{

	public function register(){
		if(IS_POST){
			$username = I('post.username','','trim');
			if(empty($username)) $this->error('用户名不能为空');
			$email = I('post.email','','trim');
			if(empty($email)) $this->error('邮箱不能为空');
			if(!check_email($email)) $this->error('邮箱格式不正确');
			if(M('Guest')->where(array('email'=>$email))->count()){
				$this->error('该邮箱已经注册');
			}
			$password = I('post.password','','trim');
			$repassword = I('post.repassword','','trim');
			if(empty($password)) $this->error('密码不能为空');
			if(!checkpasslength($password)) $this->error('密码长度不能小于6位');
			if(empty($repassword)) $this->error('确认密码不能为空');
			if($password !== $repassword) $this->error('两次密码不一致');
			//设置文件上传
    		if($_FILES['image']['size'] > 0){
    			$upload = new Upload();
    			$file = date('Y-m-d');
    			$root_path = './Uploads/';
    			$save_name = time().mt_rand();
    			$upload->maxSize = 3145728;
    			$upload->exts = array('jpg','gif','png','jpeg');
    			$upload->rootPath = $root_path;
    			$upload->savePath = 'guest/';
    			$upload->saveName = $save_name;
    			$info = $upload->uploadOne($_FILES['image']);
    			if(!$info){
    				$this->error($upload->getError());
    			}else{
    				$data['image'] = $info['savepath'].$info['savename'];
    				$image = new \Think\Image();
    				$image->open('./Uploads/'.$data['image']);
    				$image->thumb(50, 50,\Think\Image::IMAGE_THUMB_FIXED)->save('./Uploads/'.$data['image']);
    			}
    		}
    		$code = I('post.code','','trim');
    		if(check_code($code)===false) $this->error('验证码输入错误');
    		$data['name'] = $username;
    		$data['email'] = $email;
    		$data['password'] = setpass($password);
    		$data['ip_address'] = get_client_ip();
    		if(M('Guest')->add($data)){
    			$this->success('注册成功',U('Index/index'));
    		}else{
    			$this->error('注册失败');
    		} 
		}else{
			$this->display();
		}
	}

	public function login(){
		if(IS_POST){
			$username = I('post.username','','trim');
			$password = I('post.password','','trim');
			$code = I('post.code','','trim');
			if(empty($username)) {
			  $this->error('用户名不能为空');	
			}else if(!M('Guest')->where(array('name'=>$username))->count()){
				$this->error('用户名输入不正确');
			}else if(empty($password)){
				$this->error('密码不能为空');
			}else if(!M('Guest')->where(array('name'=>$username,'password'=>setpass($password)))->count()){
				$this->error('密码输入不正确');
			}else if(empty($code)){
				$this->error('验证码不能为空');
			}else if(check_code($code)===false){
				$this->error('验证码输入有误');
			}else{
				$_SESSION['uid'] = M('Guest')->where(array('name'=>$username,'password'=>setpass($password)))->getField('id');
				$_SESSION['username'] = $username;
				$this->success('登录成功',U('Index/index'));
			}
		
		}else{
			$this->display();	
		}
		
	}

	public function setpass(){
		if(IS_POST){
			$oldpassword = I('post.oldpassword','','trim');
			$newpassword = I('post.newpassword','','trim');
			$repassword = I('post.repassword','','trim');
			if(empty($oldpassword)){
				$this->error('旧密码不能为空');
			}else if(!M('Guest')->where(array('id'=>$_SESSION['uid'],'password'=>setpass($oldpassword)))->count()){
				$this->error('旧密码输入不正确');
			}else if(empty($newpassword)){
				$this->error('新密码不能为空');
			}else if(!checkpasslength($newpassword)){
				$this->error('新密码长度不能少于6位');
			}elseif(empty($repassword)){
				$this->error('确认密码不能为空');
			}else if($newpassword !== $repassword){
				$this->error('两次密码不一致');
			}else{
				$data['password'] = setpass($newpassword);
				if(M('Guest')->where(array('id'=>$_SESSION['uid'],'name'=>$_SESSION['username']))->save($data)){
					$this->success('密码修改成功',U('User/login'));
				}else{
					$this->error('密码修改失败');
				}
			}
		}else{
			$this->display();
		}
		
	}

	public function logout(){
		unset($_SESSION['uid']);
		unset($_SESSION['username']);
		$this->redirect('Index/index');
	}

}

?>