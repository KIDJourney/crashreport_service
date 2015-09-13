<!DOCTYPE html>
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <link href="../../../static/login.css" rel="stylesheet">

<body>

<div class="container">

    <form class="form-signin" action="<?php base_url('manage/login')?>" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">用户名</label>
        <input type="text" id="inputEmail" class="form-control" name="username" placeholder="用户名" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
        <?php if (isset($error)) {?>
            <label class="text-danger" >Username or password incorrect</label>
        <?php }?>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登入</button>
    </form>

</div>



</body></html>