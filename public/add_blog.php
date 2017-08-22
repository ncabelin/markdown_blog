<?php
session_start();
$menu = 'blogs';
if (!$_SESSION['username']) {
  header('Location: /login.php');
  exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include('includes/validation.php');
  include('includes/connection.php');
  $stmt = $conn->prepare("INSERT INTO blog (user_id, title, content) VALUES (?,?,?)");
  $stmt->bind_param("sss", $user_id, $title, $content);
  $title = validateFormData($_POST['title']);
  $content = validateFormData($_POST['content']);
  $user_id = $_SESSION['user_id'];
  if ($title && $content) {
    if ($stmt->execute()) {
      header("Location: /my_blogs.php?message=Added a blog");
    } else {
      $error = 'Unable to save blog';
    }
  } else {
    $error = 'Title and content required';
  }
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
        echo '<li class="active"><a href="/my_blogs.php">My Blogs</a></li>';
        echo '<li><a href="/logout.php">Logout</a></li>';
      } else {
        echo '<li><a href="/login.php">Login</a></li>
        <li><a href="/register.php">Register</a></li>';
      }
      ?>
   </ul>
 </div>
</nav>
<?php if ($error) {
echo '<div class="alert alert-danger text-center">' . $error . '</div>';
} ?>
<div class="container">
  <div class="row">
    <br>
    <div class="col-md-10 col-md-offset-1">
        <h1 class="text-center"><i class="fa fa-pencil"></i> my Blogs </h1><br>
    </div>
    <div class="col-md-6">
      <form class="form" method="POST">
        <div class="form-group">
          <input type="text" placeholder="Title" name="title" class="form-control">
        </div>
        <div class="form-group">
          <textarea type="text" name="content" class="form-control" style="font:'Courier New', Courier, monospace;" placeholder="Type Answer (Markdown preview on the other side)" id="markdown" rows="10"></textarea>
        </div>
        <input type="submit" value="SAVE" class="btn btn-default btn-lg">
        <a href="/my_blogs.php" class="btn btn-default btn-lg">CANCEL</a>
      </form>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <input placeholder="Preview" class="form-control" readonly>
      </div>
      <div id="preview">
      </div>
    </div>
  </div>
</div>
<?php
include('includes/scripts.php');
include('includes/markdown.php');
include('includes/footer.php');
?>
