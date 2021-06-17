<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>新規登録</title>
</head>

<body>
    <h1>新規登録</h1>
    <?php foreach ($errors as $error) : ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>
    <form action="./signup_complete.php" method="post">
        <div>
            <label>名前：</label>
            <input type="text" name="user_name" placeholder="" required />
        </div>
        <div>
            <label>メールアドレス：</label>
            <input type="text" name="mail" placeholder="" required />
        </div>
        <div>
            <label>パスワード：</label>
            <input type="password" name="password" placeholder="" required />
        </div>
        <button type="submit">新規登録</button>
    </form>
    <p>すでに登録済みの方は<a href="./login_form.php">こちら</a></p>
</body>

</html>