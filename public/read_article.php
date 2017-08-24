<?php
session_start();
$menu = 'blogs';
include('includes/validation.php');
$article_id = validateFormData($_GET['id']);
if ($article_id) {
  include('includes/connection.php');
  $query = "SELECT a.title, a.content, a.date_modified, u.username FROM article a JOIN user u ON u.id = a.user_id WHERE a.id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $article_id);
  if ($stmt->execute()) {
    $stmt->bind_result($title, $content, $date, $author);
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      while ($stmt->fetch()) {
        $str_date = date("F d, Y", strtotime($date));
      }
    }
  } else {
    $error = 'Unable to read article';
  }
} else {
  $error = 'No id specified';
}
$conn->close();
include('includes/header.php');
?>
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
