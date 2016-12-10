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
<table border="1" cellspacing="0" align="center" width="600">
	<tr bgcolor="#bfbfef">
		<th>書號</th>
		<th>書名</th>
		<th>價格</th>
		<th>數量</th>
		<th>小計</th>
		<th>異動</th>
	</tr>

	<?php 
	$total = 0; //總金額

	if(isset($_SESSION["myarr"])){ //購物車有資料才跑這段程式
		
		foreach ($_SESSION["myarr"] as $i => $cv) {
	?> 

			<form action="sessionCartUpdate.php" method="get">
			<input type="hidden" name="psn" value="<?php echo $cv[0] ?>">
			<input type="hidden" name="index" value="<?php echo $i ?>"> <!--這筆資料的$i-->
			<tr>	
			  	<td> <?php echo $cv[0] ?></td> <!--'psn'-->
			    <td> <?php echo $cv[1] ?></td> <!--'pname'-->
			    <td> <?php echo $cv[2] ?></td> <!--'price'-->
			    <td> <input type="text" name="qty" value="<?php echo $cv[3] ?>"></td><!--'qty'-->
			    <td> <?php echo $cv[2]*$cv[3] ?></td> <!--小計-->

			    <td>
				    <button type="submit" name="btn" value="modify">修改</button>
				    <button type="submit" name="btn" value="delete">刪除</button>  
			    </td>
			</tr>
			</form>
	<?php
			$total += $cv[2] * $cv[3]; //price*qty
		} //end of foreach
	} //end of if
	?>
	<tr><td colspan="6" align="center">總金額 : <?php echo number_format($total,1) ?></td></tr>

</table>
<center>
	<a href="sessionCartProdList.php">繼續購物</a>
	<?php
	if(isset($_SESSION["myarr"]) && count($_SESSION["myarr"])>0 ){
		echo "<a href='sessionCartToDb.php'>下單</a>";
	}
	?>
</center>  
</body>
</html>