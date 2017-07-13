<?php
namespace Admin\Controller;

class UserController extends CommonController{

	public function index(){

		$this->display();

	}

	public function setpass(){
		if(IS_POST){
			$oldpassword = setpass(I('post.oldpassword',''));
			$newpassword = setpass(I('post.newpassword',''));
			$confirmpassword = setpass(I('post.confirmPassword',''));
			$olddata = M('User')->where(array('password'=>$oldpassword))->find();
			if(!$olddata){
				$this->error('旧密码输入不正确');
			}else if($newpassword != $confirmpassword){
				$this->error('两次密码输入不正确');
			}else{
				if(M('User')->where(array('id'=>$_SESSION['uid']))->setField('password',"$newpassword")){
					session_destroy();
					session_unset();
					$this->success('修改成功');
					echo "<script>top.location.href='./index.php?m=Admin&c=Login&a=index'</script>";
				}else{
					$this->error('密码修改失败');
				}	
			}
		}	
	}


}

?>