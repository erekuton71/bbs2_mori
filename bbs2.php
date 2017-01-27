<?php
require_once 'DbManager.php';
require_once 'Encode.php';
session_start();
// ログイン状態のチェック
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}
unset($_SESSION["id"]);
unset($_SESSION["contents"]);
$user_id = $_SESSION["user_id"];

try {
//データベースへの接続を確立
    $db = getDb();
    $stt = $db->prepare("SELECT * FROM member WHERE id = '$user_id'");
    $stt->execute();
    $row = $stt->fetch(PDO::FETCH_NAMED);
    $name = $row['name'];
    $db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>BBS2</title></head>
<style type="text/css">
    <!--
    textarea {
        width:300px;
        height:100px;
    }
    -->
</style>
<body>
<h1 aligin="center">BBS2</h1>
<hr />
<a  href="logout.php">ログアウト</a>
<form method="post" action="contents_insert.php" >
    <div style="text-align: center">
        <p>ユーザ名：<?php echo $name;?></p>
        <textarea class="textarea" name="contents" cols="24" rows="5" id="ta2" wrap="hard" placeholder="本文を入力してください。"></textarea>
        <p><input type="submit" value="投稿する"></p>
    </div>
</form>
<br>

<?php
try {
//データベースへの接続を確立
    $db = getDb();
//SELECT命令の実行
    $stt = $db->prepare('SELECT * FROM post ORDER BY id DESC');
    $stt->execute();

//結果セットの内容を順に出力
    while($row = $stt->fetch(PDO::FETCH_ASSOC)) {
?>
        <div style="text-align: left">
            <p><?php e($row['id']); ?>   ユーザ名：<?php e($row['name']); ?>    <?php e($row['datetime']); ?></p>
            <form method="post" action="contents_modify.php">
                <input type="hidden" name="id" value="<?=$row['id']?>">
                <input type="submit" value="編集">
            </form>
            <p><?php e($row['contents']); ?></p>
            <br>
            <br>
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




