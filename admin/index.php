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
        $userID    = $_SESSION['adminUid'];
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
                <div id="navbar-right">Welcome : <?php echo $_SESSION['adminSession'];?> &nbsp; 
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
        <!--DASHBOARD CONTENT-->
         <div id="page-wrapper">
            <div id="page-inner">
                <div class="row"> 
                   <div class="col-md-12 col-lg-12 text-center">
                     <h3>
                        <small style="color:black; float:left; font-size:20px;"><i>Admin Panel</i></small>
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
                            $notSQL    = "SELECT * FROM `trxn` WHERE `status` = 'unread'";
                            $notQyery  = mysqli_query($con, $notSQL);
                            $notNfRows = mysqli_num_rows($notQyery); 
                            ?>
                            <div class="row">
                                <div class="col-md-3 col-sm-12 col-xs-12"  >
                                    <a href="manage_notification.php" style="text-decoration: none;color:white;">
                                        <h4>Notifications&nbsp;&nbsp;&nbsp;
                                            <span class="badge badge-light" style="background:blue;">
                                                <?php  if($notNfRows >= 0){ echo $notNfRows; ?><?php } ?>
                                            </span>
                                        </h4>
                                    </a>
                                </div> 
                                 <div class="col-md-2 col-sm-12 col-xs-12 ">
                                    <h4 style="color:lightgreen;">Active Users</h4>
                                </div> 
                                <?php
                                $not1SQL   = "SELECT *
                                                    FROM trxn 
                                                    INNER JOIN user ON trxn.user_id =  user.id
                                                    WHERE user.category = 2 AND trxn.active = 1 ";
                                $not1Qyery  = mysqli_query($con, $not1SQL);
                                $not1NfRows = mysqli_num_rows($not1Qyery); 
                                ?>

                                <div class="col-md-6 col-sm-12 col-xs-12 ">
                                  <h4 style="color:white;">Admin&nbsp;&nbsp;
                                    <span class="badge badge-light" style="background:blue;">
                                        <?php if($not1NfRows >= 0){ echo $not1NfRows;} ?> 
                                    </span>

                                <?php
                                $not2SQL    = "SELECT *
                                                    FROM trxn 
                                                    INNER JOIN user ON trxn.user_id =  user.id
                                                    WHERE user.category = 3 AND trxn.active = 1 ";

                                $not2Qyery  = mysqli_query($con, $not2SQL);
                                $not2NfRows = mysqli_num_rows($not2Qyery);
                                ?>
                                   &nbsp;&nbsp;|&nbsp;&nbsp;HR&nbsp;&nbsp;
                                    <span class="badge badge-light" style="background:blue;">
                                        <?php if($not2NfRows >= 0){ echo $not2NfRows;} ?> 
                                    </span> 
                                    <?php
                                    $not3SQL    = "SELECT *
                                                            FROM trxn 
                                                            INNER JOIN user ON trxn.user_id =  user.id
                                                            WHERE user.category = 4 AND trxn.active = 1 ";

                                    $not3Qyery  = mysqli_query($con, $not3SQL);
                                    $not3NfRows = mysqli_num_rows($not3Qyery); 
                                    ?>
                                    &nbsp;&nbsp;|&nbsp;&nbsp;Manager&nbsp;&nbsp;
                                    <span class="badge badge-light" style="background:blue;">
                                        <?php if($not3NfRows >= 0){ echo $not3NfRows;} ?>
                                    </span>
                                  </h4>
                                </div> 
                            </div>
                       </div>
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-blue">
                            <div class="panel-body">
                                <i class="fa fa-sort-amount-asc fa-5x"></i>
                                <h3><strong>Division</trong></h3>
                            </div>
                            <div class="panel-footer">
                                <a href="devision_manage.php"><button type="button" class="btn btn-primary btn-block">Manage Division</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-pink">
                            <div class="panel-body">
                                <i class="fa fa-users fa-5x"></i>
                                <h3><strong>Team</strong></h3>
                            </div>
                            <div class="panel-footer">
                                <a href="team_manage.php"><button type="button" class="btn btn-primary btn-block">Manage Team</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-yellow">
                            <div class="panel-body">
                                <i class="fa fa-male fa-5x"></i>
                                <h3><strong>Employee</strong></h3>
                            </div>
                            <div class="panel-footer">
                                <a href="manage_employee.php"><button type="button" class="btn btn-primary btn-block">Manage Employee</button></a>
                            </div>
                        </div>
                    </div>
                   <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="panel panel-primary text-center no-boder bg-color-teal">
                        <div class="panel-body">
                            <i class="fa fa-book fa-5x"></i>
                            <h3><strong>News</strong></h3>
                        </div>
                        <div class="panel-footer">
                            <a href="news_manage.php"><button type="button" class="btn btn-primary btn-block">Manage News</button></a>
                        </div>
                    </div>
                </div>
                </div><!--row-->
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