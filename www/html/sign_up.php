<?php
require_once('config.php');
//データベースへ接続、テーブルがない場合は作成
try {
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec("CREATE TABLE IF NOT EXISTS m_account(
      id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      account VARCHAR(30), 
      email VARCHAR(255),
      password VARCHAR(255),
      created timestamp not null default current_timestamp
    );");

} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
//POSTのValidate。
//アカウントの正規表現
if (!(preg_match('/[a-zA-Z0-9]{8,30}/', $_POST['account']))) {
  echo 'アカウント名は半角英数と-または_で8文字以上30文字以下になるように設定してください。';
  return false;
}


if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  return false;
}

//パスワードの正規表現
if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
} else {
  echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
  return false;
}

$account = $_POST['account'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

//登録処理
try {
  $stmt = $pdo->prepare("INSERT INTO m_account(account, email, password) VALUES(?, ?, ?);");
  $stmt->execute([$account, $email, $password]);
  echo '登録完了';
} catch (\Exception $e) {
  echo '登録済みのメールアドレスです。';
}
