<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login']) == false)
{
print'ようこそゲスト様';
print'<a href="member_login.html">会員ログイン</a><br />';
print'<br />';
}
else
{
print'ようこそ';
print $_SESSION['member_name'];
print '様 ';
print'<a href="member_logout.php">ログアウト</a><br />';
print'<br />';
}
?>

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

if(isset($_SESSION['cart']) == true)
{
    $cart = $_SESSION['cart'];
    $kazu = $_SESSION['kazu'];
    $max=count($cart);    
}
else
{
    $max = 0;
}

if($max == 0)
{
    print 'カートに商品が入っていません。<br />';
    print '<br />';
    print '<a href = "shop_list.php"> 商品一覧に戻る </a>';
    exit();
}

/* デバック　var_dump()←の中身を表示してくれる*/
// var_dump($cart);
// exit();

$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

foreach($cart as $key=>$val)
{
$sql='SELECT code,name,price,gazou FROM mst_product WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[0]=$val;
$stmt->execute($data);

$rec=$stmt->fetch(PDO::FETCH_ASSOC);

$pro_name[]=$rec['name'];
$pro_price[]=$rec['price'];
if($rec['gazou'] == '')
{
    $pro_gazou[]='';
}
else
{
    $pro_gazou[]='<img src="../product/gazou/'.$rec['gazou'].'">';
}

}
$dbh=null;

// for($i=0;$i<$max;$i++)
// {
//     print $pro_name[$i];
//     print $pro_gazou[$i];
//     print $pro_price[$i].'円';
//     print '<br />';
// }

}

catch(Exception $e)
{
print'ただいま障害により大変ご迷惑お掛けしております';
exit();
}
?>

カートの中身<br />
<br />
<?php $AddKazu = 0?>
<form method = "post" action = "kazu_change.php">
<table border = "1">
<tr>
<td>商品</td>
<td>商品画像</td>
<td>価格</td>
<td>数量</td>
<td>小計</td>
<td>削除</td>
</tr>
<?php for($i=0;$i<$max;$i++):?>
    <?php for($i2=0;$i2<$max;$i2++):?>
       <?php if($pro_name[$i2] != $pro_name[$i] &&
                $pro_gazou[$i2] != $pro_gazou[$i] &&
                $pro_price[$i2] != $pro_price[$i]): ?>
            <tr>
            <td> <?php print $pro_name[$i];?> </td>
            <td> <?php print $pro_gazou[$i];?> </td>
            <td> <?php print $pro_price[$i].'円';?> </td>

            <td> <input type="text" name="kazu<?php print $AddKazu;?>" value = "<?php print $kazu[$i];?>"> </td>
            <td> <?php print $pro_price[$i] * (int)$kazu[$i];?>円 </td>
            <td> <input type="checkbox" name = "sakujo<?php print $i;?>"> </td>
            <?php else: ?>
                <?php $AddKazu++?>
        <?php endif ?>
    <?php endfor ?>
<?php endfor ?>

</tr>
</table>
<input type = "hidden" name = "max" value = "<?php print $max;?>">
<input type = "submit" value = "数量変更"><br />
<input type="button"onclick="history.back()"value="戻る">
</form>

<br />
<a href = "shop_form.html">ご購入手続きにへ進む</a><br />
<?php
if(isset($_SESSION["member_login"]) == true)
{
    print '<a href = "shop_kantan_check.php"> 会員簡単注文へ進む</a><br />';
}

?>
</body>
</html>