<?php 
session_start();
date_default_timezone_set('Asia/Colombo');
include ("../dbconfig.php");

//Create Connection
$con = new mysqli(DB_HOSTNAME,DB_USERNAME, DB_PASSWORD,DB_NAME);
 //check connection
if ($con->connect_error){
            die("Connection fail: " . $con->connect_error);
}
if(!isset($_SESSION['hrSession'])){
        echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
        
}else{
        $user_name = $_SESSION['hrSession'];
       
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
     <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style type="text/css">
      #colorTd{
        color:blue;
        font-size:bold;
      }
    </style>
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
            <div id="navbar-right">Welcome : <?php echo $_SESSION['hrSession'];?> &nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a>
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
                    <a href="manage_employee.php"><i class="fa fa-male fa-2x"></i>Employee</a>
                </li>
                <li>
                    <a href="devision_manage.php"><i class="fa fa-sort-amount-asc fa-2x"></i>Division</a>
                </li>
                <li>
                    <a href="team_manage.php"><i class="fa fa-users fa-2x"></i>Team</a>
                </li>
                <li>
                    <a href="news_manage.php"><i class="fa fa-edit fa-2x"></i>News</a>
                </li>
                <li>
                    <a href="position_manage.php"><i class="fa fa-sort fa-2x"></i>Designation</a>
                </li>
                <li>
                    <a href="emp_Recovery.php"  class="active-menu"><i class="fa fa-refresh fa-2x"></i>EMP Recovery</a>
                </li> 
                <li>
                    <a href="logout.php"><i class="fa fa-sign-out fa-2x"></i>Logout</a>
                </li>
            </ul>
        </div>
    </nav>
  
        

            <?php 


            if($_GET['emp_id']){

            $emp_id = $_GET['emp_id'];
            $moreSQL  = "SELECT * FROM `delete_emp` WHERE `emp_id` = '$emp_id'";
            $moreQuery = mysqli_query($con, $moreSQL);
            $moreNfRows  = mysqli_num_rows($moreQuery);
            if($moreNfRows >0)
            {
                while($moreRow= mysqli_fetch_assoc($moreQuery))
              {
  

                   $epf_no        = $moreRow['epf_no'];
                   $posId         = $moreRow['position'];
                   $ename         = $moreRow['ename'];
                   $address       = $moreRow['address'];
                   $dob           = $moreRow['dob'];
                   $gender        = $moreRow['gender'];
                   $tel_personal  = $moreRow['tel_personal'];
                   $tel_home      = $moreRow['tel_home'];
                   $nic           = $moreRow['nic'];
                   $devId         = $moreRow['devision'];
                   $teamId        = $moreRow['team'];
                   $img           = "noimage.png";
                   $image = "../images/employee/noimage/".$img;
                   
                   //Educational Details
                   $eduId         = $moreRow['minimum_edu'];
                   $sports        = $moreRow['sports'];
                   $extra_edu     = $moreRow['extra_edu'];
                   //Experience
                   $e_doj         = $moreRow['e_doj'];
                   $other_company = $moreRow['other_company']; 
                   $occupation    = $moreRow['occupation']; 
                   $time_period   = $moreRow['etime_period'];
                   $remarks       = $moreRow['remarks'];
                   $religion      = $moreRow['religion'];
                   $civilstatus   = $moreRow['civilstatus'];
                   $catogaroy     = $moreRow['catogaroy'];



                    $date1 = $moreRow['e_doj'];
                    $date2 = date("Y/m/d");

                    $diff = abs(strtotime($date2) - strtotime($date1));

                    $years  = floor($diff / (365*60*60*24));
                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                    $days   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    


              }
            }
                //Select Postion Name.
                if($posId==0){
                          $posNa   = "";

                }else{

                   $posSQL   = "SELECT * FROM `position` WHERE `position_id` = $posId";
                   $posQuery = mysqli_query($con, $posSQL);
                   $posRow   = mysqli_fetch_assoc($posQuery);
                   $posNa    = $posRow['position'];
                   
               }

                  //Select Divition Name.
                  if($devId==0){
                          $divNa   = "";

                    }else{
                                
                   $divSQL   = "SELECT * FROM `devision` WHERE `dev_id` = $devId";
                   $divQuery = mysqli_query($con, $divSQL);
                   $divRow   = mysqli_fetch_assoc($divQuery);
                   $divNa    = $divRow['dev_name'];  
  
                   
                }


                  //Select Team Name.
                if($teamId==0){
                          $teamNa   = "";

                }else{
                   $teamSQL   = "SELECT * FROM `team` WHERE `team_id` = $teamId";
                   $teamQuery = mysqli_query($con, $teamSQL);
                   $teamRow   = mysqli_fetch_assoc($teamQuery);
                   $teamNa    = $teamRow['team_name'];
                   
               }

                //Select Education Qualification.
                if($eduId==0){
                          $eduNa   = "";

                }else{
                   $eduSQL   = "SELECT * FROM `education` WHERE `edu_id` = $eduId";
                   $eduQuery = mysqli_query($con, $eduSQL);
                   $eduRow   = mysqli_fetch_assoc($eduQuery);
                   $eduNa    = $eduRow['edu_level'];
                   
               }



            ?>


         <div id="page-wrapper">
          <div id="page-inner">
            <div class="row">
              <div class="col-md-12 col-lg-12 text-center">
                <h3>
                  <small style="color:black; float:left; font-size:20px;"><i>HR Panel</i></small>
                  <strong style="color:green">EMP Recovery</strong>
                </h3>
              </div>
            </div>
            <hr/> 
            <div class="row">
                <div class="col-md-2 col-lg-2">
                  <a href="emp_Recovery.php" class="btn btn-primary">Back to list</a>
                </div>
                <div class="col-md-8 col-lg-8 text-center">
                  <strong><?php echo $ename; ?>&nbsp;(<?php echo $epf_no; ?>)</strong>
                </div>
                <!--Generate Print Report-->
                <div class="col-md-2 col-lg-2">
                  <form action="generatePDF_OneByOne.php" method="post">
                    <strong><a href="generatePDF_OneByOne.php?emp_id=<?php echo $emp_id; ?>" style="color: gray;"><i class="fa fa-print fa-2x" style="color: gray;"></i>&nbsp;&nbsp;Print</a></strong>
                  </form>
                </div>
            </div>
            <hr/> 
            <div class="row">
              <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                <table class="table table-bordered">

                  <tbody>
                    <tr><td id="colorTd">EPF No</td>                      <td><?php echo $epf_no; ?></td></tr>
                    <tr><td id="colorTd">Designation</td>                 <td><?php echo $posNa; ?></td></tr>
                    <tr><td id="colorTd">Name</td>                        <td><?php echo $ename; ?></td></tr>
                    <tr><td id="colorTd">Address</td>                     <td><?php echo $address; ?></td></tr>
                    <tr><td id="colorTd">Date Of Birth</td>               <td><?php echo $dob; ?></td></tr>
                    <tr><td id="colorTd">Gender</td>                      <td><?php echo $gender; ?></td></tr>
                    <tr><td id="colorTd">Mobile Contact</td>              <td><?php echo $tel_personal; ?></td></tr>
                    <tr><td id="colorTd">Residence Contact</td>           <td><?php echo $tel_home; ?></td></tr>
                    <tr><td id="colorTd">NIC</td>                         <td><?php echo $nic; ?></td></tr>
                    <tr><td id="colorTd">Religion</td>                    <td><?php echo $religion; ?></td></tr>
                    <tr><td id="colorTd">Civil Status</td>                <td><?php echo $civilstatus; ?></td></tr>
                    <tr><td id="colorTd">Catogaroy</td>                   <td><?php echo $catogaroy; ?></td></tr>
                    <tr><td id="colorTd">Devision</td>                    <td><?php echo $divNa; ?></td></tr>
                    <tr><td id="colorTd">Team</td>                        <td><?php echo $teamNa; ?></td></tr>
                    <tr><td id="colorTd">Education Qualification</td>     <td><?php echo $eduNa; ?></td></tr>
                    <tr><td id="colorTd">Other Qualifications</td>        <td><?php echo $extra_edu; ?></td></tr>
                    <tr><td id="colorTd">Extra Curricular Activities</td> <td><?php echo $sports; ?></td></tr>
                    <tr><td id="colorTd">Date Of Join</td>                <td><?php echo $e_doj; ?></td></tr>
                    <tr><td id="colorTd">Service Period (This Firm)</td>
                        <td><?php printf("%d years, %d months, %d days\n", $years, $months, $days); ?></td></tr>
                    <tr><td id="colorTd">Previous Employment</td>         <td><?php echo $other_company; ?></td></tr>
                    <tr><td id="colorTd">Occupation</td>                  <td><?php echo $occupation; ?></td></tr>
                    <tr><td id="colorTd">Service Period (Years)</td>      <td><?php echo $time_period; ?></td></tr>
                    <tr><td id="colorTd">Remarks</td>                     <td><?php echo $remarks; ?></td></tr>
                    <tr><td id="colorTd">Image</td>                       <td><img src="<?php echo  $image; ?>" width="120"></td></tr>
                  </tbody>
                </table>
              </div>
            
         
                  

                  <?php


                        if($posId =="2" OR $posId =="3" OR $posId =="4" OR $posId =="5"){

                          $sql_supper ="SELECT * FROM `delete_skill` WHERE `emp_id` = '$emp_id'";
                          $sql_supper_query = mysqli_query($con, $sql_supper);
                          $row=mysqli_fetch_assoc($sql_supper_query);


                            if($row['over_lock'] == "1"){
                                    $over_lock  = "../images/ico/supper.png";
                            }elseif($row['over_lock'] == "2"){
                                    $over_lock  = "../images/ico/skill.png";
                            }elseif($row['over_lock'] == "3"){
                                    $over_lock  = "../images/ico/poor.png";
                            }else{
                                   $over_lock = "../images/ico/noneSkill.png";

                            }

                            if($row['flat_lock'] == "1"){
                                    $flat_lock  = "../images/ico/supper.png";
                            }elseif($row['flat_lock'] == "2"){
                                    $flat_lock  = "../images/ico/skill.png";
                            }elseif($row['flat_lock'] == "3"){
                                    $flat_lock  = "../images/ico/poor.png";
                            }else{
                                    $flat_lock = "../images/ico/noneSkill.png";

                            }

                            if($row['single_needle'] == "1"){
                                    $single_needle  = "../images/ico/supper.png";
                            }elseif($row['single_needle'] == "2"){
                                    $single_needle  = "../images/ico/skill.png";
                            }elseif($row['single_needle'] == "3"){
                                    $single_needle  = "../images/ico/poor.png";
                            }else{
                                   $single_needle = "../images/ico/noneSkill.png";

                            }

                            if($row['double_needle'] == "1"){
                                    $double_needle  = "../images/ico/supper.png";
                            }elseif($row['double_needle'] == "2"){
                                    $double_needle  = "../images/ico/skill.png";
                            }elseif($row['double_needle'] == "3"){
                                    $double_needle  = "../images/ico/poor.png";
                            }else{
                                   $double_needle = "../images/ico/noneSkill.png";

                            }

                            if($row['bar_tack'] == "1"){
                                     $bar_tack  = "../images/ico/supper.png";
                            }elseif($row['bar_tack'] == "2"){
                                     $bar_tack  = "../images/ico/skill.png";
                            }elseif($row['bar_tack'] == "3"){
                                     $bar_tack  = "../images/ico/poor.png";
                            }else{
                                   $bar_tack = "../images/ico/noneSkill.png";

                            }

                            if($row['button_hole'] == "1"){
                                     $button_hole  = "../images/ico/supper.png";
                            }elseif($row['button_hole'] == "2"){
                                     $button_hole  = "../images/ico/skill.png";
                            }elseif($row['button_hole'] == "3"){
                                     $button_hole  = "../images/ico/poor.png";
                            }else{
                                   $button_hole = "../images/ico/noneSkill.png";

                            }

                            if($row['button_attach'] == "1"){
                                     $button_attach  = "../images/ico/supper.png";
                            }elseif($row['button_attach'] == "2"){
                                     $button_attach  = "../images/ico/skill.png";
                            }elseif($row['button_attach'] == "3"){
                                     $button_attach  = "../images/ico/poor.png";
                            }else{
                                   $button_attach = "../images/ico/noneSkill.png";

                            }


                            if($row['picot'] == "1"){
                                     $picot  = "../images/ico/supper.png";
                            }elseif($row['picot'] == "2"){
                                     $picot  = "../images/ico/skill.png";
                            }elseif($row['picot'] == "3"){
                                     $picot  = "../images/ico/poor.png";
                            }else{
                                     $picot = "../images/ico/noneSkill.png";

                            }

     
                  ?>
                    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                        <table class="table  table-responsive" style="border-style: none;">
                            <tr>
                              <th><strong style="color:green;">Super</strong></th>
                              <td><img src="../images/ico/supper.png" width="16"></td>
                            </tr>
                            <tr>
                              <th><strong style="color:blue;">Skill</strong></th>
                              <td><img src="../images/ico/skill.png" width="16"></td>
                            </tr>
                            <tr>
                              <th><strong style="color:red;">Poor</strong></th>
                              <td><img src="../images/ico/poor.png" width="16"></td>
                            </tr>
                        </table>
                   <div class="table-responsive" style="overflow-x:auto;">
                        <table class="table table-bordered table-responsive">
                              <tr>
                                  <th class="text-center">Machine Type</th>
                                  <th class="text-center">Skill</th>
                              </tr>
                              <tr >
                                  <td>Over Lock</td>
                                  <td class="text-center"><img src="<?php echo $over_lock; ?>"></td>
                              </tr>
                              <tr >
                                  <td>Flat Lock</td>
                                  <td class="text-center"><img src="<?php echo $flat_lock; ?>"></td>
                              </tr>
                              <tr >
                                  <td>Single Needle</td>
                                  <td class="text-center"><img src="<?php echo $single_needle; ?>"></td>
                              </tr>
                              <tr >
                                  <td>Double Needle</td>
                                  <td class="text-center"><img src="<?php echo $double_needle; ?>"></td>
                              </tr>
                              <tr >
                                  <td>Bar Tack</td>
                                  <td class="text-center"><img src="<?php echo $bar_tack; ?>"></td>
                              </tr>
                              <tr >
                                  <td>Button Hole</td>
                                  <td class="text-center"><img src="<?php echo $button_hole; ?>"></td>
                              </tr>
                              <tr >
                                  <td>Button Attach</td>
                                  <td class="text-center"><img src="<?php echo $button_attach; ?>"></td>
                              </tr>
                              <tr >
                                  <td>Picot</td>
                                  <td class="text-center"><img src="<?php echo $picot; ?>"></td>
                              </tr>

                       </table>
                  </div>
            </div>
           <?php 
            }
           ?>
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
    <script src="../assets/js/custom.js"></script>
</body>
</html>
<?php
 } 
}
?>