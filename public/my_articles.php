<?php
session_start();
$menu = 'articles';
if (!$_SESSION['username']) {
  header('Location: /login.php');
  exit();
} else {
  include('includes/connection.php');
  include('includes/validation.php');
  $user_id = $_SESSION['user_id'];
  $blog_id = validateFormData($_GET['id']);
  $blog_topic = validateFormData($_GET['topic']);
  $query = "SELECT id, title, date_modified, share FROM article WHERE user_id = ? AND blog_id = ? ORDER BY date_modified DESC";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('ii', $user_id, $blog_id);
  $stmt->execute();
  $stmt->bind_result($id, $title, $date, $share);
  $stmt->store_result();
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
    <div class="col-md-6 col-md-offset-3">
      <div id="blog-title">
        <h1 class="text-center"><i class="fa fa-pencil"></i> <?php echo $blog_topic; ?> Articles
          <button class='btn btn-default btn-sm' id="edit-blog"><i class='fa fa-pencil'></i></button>

          <form class='delete' method='POST' action='/delete.php'>
            <input type='hidden' name='blog_id' value='<?php echo $blog_id; ?>'>
            <button class='btn btn-default btn-sm' type='submit'><i class='fa fa-trash'></i></button>
          </form>

        </h1>
      </div>
      <div id="blog-edit-form">
        <form class="form" method="POST" action="edit_blog.php">
          <input type="hidden" value="<?php echo $blog_id; ?>" name="blog_id">
          <div class="form-group">
            <input type="text" placeholder="Blog Topic" name="topic" class="form-control" value="<?php echo $blog_topic; ?>">
          </div>
          <input type="submit" value="SAVE" class="btn btn-default btn-sm">
          <a class="btn btn-default btn-sm" id="blog-cancel-edit">CANCEL</a>
        </form>
      </div>
        <br>
        <div class="text-center">
          <a class="btn btn-default" href="/my_blogs.php"><i class="fa fa-chevron-left"> </i> &nbsp; BACK TO ALL BLOGS</a>
          <a class="btn btn-default" href="/add_article.php?id=<?php echo $blog_id . '&topic=' .$blog_topic; ?>">ADD ARTICLE</a>
        </div><br>
    </div>
    <div class="col-md-6 col-md-offset-3">
      <div class="list-group">
      <?php
      if ($stmt->num_rows > 0) {
        while($stmt->fetch()) {
          $formatted_date = date("F d, Y", strtotime($date));
          if ($share == 'y') {
            $status = 'shared';
          } else {
            $status = 'private';
          }
          echo "<div class='list-group-item clearfix' data-id='$id'>$title" .
          "<span class='pull-right'><a href='/edit_article.php?id=$blog_id&topic=$blog_topic&a_id=$id' class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>" .
          "<form class='delete' method='POST' action='/delete_article.php'><input type='hidden' name='article_id' value='$article_id'><button class='btn btn-default btn-sm' type='submit'><i class='fa fa-trash'></i></button></form> ($status)</span></div>";
        }
      } else {
        echo "<div class='list-group-item'>No articles yet</div>";
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
    var article_id = $(this).data('id');
    window.location = '/read_article.php?id=' + article_id;
  });

  $('#blog-edit-form').hide();

  $('#edit-blog').click(function() {
    $('#blog-edit-form').show();
    $('#blog-title').hide();
  });

  $('#blog-cancel-edit').click(function() {
    $('#blog-edit-form').hide();
    $('#blog-title').show();
  });
});
</script>
<?php
include('includes/footer.php');
?>
