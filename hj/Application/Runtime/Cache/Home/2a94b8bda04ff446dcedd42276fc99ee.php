<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>index</title>
	<link rel="stylesheet" href="/hj/Public/Home/css/bootstrap.css">
	<link rel="stylesheet" href="/hj/Public/Home/css/mycss.css">
	<link rel="stylesheet" href="/hj/Public/Home/css/jNotify.jquery.css">
	<link rel="stylesheet" href="/hj/Public/Home/css/reset.css">
	<script src="/hj/Public/Home/js/jquery.min.js"></script>
	<script src="/hj/Public/Home/js/bootstrap.min.js"></script>
	<script src="/hj/Public/Home/js/jquery.goup.min.js"></script>
	<script src="/hj/Public/Home/js/index.js"></script>
	<script src="/hj/Public/Home/js/jNotify.jquery.js"></script>
	<script src="/hj/Public/Home/js/jquery.qqFace.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div id="header">
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
  				<a class="navbar-brand" href="<?php echo U('Index/index');?>">MyBlog</a>
				</div>
				<div>
					<ul class="nav navbar-nav navbar-left">
					    <?php if((I('get.cid') == NULL)): ?><li class="active"><a href="<?php echo U('Index/index');?>">首页</a></li>
						<?php else: ?>
						<li class=""><a href="<?php echo U('Index/index');?>">首页</a></li><?php endif; ?>
						<?php if(is_array($cate)): foreach($cate as $k=>$v): if(($k == I('get.cid'))): ?><li class="active"><a href="<?php echo U('Index/index',array('cid'=>$k));?>"><?php echo ($v); ?></a></li>
						    <?php else: ?>
						    <li class=""><a href="<?php echo U('Index/index',array('cid'=>$k));?>"><?php echo ($v); ?></a></li><?php endif; endforeach; endif; ?>
					</ul>
				</div>
				<form class="navbar-form navbar-left" role="search" method="get" action="<?php echo U('Index/index');?>">
		         <div class="input-group">
		            <input type="text" class="form-control" placeholder="文章搜索" name="search">
		            <span class="input-group-btn">
		            	<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
		            </span> 
		         </div>	
  				</form> 
  			<?php if((empty($_SESSION['uid']) AND empty($_SESSION['username']))): ?><p class="navbar-text navbar-right"><a href="<?php echo U('User/login');?>" style="color:white;text-decoration:none;">登录</a></p>
  			<p class="navbar-text navbar-right"><a href="<?php echo U('User/register');?>" style="color:white;text-decoration:none;">注册</a></p>
			<?php else: ?>
  			<div class="dropdown" style="float:right;line-height:50px;">
      				<a href="" id="dropdownMenu1" data-toggle="dropdown">
      				 <?php echo (session('username')); ?>
      					<span class="caret"></span>
      				</a>
      				 <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
					    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo U('User/setpass');?>">修改密码</a></li>
					    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo U('User/logout');?>">退出</a></li>
  					</ul>
  			</div><?php endif; ?>
		</div>
	</nav>
</div>

<!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            	<span>登录</span>
            </div>
            <div class="modal-body">
            	<form role="form">
            		<div class="form-group">
            		    <div class="form-group">
            		    	<label for="username">用户名</label>
							<input type="text" class="form-control" id="username" placeholder="请输入用户名">
            		    </div>
			 			
			 			

						<div class="form-group">
							<label for="password">密码</label>
							<input type="text" class="form-control" id="password" placeholder="请输入用户名密码">
						</div>

						
						<div class="form-group">
							<label for="yanzheng">验证码</label>
							<input type="text" class="form-control" id="yanzheng" placeholder="请输入验证码">
						</div>
						
            		</div>
            	</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary">提交登录</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModal_registr" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            	<span>注册</span>
            </div>
            <div class="modal-body">
            	<form role="form" method="<?php echo U('User/register');?>" action="post" enctype="multipart/form-data" id="register">
            		<div class="form-group">
            		    <div class="form-group">
            		    	<label for="username">用户名</label>
							<input type="text" class="form-control" id="username" placeholder="请输入用户名" name="username">
							<span style="color:red;font-size:13px;"></span>
            		    </div>
			 			
			 			<div class="form-group">
							<label for="email">邮箱</label>
							<input type="text" class="form-control" id="email" placeholder="请输入用户名邮箱" name="email">
							<span style="color:red;font-size:13px;"></span>
						</div>

						<div class="form-group">
							<label for="password">密码</label>
							<input type="text" class="form-control" id="password" placeholder="请输入用户名密码" name="password">
							<span style="color:red;font-size:13px;"></span>
						</div>

						<div class="form-group">
							<label for="repassword">确认密码</label>
							<input type="text" class="form-control" id="repassword" placeholder="请输入确认密码" name="repassword">
							<span style="color:red;font-size:13px;"></span>
						</div>


						<div class="form-group">
							<label for="photo">头像上传</label>
							<input type="file" id="photo" require="" name="image">
							<span style="color:red;font-size:13px;"></span>
						</div>
						
						<div class="form-group">
							<label for="yanzheng">验证码</label>
							<input type="text" class="form-control" id="yanzheng" placeholder="请输入验证码" name="code">
							<span style="color:red;font-size:13px;"></span>
						</div>
						
						<div class="form-group">
							<img src="/hj/index.php?m=open&c=checkcode&a=index&time=" alt="" title="点击切换" style="cursor:pointer" id="yanzhengma">
						</div>
            		</div>
            	</form>
            </div>
            <div class="modal-footer zc">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary">提交注册</button>
            </div>
        </div>
    </div>
</div> -->

	


<div id="main">
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<div class="alert alert-warning" id="myAlert">
			<?php if((I('get.tid') == NULL AND I('get.cid') == NULL)): ?><a href="#" class="close" data-dismiss="alert">
				        &times;
				    </a>
				    <p style="color:black;font-size:10px;font-family:'微软雅黑';">欢迎您,来到<span style
				    ="color:red;">太郎的博客.^_^</span></p><?php endif; ?>

			<?php if(I('get.tid')): ?><span class="badge" style="background-color: #f4645f;float:right;margin-right:0px;">
			        <?php echo ($count); ?>
			    </span>
			    <p style="color:black;font-size:10px;font-family:'微软雅黑';"><span style
			    ="color:red;"><?php echo ($tag_name); ?>.^_^</span></p><?php endif; ?>


			<?php if(I('get.cid')): ?><span class="badge" style="background-color: #f4645f;float:right;margin-right:0px;">
			        <?php echo ($count); ?>
			    </span>
			    <p style="color:black;font-size:10px;font-family:'微软雅黑';"><span style
			    ="color:red;"><?php echo ($cate_gory); ?>.^_^</span></p><?php endif; ?>
			    <p style="color:black;font-size:10px;font-family:'微软雅黑';">→_→ 是否你也会在人潮拥挤的街头，寻寻觅觅，期盼相遇在夕阳斜斜的乌衣巷口 </p>
			</div>
			<div class="article">
				<?php if(is_array($data)): foreach($data as $key=>$v): ?><div class="jumbotron">
					<div class="data-article">
						<span class="month"><?php echo (date("m",$v['sendtime'])); ?>月</span>
						<span class="day"><?php echo (date("d",$v['sendtime'])); ?></span>
					</div>

					<div class="article_title">
						<span><a href="<?php echo U('Content/show',array('aid'=>$v['aid']));?>"><?php echo ($v['title']); ?></a></span>
					</div>

					<div class="tag-article">
						<a type="button" class="btn btn-default btn-xs">
							 	<span class="glyphicon glyphicon-time"></span> <?php echo (date("m-d",$v['sendtime'])); ?>
						</a>
						<a type="button" class="btn btn-default btn-xs">
							 	<span class="glyphicon glyphicon-tags"></span> <?php echo ($v['tag_name']); ?>
						</a>
						<a type="button" class="btn btn-default btn-xs">
							 	<span class="glyphicon glyphicon-user"></span> <?php echo ($v['author']); ?>
						</a>
						<a type="button" class="btn btn-default btn-xs">
							 	<span class="glyphicon glyphicon-eye-open"></span> <?php echo ($v['click']); ?>
						</a>
					</div>

					<div class="photo">
						<a href="<?php echo U('Content/show',array('aid'=>$v['aid']));?>" class="thumbnail">
							<img src="/hj/Uploads/<?php echo ($v['thumb']); ?>" alt="">
						</a>	
					</div>

					<div class="gaiyao">
						<div class="alert alert-success" role="alert">
							<?php echo ($v['digest']); ?> 
						</div>
					</div>

					<div class="article_btn">
						<a class="btn btn-primary" href="<?php echo U('Content/show',array('aid'=>$v['aid']));?>">
							阅读全文 <span class="badge"><?php echo ($v['click']); ?></span>
						</a>
					</div>
				</div><?php endforeach; endif; ?>
			</div>
			<div class="pages">
				<!-- <ul class="pagination">
				    <li><a href="#">&laquo;</a></li>
				    <li class="p active"><a href="#">1</a></li>
				    <li class="p"><a href="#">2</a></li>
				    <li class="p"><a href="#">3</a></li>
				    <li class="p"><a href="#">4</a></li>
				    <li class="p"><a href="#">5</a></li>
				    <li><a href="#">&raquo;</a></li>
				</ul> -->
				<ul class='pagination'><?php echo ($page); ?></ul>
			</div>
		</div>
		<div class="col-md-4">
    <div class="panel-heading">
    	<span>浏览排行</span>
    </div>
	<ul class="list-group">
	 <?php if(is_array($click_num)): foreach($click_num as $key=>$v): ?><li class="list-group-item">
	    <span class="badge" style="color:#fff;background:#f4645f;"><?php echo ($v['click']); ?></span>
	  	 <a href="<?php echo U('Content/show',array('aid'=>$v['aid']));?>"><?php echo ($v['title']); ?></a>
	  </li><?php endforeach; endif; ?>
	</ul>

	<div class="tags">
		<div class="panel panel-default">
			<div class="panel-heading">标签云</div>
				<div class="panel-body">
				<?php if(is_array($tag)): foreach($tag as $key=>$v): ?><a href="<?php echo U('Index/index',array('tid'=>$v['tid']));?>"><?php echo ($v['tname']); ?></a><?php endforeach; endif; ?>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</div>
<div id="fooder">
	<div class="container">
		<p class="pull-left">© hj_168 2016 | 晋ICP备16002534号-6</p>
		<p class="pull-right">
			<a href="javascript:;">
				<img src="http://icon.cnzz.com/img/pic.gif" alt="">
			</a>
			<a href="javascript:;">
				<img src="http://icon.cnzz.com/img/pic.gif" alt="">
			</a>
		</p>
	</div>
</div>
</body>
</html>