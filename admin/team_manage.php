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
                        <a href="team_manage.php" class="active-menu"><i class="fa fa-users fa-2x"></i>Team</a>
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
        <div id="page-wrapper">
            <div id="page-inner">
                 <div class="row">
                   <div class="col-md-12 col-lg-12 text-center">
                     <h3>
                      <small style="color:black; float:left; font-size:20px;"><i>Admin Panel</i></small>
                      <strong style="color:green">Manage Team</strong>
                    </h3>
                  </div>
                </div><!--row-->
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <!-- Button to Open the Modal -->
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Add team ++
                              </button>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-offset-8">
                       <div class="form-group">
                            <?php 

                                $sqlSelect = "SELECT * FROM `team`";
                                $sqlQuery  = mysqli_query($con, $sqlSelect);
                                $numOfRow  = mysqli_num_rows($sqlQuery);
                            ?>
                           <label>
                                <strong style="color:green;font-size:20px;">Teams</strong> &nbsp;&nbsp;
                                <strong style="color:navy;font-size:20px;">(<?php echo $numOfRow -1;  ?>)</strong>
                           </label>
                       </div>
                    </div>
                </div>
                <hr>

                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">Add Team</h4>
                      </div>
                      <!-- Modal body -->
                      <form action="team_add_query.php" method="post">
                          <div class="modal-body">
                               <div class="row">
                                  <div class="form-group">
                                      <label>Team:</label>
                                      <input type="text" class="form-control" name="team_name" placeholder="Enter team name." autocomplete="off">
                                  </div>
                                  <div class="form-group">
                                      <label>Choose Divisions</label>
                                      <?php
                                            $sqlSelect2 = "SELECT * FROM `devision`";
                                            $sqlQuery2 = mysqli_query($con, $sqlSelect2);
                                            $numOfRow2 = mysqli_num_rows($sqlQuery2);
                                      ?>
                                      <select class="form-control" name="dev_id1">
                                          <option>~ SELECT 1 ~</option>
                                          <?php 
                                                while ($row = mysqli_fetch_assoc($sqlQuery2)) {
                                          ?>
                                          <option value="<?php echo $row['dev_id'] ?>"><?php echo $row['dev_name']; ?></option>
                                          <?php
                                              }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <?php
                                            $sqlSelect2 = "SELECT * FROM `devision`";
                                            $sqlQuery2 = mysqli_query($con, $sqlSelect2);
                                            $numOfRow2 = mysqli_num_rows($sqlQuery2);
                                      ?>
                                      <select class="form-control" name="dev_id2">
                                          <option>~ SELECT 2 ~</option>
                                          <?php 
                                                while ($row = mysqli_fetch_assoc($sqlQuery2)) {
                                          ?>
                                          <option value="<?php echo $row['dev_id'] ?>"><?php echo $row['dev_name']; ?></option>
                                          <?php
                                              }
                                          ?>
                                      </select>
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
                      Team table
                  </div>
                  <!-- /.panel-heading -->
                  <div class="panel-body">
                    <div class=" col-md-12 table-responsive" style="overflow-x:auto;">
                     <table class="table-bordered table table-striped table-hover" id="dataTables-example">
                      <thead>
                          <tr>
                            <th  class="text-center">Team Name</th>
                            <th  class="text-center">View Members</th>
                            <th  class="text-center">Delete</th>
                          </tr>
                    </thead>
                    <tbody>
                          <?php
                              if($numOfRow > 0)
                              {

                              while($row = mysqli_fetch_assoc($sqlQuery)){
                                 $team_id       = $row['team_id'];
                                 $team_name     = $row['team_name'];

                                if(!$team_id == 0){
                          ?>

                                <tr>
                                  <td class="text-center"><?php echo $team_name; ?></td>
                                  <td class="text-center"><a href="team_members_view.php?team_id=<?php echo $team_id; ?>" class="btn btn-primary btn-xs">View</a></td>
                                  <td class="text-center"><a onclick="deleteme(<?php echo $row['team_id']; ?>)"  class="btn btn-danger btn-xs">Remove</a></td>
                                  
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

<!--Delete Javascript function-->    
<script type="text/javascript">
        
function deleteme(delid){

if(confirm("Do you want delete!")){
    window.location.href='team_delete.php?delete=' +delid+ '';
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
</body>
</html>
<?php 
}
?>