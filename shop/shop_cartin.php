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
    $pro_code=$_GET['procode'];

    if(isset($_SESSION['cart']) == true)
    {
        $cart = $_SESSION['cart'];
        $kazu = $_SESSION['kazu'];
        if(in_array($pro_code, $cart) == true)
        {
            print 'その商品はすでにカートに入っています。<br />';
            print '<a href = "shop_list.php" class="btn btn-primary> 商品一覧に戻る</a>';
            exit();
        }
    }
    
    $cart[] = $pro_code;
    $kazu[] = 1;
    $_SESSION['cart'] = $cart;
    $_SESSION['kazu'] = $kazu;
}

catch(Exception $e)
{
print'ただいま障害により大変ご迷惑お掛けしております';
exit();
}
?>


カートに追加しました<br />
<br />
<a href="shop_list.php">商品一覧に戻る</a>

</body>
</html>