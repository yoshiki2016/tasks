<?php
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
//POSTのValidate。
//種別の正規表現
//20文字以下なっていること。
//if (!preg_match('日本語の正規表現', $_POST['task_type_value'])){
//  echo '種別は20文字以内で入力してください';
//  return false;
//}
$taskTypeValue = $_POST['task_type_value'];
//登録処理
try {
  $stmt = $pdo->prepare("INSERT INTO m_task_type(task_type_value) VALUES(?);");
  $stmt->execute([$taskTypeValue]);
  echo '種別登録完了';
} catch (\Exception $e) {
  echo '種別が登録出来ませんでした。';
}
