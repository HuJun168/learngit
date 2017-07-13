<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>register</title>
	<link rel="stylesheet" href="/hj/Public/Home/css/bootstrap.css">
	<script src="/hj/Public/Home/js/jquery.min.js"></script>
	<script src="/hj/Public/Home/js/bootstrap.min.js"></script>
	<script src="/hj/Public/Home/js/jquery.goup.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="container">
		<ol class="breadcrumb">
		    <li><a href="<?php echo U('Index/index');?>">首页</a></li>
		    <li class="active">用户注册</li>
		</ol>
		<form role="form" method="post" action="<?php echo U('User/register');?>" enctype="multipart/form-data">
		  <div class="form-group">
	    	<label for="username">用户名</label>
			<input type="text" class="form-control" id="username" placeholder="请输入用户名" name="username">
    	  </div>
		  <div class="form-group">
			<label for="email">邮箱</label>
			<input type="text" class="form-control" id="email" placeholder="请输入用户名邮箱" name="email">
		  </div>
		  <div class="form-group">
				<label for="password">密码</label>
				<input type="password" class="form-control" id="password" placeholder="请输入用户名密码" name="password">
		  </div>

		<div class="form-group">
			<label for="repassword">确认密码</label>
			<input type="password" class="form-control" id="repassword" placeholder="请输入确认密码" name="repassword">
		</div>


		<div class="form-group">
			<label for="photo">头像上传</label>
			<input type="file" id="photo" require="" name="image">
		</div>
						
		<div class="form-group">
			<label for="yanzheng">验证码</label>
			<input type="text" class="form-control" id="yanzheng" placeholder="请输入验证码" name="code">
		</div>
						
		<div class="form-group">
			<img src="/hj/index.php?m=open&c=checkcode&a=index&time=" alt="" title="点击切换" style="cursor:pointer" id="yanzhengma">
		</div>

		  <button type="submit" class="btn btn-primary">提交</button>
		</form>
	</div>
	
</body>
</html>
<script>
	$('.form-group #yanzhengma').click(function(){
		var src = $(this).attr('src');
		$(this).attr('src',src+Math.random());
	});
</script>