<?php
namespace Admin\Controller;

class WebsetController extends CommonController{

	public function index(){
        $websetdata = M('Webset')->select();
        $this->assign('data',$websetdata); 
		$this->display();
	}

	public function setweb(){
		if(IS_POST){
			$data = I('post.');
			foreach ($data as $k => $v) {
				$result = M('Webset')->where(array('id'=>$k))->setField('value',$v);
			}
			
			if($result){
				$this->redirect('Webset/index');
			}else{
				$this->redirect('Webset/index');
			}
			
		}

	}

}


?>