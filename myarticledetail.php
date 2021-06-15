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

$blog_id = @$_GET["a"];
$sql = "SELECT * FROM blogs WHERE id = $blog_id";
$res = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="blog.css">
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
                  <h2 class="mb-12 text-6xl text-center font-bold text-green-800"><?php print(nl2br($res['title'])); ?></h2>
                </div>
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-white">
                  <div class="flex-auto p-5 lg:p-10">
                    <div class="relative w-full mb-3">
                      <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="content">内容</label>
                      <div class="border-0 px-3 py-3 bg-gray-300 text-gray-800 rounded text-sm shadow focus:outline-none w-full">
                        <?php print(nl2br($res['content'])); ?>
                      </div>
                    </div>
                    <div class="text-right mt-6">
                      <a href="/edit.php?a=<?= htmlspecialchars($_GET["a"]) ?>">
                        <button class="bg-yellow-300 text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">編集
                        </button>
                      </a>
                      <a href="/destroy.php?a=<?= htmlspecialchars($_GET["a"]) ?>">
                        <button class="bg-yellow-300 text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">削除
                        </button>
                      </a>
                      <a href="/index.php">
                        <button class="bg-yellow-300 text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit" style="transition: all 0.15s ease 0s;">一覧ページへ
                        </button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>