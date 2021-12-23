<?php
// ?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>データベース追加画面</title>
</head>

<body>

<?php

try{
require_once('../common/common.php');

$post = sanitize($_POST);
$staff_name = $post['name'];
$staff_pass = $post['pass'];

$dsn = 'mysql:dbname=shop; host = localhost; charset=utf8';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql = 'INSERT INTO mst_staff(name,password) VALUES(?,?)';
$stmt = $dbh->prepare($sql);
$data[] = $staff_name;
$data[] = $staff_pass;
$stmt->execute($data);

$dbh = null;

print $staff_name;
print'さんを追加しました。<br />';
}

catch (Exception $e)
{
print'ただいま障害により大変ご迷惑お掛けしております。';
exit();
}
?>

<a href="staff_list.php">戻る</a>

</body>
</html>