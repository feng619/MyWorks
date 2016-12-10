<?php
//記得要使用session之前，要先啟用session
ob_start();
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>session</title>

</head>
<body>
<?php
//=====不連資料庫，做測試
// $_SESSION["memId"]=$_REQUEST["memId"];
// $_SESSION["memPsw"]=$_REQUEST["memPsw"];
//echo "<a href='sessionMember.php'>會員專區??</a>";

//=====連資料庫，做測試
try{
	require_once("connectBooks.php");
	$pdo = new PDO($dsn,$user,$psw);
	$sql = "select * from member where memId = :memId and memPsw = :memPsw";
	$member = $pdo->prepare($sql);
	$member -> bindValue(":memId",$_REQUEST["memId"]);
	$member -> bindValue(":memPsw",$_REQUEST["memPsw"]);
	$member -> execute();

	if( $member->rowCount() !=0 ){ //表示資料庫中有對應的登入帳密, 登入成功
	    $memRow = $member->fetch(PDO::FETCH_ASSOC);
		echo $memRow["memName"] , "您好<br>";

		//將會員資料寫入session
		$_SESSION["memId"]=$memRow["memId"];
		$_SESSION["memName"]=$memRow["memName"];
		$_SESSION["memNo"]=$memRow["no"];
		$_SESSION["email"]=$memRow["email"];

		//檢查是否是從別的程式而來, 要讓會員登入後回到原來的程式
		if(isset($_SESSION["where"])){
			$where = $_SESSION["where"];
			unset($_SESSION["where"]);
			header("Location:$where");
		}

		echo "<a href='sessionMember.php'>會員專區</a>";
	}else{
		echo "查無此帳密，請重新登入";
	}
}catch(PDOException $ex){
	echo "資料庫操作失敗,原因：",$ex->getMessage(),"<br>";
	echo "行號：",$ex->getLine(),"<br>";
}
?>	

  
</body>
</html>