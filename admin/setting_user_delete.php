<?php 
session_start();
include ("../dbconfig.php");
date_default_timezone_set('Asia/Colombo');
//Create Connection
$con = new mysqli(DB_HOSTNAME,DB_USERNAME, DB_PASSWORD,DB_NAME);
 //check connection
if ($con->connect_error){
            die("Connection fail: " . $con->connect_error);
}
if(!isset($_SESSION['adminSession'])){
        echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
        
}else{


if ($_GET['delete']) {
	
	$userId = $_GET['delete'];


//Notification Delete Users

  function get_trxn_dtl_max()
  { 
    $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
    mysqli_select_db($con, DB_NAME);
    $trxn_dtlmax = mysqli_query($con, "SELECT MAX(`dtl_id`) as max FROM `trxn_dtl`");
    while ($trxn_dtlRow = mysqli_fetch_assoc($trxn_dtlmax)) {

    $trxnDtlid  =  $trxn_dtlRow["max"] + 1;
       
    }
    return $trxnDtlid;
  }

              
    $trxnid     =  $_SESSION['tranxactionId']; 
    $trxnDtlid  = get_trxn_dtl_max();

    

    $trxn_dtl = "INSERT INTO `trxn_dtl`
                                      (`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
                                 VALUES 
                                      ('$trxnDtlid','$trxnid',15,CURRENT_TIMESTAMP)";


    $select = "SELECT  * FROM `user` WHERE `id` = $userId" ;
    $selectQuery = mysqli_query($con, $select);
    $row=mysqli_fetch_assoc($selectQuery);

       
       	$epf_no    = $row['epf_no']; 
       	$username  = $row['username'];
       	$password  = $row['password'];
       	$cateId    = $row['category'];
       	$uLvlId    = $row['user_level'];


    $sql_int = "INSERT INTO  `noti_user`
                            (`user_id`,`trxn_id`,`active_id`,`epf_no`,`username`,`password`,`category`,`user_level`)
                         VALUES
                            ('$userId','$trxnid','$trxnDtlid','$epf_no','$username','$password','$cateId','$uLvlId')";


	$dltQuery = "DELETE FROM `user` WHERE `id` = $userId";


	if($con->query($trxn_dtl)===TRUE AND $con->query($sql_int)===TRUE AND $con->query($dltQuery)===TRUE){

	 echo '<script language="javascript">';
     echo 'alert("User deleted.")';
     echo '</script>';

	echo "<script type='text/javascript'>window.location.href = 'setting.php';</script>";


	}else{

	echo '<script language="javascript">';
 	echo 'alert("User not deleted.")';
    echo '</script>';
    
    echo "<script type='text/javascript'>window.location.href = 'setting.php';</script>";
	}
 }
}
?>