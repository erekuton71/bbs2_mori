<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>BBS2ログアウト</title></head>
<body>
<h1 aligin="center">BBS2ログアウト</h1>
<hr />
<a  href="index.php">ログインページに戻る</a>
</body>
</html>

<?php
//セッション開始
session_start();
if (!(isset($_SESSION["id"]))) {
    echo "ログアウトしました。";
}
else {
    echo "セッションがタイムアウトしました。";
}
// セッション変数のクリア
$_SESSION = array();
session_destroy();
?>

