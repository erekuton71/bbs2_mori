<?php
require_once 'DbManager.php';
require_once 'Encode.php';
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>テクアカ課題BBS2</title></head>
<body>
<h1 aligin="center">テクアカ課題BBS2</h1>
<hr />
<a  href="login.php">ログアウト</a>
<form method="post" action="insert.php" >
    <div style="text-align: center">
        <p>ユーザ名：<input type="text" name="name"></p>
        <textarea name="contents" cols="30" rows="5"></textarea>
        <p><input type="submit" value="投稿する"></p>
    </div>
</form>

<?php
try {
//データベースへの接続を確立
    $db = getDb();
//SELECT命令の実行
    $stt = $db->prepare('SELECT * FROM post_table ORDER BY id DESC');
    $stt->execute();
//結果セットの内容を順に出力
    while($row = $stt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div style="text-align: center">
            <p><?php e($row['id']); ?>  名前：<?php e($row['user_id']); ?>   <?php e($row['datetime']); ?></p>
            <p><?php e($row['contents']); ?></p>
        </div>
<?php
    }
    $db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
?>

</body>
</html>





