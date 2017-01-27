<?php
require_once 'DbManager.php';
require_once 'bbs2Validator.php';
//セッション開始
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>BBS2ログイン</title></head>
<body>
<h1 aligin="center">BBS2ログインエラー</h1>
<hr />
<a  href="index.php">ログインページに戻る</a>

<?php
//入力データの受け取り
$name = $_POST['name'];
$password = $_POST['password'];

//エラー表示
$v = new bbs2Validator();
$v->login_requiredCheck($name, 'ユーザ名');
$v->login_requiredCheck($password, 'パスワード');
$v();

try {
//データベースへの接続を確立
    $db = getDb();
    $stt = $db->prepare("SELECT * FROM member WHERE name = '$name'");
    $stt->execute();
    $row = $stt->fetch(PDO::FETCH_NAMED);
    $hashpassword = $row['password'];
    if (password_verify($password, $hashpassword)) {
        //セッションIDを新規に発行
        session_regenerate_id(true);
        $_SESSION['user_id'] = $row['id'];
        header('Location: bbs2.php');
    } else {
        print '<ul style="color:Red">';
            print "<li>ユーザ名またはパスワードが違います。</li>";
        print '</ul>';
    }
    $db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
?>

</body>
</html>