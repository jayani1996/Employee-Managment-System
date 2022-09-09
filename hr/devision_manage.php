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
                        <a href="manage_employee.php"><i class="fa fa-male fa-2x"></i>Employee</a>
                    </li>
                    <li>
                        <a href="devision_manage.php" class="active-menu"><i class="fa fa-sort-amount-asc fa-2x"></i>Division</a>
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
                      <small style="color:black; float:left; font-size:20px;"><i>HR Panel</i></small>
                      <strong style="color:green">Manage Division</strong>
                    </h3>
                  </div>
                </div><!--row-->
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <!-- Button to Open the Modal -->
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Division ++
                              </button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                           <input class="form-control" id="myInput" type="text" placeholder="Devision search">  
                        </div>
                    </div>
                    <div class="col-md-2">
                       <div class="form-group">
                            
                            <?php 

                                $sqlSelect = "SELECT * FROM `devision` ORDER BY `dev_id` ASC";
                                $sqlQuery  = mysqli_query($con, $sqlSelect);
                                $numOfRow  = mysqli_num_rows($sqlQuery);

                            ?>
                           <label>
                                <strong style="color:green;font-size:20px;">Divisions</strong> &nbsp;&nbsp;
                                <strong style="color:navy;font-size:20px;">(<?php echo $numOfRow -1;  ?>)</strong>
                           </label>
                       </div>
                    </div>
                </div>
                <hr/>
                <!-- The Modal -->
                <div class="modal fade" id="myModal">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">Add Division</h4>
                      </div>
                      <!-- Modal body -->
                      <form action="devision_add_query.php" method="post">
                          <div class="modal-body">
                               <div class="row">
                                  <div class="form-group">
                                      <label>Division name:</label>
                                      <input type="text" class="form-control" name="devision_name" placeholder="Enter division name." autocomplete="off">
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
                <table class="table table-bordered table-striped">
                    <thead>
                          <tr>
                            <th class="text-center">Division name</th>
                            <th colspan="2" class="text-center">View</th>
                            <th class="text-center">Remove</th>
                          </tr>
                    </thead>
                    <tbody id="myTable">
                          <?php
                            if($numOfRow > 0)
                              {

                      while($row = mysqli_fetch_assoc($sqlQuery)){
                                 $dev_id       = $row['dev_id'];
                                 $dev_name     = $row['dev_name'];

                          //On Divition Eka Display wena eka Nawatthuwa.
                          //On Divition Eka Id eka 0.

                          if(!$dev_id == 0){

                          if ($row['dev_id'] == 2 || 
                              $row['dev_id'] == 3 || 
                              $row['dev_id'] == 4 || 
                              $row['dev_id'] == 7){


                          ?>

                          <tr>
                              <td class="text-center"><?php echo $dev_name; ?></td>
                              <td class="text-center"><a href="devision_members_view.php?dev_id=<?php echo $dev_id; ?>" class="btn btn-primary btn-xs">View</a></td>
                              <td class="text-center"><a href="devision_to_team.php?dev_id=<?php echo $dev_id; ?>" class="btn btn-primary btn-xs">Teams</a></td>
                              <td class="text-center"><a onclick="deleteme(<?php echo $row['dev_id']; ?>)" class="btn btn-danger btn-xs" disabled>Remove</a> </td>
                          </tr>
                          <?php
                          }else{
                          ?>
                          <tr>
                              <td class="text-center">&nbsp;&nbsp;<?php echo $dev_name; ?></td>
                              <td colspan="2" class="text-center">
                                <a href="devision_members_view.php?dev_id=<?php echo $dev_id; ?>" class="btn btn-primary btn-xs">View</a>
                              </td>
                              <td class="text-center">
                                <a onclick="deleteme(<?php echo $row['dev_id']; ?>)" class="btn btn-danger btn-xs" >Remove</a>
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
            </div><!--page inner-->
        </div><!--page wrapper-->
    </div><!--wrapper-->

    <!--Delete Javascript function-->    
<script type="text/javascript">
        
function deleteme(delid){

if(confirm("Do you want delete!")){
    window.location.href='devision_delete.php?delete=' +delid+ '';
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
    <script src="../assets/js/morris/morris.js"></script>

     <!--SEARCH BAR-->
     <script>
            $(document).ready(function(){
              $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
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