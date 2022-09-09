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
  

if($_GET['delete']){

	$id = $_GET['delete'];
	



  //Notification Delete News

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
                                      (`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
                                 VALUES 
                                      ('$trxnDtlid','$trxnid',12,CURRENT_TIMESTAMP)";


    $select = "SELECT  * FROM `news` WHERE `news_id` = '$id'" ;

    $selectQuery = mysqli_query($con, $select);
    $row=mysqli_fetch_assoc($selectQuery);

        $news_id = $row['news_id'];
        $heading = $row['heading'];
        $content = $row['content'];
        $active  = $row['active'];


  $sql_noti  = "INSERT INTO  `noti_news`
                        									(`news_id`,`trxn_id`,`active_id`,`heading`,`content`,`active`)
                        							VALUES
                        									('$news_id','$trxnid','$trxnDtlid','$heading','$content',$active)";

	$dltQuery = "DELETE FROM `news` WHERE `news_id` = '$id' ";
	

  if ($con->query($trxn_dtl)===TRUE AND $con->query($sql_noti)===TRUE AND $con->query($dltQuery)===TRUE) {

          echo '<script language="javascript">';
          echo 'alert("News Deleted.")';
          echo '</script>';

          echo "<script type='text/javascript'>window.location.href = 'news_manage.php';</script>";

  }else{

          echo '<script language="javascript">';
          echo 'alert("News not Deleted.")';
          echo '</script>';

          echo "<script type='text/javascript'>window.location.href = 'news_manage.php';</script>";
  }


}
}

 ?>