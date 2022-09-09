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


	$news_id      = $_POST['news_id'];
	$news_header  = $_POST['news_header'];
	$news_content = $_POST['news_content'];
	$news_active  = $_POST['active_id'];



			  // Notification news add
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

          
          	$trxnid     = $_SESSION['hrtranxactionId']; 
          	$trxnDtlid  = get_trxn_dtl_max();



			$query  = "INSERT INTO  `news`
											(`news_id`,`active_id`,`heading`,`content`,`active`)
									VALUES
											('$news_id','$trxnDtlid','$news_header','$news_content',$news_active)";

		

          	$trxn_dtl = "INSERT INTO `trxn_dtl`
                                              (`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
                                         VALUES 
                                              ('$trxnDtlid','$trxnid',10,CURRENT_TIMESTAMP)";


     $sql_noti = "INSERT INTO  `noti_news`
										(`news_id`,`trxn_id`,`active_id`,`heading`,`content`,`active`)
								VALUES
										('$news_id','$trxnid','$trxnDtlid','$news_header','$news_content',$news_active)";

			if ($con->query($query)===TRUE AND $con->query($trxn_dtl) ===TRUE AND $con->query($sql_noti) ===TRUE) {

			
      echo '<script language="javascript">';
      echo 'alert("News Inserted.")';
      echo '</script>';
      echo "<script type='text/javascript'>window.location.href = 'news_manage.php';</script>";

			}
      else
      {
      echo '<script language="javascript">';
      echo 'alert("News not Inserted.")';
      echo '</script>';
      echo "<script type='text/javascript'>window.location.href = 'news_manage.php';</script>";
      }							
	
    
}

}
?>