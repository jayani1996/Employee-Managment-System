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


  
	if (isset($_POST['submit'])) {


		 

			$epf_no   = $_POST['epf_no'];
			$username = $_POST['username'];
			$password = $_POST['password'];
			$category = $_POST['category'];
			$userLvl  = $_POST['userLvl'];

			//Check employee for that EPF Number Recode.
			$PerSQL   = "SELECT `epf_no` FROM `employee` WHERE `epf_no` = '$epf_no'";
      $perQuery = mysqli_query($con, $PerSQL);
      $pernfRow = mysqli_num_rows($perQuery);
      $perRow   = mysqli_fetch_assoc($perQuery);

    if($perRow['epf_no']==$_POST['epf_no']){


    // sql statment  fot validate duplicate value
    $sqlchek = "SELECT `epf_no` FROM `user` WHERE `epf_no` = '$epf_no' ";
    $chek    = mysqli_query($con, $sqlchek);
    $chekrow = mysqli_fetch_assoc($chek);


    $chekepf_no  =  $chekrow['epf_no'];

		if($chekepf_no==$_POST['epf_no']){


				echo '<script language="javascript">';
        echo 'alert("Already this user inserted.")';
        echo '</script>';

        echo "<script type='text/javascript'>window.location.href = 'setting.php';</script>";
				
			}else{


      //Get maximum employee id form employee table
      function get_user_max()
      { 
        $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
        mysqli_select_db($con, DB_NAME);
        $usermax = mysqli_query($con, "SELECT MAX(`id`) as max FROM `user`");
        while ($usermaxRow = mysqli_fetch_assoc($usermax)) {

        $usermaxid  =  $usermaxRow["max"] + 1;
         
        }
        return $usermaxid;
      }


      // Notification User added
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

        $trxnid     = $_SESSION['tranxactionId'];
        $userId      = get_user_max(); 
        $trxnDtlid  = get_trxn_dtl_max();

			


		$query ="INSERT INTO `user`
								  (`id`,`active_id`,`epf_no`,`username`,`password`,`category`,`user_level`) 
							VALUES
								  ('$userId','$trxnDtlid','$epf_no','$username','$password','$category','$userLvl')";


		$trxn_dtl = "INSERT INTO `trxn_dtl`
                                          (`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
                                     VALUES 
                                          ('$trxnDtlid','$trxnid',13,CURRENT_TIMESTAMP)";


     	$sql_noti = "INSERT INTO  `noti_user`
									(`user_id`,`trxn_id`,`active_id`,`epf_no`,`username`,`password`,`category`,`user_level`)
							 VALUES
									('$userId','$trxnid','$trxnDtlid','$epf_no','$username','$password','$category','$userLvl')";


		if($con->query($query)===TRUE AND $con->query($trxn_dtl)===TRUE AND $con->query($sql_noti)===TRUE){

			echo '<script language="javascript">';
      echo 'alert("User Inserted.")';
      echo '</script>';
			echo "<script type='text/javascript'>window.location.href = 'setting.php';</script>";

     	}
     	else
     	{
     	echo '<script language="javascript">';
      echo 'alert("User not Inserted.")';
      echo '</script>';
			echo "<script type='text/javascript'>window.location.href = 'setting.php';</script>";
     	}				
	}
			
	}else{

			echo '<script language="javascript">';
      echo 'alert("Invalid user epf no.")';
      echo '</script>';
      echo "<script type='text/javascript'>window.location.href = 'setting.php';</script>";

	}
  }		
}
		

?>

