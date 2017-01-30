<?php
require_once 'DbManager.php';
require_once 'bbs2Validator.php';
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
<head><title>BBS2投稿編集エラー</title></head>
<body>
<h1 aligin="center">BBS2投稿編集エラー</h1>
<hr />
<a  href="contents_modify.php">BBS2投稿編集ページに戻る</a>

<?php
//入力データの受け取り
$id = $_SESSION["id"];
$user_id = $_SESSION["user_id"];
$_SESSION["contents"] = $_POST["contents"];
$contents = $_SESSION["contents"];
$password = $_POST['password'];

//エラー表示
$v = new bbs2Validator();
$v->contents_requiredCheck($_POST['contents'], '本文');
$v->editedContents_requiredCheck($password, 'パスワード');
$v();

try {
    //データベースへの接続を確立
    $db = getDb();
    //user_idが一致するユーザ名の取得
    $stt = $db->prepare("SELECT * FROM member WHERE id = '$user_id'");
    $stt->execute();
    $row = $stt->fetch(PDO::FETCH_NAMED);
    $hashpassword = $row['password'];
    if (!(password_verify($password, $hashpassword))) {
        print '<ul style="color:Red">';
        print "<li>パスワードが違います。</li>";
        print '</ul>';
        exit;
    }
    //UPDATE命令の準備
    $stt = $db->prepare("UPDATE post SET contents = :contents  WHERE id = '$id'");
    //UPDATE命令にポストデータの内容をセット
    $stt->bindValue(':contents', $contents);
    //UPDATE命令を実行
    $stt->execute();
    $db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
//処理後は掲示板トップページにリダイレクト
header('Location: bbs2.php');
?>

</body>
</html>
