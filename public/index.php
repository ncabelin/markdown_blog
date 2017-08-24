<?php
session_start();
$menu = 'home';
include('includes/connection.php');
include('includes/validation.php');

$query = "SELECT a.title, a.id, a.date_modified, u.username FROM article a JOIN user u ON u.id = a.user_id WHERE a.share = 'y' ORDER BY a.date_modified DESC LIMIT 10";
$results = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Markdown Blogger</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

	<!-- Bootstrap and Fontawesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css">
</head>
<body id="landing">
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
<style>
.list-group-item:hover {
  cursor: pointer;
  color: #ccc;
}
</style>
<div class="container-fluid" id="landing">
  <div class="row">
    <br>
    <div class="col-md-10 col-md-offset-1">
      <div class="jumbotron">
        <h1 class="text-center"><i class="fa fa-pencil"></i> markdown-Blog </h1>
        <?php if ($_SESSION['username']) {
          echo '<p class="lead text-center">Welcome ' . $_SESSION['username'] . '</p>';
          echo '<p class="text-center">Check out your <a href="my_blogs.php" class="btn btn-default btn-lg">Blogs</a> or <a href="add_blog.php" class="btn btn-default btn-lg">Add Article</a></p>';
        }
        ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h3>Recent articles: </h3>
      <div class="list-group">
        <?php
        if (mysqli_num_rows($results) > 0) {
          while ($row = mysqli_fetch_assoc($results)) {
            $title = validateFormData($row['title']);
            $date = validateFormData($row['date_modified']);
            $str_date = date("F d, Y", strtotime($date));
            $blog_id = $row['id'];
            $author = $row['username'];
            echo "<div class='list-group-item' data-id='$blog_id'>$title <span class='small'> - <em>by $author</em></span><span class='pull-right small'>$str_date</span></div>";
          }
        }
         ?>
      </div>
    </div>
  </div>
</div>
<?php
include('includes/scripts.php');
?>
<script>
$(function() {
  $('.list-group-item').click(function() {
    var blog_id = $(this).data('id');
    window.location = '/read_article.php?id=' + blog_id;
  });
});
</script>
<?php
include('includes/footer.php');
?>
