<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Sign Up</title>
  <link rel="stylesheet" href="<?php echo base_url();?>/css/signupcss.css">

  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  
  <div class="nav">
  <div class="nav-inner">
    <div class="container">
  
      <a class="brand" href="#">
      Collabor8
      </a>
      </div>
  </div>
</div>
<?php echo validation_errors(); ?> 
<?php echo form_open('register/temp_signup'); ?> 
  <div class="login">
    <h1>Sign Up</h1>
    <form method="post" action="">
      <p><input type="text" name="username" value="" placeholder="Username"></p>
     <p><input type="text" name="email" value="" placeholder="Email"></p>
      <p><input type="password" name="password" value="" placeholder="Password"></p>
      <p><input type="password" name="passconf" value="" placeholder="Confirm Password"></p>

      
      <p class="submit"><input type="submit" name="commit" value="Sign Up"></p>
    </form>
  </div>

  
  <div class="conditions">
    <p>By clicking you agree to the <a href="#">Terms of Service  </a>,<a href="#"> Privacy </a> and <a href="#"> Refund policies</a>.</p>
  </div>

</body>
</html>

