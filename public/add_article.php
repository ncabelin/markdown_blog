<?php
session_start();
$menu = 'blogs';
include('includes/validation.php');
include('includes/connection.php');
$blog_id = validateFormData($_GET['id']);
$blog_topic = validateFormData($_GET['topic']);
if (!$_SESSION['username']) {
  header('Location: /login.php');
  exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $conn->prepare("INSERT INTO article (blog_id, user_id, title, content, share) VALUES (?,?,?,?,?)");
  $stmt->bind_param("iisss", $blog_id, $user_id, $title, $content, $share);
  $title = validateFormData($_POST['title']);
  $content = validateFormData($_POST['content']);
  $share = validateFormData($_POST['share']);
  $user_id = $_SESSION['user_id'];
  if ($title && $content) {
    if ($stmt->execute()) {
      header("Location: /my_articles.php?id=$blog_id&message=Added article");
    } else {
      $error = 'Unable to save article';
    }
  } else {
    $error = 'Both Title and Content required';
  }
} elseif (!$blog_id) {
  header('Location: /my_blogs.php');
}

include('includes/header.php'); ?>
<?php if ($error) {
echo '<div class="alert alert-danger text-center">' . $error . '</div>';
} ?>
<div class="container">
  <div class="row">
    <br>
    <div class="col-md-10 col-md-offset-1">
        <h1 class="text-center">Add Article for '<?php echo $blog_topic; ?>'</h1><br>
    </div>
    <div class="col-md-6">
      <form class="form" method="POST">
        <div class="form-group">
          <input type="text" placeholder="Title" name="title" class="form-control">
        </div>
        <div class="form-group">
          <textarea type="text" name="content" class="form-control" placeholder="Type Answer (Markdown preview on the other side)" id="markdown" rows="10"></textarea>
        </div>
        <div class="form-group">
          <select name="share">
            <option value="y" default>Share</option>
            <option value="n">Private</option>
          </select>
        </div>
        <input type="submit" value="SAVE" class="btn btn-default btn-lg">
        <a href="/my_articles.php?id=<?php echo $blog_id?>" class="btn btn-default btn-lg">CANCEL</a>
      </form>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <h3 class="text-center" style="margin-top:0;"><strong>Markdown Preview</strong></h3>
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
