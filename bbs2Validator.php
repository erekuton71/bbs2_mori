<?php
require_once 'DbManager.php';

class bbs2Validator
{
    //エラーメッセージを格納するためのプライベート変数（配列）
    private $_errors;

    //コンストラクタ
    public function __construct() {
        //プライベート変数$_errorsを初期化
        $_errors = array();
        //$_GET、$_POST、$_COOKIEの文字エンコーディングをチェック
        $this->checkEncoding($_GET);
        $this->checkEncoding($_POST);
        $this->checkEncoding($_COOKIE);

        //$_GET、$_POST、$_COOKIEのNULLバイトをチェック
        $this->checkNull($_GET);
        $this->checkNull($_POST);
        $this->checkNull($_POST);
    }
//postDelete
    //必須検証
    public function postDelete_requiredCheck($value, $name) {
        if (trim($value) === '') {
            $this->_errors[] = "{$name}が入力されていません。";
        }
    }

//editedContents
    //必須検証
    public function editedContents_requiredCheck($value, $name) {
        if (trim($value) === '') {
            $this->_errors[] = "{$name}が入力されていません。";
        }
    }

//contents_insert
    //必須検証
    public function contents_requiredCheck($value, $name) {
        if (trim($value) === '') {
            $this->_errors[] = "{$name}が入力されていません。";
        }
    }

//signUp
    //必須検証
    public function signUp_requiredCheck($value, $word) {
        if (trim($value) === '') {
            $this->_errors[] = "{$word}は必須入力です。";
        }
    }

    //半角英数検証
    public function signUp_alnumTypeCheck($value, $word) {
        if (trim($value) !== '') {
            if (!ctype_alnum($value)) {
                $this->_errors[] = "{$word}は半角英数字で指定してください。";
            }
        }
    }

    //ユーザ名文字列長検証（$len文字以内であるか）
    public function signUp_lengthCheck($value, $word, $len) {
        if (trim($value) !== '') {
            if (mb_strlen($value) > $len) {
                $this->_errors[] = "{$word}は{$len}文字以内で入力してください。";
            }
        }
    }

    //ユーザ名重複検証（データベースの内容と重複していないか）
    public function signUp_duplicateCheck($value, $word, $sql) {
        if (trim($value) !== '') {
            try {
                $db = getDb();
                $stt = $db->prepare($sql);
                $stt->bindValue(':value', $value);
                $stt->execute();
                if (($row = $stt->fetch()) !== FALSE) {
                    $this->_errors[] = "{$word}は既に使われています。他のユーザ名を指定してください。";
                }
            }
            catch (PDOException $e) {
                $this->_errors[] = $e->getMessage();
            }
        }
    }

    //パスワード範囲検証（$min～$maxの範囲にあるか）
    public function signUp_rangeCheck($value, $word, $max, $min) {
        if (trim($value) !== '') {
            if (mb_strlen($value) > $max || mb_strlen($value) < $min) {
                $this->_errors[] = "{$word}は{$min}文字以上～{$max}文字以内で指定してください。";
            }
        }
    }

//loginCheck
    //必須検証
    public function login_requiredCheck($value, $word) {
        if (trim($value) === '') {
            $this->_errors[] = "{$word}が入力されていません。";
        }
    }

//以下はテンプレ
    //配列要素に含まれる文字エンコーディングをチェック
    private function checkEncoding(array $data) {
        foreach ($data as $key => $value) {
            if (preg_match('/\0/', $value)) {
                $this->_errors[] = "{$key}は不正な文字コードです。";
            }
        }
    }

    //配列要素に含まれるNULLバイトをチェック
    private function checkNull(array $data) {
        foreach ($data as $key => $value) {
            if (preg_match('/\0/', $value)) {
                $this->_errors[] = "{$key}は不正な文字を含んでいます。";
            }
        }
    }

    //必須検証
    public function requiredCheck($value, $name) {
        if (trim($value) === '') {
            $this->_errors[] = "{$name}は必須入力です。";

        }
    }

    //文字列長検証（$len文字以内であるか）
    public function lengthCheck($value, $name, $len) {
        if (trim($value) !== '') {
            if (mb_strlen($value) > $len) {
                $this->_errors[] = "{$name}は{$len}文字以内で入力してください。";
            }
        }
    }

    //整数型検証
    public function intTypeCheck($value, $name) {
        if (trim($value) !== '') {
            if (!ctype_digit($value)) {
                $this->_errors[] = "{$name}は数値で指定してください。";
            }
        }
    }

    //整数範囲検証（$min～$maxの範囲にあるか）
    public function rangeCheck($value, $name, $max, $min) {
        if (trim($value) !== '') {
            if ($value > $max || $value < $min) {
                $this->_errors[] = "{$name}は{$min}～{$max}で指定してください。";
            }
        }
    }

    //日付型検証
    public function dateTypeCheck($value, $name) {
        if (trim($value) !== '') {
            $res = preg_split('|(/\-])|', $value);
            if (count($res) !== 3 || !@checkdate($res[1], $res[2], $res[0])) {
                $this->_errors[] = "{$name}は日付形式で入力してください。";
            }
        }

    }

    //正規表現パターン検証（パターン$patternに合致するか）
    public function regexCheck($value, $name, $pattern) {
        if (trim($value) !== '') {
            if (!preg_match($pattern, $value)) {
                $this->_errors[] = "{$name}は正しい形式で入力してください。";
            }
        }

    }

    //配列要素検証（配列$optsの要素のいずれかであるか）
    public function inArrayCheck($value, $word, $opts) {
        if (trim($value) !== '') {
            if (!in_array($value, $opts)) {
                $tmp = implode(',', $opts); //配列要素を連結
                $this->_errors[] = "{$word}は{$tmp}の中から選択してください。";
            }
        }
    }

    //重複検証（データベースの内容と重複していないか）
    public function duplicateCheck($value, $name, $sql) {
        try {
            $db = getDb();
            $stt = $db->prepare($sql);
            $stt->bindValue(':value', $value);
            $stt->execute();
            if (($row = $stt->fetch()) !== FALSE) {
                $this->_errors[] = "{$name}は重複しています。";
            }
        }
        catch (PDOException $e) {
            $this->_errors[] = $e->getMessage();
        }
    }

    //プライベート変数_errorsにエラー情報が含まれる場合にはリスト表示
    public function __invoke() {
        if (count($this->_errors) > 0) {
            print '<ul style="color:Red">';
            foreach ($this->_errors as $err) {
                print "<li>{$err}</li>";
            }
            print '</ul>';
            die();
        }
    }
}
