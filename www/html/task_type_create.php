<?php
$taskTypeValue = $_POST['task_type_value'];
if(isset($taskTypeValue)){
	require_once('config.php');
	//データベースへ接続、テーブルがない場合は作成
	try {
		$pdo = new PDO(DSN, DB_USER, DB_PASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec("
			 CREATE TABLE IF NOT EXISTS m_task_type(
			 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			 task_type_value VARCHAR(20)
		);");

	} catch (Exception $e) {
		echo $e->getMessage() . PHP_EOL;
	}
	//登録処理
	try {
		$stmt = $pdo->prepare("INSERT INTO m_task_type(task_type_value) VALUES(?);");
		$stmt->execute([$taskTypeValue]);
		echo '種別登録完了';
		require('./top.php');
	} catch (\Exception $e) {
		echo '種別が登録出来ませんでした。';
	}
} else {
?>
	<!DOCTYPE html>
	<html>
		<head>
			<title>種別登録画面</title>
			<meta http-equiv="content-type" charset="UTF-8">
			</head>
			<body>
			<h1>種別登録画面</h1>
			<form action="task_type_create.php" method="post">
			<div>
				<label>種別<label>
				<input type="text" name="task_type_value" required>
			</div>
			<input type="submit" value="登録">
			</form>
			<a href="./top.php">キャンセル</a>
		</head>
	</html>
<?php } ?>
