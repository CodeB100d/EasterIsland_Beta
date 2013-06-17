<!doctype html>
<html>
<head>
    <title><?php if(!empty($this->page_title)) echo $this->page_title; else echo '404 Page not found'; ?></title>
    <style type="text/css">
	body{
		background-color:#eee;
		width:100%;
		font-family:arial;
		font-size:11.5px;
	}
	#center{
		margin:0 auto;
		width:237px;
		padding-top:15%;
		text-align:center;
	}
        
    </style>
</head>    
<body>
    <div id="center">
        <img src="<?php echo PUBLIC_IMG_PATH ?>404.png">
		<strong>The page you are looking for doesn't exist...</strong>
		<br>
		<strong>Go back to the <a href="main">home page</a></strong>
    </div>    
</body>
</html>