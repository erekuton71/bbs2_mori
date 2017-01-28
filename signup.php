<?php
require_once 'DbManager.php';
require_once 'Encode.php';
require_once 'bbs2Validator.php';
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>BBS2新規会員登録</title></head>
<body>
<h1 aligin="center">BBS2新規会員登録</h1>
<hr />
<a  href="index.php">ログインページに戻る</a>
<ul>
    <li>ユーザ名は半角英数字で20文字以内</li>
    <li>パスワードは半角英数字で6文字以上20文字以内</li>
</ul>
<form method="POST" action="signUp_insert.php">
    <div style="text-align: center">
        <p>
            <input type="text" name="name" placeholder="ユーザ名" size="20" maxlength="30" />
        </p>
        <p>
            <input type="password" name="password" placeholder="パスワード" size="20" maxlength="30" />
        </p>
        <p>
            <input type="submit" name="submit" value="登録する" />
        </p>
    </div>
</form>

</body>
</html>