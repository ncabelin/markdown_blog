<?php
  session_start();
  $menu = 'register';
  include('includes/validation.php');
  $err = '';
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('includes/connection.php');
    $stmt = $conn->prepare("INSERT INTO user (username, password, email) VALUES (?,?,?)");
    $stmt->bind_param("sss", $name, $hashed, $email);
    $name = validateFormData($_POST['username']);
    $password = validateFormData($_POST['password']);
    $re_password = validateFormData($_POST['re_password']);
    $email = validateFormData($_POST['email']);
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    if (strlen($password) < 8) {
      $err .= 'Password needs to be more than 8 characters. <br>';
    }
    if ($password !== $re_password) {
      $error .= 'Passwords must match. <br>';
    }
    if ($name && $password && $email && !$err) {
      if ($stmt->execute()) {
        header("Location: /login.php?message=Succesfully registered, please log-in");
      } else {
        die('Unable to connect');
      }
    } else {
      $error .= 'Unique Username, Password and E-mail fields required. <br>';
    }
  }
  include('includes/header.php');
 ?>
<?php if (strlen($err) > 0) {
echo '<div class="alert alert-danger text-center">' . $err . '</div>';
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
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
