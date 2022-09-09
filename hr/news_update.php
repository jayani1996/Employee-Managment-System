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
                        <a href="team_manage.php"><i class="fa fa-users fa-2x"></i>Team</a>
                    </li>
                    <li>
                        <a href="news_manage.php" class="active-menu"><i class="fa fa-edit fa-2x"></i>News</a>
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
        

                <?php
                if ($_GET['update']) { 

                    $id = $_GET['update'];
                    //$news_id = $_GET['update'];
                    $sqlSelect = "SELECT * FROM `news` WHERE `news_id` = '$id'";
                    $sqlQuery  = mysqli_query($con, $sqlSelect);
                    $row       = mysqli_fetch_assoc($sqlQuery);

                 
                        $newsid        = $row['news_id'];
                        $news_heading  = $row['heading'];
                        $news_content  = $row['content'];
                        $active        = $row['active'];

                        $_SESSION['hrepf_noUp']   = $newsid; 
                        $_SESSION['hrpositionUp'] = $news_heading;
                        $_SESSION['hrenameUp']    = $news_content;
                        $_SESSION['hraddressUp']  = $active;

                  
                                        
                }
            
                ?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                  <div class="col-md-12 col-lg-12 text-center">
                    <h3>
                      <small style="color:black; float:left; font-size:20px;"><i>HR Panel</i></small>
                      <strong style="color:green">News</strong>&nbsp;&nbsp;(<?php echo $newsid; ?>)
                    </h3>
                  </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-2 col-lg-2">
                      <a href="news_manage.php" class="btn btn-primary">Back to news</a>
                    </div> 
                </div>
                <hr/>
                <div class="row">
                    <form class="form-add" action="news_update_query.php" method="post">
                        <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12 col-md-offset-2">
                            <div class="form-group">
                                <label>ID:</label>
                                <input class="form-control" name="newId" autocomplete="off" value="<?php echo $newsid; ?>" readonly>

                            </div>
                            <div class="form-group">
                                <label>Header:</label>
                                <input class="form-control" name="newsHead" autocomplete="off" value="<?php echo $news_heading; ?>">
                            </div>
                            <div class="form-group">
                                <label>Content:</label>
                                <!--input class="form-control" name="news_content" autocomplete="off" value="<?php //echo $news_content; ?>"-->
                                <textarea class="form-control" name="newsCon" rows="4" autocomplete="off"><?php echo $news_content; ?></textarea>
                            </div>
                          <div class="form-group">
                              <label>Active:</label>
                              <select class="form-control" name="newsAct">
                                <?php if($active == 1){ ?>
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                <?php }else{ ?>
                                        <option value="1">Active</option>
                                        <option value="0" selected>Inactive</option>
                                <?php } ?>
                              </select>

                          </div>
                       
                            <div class="form-group" style="float: right;">
                                <button type="submit" name="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div><!--row-->
                
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


   <!--ENTER KEY USE TO GO NEXT TAB-->
   <script type="text/javascript">
      // Map [Enter] key to work like the [Tab] key
      // Daniel P. Clark 2014

      // Catch the keydown for the entire document
      $(document).keydown(function(e) {
        var self = $(':focus'),
            // Set the form by the current item in focus
            form = self.parents('form:eq(0)'),
            focusable;
        // Array of Indexable/Tab-able items
        focusable = form.find('input,a,select,button,textarea,div[contenteditable=true]').filter(':visible');
        function enterKey(){
          if (e.which === 13 && !self.is('textarea,div[contenteditable=true]')) { // [Enter] key
            // If not a regular hyperlink/button/textarea
            if ($.inArray(self, focusable) && (!self.is('a,button'))){
              // Then prevent the default [Enter] key behaviour from submitting the form
              e.preventDefault();
            } // Otherwise follow the link/button as by design, or put new line in textarea

            // Focus on the next item (either previous or next depending on shift)
            focusable.eq(focusable.index(self) + (e.shiftKey ? -1 : 1)).focus();

            return false;
          }
        }
        // We need to capture the [Shift] key and check the [Enter] key either way.
        if (e.shiftKey) { enterKey() } else { enterKey() }
      });
   </script>


</body>
</html>
<?php 
}
?>