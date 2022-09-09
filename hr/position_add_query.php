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
if(!isset($_SESSION['hrSession'])){
        echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
        
}else{
 
 

if(isset($_POST['submit']))
{
	$position  = $_POST['position'];




    // sql statment  fot validate duplicate value

    $sqlchek = "SELECT `position` FROM `position` WHERE `position` = '$position' ";
    $chek    = mysqli_query($con, $sqlchek);
    $chekrow = mysqli_fetch_assoc($chek);

    $chckptin  =  $chekrow['position'];

  
    if($chckptin==$_POST['position']){


        echo '<script language="javascript">';
        echo 'alert("Already this position inserted.")';
        echo '</script>';

        echo "<script type='text/javascript'>window.location.href = 'position_manage.php';</script>";
        
      }else{


         //Notification Add Position

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

                      
            $trxnid     =  $_SESSION['hrtranxactionId']; 
            $trxnDtlid  = get_trxn_dtl_max();



    $trxn_dtl = "INSERT INTO `trxn_dtl`
                                      (`dtl_id`, `trxn_id`, `type`, `trxn_date`, `description`) 
                                 VALUES 
                                      ('$trxnDtlid','$trxnid',16,CURRENT_TIMESTAMP,'$position')";


	$query  = "INSERT INTO  `position`(`active_id`,`position`)VALUES('$trxnDtlid','$position')";


     if($con->query($trxn_dtl)===TRUE AND $con->query($query)===TRUE){

	     echo '<script language="javascript">';
         echo 'alert("Position Inserted.")';
         echo '</script>';
	     echo "<script type='text/javascript'>window.location.href = 'position_manage.php';</script>";

     	}
     	else
     	{
     	echo '<script language="javascript">';
        echo 'alert("Position not Inserted.")';
        echo '</script>';
		echo "<script type='text/javascript'>window.location.href = 'position_manage.php';</script>";
     	}

  }
 }
}

?>