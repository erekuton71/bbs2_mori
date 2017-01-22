<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>ログイン　テクアカ課題BBS2</title></head>
<body>
<h1 aligin="center">テクアカ課題BBS2</h1>
<hr />
<a  href="signup.php">新規会員登録</a>
<form method="POST" action="">
    <div style="text-align: center">
        <p>
            ユーザ名：
            <input type="text" name="username" size="20" maxlength="30" />
        </p>
        <p>
            パスワード：
            <input type="password" name="password" size="20" maxlength="30" />
        </p>
        <p>
            <input type="submit" name="submit" value="ログイン" />
        </p>
        <!--エラーメッセージを表示するための領域-->
        <!--<div style="color:Red"><?php print $errs[$status]; ?></div>-->
    </div>
</form>
</body>
</html>

<!--
<?php/*
require_once 'DbManager.php';
require_once 'Encode.php';
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>BBS2</title></head>
<body>
<h1>BBS2</h1>
<a href="login.php">新規登録</a>

<form method="post" action="insert.php" >
    <p>ユーザ名：<input type="text" name="name"></p>
    <p>パスワード：<input type="text" password="password"></p>
    <p><input type="submit" value="ログインする"></p>
</form>

<?php
try {
//データベースへの接続を確立
    $db = getDb();
//SELECT命令の実行
    $stt = $db->prepare('SELECT * FROM member_table ORDER BY id DESC');
    $stt->execute();
//結果セットの内容を順に出力
    while($row = $stt->fetch(PDO::FETCH_ASSOC)) {
?>
        <p><?php e($row['id']); ?>  名前：<?php e($row['user_id']); ?>   <?php e($row['datetime']); ?></p>
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
-->