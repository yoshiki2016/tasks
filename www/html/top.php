<?php
require_once('config.php');
if(1 == 2){
	// 表示処理を出力
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Top</title>
		<meta http-equiv="content-type" charset="UTF-8">
	</head>
	<body>
		<h1>Top画面</h1>
		<form action="top.php" method="post">
			<div>
				<label>種別<label>
				<input type="list" name="task_type_value">
			</div>
			<div>
				<label>アカウント<label>
				<input type="text" name="account">
			</div>
			<div>
				<label>担当者<label>
				<input type="text" name="worker">
			</div>
			<input type="submit" value="検索">
		</form>
	</body>
	<table>
		<tr>
			<th>sample1</th>
			<td>sample1</td>
			<td>sample1</td>
			<td>sample1</td>
		</tr>
		<tr>
			<th>sample2</th>
			<td>sample2</td>
			<td>sample2</td>
			<td>sample2</td>
		</tr>

		<tr>
			<th>sample3</th>
			<td>sample3</td>
			<td>sample3</td>
			<td>sample3</td>
		</tr>
	</table>
	<a href="./logout.php">ログアウト</a>
	<a href="./task_create.php">タスク登録</a>
	<a href="./task_type_create.php">種別登録</a>
</html>
