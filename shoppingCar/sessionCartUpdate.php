<?php
ob_start(); session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Examples</title>

</head>
<body>
<?php

$i = $_REQUEST['index'];

if($_REQUEST['btn']==='modify'){
	//修改
	$_SESSION["myarr"][$i][3] = $_REQUEST['qty'];
}else{
	//刪除
	unset($_SESSION["myarr"][$i]);
}

header('Location:sessionCartShow.php');
?>
</body>
</html>