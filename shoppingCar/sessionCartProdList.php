<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>query</title>
<style type="text/css">
  a {text-decoration:none;
  }
  a:hover{text-decoration:underline;}
</style>
</head>
<body>

<center>
  <a href="sessionCartShow.php">檢視購物車</a> 
</center>  

<table border="1" cellspacing="0" align="center" width="600">
<tr bgcolor="#bfbfef">
		<th>書號</th>
		<th>書名</th>
		<th>價格</th>
		<th>作者</th>
    <th>圖片</th>
    <th>放入購物車</th>
</tr>	
<?php
try{
  require_once("connectBooks.php");  
  $sql = "select * from products";
  $products = $pdo->query( $sql );
  
  while($prodRow = $products->fetch( PDO::FETCH_ASSOC) ){
?>
  <form action="sessionCartAdd.php" method="post">
  <input type="hidden" name="psn" value="<?php echo $prodRow["psn"] ?>">
  <input type="hidden" name="pname" value="<?php echo $prodRow["pname"] ?>">
  <input type="hidden" name="price" value="<?php echo $prodRow["price"] ?>">
  <tr>	
  	<td> <?php echo $prodRow["psn"] ?></td>
    <td> <?php echo $prodRow["pname"] ?></td>
    <td> <?php echo $prodRow["price"] ?></td>
    <td> <?php echo $prodRow["author"] ?></td>
    <td><img src="<?php echo 'images/'.$prodRow["image"] ?>"></td>
    <td><input type="submit" value="送出"></td>
  </tr>
  </form>
<?php    
  }

}catch(PDOException $ex){
  echo "連線失敗,原因:" , $ex->getMessage() ,"<br>";
  echo "行號 : " , $ex->getLine() ,"<br>";
}  

?>  
</table>  
</body>
</html>