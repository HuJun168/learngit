<?php
namespace Admin\Controller;

class CategoryController extends CommonController{

	public function index(){
		$cate_data = M('Category')->order('csort desc')->select();
		$cate_data = D('category')->unlimitedlevel($cate_data,'&nbsp;&nbsp;--');
		$this->assign('data',$cate_data); 
		$this->display();
	}

	public function add_category(){
		if(IS_POST){
			$get_category = I('post.cname');
			if(M('category')->where(array('cname'=>$get_category))->find()) $this->error($get_category.'分类已经存在');
			if(!D('category')->add_cate()){
				$this->error(D('category')->getError());
			}
			$this->success('添加成功',U('Category/index'));
		}else{
			$this->display();
		}
		
	}

	public function add_son(){
		if(IS_POST){
			$get_category = I('post.cname');
			if(M('category')->where(array('cname'=>$get_category))->find()) $this->error($get_category.'分类已经存在');
			if(!D('category')->add_cate()){
				$this->error(D('category')->getError());
			}else{
				$this->success('添加子类成功',U('Category/index'));
			}
		}else{
			$cid = I('get.cid',0,'intval');
			$get_cate = M('Category')->where(array('cid'=>$cid))->field('cid,cname')->find();
			$this->assign('data',$get_cate);
			$this->display();
		}
		
	}

	public function update_cate(){
		if(IS_POST){
			$cid = I('post.cid',0,'intval');
			if(!D('category')->update_category($cid)){
				$this->error(D('category')->getError());
			}else{
				$this->success('修改成功',U('Category/index'));
			}	
		}else{
			$cid = I('get.cid',0,'intval');
			$get_son = D('category')->getsoncate($cid);
			$olddata = M('category')->where(array('cid'=>$cid))->find();
			$this->assign('son',$get_son);
			$this->assign('data',$olddata);
			$this->display();
		}
	}

	public function delete_cate(){
		$cid = I('get.cid',0,'intval');
		//删除父类后将子类的pid向上移动一级
		$get_pid = M('Category')->where(array('cid'=>$cid))->getField('pid');
		$set_pid = M('Category')->where(array('pid'=>$cid))->setField('pid',$get_pid);
		$del_cate = M('Category')->where(array('cid'=>$cid))->delete();
		if($del_cate){
			$this->success('分类删除成功');
		}else{
			$this->error('分类删除失败');
		}

	}

	public function catesort(){
		if(IS_POST){
			$key = I('post.k');
			$value = I('post.v');
			$result = M('category')->where(array('cid'=>$key))->setField('csort',$value);
			if($result){
				$data = array(
					'code' => 1,
					'status' => 'success',
				);
				$this->ajaxReturn($data,'JSON');
			}else{
				$data = array(
					'code' => 0,
					'status' => 'fail',
				);
				$this->ajaxReturn($data,'JSON');
			}
		}
	}

}

?>