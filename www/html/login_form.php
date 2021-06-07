<?php
// ポストかゲットか条件分岐をする。
if(isset($_POST['account']) && isset($_POST['password'])){
	require_once('config.php');

	session_start();
	//DB内でPOSTされたメールアドレスを検索
	try {
	  $pdo = new PDO(DSN, DB_USER, DB_PASS);
	  $stmt = $pdo->prepare('SELECT * FROM m_account WHERE account = ?');
	  $stmt->execute([$_POST['account']]);
	  $row = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (\Exception $e) {
	  echo $e->getMessage() . PHP_EOL;
	}
	//accountがDB内に存在しているか確認
	if (!isset($row['account'])) {
	  echo 'アカウント又はパスワードが間違っています。';
	  return false;
	}
	//パスワード確認後sessionにメールアドレスを渡す
	if (password_verify($_POST['password'], $row['password'])) {
	  session_regenerate_id(true); //session_idを新しく生成し、置き換える
	  $_SESSION['ACCOUNT'] = $row['account'];
	  include('./top.html');
	} else {
	  echo 'アカウント又はパスワードが間違っています。';
	  return false;
	}
} else {
?>
  <!DOCTYPE html>
  <html>
  <head>
   <title>sample</title>
   <meta http-equiv="content-type" charset="UTF-8">
  </head>
  <body>
  <h1>ログインページ</h1>
  <form method="post" action="login_form.php">
  <div>
      <label>アカウント：<label>
      <input type="text" name="account" required>
  </div>
  <div>
      <label>パスワード：<label>
      <input type="password" name="password" required>
  </div>
  <input type="submit" value="ログイン">
  </form>
   <a href="./register_account.php">アカウント登録</a>
  </head>
  </html>
<?php } ?>
