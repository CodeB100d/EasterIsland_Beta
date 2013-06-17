<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Admin Panel</title>
	<base href="<?php echo URL.'admin/'; ?>">
	<link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>bootstrap_by_pau.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>jasny-bootstrap.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>font-awesome.min.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>style.css" type="text/css" media="screen" />
	<!--[if IE 7]>
		<link rel="stylesheet" href="public/css/font-awesome-ie7.min.css">
	<![endif]-->
</head>

<body>
	<!--header-->
	<div id="header">
		<div id="logo">
			<a href=""><img src="<?php echo PUBLIC_IMG_PATH ?>logo.png"></a>
		</div>
		
		<span id="project_title">Content Management System</span>
		<div class="pull-right" id="user">
			<span>Login as</span>
			<strong>
				<?php echo $_SESSION["username"] ?>
				<a href="main/logout">Logout</a>
			</strong>
		</div>
		<div class="clear"></div>
	</div>
	<!--end header-->