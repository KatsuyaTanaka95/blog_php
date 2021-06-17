<?php
session_start();

$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO($dsn, $dbUserName, $dbPassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));

$user_id = $_SESSION['id'];
$blog_title = $_POST['blog_title'];
$content = $_POST['content'];

$sql = "
INSERT INTO
blogs(
    user_id,
    title,
    content
)
VALUES(?,?,?)
";

$params = array($user_id, $blog_title, $content);
try {
  $statement = $pdo->prepare($sql);
  $statement->execute($params);
  header("Location: ./mypage.php");
  exit;
} catch (PDOException $e) {
  $_SESSION['errors'][] = 'ブログ記事の登録に失敗しました。';
  header("Location: ./create.php");
  exit;
}
