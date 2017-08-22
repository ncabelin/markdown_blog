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
  $query = "SELECT * FROM blog WHERE user_id = $user_id ORDER BY date_modified DESC";
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
          <a class="btn btn-default" href="/add_blog.php">ADD</a>
        </div><br>
    </div>
    <div class="col-md-6 col-md-offset-3">
      <div class="list-group">
      <?php
      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $title = validateFormData($row['title']);
          $blog_id = $row['id'];
          $date = $row['date_modified'];
          $formatted_date = date("F d, Y", strtotime($date));
          echo "<div class='list-group-item clearfix'>$formatted_date - $title <span class='pull-right'><a href='read.php?id=$blog_id' class='btn btn-default btn-xs'>read</a><a href='/edit_blog.php?id=" .
                "$blog_id' class='btn btn-default btn-xs'>edit</a> <form class='delete' method='POST' action='/delete.php'><input type='hidden' name='blog_id' value='$blog_id'><button class='btn btn-default btn-xs' type='submit'>delete</button></form></span></div>";
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
include('includes/footer.php');
?>
