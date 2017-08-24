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
    $stmt->bind_result($title, $content, $date, $author);
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $str_date = date("F d, Y", strtotime($date));
      }
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
