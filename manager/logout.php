  <?php 
  session_start();
  include ("../dbconfig.php");
	error_reporting(0);
	//Create Connection
	$con = new mysqli(DB_HOSTNAME,DB_USERNAME, DB_PASSWORD,DB_NAME);
    

	
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


           		$trxnid     =  $_SESSION['mtranxactionId'];
           		$trxnDtlid  = get_trxn_dtl_max();

         $notion = "UPDATE `trxn` SET `active` = 2  
                                  WHERE `trxn`.`trxn_id` = '$trxnid'";
  
          mysqli_query($con, $notion);


			    $trxn_dtl = "INSERT INTO `trxn_dtl`
			    									(`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
			    							VALUES 
			    							        ('$trxnDtlid','$trxnid',5,CURRENT_TIMESTAMP)";


			    mysqli_query($con, $trxn_dtl);

?>

<?php 


unset($_SESSION['mangrSession']);
session_destroy($_SESSION['mangrSession']);
header('location:../login.php');



?>