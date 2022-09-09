

<?php
session_start();
include ("../dbconfig.php");
date_default_timezone_set('Asia/Colombo');
if(isset($_POST["export"]))
{
  
  $con=mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
  mysqli_select_db($con, DB_NAME);


if(!isset($_SESSION["hrSession"])) {
  echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
}else{

  header('Content-Type: text/csv; charset=utf-8');
   header('Content-Disposition: attachment; filename=employees.csv');
   $output = fopen("php://output", "w");
   fputcsv($output, array('No','EPF No', 'Designation', 'Fullname', 'Address', 'DOB', 'Gender', 'Mobile Contact', 'Residence Contact', 'NIC', 'Division', 'Team', 'Education Qualification', 'Extra Curricular Activities', 'Other Qualifications', 'Date of Join', 'Previous Employment', 'Occupation', 'Service Period', 'Remarks', 'Religion', 'Civil Status', 'Catogory'));




    $query= "SELECT employee.emp_id AS emp_id,
                    employee.epf_no AS epf_no, 
                    position.position AS position,
                    employee.ename AS ename,
                    employee.address as address, 
                    employee.dob AS dob, 
                    employee.gender AS gender, 
                    employee.tel_personal AS tel_personal, 
                    employee.tel_home AS tel_home, 
                    employee.nic AS nic, 
                    devision.dev_name AS devision, 
                    team.team_name AS team, 
                    education.edu_level AS minimum_edu, 
                    employee.sports AS sports, 
                    employee.extra_edu AS extra_edu, 
                    employee.e_doj AS e_doj, 
                    employee.other_company AS other_company, 
                    employee.occupation AS occupation, 
                    employee.etime_period AS etime_period, 
                    employee.remarks AS remarks, 
                    employee.religion AS religion, 
                    employee.civilstatus AS civilstatus,
                    employee.catogaroy AS catogaroy 
            FROM employee 
              LEFT JOIN position  ON employee.position       =position.position_id
              LEFT JOIN devision  ON employee.devision       =devision.dev_id
              LEFT JOIN team      ON employee.team           =team.team_id
              LEFT JOIN education ON employee.minimum_edu    =education.edu_id";


  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) 
  {

    fputcsv($output, $row);
  }
  fclose($output);

 }
}




?>









