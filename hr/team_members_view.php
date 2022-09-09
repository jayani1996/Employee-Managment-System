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
                        <a href="team_manage.php"  class="active-menu"><i class="fa fa-users fa-2x"></i>Team</a>
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
        <!--DASHBOARD CONTENT-->
        <?php 
        if(isset($_GET['team_id'])){

            $teamId      = $_GET['team_id'];
            $_SESSION['hrteamId'] = $_GET['team_id'];     
            $sqlTeam      = "SELECT * FROM  team WHERE `team_id` = '$teamId'";
            $sqlTeamQuery = mysqli_query($con, $sqlTeam);
            $row1         = mysqli_fetch_assoc($sqlTeamQuery);
            $teamId       = $row1['team_id'];
            $teamNa       = $row1['team_name'];
            $divId1       = $row1['dev_id1'];
            $divId2       = $row1['dev_id2'];
            ?>

         <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                   <div class="col-md-12 col-lg-12 text-center">
                     <h3>
                      <small style="color:black; float:left; font-size:20px;"><i>HR Panel</i></small>
                      <strong style="color:green"><?php echo $teamNa;?></strong>&nbsp;&nbsp;(Members)
                    </h3>
                  </div>
                </div><!--row-->
                <hr/>

                <?php 

                    $sqlSelect = "SELECT * FROM 
                                                 `employee` 
                                           WHERE 
                                                 `team` = '$teamId' AND `devision` = '$divId1' OR `devision` = '$divId2'
                                           ORDER By 
                                                 `emp_id` ASC ";

                    $sqlQuery  = mysqli_query($con, $sqlSelect);
                    $numOfRow  = mysqli_num_rows($sqlQuery);
                ?>
                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                           <a href="team_manage.php" class="btn btn-primary">Back to teams</a>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-7">
                       <div class="form-group">
                            <label>
                                <strong style="color:green;font-size:20px;">Employees</strong> &nbsp;&nbsp;
                                <strong style="color:navy;font-size:20px;">(<?php echo $numOfRow;  ?>)</strong>
                           </label>
                       </div>
                    </div>
                </div>
                <hr>
                <div class="panel panel-default">
                        <div class="panel-heading">
                            Team table
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                      <div class=" col-md-12 table-responsive" style="overflow-x:auto;">
                         <table class="table-bordered table table-striped table-hover" id="dataTables-example">
                            <thead>
                              <tr>
                                <th class="text-center">EPF No</th>
                                <th class="text-center">Designation</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Division</th>
                                <th class="text-center">View</th>
                              </tr>
                        </thead>
                        <tbody>
                        <?php
                            if($numOfRow > 0)
                            {

                            while($row = mysqli_fetch_assoc($sqlQuery)){

                               $emp_id = $row['emp_id'];
                               $epf_no = $row['epf_no'];
                               $posId  = $row['position'];
                               $ename  = $row['ename'];
                               $devId  = $row['devision'];


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



                        ?>

                              <tr>
                                <td><?php echo $epf_no; ?></td>
                                <td><?php echo $posNa; ?></td>
                                <td><?php echo $ename; ?></td>
                                <td><?php echo $divNa; ?></td>
                                <td class="text-center"><a href="team_member_onebyone_view.php?emp_id=<?php echo $emp_id; ?>" class="btn btn-primary btn-xs">View</a></td>
                                
                              </tr>

                        <?php 
                            }
                              }
                                }
                        ?>
                        </tbody>
                    </table>
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
    <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="../assets/js/morris/morris.js"></script>
    
    <!-- Table Pages And Table data Search function -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

     <!--PRINT BUTTON-->
    <script type="text/javascript">
        function printlayer(layer) {
            var generator = window.open(",'name,");
            var layetext = document.getElementById(layer);
            generator.document.write(layetext.innerHTML.replace("Print Me"));

            generator.document.close();
            generator.print();
            generator.close();
        }
    </script>

      <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>
    
 <?php

}

 ?> 
</body>
</html>