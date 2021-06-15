<?php
session_start();
// データベース接続
$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$db_account_name = "blog";
$db_account_password = "blog";
try {
    $pdo = new PDO($dsn, $db_account_name, $db_account_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit('接続できませんでした。理由：' . $e->getMessage());
}

// Postされたものを定義
$user_id = $_SESSION['id'];
$blog_id = $_POST['blog_id'];
$commenter_name = $_POST['commenter_name'];
$comment_content = $_POST['comment_content'];

// Insert
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
    $judgment = true;
} catch (PDOException $e) {
    exit('接続できませんでした。理由：' . $e->getMessage());
}

if ($judgment) {
    header("Location: ./detail.php?a=" . $blog_id);
} else {
    $msg = 'コメントの投稿に失敗しました。';
    $link = '<a href="detail.php">戻る</a>';
}
?>
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>