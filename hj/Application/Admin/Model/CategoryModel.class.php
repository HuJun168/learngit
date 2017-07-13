<?php
namespace Admin\Model;
use Think\Model;

class CategoryModel extends Model{
	protected $_tableName = 'category';
	protected $_validate = array(
		array('cname','require','分类名称不能为空'),
		array('ctitle','require','分类标题不能为空'),
		array('cdes','require','分类描述不能为空'),
		array('ckeywords','require','分类关键字不能为空'),
		array('csort','number','分类排序只能是数字'),
	);

	protected $_auto = array(
		array('cname','trim','function'),
		array('ctitle','trim','function'),
		array('cdes','trim','function'),
		array('ckeywords','trim','function'),
		array('csort','trim','function'),
	);

	public function add_cate(){
		if(!$this->create()) return false;
	    $result = $this->add();
	    if(!$result){
	    	$this->error = '分类添加失败';
	    	return false;
	    }else{
	    	return true;
	    }
	}

	public function unlimitedlevel($cate,$html='--',$pid=0,$level=0){
		$arr = array();
		foreach ($cate as $v) {
			if($v['pid'] == $pid){
				$v['level'] = $level+1;
				$v['html'] = str_repeat($html,$level);
				$arr[] = $v;
				$arr = array_merge($arr,$this->unlimitedlevel($cate,$html,$v['cid'],$level+1));

			}
		}
		return $arr;
	}

	private function getson($cate,$cid){
		$arr = array();
		foreach ($cate as $v) {
			if($cid == $v['pid']){
				$arr[] = $v['cid'];
				$this->getson($cate,$v['cid']);
			}
		}
		return $arr;
	}

    public function getsoncate($cid){
    	$new_arr = $this->getson($this->select(),$cid);
    	$new_arr[] = $cid;
    	$where['cid'] = array('not in',$new_arr);
	 	return $this->where($where)->select(); 
    }

    public function update_category($cid){
    	if(!$this->create()) return false;
    	$result = $this->where(array('cid'=>$cid))->save();
    	if(!$result){
    		$this->error = '修改失败';
    		return false;
    	}else{
    		return true;
    	}
    }


    public function find_cate($v){
    	$data = $this->where(array('cid'=>$v))->getField('cname');
    	return $data;
    }


	
}


?>