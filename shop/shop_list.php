<?php
    session_start();
    session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>商品リスト</title>

<link href="../css/style.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"> 

</head>
<body>

<div class="container">
  <!-- Content here -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
     
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <form class="d-flex">
            <?php
              if(isset($_SESSION['member_login']) == false)
              {
                print'<div class="welcome-shop">';   
                print '<p class="text-right">ようこそゲスト様</p>';
                print'<a href="member_login.html" class="btn btn-outline-success" class="text-right">会員ログイン</a>';
                print'</div>';
              }
              else
              {
                // print'<div class="alert alert-dark" role="alert">ようこそ';
                print 'ようこそ';
                print $_SESSION['member_name'];
                // print '様</div>';
                print '様';
                print'<a href="member_logout.php" class="btn btn-outline-success">ログアウト</a>';
              }
            ?>
          </form>
        </div>
      </div>
    </ul>
    
  </nav>


    <?php


    try
    {

    $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
    $user='root';
    $password='';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT code,name,price FROM mst_product WHERE 1';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;

    print "商品一覧";

    print'<div class="list-group">';
        while(true)
        {

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            if($rec == false)
            {
                break;
            }

            print'<a href="shop_product.php?procode='.$rec['code'].'" class="list-group-item list-group-item-action">';
            print $rec['name'].'';
            print $rec['price'].'円';
            print '</a>';
        }
    print '</div>';

    print '<br />';
    print '<a href="shop_cartlook.php" class="btn btn-primary"><i class="bi bi-cart4"></i>カートを見る</a><br />';

    }

    catch(Exception $e)
    {
    print'ただいま障害により大変ご迷惑お掛けしております。';
    exit();
    }

    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>