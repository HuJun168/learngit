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
		    <li class="active">修改密码</li>
		</ol>
		<form role="form" method="post" action="<?php echo U('User/setpass');?>">
		  
			  <div class="form-group">
					<label for="password">旧密码</label>
					<input type="password" class="form-control" id="password" placeholder="请输入旧密码" name="oldpassword">
			  </div>

			  <div class="form-group">
					<label for="password">新密码</label>
					<input type="password" class="form-control" id="password" placeholder="请输入新密码" name="newpassword">
			  </div>

			<div class="form-group">
				<label for="repassword">确认密码</label>
				<input type="password" class="form-control" id="repassword" placeholder="请输入确认密码" name="repassword">
			</div>
		  <button type="submit" class="btn btn-primary">提交</button>
		</form>
	</div>	
</body>
</html>