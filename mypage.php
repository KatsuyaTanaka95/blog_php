<?php
session_start();
$user_name = $_SESSION['user_name'];
if (isset($_SESSION['id'])) { //ログインしているとき
  $msg = 'こんにちは' . htmlspecialchars($user_name, \ENT_QUOTES, 'UTF-8') . 'さん';
} else { //ログインしていない時
  header("Location: ./login_form.php");
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>マイページ</title>
</head>

<div class="w-full">
  <nav class="bg-white shadow-lg">
    <div class="md:flex items-center justify-between py-2 px-8 md:px-12">
      <div class="flex justify-between items-center">
        <div class="text-2xl font-bold text-gray-800 md:text-3xl">
          <h1><?php echo $msg; ?></h1>
        </div>
        <div class="md:hidden">
          <button type="button" class="block text-gray-800 hover:text-gray-700 focus:text-gray-700 focus:outline-none">
            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
              <path class="hidden" d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z" />
              <path d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z" />
            </svg>
          </button>
        </div>
      </div>
      <div class="flex flex-col md:flex-row hidden md:block -mx-2">
        <a href="/index.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">一覧ページ</a>
        <a href="/logout.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">ログアウト</a>
      </div>
    </div>
  </nav>
</div>

<body>
  <?php
  $dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
  $db_account_name = "blog";
  $db_account_password = "blog";
  try {
    $pdo = new PDO($dsn, $db_account_name, $db_account_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch (PDOException $Exception) {
    die('接続エラー：' . $Exception->getMessage());
  }
  try {
    $sql = "SELECT * FROM blog.blogs ORDER BY created_at DESC";
    $stmh = $pdo->prepare($sql);
    $stmh->execute();
  } catch (PDOException $Exception) {
    die('接続エラー：' . $Exception->getMessage());
  }
  ?>

  <div class="blogs__wraper bg-green-300  py-20 px-20">
    <div class="ml-8 mb-12">
      <h2 class="mb-2 px-2 text-6xl font-bold text-green-800">マイページ</h2>
    </div>
    <div class="mx-8 my-0">
      <a href="/create.php">
        <button class="bg-transparent hover:bg-green-800 text-gray-600 font-semibold hover:text-white py-2 px-4 border border-green-800 hover:border-transparent rounded">
          新規作成
        </button>
      </a>
    </div>
    <div class="flex flex-wrap">

      <?php
      while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
        if ($_SESSION['id'] == $row['user_id']) {
          $limit = 15;
          $content = mb_strimwidth(strip_tags($row['content']), 0, 15, '…', 'UTF-8');
      ?>

          <div class="blogs bg-white w-1/5 m-8">
            <div class="">
              <img src="https://images.unsplash.com/photo-1489396160836-2c99c977e970?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60" class="">
            </div>
            <div class="p-5">
              <h1 class="text-2xl font-bold text-green-800 py-2"><?= htmlspecialchars($row['title']) ?></h1>
              <p class="bg-white text-sm text-black"><?= htmlspecialchars($content) ?></p>
              <a href="/myarticledetail.php/?a=<?= htmlspecialchars($row['id']) ?>" class="py-2 px-3 mt-4 px-6 text-white bg-green-500 inline-block rounded">記事詳細へ</a>
            </div>
          </div>

      <?php
        }
      }
      $pdo = null;
      ?>

    </div>
  </div>
</body>

</html>