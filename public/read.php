<?php
session_start();
$menu = 'blogs';
include('includes/validation.php');
include('includes/connection.php');
$stmt = $conn->prepare("SELECT blog.title, blog.content, blog.date_modified, user.username FROM blog JOIN user WHERE user.id = blog.user_id AND blog.id = ?");
$stmt->bind_param("s", $blog_id);
$blog_id = validateFormData($_GET['id']);
if ($blog_id) {
  if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
      $title = validateFormData($row['title']);
      $content = validateFormData($row['content']);
      $date = validateFormData($row['date_modified']);
      $str_date = date("F d, Y", strtotime($date));
      $author = validateFormData($row['username']);
    }
  } else {
    $error = 'Unable to read blog';
  }
} else {
  $error = 'No id specified';
}

include('includes/header.php'); ?>
<?php if ($error) {
echo '<div class="alert alert-danger text-center">' . $error . '</div>';
} ?>
<div class="container">
  <div class="row">
    <br>
    <div class="col-md-10 col-md-offset-1">
        <h1 class="text-center"><?php echo $title; ?></h1>
        <p class="small text-center">by <?php echo $author ?> - <?php echo $str_date; ?></p>
        <hr>
        <div id="content"><?php echo $content; ?></div>
    </div>
  </div>
</div>
<?php
include('includes/scripts.php');
include('includes/markdown_content.php');
include('includes/footer.php');
?>
