<?php
require_once('config.php');
$taskTypeId = '';
$selectedTaskTypeId = '';
$taskDisp = '';
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
	// 更新処理 
	try { 
		$stmt = $pdo->prepare(
			"INSERT INTO 
				t_task(task_type_id, account_id, task_name, worker_name, deadline, memo)
				VALUES(?, ?, ?, ?, ?, ?);"
		); 
		$stmt->execute([$taskTypeId, $accountId, $taskName, $workerName, $deadline, $memo]);
		echo '更新完了';
	} catch (\Exception $e) {
		echo '更新出来ませんでした。';
	} 
}
elseif(!empty($_GET['task_id'])){
	echo "編集作業を開始します。<br />";
	require_once('config.php');
	$pdo = new PDO(DSN, DB_USER, DB_PASS);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// 登録処理 
	try {
		// 条件部分を除く,sqlの作成
		$query = "SELECT t_task.*, m_task_type.task_type_value FROM t_task";
		$query .= " LEFT JOIN m_task_type ON t_task.task_type_id = m_task_type.id WHERE 1 = 1";
		$query .= " AND t_task.id = " . $_GET['task_id'];	
		$taskDisp = $pdo->query($query);
		$taskDisp = $taskDisp->fetch(PDO::FETCH_ASSOC);
		$selectedTaskTypeId = $taskDisp['task_type_id'];	
	} catch (\Exception $e) {
		echo '表示出来ませんでした。';
	}
}
else{
	echo "なにもしません";
}
try {
	$pdo = new PDO(DSN, DB_USER, DB_PASS);
	$query = "SELECT * FROM m_task_type";
	$taskTypes = $pdo->query($query);
} catch (Exception $e) {
	echo $e->getMessage() . PHP_EOL;
}
// プルダウンの初期値を設定する。
foreach($taskTypes as $task){
	$list .= "<option value='" . $task['id'] . "'";
	$selectedTaskTypeId == $task['id'] ? $list .= " selected" : "";	
	$list .= ">" . $task['task_type_value'] . "</option>";
}
//
//die;
?>
	<html>
		<head>
		<title>タスク編集画面</title>
		<meta http-equiv="content-type" charset="UTF-8">
		</head>
		<body>
		<h1>タスク編集画面</h1>
		<form action="task_create.php" method="post">

		<div>
		<label>種別<label>
		<select name="task_type_id">
		<?php echo $list; ?>
		</select>
		</div>

		<div>
		<label>件名<label>
		<input type="text" name="task_name" value="<?php echo !empty($taskDisp['task_name']) ? $taskDisp['task_name'] : ''; ?>">
		</div>

		<div>
		<label>担当者<label>
		<input type="text" name="worker_name" value="<?php echo !empty($taskDisp['worker_name']) ? $taskDisp['worker_name'] : ''; ?>">
		</div>

		<div>
		<label>期限<label>
		<input type="text" name="deadline" value="<?php echo !empty($taskDisp['deadline']) ? $taskDisp['deadline'] : ''; ?>">
		</div>

		<div>
		<label>備考欄<label>
		<input type="text" name="memo" value="<?php echo !empty($taskDisp['memo']) ? $taskDisp['memo'] : ''; ?>">
		</div>

		<input type="submit" value="更新">
		</form>
		<a href="./top.php">キャンセル</a>
		</body>
	</html>
