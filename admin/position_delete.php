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


if($_GET['delete']){

	$posId = $_GET['delete'];



   //Select Postion Name.
    if($posId==0){
        $posNa   = "";

    }else{

       $posSQL   = "SELECT * FROM `position` WHERE `position_id` = $posId";
       $posQuery = mysqli_query($con, $posSQL);
       $posRow   = mysqli_fetch_assoc($posQuery);
       $posNa    = $posRow['position'];
       
   }


	 //Notification Delete Position

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
                                    (`dtl_id`, `trxn_id`, `type`, `trxn_date`, `description`) 
                               VALUES 
                                    ('$trxnDtlid','$trxnid',17,CURRENT_TIMESTAMP,'$posNa')";


	$dltQuery = "DELETE FROM `position` WHERE `position_id` = '$posId' ";


	if($con->query($trxn_dtl)===TRUE AND $con->query($dltQuery)===TRUE){

	    echo '<script language="javascript">';
      echo 'alert("Position Deleted.")';
      echo '</script>';
	    echo "<script type='text/javascript'>window.location.href = 'position_manage.php';</script>";

     	}
     	else
     	{
     	echo '<script language="javascript">';
      echo 'alert("Position not Deleted.")';
      echo '</script>';
		  echo "<script type='text/javascript'>window.location.href = 'position_manage.php';</script>";
     	}

}
}
 ?>