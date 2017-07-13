<?php
namespace Admin\Controller;

class TagController extends CommonController{

	public function index(){
        $tag_data = M('Tag')->select();
        $this->assign('data',$tag_data);  
		$this->display();
	}

	public function add_tag(){
		if(IS_POST){
			$tagdata = I('post.tname','','trim');
			if(empty($tagdata)) $this->error('标签不能为空');
			$tagdata = explode('|',$tagdata);
			foreach($tagdata as $k=>$v){
				if(M('Tag')->where(array('tname'=>$v))->find()){
					continue;
				}
				$data['tname'] = $v;
				$result = M('Tag')->add($data);
			}
			if(!$result){
				$this->error('标签添加失败');
			}else{
				$this->success('标签添加成功',U('Tag/index'));
			}
		}else{
			$this->display();
		}

	}

	public function tag_update(){
		if(IS_POST){
			$tagdata = I('post.tname','','trim');
			$tid = I('post.tid',0,'intval');
			if(empty($tagdata)) $this->error('标签不能为空');
			if(M('Tag')->where(array('tid'=>$tid))->setField('tname',$tagdata)){
				$this->success('标签修改成功',U('Tag/index'));
			}else{
				$this->error('标签修改失败');
			}
		}else{
			$tid = I('get.tid',0,'intval');
			$tag_data = M('Tag')->where(array('tid'=>$tid))->find();
			$this->assign('data',$tag_data);
			$this->display();
		}
		
	}

	public function tag_delete(){
		$tid = I('get.tid',0,'intval');
		if(M('Tag')->where(array('tid'=>$tid))->delete()){
			$this->success('标签删除成功',U('Tag/index'));
		}else{
			$this->error('标签删除失败');
		}
	}

} 

?>