<?php 

if(isset($_POST['disp']) == true)
{

if(isset($_POST['procode']) == false)
{
header('Location: pro_ng.php');
exit();
}

$pro_code = $_POST['procode'];
header('Location: pro_disp.php?procode'.$pro_code);
}



if(isset($_POST['add']) == true)
{

header('Location:pro_add.php');
exit();
}



if(isset($_POST['edit']) == true)
{

if(isset($_POST['procode']) == false)
{

header('Location:pro_ng.php');
exit();
}

$staff_code = $_POST['procode'];
header('Location:pro_edit.php?procode='.$pro_code);
//header('Location:staff_edit.php');
exit();
}



if(isset($_POST['delete']) == true)
{

if(isset($_POST['procode']) == false)
{

header('Location:pro_ng.php');
exit();
}

$staff_code = $_POST['procode'];
header('Location:pro_delete.php?procode='.$pro_code);
exit();
}



?>
