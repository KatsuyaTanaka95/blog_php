<?php
session_start();
$messages = $_SESSION['messages'] ?? [];
unset($_SESSION['messages']);
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>ログインページ</title>
</head>

<body>
  <h1>ログインページ</h1>
  <?php foreach ($messages as $message) : ?>
    <p><?php echo $message; ?></p>
  <?php endforeach; ?>
  <?php foreach ($errors as $error) : ?>
    <p><?php echo $error; ?></p>
  <?php endforeach; ?>
  <form action="./login.php" method="post">
    <div>
      <label>メールアドレス：</label>
      <input type="text" name="mail" required />
    </div>
    <div>
      <label>パスワード：</label>
      <input type="password" name="password" required />
    </div>
    <input type="submit" value="ログイン">
  </form>
  <a href="./signup.php">サインアップ</a>
</body>

</html>