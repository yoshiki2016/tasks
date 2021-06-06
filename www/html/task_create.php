<?php
header("Content-type: text/html; charset=utf-8");
require_once('config.php');
try {
  $pdo = new PDO(DSN, DB_USER, DB_PASS);
  $query = "SELECT * FROM m_task_type";
  $tasks = $pdo->query($query);
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
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
<?php foreach($tasks as $task){
     $html .= "<option value'" . $task['id'];
     $html .= "'>" . $task['task_type_value'] . "</option>";
} ?>
    <label>種別<label>
    <select name="task_type_value">
    <?php echo $html; ?> 
    </select>
</div>

<div>
    <label>件名<label>
    <input type="text" name="task_name">
</div>

<div>
    <label>担当者<label>
    <input type="text" name="worker">
</div>

<div>
    <label>備考欄<label>
    <input type="text" name="memo">
</div>

<input type="submit" value="登録">
</form>
 <a href="./top.html">キャンセル</a>
</head>
</html>
