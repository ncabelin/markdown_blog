<!DOCTYPE html>
<html>
<head>
  <title>Markdown Blogger</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">

	<!-- Bootstrap and Fontawesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav class="navbar navbar-default">
   <div class="container">
     <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/"><i class="fa fa-pencil"></i> markdown-Blog</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
     <ul class="nav navbar-nav navbar-right text-center">
       <?php if ($menu === 'home') {
         echo '<li class="active"><a href="/">Home</a></li>';
       } else {
         echo '<li><a href="/">Home</a></li>';
       }
       ?>
       <?php
        if ($_SESSION) {
          if ($menu === 'blogs') {
            echo '<li class="active"><a href="/my_blogs.php">My Blogs</a></li>';
            echo '<li><a href="/logout.php">Logout</a></li>';
          } else {
            echo '<li><a href="/my_blogs.php">My Blogs</a></li>';
            echo '<li><a href="/logout.php">Logout</a></li>';
          }
        } else {
          if ($menu === 'login') {
            echo '<li class="active"><a href="/login.php">Login</a></li>
            <li><a href="/register.php">Register</a></li>';
          } elseif ($menu === 'register') {
            echo '<li><a href="/login.php">Login</a></li>
            <li class="active"><a href="/register.php">Register</a></li>';
          } else {
            echo '<li><a href="/login.php">Login</a></li>
            <li><a href="/register.php">Register</a></li>';
          }
        }
        ?>
     </ul>
   </div>
   </div>
  </nav>
