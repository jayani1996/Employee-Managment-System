<?php
session_start();
include("../dbconfig.php");
date_default_timezone_set('Asia/Colombo');
error_reporting(0);
//Create Connection
$con = new mysqli(DB_HOSTNAME,DB_USERNAME, DB_PASSWORD, DB_NAME);
//Check Connection
if($con->connect_error) {
			die("connection fail:" . $con->connect_error);
}
if(!isset($_SESSION['hrSession'])) {
		echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
}else{



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

      	$bnewsid       = $_SESSION['hrepf_noUp'];
      	$bnews_heading = $_SESSION['hrpositionUp'];
      	$bnews_content = $_SESSION['hrenameUp'];
      	$bactive       = $_SESSION['hraddressUp'];


        $befor_trxn_dtl = "INSERT INTO `trxn_dtl`
                                              (`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
                                         VALUES 
                                               ('$trxnDtlid','$trxnid',11,CURRENT_TIMESTAMP)";
        mysqli_query($con, $befor_trxn_dtl);



        $sql_before = "INSERT INTO  `noti_news`
									(`news_id`,`trxn_id`,`active_id`,`update_tpye`,`heading`,`content`,`active`)
							VALUES
									('$bnewsid','$trxnid','$trxnDtlid',1,'$bnews_heading','$bnews_content',$bactive)";

        mysqli_query($con, $sql_before); 



		if(isset($_POST['submit'])) {

			$newsId   = $_POST['newId'];
			$newsHead = $_POST['newsHead'];
			$newsCon  = $_POST['newsCon'];
			$newsAct  = $_POST['newsAct'];


			$sql_update = "UPDATE `news` SET 
											`news_id`   = '$newsId',
											`active_id` = '$trxnDtlid',
											`heading`   = '$newsHead',
											`content`   = '$newsCon',
											`active`    = '$newsAct' 
										WHERE 
											`news_id`   = '$newsId'";

			$sql_after = "INSERT INTO  `noti_news`
									(`news_id`,`trxn_id`,`active_id`,`update_tpye`,`heading`,`content`,`active`)
							VALUES
									('$newsId','$trxnid','$trxnDtlid',2,'$newsHead','$newsCon',$newsAct)";



			if ($con->query($sql_update)===TRUE AND $con->query($sql_after)===TRUE) {

					echo '<script language="javascript">';
					echo 'alert("News Updated.")';
					echo '</script>';

					echo "<script type='text/javascript'>window.location.href = 'news_manage.php';</script>";

			}else{

					echo '<script language="javascript">';
					echo 'alert("News not Updated.")';
					echo '</script>';

					echo "<script type='text/javascript'>window.location.href = 'news_manage.php';</script>";
			}
		}
}

?>