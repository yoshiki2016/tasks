<?php
require_once('config.php');
if(isset($_POST['account_id']) && isset($_POST['password'])){
	//データベースへ接続、テーブルがない場合は作成
	try {
		$pdo = new PDO(DSN, DB_USER, DB_PASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec("CREATE TABLE IF NOT EXISTS m_account(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			account_id VARCHAR(30), 
			email VARCHAR(255),
			password VARCHAR(255),
			created timestamp not null default current_timestamp
		);");
	} catch (Exception $e) {
		echo $e->getMessage() . PHP_EOL;
	}
	//POSTのValidate。
	//アカウントの正規表現
	if (!(preg_match('/[a-zA-Z0-9]{8,30}/', $_POST['account_id']))) {
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
	
	$accountId = $_POST['account_id'];
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	
	//登録処理
	try {
		$stmt = $pdo->prepare("INSERT INTO m_account(account_id, email, password) VALUES(?, ?, ?);");
		$stmt->execute([$accountId, $email, $password]);
		echo '登録完了';
	} catch (\Exception $e) {
		echo '登録出来ませんでした。';
	}
} else {
?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>SingUp Page</title>
		<meta http-equiv="content-type" charset="UTF-8">
	</head>
	<body>
		<h1>アカウント登録フォーム</h1>
		<form action="register_account.php" method="post">
			<div>
				<label for="account_id">account_id</label>
				<input type="account_id" name="account_id" required>
			</div>
			<div>
				<label for="email">email</label>
				<input type="email" name="email" required>
			</div>
			<div>
				<label for="password">password</label>
				<input type="password" name="password" required>
				<p>※パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。</p>
			 </div>	 
			<button type="submit">Sign Up!</button>
		</form>
	</html>
<?php } ?>
