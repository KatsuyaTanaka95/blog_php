<?php
session_start();

$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO($dsn, $dbUserName, $dbPassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));

$user_id = $_SESSION['id'];
$blog_id = $_POST['blog_id'];
$commenter_name = $_POST['commenter_name'];
$comment_content = $_POST['comment_content'];

$sql = "
INSERT INTO
comments(
    user_id,
    blog_id,
    commenter_name,
    comments
)
VALUES(?,?,?,?)
";

$params = array($user_id, $blog_id, $commenter_name, $comment_content);
try {
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    header("Location: ./detail.php?id=" . $blog_id);
    exit;
} catch (PDOException $e) {
    $_SESSION['errors'][] = 'コメントの投稿に失敗しました。';
    header("Location: ./detail.php?id=" . $blog_id);
    exit;
}
