<?php
session_start();
if (isset($_SESSION['error'])) {
  echo $_SESSION['error'];
  $_SESSION['error'] = "";
}

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

$blog_id = @$_GET["id"];
$sql = "SELECT * FROM blogs WHERE id = $blog_id";
$blogInfo = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

try {
  $sql_comments = "SELECT * FROM blog.comments WHERE blog_id = $blog_id ORDER BY created_at DESC";
  $statement = $pdo->prepare($sql_comments);
  $statement->execute();
} catch (PDOException $Exception) {
  die('接続エラー：' . $Exception->getMessage());
}

$commentsInfoList = $statement->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>記事詳細ページ</title>
</head>

<body>
  <section>
    <div class="bg-green-300 text-white py-20">
      <div class="container mx-auto my-6 md:my-24">
        <div class="w-full justify-center">
          <div class="container w-full px-4">
            <div class="flex flex-wrap justify-center">
              <div class="w-full lg:w-6/12 px-4">
                <div class="">
                  <h2 class="mb-12 text-6xl text-center font-bold text-green-800"><?php print(nl2br($blogInfo['title'])); ?></h2>
                </div>
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-white">
                  <div class="flex-auto p-5 lg:p-10">
                    <div class="relative w-full mb-3">
                      <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="content">投稿日時: <?php print(nl2br($blogInfo['created_at'])); ?></label>
                      <div class="border-0 px-3 py-3 bg-gray-300 text-gray-800 rounded text-sm shadow focus:outline-none w-full">
                        <?php print(nl2br($blogInfo['content'])); ?>
                      </div>
                    </div>
                    <div class="text-right mt-6">
                      <a href="/blog_php/index.php">
                        <button class="bg-yellow-300 text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">一覧ページへ
                        </button>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-white">
                  <div class="flex-auto p-5 lg:p-10">
                    <h4 class="text-2xl mb-4 text-black font-semibold">この投稿にコメントしますか？</h4>
                    <form id="form" action="/blog_php/comment_add.php" method="post">
                      <div class="relative w-full mb-3">
                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="commenter_name">コメント名</label><input type="text" name="commenter_name" id="commenter_name" class="border-0 px-3 py-3 rounded text-sm shadow w-full
                    bg-gray-300 placeholder-black text-gray-800 outline-none focus:bg-gray-400" placeholder=" " style="transition: all 0.15s ease 0s;" required />
                      </div>
                      <div class="relative w-full mb-3">
                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="comment_content">内容</label><textarea maxlength="300" name="comment_content" id="comment_content" rows="4" cols="80" class="border-0 px-3 py-3 bg-gray-300 placeholder-black text-gray-800 rounded text-sm shadow focus:outline-none w-full" placeholder="" required></textarea>
                      </div>
                      <div class="text-center mt-6">
                        <button id="submit" class="bg-yellow-300 text-black text-center mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">コメント
                        </button>
                      </div>
                      <input type="hidden" name="blog_id" value="<?php print($blog_id); ?>">
                    </form>
                  </div>
                </div>

                <h4 class="text-2xl mb-4 text-black font-semibold">コメント一覧</h4>
                <?php foreach ($commentsInfoList as $commentsInfo) : ?>
                  <div class="border-b-2 border-solid	py-2.5 text-black">
                    <div class="relative w-full mb-3">
                      <p class="mb-2.5 leading-tight text-xl break-all font-normal"><?= htmlspecialchars($commentsInfo['comments']) ?></p>
                    </div>
                    <div class="relative w-full mb-3">
                      <p class="text-sm"><?= htmlspecialchars($commentsInfo['created_at']) ?></p>
                      <p class="text-sm"><?= htmlspecialchars($commentsInfo['commenter_name']) ?></p>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>