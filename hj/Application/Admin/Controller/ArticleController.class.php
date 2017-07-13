<?php
namespace Admin\Controller;
use Think\Upload;
use Think\Page;

class ArticleController extends CommonController{

//首页
	public function index(){
		$data = M('Article')->field('aid,title,sendtime,category_cid')->where(array('is_recycle'=>1))->order('sendtime desc')->page($_GET['p'].',3')->select();
		$count = M('Article')->where('is_recycle=1')->count();
		$Pages = new Page($count,3);
		$show = $Pages->show();
		foreach ($data as $k => $v) {
			$data[$k]['category'] = D('Category')->find_cate($v['category_cid']);
		}
		$this->assign('data',$data);
		$this->assign('page',$show);
		$this->display();
	}

//添加文章
    public function add_article(){
    	if(IS_POST){
    		$title = I('post.title','','trim');
    		$data['title'] = !empty($title) ? htmlspecialchars($title) : $this->error('文章标题不能为空');
    		$data['sendtime'] = time();
    		$digest = I('post.digest','','trim');
    		$data['digest'] = !empty($digest) ? htmlspecialchars($digest) : $this->error('文章摘要不能为空');
    		$author = I('post.author','','trim');
    		$data['author'] = !empty($author) ? htmlspecialchars($author) : $this->error('文章作者不能为空');
    		$data['user_id'] = I('session.uid');
    		$data['category_cid'] = I('post.category_cid',0,'intval');
    		$des = I('post.des','','trim');
    		$data['des'] = !empty($des) ? htmlspecialchars($des) : $this->error('文章描述不能为空');
    		$keywords = I('post.keywords','','trim');
    		$data['keywords'] = !empty($keywords) ? htmlspecialchars($keywords) : $this->error('文章描述不能为空');
    		$content = I('post.content','','trim');
    		$data['content'] = !empty($content) ? htmlspecialchars($content) : $this->error('文章内容不能为空');
    		$tags = I('post.tid');
    		//设置文件上传
    		if($_FILES['thumb']['size'] > 0){
    			$upload = new Upload();
    			$file = date('Y-m-d');
    			$root_path = './Uploads/';
    			$save_name = time().mt_rand();
    			$upload->maxSize = 3145728;
    			$upload->exts = array('jpg','gif','png','jpeg');
    			$upload->rootPath = $root_path;
    			$upload->savePath = 'article/';
    			$upload->saveName = $save_name;
    			$info = $upload->uploadOne($_FILES['thumb']);
    			if(!$info){
    				$this->error($upload->getError());
    			}else{
    				$data['thumb'] = $info['savepath'].$info['savename'];
    			}
    		}

    		$aid = M('Article')->add($data);
    		if($aid){
    			foreach ($tags as $v) {
    				$tagarr = array(
    					'article_aid' => $aid,
    					'tag_tid' => $v		
					);
					$add_tag = M('Article_tag')->add($tagarr);
    			}

    			$data['article_aid'] = $aid;
    		  	$add_data = M('Article_data')->add($data);
    		  	if($add_tag && $add_data){
    		  		$this->success('文章添加成功',U('Article/index'));
    		  	}else{
    		  		$this->error('文章添加失败');
    		  	}
    		}
 
    	}else{
    		$tag_data = M('Tag')->select();
			$category_data = M('Category')->field('cid,cname')->select();
			$this->assign('tagdata',$tag_data);
			$this->assign('catedata',$category_data);
    		$this->display();
    	}
    	
    }

//删除文章
    public function delete_article(){
    	$aid = I('get.aid',0,'intval');
    	$image_mess = M('Article')->where(array('aid'=>$aid))->getField('thumb');
    	$file_link = './Uploads/'.$image_mess;
    	if($image_mess !== ''){
    		unlink($file_link);
    	}
    	$article = M('Article')->where(array('aid'=>$aid))->delete();
    	$article_data = M('Article_data')->where(array('article_aid'=>$aid))->delete();
    	$art_tag = M('Article_tag')->where(array('article_aid'=>$aid))->delete();
    	if($article && $article_data && $art_tag){
    		$this->success('文章删除成功',U('Article/index'));
    	}else{
    		$this->error('删除文章失败');
    	}
    }

//修改文章
    public function update_article(){
    	if(IS_POST){
    		$aid = I('post.aid',0,'intval');
    		$title = I('post.title','','trim');
    		$data['title'] = !empty($title) ? htmlspecialchars($title) : $this->error('文章标题不能为空');
    		$digest = I('post.digest','','trim');
    		$data['digest'] = !empty($digest) ? htmlspecialchars($digest) : $this->error('文章摘要不能为空');
    		$author = I('post.author','','trim');
    		$data['author'] = !empty($author) ? htmlspecialchars($author) : $this->error('文章作者不能为空');
    		$data['user_id'] = I('session.uid');
    		$data['category_cid'] = I('post.category_cid',0,'intval');
    		$des = I('post.des','','trim');
    		$data['des'] = !empty($des) ? htmlspecialchars($des) : $this->error('文章描述不能为空');
    		$keywords = I('post.keywords','','trim');
    		$data['keywords'] = !empty($keywords) ? htmlspecialchars($keywords) : $this->error('文章描述不能为空');
    		$content = I('post.content','','trim');
    		$data['content'] = !empty($content) ? htmlspecialchars($content) : $this->error('文章内容不能为空');
    		$data['update_time'] = time();
    		// $data['article_aid'] = $aid;
    		$tags = I('post.tid');
    		//如果上传图片有修改的时候
    		if($_FILES['thumb']['size'] > 0){
    			$upload = new Upload();
    			$file = date('Y-m-d');
    			$root_path = './Uploads/';
    			$save_name = time().mt_rand();
    			$upload->maxSize = 3145728;
    			$upload->exts = array('jpg','gif','png','jpeg');
    			$upload->rootPath = $root_path;
    			$upload->savePath = 'article/';
    			$upload->saveName = $save_name;
    			$info = $upload->uploadOne($_FILES['thumb']);
    			if(!$info){
    				$this->error($upload->getError());
    			}else{
    				$thumb = M('Article')->where(array('aid'=>$aid))->getField('thumb');
    				$file_link = './Uploads/'.$thumb;
    				if($thumb !== ''){
    					unlink($file_link);
    				}
    				$data['thumb'] = $info['savepath'].$info['savename'];
    			}
    		}
    		$update_article = M('Article')->where(array('aid'=>$aid))->save($data);
    		if($update_article){
    			M('Article_tag')->where(array('article_aid'=>$aid))->delete();
    			foreach ($tags as  $val) {
    				$tagarr = array(
    				  'article_aid' => $aid,
    				  'tag_tid' => $val		
					);
					$update_tag = M('Article_tag')->add($tagarr);
    			}

    			$update_data = M('Article_data')->where(array('article_aid'=>$aid))->save($data);

    			if($update_tag || $update_data){
    				$this->success('修改文章成功',U('Article/index'));
    			}else{
    				$this->error('修改文章失败');
    			}
    		}	
    	}else{
    		$aid = I('get.aid',0,'intval');
    		$article_data = M('Article')->join('article_data ON article.aid = article_data.article_aid')->where(array('aid'=>$aid))->find();
    		$get_tag = M('Tag')->select();
    		$cate = M('Category')->field('cid,cname')->select();
    		$tag = M('Article_tag')->where(array('article_aid'=>$aid))->field('tag_tid')->select(); 
    		foreach ($tag as $key => $value) {
    			foreach ($value as $k => $v) {
    				$arr[] = $v;
    			}
    		}
    		$this->assign('data',$article_data);
    		$this->assign('gdata',$get_tag);
    		$this->assign('cate',$cate);
    		$this->assign('arr',$arr);
    		$this->display();
    	}
    }

    //将文章置入回收站
    public function article_recycle(){
    	$aid = I('get.aid',0,'intval');
    	M('Article')->where(array('aid'=>$aid))->setField('is_recycle',0);
    	$this->redirect('Article/index');
    }

    public function recycle(){
    	$data = M('Article')->field('aid,title,sendtime,category_cid')->where(array('is_recycle'=>0))->page($_GET['p'].',3')->select();
    	$count = M('Article')->where(array('is_recycle'=>0))->count();
    	$Page = new Page($count,3);
    	$show = $Page->show();
		foreach ($data as $k => $v) {
			$data[$k]['category'] = D('Category')->find_cate($v['category_cid']);
		}
		$this->assign('data',$data);
		$this->assign('page',$show);
    	$this->display();
    }

 // 还原
    public function article_back(){
    	$aid = I('get.aid',0,'intval');
    	M('Article')->where(array('aid'=>$aid))->setField('is_recycle',1);
    	$this->redirect('Article/recycle');
    } 


}

?>