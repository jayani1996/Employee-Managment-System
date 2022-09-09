<?php
date_default_timezone_set('Asia/Colombo');
// Load the database configuration file
include_once '../dbconfig.php';
//Create Connection
$con = new mysqli(DB_HOSTNAME,DB_USERNAME, DB_PASSWORD,DB_NAME);
 //check connection
if ($con->connect_error){
            die("Connection fail: " . $con->connect_error);
}

if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data


                $empId             = $line[0];
                $epf_no            = $line[1];
                $position          = $line[2];
                $ename             = $line[3];
                $address           = $line[4];
                $dob               = $line[5];
                $gender            = $line[6];
                $tel_personal      = $line[7];
                $tel_home          = $line[8];
                $nic               = $line[9];
                $devision          = $line[10];
                $team              = $line[11];
                //$ephoto            = "noimage.png";
                $ephoto			   = $line[12];
                //Educational Details
                $minimum_edu       = $line[13];
                $sports            = $line[14];
                $extra_edu         = $line[15];
                //Experience
                $e_doj             = $line[16];
                $other_company     = $line[17];
                $occupation        = $line[18];
                $time_period       = $line[19];
                $remarks           = $line[20];
                $religion          = $line[21];
                $civilstatus       = $line[22];
                $catogaroy         = $line[23];


                // include  Position / Division  / Team / Education here

                $posSelect = "SELECT `position_id` FROM `position` WHERE `position` = '".$line[2]."'";
                $posQuery = mysqli_query($con,$posSelect);
                $posRow = mysqli_fetch_assoc($posQuery);
                $posId = $posRow['position_id'];


                $divSelect = "SELECT `dev_id` FROM `devision` WHERE `dev_name` = '".$line[10]."'";
                $divQuery = mysqli_query($con,$divSelect);
                $divRow = mysqli_fetch_assoc($divQuery);
                $divId = $divRow['dev_id'];


                $teamSelect = "SELECT `team_id` FROM `team` WHERE `team_name` = '".$line[11]."'";
                $teamQuery = mysqli_query($con,$teamSelect);
                $teamRow = mysqli_fetch_assoc($teamQuery);
                $teamId = $teamRow['team_id'];


                $eduSelect = "SELECT `edu_id` FROM `education` WHERE `edu_level` = '".$line[12]."'";
                $eduQuery = mysqli_query($con,$eduSelect);
                $eduRow = mysqli_fetch_assoc($eduQuery);
                $eduId = $eduRow['edu_id'];

                // Check whether member already exists in the database with the same EPF No

                $prevQuery = "SELECT `epf_no` FROM `employee` WHERE `epf_no` = '".$line[1]."'";
                $prevResult = mysqli_query($con, $prevQuery);
                $num_rows = mysqli_num_rows($prevResult);
                $prevEpfno = mysqli_fetch_assoc($prevResult);
                $prevResult  =  $prevEpfno['epf_no'];




                if($num_rows > 0){


       

                // Update employee data in the database

         		$con->query("UPDATE `employee` 
                                                SET  
                                                    `position`        = '".$posId."',
                                                    `ename`           = '".$ename."',
                                                    `address`         = '".$address."',
                                                    `dob`             = '".$dob."',
                                                    `gender`          = '".$gender."',
                                                    `tel_personal`    = '".$tel_personal."',
                                                    `tel_home`        = '".$tel_home."',
                                                    `nic`             = '".$nic."',
                                                    `devision`        = '".$divId."',
                                                    `team`            = '".$teamId."',
                                                    `ephoto`		  = '".$ephoto."',
                                                    `minimum_edu`     = '".$eduId."',
                                                    `sports`          = '".$sports."',
                                                    `extra_edu`       = '".$extra_edu."',
                                                    `e_doj`           = '".$e_doj."',
                                                    `other_company`   = '".$other_company."',
                                                    `occupation`      = '".$occupation."',
                                                    `etime_period`    = '".$time_period."',
                                                    `remarks`         = '".$remarks."',
                                                    `religion`        = '".$religion."',
                                                    `civilstatus`     = '".$civilstatus."',
                                                    `catogaroy`       = '".$catogaroy."'

                                                WHERE
                                                   
                                                     `employee`.`epf_no` = '".$epf_no."'");

                }else{

                    // Insert employee data in the database


                   $con->query("INSERT INTO `employee`
                                                          (`emp_id`,`epf_no`, 
                                                          `position`, `ename`, 
                                                          `address`, `dob`, 
                                                          `gender`, `tel_personal`, 
                                                          `tel_home`, `nic`, 
                                                          `devision`, `team`, 
                                                          `ephoto`, `minimum_edu`, 
                                                          `sports`, `extra_edu`, 
                                                          `e_doj`, `other_company`, 
                                                          `occupation`, `etime_period`, 
                                                          `remarks`, `religion`, 
                                                          `civilstatus`, `catogaroy`
                                                          ) 
                                                      VALUES 
                                                          (
                                                          '".$empId."','".$epf_no."',
                                                          '".$posId."','".$ename."',
                                                          '".$address."','".$dob."',
                                                          '".$gender."','".$tel_personal."',
                                                          '".$tel_home."','".$nic."',
                                                          '".$divId."','".$teamId."',
                                                          '".$ephoto."','".$eduId."',
                                                          '".$sports."','".$extra_edu."',
                                                          '".$e_doj."', '".$other_company."',
                                                          '".$occupation."', '".$time_period."',
                                                          '".$remarks."', '".$religion."',
                                                          '".$civilstatus."', '".$catogaroy."'
                                                          )");



            if($posId =="2" OR $posId =="3" OR $posId =="4" OR $posId =="5"){

             $con->query("INSERT INTO `skill`(`emp_id`,
                                              `over_lock`,`flat_lock`,
                                              `single_needle`,`double_needle`,
                                              `bar_tack`,`button_hole`,
                                              `button_attach`,`picot`
                                            ) 
                                      VALUES
                                            ('$empId',
                                            0,0,
                                            0,0,
                                            0,0,
                                            0,0
                                          )");

         

              }



               }


            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: manage_employee.php".$qstring);
