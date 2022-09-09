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
if(!isset($_SESSION["adminSession"])){
        echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
        
}else{
  

if($_GET['delete']){

	$trxnID = $_GET['delete']; 


	$noti_user = "DELETE FROM `noti_user` WHERE `trxn_id` = '$trxnID' ";
	mysqli_query($con, $noti_user);

	$noti_news = "DELETE FROM `noti_news` WHERE `trxn_id` = '$trxnID' ";
	mysqli_query($con, $noti_news);

	$noti_skill = "DELETE FROM `noti_skill` WHERE `trxn_id` = '$trxnID' ";
	mysqli_query($con, $noti_skill); 

	$noti_employee = "DELETE FROM `noti_employee` WHERE `trxn_id` = '$trxnID' ";
	mysqli_query($con, $noti_employee);

	$trxn_dtl = "DELETE FROM `trxn_dtl` WHERE `trxn_id` = '$trxnID' ";
	mysqli_query($con, $trxn_dtl);

	$trxn = "DELETE FROM `trxn` WHERE `trxn_id` = '$trxnID' ";
	mysqli_query($con, $trxn);
	
	echo "<script type='text/javascript'>window.location.href = 'manage_notification.php';</script>";
	
		

}
}

 ?>