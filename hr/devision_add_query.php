<?php 
session_start();
date_default_timezone_set('Asia/Colombo');
include ("../dbconfig.php");

//Create Connection
$con = new mysqli(DB_HOSTNAME,DB_USERNAME, DB_PASSWORD,DB_NAME);
 //check connection
if ($con->connect_error){
            die("Connection fail: " . $con->connect_error);
}
if(!isset($_SESSION['hrSession'])){
         echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
        
}else{
        $user_name = $_SESSION['hrSession'];


        

if(isset($_POST['submit']))
{
	$dev_name  = $_POST['devision_name'];



    // sql statment  fot validate duplicate value
    $sqlchek = "SELECT `dev_name` FROM `devision` WHERE `dev_name` = '$dev_name' ";
    $chek    = mysqli_query($con, $sqlchek);

    $chekrow = mysqli_fetch_assoc($chek);

    $dename  =  $chekrow['dev_name'];
   
   


      if($dename==$_POST['devision_name']){


        echo '<script language="javascript">';
        echo 'alert("Already this division inserted.")';
        echo '</script>';

        echo "<script type='text/javascript'>window.location.href = 'devision_manage.php';</script>";
        
      }else{


        //Notification Add Divition

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
                                      ('$trxnDtlid','$trxnid',6,CURRENT_TIMESTAMP,'$dev_name')";



    $query  = "INSERT INTO  `devision`(`active_id`,`dev_name`)VALUES('$trxnDtlid','$dev_name')";

     if($con->query($trxn_dtl)===TRUE AND $con->query($query)===TRUE){

      echo '<script language="javascript">';
      echo 'alert("Division Inserted.")';
      echo '</script>';
      echo "<script type='text/javascript'>window.location.href = 'devision_manage.php';</script>";

      }
      else
      {
      echo '<script language="javascript">';
      echo 'alert("Division not Inserted.")';
      echo '</script>';
      echo "<script type='text/javascript'>window.location.href = 'devision_manage.php';</script>";
      }


 
 }
 }
}

?>