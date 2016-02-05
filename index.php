<?php
    header('Content-Type: text/html; charset=UTF-8');
 session_start(); 
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
      		mysql_query("CREATE TABLE IF NOT EXISTS nmb_save ( num int(30),board int(30),id varchar(30),time varchar(30), text varchar(1000))");
            mysql_query("CREATE TABLE IF NOT EXISTS nmb_id ( id float(30), name varchar(40),status int(30),time int(30))");
            mysql_query("CREATE TABLE IF NOT EXISTS nmb_set ( item varchar(50), value varchar(30))");
            init_set();
            if(isset($_COOKIE['id']))
 			{
                br();br();br();
  				 echo "欢迎回来    ".$_COOKIE['name'];
            }else{
                if( check_cookie()){
                    $new_id =check_id();
                    $new_time = time();
                    $new_name = "user_$new_id";
                    
                    $cookie_expire = $new_time + 36000;
                     mysql_query("INSERT INTO nmb_id  VALUES($new_id,'$new_name',1,$cookie_expire)");
                    setcookie('id',$new_id,$new_time+ 36000);
                     setcookie('name',$new_name,$new_time+ 36000)   ;
                     br();br();br();
                    echo "已获得新身份  &nbsp;&nbsp;  ".$new_name;
                }
            }
        }
            
  		
	}
?>

<body>
    <br/><br/><br/>
<?php





echo "<br/>";
echo "<br/>";
echo "<br/>";
$hour=date('G',time()); 
if($hour>=5&&$hour<=12)
{echo("早上好!</br>");}
else if($hour>12&&$hour<=17)
{echo("下午好!</br>");}
else
{echo("晚上好!</br>");}


function init_set(){
    $con = mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);


 $res = mysql_query("SELECT * FROM nmb_set WHERE item = 'cookies'");
  $row = mysql_fetch_array($res);
    if( $row['value'] == null){
        mysql_query("INSERT INTO nmb_set  VALUES('cookies','20')");
        mysql_query("INSERT INTO nmb_set  VALUES('admin_pass','000')");
        mysql_query("INSERT INTO nmb_set  VALUES('index','0')");
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

function check_id()
{
    $id_ready = time();
    $id_ready = (float)$id_ready;
    
    function generate($id){
    if(connect_sql()){
        
        $result = mysql_query("SELECT * FROM nmb_id WHERE id =$id");
    if($result){
        $row2 = mysql_fetch_array($result);
        if(!$row2['id'] == $id){
            return $id;
        }else{
            $id = $id *10 +1;
         return generate($id);   
        }
    }
        
    }
        
            }
    return generate($id_ready);
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
    
?>
    
    
<p>
    <a href="/board/1.php">板块1</a>      </p>
    <br/>
    <br/>
    
<p>
    <a href="/admin_login.php">管理</a>      </p>

</body> 
