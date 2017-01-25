<?php
require_once 'DbManager.php';
require_once 'Encode.php';
require_once 'signupValidator.php';
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>ログイン　テクアカ課題BBS2</title></head>
<body>
<h1 aligin="center">テクアカ課題BBS2</h1>
<hr />
<a  href="index.php">ログインページに戻る</a>
<ul>
    <li>ユーザ名は半角英数字で20文字以内</li>
    <li>パスワードは半角英数字で6文字以上20文字以内</li>
</ul>
<form method="POST" action="register.php">
    <div style="text-align: center">
        <p>
            <input pattern="^([a-zA-Z0-9]{,20})$" title="半角英数字で20文字以内" name="name" placeholder="ユーザ名" size="20" maxlength="30" />
        </p>
        <p>
            <input type="password" name="password" placeholder="パスワード" size="20" maxlength="30" />
        </p>
        <p>
            <input type="submit" name="submit" value="登録する" />
        </p>
    </div>
</form>

<?php
try {
//データベースへの接続を確立
    $db = getDb();
//SELECT命令の実行
    $stt = $db->prepare('SELECT * FROM member ORDER BY id DESC');
    $stt->execute();
//結果セットの内容を順に出力
    while($row = $stt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <p><?php e($row['id']); ?>  ユーザ名：<?php e($row['name']); ?>  パスワード：<?php e($row['password']); ?></p>
        <?php
    }
    $db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
?>

</body>
</html>