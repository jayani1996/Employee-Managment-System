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


            $userId    = $_SESSION['userId'];
            $bepf_no   = $_SESSION['usepf_no'];
            $busername = $_SESSION['ususername'];
            $bpassword = $_SESSION['uspassword'];
            $bcateId   = $_SESSION['uscateId'];
            $buLvlId   = $_SESSION['usuLvlId'];


            $befor_trxn_dtl = "INSERT INTO `trxn_dtl`
                                              (`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
                                         VALUES 
                                               ('$trxnDtlid','$trxnid',14,CURRENT_TIMESTAMP)";
            mysqli_query($con, $befor_trxn_dtl);



            $sql_before = "INSERT INTO  `noti_user`
                            (`user_id`,`trxn_id`,`active_id`,`update_tpye`,`epf_no`,`username`,`password`,`category`,`user_level`)
                         VALUES
                            ('$userId','$trxnid','$trxnDtlid',1,'$bepf_no','$busername','$bpassword','$bcateId','$buLvlId')";

            mysqli_query($con, $sql_before); 


        
			   

        	  if(isset($_POST['submit'])){

                $epf_no      = $_POST['epf_no'];
                $username    = $_POST['username'];
                $password    = $_POST['password'];
                $category    = $_POST['category'];
                $user_level  = $_POST['user_level'];


              $SQS = "UPDATE `user` SET           
                                        `active_id`  = '$trxnDtlid',
                                        `epf_no`     = '$epf_no',
                                        `username`   = '$username',
                                        `password`   = '$password',
                                        `category`   = '$category', 
                                        `user_level` = '$user_level' 
                                    WHERE 
                                        `user`.`id`     = '$userId' ";

      $sql_after = "INSERT INTO  `noti_user`
                            (`user_id`,`trxn_id`,`active_id`,`update_tpye`,`epf_no`,`username`,`password`,`category`,`user_level`)
                         VALUES
                            ('$userId','$trxnid','$trxnDtlid',2,'$epf_no','$username','$password','$category','$user_level')";

      if($con->query($SQS)===TRUE AND $con->query($sql_after)===TRUE){


      echo '<script language="javascript">';
      echo 'alert("User Updated.")';
      echo '</script>';

      echo "<script type='text/javascript'>window.location.href = 'setting.php';</script>";

		}else{
      echo '<script language="javascript">';
      echo 'alert("User not Updated.")';
      echo '</script>';
    
      echo "<script type='text/javascript'>window.location.href = 'setting.php';</script>";
    }
	}
 }
?>