<?php
  session_start();
  include('includes/validation.php');
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = '';
    $name = validateFormData($_POST['username']);
    $password = validateFormData($_POST['password']);
    $re_password = validateFormData($_POST['re_password']);
    $email = validateFormData($_POST['email']);
    include('includes/connection.php');
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    if (count($password) < 8) {
      $error .= 'Password needs to be more than 8 characters. <br>';
    }
    if ($password !== $re_password) {
      $error .= 'Passwords must match. <br>';
    }
    if ($name && $password && $email && !$error) {
      $query = "INSERT INTO user (username, password, email) VALUES ('$name', '$hashed', '$email')";
      $result = mysqli_query($conn, $query);
      if ($result) {
        $_SESSION['username'] = $name;
        header("Location: /index.php");
      } else {
        die(mysqli_error($conn));
      }
    } else {
      $error .= 'Unique Username, Password and E-mail fields required. <br>';
    }
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
        echo '<li><a href="/login.php">Login</a></li>
        <li class="active"><a href="/register.php">Register</a></li>';
      }
      ?>
   </ul>
 </div>
</nav>
<?php if (count($error) > 0) {
echo '<div class="alert alert-danger text-center">' . $error . '</div>';
} ?>
<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h1 class="text-center">Register</h1>
      <hr>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group">
          <input type="text" placeholder="Username" class="form-control" name="username">
        </div>
        <div class="form-group">
          <input type="password" placeholder="Password (minimum 8 characters)" class="form-control" name="password">
        </div>
        <div class="form-group">
          <input type="password" placeholder="Repeat Password" class="form-control" name="re_password">
        </div>
        <div class="form-group">
          <input type="email" placeholder="E-mail" class="form-control" name="email">
        </div>
        <input type="submit" value="Register" class="btn btn-default btn-lg">
        <hr>
        <div class="pull-right">
          <p>or if you already have an account </p>
          <a href="login.php" class="btn btn-default btn-lg">Login</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>
