<?php
require_once 'DbManager.php';
require_once 'Encode.php';
require_once 'bbs2Validator.php';
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>BBS2ログイン</title></head>
<body>
<h1 aligin="center">BBS2ログインページ</h1>
<hr />
<a  href="signUp.php">新規会員登録</a>
<form method="POST" action="login_check.php">
    <div style="text-align: center">
        <p>
            <input type =text name="name" placeholder="ユーザ名" size="20" maxlength="30" />
            <!--<input pattern="^([a-zA-Z0-9]{,20})$"  name="name" placeholder="ユーザ名" size="20" maxlength="30" />-->
        </p>
        <p>
            <input type="password" name="password" placeholder="パスワード" size="20" maxlength="30" />
        </p>
        <p>
            <input type="submit" name="submit" value="ログイン" />
    </div>
</form>
</body>
</html>