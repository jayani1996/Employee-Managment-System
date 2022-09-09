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
if(!isset($_SESSION['hrSession'])){
        echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
        
}else{
         $user_name = $_SESSION['hrSession'];
         //$empId     = $_SESSION['hremployeeID'];

   
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
                    <a href="logout.php"><i class="fa fa-sign-out fa-2x"></i>Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="page-wrapper">
        <div id="page-inner">

      <?php
       //error_reporting(0);
       if(isset($_POST['submit'])){

   

          $empId          = $_POST['empID'];
          $epf_noNob      = $_SESSION['hrepf_noUp']; 
          $epf_no         = $_POST['epf_no'];
          $posId          = $_POST['position'];
          $ename          = $_POST['ename'];
          $address        = $_POST['address'];
          $dob            = $_POST['dob'];
          $gender         = $_POST['gender'];
         
          $tel_personal   = $_POST['tel_personal'];
          $tel_home       = $_POST['tel_home'];
          $nic            = $_POST['nic'];
          $religion       = $_POST['religion'];
          $civilStatus    = $_POST['civilStatus'];
          $catogory       = $_POST['catogory'];
          $devId          = $_POST['devision'];
          $teamId         = $_POST['team'];
          $new_image      = $_FILES["file"]["name"];
          //Educational Details
          $eduId          = $_POST['minimum_edu'];
          $sports         = $_POST['sports'];
          $extra_edu      = $_POST['extra_edu'];
         // Experience
          $e_doj          = $_POST['e_doj'];
          $other_company  = $_POST['other_company'];
          $occupation     = $_POST['occupation'];
          $time_period    = $_POST['time_period'];
          $remarks        = $_POST['remarks'];


    // sql statment  fot validate duplicate value
    $sqlchek = "SELECT `epf_no` FROM `employee` WHERE `epf_no` = '$epf_no' ";
    $chek    = mysqli_query($con, $sqlchek);

    $chekrow = mysqli_fetch_assoc($chek);

    $chkpfno  =  $chekrow['epf_no'];
   
   if(($epf_noNob==$_POST['epf_no']) || ($chkpfno<>$_POST['epf_no'])){




         //FOR NOTIFICATION

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

          
        $posIdNob         = $_SESSION['hrpositionUp'];  
        $enameNob         = $_SESSION['hrenameUp'];  
        $addressNob       = $_SESSION['hraddressUp'];  
        $dobNob           = $_SESSION['hrdobUp'];  
        $genderNob        = $_SESSION['hrgenderUp'];  
        $tel_plNob        = $_SESSION['hrtel_personalUp'];  
        $tel_homeNob      = $_SESSION['hrtel_homeUp'];  
        $nicNob           = $_SESSION['hrnicUp'];
        $religionNob      = $_SESSION['hrreligionUp'];
        $ciilstusNob      = $_SESSION['hrcivilstatusUp'];
        $catgroyNob       = $_SESSION['hrcatogaroyUp'];  
        $devIdNob         = $_SESSION['hrdevisionUp'];  
        $teamIdNob        = $_SESSION['hrteamUp'];  
        $imageNob         = $_SESSION['hrephotoUp'];  
        $eduIdNob         = $_SESSION['hrminimum_eduUp'];  
        $sportsNob        = $_SESSION['hrsportsUp'];  
        $extra_eduNob     = $_SESSION['hrextra_eduUp'];  
        $e_dojNob         = $_SESSION['hre_dojUp'];  
        $ocompanyNob      = $_SESSION['hrother_companyUp'];   
        $occupationNob    = $_SESSION['hroccupationUp'];  
        $time_periodNob   = $_SESSION['hretime_periodUp'];  
        $remarksNob       = $_SESSION['hrremarksUp']; 



        $befor_trxn_dtl = "INSERT INTO `trxn_dtl`
                                                      (`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
                                                 VALUES 
                                                          ('$trxnDtlid','$trxnid',3,CURRENT_TIMESTAMP)";
        mysqli_query($con, $befor_trxn_dtl);


        $sql_before = "INSERT INTO `noti_employee`
                                                    (
                                                    `emp_id`,`trxn_id`,`active_id`, `update_tpye`, `epf_no`, `position`, `ename`, 
                                                    `address`, `dob`, `gender`, `tel_personal`, `tel_home`, 
                                                     `nic`, `devision`, `team`, `ephoto`,
                                                     `minimum_edu`, `sports`, `extra_edu`, `e_doj`,
                                                     `other_company`, `occupation`, `etime_period`, 
                                                     `remarks`,`religion`,`civilstatus`,`catogaroy`
                                                    ) 
                                                VALUES 
                                                    (
                                                    '$empId','$trxnid','$trxnDtlid',1,'$epf_noNob','$posIdNob','$enameNob','$addressNob',
                                                    '$dobNob','$genderNob','$tel_plNob','$tel_homeNob',
                                                    '$nicNob','$devIdNob','$teamIdNob','$imageNob',
                                                    '$eduIdNob','$sportsNob','$extra_eduNob','$e_dojNob',
                                                    '$ocompanyNob','$occupationNob', '$time_periodNob',
                                                    '$remarksNob','$religionNob','$ciilstusNob','$catgroyNob'
                                                    )";

           mysqli_query($con, $sql_before);



  if($_SESSION['hrpCheck'] == 2 OR $_SESSION['hrpCheck'] == 3 OR $_SESSION['hrpCheck'] == 4 OR $_SESSION['hrpCheck'] == 5){

                      $olNob = $_SESSION['hrover_lockUp'];
                      $flNob = $_SESSION['hrflat_lockUp'];
                      $snNob = $_SESSION['hrsingle_needleUp'];
                      $dnNob = $_SESSION['hrdouble_needleUp'];
                      $btNob = $_SESSION['hrbar_tackUp'];
                      $bhNob = $_SESSION['hrbutton_holeUp'];
                      $baNob = $_SESSION['hrbutton_attachUp'];
                      $piNob = $_SESSION['hrpicotUp'];
           


            $beforeSkill = "INSERT INTO `noti_skill`
                                                          (
                                                          `emp_id`,`trxn_id`, `active_id`,`update_tpye`, `over_lock`, 
                                                          `flat_lock`, `single_needle`, 
                                                          `double_needle`, `bar_tack`, 
                                                          `button_hole`, `button_attach`, `picot`
                                                          ) 
                                                  VALUES 
                                                          (
                                                           '$empId','$trxnid', '$trxnDtlid',1,'$olNob','$flNob',
                                                           '$snNob','$dnNob','$btNob','$bhNob', 
                                                           '$baNob', '$piNob'
                                                         )";

          mysqli_query($con, $beforeSkill);

           }



        if($_SESSION['hrpCheck'] <> 2 AND $_SESSION['hrpCheck'] <> 3 AND $_SESSION['hrpCheck'] <> 4 AND $_SESSION['hrpCheck'] <> 5){

           $value  = $_SESSION['hrpCheck'];
        } else{

           $value = NULL;
        }

       

        if( ($_SESSION['hrpCheck']== $value AND ( $_POST['position']== 2 OR 
                                                  $_POST['position']== 3 OR 
                                                  $_POST['position']== 4 OR 
                                                  $_POST['position']== 5 ))  ) {

      
            // Machine Oparator kanekGe position eka wens karothi eyage Kalin Skills databse eka save 
            //wela thiyenawa ekan puluwan apahu e employeewa machine oparetor kenak karothin kali
            //thibuna skills tika gannna puluwan. eka select karanne e employeege ID ekata saha
            //EPF number eken. 



            $oSkillSQL   = "SELECT * FROM `skill` WHERE `emp_id` = '$empId'";
            $oSkillQuery = mysqli_query($con, $oSkillSQL);
           // while($oSRow= mysqli_fetch_assoc($oSkillQuery)){
           $oSRow= mysqli_fetch_assoc($oSkillQuery);
            //$oSRow= mysqli_fetch_assoc($oSkillQuery);
                $id            = $oSRow['id'];
                // $empIdCheck    = $oSRow['emp_id'];
                //$epfNoCheck    = $oSRow['epf_no'];
                $active_id     = $oSRow['over_lock'];
                $over_lock     = $oSRow['over_lock'];
                $flat_lock     = $oSRow['flat_lock'];
                $single_needle = $oSRow['single_needle'];
                $double_needle = $oSRow['double_needle'];
                $bar_tack      = $oSRow['bar_tack'];
                $button_hole   = $oSRow['button_hole'];
                $button_attach = $oSRow['button_attach'];
                $picot         = $oSRow['picot'];
     //  }
               
                          
       if($oSRow['emp_id']==$empId){


            $olUpdatec   = $over_lock;
            $flUpdatec   = $flat_lock;
            $snUpdatec   = $single_needle;
            $dnUpdatec   = $double_needle;
            $btUpdatec   = $bar_tack;
            $bhUpdatec   = $button_hole;
            $baUpdatec   = $button_attach;
            $piUpdatec   = $picot;


            $SQLCheck = "UPDATE `skill` SET 
                                                   
                                          `active_id`    = '$trxnDtlid',
                                          `over_lock`    = '$olUpdatec',
                                          `flat_lock`    = '$flUpdatec',
                                          `single_needle`= '$snUpdatec',
                                          `double_needle`= '$dnUpdatec',
                                          `bar_tack`     = '$btUpdatec',
                                          `button_hole`  = '$bhUpdatec',
                                          `button_attach`= '$baUpdatec',
                                          `picot`        = '$piUpdatec' 
                                      WHERE 
                                          `skill`.`emp_id` = '$empId'";

                mysqli_query($con, $SQLCheck);

                echo '<script language="javascript">';
                echo 'alert("Old Machine oparetor Found.")';
                echo '</script>';



                // Notofication 

                   $afterSkill = "INSERT INTO `noti_skill`
                                                                      (
                                                                      `emp_id`,`trxn_id`, `active_id`, 
                                                                      `update_tpye`, `over_lock`, 
                                                                      `flat_lock`, `single_needle`, 
                                                                      `double_needle`, `bar_tack`, 
                                                                      `button_hole`, `button_attach`, `picot`
                                                                      ) 
                                                              VALUES 
                                                                      (
                                                                       '$empId','$trxnid', '$trxnDtlid',2,
                                                                       '$olUpdatec','$flUpdatec',
                                                                       '$snUpdatec','$dnUpdatec','$btUpdatec',
                                                                       '$bhUpdatec', '$baUpdatec', '$piUpdatec'
                                                                     )";

                           mysqli_query($con, $afterSkill);

                           // echo '<script language="javascript">';
                            //echo 'alert("Find old emp skills.(noti )")';
                           // echo '</script>';

                         

        }elseif((!$oSRow['emp_id']==$empId)){


               $olInsert   = 0;
               $flInsert   = 0;
               $snInsert   = 0;
               $dnInsert   = 0;
               $btInsert   = 0;
               $bhInsert   = 0;
               $baInsert   = 0;
               $piInsert   = 0;


                $sqlIns = "INSERT INTO `skill`(
                                                `emp_id`,`active_id`,
                                                `over_lock`,`flat_lock`,
                                                `single_needle`,`double_needle`,
                                                `bar_tack`,`button_hole`,
                                                `button_attach`,`picot`
                                              ) 
                                        VALUES(
                                                '$empId','$trxnDtlid',
                                                '$olInsert','$flInsert',
                                                '$snInsert','$dnInsert',
                                                '$btInsert','$bhInsert',
                                                '$baInsert','$piInsert'
                                              )";


                  if($con->query($sqlIns)===TRUE){

                    echo '<script language="javascript">';
                    echo 'alert("This is new Machine Oparater. Please Update Skill Metrics.")';
                    echo '</script>';

                    // Notofication 

                    $afterSkill = "INSERT INTO `noti_skill`
                                                              (
                                                              `emp_id`,`trxn_id`, `active_id`, 
                                                              `update_tpye`, `over_lock`, 
                                                              `flat_lock`, `single_needle`, 
                                                              `double_needle`, `bar_tack`, 
                                                              `button_hole`, `button_attach`, `picot`
                                                              ) 
                                                      VALUES 
                                                              (
                                                               '$empId','$trxnid', '$trxnDtlid',2,
                                                               '$olInsert','$flInsert',
                                                               '$snInsert','$dnInsert','$btInsert',
                                                               '$bhInsert','$baInsert', '$piInsert'
                                                             )";

                           mysqli_query($con, $afterSkill);

                          //  echo '<script language="javascript">';
                          //  echo 'alert("new  emp add skills(noti).")';
                          //  echo '</script>';
                   

                   }



                }


              }elseif($_POST['position']== 2 OR $_POST['position']== 3 OR $_POST['position']== 4 OR $_POST['position']== 5){

                 $olUpdate   = $_POST['over_lock'];
                 $flUpdate   = $_POST['flat_lock'];
                 $snUpdate   = $_POST['single_needle'];
                 $dnUpdate   = $_POST['double_needle'];
                 $btUpdate   = $_POST['bar_tack'];
                 $bhUpdate   = $_POST['button_hole'];
                 $baUpdate   = $_POST['button_attach'];
                 $piUpdate   = $_POST['picot'];


             

              }else{


              }




                   
                if(!empty($new_image)){


                    // .:: Image funtion for crop, resize  and wartermark ::.

                    function image_handler($source_image,$destination,$tn_w = 100,$tn_h = 100,$quality = 80,$wmsource = false) {
                      // The getimagesize functions provides an "imagetype" string contstant, which can be passed to the image_type_to_mime_type function for the corresponding mime type
                      $info = getimagesize($source_image);
                      $imgtype = image_type_to_mime_type($info[2]);
                      // Then the mime type can be used to call the correct function to generate an image resource from the provided image
                      switch ($imgtype) {
                      case 'image/jpeg':
                        $source = imagecreatefromjpeg($source_image);
                        break;
                      case 'image/JPG':
                        $source = imagecreatefromjpeg($source_image);
                        break;
                      case 'image/gif':
                        $source = imagecreatefromgif($source_image);
                        break;
                      case 'image/png':
                        $source = imagecreatefrompng($source_image);
                        break;
                      default:
                        die('Invalid image type.');
                      }
                      // Now, we can determine the dimensions of the provided image, and calculate the width/height ratio
                      $src_w = imagesx($source);
                      $src_h = imagesy($source);
                      $src_ratio = $src_w/$src_h;
                      // Now we can use the power of math to determine whether the image needs to be cropped to fit the new dimensions, and if so then whether it should be cropped vertically or horizontally. We're just going to crop from the center to keep this simple.
                      if ($tn_w/$tn_h > $src_ratio) {
                      $new_h = $tn_w/$src_ratio;
                      $new_w = $tn_w;
                      } else {
                      $new_w = $tn_h*$src_ratio;
                      $new_h = $tn_h;
                      }
                      $x_mid = $new_w/2;
                      $y_mid = $new_h/2;
                      // Now actually apply the crop and resize!
                      $newpic = imagecreatetruecolor(round($new_w), round($new_h));
                      imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
                      $final = imagecreatetruecolor($tn_w, $tn_h);
                      imagecopyresampled($final, $newpic, 0, 0, ($x_mid-($tn_w/2)), ($y_mid-($tn_h/2)), $tn_w, $tn_h, $tn_w, $tn_h);
                      // If a watermark source file is specified, get the information about the watermark as well. This is the same thing we did above for the source image.
                      if($wmsource) {
                      $info = getimagesize($wmsource);
                      $imgtype = image_type_to_mime_type($info[2]);
                      switch ($imgtype) {
                        case 'image/jpeg':
                          $watermark = imagecreatefromjpeg($wmsource);
                          break;
                        case 'image/gif':
                          $watermark = imagecreatefromgif($wmsource);
                          break;
                        case 'image/png':
                          $watermark = imagecreatefrompng($wmsource);
                          break;
                        default:
                          die('Invalid watermark type.');
                      }
                      // Determine the size of the watermark, because we're going to specify the placement from the top left corner of the watermark image, so the width and height of the watermark matter.
                      $wm_w = imagesx($watermark);
                      $wm_h = imagesy($watermark);
                      // Now, figure out the values to place the watermark in the bottom right hand corner. You could set one or both of the variables to "0" to watermark the opposite corners, or do your own math to put it somewhere else.
                      $wm_x = $tn_w - $wm_w;
                      $wm_y = $tn_h - $wm_h;
                      // Copy the watermark onto the original image
                      // The last 4 arguments just mean to copy the entire watermark
                      imagecopy($final, $watermark, $wm_x, $wm_y, 0, 0, $tn_w, $tn_h);
                      }
                      // Ok, save the output as a jpeg, to the specified destination path at the desired quality.
                      // You could use imagepng or imagegif here if you wanted to output those file types instead.
                      if(Imagejpeg($final,$destination,$quality)) {
                      return true;
                      }
                      // If something went wrong
                      return false;
                    }

                  $FileSize = 100000000;

             if($_FILES && $_FILES["file"]["size"] < $FileSize) {


                  //get the uploaded image
                  $source_image = $_FILES["file"]["tmp_name"];
                  //specify the output path in your file system and the image size/quality
                  $newImage = time(). ".jpg" ;
                  $destination = "../images/employee/".$newImage ;
                  $tn_w = 250;
                  $tn_h = 250;
                  $quality = 100;
                  //path to an optional watermark
                  $wmsource = '../images/waterMark1.png';
                  // Try to process the image and echo a small message whether or not it worked. If the image is saved somewhere public, you could add an <img src> tag to display the image here, too!
                  $success = image_handler($source_image,$destination,$tn_w,$tn_h,$quality,$wmsource);
              
                  // old iamge name and path get in session variable


                  if("../images/employee/noimage/noimage.png"!==$_SESSION['hroldImageName']){

                 
                     file_exists($_SESSION['hroldImageName']);
                      unlink($_SESSION['hroldImageName']);
                  }

                      $SUpdate = "UPDATE `employee` SET 
                                                            `active_id`       = '$trxnDtlid',
                                                            `epf_no`          = '$epf_no',
                                                            `position`        = '$posId',
                                                            `ename`           = '$ename',
                                                            `address`         = '$address',
                                                            `dob`             = '$dob',
                                                            `gender`          = '$gender',
                                                            `tel_personal`    = '$tel_personal',
                                                            `tel_home`        = '$tel_home',
                                                            `nic`             = '$nic',
                                                            `devision`        = '$devId',
                                                            `team`            = '$teamId',
                                                            `ephoto`          = '$newImage',
                                                            `minimum_edu`     = '$eduId',
                                                            `sports`          = '$sports',
                                                            `extra_edu`       = '$extra_edu',
                                                            `e_doj`           = '$e_doj',
                                                            `other_company`   = '$other_company',
                                                            `occupation`      = '$occupation',
                                                            `etime_period`    = '$time_period',
                                                            `remarks`         = '$remarks',
                                                            `religion`        = '$religion',
                                                            `civilstatus`     = '$civilStatus',
                                                            `catogaroy`       = '$catogory'

                                                        WHERE
                                                              `employee`.`emp_id` = '$empId'";
                    



   

      if ($con->query($SUpdate)===TRUE) {


        if(($_SESSION['hrpCheck'] == 2 AND $_POST['position']== 2) OR
           ($_SESSION['hrpCheck'] == 3 AND $_POST['position']== 3) OR
           ($_SESSION['hrpCheck'] == 4 AND $_POST['position']== 4) OR 
           ($_SESSION['hrpCheck'] == 5 AND $_POST['position']== 5)){

                      $SQS = "UPDATE `skill` SET 
                                                           
                                                  `active_id`    = '$trxnDtlid',
                                                  `over_lock`    = '$olUpdate',
                                                  `flat_lock`    = '$flUpdate',
                                                  `single_needle`= '$snUpdate',
                                                  `double_needle`= '$dnUpdate',
                                                  `bar_tack`     = '$btUpdate',
                                                  `button_hole`  = '$bhUpdate',
                                                  `button_attach`= '$baUpdate',
                                                  `picot`        = '$piUpdate' 
                                            WHERE 
                                                  `skill`.`emp_id` = '$empId'";

                  mysqli_query($con, $SQS);

                 
          }

                //Notification Add employee


                  $sqlAfterInt = "INSERT INTO `noti_employee`  (
                                                                `emp_id`, `trxn_id`, `active_id`,
                                                                `update_tpye`, 
                                                                `epf_no`, `position`, 
                                                                `ename`, `address`, 
                                                                `dob`, `gender`, 
                                                                `tel_personal`, 
                                                                `tel_home`, `nic`, 
                                                                `devision`, `team`, 
                                                                `ephoto`, `minimum_edu`, 
                                                                `sports`, `extra_edu`, 
                                                                `e_doj`, `other_company`, 
                                                                `occupation`, `etime_period`, 
                                                                `remarks`,`religion`,
                                                                `civilstatus`,`catogaroy`
                                                                ) 
                                                          VALUES 
                                                                (
                                                                '$empId','$trxnid','$trxnDtlid',2,
                                                                '$epf_no','$posId',
                                                                '$ename','$address',
                                                                '$dob','$gender',
                                                                '$tel_personal','$tel_home',
                                                                '$nic','$devId',
                                                                '$teamId','$newImage',
                                                                '$eduId','$sports',
                                                                '$extra_edu','$e_doj',
                                                                '$other_company', '$occupation',
                                                                '$time_period', '$remarks',
                                                                '$religion','$civilStatus',
                                                                '$catogory'
                                                                )";


                    if ($con->query($sqlAfterInt)===TRUE) {



                      if(($_SESSION['hrpCheck'] == 2 AND $_POST['position']== 2) OR
                         ($_SESSION['hrpCheck'] == 3 AND $_POST['position']== 3) OR 
                         ($_SESSION['hrpCheck'] == 4 AND $_POST['position']== 4) OR 
                         ($_SESSION['hrpCheck'] == 5 AND $_POST['position']== 5)){

                            $afterSkill = "INSERT INTO `noti_skill`
                                                                      (
                                                                      `emp_id`,`trxn_id`, `active_id`, 
                                                                      `update_tpye`, `over_lock`, 
                                                                      `flat_lock`, `single_needle`, 
                                                                      `double_needle`, `bar_tack`, 
                                                                      `button_hole`, `button_attach`, `picot`
                                                                      ) 
                                                              VALUES 
                                                                      (
                                                                       '$empId','$trxnid', '$trxnDtlid',2,
                                                                       '$olUpdate','$flUpdate',
                                                                       '$snUpdate','$dnUpdate','$btUpdate',
                                                                       '$bhUpdate', 
                                                                       '$baUpdate', '$piUpdate'
                                                                     )";

                      

                          if ($con->query($afterSkill)===TRUE) {

                            echo '<script language="javascript">';
                            echo 'alert("Skills Updated.")';
                            echo '</script>';

                         }else{

                          echo '<script language="javascript">';
                            echo 'alert("Skills not Updated.")';
                            echo '</script>';
                         }

                }




                    }


                      echo '<script language="javascript">';
                      echo 'alert("employee Updated.")';
                      echo '</script>';
                    
                      
                     echo "<script type='text/javascript'>window.location.href = 'manage_employee.php';</script>";
                  }else{
                      echo "Error Updating record : " . $con->error;

                      echo '<script language="javascript">';
                      echo 'alert("employee not Updated.")';
                      echo '</script>';
                  }
                    

                  

                }else{

                ?>

              <div class="row">
               <div class="col-md-2">
                  <a href="manage_employee_update.php?update=<?php echo $epf_no; ?>" class="btn btn-primary btn-block">Back to form</a>
               </div>
                 <div class="col-md-8 text-center">
                    <h1>Dear &nbsp;<strong><?php echo $_SESSION['hrSession']; ?></strong></h1>
                   
                    <hr>
                    <h3><span style="color:red"><span><b>Invalid file Size</b></span></h3>
                    <b>File Size :</b><a> <?php echo round(($_FILES["file"]["size"] / 1024),2) ?>KB </a>
                </div>
              </div>

              <?php


        }
      }else{          

                          $SUpdate = "UPDATE `employee` 
                                                        SET 
                                                            `active_id`       = '$trxnDtlid',
                                                            `epf_no`          = '$epf_no',
                                                            `position`        = '$posId',
                                                            `ename`           = '$ename',
                                                            `address`         = '$address',
                                                            `dob`             = '$dob',
                                                            `gender`          = '$gender',
                                                            `tel_personal`    = '$tel_personal',
                                                            `tel_home`        = '$tel_home',
                                                            `nic`             = '$nic',
                                                            `devision`        = '$devId',
                                                            `team`            = '$teamId',
                                                            `minimum_edu`     = '$eduId',
                                                            `sports`          = '$sports',
                                                            `extra_edu`       = '$extra_edu',
                                                            `e_doj`           = '$e_doj',
                                                            `other_company`   = '$other_company',
                                                            `occupation`      = '$occupation',
                                                            `etime_period`    = '$time_period',
                                                            `remarks`         = '$remarks',
                                                            `religion`        = '$religion',
                                                            `civilstatus`     = '$civilStatus',
                                                            `catogaroy`       = '$catogory'

                                                        WHERE
                                                           
                                                             `employee`.`emp_id` = '$empId'";

           if ($con->query($SUpdate)===TRUE) {



             if(($_SESSION['hrpCheck'] == 2 AND $_POST['position']== 2) OR 
                ($_SESSION['hrpCheck'] == 3 AND $_POST['position']== 3) OR 
                ($_SESSION['hrpCheck'] == 4 AND $_POST['position']== 4) OR 
                ($_SESSION['hrpCheck'] == 5 AND $_POST['position']== 5)){


                   $SQS = "UPDATE `skill` SET 
                                                           
                                                  `active_id`    = '$trxnDtlid',
                                                  `over_lock`    = '$olUpdate',
                                                  `flat_lock`    = '$flUpdate',
                                                  `single_needle`= '$snUpdate',
                                                  `double_needle`= '$dnUpdate',
                                                  `bar_tack`     = '$btUpdate',
                                                  `button_hole`  = '$bhUpdate',
                                                  `button_attach`= '$baUpdate',
                                                  `picot`        = '$piUpdate' 
                                            WHERE 
                                                  `skill`.`emp_id` = '$empId'";



                if($con->query($SQS)===TRUE){

                 }
          }




            //Notification Add employee

            $sqlAfterInt = "INSERT INTO `noti_employee`  (
                                                           `emp_id`, `trxn_id`, `active_id`,
                                                           `update_tpye`, 
                                                           `epf_no`, `position`,
                                                           `ename`, `address`, 
                                                           `dob`, `gender`, 
                                                           `tel_personal`, 
                                                           `tel_home`, `nic`, 
                                                           `devision`, `team`, 
                                                           `ephoto`, `minimum_edu`, 
                                                           `sports`, `extra_edu`, 
                                                           `e_doj`, `other_company`, 
                                                           `occupation`, `etime_period`, 
                                                           `remarks`, `religion`,
                                                           `civilstatus`,`catogaroy`
                                                           ) 
                                                      VALUES 
                                                          (
                                                            '$empId','$trxnid','$trxnDtlid',2,
                                                            '$epf_no','$posId',
                                                            '$ename','$address',
                                                            '$dob','$gender',
                                                            '$tel_personal','$tel_home',
                                                            '$nic','$devId',
                                                            '$teamId','$imageNob',
                                                            '$eduId','$sports',
                                                            '$extra_edu','$e_doj',
                                                            '$other_company', '$occupation',
                                                            '$time_period', '$remarks',
                                                            '$religion','$civilStatus',
                                                            '$catogory'
                                                           )";



      if ($con->query($sqlAfterInt)===TRUE) {

                       if(($_SESSION['hrpCheck'] == 2 AND $_POST['position']== 2) OR
                          ($_SESSION['hrpCheck'] == 3 AND $_POST['position']== 3) OR
                          ($_SESSION['hrpCheck'] == 4 AND $_POST['position']== 4) OR
                          ($_SESSION['hrpCheck'] == 5 AND $_POST['position']== 5)){



                         $afterSkill = "INSERT INTO `noti_skill`
                                                                      (
                                                                      `emp_id`,`trxn_id`, `active_id`, 
                                                                      `update_tpye`, `over_lock`, 
                                                                      `flat_lock`, `single_needle`, 
                                                                      `double_needle`, `bar_tack`, 
                                                                      `button_hole`, `button_attach`, `picot`
                                                                      ) 
                                                              VALUES 
                                                                      (
                                                                       '$empId','$trxnid', '$trxnDtlid',2,
                                                                       '$olUpdate','$flUpdate',
                                                                       '$snUpdate','$dnUpdate','$btUpdate',
                                                                       '$bhUpdate', 
                                                                       '$baUpdate', '$piUpdate'
                                                                     )";

                      
                         if ($con->query($afterSkill)===TRUE) {

                            echo '<script language="javascript">';
                            echo 'alert("Skills Updated.")';
                            echo '</script>';

                         }else{

                          echo '<script language="javascript">';
                            echo 'alert("Skills not Updated.")';
                            echo '</script>';
                         }

                            //echo '<script language="javascript">';
                           // echo 'alert("POSITION CHECK Updated AND Old Image.")';
                           // echo '</script>';

                }
                 
           }
                   echo '<script language="javascript">';
                   echo 'alert("employee Updated.")';
                   echo '</script>';

                   echo "<script type='text/javascript'>window.location.href = 'manage_employee.php';</script>";
                  }else{
                      echo "Error Updating record : " . $con->error;

                      echo '<script language="javascript">';
                      echo 'alert("employee not Updated. ")';
                      echo '</script>';
                  }
    }

}else{


      echo '<script language="javascript">';
      echo 'alert("Already this epf inserted.")';
      echo '</script>';

      echo "<script type='text/javascript'>window.location.href = 'manage_employee.php';</script>";

  
}

?>



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