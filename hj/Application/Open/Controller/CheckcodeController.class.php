<?php
namespace Open\Controller;
use Think\Controller;

class CheckcodeController extends Controller{

	public function index(){
		$config = array(
			'expire' => 1800,
			// 'imageW' => 340,
			// 'imageH' => 43, 
			'fontSize' => 25,
			'useCurve' => true,
			'useNoise' => true,
			'length' => 4,
			'bg' => array(243,251,254),
		);
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}

}


?>