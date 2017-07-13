<?php

//封装经常使用函数

//打印数组的函数
function p($arr){
	header('content-type:text/html;charset=utf-8');
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}


//验证码检测
function check_code($code,$id=''){
	$verify = new \Think\Verify();
	return $verify->check($code,$id);
}


//将密码MD5化
function setpass($password){
	return md5($password.'blog');
}


//检测是否是url地址

function url_check($url){
	$ptn = '/^(http:\/\/|https:\/\/)?(www)+\.\w+\.\w+/';
	if(preg_match($ptn,$url)){
		return true;
	}
	return false;
}


function check_email($email){
  $pattern='/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
  if(preg_match($pattern, $email)){
  	return true;
  }
   return false;
}

function checkpasslength($password){
	if(strlen($password)<6){
		return false;
	}
	return true;
}


function ubbReplace($str){
    $str = str_replace ( ">", '<;', $str );    
    $str = str_replace ( ">", '>;', $str );
    $str = str_replace ( "\n", '>;br/>;', $str );  
    $str = preg_replace ( "[\[em_([0-9]*)\]]", "<img src=/hj/Public/Home/arclist/$1.gif />", $str );
    return $str;
}


?>