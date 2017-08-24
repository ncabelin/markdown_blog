<?php
session_start();
$menu = 'blogs';
if (!$_SESSION['username']) {
  header('Location: /login.php');
  exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include('includes/validation.php');
  include('includes/connection.php');
  $stmt = $conn->prepare("INSERT INTO blog (user_id, topic) VALUES (?,?)");
  $stmt->bind_param("ss", $user_id, $topic);
  $topic = validateFormData($_POST['topic']);
  $user_id = $_SESSION['user_id'];
  if ($topic) {
    if ($stmt->execute()) {
      header("Location: /my_blogs.php?message=Added a blog");
    } else {
      $error = 'Unable to save blog';
    }
  } else {
    $error = 'Topic required';
  }
}

include('includes/header.php'); ?>
<?php if ($error) {
echo '<div class="alert alert-danger text-center">' . $error . '</div>';
} ?>
<div class="container">
  <div class="row">
    <br>
    <div class="col-md-10 col-md-offset-1">
        <h1 class="text-center"><i class="fa fa-pencil"></i> my Blogs </h1><br>
    </div>
    <div class="col-md-6 col-md-offset-3">
      <form class="form" method="POST">
        <div class="form-group">
          <input type="text" placeholder="Blog Topic" name="topic" class="form-control">
        </div>
        <input type="submit" value="SAVE" class="btn btn-default btn-lg">
        <a href="/my_blogs.php" class="btn btn-default btn-lg">CANCEL</a>
      </form>
    </div>
  </div>
</div>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
