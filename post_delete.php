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
<head><title>BBS2投稿削除エラー</title></head>
<body>
<h1 aligin="center">BBS2投稿削除エラー</h1>
<hr />
<a  href="contents_delete.php">BBS2投稿削除ページに戻る</a>

<?php
//入力データの受け取り
$id = $_SESSION["id"];
$user_id = $_SESSION["user_id"];
$password = $_POST['password'];

//エラー表示
$v = new bbs2Validator();
$v->postDelete_requiredCheck($password, 'パスワード');
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
    //DELETE命令の準備
    $stt = $db->prepare("DELETE FROM post WHERE id = '$id'");
    //DELETE命令を実行
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
