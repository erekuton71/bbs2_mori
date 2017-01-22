<?php
require_once 'Auth.php';

//認証フォーム呼び出しのためのユーザ定義巻子
function myLogin($usr, $status) {
    //エラーメッセージ（の候補）を連想配列で準備
    $errs = array(
        AUTH_IDLED => 'アイドル時間を超えています。再ログインしてください。',
        AUTH_EXPIRED => '期限切れです。再ログインしてください。',
        AUTH_WRONG_LOGIN => 'ユーザ/パスワードが誤っています。'
    );
    //認証フォームを呼び出し
    require_once 'login.php';
}

//Authクラスのインスタンス化
$auth = new Auth('MDB2',
    array(
        'dsn => '
    ));

