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
		<table class="table table-hover">
			<tr class="active">
			  <th width="30">aid</th>
			  <th>标题</th>
			  <th>添加时间</th>
			  <th width="100">分类</th>
			  <th width="200">操作</th>
			</tr>
			<?php if(is_array($data)): foreach($data as $key=>$v): ?><tr>
				<td><?php echo ($v['aid']); ?></td>
				<td><?php echo ($v['title']); ?></td>
				<td><?php echo (date("Y-m-d",$v['sendtime'])); ?></td>
				<td><?php echo ($v['category']); ?></td>
				<td>
					<a href="<?php echo U('Article/article_back',array('aid'=>$v['aid']));?>" class="btn btn-sm btn-warning">还原</a>
					<a href="<?php echo U('Article/delete_article',array('aid'=>$v['aid']));?>" class="btn btn-sm btn-danger">删除</a>
				</td>
			</tr><?php endforeach; endif; ?>
		
		</table>
		<center><ul class='pagination'><?php echo ($page); ?></ul></center>
	</body>
</html>