<?php
ob_start(); session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Examples</title>
<meta name="description" content="">
<meta name="keywords" content="">
<link href="" rel="stylesheet">
</head>
<body>
<?php

if(!isset($_SESSION["memNo"])){

	$_SESSION["where"] = $_SERVER["PHP_SELF"]; //設定來源檔案為此自身檔案
	// echo "尚未登入, 請<a href='sessionLogin.html'>登入</a>";
	//改成跳窗
	echo "<script>alert('尚未登入, 請登入');location.href='sessionLogin.html';</script>";

}else{

	try{
		require_once("connectBooks.php"); 
		//啟用交易管理
		$pdo->beginTransaction();

		// (orderNo, orderMemNo, orderTime, email, payStatus)
		$sql_bo = "insert into bookorder value(null, :orderMemNo, Now(), :email, 0)";
		$statment = $pdo->prepare($sql_bo);
		$statment->bindValue(":orderMemNo", $_SESSION["memNo"]);
		$statment->bindValue(":email", $_SESSION["email"]);
		$statment->execute();


		//(orderNo, productNo, quantity)
		$orderNo = $pdo->lastInsertId();
		$sql_oi = "insert into orderitems value($orderNo, :productNo, :quantity)";
		$statment = $pdo->prepare($sql_oi);

		foreach ( $_SESSION["myarr"] as $i => $cv) {
			$statment->bindValue(":productNo", $cv[0]);
			$statment->bindValue(":quantity", $cv[3]);
			$statment->execute();
		}

	  	//清空購物車
		unset($_SESSION["myarr"]);
		//確認交易
		$pdo->commit();
		echo "<center>下單成功, 您的訂單編號是 : $orderNo</center>";

	}catch(PDOException $ex){

		//放棄交易
		$pdo->rollBack();

		echo "連線失敗,原因:" , $ex->getMessage() ,"<br>";
		echo "行號 : " , $ex->getLine() ,"<br>";
	}

} //end of if/else

?>
<center>
	<a href="sessionCartProdList.php">返回商品列表</a> 
</center> 
</body>
</html>