<!DOCTYPE html>
<html>

<head>
    <title>LENACastle - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no,minimal-ui" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="screen-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="browsermode" content="application">
    <meta name="x5-orientation" content="portrait">
    <meta name="x5-fullscreen" content="true">
    <meta name="x5-page-mode" content="app">
    <!-- <script src="/resources/js/fastclick.min.js"></script> -->
    <!-- <script src="/resources/js/jquery.min.js"></script> -->
    <script src="//cdn.bootcss.com/fastclick/1.0.6/fastclick.min.js"></script>
    <script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    <script src="/resources/js/jquery.easyui.min.js"></script>
    <script src="/resources/js/login.js?v=1.0"></script>
    <link href="/resources/css/login.css?v=1.0" rel="stylesheet">
    <link href="/resources/img/favicon_lc.ico" rel="shortcut icon" />
</head>

<body>
    <div id="bg" class="fullscreen-bg" style="background-image: url('<?php echo $bingPhote ?>');">
    </div>
    <div class="form-signin">
        <h1 class="form-signin-heading">LENACastle</h1>
        <input id="UserName" name="UserName" type="text" class="form-control" placeholder="账户" autofocus>
        <input id="Password" name="Password" type="password" class="form-control" placeholder="密码">
        <div id="alert" class="alert alert-dismissable alert-danger"><span></span></div>
        <a id="btn_submit" class="btn btn-primary btn-block" role="button">登 陆</a>
    </div>
    <div class="bing-desc">
        <span><?php echo $bingDescription ?></span>
    </div>
</body>

</html>
