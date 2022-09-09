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
                    <div class="col-lg-12">
                        

                        <?php

                          $notSQL = "SELECT trxn.trxn_id         AS trxn_id,
                                            trxn.user_id         AS user_id, 
                                            trxn.status          AS status, 
                                            trxn.active          AS active, 
                                            trxn_dtl.type        AS type,
                                            trxn_dtl.trxn_date   AS trxn_date
                                    FROM trxn 
                                      INNER JOIN  trxn_dtl ON trxn.trxn_id =  trxn_dtl.trxn_id

                                    ORDER BY `trxn_date` DESC" ;

                            $notQyery  = mysqli_query($con, $notSQL);
                            $notNfRows = mysqli_num_rows($notQyery);
                           if($notNfRows > 0){
                           while($row = mysqli_fetch_assoc($notQyery)) {
                                  $trxn_id      = $row['trxn_id'];
                                  $user_id      = $row['user_id'];
                                  $status       = $row['status'];
                                  $active       = $row['active'];
                                  $type         = $row['type'];
                                  $trxn_date    = $row['trxn_date'];
                                 


                                  $usersql    = "SELECT * FROM `user` WHERE `id` = '$user_id'";
                                  $userQuery  = mysqli_query($con, $usersql);
                                  $userRow    = mysqli_fetch_assoc($userQuery);      
                                  //$username   = $userRow['username'];
                                       
                            

                if ($row['type'] == 1){
                       
                ?>
                    <div class="col-md-9">
                        <div class="well well-sm">
                            <a  style="text-decoration:none;
                    		<?php 
                    			if($row['status']=='unread')
                    			{
                    				echo "font-weight:bold;color:green;";
                    			}else{ 
                                    echo "color:black;";
                                }
                    		?>  
                            " href="manage_notiResult.php?trxn_id=<?php echo $trxn_id; ?>">
                            <span> 
                               <?php 
                               echo ucfirst($userRow['username'])."&nbsp;(&nbsp; <span style='color:black;'>".$userRow['epf_no']."</span> &nbsp;)&nbsp;has logged."; 
                               ?>
                            </span> 
                            <small style="color:black;">
                                <i> &nbsp;&nbsp;<?php echo date('F j,Y, g : i a',strtotime($trxn_date)); ?></i>
                            </small>

                                <?php if($row['active'] == 2){ 


                                     $outSQL = "SELECT * FROM  trxn_dtl WHERE type = 5 AND trxn_id = $trxn_id";
                                     $outQyery  = mysqli_query($con, $outSQL);
                                     $outRow    = mysqli_fetch_assoc($outQyery);
                                    if($outRow['type'] == 5){ 
                                 ?>
                                  <small style="color:red;">
                                    <i> &nbsp;&nbsp;<?php echo date('F j,Y, g : i a',strtotime($outRow['trxn_date'])); ?></i>
                                 </small>
                                <?php
                                  }
                                } 
                                ?>
                            </a>
                        </div> 
                    </div>

                    <!--Check User Active or Inactive-->

                    <div class="col-md-1">
                            <?php if($row['active'] == 2 ){ ?>
                                 <i style="color:red;"  class="glyphicon glyphicon-remove-circle" ></i>
                            <?php }elseif($row['active'] == 1){?>
                                 <i style="color:green;" class="glyphicon glyphicon-ok-circle"></i>
                           <?php  } ?>   
                    </div>  
                    <div class="col-md-2">
                        <div class="well well-sm">
                        <a onclick="deleteme(<?php echo $trxn_id; ?>)" class="btn btn-danger btn-xs btn-block">Remove</a>
                        </div>
                    </div> 
                    <br>                                    
                    <?php 
                            }
                    	}
                   }
                    ?>

                       
                    </div> <!-- /.col-lg-12 -->
                </div> <!-- /.row -->
            </div><!--page inner-->
        </div><!--page wrapper-->
    </div><!--wrapper-->

    <!--Delete Javascript function-->    
    <script type="text/javascript">
            
    function deleteme(delid){

    if(confirm("Do you want delete!")){
        window.location.href='manage_notiDelete.php?delete=' +delid+ '';
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