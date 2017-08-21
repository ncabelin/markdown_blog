<?php
session_start();
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time()-86400, '/');
  header('Location: /login.php?message=Logged out');
}
include('includes/header.php'); ?>
<nav class="navbar navbar-default">
 <div class="container">
   <div class="navbar-header">
     <a class="navbar-brand" href="/">Markdown Blog</a>
   </div>
   <ul class="nav navbar-nav navbar-right">
     <li><a href="/">Home</a></li>
     <?php
      if ($_SESSION['username']) {
        echo '<li><a href="/my_blogs.php">My Blogs</a></li>';
        echo '<li class="active"><a href="/logout.php">Logout</a></li>';
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
        <h1 class="text-center">Logged out</h1>
        <br>
        <p class="lead text-center"><?php echo $_SESSION['username']; ?></p>
      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>
