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

                  $beSQL     = "SELECT * FROM `noti_news` WHERE `active_id` = '$dtlId' AND `update_tpye` = 1";
                  $beQuery   = mysqli_query($con, $beSQL);
                  $beNfRows  = mysqli_num_rows($beQuery);
                  $beRow     = mysqli_fetch_assoc($beQuery);

                   $benid   = $beRow['news_id'];
                   $behadig = $beRow['heading'];
                   $beconet = $beRow['content'];

                   if($beRow['active'] == 1){
                      $beactive  = "Active";
                   }else{
                      $beactive  = "Inactive";
                   }


                  //After Notification fatch table data.

                  $afSQL     = "SELECT * FROM `noti_news` WHERE `active_id` = '$dtlId' AND `update_tpye` = 2";
                  $afQuery   = mysqli_query($con, $afSQL);
                  $afNfRows  = mysqli_num_rows($afQuery);
                  $afRow     = mysqli_fetch_assoc($afQuery);

                  $afnid    = $afRow['news_id'];
                  $afhadig  = $afRow['heading'];
                  $afconet  = $afRow['content'];

                  if($afRow['active'] == 1){
                      $afactive  = "Active";
                   }else{
                      $afactive  = "Inactive";
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
                        if ($benid <> $afnid)
                        {
                          $idbgd = "$colorOne";
                        }else
                        {
                          $idbgd = "$colorTwo";
                        }
                        // 02.Header
                        if ($behadig <> $afhadig)
                        {
                          $hadigbgd = "$colorOne";
                        }else
                        {
                          $hadigbgd = "$colorTwo";
                        }

                        // 03.Content
                        if ($beconet <> $afconet)
                        {
                          $conbgd = "$colorOne";
                        }else
                        {
                          $conbgd = "$colorTwo";
                        }

                        // 04.Active / Inactive
                        if ($beactive <> $afactive)
                        {
                          $actbgd = "$colorOne";
                        }else
                        {
                          $actbgd = "$colorTwo";
                        }

                  ?>
                  <tbody> <!--Before and After update News-->
                    <tr><td id="colorTd">ID</td>                   
                                  <td style="<?php echo $idbgd.$othercss; ?>"><?php echo $benid; ?></td>
                                  <td style="<?php echo $idbgd.$othercss; ?>"><?php echo $afnid; ?></td></tr>
                    <tr><td id="colorTd">Header</td>                  
                                  <td style="<?php echo $hadigbgd.$othercss; ?>"><?php echo $behadig; ?></td>
                                  <td style="<?php echo $hadigbgd.$othercss; ?>"><?php echo $afhadig; ?></td></tr>
                    <tr><td id="colorTd">Content</td>                      
                                  <td style="<?php echo $conbgd.$othercss; ?>"><?php echo $beconet; ?></td>
                                  <td style="<?php echo $conbgd.$othercss; ?>"><?php echo $afconet; ?></td></tr>
                    <tr><td id="colorTd">Active / Inactive</td>                   
                                  <td style="<?php echo $actbgd.$othercss; ?>"><?php echo $beactive; ?></td>
                                  <td style="<?php echo $actbgd.$othercss; ?>"><?php echo $afactive; ?></td></tr> 
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