<!DOCTYPE html>
<!-- saved from url=(0023)http://localhost:49558/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Login</title>
    <!-- Le styles -->
    <link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>bootstrap_by_pau.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>font-awesome.min.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>style.css" type="text/css" media="screen" />
    <style>
		body{
			margin:0;
			padding:0;
		}
      .form-signin {
        max-width: 318px;
        margin: 0 auto;
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
		
		#login_header{
			max-width: 318px;
			margin: 0 auto;
			margin-bottom:20px;
			margin-top:15%;
			text-align:center;
		}
		
		#login_header img{
			margin:0 auto;
		}
    </style>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
<body>

	<div class="container">
		<div class="row" id="login_header" >
				<img src="<?php echo PUBLIC_IMG_PATH ?>login_header.png" />		
		</div>
		
		<form method="post" class="form-signin">
			<?php
		   if(!empty($form_error_message)){
				echo '<script>$("#error_msg").shake();</script>';
			   echo '<div class="alert alert-error" id="error_msg">';
			   foreach($form_error_message as $inpname => $inp_err)
			   {
				   echo "$inp_err <br/>";
			   }
			   echo '</div>';
		   }
		   ?> 
		   <input type="text" name="username" class="input-block-level" placeholder="Username" value="<?php echo ($_POST['username'])?$_POST['username']:'' ?>">
		   <input type="password" name="password" class="input-block-level" placeholder="Password" value="<?php echo ($_POST['password'])?$_POST['password']:'' ?>">
		   <a href="#"> I lost my Password</a>
		   <button name="login" type="submit" class="btn btn-primary pull-right"><i class="icon-white icon-ok"></i> Log me in</button>
		</form>
    </div> <!-- /container -->
	
	<!--end container-->
	<script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>jquery.js"></script>
	<script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap.js"></script>
	<script>
		jQuery(document).ready(function($) {
			$('.btn-primary').on('click', function () {$(this).button('loading')});
		});
	</script>
</body>

</html>