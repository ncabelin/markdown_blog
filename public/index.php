<?php
session_start();
include('includes/header.php'); ?>
<nav class="navbar navbar-default">
 <div class="container">
   <div class="navbar-header">
     <a class="navbar-brand" href="/">Markdown Blog</a>
   </div>
   <ul class="nav navbar-nav navbar-right">
     <li class="active"><a href="/">Home</a></li>
     <?php
      if ($_SESSION['username']) {
        echo '<li><a href="/my_blogs.php">My Blogs</a></li>';
        echo '<li><a href="/logout.php">Logout</a></li>';
      } else {
        echo '<li><a href="/login.php">Login</a></li>
        <li><a href="/register.php">Register</a></li>';
      }
      ?>
   </ul>
 </div>
</nav>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="jumbotron">
        <h1 class="text-center"><i class="fa fa-pencil"></i> markdown-Blog </h1>
        <p class="lead text-center"><?php echo 'Welcome ' . $_SESSION['username']; ?></p>
      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>
