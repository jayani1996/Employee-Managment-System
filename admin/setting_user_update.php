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
                    <a href="manage_employee.php"  ><i class="fa fa-male fa-2x"></i>Employee</a>
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
                    <a href="setting.php" class="active-menu"><i class="fa fa-cogs fa-2x"></i>Setting</a>
                </li>
                <li>
                    <a href="logout.php"><i class="fa fa-sign-out fa-2x"></i>Logout</a>
                </li>
            </ul>
        </div>
    </nav>

 
            <?php 
        
        if($_GET['update']){
            $id = $_GET['update'];
            $query  = "SELECT * FROM `user` WHERE `id` = '$id'";
            $sql_select = mysqli_query($con, $query);
           
                while($row= mysqli_fetch_assoc($sql_select)){

                       
                       $user_id   = $row['id'];
                       $epf_no    = $row['epf_no']; 
                       $username  = $row['username'];
                       $password  = $row['password'];
                       $cateId    = $row['category'];
                       $uLvlId    = $row['user_level'];

                       $_SESSION['userId']     = $user_id;
                       $_SESSION['usepf_no']   = $epf_no; 
                       $_SESSION['ususername'] = $username;
                       $_SESSION['uspassword'] = $password;
                       $_SESSION['uscateId']   = $cateId;
                       $_SESSION['usuLvlId']   = $uLvlId;





                     }
                   
                 }
                   ?>

      <div id="page-wrapper">
        <div id="page-inner">
          <div class="row">
            <div class="col-md-12 col-lg-12 text-center">
              <h3>
                <small style="color:black; float:left; font-size:20px;"><i>Admin Panel</i></small>
                <strong style="color:green"><?php echo $epf_no; ?>&nbsp;</strong>(<?php echo $username; ?>)
              </h3>
            </div>
          </div>
          <hr/>
            <div class="row">
              <div class="col-md-2 col-lg-2">
                <a href="setting.php" class="btn btn-primary">Back to list</a>
              </div>
           </div>
          <hr/>
          <div class="row">
            <form class="form-add" role="form" action="settingUpdateQuery.php" method="post" enctype="multipart/form-data">
              <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12  col-md-offset-3">
                <div class="form-group">
                    <label>EPF No</label>
                    <input class="form-control" type="text" name="epf_no"  autocomplete="off" value="<?php echo $epf_no; ?>" readonly>
                  </div>
                <div class="form-group">
                  <label>Username</label>
                  <input class="form-control" type="text" name="username" maxlength="20" autocomplete="off" value="<?php echo $username; ?>">
                </div>
                 <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="text" name="password"  autocomplete="off" id="password" value="<?php echo $password; ?>">                        
                  </div>
                  <div class="form-group">
                      <label>Category</label>
                      <?php

                      $cateSQL   = "SELECT * FROM `user_category`";
                      $cateQuery = mysqli_query($con, $cateSQL);
                      $cateNfRow = mysqli_num_rows($cateQuery);
                      ?>
                      <select class="form-control" name="category">
                          <?php
                          if($cateNfRow > 0){
                              while ($cateRow = mysqli_fetch_assoc($cateQuery)) {

                            $selected = ( $cateRow['id']=="$cateId" ? ' selected' : '' );
                            echo '<option value="'.$cateRow['id'].'"'.$selected.'>'.$cateRow['description'].'</option>';  
                       
                              }
                           }
                          ?>
                      </select>
                   </div>
                 <div class="form-group">
                    <label>User Level</label>
                    <?php

                    $ulvlSQL   = "SELECT * FROM `user_levels`";
                    $ulvlQuery = mysqli_query($con, $ulvlSQL);
                    $ulvlNfRow = mysqli_num_rows($ulvlQuery);
                    ?>
                    <select class="form-control" name="user_level">
                        <?php
                        if($ulvlNfRow > 0){
                            while ($ulvlRow = mysqli_fetch_assoc($ulvlQuery)) {

                          $selected = ( $ulvlRow['id']=="$uLvlId" ? ' selected' : '' );
                          echo '<option value="'.$ulvlRow['id'].'"'.$selected.'>'.$ulvlRow['description'].'</option>';  
                     
                            }
                         }
                        ?>
                    </select>
                 </div>
               <div class="form-group">
                <button name="submit" class="btn btn-success btn-block">Update</button>
              </div> 
            </div>
          </form>
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
    <script src="assets/js/custom.js"></script>

    </body>
    </html>
    <?php } ?>