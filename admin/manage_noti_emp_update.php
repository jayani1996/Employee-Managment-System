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
if(!isset($_SESSION["adminSession"])){
        echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
        
}else{
        $user_name = $_SESSION["adminSession"];
        $trxnID    = $_SESSION['trxn_id'];
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
            <div id="navbar-right">Welcome : <?php echo $_SESSION["adminSession"];?> &nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a>
            </div>
  </nav>
        <!--NAVBAR SIDE-->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li>
                    
                </li>
                <li>
                    <a href="index.php" class="active-menu"><i class="fa fa-dashboard fa-2x"></i>Dashboard</a>
                </li>
                <li>
                    <a href="manage_employee.php"><i class="fa fa-male fa-2x"></i>Employee</a>
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


            if($_GET['dtlId'] AND $_GET['notiNum']){

                  $dtlId     = $_GET['dtlId'];
                  $notiNum = $_GET['notiNum']; 

                  //Before Notification fatch table data.

                  $beSQL     = "SELECT * FROM `noti_employee` WHERE `active_id` = '$dtlId' AND `update_tpye` = 1";
                  $beQuery   = mysqli_query($con, $beSQL);
                  $beNfRows  = mysqli_num_rows($beQuery);
                  $beRow     = mysqli_fetch_assoc($beQuery);
              
  

                   //$beemp_id        = $beRow['emp_id'];
                   $beepf_no        = $beRow['epf_no'];
                   $beposId         = $beRow['position'];
                   $beename         = $beRow['ename'];
                   $beaddress       = $beRow['address'];
                   $bedob           = $beRow['dob'];
                   $begender        = $beRow['gender'];
                   $betel_personal  = $beRow['tel_personal'];
                   $betel_home      = $beRow['tel_home'];
                   $benic           = $beRow['nic'];
                   $bedevId         = $beRow['devision'];
                   $beteamId        = $beRow['team'];
         

                   //Educational Details
                   $beeduId         = $beRow['minimum_edu'];
                   $besports        = $beRow['sports'];
                   $beextra_edu     = $beRow['extra_edu'];
                   //Experience
                   $bee_doj         = $beRow['e_doj'];
                   $beother_company = $beRow['other_company']; 
                   $beoccupation    = $beRow['occupation']; 
                   $betime_period   = $beRow['etime_period'];
                   $beremarks       = $beRow['remarks'];
                   $bereligion      = $beRow['religion'];
                   $becivilstatus   = $beRow['civilstatus'];
                   $becatogaroy     = $beRow['catogaroy'];


                  $bedate1 = $beRow['e_doj'];
                  $bedate2 = date("Y/m/d");

                  $bediff = abs(strtotime($bedate2) - strtotime($bedate1));

                  $beyears  = floor($bediff / (365*60*60*24));
                  $bemonths = floor(($bediff - $beyears * 365*60*60*24) / (30*60*60*24));
                  $bedays   = floor(($bediff - $beyears * 365*60*60*24 - $bemonths*30*60*60*24)/ (60*60*24));


                //Select Postion Name.
                if($beposId==0){
                          $beposNa   = "";

                }else{

                   $beposSQL   = "SELECT * FROM `position` WHERE `position_id` = $beposId";
                   $beposQuery = mysqli_query($con, $beposSQL);
                   $beposRow   = mysqli_fetch_assoc($beposQuery);
                   $beposNa    = $beposRow['position'];
                   
               }

                  //Select Divition Name.
                  if($bedevId==0){
                          $bedivNa   = "";

                    }else{
                                
                   $bedivSQL   = "SELECT * FROM `devision` WHERE `dev_id` = $bedevId";
                   $bedivQuery = mysqli_query($con, $bedivSQL);
                   $bedivRow   = mysqli_fetch_assoc($bedivQuery);
                   $bedivNa    = $bedivRow['dev_name'];  
  
                   
                }


                  //Select Team Name.
                if($beteamId==0){
                          $beteamNa   = "";

                }else{
                   $beteamSQL   = "SELECT * FROM `team` WHERE `team_id` = $beteamId";
                   $beteamQuery = mysqli_query($con, $beteamSQL);
                   $beteamRow   = mysqli_fetch_assoc($beteamQuery);
                   $beteamNa    = $beteamRow['team_name'];
                   
               }

                //Select Education Qualification.
                if($beeduId==0){
                          $beeduNa   = "";

                }else{
                   $beeduSQL    = "SELECT * FROM `education` WHERE `edu_id` = $beeduId";
                   $beeduQuery  = mysqli_query($con, $beeduSQL);
                   $beeduRow    = mysqli_fetch_assoc($beeduQuery);
                   $beeduNa     = $beeduRow['edu_level'];
                   
               }




         ?>


               <?php
                     //After Notification fatch table data.

                  $afSQL     = "SELECT * FROM `noti_employee` WHERE `active_id` = '$dtlId' AND `update_tpye` = 2";
                  $afQuery   = mysqli_query($con, $afSQL);
                  $afNfRows  = mysqli_num_rows($afQuery);
                  $afRow     = mysqli_fetch_assoc($afQuery);

                   $afepf_no        = $afRow['epf_no'];
                   $afposId         = $afRow['position'];
                   $afename         = $afRow['ename'];
                   $afaddress       = $afRow['address'];
                   $afdob           = $afRow['dob'];
                   $afgender        = $afRow['gender'];
                   $aftel_personal  = $afRow['tel_personal'];
                   $aftel_home      = $afRow['tel_home'];
                   $afnic           = $afRow['nic'];
                   $afdevId         = $afRow['devision'];
                   $afteamId        = $afRow['team'];
       
                   //Educational Details
                   $afeduId         = $afRow['minimum_edu'];
                   $afsports        = $afRow['sports'];
                   $afextra_edu     = $afRow['extra_edu'];
                   //Experience
                   $afe_doj         = $afRow['e_doj'];
                   $afother_company = $afRow['other_company']; 
                   $afoccupation    = $afRow['occupation']; 
                   $aftime_period   = $afRow['etime_period'];
                   $afremarks       = $afRow['remarks'];
                   $afreligion      = $afRow['religion'];
                   $afcivilstatus   = $afRow['civilstatus'];
                   $afcatogaroy     = $afRow['catogaroy'];

                  $afdate1 = $afRow['e_doj'];
                  $afdate2 = date("Y/m/d");

                  $afdiff = abs(strtotime($afdate2) - strtotime($afdate1));

                  $afyears  = floor($afdiff / (365*60*60*24));
                  $afmonths = floor(($afdiff - $afyears * 365*60*60*24) / (30*60*60*24));
                  $afdays   = floor(($afdiff - $afyears * 365*60*60*24 - $afmonths*30*60*60*24)/ (60*60*24));

            
                //Select Postion Name.
                if($afposId==0){
                          $afposNa   = "";

                }else{

                   $afposSQL   = "SELECT * FROM `position` WHERE `position_id` = $afposId";
                   $afposQuery = mysqli_query($con, $afposSQL);
                   $afposRow   = mysqli_fetch_assoc($afposQuery);
                   $afposNa    = $afposRow['position'];
                   
               }

                  //Select Divition Name.
                  if($afdevId==0){
                          $afdivNa   = "";

                    }else{
                                
                   $afdivSQL   = "SELECT * FROM `devision` WHERE `dev_id` = $afdevId";
                   $afdivQuery = mysqli_query($con, $afdivSQL);
                   $afdivRow   = mysqli_fetch_assoc($afdivQuery);
                   $afdivNa    = $afdivRow['dev_name'];  
  
                   
                }


                  //Select Team Name.
                if($afteamId==0){
                          $afteamNa   = "";

                }else{
                   $afteamSQL   = "SELECT * FROM `team` WHERE `team_id` = $afteamId";
                   $afteamQuery = mysqli_query($con, $afteamSQL);
                   $afteamRow   = mysqli_fetch_assoc($afteamQuery);
                   $afteamNa    = $afteamRow['team_name'];
                   
               }

                //Select Education Qualification.
                if($afeduId==0){
                          $afeduNa   = "";

                }else{
                   $afeduSQL    = "SELECT * FROM `education` WHERE `edu_id` = $afeduId";
                   $afeduQuery  = mysqli_query($con, $afeduSQL);
                   $afeduRow    = mysqli_fetch_assoc($afeduQuery);
                   $afeduNa     = $afeduRow['edu_level'];
                   
               }



            ?>


         <div id="page-wrapper">
          <div id="page-inner">
            <div class="row">
              <div class="col-md-12 col-lg-12 text-center">
                <h3>
                  <small style="color:black; float:left; font-size:20px;"><i>Admin Panel</i></small>
                  <strong style="color:green">Manage Notifications</strong>
                </h3>
              </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                       <a href="manage_notiResult.php?trxn_id=<?php echo $trxnID; ?>" class="btn btn-primary">Back</a>
                    </div>
                </div>
                <div class="col-md-11 col-sm-12 col-xs-12 ">
                <?php 
                 
                  $udltSQL = "SELECT *
                                        FROM trxn 
                                        INNER JOIN user ON trxn.user_id =  user.id
                                        WHERE `trxn`.`trxn_id` = '$trxnID'" ;

                  $udltQry   = mysqli_query($con, $udltSQL);
                  //$udltOfRow = mysqli_num_rows($udltQry);
                  $udltrow = mysqli_fetch_assoc($udltQry); 

                    $udltepf     = $udltrow['epf_no'];
                    $udltname    = $udltrow['username'];
                    $udltcatId   = $udltrow['category'];

                    //Select Category Name.
                     if($udltcatId==0){
                        $udltctgry   = "";

                     }else{
                       $udltcateSQL   = "SELECT * FROM `user_category` WHERE `id` = $udltcatId";
                       $udltcateQuery = mysqli_query($con, $udltcateSQL);
                       $udltcateRow   = mysqli_fetch_assoc($udltcateQuery);
                       $udltctgry    = $udltcateRow['description'];
                    }

                      $ueSQL   = "SELECT * FROM `employee` WHERE `epf_no` = '$udltepf'" ;
                       $ueqry   = mysqli_query($con, $ueSQL);
                       $ueRow   = mysqli_fetch_assoc($ueqry);
                       $ueposId = $ueRow['position'];
                       $ueename = $ueRow['ename'];


                      //Select Postion Name.
                      if($ueposId==0){
                                  $ueposNa   = "";

                      }else{

                          $ueposSQL   = "SELECT * FROM `position` WHERE `position_id` = $ueposId";
                          $ueposQry = mysqli_query($con, $ueposSQL);
                          $ueposRow   = mysqli_fetch_assoc($ueposQry);
                          $ueposNa    = $ueposRow['position'];
                             
                      }

                ?>
              <div class="panel" style="background:black;">
                 <div class="panel-heading">
                  <h5 style="color:white;">EPF No :&nbsp;&nbsp;
                        <span class="badge badge-light" style="background:blue;">
                            <?php echo $udltepf; ?> 
                        </span>
                        &nbsp;&nbsp;|&nbsp;&nbsp;Username :&nbsp;&nbsp;
                        <span class="badge badge-light" style="background:blue;">
                            <?php echo $udltname ; ?> 
                        </span>
                        &nbsp;&nbsp;|&nbsp;&nbsp;Panel :&nbsp;&nbsp;
                        <span class="badge badge-light" style="background:blue;">
                            <?php echo $udltctgry ; ?> 
                        </span>
                        &nbsp;&nbsp;|&nbsp;&nbsp;
                        <small style="color:red;font-size:13px;">
                          <i><?php  echo $ueposNa; ?></i>
                        </small>
                        &nbsp;&nbsp;|&nbsp;&nbsp;
                        <small style="color:red;font-size:13px;">
                          <i><?php  echo $ueename; ?></i>
                        </small>  
                  </h5>
                 </div>
              </div>
              </div>
            </div><!--row-->
            <div class="row"> 
              <div class="col-md-11 col-sm-12 col-xs-12 col-md-offset-1">
                <?php

                $dateSQL    = "SELECT * FROM `trxn_dtl` WHERE `dtl_id` = '$dtlId'" ;
                $dateqty    = mysqli_query($con, $dateSQL);
                $dateRow    = mysqli_fetch_assoc($dateqty);

                $typ        = $dateRow['type'];

                $typeSQL    = "SELECT `description` FROM `trxn_type` WHERE `id` = '$typ'" ;
                $typeQyery  = mysqli_query($con, $typeSQL);
                $typeRow    = mysqli_fetch_assoc($typeQyery);   

                //$dsriptin   = $typeRow['description'];  
                ?>
                <div class="panel" style="background:black;color:yellow;font-size:18px;">
                 <div class="panel-heading">
                    <small style="">
                      <small style="color:white;">Line Number&nbsp;:&nbsp;</small> 
                      <?php echo  $notiNum;?>
                      <small style="color:white;">&nbsp;&nbsp;|&nbsp;&nbsp;</small>
                      <small style="color:white;">Description &nbsp;:&nbsp;</small> 
                      <?php echo $typeRow['description']; ?>
                      <small style="color:white;">&nbsp;&nbsp;|&nbsp;&nbsp;</small>
                      <small style="color:white;">Time &nbsp;:&nbsp;</small> 
                      <?php echo date('F j, Y, g : i a',strtotime($dateRow['trxn_date'])); ?>
                    </small> 
                 </div>
               </div>
              </div>
            </div>
            <hr/> 
            <div class="row">

               <!--Before update employeee-->
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            
                <table class="table table-bordered">
                  <thead>
                    <th class="text-center">Details</th>
                    <th class="text-center" style="background:black; color:white; font-size:18px;">Before</th>
                    <th class="text-center" style="background:black; color:white; font-size:18px;">After</th>
                  </thead>
                  <?php 

                         // Change employee form colors 
                         $othercss = "color:black;font-size:14px;";
                         $colorOne = "background:red;";
                         $colorTwo = "background:white;";

                         // Change Skill form colors 
                         $skillOne = "background:red;";
                         $skillTwo = "background:white;";


                        // 01.EPF NO
                        if ($beepf_no <> $afepf_no)
                        {
                          $epfnobgd = "$colorOne";
                        }else
                        {
                          $epfnobgd = "$colorTwo";
                        }
                        // 02.Designation
                        if ($beposNa <> $afposNa)
                        {
                          $posNabgd = "$colorOne";
                        }else
                        {
                          $posNabgd = "$colorTwo";
                        }

                        // 03.Name
                        if ($beename <> $afename)
                        {
                          $namebgd = "$colorOne";
                        }else
                        {
                          $namebgd = "$colorTwo";
                        }

                        // 04.Address
                        if ($beaddress <> $afaddress)
                        {
                          $addbgd = "$colorOne";
                        }else
                        {
                          $addbgd = "$colorTwo";
                        }

                        // 05.Date Of Birth
                        if ($bedob <> $afdob)
                        {
                          $dobbgd = "$colorOne";
                        }else
                        {
                          $dobbgd = "$colorTwo";
                        }

                        // 06.Gender
                        if ($begender <> $afgender)
                        {
                          $gndrbgd = "$colorOne";
                        }else
                        {
                          $gndrbgd = "$colorTwo";
                        } 

                        // 07.Mobile Contact
                        if ($betel_personal <> $aftel_personal)
                        {
                          $perbgd = "$colorOne";
                        }else
                        {
                          $perbgd = "$colorTwo";
                        }

                        // 08.Residence Contact
                        if ($betel_home <> $aftel_home)
                        {
                          $homebgd = "$colorOne";
                        }else
                        {
                          $homebgd = "$colorTwo";
                        } 

                        // 09.NIC
                        if ($benic <> $afnic)
                        {
                          $nicbgd = "$colorOne";
                        }else
                        {
                          $nicbgd = "$colorTwo";
                        } 

                        // 10.Religion
                        if ($bereligion <> $afreligion)
                        {
                          $relibgd = "$colorOne";
                        }else
                        {
                          $relibgd = "$colorTwo";
                        } 

                        // 11.Civil Status
                        if ($becivilstatus <> $afcivilstatus)
                        {
                          $cvsbgd = "$colorOne";
                        }else
                        {
                          $cvsbgd = "$colorTwo";
                        }

                        // 12.Catogaroy
                        if ($becatogaroy <> $afcatogaroy)
                        {
                          $ctgybgd = "$colorOne";
                        }else
                        {
                          $ctgybgd = "$colorTwo";
                        }

                        // 13.Devision
                        if ($bedivNa <> $afdivNa)
                        {
                          $divNabgd = "$colorOne";
                        }else
                        {
                          $divNabgd = "$colorTwo";
                        }

                        // 14.Team
                        if ($beteamNa <> $afteamNa)
                        {
                          $teamNabgd = "$colorOne";
                        }else
                        {
                          $teamNabgd = "$colorTwo";
                        } 

                        // 15.Education Qualification
                        if ($beeduNa <> $afeduNa)
                        {
                          $eduNabgd = "$colorOne";
                        }else
                        {
                          $eduNabgd = "$colorTwo";
                        } 

                        // 16.Other Qualifications
                        if ($beextra_edu <> $afextra_edu)
                        {
                          $oquabgd = "$colorOne";
                        }else
                        {
                          $oquabgd = "$colorTwo";
                        }

                        // 17.Extra Curricular Activities
                        if ($besports <> $afsports)
                        {
                          $sptbgd = "$colorOne";
                        }else
                        {
                          $sptbgd = "$colorTwo";
                        }

                        // 18.Date Of Join
                        // 19.Service Period (This Firm)
                        if ($bee_doj <> $afe_doj)
                        {
                          $dojbgd = "$colorOne";
                        }else
                        {
                          $dojbgd = "$colorTwo";
                        } 

                        // 20.Previous Employment
                        if ($beother_company <> $afother_company)
                        {
                          $ocmbgd = "$colorOne";
                        }else
                        {
                          $ocmbgd = "$colorTwo";
                        }

                        // 21.Occupation
                        if ($beoccupation <> $afoccupation)
                        {
                          $occubgd = "$colorOne";
                        }else
                        {
                          $occubgd = "$colorTwo";
                        }

                        // 22.Service Period (Years)
                        if ($betime_period <> $aftime_period)
                        {
                          $tpbgd = "$colorOne";
                        }else
                        {
                          $tpbgd = "$colorTwo";
                        }

                        // 23.Remarks
                        if ($beremarks <> $afremarks)
                        {
                          $rembgd = "$colorOne";
                        }else
                        {
                          $rembgd = "$colorTwo";
                        }
                  ?>
                  <tbody> <!--Before and After update employeee-->
                    <td id="colorTd">EPF No</td>                   
                                  <td style="<?php echo $epfnobgd.$othercss; ?>"><?php echo $beepf_no; ?></td>
                                  <td style="<?php echo $epfnobgd.$othercss; ?>"><?php echo $afepf_no; ?></td></tr>
                    <td id="colorTd">Designation</td>                  
                                  <td style="<?php echo $posNabgd.$othercss; ?>"><?php echo $beposNa; ?></td>
                                  <td style="<?php echo $posNabgd.$othercss; ?>"><?php echo $afposNa; ?></td></tr>
                    <td id="colorTd">Name</td>                      
                                  <td style="<?php echo $namebgd.$othercss; ?>"><?php echo $beename; ?></td>
                                  <td style="<?php echo $namebgd.$othercss; ?>"><?php echo $afename; ?></td></tr>
                    <td id="colorTd">Address</td>                   
                                  <td style="<?php echo $addbgd.$othercss; ?>"><?php echo $beaddress; ?></td>
                                  <td style="<?php echo $addbgd.$othercss; ?>"><?php echo $afaddress; ?></td></tr>
                    <td id="colorTd">Date Of Birth</td>             
                                  <td style="<?php echo $dobbgd.$othercss; ?>"><?php echo $bedob; ?></td>
                                  <td style="<?php echo $dobbgd.$othercss; ?>"><?php echo $afdob; ?></td></tr>
                    <td id="colorTd">Gender</td>                    
                                  <td style="<?php echo $gndrbgd.$othercss; ?>"><?php echo $begender; ?></td>
                                  <td style="<?php echo $gndrbgd.$othercss; ?>"><?php echo $afgender; ?></td></tr>
                    <td id="colorTd">Mobile Contact</td>            
                                  <td style="<?php echo $perbgd.$othercss; ?>"><?php echo $betel_personal; ?></td>
                                  <td style="<?php echo $perbgd.$othercss; ?>"><?php echo $aftel_personal; ?></td></tr>
                    <td id="colorTd">Residence Contact</td>         
                                  <td style="<?php echo $homebgd.$othercss; ?>"><?php echo $betel_home; ?></td>
                                  <td style="<?php echo $homebgd.$othercss; ?>"><?php echo $aftel_home; ?></td></tr>
                    <td id="colorTd">NIC</td>                       
                                  <td style="<?php echo $nicbgd.$othercss; ?>"><?php echo $benic; ?></td>
                                  <td style="<?php echo $nicbgd.$othercss; ?>"><?php echo $afnic; ?></td></tr>
                    <td id="colorTd">Religion</td>                       
                                  <td style="<?php echo $relibgd.$othercss; ?>"><?php echo $bereligion; ?></td>
                                  <td style="<?php echo $relibgd.$othercss; ?>"><?php echo $afreligion; ?></td></tr>
                    <td id="colorTd">Civil Status</td>                      
                                  <td style="<?php echo $cvsbgd.$othercss; ?>"><?php echo $becivilstatus; ?></td>
                                  <td style="<?php echo $cvsbgd.$othercss; ?>"><?php echo $afcivilstatus; ?></td></tr>
                    <td id="colorTd">Catogaroy</td>                       
                                  <td style="<?php echo $ctgybgd.$othercss; ?>"><?php echo $becatogaroy; ?></td>
                                  <td style="<?php echo $ctgybgd.$othercss; ?>"><?php echo $afcatogaroy; ?></td></tr>
                    <td id="colorTd">Devision</td>                  
                                  <td style="<?php echo $divNabgd.$othercss; ?>"><?php echo $bedivNa; ?></td>
                                  <td style="<?php echo $divNabgd.$othercss; ?>"><?php echo $afdivNa; ?></td></tr>
                    <td id="colorTd">Team</td>                      
                                  <td style="<?php echo $teamNabgd.$othercss; ?>"><?php echo $beteamNa; ?></td>
                                  <td style="<?php echo $teamNabgd.$othercss; ?>"><?php echo $afteamNa; ?></td></tr>
                    <td id="colorTd">Education Qualification</td>         
                                  <td style="<?php echo $eduNabgd.$othercss; ?>"><?php echo $beeduNa; ?></td>
                                  <td style="<?php echo $eduNabgd.$othercss; ?>"><?php echo $afeduNa; ?></td></tr>
                    <td id="colorTd">Other Qualifications</td>      
                                  <td style="<?php echo $oquabgd.$othercss; ?>"><?php echo $beextra_edu; ?></td>
                                  <td style="<?php echo $oquabgd.$othercss; ?>"><?php echo $afextra_edu; ?></td></tr>
                    <td id="colorTd">Extra Curricular Activities</td>                    
                                  <td style="<?php echo $sptbgd.$othercss; ?>"><?php echo $besports; ?></td>
                                  <td style="<?php echo $sptbgd.$othercss; ?>"><?php echo $afsports; ?></td></tr>
                    <td id="colorTd">Date Of Join</td>     
                                  <td style="<?php echo $dojbgd.$othercss; ?>"><?php echo $bee_doj; ?></td>
                                  <td style="<?php echo $dojbgd.$othercss; ?>"><?php echo $afe_doj; ?></td></tr>
                    <td id="colorTd">Service Period (This Firm)</td>
                                  <td style="<?php echo $dojbgd.$othercss; ?>">
                                  <?php printf("%d years, %d months, %d days\n", $beyears, $bemonths, $bedays); ?></td>
                                  <td style="<?php echo $dojbgd.$othercss; ?>">
                                  <?php printf("%d years, %d months, %d days\n", $afyears, $afmonths, $afdays);?></td></tr>
                    <td id="colorTd">Previous Employment</td>              
                                  <td style="<?php echo $ocmbgd.$othercss; ?>"><?php echo $beother_company; ?></td>
                                  <td style="<?php echo $ocmbgd.$othercss; ?>"><?php echo $afother_company; ?></td></tr>
                    <td id="colorTd">Occupation</td>                
                                  <td style="<?php echo $occubgd.$othercss; ?>"><?php echo $beoccupation; ?></td>
                                  <td style="<?php echo $occubgd.$othercss; ?>"><?php echo $afoccupation; ?></td></tr>
                    <td id="colorTd">Service Period (Years)</td>               
                                  <td style="<?php echo $tpbgd.$othercss; ?>"><?php echo $betime_period; ?></td>
                                  <td style="<?php echo $tpbgd.$othercss; ?>"><?php echo $aftime_period; ?></td></tr> 
                    <td id="colorTd">Remarks</td>                   
                                  <td style="<?php echo $rembgd.$othercss; ?>"><?php echo $beremarks; ?></td>
                                  <td style="<?php echo $rembgd.$othercss; ?>"><?php echo $afremarks; ?></td></tr>
                  </tbody>
                </table>
              


          <!--Before Update Employee Skill-->


         <?php


          if($beposId =="2" OR $beposId =="3" OR $beposId =="4" OR $beposId =="5"){

              $besSQL ="SELECT * FROM `noti_skill` WHERE `active_id` = '$dtlId' AND `update_tpye` = 1";
              $besquery = mysqli_query($con, $besSQL);
              while($besrow=mysqli_fetch_assoc($besquery)){


                            if($besrow['over_lock'] == "1"){
                                    $beover_lock  = "../images/ico/supper.png";
                            }elseif($besrow['over_lock'] == "2"){
                                    $beover_lock  = "../images/ico/skill.png";
                            }elseif($besrow['over_lock'] == "3"){
                                    $beover_lock  = "../images/ico/poor.png";
                            }else{
                                    $beover_lock = "../images/ico/noneSkill.png";

                            }

                            if($besrow['flat_lock'] == "1"){
                                    $beflat_lock  = "../images/ico/supper.png";
                            }elseif($besrow['flat_lock'] == "2"){
                                    $beflat_lock  = "../images/ico/skill.png";
                            }elseif($besrow['flat_lock'] == "3"){
                                    $beflat_lock  = "../images/ico/poor.png";
                            }else{
                                    $beflat_lock = "../images/ico/noneSkill.png";

                            }

                            if($besrow['single_needle'] == "1"){
                                    $besingle_needle  = "../images/ico/supper.png";
                            }elseif($besrow['single_needle'] == "2"){
                                    $besingle_needle  = "../images/ico/skill.png";
                            }elseif($besrow['single_needle'] == "3"){
                                    $besingle_needle  = "../images/ico/poor.png";
                            }else{
                                    $besingle_needle = "../images/ico/noneSkill.png";

                            }

                            if($besrow['double_needle'] == "1"){
                                    $bedouble_needle  = "../images/ico/supper.png";
                            }elseif($besrow['double_needle'] == "2"){
                                    $bedouble_needle  = "../images/ico/skill.png";
                            }elseif($besrow['double_needle'] == "3"){
                                    $bedouble_needle  = "../images/ico/poor.png";
                            }else{
                                    $bedouble_needle = "../images/ico/noneSkill.png";

                            }

                            if($besrow['bar_tack'] == "1"){
                                     $bebar_tack  = "../images/ico/supper.png";
                            }elseif($besrow['bar_tack'] == "2"){
                                     $bebar_tack  = "../images/ico/skill.png";
                            }elseif($besrow['bar_tack'] == "3"){
                                     $bebar_tack  = "../images/ico/poor.png";
                            }else{
                                     $bebar_tack = "../images/ico/noneSkill.png";

                            }

                            if($besrow['button_hole'] == "1"){
                                     $bebutton_hole  = "../images/ico/supper.png";
                            }elseif($besrow['button_hole'] == "2"){
                                     $bebutton_hole  = "../images/ico/skill.png";
                            }elseif($besrow['button_hole'] == "3"){
                                     $bebutton_hole  = "../images/ico/poor.png";
                            }else{
                                     $bebutton_hole = "../images/ico/noneSkill.png";

                            }

                            if($besrow['button_attach'] == "1"){
                                     $bebutton_attach  = "../images/ico/supper.png";
                            }elseif($besrow['button_attach'] == "2"){
                                     $bebutton_attach  = "../images/ico/skill.png";
                            }elseif($besrow['button_attach'] == "3"){
                                     $bebutton_attach  = "../images/ico/poor.png";
                            }else{
                                     $bebutton_attach = "../images/ico/noneSkill.png";

                            }


                            if($besrow['picot'] == "1"){
                                     $bepicot  = "../images/ico/supper.png";
                            }elseif($besrow['picot'] == "2"){
                                     $bepicot  = "../images/ico/skill.png";
                            }elseif($besrow['picot'] == "3"){
                                     $bepicot  = "../images/ico/poor.png";
                            }else{
                                     $bepicot = "../images/ico/noneSkill.png";

                            }
                    }
     
                }
           ?>

         <!--After Update Employee Skill-->


         <?php


          if($afposId == "2" OR $afposId == "3" OR $afposId == "4" OR $afposId == "5"){

              $afsSQL   ="SELECT * FROM `noti_skill` WHERE `active_id` = '$dtlId' AND `update_tpye` = 2";
              $afsquery = mysqli_query($con, $afsSQL);
              $afsrow   = mysqli_fetch_assoc($afsquery);


                            if($afsrow['over_lock'] == "1"){
                                    $afover_lock  = "../images/ico/supper.png";
                            }elseif($afsrow['over_lock'] == "2"){
                                    $afover_lock  = "../images/ico/skill.png";
                            }elseif($afsrow['over_lock'] == "3"){
                                    $afover_lock  = "../images/ico/poor.png";
                            }else{
                                    $afover_lock = "../images/ico/noneSkill.png";

                            }

                            if($afsrow['flat_lock'] == "1"){
                                    $afflat_lock  = "../images/ico/supper.png";
                            }elseif($afsrow['flat_lock'] == "2"){
                                    $afflat_lock  = "../images/ico/skill.png";
                            }elseif($afsrow['flat_lock'] == "3"){
                                    $afflat_lock  = "../images/ico/poor.png";
                            }else{
                                    $afflat_lock = "../images/ico/noneSkill.png";

                            }

                            if($afsrow['single_needle'] == "1"){
                                    $afsingle_needle  = "../images/ico/supper.png";
                            }elseif($afsrow['single_needle'] == "2"){
                                    $afsingle_needle  = "../images/ico/skill.png";
                            }elseif($afsrow['single_needle'] == "3"){
                                    $afsingle_needle  = "../images/ico/poor.png";
                            }else{
                                    $afsingle_needle = "../images/ico/noneSkill.png";

                            }

                            if($afsrow['double_needle'] == "1"){
                                    $afdouble_needle  = "../images/ico/supper.png";
                            }elseif($afsrow['double_needle'] == "2"){
                                    $afdouble_needle  = "../images/ico/skill.png";
                            }elseif($afsrow['double_needle'] == "3"){
                                    $afdouble_needle  = "../images/ico/poor.png";
                            }else{
                                    $afdouble_needle = "../images/ico/noneSkill.png";

                            }

                            if($afsrow['bar_tack'] == "1"){
                                     $afbar_tack  = "../images/ico/supper.png";
                            }elseif($afsrow['bar_tack'] == "2"){
                                     $afbar_tack  = "../images/ico/skill.png";
                            }elseif($afsrow['bar_tack'] == "3"){
                                     $afbar_tack  = "../images/ico/poor.png";
                            }else{
                                     $afbar_tack = "../images/ico/noneSkill.png";

                            }

                            if($afsrow['button_hole'] == "1"){
                                     $afbutton_hole  = "../images/ico/supper.png";
                            }elseif($afsrow['button_hole'] == "2"){
                                     $afbutton_hole  = "../images/ico/skill.png";
                            }elseif($afsrow['button_hole'] == "3"){
                                     $afbutton_hole  = "../images/ico/poor.png";
                            }else{
                                     $afbutton_hole = "../images/ico/noneSkill.png";

                            }

                            if($afsrow['button_attach'] == "1"){
                                     $afbutton_attach  = "../images/ico/supper.png";
                            }elseif($afsrow['button_attach'] == "2"){
                                     $afbutton_attach  = "../images/ico/skill.png";
                            }elseif($afsrow['button_attach'] == "3"){
                                     $afbutton_attach  = "../images/ico/poor.png";
                            }else{
                                     $afbutton_attach = "../images/ico/noneSkill.png";

                            }


                            if($afsrow['picot'] == "1"){
                                     $afpicot  = "../images/ico/supper.png";
                            }elseif($afsrow['picot'] == "2"){
                                     $afpicot  = "../images/ico/skill.png";
                            }elseif($afsrow['picot'] == "3"){
                                     $afpicot  = "../images/ico/poor.png";
                            }else{
                                     $afpicot = "../images/ico/noneSkill.png";

                            }




        /* Nomal employee kenek Position eka 2,3,4,5 thiyene kenek karanakota noti_skill table eke before
         (type 1) recode ekak add wenna nathi nisa ena error ekata position deka check karala recode ekak teble eka nattm 0 kiyala before veriable walata value ekak denawa.*/
         
        if(($beposId <> 2 AND $beposId <> 3 AND $beposId <> 4 AND $beposId <>  5 ) AND ($afposId == 2 OR 
                                                                                        $afposId == 3 OR 
                                                                                        $afposId == 4 OR 
                                                                                        $afposId == 5)){

                              $beover_lock = 0;
                              $beflat_lock = 0;
                              $besingle_needle = 0;
                              $bedouble_needle = 0;
                              $bebar_tack = 0;
                              $bebutton_hole = 0;
                              $bebutton_attach = 0;
                              $bepicot = 0;
        }

                        // 01.Over Lock
                        if ($beover_lock <> $afover_lock)
                        {
                          $olbgd = "$skillOne";
                        }else
                        {
                          $olbgd = "$skillTwo";
                        } 

                        // 02.Flat Lock
                        if ($beflat_lock <> $afflat_lock)
                        {
                          $flbgd = "$skillOne";
                        }else
                        {
                          $flbgd = "$skillTwo";
                        } 

                        // 03.Single Needle
                        if ($besingle_needle <> $afsingle_needle)
                        {
                          $snbgd = "$skillOne";
                        }else
                        {
                          $snbgd = "$skillTwo";
                        } 

                        // 04.Double Needle
                        if ($bedouble_needle <> $afdouble_needle)
                        {
                          $dnbgd = "$skillOne";
                        }else
                        {
                          $dnbgd = "$skillTwo";
                        }

                        // 05.Bar Tack
                        if ($bebar_tack <> $afbar_tack)
                        {
                          $btbgd = "$skillOne";
                        }else
                        {
                          $btbgd = "$skillTwo";
                        } 

                        // 06.Button Hole
                        if ($bebutton_hole <> $afbutton_hole)
                        {
                          $bhbgd = "$skillOne";
                        }else
                        {
                          $bhbgd = "$skillTwo";
                        }

                        // 07.Button Attach
                        if ($bebutton_attach <> $afbutton_attach)
                        {
                          $babgd = "$skillOne";
                        }else
                        {
                          $babgd = "$skillTwo";
                        }

                        // 08.Picot
                        if ($bepicot <> $afpicot)
                        {
                          $pibgd = "$skillOne";
                        }else
                        {
                          $pibgd = "$skillTwo";
                        }
            
          
           ?>
                   
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
                                  <th class="text-center" rowspan="2">Machine Type</th>
                                  <th class="text-center" colspan="2">Skill</th>
                              </tr>
                              <tr>
                                  <th class="text-center" style="background:black; color:white; font-size:18px;">Before</th>
                                  <th class="text-center" style="background:black; color:white; font-size:18px;">After</th>
                              </tr>
                              <tr >
                                  <td>Over Lock</td>
                                  <td class="text-center" style="<?php echo $olbgd; ?>">
                                    <!--Before-->
                                    <?php if($beposId =="2" OR $beposId =="3" OR $beposId =="4" OR $beposId =="5"){?>
                                      <img src="<?php echo $beover_lock; ?>">
                                    <?php } ?>
                                  </td>
                                  <td class="text-center" style="<?php echo $olbgd; ?>">
                                    <!--After-->
                                    <?php if($afposId == "2" OR $afposId == "3" OR $afposId == "4" OR $afposId == "5"){?>
                                      <img src="<?php echo $afover_lock; ?>">
                                    <?php } ?>
                                  </td>
                              </tr>
                              <tr >
                                  <td>Flat Lock</td>
                                  <td class="text-center" style="<?php echo $flbgd; ?>">
                                    <!--Before-->
                                    <?php if($beposId =="2" OR $beposId =="3" OR $beposId =="4" OR $beposId =="5"){?>
                                      <img src="<?php echo $beflat_lock; ?>">
                                    <?php } ?>
                                  </td>
                                  <td class="text-center" style="<?php echo $flbgd; ?>">
                                    <!--After-->
                                    <?php if($afposId == "2" OR $afposId == "3" OR $afposId == "4" OR $afposId == "5"){?>
                                      <img src="<?php echo $afflat_lock; ?>">
                                    <?php } ?>
                                  </td>
                              </tr>
                              <tr >
                                  <td>Single Needle</td>
                                  <td class="text-center" style="<?php echo $snbgd; ?>">
                                    <!--Before-->
                                    <?php if($beposId =="2" OR $beposId =="3" OR $beposId =="4" OR $beposId =="5"){?>
                                      <img src="<?php echo $besingle_needle; ?>">
                                    <?php } ?>
                                  </td>
                                  <td class="text-center" style="<?php echo $snbgd; ?>">
                                    <!--After-->
                                    <?php if($afposId == "2" OR $afposId == "3" OR $afposId == "4" OR $afposId == "5"){?>
                                      <img src="<?php echo $afsingle_needle; ?>">
                                    <?php } ?>
                                  </td>
                              </tr>
                              <tr >
                                  <td>Double Needle</td>
                                  <td class="text-center" style="<?php echo $dnbgd; ?>">
                                    <!--Before-->
                                    <?php if($beposId =="2" OR $beposId =="3" OR $beposId =="4" OR $beposId =="5"){?>
                                      <img src="<?php echo $bedouble_needle; ?>">
                                    <?php } ?>
                                  </td>
                                  <td class="text-center" style="<?php echo $dnbgd; ?>">
                                    <!--After-->
                                    <?php if($afposId == "2" OR $afposId == "3" OR $afposId == "4" OR $afposId == "5"){?>
                                      <img src="<?php echo $afdouble_needle; ?>">
                                    <?php } ?>
                                  </td>
                              </tr>
                              <tr >
                                  <td>Bar Tack</td>
                                  <td class="text-center" style="<?php echo $btbgd; ?>">
                                    <!--Before-->
                                    <?php if($beposId =="2" OR $beposId =="3" OR $beposId =="4" OR $beposId =="5"){?>
                                      <img src="<?php echo $bebar_tack; ?>">
                                    <?php } ?>
                                  </td>
                                  <td class="text-center" style="<?php echo $btbgd; ?>">
                                    <!--After-->
                                    <?php if($afposId == "2" OR $afposId == "3" OR $afposId == "4" OR $afposId == "5"){?>
                                      <img src="<?php echo $afbar_tack; ?>">
                                    <?php } ?>
                                  </td>
                              </tr>
                              <tr >
                                  <td>Button Hole</td>
                                  <td class="text-center" style="<?php echo $bhbgd; ?>">
                                    <!--Before-->
                                    <?php if($beposId =="2" OR $beposId =="3" OR $beposId =="4" OR $beposId =="5"){?>
                                      <img src="<?php echo $bebutton_hole; ?>">
                                    <?php } ?>
                                  </td>
                                  <td class="text-center" style="<?php echo $bhbgd; ?>">
                                    <!--After-->
                                    <?php if($afposId == "2" OR $afposId == "3" OR $afposId == "4" OR $afposId == "5"){?>
                                      <img src="<?php echo $afbutton_hole; ?>">
                                    <?php } ?>
                                  </td>
                              </tr>
                              <tr >
                                  <td>Button Attach</td>
                                  <td class="text-center" style="<?php echo $babgd; ?>">
                                    <!--Before-->
                                    <?php if($beposId =="2" OR $beposId =="3" OR $beposId =="4" OR $beposId =="5"){?>
                                      <img src="<?php echo $bebutton_attach; ?>">
                                    <?php } ?>
                                  </td>
                                  <td class="text-center" style="<?php echo $babgd; ?>">
                                    <!--After-->
                                    <?php if($afposId == "2" OR $afposId == "3" OR $afposId == "4" OR $afposId == "5"){?>
                                      <img src="<?php echo $afbutton_attach; ?>">
                                    <?php } ?>
                                  </td>
                              </tr>
                              <tr >
                                  <td>Picot</td>
                                  <td class="text-center" style="<?php echo $pibgd; ?>">
                                    <!--Before-->
                                    <?php if($beposId =="2" OR $beposId =="3" OR $beposId =="4" OR $beposId =="5"){?>
                                      <img src="<?php echo $bepicot; ?>">
                                    <?php } ?>
                                  </td>
                                  <td class="text-center" style="<?php echo $pibgd; ?>">
                                    <!--After-->
                                    <?php if($afposId == "2" OR $afposId == "3" OR $afposId == "4" OR $afposId == "5"){?>
                                      <img src="<?php echo $afpicot; ?>">
                                    <?php } ?>
                                  </td>
                              </tr>

                       </table>
                  </div>
            </div>
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
 }
?>