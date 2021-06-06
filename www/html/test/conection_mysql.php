<?php
//DBを選択してコネクト
$link = new mysqli("db" , "root" , "secret" , "task_db"); // IP,USERID,PASSWORD,DB_NAME
if ($link->connect_error){
 $sql_error = $link->connect_error;
 error_log($sql_error);
 die($sql_error);
} else {
 $link->set_charset("SJIS");
 echo "connect and use success!<br>";
}

echo 'm_accountのデータをすべて出力します。';
$result = mysql_query('SELECT * FROM m_account');
if (!$result) {
    die('クエリーが失敗しました。'.mysql_error());
}

mysql_close($link);
