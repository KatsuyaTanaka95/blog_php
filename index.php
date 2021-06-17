<?php
session_start();
if (empty($_SESSION['id'])) {
  header("Location: ./login_form.php");
  exit;
}

$dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
$dbUserName = "blog";
$dbPassword = "blog";
$pdo = new PDO($dsn, $dbUserName, $dbPassword);

$keyword = filter_input(INPUT_GET, 'keyword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$inputOrder = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$order = $inputOrder ?? 'DESC';

$baseUrl = 'index.php?';
if (!empty($keyword)) {
  $baseUrl .= 'keyword=' . $keyword;
}
$urlDesc = $baseUrl . '&order=DESC';
$urlAsc = $baseUrl . '&order=ASC';

$sql = "SELECT * FROM blogs";
if (!empty($keyword)) {
  $sql .= " WHERE content like :keyword";
}
$sql .= " ORDER BY created_at " . $order;
$statement = $pdo->prepare($sql);
$statement->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
$statement->execute();

$blogInfoList = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>blog一覧</title>
</head>

<header>
  <div class="w-full">
    <nav class="bg-white shadow-lg">
      <div class="md:flex items-center justify-between py-2 px-8 md:px-12">
        <div class="flex justify-between items-center">
          <div class="text-2xl font-bold text-gray-800 md:text-3xl">
            <h1><?php echo 'こんにちは' . htmlspecialchars($_SESSION['user_name'], \ENT_QUOTES, 'UTF-8') . 'さん';; ?></h1>
          </div>
        </div>
        <div class="flex flex-col md:flex-row hidden md:block -mx-2">
          <a href="./mypage.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">マイページ</a>
          <a href="./logout.php" class="text-gray-800 rounded hover:bg-gray-900 hover:text-gray-100 hover:font-medium py-2 px-2 md:mx-2">ログアウト</a>
        </div>
      </div>
    </nav>
  </div>
</header>

<body>
  <div class="blogs__wraper bg-green-300 py-20 px-20">
    <div class="ml-8 mb-12">
      <h2 class="mb-2 px-2 text-6xl font-bold text-green-800">blog一覧</h2>
    </div>
    <div class="ml-8 mb-6">
      <form action="index.php" method="get">
        <input name="keyword" type="text" value="<?php echo $keyword; ?>" placeholder="キーワードを入力" />
        <input type="submit" value="検索" />
      </form>
    </div>
    <div class="ml-8">
      <a href="<?php echo $urlDesc; ?>">
        <button class="bg-white text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">新しい順
        </button>
      </a>
      <a href="<?php echo $urlAsc; ?>">
        <button class="bg-white text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">古い順
        </button>
      </a>
    </div>
    <div class="flex flex-wrap">
      <?php foreach ($blogInfoList as $blogInfo) : ?>
        <div class="blogs bg-white w-1/5 m-8">
          <div class="">
            <img src="https://images.unsplash.com/photo-1489396160836-2c99c977e970?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60" class="">
          </div>
          <div class="p-5">
            <h1 class="text-2xl font-bold text-green-800 py-2"><?= htmlspecialchars($blogInfo['title']) ?></h1>
            <p class="bg-white text-sm text-black"><?= htmlspecialchars($blogInfo['created_at']) ?></p>
            <p class="bg-white text-sm text-black"><?= htmlspecialchars(mb_strimwidth(strip_tags($blogInfo['content']), 0, 15, '…', 'UTF-8')) ?></p>
            <a href="./detail.php/?id=<?= htmlspecialchars($blogInfo['id']) ?>" class="py-2 px-3 mt-4 px-6 text-white bg-green-500 inline-block rounded">記事詳細へ</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>