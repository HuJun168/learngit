<?php
namespace Admin\Controller;
use Think\Upload;

class LinkController extends CommonController{

	public function index(){
        $data = M('Link')->select();
        $this->assign('data',$data);
		$this->display();
	}


	public function add_link(){
		if(IS_POST){
			$linkname = I('post.name','','trim');
			$data['name'] = !empty($linkname) ? htmlspecialchars($linkname) : $this->error('链接名称不能为空');
			$url = I('post.url_address','','trim');
			$data['url_address'] = url_check($url) ? $url :$this->error('你输入的URL格式不正确');
			//设置文件上传
    		if($_FILES['logo']['size'] > 0){
    			$upload = new Upload();
    			$file = date('Y-m-d');
    			$root_path = './Uploads/';
    			$save_name = time().mt_rand();
    			$upload->maxSize = 3145728;
    			$upload->exts = array('jpg','gif','png','jpeg');
    			$upload->rootPath = $root_path;
    			$upload->savePath = 'Link/';
    			$upload->saveName = $save_name;
    			$info = $upload->uploadOne($_FILES['logo']);
    			if(!$info){
    				$this->error($upload->getError());
    			}else{
    				$data['logo'] = $info['savepath'].$info['savename'];
    			}
    		}

    		if(M('Link')->add($data)){
    			$this->success('添加成功',U('Link/index'));
    		}else{
    			$this->error('添加失败');
    		}

		}else{

			$this->display();
		}
	
	}

	public function update_link(){
		if(IS_POST){
			$id = I('post.lid',0,'intval');
			$linkname = I('post.name','','trim');
			$data['name'] = !empty($linkname) ? htmlspecialchars($linkname) : $this->error('链接名称不能为空');
			$url = I('post.url_address','','trim');
			$data['url_address'] = url_check($url) ? $url :$this->error('你输入的URL格式不正确');
			//设置文件上传
    		if($_FILES['logo']['size'] > 0){
    			$upload = new Upload();
    			$file = date('Y-m-d');
    			$root_path = './Uploads/';
    			$save_name = time().mt_rand();
    			$upload->maxSize = 3145728;
    			$upload->exts = array('jpg','gif','png','jpeg');
    			$upload->rootPath = $root_path;
    			$upload->savePath = 'Link/';
    			$upload->saveName = $save_name;
    			$info = $upload->uploadOne($_FILES['logo']);
    			if(!$info){
    				$this->error($upload->getError());
    			}else{
    				$file = M('Link')->where(array('lid'=>$id))->getField('logo');
    				$file_path = './Uploads/'.$file;
    				if($file !== ''){
    					unlink($file_path);
    				} 
    				$data['logo'] = $info['savepath'].$info['savename'];
    			}
    		}
    		if(M('link')->where(array('lid'=>$id))->save($data)){
    			$this->success('修改成功',U('link/index'));
    		}else{
    			$this->error('修改失败');
    		}
		}else{
			$id = I('get.lid',0,'intval');
			$data = M('Link')->where(array('lid'=>$id))->find();
        	$this->assign('data',$data);
			$this->display();
		}
		
	}


	public function delete_link(){
		$id = I('get.id',0,'intval');
		$file = M('Link')->where(array('lid'=>$id))->getField('logo');
		$file_path = './Uploads/'.$file;
		if($file !== ''){
		  unlink($file_path);
		}
		$result = M('Link')->where(array('lid'=>$id))->delete();
		if($result){
			$data = array(
				'code'=>1,
				'success'=>'success'	
			);
			$this->ajaxReturn($data,'JSON');
		}else{
			$data = array(
				'code'=>0,
				'success'=>'fail'	
			);
			$this->ajaxReturn($data,'JSON');
		}
	}


}


?>