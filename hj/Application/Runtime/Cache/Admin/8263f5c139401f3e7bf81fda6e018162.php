<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">
	    <!-- Loading Bootstrap -->
	    <link href="/hj/Public/Flat/dist/css/vendor/bootstrap.min.css" rel="stylesheet">
	    <!-- Loading Flat UI -->
	    <link href="/hj/Public/Flat/dist/css/flat-ui.css" rel="stylesheet">
	    <link href="/hj/Public/Flat/docs/assets/css/demo.css" rel="stylesheet">
	    <link rel="shortcut icon" href="/hj/Public/Flat/img/favicon.ico">
	    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
	    <!--[if lt IE 9]>
	      <script src="dist/js/vendor/html5shiv.js"></script>
	      <script src="dist/js/vendor/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body>
		<div class="alert alert-success">添加文章</div>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="exampleInputEmail1">文章标题</label>
				<input id="exampleInputEmail1" class="form-control" type="text" placeholder="请输入文章标题" required="" name="title">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">作者</label>
				<input id="exampleInputEmail1" class="form-control" type="text" placeholder="请输入文章作者" required="" name="author">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">所属分类</label>
				<select name="category_cid" class="form-control">
					<option value="0">请选择</option>
					<?php if(is_array($catedata)): foreach($catedata as $key=>$v): ?><option value="<?php echo ($v["cid"]); ?>"><?php echo ($v["cname"]); ?></option><?php endforeach; endif; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">缩略图</label>
				<input id="exampleInputEmail1" type="file" required="" name="thumb">
			</div>
			
			<div id="">
				<label for="">文章标签</label>
				<br />
				<?php if(is_array($tagdata)): foreach($tagdata as $key=>$vo): ?><label class="checkbox checkbox-inline">
					<input class="custom-checkbox" type="checkbox" data-toggle="checkbox" value="<?php echo ($vo["tid"]); ?>" name="tid[]">
					<span class="icons">
					<span class="icon-unchecked"></span>
					<span class="icon-checked"></span>
					</span>
					<?php echo ($vo["tname"]); ?>
				</label><?php endforeach; endif; ?>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">文章摘要</label>
				<textarea name="digest" rows="5" cols=""  class="form-control" placeholder="请输入文章摘要" name="digest"></textarea>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">文章关键字</label>
				<textarea rows="5" cols=""  class="form-control" placeholder="请输入文章关键字" name="keywords"></textarea>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">文章描述</label>
				<textarea rows="5" cols=""  class="form-control" placeholder="请输入文章描述" name="des"></textarea>
			</div>
			<script type="text/javascript" charset="utf-8" src="/hj/Public/ueditor1_4_3/ueditor.config.js"></script>
			<script type="text/javascript" charset="utf-8" src="/hj/Public/ueditor1_4_3/ueditor.all.min.js"> </script>
			<script type="text/javascript" charset="utf-8" src="/hj/Public/ueditor1_4_3/lang/zh-cn/zh-cn.js"></script>
			<div class="form-group">
				<label for="exampleInputEmail1">文章正文</label>
				<script id="editor" type="text/plain" style="width:100%;height:500px;" name="content"></script>
				<script>
    				var ue = UE.getEditor('editor');
				</script>
			</div>
			<button class="btn btn-primary btn-block" type="submit"> 确定 </button>
		</form>
		
	</body>
</html>