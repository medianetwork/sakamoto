<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<body>
<?php

try
{


$pro_code = $_GET['procode'];

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'SELECT name,price FROM mst_product WHERE code=?';
$stmt = $dbh->prepare($sql);
$data[]  = $pro_code;
$stmt->execute($data);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);
$pro_name=$rec['name'];
$pro_price=$rec['price'];

$dbh = null;

}

catch(Exception $e)
{
print'ただいま障害により大変ご迷惑お掛けしております';
exit();
}
?>

商品修正<br />
<br />
スタッフコード<br />
<?php print $staff_code;?>
<br />
<br />
<form method="post" action="staff_edit_check.php">
<input type="hidden" name="code" value="<?php print $staff_code;?>">
スタッフ名<br />
<input type="text"name="name"style="width:200px" value="<?php print $staff_name; ?>"><br />

パスワードを入力してください。<br />
<input type="password" name="pass" style="width:100px"><br />
パスワードをもう一度入力してください。<br />
<input type="password" name="pass2" style="width:100px"><br />

<br />
<input type="button"onclick="history.back()"value="戻る">
<input type="submit" value="OK">
</form>

</body>
</html>