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
				    <a href="#" class="close" data-dismiss="alert">
				        &times;
				    </a>
				    <p style="color:black;font-size:10px;font-family:'微软雅黑';">欢迎您,来到<span style
				    ="color:red;">太郎的博客.^_^</span></p>
				    <p style="color:black;font-size:10px;font-family:'微软雅黑';">→_→ 是否你也会在人潮拥挤的街头，寻寻觅觅，期盼相遇在夕阳斜斜的乌衣巷口 </p>
				</div>
				<div class="well">
					<ol class="breadcrumb">
						<li><a href="<?php echo U('Index/index');?>">首页</a></li>
    					<li><a href="<?php echo U('Index/index',array('cid'=>$data['cate_name']['cid']));?>"><?php echo ($data["cate_name"]["cname"]); ?></a></li>
						<li class="active"><?php echo ($data["title"]); ?></li>
					</ol>
				
					<div class="article">
					 
						<div class="jumbotron">
							<div class="article_title">
								<span><a href="javascript:;"><?php echo ($data['title']); ?></a></span>
							</div>

							<div class="tag-article">
								<a type="button" class="btn btn-default btn-xs">
 								 	<span class="glyphicon glyphicon-time"></span> <?php echo (date("m-d",$data['sendtime'])); ?>
								</a>
								<a type="button" class="btn btn-default btn-xs">
 								 	<span class="glyphicon glyphicon-tags"></span> <?php echo ($data['tag_name']); ?>
								</a>
								<a type="button" class="btn btn-default btn-xs">
 								 	<span class="glyphicon glyphicon-user"></span> <?php echo ($data['author']); ?>
								</a>
								<a type="button" class="btn btn-default btn-xs">
 								 	<span class="glyphicon glyphicon-eye-open"></span> <?php echo ($data['click']); ?>
								</a>
							</div>

							<div class="photo">
								<a href="javascript:;" class="thumbnail">
      								<img src="/hj/Uploads/<?php echo ($data['thumb']); ?>" alt="...">
    							</a>	
							</div>

							<div class="gaiyao">
								<div class="alert alert-success" role="alert">
									<?php echo ($data['digest']); ?>  
								</div>
							</div>

							<div class="article_content">	
								<?php echo (htmlspecialchars_decode($data["content"])); ?>
							</div>

							<div class="zan">
								<ul class="pager">
									 <li>
									 	<a href="javascript:;" onclick="like(<?php echo ($data['aid']); ?>)" id="zan">
											<i class="glyphicon glyphicon-thumbs-up"></i>
											<span>点赞</span>
											<?php if(empty($num)): ?><span class="badge" id="praise-nums">0</span>
												<?php else: ?>
												<span class="badge" id="praise-nums"><?php echo ($num); ?></span><?php endif; ?>
										</a>
									 </li>	
								</ul>
								
								<div class="dianzan">
									<div class="alert alert-warning click" role="alert">
	 								 	<p></p>
									</div>
								</div>

							</div>

							
							<div class="pianfu">
								<div class="alert alert-warning" role="alert">
								    <?php if(!empty($prev_title)): if(is_array($prev_title)): foreach($prev_title as $k=>$v): ?><p><a href="<?php echo U('Content/show',array('aid'=>$k));?>">上一篇 : <?php echo ($v); ?></a></p><?php endforeach; endif; endif; ?> 
									
									<?php if(!empty($next_title)): if(is_array($next_title)): foreach($next_title as $k=>$v): ?><p><a href="<?php echo U('Content/show',array('aid'=>$k));?>">下一篇 : <?php echo ($v); ?></a></p><?php endforeach; endif; endif; ?>
									
								</div>
							</div>
						</div>
						
					</div>
				</div>
                <?php if(($comment_num == 0)): ?><div class="pinglun">
						<div class="alert alert-warning" role="alert">
							<p>暂无评论,赶紧发表你的见解吧.^_^</p>
						</div>
					</div>
				<?php else: ?>
					<div class="pinglun_num">
						<div class="alert alert-warning" role="alert">
							<center>共<?php echo ($comment_num); ?>条评论</center>
						</div>
					</div>
					<?php if(is_array($comment_data)): foreach($comment_data as $key=>$v): ?><div class="pinglun_content">
						 <div class="panel panel-success">
						    <div class="panel-heading">
						        <p><b><?php echo ($v["name"]); ?></b> &nbsp;&nbsp;&nbsp;<span>说道:</span><span class="comment_time"><?php echo (date("Y-m-d H:i:s",$v["addtime"])); ?></span></p>
						    </div>
						    <div class="panel-body" style="height:80px;">
						        <?php if(empty($v['content'])): ?><p style="color:#ccc;">这家伙很懒,什么也没留下</p>
						          <?php else: ?>
						          <p><?php echo ($v["content"]); ?></p><?php endif; ?>
						    </div>
						</div>
						
						<div class="photo_image">
							<img src="/hj/Uploads/<?php echo ($v["image"]); ?>" style="border-radius:100px;">
						</div>

					</div><?php endforeach; endif; endif; ?>
				


				<!-- <div class="pinglun_content">
					 <div class="panel panel-success">
					    <div class="panel-heading">
					        <p><b>小野太郎</b> &nbsp;&nbsp;&nbsp;<span>回复:</span>  <span><b>安倍晋三</b></span><span class="comment_time">2016-12-30 00:12:54</span></p>
					    </div>
					    <div class="panel-body" style="height:80px;">
					        <p>这是一个基本的面板这是一个基本的面板这是一个基本的面板这是一个基本的面板这是一个基本的面板这是一个基本的面板这是一个基本的面板这是一个基本的面板这是一个基本的面板这是一个基本的面板</p>
					    </div>
					</div>
					
					<div class="photo_image">
						
					</div>

					<div class="reply">
						<a href="javascript:;">回复留言</a>
					</div>

				</div> -->

				
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

				<a href="javascript:;" style="text-decoration:none;" id="li">
					<div class="alert alert-info" role="alert" id="liuyan">
					    <center>
					    	<span class="glyphicon glyphicon-pencil"></span>
							<span>欢迎留言</span>
						</center>
						<div class="no_login">
							<div class="alert alert-warning" role="alert">
								 	<p>^_^您尚未登录,还不能评论哟!</p>
							</div>
						</div>	
					</div>
				</a>
				
				<script src="/hj/Public/Home/js/ueditor/ueditor.config.js" charset="utf-8"></script>
				<script src="/hj/Public/Home/js/ueditor/ueditor.all.min.js" charset="utf-8"></script>
				<script src="/hj/Public/Home/js/ueditor/lang/zh-cn/zh-cn.js" charset="utf-8"></script>

				<div class="commentdata" style="display:none;">
				    <form action="javascript:;" method="post">
						<div class="form-group">
							<textarea class="form-control" rows="3" placeholder="可以随便说些自己的内容,或者吐槽什么的^_^" style="resize:none;" require="" id="saytext" name="saytext"></textarea>
							<input type="hidden" name="aid" value="<?php echo ($data['aid']); ?>">
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-primary btn-xs" id="biaoqing">
								<span class="glyphicon glyphicon-plus"></span>添加表情
							</button>
							<button class="btn btn-danger btn-sm" onclick="guest_comment(<?php echo ($data['aid']); ?>)" style="float:right;">发表评论</button>
						</div>
						<div class="form-group">
							
						</div>
					</form>
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
<script type="text/javascript">
  (function ($) {
			$.extend({
			tipsBox: function (options) {
			options = $.extend({
				obj: null,  //jq对象，要在那个html标签上显示
				str: "+1",  //字符串，要显示的内容;也可以传一段html，如: "<b style='font-family:Microsoft YaHei;'>+1</b>"
				startSize: "12px",  //动画开始的文字大小
				endSize: "30px",    //动画结束的文字大小
				interval: 600,  //动画时间间隔
				color: "red",    //文字颜色
				callback: function () { }    //回调函数
			}, options);
			$("body").append("<span class='num'>" + options.str + "</span>");
			var box = $(".num");
			var left = options.obj.offset().left + options.obj.width() / 2;
			var top = options.obj.offset().top - options.obj.height();
			box.css({
				"position": "absolute",
				"left": left + "px",
				"top": top + "px",
				"z-index": 9999,
				"font-size": options.startSize,
				"line-height": options.endSize,
				"color": options.color
			});
			box.animate({
				"font-size": options.endSize,
				"opacity": "0",
				"top": top - parseInt(options.endSize) + "px"
			}, options.interval, function () {
				box.remove();
				options.callback();
			});
		}
	});
})(jQuery);	

  function like(id){				
		$.get("<?php echo U('Content/zan_click');?>",
		{
			aid : id
		},function(like_data){
			if(like_data.code > 0){
				$('#praise-nums').html(like_data.result);
				$.tipsBox({
					obj: $('#zan'),
					str: "+1",
					callback: function () {
					}
				});
			}

			if(like_data.code <= 0){
				$('.dianzan div.alert-warning p').html(like_data.result);
				$('.dianzan').fadeIn(2000,function(){
					$('.dianzan').hide();	
				})
				
			}
		})
	}

	$('#liuyan').click(function(){
		$.get("<?php echo U('Content/comment_click');?>",
		{

		},function(data){
			if(data.code == 0){
				$('#liuyan .no_login').fadeIn(2000,function(){
					$('#liuyan .no_login').hide();	
				})
			}

			if(data.code == 1){
				$('.commentdata').toggle()
			}
		})
	})

  function guest_comment(aid){
  	 var value = $('.commentdata textarea').val();
  	 $.post("<?php echo U('Content/comment');?>",{
  	 	aid : aid,
        content : value
  	 },function(data){
  	 	if(data.code == 1){
  	 		window.location.reload(true);
  	 		jSuccess("留言成功！",{

				// autoHide : true,       // 是否自动隐藏提示条 

				clickOverlay : false,  // 是否单击遮罩层才关闭提示条 

				MinWidth : 200,        // 最小宽度 

				TimeShown : 1500,      // 显示时间：毫秒 

				ShowTimeEffect : 200,  // 显示到页面上所需时间：毫秒 

				HideTimeEffect : 200,  // 从页面上消失所需时间：毫秒 

				LongTrip : 15,         // 当提示条显示和隐藏时的位移 

				HorizontalPosition : "center",// 水平位置:left, center, right 

				VerticalPosition : "top",// 垂直位置：top, center, bottom 

				ShowOverlay : false,     // 是否显示遮罩层 

				ColorOverlay : "#000",  // 设置遮罩层的颜色 

				OpacityOverlay : 0.3,   // 设置遮罩层的透明度 

			});


  	 	}
  	 })
  }


  	$('#biaoqing').qqFace({

		id : 'facebox', 

		assign:'saytext', 

		path:"/hj/Public/Home/arclist/"	//表情存放的路径

	});

 </script>