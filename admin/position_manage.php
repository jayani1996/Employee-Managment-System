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
                <div id="navbar-right">Welcome : <?php echo $_SESSION['adminSession'];?> &nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a>
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
                        <a href="position_manage.php"  class="active-menu"><i class="fa fa-sort fa-2x"></i>Designation</a>
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
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                   <div class="col-md-12 col-lg-12 text-center">
                     <h3>
                      <small style="color:black; float:left; font-size:20px;"><i>Admin Panel</i></small>
                      <strong style="color:green">Manage Designation</strong>
                    </h3>
                  </div>
                </div><!--row-->
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <!-- Button to Open the Modal -->
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Add Designation ++
                              </button>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-offset-7">
                       <div class="form-group">
                            <?php 

                                $sqlSelect = "SELECT * FROM `position`";
                                $sqlQuery  = mysqli_query($con, $sqlSelect);
                                $numOfRow  = mysqli_num_rows($sqlQuery);
                            ?>
                            <label>
                                <strong style="color:green;font-size:20px;">Designation</strong> &nbsp;&nbsp;
                                <strong style="color:navy;font-size:20px;">(<?php echo $numOfRow - 1;  ?>)</strong>
                           </label>
                       </div>
                    </div>
                </div>
                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                  <div class="modal-dialog">
                    <div class="modal-content">
                    
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">Add Designation</h4>
                       
                      </div>
                      
                      <!-- Modal body -->
                      <form action="position_add_query.php" method="post">
                          <div class="modal-body">
                               <div class="row">
                                  <div class="form-group">
                                      <label>Designation:</label>
                                      <input type="text" class="form-control" name="position" placeholder="Designation.">
                                  </div>
                              </div>
                          </div>
                          <!-- Modal footer -->
                          <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          </div>
                      </form>
                      
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                      Designation table
                  </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                <div class=" col-md-12 table-responsive" style="overflow-x:auto;">
                   <table class="table-bordered table table-striped table-hover" id="dataTables-example">
                      <thead>
                          <tr>
                            <th  class="text-center">Designation</th>
                            <th  class="text-center">Delete</th>
                          </tr>
                    </thead>
                    <tbody>
                          <?php
                          if($numOfRow > 0)
                          {

                          while($row = mysqli_fetch_assoc($sqlQuery)){
                             $posId     = $row['position_id'];
                             $position  = $row['position'];

                          if(!$posId == 0){

                          if($posId == 2 OR $posId == 3 OR $posId == 4 OR $posId == 5){
                          ?>

                            <tr>
                              <td><?php echo $position; ?></td>
                              <td class="text-center">
                               <a onclick="deleteme(<?php echo $posId; ?>)" class="btn btn-danger btn-xs" disabled>
                               Remove</a> 
                              </td> 
                            </tr>
                          <?php
                           } else { ?>
                            <tr>
                              <td><?php echo $position; ?></td>
                              <td class="text-center">
                               <a onclick="deleteme(<?php echo $posId; ?>)" class="btn btn-danger btn-xs">Remove</a> 
                              </td> 
                            </tr>
                      <?php
                           }
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

        <!--Delete Javascript function-->    
        <script type="text/javascript">
                
        function deleteme(delid){

        if(confirm("Do you want delete!")){
            window.location.href='position_delete.php?delete=' +delid+ '';
            return true;
        }

        }
        </script>

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

      <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>
</body>
</html>
<?php 
}
?>