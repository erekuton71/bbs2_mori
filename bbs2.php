<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>BBS1</title></head>
<body>
<h1>BBS1</h1>
<form method="post" action="register.php" >
    <p>名前：<input type="text" name="name"></p>
    <textarea name="contents" cols="30" rows="5"></textarea>
    <p><input type="submit" value="投稿する"></p>
</form>

<?php
require_once 'DbManager.php';
require_once 'Encode.php';
try {
//データベースへの接続を確立
$db = getDb();
//SELECT命令の実行
$stt = $db->prepare('SELECT * FROM post_table ORDER BY id DESC');
$stt->execute();
//結果セットの内容を順に出力
while($row = $stt->fetch(PDO::FETCH_ASSOC)) {
?>
<p><?php e($row['id']); ?>  名前：<?php e($row['name']); ?>   <?php e($row['datetime']); ?></p>

<p><?php e($row['contents']); ?></p>

<?php
}
$db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
?>

</body>
</html>




