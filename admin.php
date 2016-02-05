<?php session_start(); 
header('Content-Type: text/html; charset=UTF-8');
if ((!isset($_SESSION['admin_logged_in']))||(!$_SESSION['admin_logged_in'] == 1)) 
            {echo "<script>location.href='admin_login.php';</script>";
}
$time_plus = time()+100;
$time_plus = (int)$time_plus;
setcookie('id',$_COOKIE['id'],$time_plus);
setcookie('name',$_COOKIE['name'],$time_plus)   ;
                   
date_default_timezone_set('prc');
br();
br();
br();

if (isset($_POST['change_cookie'])) 
            {
    if(connect_sql()){
        $result =  mysql_query("UPDATE nmb_set SET value = $_POST[change_cookie] WHERE item = 'cookies'");
    if($result){
        echo"成功更改cookies!";
    }else{
        echo"更改cookies失败！";
        
    }
    }
}

    if (isset($_POST['change_pass'])) 
            {
    if(connect_sql()){
        $result =  mysql_query("UPDATE nmb_set SET value = $_POST[change_pass] WHERE item = 'admin_pass'");
    if($result){
        echo"成功更改 管理员密码!";
    }else{
        echo"更改 管理员密码 失败！";
        
    }
    }
}

    if (isset($_POST['change_status'])) 
{
        
    if(connect_sql()){
        check_cookie();
        $result = mysql_query("SELECT * FROM nmb_id WHERE id = $_POST[change_status]");
    
        if($result){
            $row = mysql_fetch_array($result);
            if(!$row == null){
        $id_to_change = (float)$_POST['change_status'];
            if($row["status"]== 1){
        
                echo $id_to_change;
        
                $result1 =  mysql_query("UPDATE nmb_id SET status = 0 WHERE id = $id_to_change");
    if($result1){
       				 echo"成功禁言 &nbsp; ".$row['name'];
   						 }else{
      				  echo"禁言&nbsp;".$row['name']." 失败！";
        
    			}
            }else {
                $result1 =  mysql_query("UPDATE nmb_id SET status = 1 WHERE id = $id_to_change");
    if($result1){
       				 echo"成功解禁 &nbsp; ".$row['name'];
   						 }else{
      				  echo"解禁&nbsp;".$row['name']." 失败！";
        
    			}
                
            }
                
            }else{
                
                 echo"删除失败，用户已过期或不存在！";
            }
        }
    }
    }




 show_navi();
function show_navi(){
   echo " <p> <a href='index.php'>主页</a> /管理员页面    </p>";
} 
echo"<h3>留言管理</h3>";
br();
echo " <p>请到具体板块进行管理</p>";
echo "<a href='/board/1.php'>板块1</a></p>";
    br();

    echo"<h3>cookie管理</h3>";
br();
 if(connect_sql()){
        $result = mysql_query("SELECT * FROM nmb_set WHERE item='cookies'");
    if($result){
$row1 = mysql_fetch_array($result);
        $set_cookie = $row1['value'];
          echo" <form action='admin.php' method='post'>
                    <input type = 'text' name='change_cookie' value = $set_cookie>
                    <input type='submit' value='更改' /></form>";

    }else{
        echo"获取结果失败";
        
    }
        
    }else{
        echo"连接数据库失败";
        
    }
				
     echo"<h3>密码管理</h3>";
br();
 if(connect_sql()){
        $result = mysql_query("SELECT * FROM nmb_set WHERE item='admin_pass'");
    if($result){
$row1 = mysql_fetch_array($result);
        $set_admin_pass = $row1['value'];
         echo" <form action='admin.php' method='post'>
                    <input type = 'text' name='change_pass' value = $set_admin_pass>
                    <input type='submit' value='更改' /></form>";
				
    }else{
        echo"获取结果失败";
        
    }
        
    }else{
        echo"连接数据库失败";
        
    }
 
    echo"<h3>用户管理&nbsp;&nbsp;<a href='admin.php'>刷新本页</a></h3>";
br();
 if(connect_sql()){
        $result = mysql_query("SELECT * FROM nmb_id ");
    if($result){
        $no_user = true;
        while($row1 = mysql_fetch_array($result)){
            $no_user = false;
            br();
            echo "ID:".$row1['id'];
                br();
                $res = mysql_query("SELECT * FROM nmb_save WHERE id = $row1[id] order by num desc");
    			if($res){
					$row = mysql_fetch_array($res);
                    if(!$row['board']==null){
                    echo "最后发言：";
                        br();
                    
                    echo "板块：".$row['board'];
                    br();
                    echo "&nbsp;".$row['text'];
                    }else{
                        
                     echo"无最近发言";   
                    }
                }
        
            if($row1["status"]== 1){
                
                echo" <form action='admin.php' method='post'>
                    <input type = 'hidden' name='change_status' value = $row1[id]>
                    <input type='submit' value='禁言' /></form>";
                
            }
            if($row1["status"]== 0){
                
                echo" <form action='admin.php' method='post'>
                    <input type = 'hidden' name='change_status' value = $row1[id]>
                    <input type='submit' value='解禁' /></form>";
                
            }
            
        }
        if($no_user){
            
         
            echo"当前无活跃用户";
        }
            
    }
 }

        
 
function br(){
echo"<br/>";
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

function check_cookie(){
    $current_time = time();
    $current_time = (int) $current_time;
    mysql_query("DELETE FROM nmb_id WHERE time < $current_time");
   
 $res = mysql_query("select * from nmb_id");
    if($res){
        
    $row = mysql_fetch_array($res);
 $numrows = count($row);
    }else{
        $numrows = 0;
    }
    $result = mysql_query("SELECT * FROM nmb_set WHERE item='cookies'");
    if($result){
$row1 = mysql_fetch_array($result);
        $set_cookie = (int)$row1['value'];
    }
    
    if($numrows<$set_cookie){
      
        return true;
        
    } else{
     
        return false;
        
    }

}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>管理员控制台</title>
</head>
<body>
    <br/><br/>
    ----------------------------
</body>
</html>
