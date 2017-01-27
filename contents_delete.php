<?php
require_once 'DbManager.php';
require_once 'Encode.php';
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
<head><title>BBS2投稿削除ページ</title></head>
<body>
<h1 aligin="center">BBS2投稿削除ページ</h1>
<a  href="contents_modify.php">BBS2投稿編集ページに戻る</a>

<?php
//入力データの受け取り
$id = $_SESSION["id"];
$user_id = $_SESSION["user_id"];

try {
//データベースへの接続を確立
    $db = getDb();
    $stt = $db->prepare("SELECT * FROM post WHERE id = '$id'");
    $stt->execute();
    $row = $stt->fetch(PDO::FETCH_NAMED);
    if ($user_id == $row['user_id']) {
    } else {
        print '<ul style="color:Red">';
        print "<li>他のユーザの投稿は編集できません。</li>";
        print '</ul>';
        exit;
    }

//結果セットの内容を順に出力
?>
         <div style="text-align: center">
             <p><?php e($row['id']); ?> ユーザ名：<?php e($row['name']); ?>    <?php e($row['datetime']); ?></p>
             <p><?php e($row['contents']); ?></p>
             <form method="post" action="post_delete.php">
                 <p><input type="hidden" name="id" value="<?= $row['id'] ?>"></p>
                 <p><input type="password" name="password" placeholder="パスワードを入力"></p>
                 <p><input type="submit" value="この投稿を削除する"></p>
             </form>
         </div>
<?php
    $db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
?>

</form>
</body>
</html>
