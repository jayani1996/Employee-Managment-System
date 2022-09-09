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
        <div id="page-wrapper">
            <div id="page-inner">
                  <div class="row">
                   <div class="col-md-12 col-lg-12 text-center">
                     <h3>
                      <small style="color:black; float:left; font-size:20px;"><i>HR Panel</i></small>
                      <strong style="color:green">Manage News</strong>
                    </h3>
                  </div>
                </div><!--row-->
                <hr/>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <!-- Button to Open the Modal -->
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Add News ++
                              </button>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-offset-8">
                       <div class="form-group">
                            <?php 

                                $sqlSelect = "SELECT * FROM `news` ORDER BY `news_id` ASC";
                                $sqlQuery  = mysqli_query($con, $sqlSelect);
                                $numOfRow  = mysqli_num_rows($sqlQuery);
                            ?>
                            <label>
                                <strong style="color:green;font-size:20px;">News</strong> &nbsp;&nbsp;
                                <strong style="color:navy;font-size:20px;">(<?php echo $numOfRow;  ?>)</strong>
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
                        <h4 class="modal-title">Add news</h4>
                      </div>
                      <!-- Modal body -->
                      <form action="news_add_query.php" method="post">
                          <div class="modal-body">

                              <div class="row">
                                  <div class="col-md-8">
                                    <div class="form-group">
                                      <label>ID:</label>
                                      <input type="text" class="form-control" name="news_id" autocomplete="off" placeholder="Enter news ID.">
                                   </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                          <label>Active</label>
                                          <select class="form-control" name="active_id"> 
                                              <option value="1">Active</option>
                                              <option value="0">Inactive</option> 
                                          </select>
                                    </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Header:</label>
                                        <input type="text" class="form-control" name="news_header" autocomplete="off" placeholder="Enter header.">
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Content:</label>
                                        <textarea type="text" class="form-control" name="news_content" rows="4" autocomplete="off" placeholder="Enter content"></textarea>
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
                    <div class="panel-heading">
                        Team table
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                  <div class=" col-md-12 table-responsive" style="overflow-x:auto;">
                     <table class="table-bordered table table-striped table-hover" id="dataTables-example">
                      <thead>
                            <tr>
                              <th  class="text-center">ID</th>
                              <th  class="text-center">Header</th>
                              <th  class="text-center">Content</th>
                              <th  class="text-center">Active / Inactive</th>
                              <th  class="text-center">Update</th>
                              <th  class="text-center">Remove</th>
                            </tr>
                      </thead>
                      <tbody>
                            <?php
                                if($numOfRow > 0)
                                {

                                while($row = mysqli_fetch_assoc($sqlQuery)){
                                 
                                  $newsid   = $row['news_id'];
                                  $heading  = $row['heading'];
                                  $content  = $row['content'];
                                  //$active     = $row['active'];

                                   if($row['active'] == 1){
                                      $active  = "Active";
                                     }else{
                                      $active  = "Inactive";
                                     }
                            ?>

                                  <tr>
                                    <td class="text-center"><?php echo $newsid; ?></td>
                                    <td><?php echo $heading; ?></td>
                                    <td><?php echo $content; ?></td>
                                    <td class="text-center"><?php echo $active; ?></td>
                                    <td class="text-center"><a href="news_update.php?update=<?php echo $newsid; ?>" class="btn btn-success btn-xs">Update</a></td>
                                    <td class="text-center"><a onclick="deleteme(<?php echo $row['news_id']; ?>)" class="btn btn-danger btn-xs">Remove</a></td>
                                    
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
        window.location.href='news_delete.php?delete=' +delid+ '';
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


      <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>
</body>
</html>
<?php 
}
?>