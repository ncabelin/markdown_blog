<?php
session_start();
$menu = 'blogs';
if (!$_SESSION['username']) {
  header('Location: /login.php');
  exit();
} else {
  include('includes/connection.php');
  include('includes/validation.php');
  $user_id = $_SESSION['user_id'];
  $query = "SELECT * FROM blog WHERE user_id = $user_id ORDER BY topic ASC";
  $result = mysqli_query($conn, $query);
  $error = validateFormData($_GET['error']);
  $message =  validateFormData($_GET['message']);
}
include('includes/header.php'); ?>
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
        <h1 class="text-center"><i class="fa fa-pencil"></i> my Blogs </h1><br>
        <div class="text-center">
          <?php
          if (mysqli_num_rows($result) > 0) {
          echo '<span>* Select a topic or</span>';
          }
          ?>
          <a class="btn btn-default" href="/add_blog.php">ADD TOPIC</a>
        </div><br>
    </div>
    <div class="col-md-6 col-md-offset-3">
      <div class="list-group">
      <?php
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $topic = validateFormData($row['topic']);
          $blog_id = $row['id'];
          $date = $row['date_modified'];
          $formatted_date = date("F d, Y", strtotime($date));
          echo "<div class='list-group-item clearfix' data-id='$blog_id' data-topic='$topic'>$topic " .
          "<span class='pull-right'>" .
          "<a class='btn btn-default btn-sm' href='add_article.php?id=$blog_id&topic=$topic'><i class='fa fa-plus'></i> ARTICLE</a></span></div>";
        }
      } else {
        echo "<div class='list-group-item'>No entries yet</div>";
      }
      ?>
      </div>
    </div>
  </div>
</div>
<?php
include('includes/scripts.php');
?>
<script>
$(function() {
  $('.list-group-item').click(function() {
    var blog_id = $(this).data('id'),
        topic = $(this).data('topic');
    window.location = '/my_articles.php?id=' + blog_id + '&topic=' + topic;
  });
});
</script>
<?php
include('includes/footer.php');
?>
