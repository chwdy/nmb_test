<?php session_start(); 

date_default_timezone_set('prc');

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
            if (isset($_POST['delete'])) 
            {
                ////////////////////////////////////////////////\\\
                $num = (float)$_POST['delete'];
                $_POST['delete'] = null;
                mysql_query("DELETE FROM nmb_save WHERE num = $num");
                //删除功能占坑
                
                
                ///////////////////////////////////////
            }
      		if (isset($_POST['newmsg'])) 
            {
                
                $date1 = date("Y/m/d h:i:s a");
                mysql_select_db("app_chwdywp1", $con);
               if(isset($_COOKIE['id']))
 			{
                   $time_plus = time()+36000;
                   $time_plus = (int)$time_plus;
                   setcookie('id',$_COOKIE['id'],$time_plus,'/../');
                   setcookie('name',$_COOKIE['name'],$time_plus,'/../')   ;
                   
                   $index = check_row() +1;
                   $index = (int)$index;
                   
                   if(get_status() == 1){
                       if (isset($_POST['time'])) 
                       {
                           if ($_POST["time"] != $_SESSION["time"]){
                           mysql_query("INSERT INTO nmb_save  VALUES($index,1,'$_COOKIE[id]','$date1','$_POST[newmsg]')");
                              mysql_query("UPDATE nmb_set SET value = '$index' WHERE item = 'index'");
    
                               $_SESSION["time"] = $_POST['time'];
                           }else{
                               
                           }
                       }
                   $_POST['msg'] = null;
                   }else{
                   br();br();br();
                   echo'不能发言！！！！！！！！！！！！！！！！！！！！！';br();
                   echo'因为&nbsp;&nbsp;当前身份被禁言';
                   br();
                   echo"<p>请与管理员联系，或过一段时间再登陆</p>";
                   }
                   
				 mysql_query("UPDATE nmb_id SET time = $time_plus WHERE id = '$_COOKIE[id]'");
                   
               }else{
                   br();br();br();
                   echo'不能发言！！！！！！！！！！！！！！！！！！！！！';br();
                   echo'因为&nbsp;&nbsp;没有身份';
                   br();
                   echo"<p>请<a href='../index.php'>返回主页</a>获取新的身份</p>";
    br();
               }
			}
  			
  		}
}



if(isset($_COOKIE['id']))
 			{
    br();br();br();
  				 echo "welcome back &nbsp; &nbsp; ".$_COOKIE['name'];
    br();
}else{
    
    br();br();br();
  				 echo "以 游客 身份浏览 ".$_COOKIE['name'];
    br();
}





show_navi();
show_time();
br();
show_current_id();
show_input();
show_all_msg();

function get_status(){
    $stat = (float)$_COOKIE['id'];
    $res = mysql_query("SELECT * FROM nmb_id WHERE id = $stat");
    if($res){
$row1 = mysql_fetch_array($res);
        $stat= (int)$row1['status'];
        return $stat;
    }
}
function check_row(){
    
    $res = mysql_query("SELECT * FROM nmb_set WHERE item = 'index'");
    if($res){
$row1 = mysql_fetch_array($res);
        $numrows= (int)$row1['value'];
        
    return $numrows;
    }
}

function show_navi(){
   echo " <p> <a href='../index.php'>主页</a> /板块1     </p>";
} 

function show_time(){
$hour=date('G',time()); 
if($hour>=5&&$hour<=12)
{echo("早上好!</br>");}
else if($hour>12&&$hour<=17)
{echo("下午好!</br>");}
else
{echo("晚上好!</br>");}  
}

function br(){
echo"<br/>";
}

function show_current_id(){
if(isset($_COOKIE['id']))
{echo '当前 &nbsp; ID:'.$_COOKIE['id'];
}
 if(isset($_SESSION['admin_logged_in'])&& $_SESSION['admin_logged_in'] ==1){
                  echo "   &nbsp; 以管理员身份浏览&nbsp;&nbsp;";
                  echo " <a href='../admin_login.php'>管理员控制台</a> </p>";
                }
}

function show_input(){
    $thistime = time();
   echo" <br/>
<form action='1.php' method='post'>
<input type = 'hidden' name='time' value = $thistime >
    <table>
        <tr>
            <td>输入留言</td>
            <td><input type = 'text' name='newmsg'></td>
            <td><input type='submit' value='Submit' /></td>
        </tr>
    </table></form>
--------------------------------------------------------
";
}

function show_all_msg(){
    
$result1 = mysql_query("SELECT * FROM nmb_save WHERE board = 1 order by num desc");
            if($result1){
			while($row = mysql_fetch_array($result1))
  			{
                br();br();
                if(isset($_SESSION['admin_logged_in'])&& $_SESSION['admin_logged_in'] ==1){
                  echo" 发言编号:".$row['num'];
                 br();
                    
                }
                echo" ID:".$row['id'];
                    if($row['id']== $_COOKIE['id']){
                    echo "（自己）";
                }
                    
                    
                    echo"&nbsp;&nbsp; &nbsp; &nbsp; ".$row['time'] ."<br/>"."<br/>". $row['text'];
                
                if(isset($_SESSION['admin_logged_in'])&& $_SESSION['admin_logged_in'] ==1){
                    echo" <form action='1.php' method='post'>
                    <input type = 'hidden' name='delete' value = $row[num]>
                    <input type='submit' value='删除' /></form>";
				}
                echo "<br/>"."<br/>"."_____________________________________";
  			}
            }
}


?>
   <html>
<head>
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>板块1</title>
</head>
 
<body>
</body>
</html> 
