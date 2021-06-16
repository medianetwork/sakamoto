<?php
    session_start();
    session_regenerate_id(true);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ろくまる農園</title>
    <link href="../css/style.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"> 

  </head>
  <body>

    <div class="container">
      <!-- Content here -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">ろくまる農園</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"></a>
              </li>
              <li class="nav-item dropdown">
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"></a>
              </li>
            </ul> -->
            <form class="d-flex">
              <?php
                if(isset($_SESSION['member_login']) == false)
                {
                  print'<div class="welcome-shop">';   
                  print 'ようこそゲスト様';
                  print'<a href="member_login.html" class="btn btn-outline-success">会員ログイン</a>';
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
      </nav>
              
      <?php
      try
      {
        $pro_code=$_GET['procode'];
        $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT name,price,gazou FROM mst_product WHERE code=?';
        $stmt = $dbh->prepare($sql);
        $data[]  = $pro_code;
        $stmt->execute($data);
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        $pro_name=$rec['name'];
        $pro_price=$rec['price'];
        $pro_gazou_name=$rec['gazou'];
        $dbh = null;
        // もし画像ファイルがあれば表示のタグを準備
        if($pro_gazou_name == '')
        {
          $disp_gazou='';
        }
        else
        {
          $disp_gazou='<img src="../product/gazou/'.$pro_gazou_name.'">';
        }
        print'<a href="shop_cartin.php?procode='.$pro_code.'"class="btn btn-primary"><i class="bi bi-cart4"></i>カートに入れる</a><br /><br />';
      }
    
      catch(Exception $e)
      {
      print'ただいま障害により大変ご迷惑お掛けしております';
      exit();
      }
      ?>
        商品情報参照
        <table class="table table-bordered" class="pro_list">
          <tr>
            <th class="text-center">商品コード</th>
            <th class="text-center">商品名</th>
            <th class="text-center">価格</th>
            <th class="text-center">画像</th>
          </tr>
          <tr>
            <td class="align-middle"><?php print $pro_code;?></td>
            <td class="align-middle"><?php print $pro_name; ?></td>
            <td class="align-middle"><?php print $pro_price;?></td>
            <td class="align-middle"><?php print $disp_gazou;?></td>
          </tr>
        </table>
      <br />
      <br />
      <form>
        <input type="button"onclick="history.back()"class="btn btn-primary"value="戻る">
      </form>
    </div>
  </body>
</html>