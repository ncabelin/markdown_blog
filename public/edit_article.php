<?php
session_start();
$menu = 'blogs';
include('includes/validation.php');
include('includes/connection.php');
$article_id = validateFormData($_GET['a_id']);
$blog_id = validateFormData($_GET['id']);
$blog_topic = validateFormData($_GET['topic']);
$user_id = $_SESSION['user_id'];
if (!$_SESSION['username']) {
  header('Location: /login.php');
  exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $conn->prepare("UPDATE article SET title = ?, content = ?, share = ? WHERE user_id = ? AND id = ?");
  $stmt->bind_param("sssii", $title, $content, $share, $user_id, $article_id);
  $title = validateFormData($_POST['title']);
  $content = validateFormData($_POST['content']);
  $share = validateFormData($_POST['share']);
  $user_id = $_SESSION['user_id'];
  if ($title && $content) {
    if ($stmt->execute()) {
      header("Location: /my_articles.php?id=$blog_id&message=Updated article");
    } else {
      $error = 'Unable to save article';
    }
  } else {
    $error = 'Both Title and Content required';
  }
} elseif (!$blog_id && !$blog_content) {
  header('Location: /my_blogs.php');
} else {
  // GET request
  $query = "SELECT title, content, date_modified, share FROM article WHERE id = ? AND user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ii", $article_id, $user_id);
  $stmt->execute();
  $stmt->bind_result($title, $content, $date, $share);
  $stmt->store_result();
  $stmt->fetch();
  if ($stmt->num_rows === 0) {
    $error = 'Error: Could not retrieve article to edit';
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
        <h1 class="text-center">Edit Article for '<?php echo $blog_topic; ?>'</h1><br>
    </div>
    <div class="col-md-6">
      <form class="form" method="POST">
        <div class="form-group">
          <input type="text" placeholder="Title" name="title" class="form-control" value="<?php echo $title; ?>">
        </div>
        <div class="form-group">
          <textarea type="text" name="content" class="form-control" placeholder="Type Answer (Markdown preview on the other side)" id="markdown" rows="10"><?php echo $content; ?></textarea>
        </div>
        <div class="form-group">
          <select name="share">
            <?php if ($share == 'y') {
              echo '<option value="y" default selected>Share</option>';
              echo '<option value="n">Private</option>';
            } else {
              echo '<option value="y">Share</option>';
              echo '<option value="n" default selected>Private</option>';
            }?>
          </select>
        </div>
        <input type="submit" value="SAVE" class="btn btn-default btn-lg">
        <a href="/my_articles.php?id=<?php echo $blog_id; ?>" class="btn btn-default btn-lg">CANCEL</a>
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
