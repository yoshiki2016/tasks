<?php
	require_once('config.php');
	if(!empty($_GET['task_type_id']) || !empty($_GET['task_name']) || !empty($_GET['worker_name'])){
		$pdo = new PDO(DSN, DB_USER, DB_PASS); 
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// 登録処理 
		try {
			// 条件部分を除く,sqlの作成
			$query = "SELECT t_task.*, m_task_type.task_type_value FROM t_task";
			$query .= " LEFT JOIN m_task_type ON t_task.task_type_id = m_task_type.id WHERE 1 = 1";
			if(!empty($_GET['task_type_id'])){
				$query .= " AND task_type_id = " . $_GET['task_type_id'];
			}
			if(!empty($_GET['task_name'])){
				$query .= " AND task_name = " . $_GET['task_name'];
			}
			if(!empty($_GET['worker_name'])){
				$query .= " AND worker_name = " . $_GET['worker_name'];
			}
			$tasks = $pdo->query($query);
		
			// 検索結果を表示するHTMLを作成	
			$taskList = "";
			foreach($tasks as $task){
				$button  =  "<th><p><a href=edit_task.php?task_id=" .$task['id'] .">編集</a>";
				$button .= "<a href=delete_task.php?task_id=" .$task['id'] .">削除</a></p></th>";
				$info   = "<td>" . $task['task_type_value'] . "<td>";
				$info  .= "<td>" . $task['task_name'] . "<td>";
				$info  .= "<td>" . $task['worker_name'] . "<td>";
				$taskList .= "<tr>" . $button . $info . "<tr>"; 
			}
			} catch (\Exception $e) {
				echo '表示出来ませんでした。';
		}
	}
try {
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $query = "SELECT * FROM m_task_type";
  $tasks = $pdo->query($query); 
} catch (Exception $e) { echo $e->getMessage() . PHP_EOL;
} 
foreach($tasks as $task){
  $list .= "<option value='" . $task['id'];
  $list .= "'>" . $task['task_type_value'] . "</option>";
} 
?>
<html>
	<head>
		<title>Top</title>
		<meta http-equiv="content-type" charset="UTF-8">
	</head>
	<body>
		<h1>Top画面</h1>
		<form action="top.php" method="get">
			<div>
				<label>種別<label>
				<select name="task_type_id">
					<?php echo $list; ?>
				</select>
			</div>
			<div>
				<label>タスク名<label>
				<input type="text" name="task_name">
			</div>
			<div>
				<label>担当者<label>
				<input type="text" name="worker_name">
			</div>
			<input type="submit" value="検索">
		</form>
		<table border="1">
			<tr><th>編集削除</th><td>種別</td><td>件名</td><td>担当</td></tr>
			<?php echo $taskList; ?>	
		</table>
		<a href="./logout.php">ログアウト</a>
		<a href="./task_create.php">タスク登録</a>
		<a href="./task_type_create.php">種別登録</a>
	</body>
</html>
