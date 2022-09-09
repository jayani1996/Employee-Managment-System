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

?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Koggala</title>
  <!-- BOOTSTRAP STYLES-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="../assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="../assets/css/custom.css" rel="stylesheet" />

    <link href="../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
<div id="wrapper">
            <!--NAVBAR TOP-->
  <nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
        <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
      <a href="#" class="navbar-brand ">Koggala</a>
    </div>
            <div id="navbar-right">Welcome : <?php echo $_SESSION['adminSession'];?> &nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a>
            </div>
  </nav>
        <!--NAVBAR SIDE-->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li>
                    
                </li>
                <li>
                    <a href="index.php"><i class="fa fa-dashboard fa-2x"></i>Dashboard</a>
                </li>
                <li>
                    <a href="manage_employee.php"  class="active-menu"><i class="fa fa-male fa-2x"></i>Employee</a>
                </li>
                <li>
                    <a href="devision_manage.php"><i class="fa fa-sort-amount-asc fa-2x"></i>Division</a>
                </li>
                <li>
                    <a href="team_manage.php" ><i class="fa fa-users fa-2x"></i>Team</a>
                </li>
                <li>
                    <a href="news_manage.php"><i class="fa fa-edit fa-2x"></i>News</a>
                </li>
                <li>
                    <a href="position_manage.php"><i class="fa fa-sort fa-2x"></i>Designation</a>
                </li>
                <li>
                    <a href="emp_Recovery.php"><i class="fa fa-refresh fa-2x"></i>EMP Recovery</a>
                </li>

                <li>
                    <a href="setting.php"><i class="fa fa-cogs fa-2x"></i>Setting</a>
                </li>
                <li>
                    <a href="logout.php"><i class="fa fa-sign-out fa-2x"></i>Logout</a>
                </li>
            </ul>
        </div>
    </nav>

        
            <?php 
            $con=mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
            mysqli_select_db($con, DB_NAME);
            if($_GET['update']){

            $emp_id = $_GET['update'];
            $query  = "SELECT * FROM `employee` WHERE `emp_id` = '$emp_id'";
            $sql_select = mysqli_query($con, $query);
            $numOfRows  = mysqli_num_rows($sql_select);
            if($numOfRows >0)
            {
                while($row= mysqli_fetch_assoc($sql_select)){

                       $_SESSION['pCheck'] = $row['position'];
                       $_SESSION['employeeID']   = $row['emp_id'];
                       $eid          = $row['emp_id'];
                       $epf_no       = $row['epf_no']; 
                       $posId        = $row['position'];
                       $ename        = $row['ename'];
                       $address      = $row['address'];
                       $dob          = $row['dob'];
                       $gender       = $row['gender'];
                       $tel_personal = $row['tel_personal'];
                       $tel_home     = $row['tel_home'];
                       $nic          = $row['nic'];
                       $devId        = $row['devision'];
                       $teamId       = $row['team'];
                    
                       if($row['ephoto'] == "noimage.png"){

                      $image = "../images/employee/noimage/".$row['ephoto'];

                      $_SESSION['oldImageName'] ="../images/employee/noimage/".$row['ephoto'];
                     }else{

                      $image = "../images/employee/".$row['ephoto'];
                      
                      $_SESSION['oldImageName']  = "../images/employee/".$row['ephoto'];

                     }
                       //Educational Details
                       $eduId          = $row['minimum_edu'];
                       $sports         = $row['sports'];
                       $extra_edu      = $row['extra_edu'];
                       //Experience
                       $e_doj          = $row['e_doj'];
                       $other_company  = $row['other_company']; 
                       $occupation     = $row['occupation']; 
                       $time_period    = $row['etime_period'];
                       $remarks        = $row['remarks'];
                       $religion       = $row['religion'];
                       $civilstatus    = $row['civilstatus'];
                       $catogaroy      = $row['catogaroy'];


                      $date1 = $row['e_doj'];
                      $date2 = date("Y/m/d");

                      $diff = abs(strtotime($date2) - strtotime($date1));

                      $years  = floor($diff / (365*60*60*24));
                      $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                      $days   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));



                       // 1. this Session Variable create for add before update employee notifications



                       $_SESSION['epf_noUp']         = $epf_no; 
                       $_SESSION['positionUp']       = $posId;
                       $_SESSION['enameUp']          = $ename;
                       $_SESSION['addressUp']        = $address;
                       $_SESSION['dobUp']            = $dob;
                       $_SESSION['genderUp']         = $gender;
                       $_SESSION['tel_personalUp']   = $tel_personal;
                       $_SESSION['tel_homeUp']       = $tel_home;
                       $_SESSION['nicUp']            = $nic;
                       $_SESSION['religionUp']       = $religion;
                       $_SESSION['civilstatusUp']    = $civilstatus;
                       $_SESSION['catogaroyUp']      = $catogaroy;
                       $_SESSION['devisionUp']       = $devId;
                       $_SESSION['teamUp']           = $teamId;
                       $_SESSION['ephotoUp']         = $row['ephoto'];
                       $_SESSION['minimum_eduUp']    = $eduId;
                       $_SESSION['sportsUp']         = $sports;
                       $_SESSION['extra_eduUp']      = $extra_edu;
                       $_SESSION['e_dojUp']          = $e_doj;
                       $_SESSION['other_companyUp']  = $other_company; 
                       $_SESSION['occupationUp']     = $occupation; 
                       $_SESSION['etime_periodUp']   = $time_period;
                       $_SESSION['remarksUp']        = $remarks;
                       



     
                }
            }
      
    ?>
  <div id="page-wrapper">
  <div id="page-inner">
    <div class="row">
      <div class="col-md-12 col-lg-12 text-center">
        <h3>
          <small style="color:black; float:left; font-size:20px;"><i>Admin Panel</i></small>
          <strong style="color:green">Employee Update</strong>
        </h3>
      </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-2 col-lg-2">
          <a href="manage_employee.php" class="btn btn-primary">Back to list</a>
        </div>
        <div class="col-md-9 col-lg-9 text-center">
          <strong><?php echo $ename; ?>&nbsp;(<?php echo $epf_no; ?>)</strong>
        </div>
    </div>
    <hr/>
    <div class="row">
       <form class="form-add" role="form" action="manage_employee_update_query.php" method="post" enctype="multipart/form-data">
          <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
            <div class="form-group">
              <h3><strong>Personal Details</strong></h3>
              <hr>
            </div>
        <div class="row">
              <div class="col-md-12">
                  <input class="form-control" type="hidden" name="empID" value="<?php echo $eid; ?>"> 
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>EPF No</label>
                  <input class="form-control" type="text" name="epf_no" value="<?php echo $epf_no; ?>">
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Designation</label>
                      <?php

                      $posSQL   = "SELECT * FROM `position`";
                      $posQuery = mysqli_query($con, $posSQL);
                      $posNfRow = mysqli_num_rows($posQuery);
                      ?>
                      <select class="form-control" name="position">
                          <?php
                          if($posNfRow > 0){
                              while ($posRow = mysqli_fetch_assoc($posQuery)) {

                            $selected = ( $posRow['position_id']=="$posId" ? ' selected' : '' );
                            echo '<option value="'.$posRow['position_id'].'"'.$selected.'>'.$posRow['position'].'</option>';  
                       
                              }
                           }
                          ?>
                      </select>

                  </div>
              </div>
        </div>
            <div class="form-group">
              <label>Name</label>
              <input class="form-control" type="text" name="ename"  value="<?php echo $ename; ?>">
            </div>  
            <div class="form-group">
              <label>Address</label>
              <input class="form-control" name="address" value="<?php echo $address; ?>"> 
            </div>
            <div class="row">
                <div class="col-md-6"> 
                  <div class="form-group">
                    <label>Date Of Birth</label>
                    <input class="form-control" type="date" name="dob" value="<?php echo $dob; ?>">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                      <label>Gender</label><br>
                      <div class="radio-inline">
                          <label><input type="radio" name="gender" value="MALE"<?php  if($gender == "MALE"){ echo "checked";} ?>>Male</label>
                      </div>
                      <div class="radio-inline">
                          <label><input type="radio" name="gender" value="FEMALE"<?php if($gender == "FEMALE"){ echo "checked";} ?>>Female</label>
                      </div>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">   
                  <div class="form-group">
                    <label>Mobile Contact</label>
                    <input class="form-control" type="text" name="tel_personal" value="<?php echo $tel_personal; ?>">
                  </div>
                </div>
                <div class="col-md-6">  
                  <div class="form-group">
                    <label>Residence Contact</label>
                    <input class="form-control" type="text" name="tel_home" value="<?php echo $tel_home; ?>">
                  </div>
                </div>
            </div> 
            <div class="form-group">
              <label>NIC</label>
              <input class="form-control" type="text" name="nic" value="<?php echo $nic; ?>">
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label>Religion</label>
                    <?php
                    $relsql = "SELECT * FROM `religion`";
                    $relQuery = mysqli_query($con, $relsql);
                    $relNfRow = mysqli_num_rows($relQuery);
                    ?>
                   
                    <select class="form-control" name="religion">
                        <?php
                        if($relNfRow > 0){
                            while ($relRow = mysqli_fetch_assoc($relQuery)) {

                          $selected = ( $relRow['description']=="$religion" ? ' selected' : '' );
                          echo '<option value="'.$relRow['description'].'"'.$selected.'>'.$relRow['description'].'</option>';  
                     
                            }
                         }
                        ?>
                    </select>
                </div>
             </div>
           </div>
           <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Civil Status</label>
                          <select class="form-control" name="civilStatus">
                            <?php 
                            if($civilstatus == "SINGLE"){
                            ?>
                              <option value="">NO CIVIL STATUS</option>
                              <option value="SINGLE" selected>SINGLE</option>
                              <option value="MARRIED">MARRIED</option> 
                            <?php 
                            }elseif($civilstatus == "MARRIED"){
                            ?>
                              <option value="">NO CIVIL STATUS</option>
                              <option value="SINGLE">SINGLE</option>
                              <option value="MARRIED" selected>MARRIED</option> 
                            <?php 
                            }else{
                            ?>
                              <option value=""  selected>NO CIVIL STATUS</option>
                              <option value="SINGLE">SINGLE</option>
                              <option value="MARRIED">MARRIED</option> 
                            <?php
                            }
                            ?>   
                          </select>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Category</label>
                          <select class="form-control" name="catogory">
                              
                            <?php 
                            if($catogaroy == "STAFF"){
                            ?>
                              <option value="">NO CATEGORY</option> 
                              <option value="STAFF" selected>STAFF</option>
                              <option value="WORKER">WORKER</option> 
                            <?php 
                            }elseif($catogaroy == "WORKER"){
                            ?>
                              <option value="">NO CATEGORY</option> 
                              <option value="STAFF">STAFF</option>
                              <option value="WORKER" selected>WORKER</option>
                            <?php 
                            }else{
                            ?>
                              <option value="" selected>NO CATEGORY</option> 
                              <option value="STAFF">STAFF</option>
                              <option value="WORKER">WORKER</option>
                            <?php 
                              }
                            ?> 
                          </select>
                      </div>
                  </div>
              </div>
            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label>Division</label>
                      <?php

                      $divSQL    = "SELECT * FROM `devision`";
                      $divQuery = mysqli_query($con, $divSQL);
                      $divNfRow = mysqli_num_rows($divQuery);
                      ?>
                      <select class="form-control" name="devision">
                          <?php
                          if($divNfRow > 0){
                              while ($divRow = mysqli_fetch_assoc($divQuery)) {

                            $selected = ( $divRow['dev_id']=="$devId" ? ' selected' : '' );
                            echo '<option value="'.$divRow['dev_id'].'"'.$selected.'>'.$divRow['dev_name'].'</option>';  
                       
                              }
                           }
                          ?>
                      </select>

                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Team</label>
                      <?php

                      $teamSQL   = "SELECT * FROM `team`";
                      $teamQuery = mysqli_query($con, $teamSQL);
                      $teamNfRow = mysqli_num_rows($teamQuery);
                      ?>
                      <select class="form-control" name="team">
                          <?php
                          if($teamNfRow > 0){
                              while ($teamRow = mysqli_fetch_assoc($teamQuery)) {

                            $selected = ( $teamRow['team_id']=="$teamId" ? ' selected' : '' );
                            echo '<option value="'.$teamRow['team_id'].'"'.$selected.'>'.$teamRow['team_name'].'</option>';  
                       
                              }
                           }
                          ?>
                      </select>

                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Employee Image</label>
                  <input class="form-control" type="file" name="file">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <img src="<?php echo $image; ?>" width="100">
                </div>
              </div>
            </div>
              <div class="form-group">
                <h3><strong>Educational Details</strong></h3>
                <hr>
              </div>
              <div class="form-group">
                  <label>Education Qualification</label>
                  <?php

                  $eduSQL    = "SELECT * FROM `education`";
                  $eduQuery = mysqli_query($con, $eduSQL);
                  $eduNfRow = mysqli_num_rows($eduQuery);
                  ?>
                  <select class="form-control" name="minimum_edu">
                      <?php
                      if($eduNfRow > 0){
                          while ($eduRow = mysqli_fetch_assoc($eduQuery)) {

                        $selected = ( $eduRow['edu_id']=="$eduId" ? ' selected' : '' );
                        echo '<option value="'.$eduRow['edu_id'].'"'.$selected.'>'.$eduRow['edu_level'].'</option>';  
                   
                          }
                       }
                      ?>
                  </select>

              </div>
            <div class="form-group">
              <label>Extra Curricular Activities</label>
              <input class="form-control" name="sports" value="<?php echo $sports; ?>">
            </div>
            <div class="form-group">
              <label>Other Qualification</label>
              <input class="form-control" name="extra_edu" rows="4" value="<?php echo $extra_edu; ?>"> 
            </div>
          </div>
          <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
            
            <div class="form-group">
              <h3><strong>Experience</strong></h3>
              <hr>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-lable">Date Of Join</label>
                  <input class="form-control" type="date" name="e_doj" value="<?php echo $e_doj; ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Service Period (This Firm)</label>
                  <input class="form-control" type="text"  value="<?php printf("%d years, %d months, %d days\n", $years, $months, $days); ?>" readonly>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Previous Employment</label>
              <input class="form-control" name="other_company" rows="4" value="<?php echo $other_company; ?>">
            </div>
            <div class="form-group">
              <label>Occupation</label>
              <input class="form-control" type="text" name="occupation" value="<?php echo $occupation; ?>">
            </div>
            <div class="form-group">
              <label>Service Period</label>
              <input class="form-control" type="text" name="time_period" value="<?php echo $time_period; ?>">
            </div>
            <div class="form-group">
              <label>Remarks</label>
              <textarea class="form-control" name="remarks" rows="3"><?php echo $remarks; ?></textarea>
            </div>



                    <?php

                    //skill table....

            

                    $querySkill  = "SELECT * FROM skill WHERE emp_id = $emp_id";
                    $sql_selectSkill = mysqli_query($con, $querySkill);
                    $numOfRowsSkill  = mysqli_num_rows($sql_selectSkill);
                    if($numOfRowsSkill >0)
                    {
                    while($row1= mysqli_fetch_assoc($sql_selectSkill)){


                      //For Update Skill Drop DropDown Box.

                       $olUpdate = $row1['over_lock'];
                       $flUpdate = $row1['flat_lock'];
                       $snUpdate = $row1['single_needle'];
                       $dnUpdate = $row1['double_needle'];
                       $btUpdate = $row1['bar_tack'];
                       $bhUpdate = $row1['button_hole'];
                       $baUpdate = $row1['button_attach'];
                       $piUpdate = $row1['picot'];


                        // 2. this Session Variable create for add before update employee notifications

                        $_SESSION['over_lockUp']     = $olUpdate;
                        $_SESSION['flat_lockUp']     = $flUpdate;
                        $_SESSION['single_needleUp'] = $snUpdate;
                        $_SESSION['double_needleUp'] = $dnUpdate;
                        $_SESSION['bar_tackUp']      = $btUpdate;
                        $_SESSION['button_holeUp']   = $bhUpdate;
                        $_SESSION['button_attachUp'] = $baUpdate;
                        $_SESSION['picotUp']         = $piUpdate; 



                    if ($row1['over_lock'] == '1') {
                        $over_lock = "../images/ico/supper.png";

                       }elseif ($row1['over_lock'] == '2'){
                        $over_lock = "../images/ico/skill.png";

                       }elseif ($row1['over_lock'] == '3'){
                        $over_lock = "../images/ico/poor.png";

                      }else{
                        $over_lock = "../images/ico/noneSkill.png";
                    }

                    if ($row1['flat_lock'] == "1") {
                        $flat_lock = "../images/ico/supper.png";

                      }elseif ($row1['flat_lock'] == "2") {
                        $flat_lock = "../images/ico/skill.png";

                      }elseif ($row1['flat_lock'] == "3") {
                        $flat_lock = "../images/ico/poor.png";

                      }else{
                         $flat_lock = "../images/ico/noneSkill.png";
                    }

                    if ($row1['single_needle'] == '1') {
                        $single_needle = "../images/ico/supper.png";

                      }elseif ($row1['single_needle'] == "2") {
                        $single_needle = "../images/ico/skill.png";

                      }elseif ($row1['single_needle'] == "3") {
                        $single_needle = "../images/ico/poor.png";

                      }else{
                        $single_needle = "../images/ico/noneSkill.png";
                    }

                    if ($row1['double_needle'] == "1") {
                        $double_needle = "../images/ico/supper.png";

                      }elseif ($row1['double_needle'] == "2") {
                        $double_needle = "../images/ico/skill.png";

                      }elseif ($row1['double_needle'] == "3") {
                        $double_needle = "../images/ico/poor.png";

                      }else{
                        $double_needle = "../images/ico/noneSkill.png";
                    }

                    if ($row1['bar_tack'] == "1") {
                        $bar_tack = "../images/ico/supper.png";

                      }elseif ($row1['bar_tack'] == "2") {
                        $bar_tack = "../images/ico/skill.png";

                      }elseif ($row1['bar_tack'] == "3") {
                        $bar_tack = "../images/ico/poor.png";

                      }else{
                        $bar_tack = "../images/ico/noneSkill.png";
                    }

                    if ($row1['button_hole'] == "1") {
                        $button_hole = "../images/ico/supper.png";

                      }elseif ($row1['button_hole'] == "2") {
                        $button_hole = "../images/ico/skill.png";

                      }elseif ($row1['button_hole'] == "3") {
                        $button_hole = "../images/ico/poor.png";

                      }else{
                        $button_hole = "../images/ico/noneSkill.png";
                    }

                    if ($row1['button_attach'] == "1") {
                        $button_attach = "../images/ico/supper.png";

                      }elseif ($row1['button_attach'] == "2") {
                        $button_attach = "../images/ico/skill.png";

                      }elseif ($row1['button_attach'] == "3") {
                        $button_attach = "../images/ico/poor.png";

                      }else{
                        $button_attach = "../images/ico/noneSkill.png";
                    }

                    if ($row1['picot'] == "1") {
                        $picot = "../images/ico/supper.png";

                      }elseif ($row1['picot'] == "2") {
                        $picot = "../images/ico/skill.png";

                      }elseif ($row1['picot'] == "3") {
                        $picot = "../images/ico/poor.png";

                      }else{
                        $picot = "../images/ico/noneSkill.png";
                    }


                     }
                   }
                }
              if($posId =="2" OR $posId =="3" OR $posId =="4" OR $posId =="5"){

              ?>

    
            <div class="row">  
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                <div class="form-group" ">
                  <h3><strong>Skill Metrics</strong></h3>
                  <hr>
                </div>
            </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="col-md-4 col-lg-4 col-sm-3 col-xs-3">
                  <ul>
                    <li><strong>Super</strong>&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/ico/supper.png" width="16"></li>
                  </ul>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 col-xs-3">
                  <ul>
                    <li><strong>Skill</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/ico/skill.png" width="16"></li>
                  </ul>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-3 col-xs-3">
                  <ul>
                    <li><strong>Poor</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/ico/poor.png" width="16"></li>
                  </ul>
                </div>
              </div>
             </div>
              <div class="table responsive">
                  <table class="table table-bordered table-responsive">
                    <tr>
                        <th class="text-center">Machine Type</th>
                        <th class="text-center">Skill</th>
                        <th class="text-center">Update</th>
                    </tr>
                    <tr>
                       <td>Over Lock</td>
                        <td class="text-center"><img src="<?php echo $over_lock; ?>"></td> 
                        <td>
                          <div class="form-group col-md-12">
                            <?php

                            $olSQL = "SELECT * FROM skill_category";
                            $olQuery = mysqli_query($con, $olSQL);
                            $olNfRow = mysqli_num_rows($olQuery);
                            ?>
                            <select class="form-control" name="over_lock">
                                <?php
                                if($olNfRow > 0){
                                    while ($olRow = mysqli_fetch_assoc($olQuery)) {

                                  $selected = ( $olRow['sc_id']=="$olUpdate"? ' selected' : '' );
                                  echo '<option value="'.$olRow['sc_id'].'"'.$selected.'>'.$olRow['sc_name'].'</option>';  
                             
                                    }
                                 }
                                ?>
                            </select>
                          </div>
                        </td>
                    </tr>

                    <tr>
                        <td>Flat Lock</td>
                        <td class="text-center"><img src="<?php echo $flat_lock; ?>" ></td>
                        <td>
                          <div class="form-group col-md-12">
                            <?php

                            $flSQL = "SELECT * FROM skill_category";
                            $flQuery = mysqli_query($con, $flSQL);
                            $flNfRow = mysqli_num_rows($flQuery);
                            ?>
                            <select class="form-control" name="flat_lock">
                                <?php
                                if($flNfRow > 0){
                                    while ($flRow = mysqli_fetch_assoc($flQuery)) {

                                  $selected = ( $flRow['sc_id']=="$flUpdate"? ' selected' : '' );
                                  echo '<option value="'.$flRow['sc_id'].'"'.$selected.'>'.$flRow['sc_name'].'</option>';  
                             
                                    }
                                 }
                                ?>
                            </select>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Single Needle</td>
                        <td class="text-center"><img src="<?php echo $single_needle; ?>"></td>
                        <td>
                          <div class="form-group col-md-12">
                            <?php

                            $snSQL   = "SELECT * FROM skill_category";
                            $snQuery = mysqli_query($con, $snSQL);
                            $snNfRow = mysqli_num_rows($snQuery);
                            ?>
                            <select class="form-control" name="single_needle">
                                <?php
                                if($snNfRow > 0){
                                    while ($snRow = mysqli_fetch_assoc($snQuery)) {

                                  $selected = ( $snRow['sc_id']=="$snUpdate"? ' selected' : '' );
                                  echo '<option value="'.$snRow['sc_id'].'"'.$selected.'>'.$snRow['sc_name'].'</option>';  
                             
                                    }
                                 }
                                ?>
                            </select>
                          </div>
                        </td>
                    </tr> 
                    <tr>
                        <td>Double Needle</td>
                        <td class="text-center"><img src="<?php echo $double_needle; ?>"></td>
                        <td>
                        <div class="form-group col-md-12">
                            <?php

                            $dnSQL   = "SELECT * FROM skill_category";
                            $dnQuery = mysqli_query($con, $dnSQL);
                            $dnNfRow = mysqli_num_rows($dnQuery);
                            ?>
                            <select class="form-control" name="double_needle">
                                <?php
                                if($dnNfRow > 0){
                                    while ($dnRow = mysqli_fetch_assoc($dnQuery)) {

                                  $selected = ( $dnRow['sc_id']=="$dnUpdate"? ' selected' : '' );
                                  echo '<option value="'.$dnRow['sc_id'].'"'.$selected.'>'.$dnRow['sc_name'].'</option>';  
                             
                                    }
                                 }
                                ?>
                            </select>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Bar Tack</td>
                        <td class="text-center"><img src="<?php echo $bar_tack; ?>"></td>
                        <td>
                          <div class="form-group col-md-12">
                            <?php

                            $btSQL   = "SELECT * FROM skill_category";
                            $btQuery = mysqli_query($con, $btSQL);
                            $btNfRow = mysqli_num_rows($btQuery);
                            ?>
                            <select class="form-control" name="bar_tack">
                                <?php
                                if($btNfRow > 0){
                                    while ($btRow = mysqli_fetch_assoc($btQuery)) {

                                  $selected = ( $btRow['sc_id']=="$btUpdate"? ' selected' : '' );
                                  echo '<option value="'.$btRow['sc_id'].'"'.$selected.'>'.$btRow['sc_name'].'</option>';  
                             
                                    }
                                 }
                                ?>
                            </select>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Button_Hole</td>
                        <td class="text-center"><img src="<?php echo $button_hole; ?>"></td>
                        <td>
                          <div class="form-group col-md-12">
                            <?php

                            $bhSQL   = "SELECT * FROM skill_category";
                            $bhQuery = mysqli_query($con, $bhSQL);
                            $bhNfRow = mysqli_num_rows($bhQuery);
                            ?>
                            <select class="form-control" name="button_hole">
                                <?php
                                if($bhNfRow > 0){
                                    while ($bhRow = mysqli_fetch_assoc($bhQuery)) {

                                  $selected = ( $bhRow['sc_id']=="$bhUpdate"? ' selected' : '' );
                                  echo '<option value="'.$bhRow['sc_id'].'"'.$selected.'>'.$bhRow['sc_name'].'</option>';  
                             
                                    }
                                 }
                                ?>
                            </select>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Button Attach</td>
                        <td class="text-center"><img src="<?php echo $button_attach; ?>"></td>
                        <td>
                          <div class="form-group col-md-12">
                            <?php

                            $baSQL   = "SELECT * FROM skill_category";
                            $baQuery = mysqli_query($con, $baSQL);
                            $baNfRow = mysqli_num_rows($baQuery);
                            ?>
                            <select class="form-control" name="button_attach">
                                <?php
                                if($baNfRow > 0){
                                    while ($baRow = mysqli_fetch_assoc($baQuery)) {

                                  $selected = ( $baRow['sc_id']=="$baUpdate"? ' selected' : '' );
                                  echo '<option value="'.$baRow['sc_id'].'"'.$selected.'>'.$baRow['sc_name'].'</option>';  
                             
                                    }
                                 }
                                ?>
                            </select>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td>picot</td>
                        <td class="text-center"><img src="<?php echo $picot; ?>"></td>
                        <td>
                          <div class="form-group col-md-12">
                            <?php

                            $piSQL   = "SELECT * FROM skill_category";
                            $piQuery = mysqli_query($con, $piSQL);
                            $piNfRow = mysqli_num_rows($piQuery);
                            ?>
                            <select class="form-control" name="picot">
                                <?php
                                if($piNfRow > 0){
                                    while ($piRow = mysqli_fetch_assoc($piQuery)) {

                                  $selected = ( $piRow['sc_id']=="$piUpdate"? ' selected' : '' );
                                  echo '<option value="'.$piRow['sc_id'].'"'.$selected.'>'.$piRow['sc_name'].'</option>';  
                             
                                    }
                                 }
                                ?>
                            </select>
                          </div>
                        </td>
                    </tr>
                  </table>
              </div>
            <?php   } ?>
            <div class="col-md-12 ">
              <button name="submit" class="btn btn-success btn-block">Update</button>
            </div> 
           </div>  
        </form>
      </div>
  </div>
</div>
</div>

  <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../assets/js/jquery.metisMenu.js"></script>
     <!-- MORRIS CHART SCRIPTS -->
     <script src="../assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="../assets/js/morris/morris.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

   <!--SELECT ONE VALUE IN CHECKOX-->
  <script>
      // the selector will match all input controls of type :checkbox
      // and attach a click event handler 
      $("input:checkbox").on('click', function() {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
          // the name of the box is retrieved using the .attr() method
          // as it is assumed and expected to be immutable
          var group = "input:checkbox[name='" + $box.attr("name") + "']";
          // the checked state of the group/box on the other hand will change
          // and the current value is retrieved using .prop() method
          $(group).prop("checked", false);
          $box.prop("checked", true);
        } else {
          $box.prop("checked", false);
        }
      });
  </script>
</body>
</html>
<?php } ?>