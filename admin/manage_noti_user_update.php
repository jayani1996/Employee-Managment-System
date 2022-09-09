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

                  $dtlId   = $_GET['dtlId'];
                  $notiNum = $_GET['notiNum']; 

                  //Before Notification fatch table data.

                  $beSQL     = "SELECT * FROM `noti_user` WHERE `active_id` = '$dtlId' AND `update_tpye` = 1";
                  $beQuery   = mysqli_query($con, $beSQL);
                  $beNfRows  = mysqli_num_rows($beQuery);
                  $beRow     = mysqli_fetch_assoc($beQuery);

                  $beuid     = $beRow['user_id'];
                  $beepfno   = $beRow['epf_no'];
                  $beuname   = $beRow['username'];
                  $bepass    = $beRow['password'];
                  $becateId  = $beRow['category'];
                  $beuserLvl = $beRow['user_level'];



                    //Select Category Name.
                     if($becateId==0){
                            $becgry   = "";

                     }else{
                       $becateSQL   = "SELECT * FROM `user_category` WHERE `id` = $becateId";
                       $becateQuery = mysqli_query($con, $becateSQL);
                       $becateRow   = mysqli_fetch_assoc($becateQuery);
                       $becgry    = $becateRow['description'];
                    }


                     if($beuserLvl==0){

                           $beulvl   = "";

                     }else{
                      
                        //Select User level.
                        $belvlSQL   = "SELECT * FROM `user_levels` WHERE `id` = $beuserLvl";
                        $belvlQuery = mysqli_query($con, $belvlSQL);
                        $belvlRow   = mysqli_fetch_assoc($belvlQuery);
                        $beulvl    = $belvlRow['description'];

                    }



                  //After Notification fatch table data.

                  $afSQL     = "SELECT * FROM `noti_user` WHERE `active_id` = '$dtlId' AND `update_tpye` = 2";
                  $afQuery   = mysqli_query($con, $afSQL);
                  $afNfRows  = mysqli_num_rows($afQuery);
                  $afRow     = mysqli_fetch_assoc($afQuery);

                  $afuid     = $afRow['user_id'];
                  $afepfno   = $afRow['epf_no'];
                  $afuname   = $afRow['username'];
                  $afpass    = $afRow['password'];
                  $afcateId  = $afRow['category'];
                  $afuserLvl = $afRow['user_level']; 


                    //Select Category Name.
                    if($afcateId==0){
                            $afcgry   = "";

                     }else{
                       $afcateSQL   = "SELECT * FROM `user_category` WHERE `id` = $afcateId";
                       $afcateQuery = mysqli_query($con, $afcateSQL);
                       $afcateRow   = mysqli_fetch_assoc($afcateQuery);
                       $afcgry    = $afcateRow['description'];
                    }


                    if($afuserLvl==0){

                           $afulvl   = "";

                     }else{
                      
                        //Select User level.
                        $aflvlSQL   = "SELECT * FROM `user_levels` WHERE `id` = $afuserLvl";
                        $aflvlQuery = mysqli_query($con, $aflvlSQL);
                        $aflvlRow   = mysqli_fetch_assoc($aflvlQuery);
                        $afulvl     = $aflvlRow['description'];

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


                        // 01.ID
                        if ($beuid <> $afuid)
                        {
                          $uidbgd = "$colorOne";
                        }else
                        {
                          $uidbgd = "$colorTwo";
                        }
                        // 02.EPF No
                        if ($beepfno <> $afepfno)
                        {
                          $epfnobgd = "$colorOne";
                        }else
                        {
                          $epfnobgd = "$colorTwo";
                        }

                        // 03.Username
                        if ($beuname <> $afuname)
                        {
                          $namebgd = "$colorOne";
                        }else
                        {
                          $namebgd = "$colorTwo";
                        }

                        // 04.Password
                        if ($bepass <> $afpass)
                        {
                          $passbgd = "$colorOne";
                        }else
                        {
                          $passbgd = "$colorTwo";
                        } 

                        // 05.Category
                        if ($becgry <> $afcgry)
                        {
                          $cgrybgd = "$colorOne";
                        }else
                        {
                          $cgrybgd = "$colorTwo";
                        }

                        // 06.User Level
                        if ($beulvl <> $afulvl)
                        {
                          $ulvlbgd = "$colorOne";
                        }else
                        {
                          $ulvlbgd = "$colorTwo";
                        }

                  ?>
                  <tbody> <!--Before and After update News-->
                    <tr><td id="colorTd">ID</td>                   
                                  <td style="<?php echo $uidbgd.$othercss; ?>"><?php echo $beuid; ?></td>
                                  <td style="<?php echo $uidbgd.$othercss; ?>"><?php echo $afuid; ?></td></tr>
                    <tr><td id="colorTd">EPF No</td>                   
                                  <td style="<?php echo $epfnobgd.$othercss; ?>"><?php echo $beepfno; ?></td>
                                  <td style="<?php echo $epfnobgd.$othercss; ?>"><?php echo $afepfno; ?></td></tr>
                    <tr><td id="colorTd">Username</td>                  
                                  <td style="<?php echo $namebgd.$othercss; ?>"><?php echo $beuname; ?></td>
                                  <td style="<?php echo $namebgd.$othercss; ?>"><?php echo $afuname; ?></td></tr>
                    <tr><td id="colorTd">Password</td>                      
                                  <td style="<?php echo $passbgd.$othercss; ?>"><?php echo $bepass; ?></td>
                                  <td style="<?php echo $passbgd.$othercss; ?>"><?php echo $afpass; ?></td></tr>
                    <tr><td id="colorTd">Category</td>                   
                                  <td style="<?php echo $cgrybgd.$othercss; ?>"><?php echo $becgry; ?></td>
                                  <td style="<?php echo $cgrybgd.$othercss; ?>"><?php echo $afcgry; ?></td></tr>
                    <tr><td id="colorTd">User Level</td>                   
                                  <td style="<?php echo $ulvlbgd.$othercss; ?>"><?php echo $beulvl; ?></td>
                                  <td style="<?php echo $ulvlbgd.$othercss; ?>"><?php echo $afulvl; ?></td></tr> 
                   </tbody>
                </table>       
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
?>