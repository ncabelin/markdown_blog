<?php
session_start();
$menu = 'blogs';
include('includes/connection.php');
include('includes/validation.php');
if (!$_SESSION['username']) {
  header('Location: /login.php');
  exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // save edit
  $stmt = $conn->prepare("UPDATE blog SET title = ?, content = ? WHERE id = ?");
  $stmt->bind_param("ssi", $title, $content, $blog_id);
  $title = validateFormData($_POST['title']);
  $content = validateFormData($_POST['content']);
  $blog_id = validateFormData($_POST['blog_id']);
  $user_id = $_SESSION['user_id'];
  if ($stmt->execute()) {
    header('Location: /my_blogs.php?message=Successfully edited');
  } else {
    $error = 'Failed to saved edited blog';
  }
} else {
  $user_id = $_SESSION['user_id'];
  $blog_id = validateFormData($_GET['id']);
  $query = "SELECT * FROM blog WHERE id = $blog_id AND user_id = $user_id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      $blog_id = $row['id'];
      $title = $row['title'];
      $content = $row['content'];
    }
  }
  $error = validateFormData($_GET['error']);
  $message =  validateFormData($_GET['message']);
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
<?php if ($message) {
echo '<div class="alert alert-success text-center">' . $message . '</div>';
} ?>
<?php if ($error) {
echo '<div class="alert alert-danger text-center">' . $error . '</div>';
} ?>
<div class="container">
  <div class="row">
    <br>
    <div class="col-md-10 col-md-offset-1">
        <h1 class="text-center"><i class="fa fa-pencil"></i>Edit Blog </h1><br>
    </div>
    <div class="col-md-6">
      <form class="form" method="POST">
        <input type="hidden" value="<?php echo $blog_id; ?>" name="blog_id">
        <div class="form-group">
          <input type="text" placeholder="Title" name="title" class="form-control" value="<?php echo $title; ?>">
        </div>
        <div class="form-group">
          <textarea type="text" name="content" class="form-control" style="font:'Courier New', Courier, monospace;" placeholder="Type Answer (Markdown preview on the other side)" id="markdown" rows="10"><?php echo $content; ?></textarea>
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
