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
        //$user_name = $_SESSION['adminSession'];


if($_GET['delete']){


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


			     $empId = $_GET['delete'];

            $select = "SELECT  * FROM employee 
                                  LEFT JOIN  skill ON employee.emp_id =  skill.emp_id
                                  WHERE `employee`.`emp_id` = '$empId'" ;

			           $selectQuery = mysqli_query($con, $select);
			           $row=mysqli_fetch_assoc($selectQuery);

                    $epf_no        = $row['epf_no']; 
                    $posId         = $row['position'];
                    $ename         = $row['ename'];
                    $address       = $row['address'];
                    $dob           = $row['dob'];
                    $gender        = $row['gender'];
                    $tel_personal  = $row['tel_personal'];
                    $tel_home      = $row['tel_home'];
                    $nic           = $row['nic'];
                    $devId         = $row['devision'];
                    $teamId        = $row['team'];
                    $ephoto        = $row['ephoto'];
                    //Educational Details
                    $eduId         = $row['minimum_edu'];
                    $sports        = $row['sports'];
                    $extra_edu     = $row['extra_edu'];
                    //Experience
                    $e_doj         = $row['e_doj'];
                    $other_company = $row['other_company']; 
                    $occupation    = $row['occupation']; 
                    $time_period   = $row['etime_period'];
                    $remarks       = $row['remarks'];
                    $religion      = $row['religion'];
                    $civilstatus   = $row['civilstatus'];
                    $catogaroy     = $row['catogaroy'];

                 if($posId =="2" OR $posId =="3" OR $posId =="4" OR $posId =="5"){

                    $over_lock      = $row['over_lock'];
                    $flat_lock      = $row['flat_lock'];
                    $single_needle  = $row['single_needle'];
                    $double_needle  = $row['double_needle'];
                    $bar_tack       = $row['bar_tack'];
                    $button_hole    = $row['button_hole'];
                    $button_attach  = $row['button_attach'];
                    $picot          = $row['picot'];

                }

              $trxn_dtl = "INSERT INTO `trxn_dtl`
                                                    (`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
                                               VALUES 
                                                        ('$trxnDtlid','$trxnid',4,CURRENT_TIMESTAMP)";
               mysqli_query($con, $trxn_dtl);


              $sql_noti = "INSERT INTO `noti_employee`
                                                      (
                                                      `emp_id`,`trxn_id`,`active_id`, `epf_no`, `position`, `ename`, `address`, 
                                                       `dob`, `gender`, `tel_personal`, `tel_home`, 
                                                       `nic`, `devision`, `team`, `minimum_edu`, `sports`, 
                                                       `extra_edu`, `e_doj`, `other_company`, `occupation`,
                                                       `etime_period`, `remarks`,`religion`,`civilstatus`,`catogaroy`
                                                      ) 
                                                  VALUES 
                                                      (
                                                      '$empId','$trxnid','$trxnDtlid','$epf_no','$posId','$ename','$address',
                                                      '$dob','$gender','$tel_personal','$tel_home',
                                                      '$nic','$devId','$teamId', '$eduId','$sports',
                                                      '$extra_edu','$e_doj', '$other_company','$occupation',
                                                      '$time_period','$remarks','$religion','$civilstatus','$catogaroy'
                                                      )";

            // For will recover Delete employess

              $delete_emp = "INSERT INTO `delete_emp`
                                                      (
                                                      `emp_id`,`trxn_date`,`trxn_id`,`active_id`, `epf_no`, `position`, `ename`, `address`, 
                                                       `dob`, `gender`, `tel_personal`, `tel_home`, 
                                                       `nic`, `devision`, `team`, `minimum_edu`, `sports`, 
                                                       `extra_edu`, `e_doj`, `other_company`, `occupation`,
                                                       `etime_period`, `remarks`,`religion`,`civilstatus`,`catogaroy`
                                                      ) 
                                                  VALUES 
                                                      (
                                                      '$empId',CURRENT_TIMESTAMP,'$trxnid','$trxnDtlid','$epf_no','$posId','$ename','$address',
                                                      '$dob','$gender','$tel_personal','$tel_home',
                                                      '$nic','$devId','$teamId', '$eduId','$sports',
                                                      '$extra_edu','$e_doj', '$other_company','$occupation',
                                                      '$time_period','$remarks','$religion','$civilstatus','$catogaroy'
                                                      )";

       if ($con->query($sql_noti) ===TRUE AND $con->query($delete_emp) ===TRUE) {

       if($posId =="2" OR $posId =="3" OR $posId =="4" OR $posId =="5"){

             $sql_noti2 = "INSERT INTO `noti_skill`(`emp_id`,`trxn_id`,`active_id`,
                                                    `over_lock`,`flat_lock`,
                                                    `single_needle`,`double_needle`,
                                                    `bar_tack`,`button_hole`,
                                                    `button_attach`,`picot`
                                                  ) 
                                            VALUES
                                                  ('$empId','$trxnid','$trxnDtlid',
                                                  '$over_lock','$flat_lock',
                                                  '$single_needle','$double_needle',
                                                  '$bar_tack','$button_hole',
                                                  '$button_attach','$picot'
                                                )";

          // For will recover Delete employess

          $delete_skill = "INSERT INTO `delete_skill`(`emp_id`,`trxn_date`,`trxn_id`,`active_id`,
                                                    `over_lock`,`flat_lock`,
                                                    `single_needle`,`double_needle`,
                                                    `bar_tack`,`button_hole`,
                                                    `button_attach`,`picot`
                                                  ) 
                                            VALUES
                                                  ('$empId',CURRENT_TIMESTAMP,'$trxnid','$trxnDtlid',
                                                  '$over_lock','$flat_lock',
                                                  '$single_needle','$double_needle',
                                                  '$bar_tack','$button_hole',
                                                  '$button_attach','$picot'
                                                )";

            if($con->query($sql_noti2) ===TRUE AND $con->query($delete_skill) ===TRUE){

            }
        }
      }

                       

   if($row['ephoto'] == "noimage.png"){

            	$image = $row['ephoto'];

    }else{

            $image = "../images/employee/".$row['ephoto'];
        
          	file_exists($image);
			      unlink($image);


    }


    if($image){

           		
           		$deleteQuery = "DELETE FROM `employee` WHERE `emp_id` = $empId";

				      $deleteSkill = "DELETE FROM `skill` WHERE `emp_id` = $empId";


			if ($con->query($deleteQuery)===TRUE AND $con->query($deleteSkill)===TRUE ) {

					echo '<script language="javascript">';
					echo 'alert("employee Deleted.")';
					echo '</script>';

					echo "<script type='text/javascript'>window.location.href = 'manage_employee.php';</script>";
  

			}else{
					echo "Error Updating record : " . $con->error;

					echo '<script language="javascript">';
					echo 'alert("employee Not deleted.")';
					echo '</script>';

          echo "<script type='text/javascript'>window.location.href = 'manage_employee.php';</script>";
			}
				


           }else{


           		echo '<script language="javascript">';
				      echo 'alert("Already Deleted.")';
				      echo '</script>';

              echo "<script type='text/javascript'>window.location.href = 'manage_employee.php';</script>";
			
		}





	}	
}

 ?>