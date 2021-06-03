<?php
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
$user_id = $_POST['blog_id'];
$blog_title = $_POST['blog_title'];
$content = $_POST['content'];

// Update
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
  $judgment = true;
} catch (PDOException $e) {
  exit('接続できませんでした。理由：' . $e->getMessage());
}

if ($judgment) {
  $msg = 'ブログ記事を編集しました。';
  $link = '<a href="index.php">戻る</a>';
} else {
  $msg = 'ブログ記事の編集に失敗しました。';
  $link = '<a href="update_form.php">戻る</a>';
}
?>
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>