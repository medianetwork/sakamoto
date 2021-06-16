<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<link href="../css/style.css" rel="stylesheet">

<?php
$w1 = new EvTimer(10, 0, function change() {
  header("location: shop_kantan_done.php");
});

?>

<body>
    <div class="content">
        <div class="load-wrapp">
          <div class="load-9">
            <div class="spinner">
              <div class="bubble-1"></div>
              <div class="bubble-2"></div>
              <div class="bubble-3"></div>
              <div class="bubble-4"></div>
              <div class="bubble-5"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="clear"></div>     -->
</body>
</html>


