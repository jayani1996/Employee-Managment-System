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
       // $user_id   = $_SESSION['hrUid'];

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

     


      // This function we used for hide simple errors in program. but that errors not bug.
      //error_reporting(0);

      if(isset($_POST['submit']))
      { 
              

           
    
      
        //Find Same EPF Numbers

       $sqlEpfNo = "SELECT `epf_no`FROM `employee` WHERE  epf_no ='".$_POST['epf_no']."'"; 
       $EpfNoQry = mysqli_query($con, $sqlEpfNo);
       $row1     = mysqli_fetch_assoc($EpfNoQry);
         

        if($row1["epf_no"]==$_POST['epf_no']){

         
         echo '<script language="javascript">';
         echo 'alert("Already epf no Inserted.")';
         echo '</script>';
         echo "<script type='text/javascript'>window.location.href = 'manage_employee.php';</script>";

        }else{





                //Get maximum employee id form employee table
                function get_emp_max()
                  { 
                    $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
                    mysqli_select_db($con, DB_NAME);
                    $empmax = mysqli_query($con, "SELECT MAX(`emp_id`) as max FROM `employee`");
                    while ($empmaxRow = mysqli_fetch_assoc($empmax)) {

                    $empmaxid  =  $empmaxRow["max"] + 1;
                       
                    }
                    return $empmaxid;
                  }


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

              
              $trxnid     = $_SESSION['hrtranxactionId']; 
              $trxnDtlid  = get_trxn_dtl_max();
              $_SESSION['hrtrxnDtlid'] = $trxnDtlid;
              $empId      = get_emp_max();
              $_SESSION['hremployeeId'] = $empId; 

              $epf_no            = $_POST['epf_no'];
              $position          = $_POST['position'];
              $ename             = $_POST['ename'];
              $address           = $_POST['address'];
              $dob               = $_POST['dob'];
              $gender            = $_POST['gender'];
              $tel_personal      = $_POST['tel_personal'];
              $tel_home          = $_POST['tel_home'];
              $nic               = $_POST['nic'];
              $religion          = $_POST['religion'];
              $civilStatus       = $_POST['civilStatus'];
              $catogory          = $_POST['catogory'];
              $devision          = $_POST['devision'];
              $team              = $_POST['team'];
              //Educational Details
              $minimum_edu       = $_POST['minimum_edu'];
              $extra_edu         = $_POST['extra_edu'];
              $sports            = $_POST['sports'];
             
              //Experience
              $e_doj             = $_POST['e_doj']; 
              $other_company     = $_POST['other_company'];
              $occupation        = $_POST['occupation'];
              $time_period       = $_POST['time_period'];


              
              //Oparational Skills

                if(!empty($_POST['over_lock'])){

                        if($_POST['over_lock'] == "1"){
                              $over_lock   = 1;
                        }elseif($_POST['over_lock'] == "2"){
                                $over_lock   = 2;
                        }elseif($_POST['over_lock'] == "3"){
                                $over_lock   = 3;

  
                      }
                  }else{

                      $over_lock   = 0;
                  }

                if(!empty($_POST['flat_lock'])){

                     if($_POST['flat_lock'] == "1"){
                          $flat_lock   = 1;
                     }elseif($_POST['flat_lock'] == "2"){
                          $flat_lock   = 2;
                     }elseif($_POST['flat_lock'] == "3"){
                          $flat_lock   = 3;

 
                    }

                  }else{

                    $flat_lock   = 0;

                  }
  
                if(!empty($_POST['single_needle'])){
                    if($_POST['single_needle'] == "1"){
                          $single_needle   = 1;
                    }elseif($_POST['single_needle'] == "2"){
                          $single_needle   = 2;
                    }elseif($_POST['single_needle'] == "3"){
                          $single_needle   = 3;

                    }
                  }else{
                    $single_needle   = 0;
                  }

                if(!empty($_POST['double_needle'])){
                      if($_POST['double_needle'] == "1"){
                          $double_needle   = 1;
                      }elseif($_POST['double_needle'] == "2"){
                          $double_needle   = 2;
                      }elseif($_POST['double_needle'] == "3"){
                          $double_needle   = 3;

   
                    }
                   }else{
                      $double_needle   = 0;
                   }

                if(!empty($_POST['bar_tack'])){
                      if($_POST['bar_tack'] == "1"){
                              $bar_tack   = 1;
                      }elseif($_POST['bar_tack'] == "2"){
                              $bar_tack   = 2;
                      }elseif($_POST['bar_tack'] == "3"){
                              $bar_tack   = 3;

                    }
                  }else{
                    $bar_tack   = 0;
                  }

                if(!empty($_POST['button_hole'])){
                      if($_POST['button_hole'] == "1"){
                             $button_hole = 1;
                      }elseif($_POST['button_hole'] == "2"){
                             $button_hole = 2;
                      }elseif($_POST['button_hole'] == "3"){
                             $button_hole = 3;

             
                       }
                   }else{
                        $button_hole = 0;
                   }

                if(!empty($_POST['button_attach'])){
                  if($_POST['button_attach'] == "1"){
                         $button_attach = 1;
                  }elseif($_POST['button_attach'] == "2"){
                         $button_attach = 2;
                  }elseif($_POST['button_attach'] == "3"){
                         $button_attach = 3;

               
                    }
                  }else{
                      $button_attach = 0;

                  }

                if(!empty($_POST['picot'])){

                    if($_POST['picot'] == "1"){
                         $picot = 1;
                    }elseif($_POST['picot'] == "2"){
                         $picot = 2;
                    }elseif($_POST['picot'] == "3"){
                         $picot = 3;

                    }      
                  }else{
                    $picot = 0;
                  }




          if(empty($_FILES["file"]["name"])){

                $newImage = "noimage.png";
          }else{

            $FileSize = 100000000;

          if($_FILES && $_FILES["file"]["size"] < $FileSize) {



            //Add image funtion .
            function image_handler($source_image,$destination,$tn_w = 100,$tn_h = 100,$quality = 80,$wmsource = false) {
            // The getimagesize functions provides an "imagetype" string contstant, which can be passed to the image_type_to_mime_type function for the corresponding mime type
            $info = getimagesize($source_image);
            $imgtype = image_type_to_mime_type($info[2]);
            // Then the mime type can be used to call the correct function to generate an image resource from the provided image
            switch ($imgtype) {
            case 'image/jpeg':
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

           }

         }
  
         if(empty($_FILES["file"]["name"]) || $_FILES["file"]["size"] < $FileSize) {






                 $trxn_dtl = "INSERT INTO `trxn_dtl`
                                                      (`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
                                                 VALUES 
                                                          ('$trxnDtlid','$trxnid',2,CURRENT_TIMESTAMP)";
                 mysqli_query($con, $trxn_dtl);


             



          
                  $sql_ins = "INSERT INTO `employee`
                                                          (
                                                          `emp_id`,`active_id`, `epf_no`, `position`, `ename`, `address`, 
                                                           `dob`, `gender`, `tel_personal`, `tel_home`, 
                                                           `nic`, `devision`, `team`, `ephoto`,
                                                           `minimum_edu`, `sports`, `extra_edu`, `e_doj`,
                                                           `other_company`, `occupation`,
                                                           `etime_period`,`religion`,`civilstatus`,`catogaroy`
                                                          ) 
                                                      VALUES 
                                                          (
                                                          '$empId','$trxnDtlid','$epf_no','$position','$ename','$address',
                                                          '$dob','$gender','$tel_personal','$tel_home',
                                                          '$nic','$devision','$team','$newImage',
                                                          '$minimum_edu','$sports','$extra_edu','$e_doj',
                                                          '$other_company','$occupation',
                                                          '$time_period','$religion','$civilStatus','$catogory'
                                                          )";


                 $sql_noti = "INSERT INTO `noti_employee`
                                                          (
                                                          `emp_id`,`trxn_id`,`active_id`, `epf_no`, `position`, `ename`, `address`, 
                                                           `dob`, `gender`, `tel_personal`, `tel_home`, 
                                                           `nic`, `devision`, `team`, `ephoto`,
                                                           `minimum_edu`, `sports`, `extra_edu`, `e_doj`,
                                                           `other_company`, `occupation`,
                                                           `etime_period`,`religion`,`civilstatus`,`catogaroy`
                                                          ) 
                                                      VALUES 
                                                          (
                                                          '$empId','$trxnid','$trxnDtlid','$epf_no','$position','$ename','$address',
                                                          '$dob','$gender','$tel_personal','$tel_home',
                                                          '$nic','$devision','$team','$newImage',
                                                          '$minimum_edu','$sports','$extra_edu','$e_doj',
                                                          '$other_company','$occupation',
                                                          '$time_period','$religion','$civilStatus','$catogory'
                                                          )";

          

          if ($con->query($sql_ins)===TRUE AND $con->query($sql_noti) ===TRUE) {

            //This SQL Query Will run Employee position only Machine Oparater.

       if($position =="2" OR $position =="3" OR $position =="4" OR $position =="5"){

             $sql_ins2 = "INSERT INTO `skill`(`emp_id`,`active_id`,
                                              `over_lock`,`flat_lock`,
                                              `single_needle`,`double_needle`,
                                              `bar_tack`,`button_hole`,
                                              `button_attach`,`picot`
                                            ) 
                                      VALUES
                                            ('$empId','$trxnDtlid',
                                            '$over_lock','$flat_lock',
                                            '$single_needle','$double_needle',
                                            '$bar_tack','$button_hole',
                                            '$button_attach','$picot'
                                          )";


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

       if($con->query($sql_ins2)===TRUE AND $con->query($sql_noti2)){

            }
        }
                      
        echo '<script language="javascript">';
        echo 'alert("Employee Inserted.")';
        echo '</script>';
         
        echo "<script type='text/javascript'>window.location.href = 'manage_employee_result.php';</script>";

        }else{

        echo "Error Updating record : " . $con->error;

        echo '<script language="javascript">';
        echo 'alert("Employee Not Inserted.")';
        echo '</script>';

        echo "<script type='text/javascript'>window.location.href = 'manage_employee_result.php';</script>";
        }                                 


       

      } else{
          ?>
               <div class="row">
                  <div class="col-md-12 col-lg-12 text-center">
                    <h3>
                      <small style="color:black; float:left; font-size:20px;"><i>HR Panel</i></small>
                      <strong style="color:green">Add Employees</strong>
                  </h3>
                  </div>
              </div>
              <hr/>
              <div class="row">
                 <div class="col-md-2">
                    <a href="manage_employee.php" class="btn btn-primary">Back to list</a>
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

          }
        } // main if

?>

      </div><!--page inner-->
  </div><!--page wrapper-->
</div><!--wrapper-->

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
</body>
</html>
<?php
    
  }
  
 ?>
