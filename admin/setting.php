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
                        <a href="position_manage.php"><i class="fa fa-sort fa-2x"></i>Designation</a>
                    </li>
                    <li>
                        <a href="emp_Recovery.php"><i class="fa fa-refresh fa-2x"></i>EMP Recovery</a>
                    </li>
                    <li>
                        <a href="setting.php" class="active-menu"><i class="fa fa-cogs fa-2x"></i>Setting</a>
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
                        <strong style="color:green">Manage Users</strong>
                     </h3>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <!-- Button to Open the Modal -->
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myNewUser">New User ++</button> 
                        </div>
                    </div> 
                    <div class="col-md-2 col-md-offset-8">
                       <div class="form-group">
                            <?php 

                                $sqlSelect = "SELECT * FROM `user` ORDER BY `id` DESC";
                                $sqlQuery  = mysqli_query($con, $sqlSelect);
                                $numOfRow  = mysqli_num_rows($sqlQuery);
                            ?>
                           <label>
                                <strong style="color:green;font-size:20px;">Users</strong> &nbsp;&nbsp;
                                <strong style="color:navy;font-size:20px;">(<?php echo $numOfRow; ?>)</strong>
                           </label>
                       </div>
                    </div>
                </div>


         <!--NEW USER MODAL FORM-->
        <div class="modal fade" id="myNewUser">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!--Modal Header-->
                    <div class="modal-header">
                        <h4>New User</h4>
                    </div>
                    <!--Modal Body-->
                <form  action="settingAddQuery.php" method="post">
                 
                    <div class="modal-body">
                        <div class="row">
                             <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>EPF No</label>
                                    <input class="form-control" type="text" name="epf_no" placeholder="Enter full name." autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control" type="text" name="username" placeholder="Enter user name." maxlength="20" autocomplete="off">
                                    
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type="text" name="password" placeholder="Enter password." autocomplete="off">
                                    
                                </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>User Level</label>
                                        <?php
                                        $sqlSelect4 = "SELECT * FROM user_levels";
                                        $sqlQuery4  = mysqli_query($con, $sqlSelect4);
                                        $numOfRow4  = mysqli_num_rows($sqlQuery4); 
                                        ?>
                                        <select class="form-control" name="userLvl">
                                            <?php
                                                while ($row4 = mysqli_fetch_assoc($sqlQuery4)) {
                                            ?>
                                            <option value="<?php echo $row4['id']; ?>">
                                                     <?php echo $row4['description']; ?>    
                                            </option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                               <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <?php
                                    $sqlSelect5 = "SELECT * FROM user_category";
                                    $sqlQuery5  = mysqli_query($con, $sqlSelect5);
                                    $numOfRow5  = mysqli_num_rows($sqlQuery5); 
                                    ?>
                                    <select class="form-control" name="category">
                                        <?php
                                            while ($row5 = mysqli_fetch_assoc($sqlQuery5)) {
                                        ?>
                                        <option value="<?php echo $row5['id']; ?>">
                                                 <?php echo $row5['description']; ?>    
                                        </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
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
            <div class="panel-heading"> Users table </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
              <div class=" col-md-12 table-responsive" style="overflow-x:auto;">
                <table class="table-bordered table table-striped table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>EPF No</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Category</th>
                        <th>User Level</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Designation</th>
                        <th>Division</th>
                        <th>Team</th>
                        <th>Edit</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($numOfRow > 0) {
                    while($row = mysqli_fetch_assoc($sqlQuery)) {
                            $id       = $row['id'];
                            $epf_no   = $row['epf_no'];
                            $username = $row['username'];
                            $password = $row['password'];
                            $cateId   = $row['category'];
                            $userLvl  = $row['user_level'];

                     //Select Category Name.
                     if($cateId==0){
                            $cateNa   = "";

                     }else{
                       $cateSQL   = "SELECT * FROM `user_category` WHERE `id` = $cateId";
                       $cateQuery = mysqli_query($con, $cateSQL);
                       $cateRow   = mysqli_fetch_assoc($cateQuery);
                       $cateNa    = $cateRow['description'];
                    }


                     if($userLvl==0){

                           $lvlNa   = "";

                     }else{
                      
                        //Select User level.
                        $lvlSQL   = "SELECT * FROM `user_levels` WHERE `id` = $userLvl";
                        $lvlQuery = mysqli_query($con, $lvlSQL);
                        $lvlRow   = mysqli_fetch_assoc($lvlQuery);
                        $lvlNa    = $lvlRow['description'];

                    }
                      

                        $PerSQL = "SELECT * FROM `employee` WHERE `epf_no` = '$epf_no'";

                        $perQuery  = mysqli_query($con, $PerSQL);
                        $pernfRow  = mysqli_num_rows($perQuery);
                        $perRow = mysqli_fetch_assoc($perQuery);

                                

                        if($perRow['epf_no']==$epf_no){

                            $fullname = $perRow['ename'];
                            $posId    = $perRow['position'];
                            $mobile   = $perRow['tel_personal'];
                            $divId    = $perRow['devision'];
                            $teamId   = $perRow['team'];





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
                               if($divId==0){
                                      $divNa   = "";

                                }else{
                                            
                               $divSQL    = "SELECT * FROM `devision` WHERE `dev_id` = $divId";
                               $divQuery  = mysqli_query($con, $divSQL);
                               $divRow    = mysqli_fetch_assoc($divQuery);
                               $divNa     = $divRow['dev_name'];  
              
                               
                            }

                              //Select Team Name.
                             if($teamId==0){
                                      $teamNa   = "";

                            }else{
                               $teamSQL    = "SELECT * FROM `team` WHERE `team_id` = $teamId";
                               $teamQuery  = mysqli_query($con, $teamSQL);
                               $teamRow    = mysqli_fetch_assoc($teamQuery);
                               $teamNa     = $teamRow['team_name'];
                               
                           }

                        }else{
                           $fullname = "";
                           $mobile   = "";
                           $posNa    = ""; 
                           $divNa    = ""; 
                           $teamNa   = ""; 
                        }


                    ?>

                    <tr>
                        <td><?php echo $epf_no;?>  </td>
                        <td><?php echo $username;?></td>
                        <td><?php echo $password;?></td>
                        <td><?php echo $cateNa;?>  </td>
                        <td><?php echo $lvlNa;?> </td>
                        <td><?php echo $fullname;?></td>
                        <td><?php echo $mobile;?></td>
                        <td><?php echo $posNa;?>   </td>
                        <td><?php echo $divNa;?>   </td>
                        <td><?php echo $teamNa;?>  </td>
                    
                        <td class="text-center"><a href="setting_user_update.php?update=<?php echo $id; ?>" class="btn btn-success btn-xs">Update</a></td>
                        <td class="text-center"><a onclick="deleteme(<?php echo $row['id']; ?>)" class="btn btn-danger btn-xs" >Remove</a></td>
                    </tr>
                    <?php
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
            window.location.href='setting_user_delete.php?delete=' +delid+ '';
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