<?php session_start(); ?>
<html>
<head>
    <title>Title</title>
 <meta charset = "utf-8">
</head>
<body>
<?php
date_default_timezone_set('prc');
echo "</br>";
echo "</br>";
echo "</br>";


$con = mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
if (!$con)
	{
  die('Could not connect: ' . mysql_error());
	}else{
     	$sjk=mysql_select_db("app_chwdywp1",$con);
  		if(!$sjk){
   		echo "bu cun zai";
  		}else{
          mysql_select_db("app_chwdywp1", $con);
      		mysql_query("CREATE TABLE IF NOT EXISTS nmb_save ( time varchar(30), text varchar(1000))");
      		if (isset($_POST['newmsg'])) 
            {
                $date1 = date("h:i:sa");
                mysql_select_db("app_chwdywp1", $con);
				mysql_query("INSERT INTO nmb_save  VALUES('$date1',' $_POST[newmsg]')");
			}
  			$result1 = mysql_query("SELECT * FROM nmb_save");
            if($result1){
			while($row = mysql_fetch_array($result1))
  			{
  				echo "<br/>"."<br/>"."时间   ".$row['time'] ."<br/>". $row['text']."<br/>"."<br/>"."-------------------------------------------";
  			}
  		}
}
}




echo "<br/>";
echo "<br/>";
echo "<br/>";
$hour=date('G',time()); 
if($hour>=5&&$hour<=12)
{echo("早上好!</br>");}
if($hour>12&&$hour<=17)
{echo("下午好!</br>");}
else
{echo("晚上好!</br>");}
?>
    
    
<form action="nmb.php" method="post">

    <table>
        <tr>
            <td><input type = "text" name="newmsg">
            </td>
            <td><input type="submit" value="Submit" /></td>
            
        </tr>
    </table>



</form>



</body>
</html>
