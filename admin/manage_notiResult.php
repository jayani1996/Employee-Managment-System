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
   #change_ahref{

    text-decoration: none;
   }

    #change_h5{

      border-bottom:1px solid black;
    }
    #changeNo{

      color:black;

    }
    #changeDis{
      color:green;
    }

    #changeDtl{
     color:blue; 
    }

    #changeDate{
     color:red; 
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
                     <strong style="color:green">Manage Notifications</strong>
                 </h3>
              </div>
            </div><!--row-->
            <hr/>
            <div class="row">
              <div class="col-md-1">
                  <div class="form-group">
                     <a href="manage_notification.php" class="btn btn-primary">Back</a>
                  </div>
              </div>   
              <div class="col-md-11 col-sm-12 col-xs-12 ">
                <?php 
                 if($_GET['trxn_id']){

                  $trxnID              = $_GET['trxn_id'];
                  $_SESSION['trxn_id'] = $_GET['trxn_id'];
                  
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
            <hr/>
                <div class="jumbotron">
                  <?php

                  $notUpdate = "UPDATE `trxn` SET `status` = 'read' WHERE `trxn`.`trxn_id` = '$trxnID' ";
                  mysqli_query($con, $notUpdate);

                  $notSQL = "SELECT *
                                    FROM trxn 
                                          INNER JOIN  trxn_dtl ON trxn.trxn_id =  trxn_dtl.trxn_id 
                                    WHERE `trxn`.`trxn_id` = '$trxnID'" ;

                    $notQyery  = mysqli_query($con, $notSQL);
                    $numOfRow = mysqli_num_rows($notQyery);
                    if($numOfRow > 0){

                    $i = 1;
                    while($row = mysqli_fetch_assoc($notQyery)){ 

                    $trxn_id     = $row['trxn_id'];
                    $user_id     = $row['user_id'];
                    $dtl_id      = $row['dtl_id'];
                    $type        = $row['type'];             
                    $trxn_date   = $row['trxn_date'];
                    $details     = $row['description'];

                    $typeSQL    = "SELECT `description` FROM `trxn_type` WHERE `id` = '$type'" ;
                    $typeQyery  = mysqli_query($con, $typeSQL);
                    $typeRow    = mysqli_fetch_assoc($typeQyery);   

                    $dsriptin   = $typeRow['description']; 

                      switch ($type) {
                          case 1:
                          ?>
                          <div class="well well-sm">
                            <h5>
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                            </h5>
                          </div>
                          <?php
                          break;

                          case 2:
                          ?>
                        <div class="well well-sm">
                          <a href="manage_noti_emp_insdtl.php?dtlId=<?php echo $dtl_id?>&amp;notiNum=<?php echo $i;?>" id="change_ahref">
                              <h5 id="change_h5">
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                              </h5>
                          </a>
                        </div>
                          <?php
                          break;

                          case 3:
                          ?>
                          <div class="well well-sm">
                          <a href="manage_noti_emp_update.php?dtlId=<?php echo $dtl_id?>&amp;notiNum=<?php echo $i;?>" id="change_ahref"> 
                              <h5  id="change_h5">
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                              </h5>
                            </a>
                          </div>
                          <?php
                          break;

                          case 4:
                          ?>
                          <div class="well well-sm">
                            <a href="manage_noti_emp_insdtl.php?dtlId=<?php echo $dtl_id?>&amp;notiNum=<?php echo $i;?>" id="change_ahref"> 
                              <h5 id="change_h5">
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                              </h5>
                            </a>
                          </div>
                          <?php
                          break;

                          case 5:
                          ?>
                          <div class="well well-sm"> 
                            <h5>
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                            </h5>
                          </div>
                          <?php
                          break;

                          case 6:
                          ?>
                          <div class="well well-sm"> 
                            <h5>
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDtl"> 
                                   <?php echo "(&nbsp;".$details."&nbsp;)&nbsp;"; ?>
                              </span>
                              <span id="changeDis">
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                            </h5>
                          </div>
                          <?php
                          break;

                          case 7:
                          ?>
                          <div class="well well-sm"> 
                            <h5>
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDtl"> 
                                   <?php echo "(&nbsp;".$details."&nbsp;)&nbsp;"; ?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                            </h5>
                          </div>
                          <?php
                          break;
                          case 8:
                          ?>
                          <div class="well well-sm"> 
                            <h5>
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDtl"> 
                                   <?php echo "(&nbsp;".$details."&nbsp;)&nbsp;"; ?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                            </h5>
                          </div>
                          <?php
                          break;
                          case 9:
                          ?>
                          <div class="well well-sm"> 
                            <h5>
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDtl"> 
                                   <?php echo "(&nbsp;".$details."&nbsp;)&nbsp;"; ?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                            </h5>
                          </div>
                          <?php
                          break;
                          case 10:
                          ?>
                          <div class="well well-sm">
                          <a href="manage_noti_news_insdtl.php?dtlId=<?php echo $dtl_id?>&amp;notiNum=<?php echo $i;?>" id="change_ahref"> 
                              <h5 id="change_h5">
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                              </h5>
                            </a>
                          </div>
                          <?php
                          break;
                          case 11:
                          ?>
                          <div class="well well-sm">
                            <a href="manage_noti_news_update.php?dtlId=<?php echo $dtl_id?>&amp;notiNum=<?php echo $i;?>" id="change_ahref"> 
                              <h5 id="change_h5">
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                              </h5>
                            </a>
                          </div>
                          <?php
                          break;
                          case 12:
                          ?>
                          <div class="well well-sm">
                            <a href="manage_noti_news_insdtl.php?dtlId=<?php echo $dtl_id?>&amp;notiNum=<?php echo $i;?>" id="change_ahref"> 
                              <h5 id="change_h5">
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                              </h5>
                            </a>
                          </div>
                          <?php
                          break;
                          case 13:
                          ?>
                          <div class="well well-sm">
                            <a href="manage_noti_user_insdtl.php?dtlId=<?php echo $dtl_id?>&amp;notiNum=<?php echo $i;?>" id="change_ahref"> 
                              <h5 id="change_h5">
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                              </h5>
                            </a>
                          </div>
                          <?php
                          break;
                          case 14:
                          ?>
                          <div class="well well-sm">
                            <a href="manage_noti_user_update.php?dtlId=<?php echo $dtl_id?>&amp;notiNum=<?php echo $i;?>" id="change_ahref"> 
                              <h5 id="change_h5">
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                              </h5>
                            </a>
                          </div>
                          <?php
                          break;
                          case 15:
                          ?>
                          <div class="well well-sm">
                            <a href="manage_noti_user_insdtl.php?dtlId=<?php echo $dtl_id?>&amp;notiNum=<?php echo $i;?>" id="change_ahref"> 
                              <h5 id="change_h5">
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                              </h5>
                            </a>
                          </div>
                          <?php
                          break;
                          case 16:
                          ?>
                          <div class="well well-sm">
                            <h5>
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDtl"> 
                                   <?php echo "(&nbsp;".$details."&nbsp;)&nbsp;"; ?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                            </h5>
                          </div>
                          <?php
                          break;
                          case 17:
                          ?>
                          <div class="well well-sm"> 
                            <h5>
                              <span id="changeNo">
                                <?php echo  $i.")&nbsp;";?>
                              </span>
                              <span id="changeDtl"> 
                                   <?php echo "(&nbsp;".$details."&nbsp;)&nbsp;"; ?>
                              </span>
                              <span id="changeDis"> 
                                   <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                              </span>  
                              <small id="changeDate">
                                    <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                              </small><br>
                            </h5>
                          </div>
                          <?php
                          break;
                          case 18:
                          ?>
                          <div class="well well-sm">
                            <a href="manage_noti_emp_insdtl.php?dtlId=<?php echo $dtl_id?>&amp;notiNum=<?php echo $i;?>" id="change_ahref">
                                <h5 id="change_h5">
                                <span id="changeNo">
                                  <?php echo  $i.")&nbsp;";?>
                                </span>
                                <span id="changeDis"> 
                                     <?php echo ucfirst($dsriptin)."&nbsp;"; ?>
                                </span>  
                                <small id="changeDate">
                                      <i> &nbsp;&nbsp;<?php echo date('F j, Y, g : i a',strtotime($trxn_date)); ?></i>
                                </small><br>
                                </h5>
                            </a>
                          </div>
                          <?php
                          break;
                        
                        default:
                          break;
                      }
                      $i++;
                        }

                  }  
                  } 
                ?>
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