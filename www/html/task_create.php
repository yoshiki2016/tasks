<?php
require_once('config.php');
if(isset($_POST['task_name'])){
	try {
		$pdo = new PDO(DSN, DB_USER, DB_PASS);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec(
			"CREATE TABLE IF NOT EXISTS t_task(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			task_type_id VARCHAR(255), 
			account_id VARCHAR(255),
			task_name VARCHAR(30) character set utf8,
			worker_name VARCHAR(30) character set utf8,
			deadline date,
			memo VARCHAR(100) character set utf8,
			created timestamp not null default current_timestamp);"
	);
	} catch (Exception $e) {
		echo $e->getMessage() . PHP_EOL;
	}
	// POSTされたデータを変数に格納	
	$taskTypeId = $_POST['task_type_id'];
	$accountId = $_SESSION['account_id']; // NULLになる理由がわからない。
	$taskName = $_POST['task_name'];
	$workerName = $_POST['worker_name'];
	$deadline = $_POST['deadline'];
	$memo = $_POST['memo'];
	// 登録処理 
	try { 
		$stmt = $pdo->prepare(
			"INSERT INTO 
				t_task(task_type_id, account_id, task_name, worker_name, deadline, memo)
			  VALUES(?, ?, ?, ?, ?, ?);"
		); 
		$stmt->execute([$taskTypeId, $accountId, $taskName, $workerName, $deadline, $memo]); 
		echo '登録完了'; 
	} catch (\Exception $e) { 
		echo '登録出来ませんでした。'; 
	}
} else {
	try {
		$pdo = new PDO(DSN, DB_USER, DB_PASS);
		$query = "SELECT * FROM m_task_type";
		$tasks = $pdo->query($query);
	} catch (Exception $e) {
		echo $e->getMessage() . PHP_EOL;
	}
	foreach($tasks as $task){
		$list .= "<option value='" . $task['id'];
		$list .= "'>" . $task['task_type_value'] . "</option>";
	}
?>
	<html>
		<head>
		<title>タスク登録画面</title>
		<meta http-equiv="content-type" charset="UTF-8">
		</head>
		<body>
		<h1>タスク登録画面</h1>
		<form action="task_create.php" method="post">
		
		<div>
		<label>種別<label>
		<select name="task_type_id">
		<?php echo $list; ?> 
		</select>
		</div>
		
		<div>
		<label>件名<label>
		<input type="text" name="task_name">
		</div>
		
		<div>
		<label>担当者<label>
		<input type="text" name="worker_name">
		</div>

		<div>
		<label>期限<label>
		<input type="date" name="deadline">
		</div>
	
		<div>
		<label>備考欄<label>
		<input type="text" name="memo">
		</div>
		
		<input type="submit" value="登録">
		</form>
		<a href="./top.php">キャンセル</a>
		</body>
	</html>
<?php } ?>
