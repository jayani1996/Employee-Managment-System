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

	$team_id = $_GET['delete'];


       //Select Team Name.
         if($team_id==0){
              $teamNa   = "";

        }else{
           $teamSQL   = "SELECT * FROM `team` WHERE `team_id` = $team_id";
           $teamQuery = mysqli_query($con, $teamSQL);
           $teamRow   = mysqli_fetch_assoc($teamQuery);
           $teamNa    = $teamRow['team_name'];
           
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
                                        ('$trxnDtlid','$trxnid',9,CURRENT_TIMESTAMP,'$teamNa')";


	$dltQuery = "DELETE FROM `team` WHERE `team_id` = $team_id";

  if($con->query($trxn_dtl)===TRUE AND $con->query($dltQuery)===TRUE){

      echo '<script language="javascript">';
      echo 'alert("Team deleted.")';
      echo '</script>';
      echo "<script type='text/javascript'>window.location.href = 'team_manage.php';</script>";

      }
      else
      {
      echo '<script language="javascript">';
      echo 'alert("Team not deleted.")';
      echo '</script>';
      echo "<script type='text/javascript'>window.location.href = 'team_manage.php';</script>";
      }

  }
}
 ?>