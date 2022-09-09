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
if(!isset($_SESSION['mangrSession'])){
        echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
        
}else{
        $user_name = $_SESSION['mangrSession'];
        $userID    = $_SESSION['mangrUid'];

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
                <div id="navbar-right">Welcome : <?php echo $_SESSION['mangrSession'];?> &nbsp; 
                    <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout
                    </a>
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
                        <a href="manage_employee.php"><i class="fa fa-users fa-2x"></i>Teams</a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="fa fa-sign-out fa-2x"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!--DASHBOARD CONTENT-->
         <div id="page-wrapper">
            <div id="page-inner">
                <div class="row"> 
                   <div class="col-md-12 col-lg-12 text-center">
                     <h3>
                        <small style="color:black; float:left; font-size:20px;"><i>Manager Panel</i></small>
                         <strong style="color:green">Dashboard</strong>
                     </h3>
                  </div>
                </div><!--row-->
                <hr/>
                <div class="row">
                 <div class="col-md-12 col-sm-12 col-xs-12 ">
                    <div class="panel" style="background:black;">
                       <div class="panel-heading"> 

                            <?php 

                            $admeSQL = "SELECT  employee.epf_no   AS epf_no, 
                                                employee.position AS position, 
                                                employee.ename    AS ename 
                                                    FROM user 
                                                        INNER JOIN  employee ON user.epf_no =  employee.epf_no 
                                                        WHERE `user`.`id` = '$userID'" ;
                     
                                $admeQyery  = mysqli_query($con, $admeSQL);
                                $adnumOfRow = mysqli_num_rows($admeQyery);
                                $adrow = mysqli_fetch_assoc($admeQyery);
                                $adefp         = $adrow['epf_no'];
                                $adename       = $adrow['ename'];
                                $adposId       = $adrow['position'];
                                

                             //Select Postion Name.
                            if($adposId==0){
                                        $adposNa   = "";

                            }else{

                                $adposSQL   = "SELECT * FROM `position` WHERE `position_id` = $adposId";
                                $adposQuery = mysqli_query($con, $adposSQL);
                                $adposRow   = mysqli_fetch_assoc($adposQuery);
                                $adposNa    = $adposRow['position'];
                                   
                            }
                            ?>
                            <div class="row">
                                <h5 style="color:white;">
                                   
                                    &nbsp;&nbsp;Name :&nbsp;&nbsp;
                                    <small style="color:red;font-size:13px;">
                                    <i><?php  echo $adename; ?></i>
                                   </small>
                                    &nbsp;&nbsp;|&nbsp;&nbsp;Designation :&nbsp;&nbsp;
                                    <small style="color:red;font-size:13px;">
                                    <i><?php  echo $adposNa; ?></i>
                                   </small>
                                    &nbsp;&nbsp;|&nbsp;&nbsp;EPF No :&nbsp;&nbsp;
                                    <span class="badge badge-light" style="background:blue;">
                                    <i><?php  echo $adefp; ?></i>
                                    </span>
                                  </h5>
                                </div> 
                            </div>
                       </div>
                    </div>
                </div>
                
                <div class="row">
                 <div class="col-md-12 col-sm-12 col-xs-12 ">
                    <div class="panel" style="background:black;">
                       <div class="panel-heading">

                        <?php 

                        $meSQL = "SELECT user.id       AS id, 
                                         user.epf_no   AS epf_no,
                                         user.username AS username, 
                                         user.category AS category,   
                                         employee.devision   AS devision, 
                                         employee.team   AS team 
                               
                                  FROM user 
                                        INNER JOIN  employee ON user.epf_no =  employee.epf_no

                                      WHERE `user`.`id` = '$userID'" ;
                       
                      $meQyery  = mysqli_query($con, $meSQL);
                      $numOfRow = mysqli_num_rows($meQyery);
                      $row = mysqli_fetch_assoc($meQyery);
                          $epf_no      = $row['epf_no'];
                          $username    = $row['username'];
                          $devision    = $row['devision'];
                          $team        = $row['team']; 
                

                             //Select Divition Name.
                             if($devision==0){
                                $divNa   = "";

                              }else{
                                          
                             $divSQL   = "SELECT * FROM `devision` WHERE `dev_id` = $devision";
                             $divQuery = mysqli_query($con, $divSQL);
                             $divRow   = mysqli_fetch_assoc($divQuery);
                             $divNa    = $divRow['dev_name'];  
            
                              } 
                            ?>
                            <div class="row">
                                <div class="col-md-3 col-sm-12 col-xs-12"  > 
                                    <h5 style="color:white;"><?php echo $divNa; ?>&nbsp; </h5> 
                                </div>
                                <?php
                                $temSQL   = "SELECT * FROM `team`  WHERE `dev_id1` = '$devision' OR `dev_id2` = '$devision'" ;
                                $temQuery = mysqli_query($con, $temSQL);
                                $tnr      = mysqli_num_rows($temQuery);
                                ?>

                                <div class="col-md-9 col-sm-12 col-xs-12 ">
                                  <h5 style="color:white;">Teams&nbsp;&nbsp;
                                    <span class="badge badge-light" style="background:blue;">
                                        <?php if($tnr >= 0){ echo $tnr;} ?> 
                                    </span>

                                  <?php
                                  $pSQL = "SELECT * FROM `employee`  WHERE `devision` = '$devision'" ;
                                  $pQry = mysqli_query($con, $pSQL);
                                  $pnor = mysqli_num_rows($pQry);
                                  ?>
                                   &nbsp;&nbsp;|&nbsp;&nbsp;Employees&nbsp;&nbsp;
                                    <span class="badge badge-light" style="background:blue;">
                                        <?php if($pnor >= 0){ echo $pnor;} ?> 
                                    </span>
                                  </h5>
                                </div> 
                            </div>
                       </div>
                    </div>
                </div>
                </div>
            </div>
          </div>
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
    
 <?php

}

 ?> 
</body>
</html>