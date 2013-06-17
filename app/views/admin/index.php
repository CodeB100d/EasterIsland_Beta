<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Admin Panel</title>
	<link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>bootstrap_by_pau.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>font-awesome.min.css" type="text/css" media="screen" />
	<!--[if IE 7]>
		<link rel="stylesheet" href="public/css/font-awesome-ie7.min.css">
	<![endif]-->
	<link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>site.css" type="text/css" media="screen" />
</head>
<body>
	<div id="header">
		<div id="logo">
			<a href=""><img src="<?php echo PUBLIC_IMG_PATH ?>logo.png"></a>
		</div>
		<span id="project_title">Content Management System</span>
		<div class="pull-right" id="user">
			<span>Login as</span>
			<strong>
				<?php echo Session::get('username') ?>
				<a href="main/logout">Logout</a>
			</strong>
		</div>
		<div class="clear"></div>
	</div>
	<div id="left-sidebar">
		<strong>
		<ul class="nav mega-menu"id="side_menu">
			<li class="nav-header">System Modules</li>
			<li class="active"><a href="index.html"><i class="icon-home"></i> Dashboard</a></li>
			<li>
				<a href="pages.html"><i class="icon-list-alt"></i> Pages</a>
				<ul class="nav nav-list">
					<li class="sub_menu"><a href="#">Add New Page</a></li>
					<li><a href="#">Add Page Templates</a></li>
					<li><a href="#">Create Menu Group</a></li>
					<li><a href="#">Create Sidebar Groups</a></li>
					<li><a href="#">Page Template Editor</a></li>
				</ul>
			</li>
			<li><a href="#"><i class="icon-file"></i> Files</a></li>
			<li><a href="#"><i class="icon-bullhorn"></i> Posts</a></li>
			<li><a href="#"><i class="icon-calendar"></i> Schedule</a></li>
			<li><a href="#"><i class="icon-comment"></i> Comments</a></li>
			<li><a href="#"><i class="icon-envelope"></i> Newsletter</a></li>
			<li><a href="#"><i class="icon-th"></i> Themes</a></li>
			<li><a href="users.html"><i class="icon-user"></i> Users</a></li>
			<li><a href="#"><i class="icon-cog"></i> System</a></li>
		</ul>
		</strong>
		
		<!--footer-->
		<footer id="foot">
			<hr />
			<strong class="muted">
				Company Name<br>
				&copy; Copyright 2013
			</strong>
		</footer>
		<!--end footer-->
	</div>
	<div id="content">
		<div class="breadcrumbs_container" id="breadcrumbs_container">
			<div class="breadcrumbs">
				<span><i class="icon-list-alt"></i> Dashboard</span>
				<div class="breadcrumb_divider"></div>
				
			</div>
			<div class="clear"></div>
		</div>
		
		
		<div style="height:1000px;"></div>fghgh
	</div>
	<!--end container-->
	<script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>jquery.js"></script>
	<script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>jquery.dcverticalmegamenu.1.3.js"></script>
	<script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>jquery.hoverIntent.minified.js"></script>
	<script>
		jQuery(document).ready(function($) {
			$('#side_menu').dcVerticalMegaMenu();
		});
	</script>
</body>

</html>	