<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;

class ContentController extends Controller{

	public function show(){
		//点击阅读全文的时候
		$aid = I('get.aid',0,'intval');
		if($aid){
			$p = I('get.p',0,'intval');
			$read_num = M('Article')->where(array('aid'=>$aid))->setInc('click');
			$data = M('Article')->join('article_data ON article.aid = article_data.article_aid')->where(array('aid'=>$aid))->find();

			$tag = M('Article_tag')->where(array('article_aid'=>$data['aid']))->Field('tag_tid')->find();
			$data['tag_name'] = M('Tag')->where(array('tid'=>$tag['tag_tid']))->getField('tname');
			$data['cate_name'] = M('Category')->where(array('cid'=>$data['category_cid']))->field('cid,cname')->find();
			$next_title = M('Article')->where(array('aid'=>$aid+1))->getField('aid,title');
		
			$prev_title = M('Article')->where(array('aid'=>$aid-1))->getField('aid,title');
			$like_num = M('Praise')->where(array('aid'=>$aid))->sum('nums');
			$comment_data = M('Comment')->where(array('article_aid'=>$aid))->order('addtime desc')->page($p.',5')->select();
			$count = M('Comment')->where(array('article_aid'=>$aid))->order('addtime desc')->count();
			$Pages = new Page($count,5);
    		$show = $Pages->show();
			foreach ($comment_data as $key => $value) {
				$comment_data[$key]['image'] = M('Guest')->where(array('id'=>$value['gid']))->getField('image'); 
				$comment_data[$key]['name'] = M('Guest')->where(array('id'=>$value['gid']))->getField('name');
				$comment_data[$key]['content'] = ubbReplace($value['content']);
			}

		}
        $category = M('Category')->order('csort desc')->getField('cid,cname');
        $tags = M('Tag')->select();
        $article_click = M('Article')->where(array('is_recycle'=>1))->order('click desc')->limit(5)->select();
        $comment_num = M('Comment')->where(array('article_aid'=>$aid))->count();
        $this->assign('comment_num',$comment_num);
        $this->assign('click_num',$article_click);
        $this->assign('tag',$tags);
        $this->assign('cate',$category);
		$this->assign('next_title',$next_title);
		$this->assign('prev_title',$prev_title);
    	$this->assign('data',$data);
    	$this->assign('num',$like_num);
    	$this->assign('comment_data',$comment_data);
    	$this->assign('page',$show);
		$this->display();
	}


	public function zan_click(){
		if(IS_AJAX){
			$aid = I('get.aid',0,'intval');
			$type = isset($_SESSION['uid']) ? 1 : 0;
			$uid = isset($_SESSION['uid']) ? intval($_SESSION['uid']) : 0;
			$now_time = time();
			$model = M('Praise');
			$data = array(
				'user_ip' => get_client_ip(0,true),	
				'add_time' =>$now_time,
				'type' => $type,
				'uid' => $uid,
				'aid' => $aid,
				'nums'=> 1
			);
		    //判断文章id是否合法
		    if(!$aid){
		    	$like_data = array(
		    		'code' => 0,
		    		'result' => '非法请求',
		    		'status'=>'fail'
	   			 );

		    	$this->ajaxReturn($like_data,'JSON');
		    } 
		    
			//如果是系统用户点赞
			if($uid){
				//判断是否已经点赞,没有点赞的情况下
				$where = array('type'=>1,'uid'=>$uid,'aid'=>$aid);
				$olddata = $model->where($where)->find();
				if(!$olddata){
					$data['valid_time'] = $now_time+3600;
					if($model->add($data)){
						$count = $model->where(array('aid'=>$aid))->sum('nums');
						$like_data = array(
		    				'code' => 1,
		    				'result' => $count,
		    				'status'=>'success'
	   					 );
		    			$this->ajaxReturn($like_data,'JSON');
					}else{
						$like_data = array(
		    				'code' => -1,
		    				'result' => '点赞失败,请重试ToT~',
		    				'status'=>'fail'
	   					 );
		    			$this->ajaxReturn($like_data,'JSON');
					} 
				}else{
					if($olddata['valid_time'] > $now_time){
						$like_data = array(
		    				'code' => -2,
		    				'result' => '您已经赞过了,一个小时再来吧!',
		    				'status'=>'fail'
	   					 );
		    			$this->ajaxReturn($like_data,'JSON');
					}else{
						$data['nums'] = $olddata['nums'] + 1;
						$data['valid_time'] = $now_time+3600;
						if($model->where($where)->save($data)){
							$count = $model->where(array('aid'=>$aid))->sum('nums');
							$like_data = array(
			    				'code' => 2,
			    				'result' => $count,
			    				'status'=>'success'
	   					 	);
		    				$this->ajaxReturn($like_data,'JSON');
						}else{
							$like_data = array(
			    				'code' => -3,
			    				'result' => '点赞失败,请重试ToT~',
			    				'status'=>'fail'
	   					 	);
		    				$this->ajaxReturn($like_data,'JSON');
						}
					}
				}
			}else{
				//游客模式
				$where2 = array('type'=>0,'user_ip'=>$data['user_ip'],'aid'=>$aid);
				$olddata = $model->where($where2)->find();
				if(!$olddata){
					//未点赞
					$data['valid_time'] = $now_time+86400;
					if($model->add($data)){
						$count = $model->where(array('aid'=>$aid))->sum('nums');
						$like_data = array(
			    				'code' => 3,
			    				'result' => $count,
			    				'status'=>'success'
	   					 	);
	    				$this->ajaxReturn($like_data,'JSON');
					}else{
						$like_data = array(
			    				'code' => -4,
			    				'result' => '点赞失败,请重试ToT~',
			    				'status'=>'fail'
   					 	);
	    				$this->ajaxReturn($like_data,'JSON');
					}
				}else{
					//点赞模式
					if($olddata['valid_time'] > $now_time){
						$like_data = array(
			    				'code' => -5,
			    				'result' => '您已经赞过了,一天以后再来吧!~',
			    				'status'=>'fail'
   					 	);
	    				$this->ajaxReturn($like_data,'JSON');
					}else{
						$data['nums'] = $olddata['nums'] + 1;
						$data['valid_time'] = $now_time+86400;
						if(!$model->where($where2)->save($data)){
							$like_data = array(
			    				'code' => -6,
			    				'result' => '点赞失败,请重试ToT~',
			    				'status'=>'fail'
   					 		);
	    					$this->ajaxReturn($like_data,'JSON');
						}else{
							$count = $model->where(array('aid'=>$aid))->sum('nums');
							$like_data = array(
			    				'code' => 6,
			    				'result' => $count,
			    				'status'=>'success'
	   					 	);
	    					$this->ajaxReturn($like_data,'JSON');
						} 
					}
				}
			}
		}		
	}

	public function comment_click(){
		if(!$_SESSION['uid'] || !$_SESSION['username']){
			$data = array(
				'code' => 0,
				'result' => '',
				'status' => 'fail'
			);
			$this->ajaxReturn($data,'JSON');
		}else{
			$data = array(
				'code' => 1,
				'result' => '',
				'status' => 'success'
			);
			$this->ajaxReturn($data,'JSON');
		}
	}


	public function comment(){
		if(IS_POST){
			$aid = I('post.aid',0,'intval');
			$content = I('post.content','','trim');
			$comment_data['addtime'] = time();
			$comment_data['content'] = htmlspecialchars($content);
			$comment_data['article_aid'] = $aid;
			$comment_data['gid'] = $_SESSION['uid'];
			if(M('Comment')->add($comment_data)){
				$data = array(
					'code' => 1,
					'result' => '评论成功',
					'status' => 'success'
				);
				$this->ajaxReturn($data,'JSON');
			} 

		}
	}

}

?>