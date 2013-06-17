<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Admin Panel</title>
        <base href="<?php echo URL . 'admin/'; ?>">
        <link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>bootstrap_by_pau.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>jasny-bootstrap.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>bigmodals.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>font-awesome.min.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>style.css" type="text/css" media="screen" />
        <!--codemirror-->
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/lib/codemirror.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/neat.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/elegant.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/erlang-dark.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/night.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/monokai.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/cobalt.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/eclipse.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/rubyblue.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/lesser-dark.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/xq-dark.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/xq-light.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/ambiance.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/blackboard.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/vibrant-ink.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/solarized.css">
        <link rel="stylesheet" href="<?php echo PUBLIC_JS_PATH ?>codemirror/theme/twilight.css">
        <style type="text/css">
            .CodeMirror {
                border: 1px solid #eee;
                height: auto;
                min-height:200px;
            }
            .CodeMirror-scroll {
                overflow-y: hidden;
                overflow-x: auto;
            }
            .CodeMirror {border-top: 1px solid #ccc;}
            .CodeMirror-activeline-background {background: #e8f2ff !important;}

            iframe {
                width: 100%;
                height:100%;
                border:none;
            }
        </style>
        <!---->
        <!--[if IE 7]>
                <link rel="stylesheet" href="<?php echo PUBLIC_CSS_PATH ?>font-awesome-ie7.min.css">
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
                    <?php echo Session::get('username') ?>
                    <a href="main/logout">Logout</a>
                </strong>
            </div>
            <div class="clear"></div>
        </div>
        <!--end header-->