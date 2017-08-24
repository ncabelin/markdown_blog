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
  $stmt = $conn->prepare("UPDATE blog SET topic = ? WHERE id = ?");
  $stmt->bind_param("si", $topic, $blog_id);
  $topic = validateFormData($_POST['topic']);
  $blog_id = validateFormData($_POST['blog_id']);
  $user_id = $_SESSION['user_id'];
  if ($stmt->execute()) {
    header("Location: /my_articles.php?id=$blog_id&topic=$topic&message=Successfully edited blog topic");
  } else {
    header("Location: /my_articles.php?id=$blog_id&topic=$topic&error=Cannot edit blog topic");
  }
} else {
  header('Location: /my_blogs.php');
}
?>
