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
        $user_name = $_SESSION['adminSession'];


if($_GET['delete']){

	$dev_id = $_GET['delete'];

	


	  //Select Divition Name.
       if($dev_id==0){
              $divNa   = "";

        }else{
                    
       $divSQL   = "SELECT * FROM `devision` WHERE `dev_id` = $dev_id";
       $divQuery = mysqli_query($con, $divSQL);
       $divRow   = mysqli_fetch_assoc($divQuery);
       $divNa    = $divRow['dev_name'];  

    }



  //Notification Delete Divition

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
                                      ('$trxnDtlid','$trxnid',7,CURRENT_TIMESTAMP,'$divNa')";


    $dltQuery = "DELETE FROM `devision` WHERE `dev_id` = $dev_id";
	

    if($con->query($trxn_dtl)===TRUE AND $con->query($dltQuery)===TRUE){

    echo '<script language="javascript">';
    echo 'alert("Division deleted.")';
    echo '</script>';
    echo "<script type='text/javascript'>window.location.href = 'devision_manage.php';</script>";

    }
    else
    {
    echo '<script language="javascript">';
    echo 'alert("Division not deleted.")';
    echo '</script>';
    echo "<script type='text/javascript'>window.location.href = 'devision_manage.php';</script>";
    }

}
}

 ?>