<?php
session_start();
include('includes/validation.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  include('includes/connection.php');
  $query = "SELECT * FROM user WHERE username = '$username'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      $hashed_password = $row['password'];
    }
    if (password_verify($password, $hashed_password)) {
      // password is correct
      $_SESSION['username'] = $username;
      header("Location: /index.php");
    } else {
      // password is not correct
      $error = 'Username / Password incorrect';
    }
  } else {
    $error = 'Username / Password not found';
  }
} else {
  $message =  validateFormData($_GET['message']);
}

include('includes/header.php');

?>
<nav class="navbar navbar-default">
 <div class="container">
   <div class="navbar-header">
     <a class="navbar-brand" href="/">Markdown Blog</a>
   </div>
   <ul class="nav navbar-nav navbar-right">
     <li><a href="/">Home</a></li>
     <?php
      if ($_SESSION) {
        echo '<li><a href="/my_blogs.php">My Blogs</a></li>';
        echo '<li><a href="/logout.php">Logout</a></li>';
      } else {
        echo '<li class="active"><a href="/login.php">Login</a></li>
        <li><a href="/register.php">Register</a></li>';
      }
      ?>
   </ul>
 </div>
</nav>
<?php if ($message) {
echo '<div class="alert alert-success text-center">' . $message . '</div>';
} ?>
<?php if ($error) {
echo '<div class="alert alert-danger text-center">' . $error . '</div>';
} ?>
<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h1 class="text-center">Login</h1>
      <hr>
      <form method="POST">
        <div class="form-group">
          <input type="text" placeholder="Username" class="form-control" name="username">
        </div>
        <div class="form-group">
          <input type="password" placeholder="Password" class="form-control" name="password">
        </div>
        <input type="submit" value="Log-in" class="btn btn-default btn-lg">
        <hr>
        <p>or</p>
        <a href="register.php" class="btn btn-default btn-lg">Register</a>
      </form>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>
