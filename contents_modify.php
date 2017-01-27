<?php
require_once 'DbManager.php';
require_once 'Encode.php';
session_start();
// ログイン状態のチェック
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>BBS2投稿編集ページ</title></head>
<style type="text/css">
    <!--
    textarea {
        width:300px;
        height:100px;
    }
    -->
</style>
<body>
<h1 aligin="center">BBS2投稿編集ページ</h1>
<a  href="bbs2.php">BBS2に戻る</a>

<?php
//入力データの受け取り
if (!(isset($_SESSION["id"]))) {
    $_SESSION["id"] = $_POST["id"];
    $id = $_SESSION["id"];
}
$id = $_SESSION["id"];
$user_id = $_SESSION["user_id"];

try {
//データベースへの接続を確立
    $db = getDb();
    $stt = $db->prepare("SELECT * FROM post WHERE id = '$id'");
    $stt->execute();
    $row = $stt->fetch(PDO::FETCH_NAMED);
    $name = $row['name'];
    if (!(isset($_SESSION["contents"]))) {
        $_SESSION["contents"] = $row['contents'];
    }
    if ($user_id == $row['user_id']) {
    } else {
        print '<ul style="color:Red">';
        print "<li>他のユーザの投稿は編集できません。</li>";
        print '</ul>';
        exit;
    }
    $db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
?>

<form method="post" action="editedContents_insert.php" >
    <div style="text-align: center">
        <p>ユーザ名：<?=$name?></p>
        <textarea class="textarea" name="contents" cols="24" rows="5" id="ta2" wrap="hard" ><?=$_SESSION["contents"]?></textarea>
        <input type="hidden" name="id" value="<?=$id?>">
        <p><input type="password" name="password" placeholder="パスワード"</p>
        <p><input type="submit" value="投稿する"></p>
    </div>
</form>
<a  href="contents_delete.php">投稿を削除する</a>
</body>
</html>
