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
if (isset($_POST['newmsg'])) {
    if(isset($_SESSION['msg'])) {
$_SESSION['msg'] =  $_SESSION['msg']."<br/>"."时间".date("h:i:sa")."<br/>".$_POST['newmsg']."<br/>"."-------------------------------------------";
}else{
        $_SESSION['msg'] =  "-------------------------------------------"."<br/>"."时间".date("h:i:sa")."<br/>".$_POST['newmsg']."<br/>"."-------------------------------------------";
}
    
    echo $_SESSION['msg'];

}
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
