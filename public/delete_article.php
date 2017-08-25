<?php
session_start();
$menu = 'blogs';
if (!$_SESSION['username']) {
  header('Location: /login.php');
  exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include('includes/connection.php');
  include('includes/validation.php');
  $stmt = $conn->prepare("DELETE FROM article WHERE user_id = ? AND id = ?");
  $stmt->bind_param("ii", $user_id, $article_id);
  $user_id = $_SESSION['user_id'];
  $blog_id = validateFormData($_POST['blog_id']);
  $blog_topic = validateFormData($_POST['blog_topic']);
  $article_id = validateFormData($_POST['article_id']);
  if ($stmt->execute()) {
    header("Location: /my_articles.php?id=$blog_id&topic=$blog_topic&message=Succesfully deleted");
  } else {
    header("Location: /my_articles.php?id=$blog_id&topic=$blog_topic&error=Unable to delete blog");
  }
} else {
  header("Location: /my_articles.php?id=$blog_id&topic=$blog_topic");
}
