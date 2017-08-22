<?php
session_start();
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time()-86400, '/');
  header('Location: /login.php?message=Logged out');
}
include('includes/header.php'); ?>
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
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
