<?php
session_start();

$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO($dsn, $dbUserName, $dbPassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));

$user_id = $_POST['blog_id'];
$blog_title = $_POST['blog_title'];
$content = $_POST['content'];

$sql = "
    UPDATE
      blogs
    SET
      title = ?,
      content = ?
    WHERE
      id = ?
  ";

$params = array($blog_title, $content, $user_id);
try {
  $statement = $pdo->prepare($sql);
  $statement->execute($params);
  header("Location: ./myarticledetail.php?id=" . $user_id);
  exit;
} catch (PDOException $e) {
  $_SESSION['errors'][] = 'ブログ記事の編集に失敗しました。';
  header("Location: ./edit.php");
  exit;
}
