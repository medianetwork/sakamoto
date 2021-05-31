<?php
session_start();
session_regenerate_id(true);
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
    require_once('../common/common.php');

    $post = sanitize($_POST);

    $onamae = $post['onamae'];
    $email  = $post['email'];
    $postal1 = $post['postal1'];
    $postal2 = $post['postal2'];
    $address = $post['address'];
    $tel = $post['tel'];

    // 注文後に画面に表示する処理
    print $onamae.'様<br />';
    print 'ご注文ありがとうございました。<br />';
    print $email.'にメールを送りましたのでご確認ください。<br />';
    print '商品は以下の住所に発送させていただきます<br />';
    print $postal1.'-'.$postal2.'<br />';
    print $address.'<br />';
    print $tel.'<br />';

    // 注文客に送信するメールを送信する処理
    $honbun = '';
    $honbun .= $onamae."様\n\nこの度はご注文ありがとうございました。\n";
    $honbun .= "\n";
    $honbun .= "ご注文商品\n";
    $honbun .= "--------------\n";

    $cart = $_SESSION['cart'];
    $kazu = $_SESSION['kazu'];
    $max = count($cart);

    $dsn = 'mysql:dbname = shop; host = localhost;charset = utf8';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    for($i = 0; $i < $max; $i++)
    {
        $sql = 'SELECT name, price FROM mst_product WHERE code = ?';
        $stmt = $dbh->prepare($sql);
        $data[0] = $cart[$i];
        $stmt->execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $rec['name'];
        $price = $rec['price'];
        $kakaku[] = $price;
        $suryo = $kazu[$i];
        $shokei = $price * $suryo;

        $honbun .= $name.'';
        $honbun .= $price.'円 x ';
        $honbun .= $suryo.'個 = ';
        $honbun .= $shokei."円\n";
    }

    // 注文データをデータベースに追加する処理
    $sql = 'INSERT INTO dat_salses(code_member, name, email, postal1, postal2, address, tel) VALUES(?,?,?,?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    $data = array();
    $data[] = 0;
    $data[] = $onamae;
    $data[] = $email;
    $data[] = $postal1;
    $data[] = $postal2;
    $data[] = $address;
    $data[] = $tel;
    $stmt->execute($data);

    $sql = 'SELECT LAST_INSERT_ID()';
    $stmt->execute();
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $lastcode = $rec['LAST_INSERT_ID()'];

    for($i = 0; $i < $max; $i++)
    {
        $sql = 'INSERT INTO dat_product(code_sales, code_product, price, quantity) VALUES (?,?,?,?)';
        $stmt = $dbh->prepare($sql);
        $data = array();
        $data[] = $lastcode;
        $data[] = $cart[$i];
        $data[] = $kakaku[$i];
        $data[] = $kazu[$i];
        $stmt->execute($data);
    }
    $dbh = null;

    $honbun .= "送料は無料です。\n";
    $honbun .= "---------------\n";
    $honbun .= "\n";
    $honbun .= "代金は以下の口座にお振込みください。\n";
    $honbun .= "ろくまる銀行　やさい支店　普通銀行　1234567\n";
    $honbun .= "入金確認が取れ次第、梱包、発送させていただきます";
    $honbun .= "\n";
    $honbun .= "□□□□□□□□□□□□□□□□□□□□□□□□□□□□□\n";
    $honbun .= " ～安心野菜のろくまる農園～";
    $honbun .= "\n";
    $honbun .= "〇〇県六丸郡六丸村123-4\n";
    $honbun .= "電話 090-6060-xxxx\n";
    $honbun .= "メール info@rokumarunouen.co.jp\n";
    $honbun .= "□□□□□□□□□□□□□□□□□□□□□□□□□□□□□\n";
    // print nl2br($honbun);


    // お客様へメールを送る
    $title = 'ご注文ありがとうございます。';
    $header = 'From: info@rokumarunouen.co.jp';
    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
    mb_language('japanese');
    mb_internal_encording('UTF-8');
    // メール送信の命令
    mb_send_mail($email, $title, $honbun, $header);

    // お見せ側にメールを送る
    $title = 'ご注文がありました。';
    $header = 'From: '.$email;
    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
    mb_language('japanese');
    mb_internal_encording('UTF-8');
    // メール送信の命令
    mb_send_mail('info@rokumarunouen.co.jp', $title, $honbun, $header);

}
catch(Exception $e)
{
    print 'ただいま障害発生により大変ご迷惑お掛けしております。';
    exit();
}
?>
</body>
</html>