<?php
ob_start(); session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Examples</title>
<style type="text/css">
  a {text-decoration:none;
  }
  a:hover{text-decoration:underline;}
</style>
</head>
<body>
<?php

	$repeat = false;

	$arrlength = count($_SESSION["myarr"]);
	for ($i=0; $i < $arrlength; $i++) { //檢查選取的商品是不是已經存在於購物車當中
		if($_SESSION['myarr'][$i][0] == $_REQUEST['psn']){
			$repeat = true;
		}
	}

	if(!$repeat){ //不是重複購入的商品才能加入到購物車
		$arr = array($_REQUEST['psn'], $_REQUEST['pname'], $_REQUEST['price'], 1);
	    $_SESSION['myarr'][] = $arr;		
	}

    header('Location:sessionCartShow.php');
    
?>
</body>
</html>