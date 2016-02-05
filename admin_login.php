<?php session_start(); 
header('Content-Type: text/html; charset=UTF-8');
?>

<html> 

<head> 
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>管理员登陆</title> 

</head>





<body>
<center>
    <br/><br/>
    <hr/>
<form action ="admin_login.php" method = "post">
<br/>
<table border = 0>
    <caption align = "center">  </caption>
	
	<tr>
      

		
          <?php

show_navi();
function show_navi(){
   echo " <p> <a href='index.php'>主页</a> /管理员登陆     </p>";
} 

if (isset($_POST['pass'])) {
    
    if(connect_sql()){
        $result = mysql_query("SELECT * FROM nmb_set WHERE item='admin_pass'");
    if($result){
$row1 = mysql_fetch_array($result);
        $set_pass = $row1['value'];
        
        if($set_pass == $_POST['pass']){
            $_SESSION['admin_logged_in'] = 1;
        }else{
            echo '密码错误';
        }
    }
        
    }
    
}
if (isset($_SESSION['admin_logged_in'])){
    if ($_SESSION['admin_logged_in']==1)
            {echo "<script>location.href='admin.php';</script>";
           br();
             br();
             br();
             echo "<h1>  已登陆，正在跳转中。。。</h1>";
             echo "<script>location.href='admin.php';</script>";
}
}
function connect_sql(){
    $con = mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
if (!$con)
	{
  die('Could not connect: ' . mysql_error());
     return false;
	}else{
     	$sjk=mysql_select_db("app_chwdywp1",$con);
  		if(!$sjk){
   		echo "bu cun zai";
            return false;
  		}else{
          mysql_select_db("app_chwdywp1", $con);
            return true;
        }
}
    
    
}
   
function br(){
echo"<br/>";
}
echo "密码";
?>
		<td>
		<input type="text" name="pass">
		</td>
	</tr>
	<tr align = "center">
		<td>
		<input type="submit" value="提交" >
        </td>
	</tr>
</table>

</form>

</body>

</html>
