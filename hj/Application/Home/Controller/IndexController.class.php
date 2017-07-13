<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;


class IndexController extends Controller {
    public function index(){
        //首页的情况下
        $p = I('get.p',0,'intval');
    	$data = M('Article')->join('article_data ON article.aid = article_data.article_aid')->field('content',true)->where(array('is_recycle'=>1))->order('sendtime desc')->page($p.',5')->select();
    	$count = M('Article')->where('is_recycle=1')->count();
    	$Pages = new Page($count,5);
    	$show = $Pages->show();
    	foreach ($data as $k => $v) {
    		$tag = M('Article_tag')->where(array('article_aid'=>$v['aid']))->Field('tag_tid')->find();
    		$data[$k]['tag_name'] = M('Tag')->where(array('tid'=>$tag['tag_tid']))->getField('tname');
    	}
        
        //点击分类的情况下    
        $cid = I('get.cid',0,'intval');
        if($cid){
            $p = I('get.p',0,'intval');
            $data = M('Article')->join('article_data ON article.aid = article_data.article_aid')->field('content',true)->order('sendtime desc')->page($p.',5')->where(array('category_cid'=>$cid,'is_recycle'=>1))->select();
            $array['is_recycle'] = 1;
            $array['category_cid'] = $cid;
            $count = M('Article')->where($array)->count();
            $Pages = new Page($count,5);
            $show = $Pages->show();
            foreach ($data as $k => $v){
            $tag = M('Article_tag')->where(array('article_aid'=>$v['aid']))->Field('tag_tid')->find();
            $data[$k]['tag_name'] = M('Tag')->where(array('tid'=>$tag['tag_tid']))->getField('tname');
            }
            $cate_gory = M('Category')->where(array('cid'=>$cid))->getField('cname');
            $this->assign('cate_gory',$cate_gory);
            $this->assign('count',$count);
        }

        //点击标签的时候
        $tid = I('get.tid',0,'intval');
        if($tid){
            $p = I('get.p',0,'intval');
            $data = M('Article')->join('article_data ON article.aid = article_data.article_aid')->join('article_tag ON article_data.article_aid = article_tag.article_aid')->where(array('tag_tid'=>$tid,'is_recycle'=>1))->field('content',true)->order('sendtime desc')->page($p.',5')->select();
            foreach ($data as $k => $v) {
                 $tag = M('Article_tag')->where(array('article_aid'=>$v['aid']))->getField('tag_tid');
                 $data[$k]['tag_name'] = M('Tag')->where(array('tid'=>$tag))->getField('tname');
            }
            $count = M('Article_tag')->where(array('tag_tid'=>$tid))->count();
            $Pages = new Page($count,5);
            $show = $Pages->show();
            $tag_name = M('Tag')->where(array('tid'=>$tid))->getField('tname');
            $this->assign('tag_name',$tag_name);
            $this->assign('count',$count);
        }

        //当搜索文章的时候
        $search = I('get.search','','trim');
        if(!empty($search)){
            $p = I('get.p',0,'intval');
            $condition['is_recycle'] = 1;
            $condition['title'] = array('like',"%$search%"); 
            $data = M('Article')->join('article_data ON article.aid = article_data.article_aid')->field('content',true)->where($condition)->order('sendtime desc')->page($p.',5')->select();
            $count = M('Article')->where($condition)->count();
            $Pages = new Page($count,5);
            $show = $Pages->show();
            foreach ($data as $k => $v) {
                $tag = M('Article_tag')->where(array('article_aid'=>$v['aid']))->Field('tag_tid')->find();
                $data[$k]['tag_name'] = M('Tag')->where(array('tid'=>$tag['tag_tid']))->getField('tname');
            }
        }


        $category = M('Category')->order('csort desc')->getField('cid,cname');
        $tags = M('Tag')->select();
        $article_click = M('Article')->where(array('is_recycle'=>1))->order('click desc')->limit(5)->select();
        $this->assign('click_num',$article_click);
        $this->assign('tag',$tags);
        $this->assign('cate',$category);
      	$this->assign('data',$data);
    	$this->assign('page',$show);
        $this->display();
    }
}