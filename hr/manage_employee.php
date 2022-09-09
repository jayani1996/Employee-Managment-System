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
                    <a href="manage_employee.php"  class="active-menu"><i class="fa fa-male fa-2x"></i>Employee</a>
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
                <strong style="color:green">Manage Employees</strong>
            </h3>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <!-- Button to Open the Modal -->
                    <a href="manage_empAdd_form.php" class="btn btn-primary">Add Employee ++</a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <!-- Button to Open the Modal -->
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalImport">
                        Import CSV ++
                      </button>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <!-- Button to Open the Modal -->
                      <form method="post" action="export_employee.php">
                      <input type="submit" name="export" class="btn btn-primary" value="Export CSV ++" />
                    </form>
                </div>
            </div>
            <!--Generate Print Report-->
            <div class="col-md-2">
                <form action="genarate_pdf.php" method="post" name="submit">
                <strong><a href="generate_pdf.php" name="submit" style="color: gray; padding-right: 10px; float: right;"><i class="fa fa-print fa-2x" style="color: gray;"></i>&nbsp;&nbsp;Print</a></strong>
                </form>
            </div>
            <div class="col-md-3 col-md-offset-1">
               <div class="form-group">
                    <?php 

                        $con=mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
                        mysqli_select_db($con, DB_NAME);
                        $sqlSelect = "SELECT * FROM `employee` ORDER BY `emp_id` DESC";
                        $sqlQuery  = mysqli_query($con, $sqlSelect);
                        $numOfRow  = mysqli_num_rows($sqlQuery);
                    ?>
                    <label>
                        <strong style="color:green;font-size:20px;">Employees</strong> &nbsp;&nbsp;
                        <strong style="color:navy;font-size:20px;">(<?php echo $numOfRow; ?>)</strong>
                   </label>
               </div>
            </div>
        </div>
        <hr/>

        <!-- The Modal for Import Employess in database -->
        <div class="modal fade" id="myModalImport">
          <div class="modal-dialog">
            <div class="modal-content">
            
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Import CSV</h4>
               
              </div>
              
              <!-- Modal body -->
              <form action="importData.php" method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                       <div class="row">
                          <div class="form-group">
                              <label>CSV :</label>
                              <input type="file" name="file" />
                          </div>
                      </div>
                  </div>
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <div class="text-left">
                       <div class="form-group">
                            <?php 
                                $sqlSel = "SELECT `emp_id` FROM `employee` ORDER BY `emp_id` DESC";
                                $sqlQuer  = mysqli_query($con, $sqlSel);
                                $numOfRo  = mysqli_num_rows($sqlQuer);
                            ?>
                            <label>
                                <strong style="color:green;font-size:20px;"> Last emp id</strong> &nbsp;&nbsp;
                                <strong style="color:navy;font-size:20px;">(<?php echo $numOfRo; ?>)</strong>
                           </label>
                       </div>
                    </div>
                    <div class="text-right">
                    <button type="submit" name="importSubmit" class="btn btn-primary">Upload</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                  </div>
              </form>
            
            </div>
          </div>
        </div>
        <div class="panel panel-default">
        <div class="panel-heading">
            Employee table
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
      <div class=" col-md-12 table-responsive" style="overflow-x:auto;">
        <table class="table-bordered table table-striped table-hover" id="dataTables-example">
            <thead>
                  <tr> 
                    <th>EPF No</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>NIC</th>
                    <th>DOJ</th>
                    <th>Address</th>
                    <th>Division</th>
                    <th>Team</th>
                    <th>Image</th>
                    <th>More</th>
                    <th>Update</th>
                    <th>Delete</th>
                  </tr>
             </thead>
  			<tbody>
            <?php 
                
                if($numOfRow > 0)
                {

                while($row = mysqli_fetch_assoc($sqlQuery)){

                   $id           = $row['emp_id']; 
                   $epf_no       = $row['epf_no']; 
                   $posId        = $row['position'];
                   $ename        = $row['ename'];
                   $address      = $row['address'];
                   $e_doj        = $row['e_doj'];
                   $nic          = $row['nic'];
                   $devId        = $row['devision'];
                   $teamId       = $row['team'];

                 //  $_SESSION['emp_id'] = $id;
                    
                    if($row['ephoto'] == "noimage.png"){
                    $image = "../images/employee/noimage/".$row['ephoto'];
                   }else{
                    $image = "../images/employee/".$row['ephoto'];
                   }

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


                   //Select Team Name.
                 if($teamId==0){
                          $teamNa   = "";

                }else{
                   $teamSQL   = "SELECT * FROM `team` WHERE `team_id` = $teamId";
                   $teamQuery = mysqli_query($con, $teamSQL);
                   $teamRow   = mysqli_fetch_assoc($teamQuery);
                   $teamNa    = $teamRow['team_name'];
                   
               }
                   
             ?>

                  <tr>
                    <td><?php echo $epf_no; ?></td>
                    <td><?php echo $ename; ?></td>
                    <td><?php echo $posNa; ?></td>
                    <td><?php echo $nic; ?></td>
                    <td><?php echo $e_doj; ?></td>
                    <td><?php echo $address; ?></td>
                    <td><?php echo $divNa; ?></td>
                    <td><?php echo $teamNa; ?></td>
                    <td><img src="<?php echo $image; ?>"  width="70"></td>
                    <td class="text-center"><a href="manage_employee_more.php?emp_id=<?php echo $id; ?>" class="btn btn-primary btn-xs">More</a></td>
                    <td class="text-center"><a href="manage_employee_update.php?update=<?php echo $id; ?>" class="btn btn-success btn-xs">Update</a></td>
                     <td class="text-center"><a onclick="deleteme(<?php echo $row['emp_id']; ?>)" class="btn btn-danger btn-xs">Remove</a></td>
              
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
    </div>
</div>
</div>


     
    <!--Delete-->
    <script type="text/javascript">

        function deleteme(delid){

            if(confirm("Do you want delete!")){
                window.location.href='manage_employee_delete.php?delete=' +delid+ '';
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

 


          <!--SELECT ONE VALUE IN CHECKOX-->
        <script>
            // the selector will match all input controls of type :checkbox
            // and attach a click event handler 
            $("input:checkbox").on('click', function() {
              // in the handler, 'this' refers to the box clicked on
              var $box = $(this);
              if ($box.is(":checked")) {
                // the name of the box is retrieved using the .attr() method
                // as it is assumed and expected to be immutable
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                // the checked state of the group/box on the other hand will change
                // and the current value is retrieved using .prop() method
                $(group).prop("checked", false);
                $box.prop("checked", true);
              } else {
                $box.prop("checked", false);
              }
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
<?php } ?>