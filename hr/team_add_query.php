<?php 
session_start();
include ("../dbconfig.php");
date_default_timezone_set('Asia/Colombo');
$con=mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
        mysqli_select_db($con, DB_NAME);
if(!isset($_SESSION['hrSession'])){

 echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
}else{
        

if(isset($_POST['submit']))
{
	$team_name = $_POST['team_name'];
  $dev_id1    = $_POST['dev_id1'];
	$dev_id2    = $_POST['dev_id2'];



    // sql statment  fot validate duplicate value
    $sqlchek = "SELECT `team_name` FROM `team` WHERE `team_name` = '$team_name' ";
    $chek    = mysqli_query($con, $sqlchek);
    $chekrow = mysqli_fetch_assoc($chek);

      $chckteam_name  =  $chekrow['team_name'];


      if($chckteam_name==$_POST['team_name']){


        echo '<script language="javascript">';
        echo 'alert("Already this team inserted.")';
        echo '</script>';

        echo "<script type='text/javascript'>window.location.href = 'team_manage.php';</script>";
        
      }else{


  //Notification Add Team

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
                                      ('$trxnDtlid','$trxnid',8,CURRENT_TIMESTAMP,'$team_name')";


	  $query = "INSERT INTO `team`(`active_id`,`team_name`,`dev_id1`,`dev_id2`) VALUES('$trxnDtlid','$team_name','$dev_id1','$dev_id2')";


      if($con->query($trxn_dtl)===TRUE AND $con->query($query)===TRUE){

      echo '<script language="javascript">';
      echo 'alert("Team Inserted.")';
      echo '</script>';
      echo "<script type='text/javascript'>window.location.href = 'team_manage.php';</script>";

      }
      else
      {
      echo '<script language="javascript">';
      echo 'alert("Team not Inserted.")';
      echo '</script>';
      echo "<script type='text/javascript'>window.location.href = 'team_manage.php';</script>";
      }

    }
  }
}
?>