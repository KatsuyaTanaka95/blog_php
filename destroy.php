<?php
session_start();

$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO($dsn, $dbUserName, $dbPassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));

$blog_id = @$_GET["id"];
$sql = "
    DELETE FROM
      blogs
    WHERE
      id = ?
  ";
$params = array($blog_id);
try {
  $statement = $pdo->prepare($sql);
  $statement->execute($params);
  header("Location: ./mypage.php");
  exit;
} catch (PDOException $e) {
  $_SESSION['errors'][] = 'ブログ記事の削除に失敗しました。';
  header("Location: ./myarticledetail.php?id=" . $_GET["id"]);
  exit;
}
