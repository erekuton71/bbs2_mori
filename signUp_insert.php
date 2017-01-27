<?php
require_once 'DbManager.php';
require_once 'bbs2Validator.php';
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>BBS2新規登録</title></head>
<body>
<h1 aligin="center">BBS2登録エラー</h1>
<hr />
<a  href="signUp.php">新規登録ページに戻る</a>

<?php
//入力データの受け取り
$name = $_POST['name'];
$password = $_POST['password'];

//エラー表示
$v = new bbs2Validator();
$v->signUp_requiredCheck($name, 'ユーザ名');
$v->signUp_alnumTypeCheck($name, 'ユーザ名');
$v->signUp_lengthCheck($name, 'ユーザ名', 20);
$v->signUp_duplicateCheck($name, $name, 'SELECT name FROM member WHERE name = :value');
$v->signUp_requiredCheck($password, 'パスワード');
$v->signUp_rangeCheck($password, 'パスワード', 20, 6);
$v();

//passwordのハッシュ化
$hashpassword = password_hash($_POST['password'],PASSWORD_DEFAULT);

try {
    //データベースへの接続を確立
    $db = getDb();
    //INSERT命令の準備
    $stt = $db->prepare('INSERT INTO member (name, password) VALUES (:name, :password)');
    //INSERT命令にポストデータの内容をセット
    $stt->bindValue(':name', $name);
    $stt->bindValue(':password', $hashpassword);

    //INSERT命令を実行
    $stt->execute();
    $db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
//処理後は掲示板ログインページにリダイレクト
header('Location: index.php');
?>

</body>
</html>