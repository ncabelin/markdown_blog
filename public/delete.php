<?php
session_start();
$menu = 'blogs';
if (!$_SESSION['username']) {
  header('Location: /login.php');
  exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include('includes/connection.php');
  include('includes/validation.php');
  $stmt = $conn->prepare("DELETE FROM blog WHERE user_id = ? AND id = ?");
  $stmt->bind_param("ii", $user_id, $blog_id);
  $user_id = $_SESSION['user_id'];
  $blog_id = validateFormData($_POST['blog_id']);
  if ($stmt->execute()) {
    header('Location: /my_blogs.php?message=Succesfully deleted');
  } else {
    header('Location: /my_blogs.php?error=Unable to delete blog');
  }
} else {
  header('Location: /my_blogs.php?error=Unable to delete blog');
}
