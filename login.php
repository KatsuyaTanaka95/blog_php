<?php
session_start();
$email = $_POST['email'];
$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$db_account_name = "blog";
$db_account_password = "blog";
try {
    $pdo = new PDO($dsn, $db_account_name, $db_account_password);
} catch (PDOException $e) {
    $message = $e->getMessage();
}

$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email);
$stmt->execute();
$member = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$member) {
    $message = 'メールアドレスもしくはパスワードが間違っています。';
    $loginFormLink = '<a href="login_form.php">戻る</a>';
} elseif (password_verify($_POST['password'], $member['password'])) {
    //DBのユーザー情報をセッションに保存
    $_SESSION['id'] = $member['id'];
    $_SESSION['user_name'] = $member['user_name'];
    header("Location: ./");
}
?>

<h1><?php echo $message; ?></h1>
<?php echo $loginFormLink; ?>