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
if(!isset($_SESSION['mangrSession'])){
        echo "<script type='text/javascript'>window.location.href = '../login.php';</script>";
        
}else{
        $user_name = $_SESSION['mangrSession'];
        $userID    = $_SESSION['mangrUid'];

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
            <div id="navbar-right">Welcome : <?php echo $_SESSION['mangrSession'];?> &nbsp; <a href="logout.php" class="btn btn-danger square-btn-adjust">Logout</a>
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
                    <a href="manage_employee.php"  class="active-menu"><i class="fa fa-users fa-2x"></i>Teams</a>
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
                <small style="color:black; float:left; font-size:20px;"><i>Manager Panel</i></small>
                <strong style="color:green">Manage Teams</strong>
            </h3>
            </div>
        </div>
        <hr/>
          <?php 
            if($_GET['team_id'] AND $_GET['devision']){

                $team_id  = $_GET['team_id'];
                $devision = $_GET['devision'];
                $_SESSION['team_id']  = $_GET['team_id'];
                $_SESSION['devision'] = $_GET['devision'];
 


                     $con=mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
                     mysqli_select_db($con, DB_NAME);

                      $meSQL = "SELECT user.id       AS id, 
                                          user.epf_no   AS epf_no,
                                          user.username AS username, 
                                          user.category AS category, 
                                          employee.devision   AS devision, 
                                          employee.team   AS team 
                             
                    FROM user 
                      INNER JOIN  `employee` ON user.epf_no =  employee.epf_no

                    WHERE `user`.`id` = '$userID'" ;
                     
                    $meQyery  = mysqli_query($con, $meSQL);
                    $numOfRow = mysqli_num_rows($meQyery);
                    $row = mysqli_fetch_assoc($meQyery);
                        $epf_no      = $row['epf_no'];
                        $username    = $row['username'];
                        $devision    = $row['devision'];
                        $team        = $row['team']; 
                    ?>
              <div class="row">
                 <div class="col-md-12 col-sm-12 col-xs-12 ">
                    <div class="panel" style="background:black;">
                       <div class="panel-heading">

                            <?php

                             //Select Divition Name.
                             if($devision==0){
                                $divNa   = "";

                              }else{
                                          
                             $divSQL   = "SELECT * FROM `devision` WHERE `dev_id` = $devision";
                             $divQuery = mysqli_query($con, $divSQL);
                             $divRow   = mysqli_fetch_assoc($divQuery);
                             $divNa    = $divRow['dev_name'];  
            
                              } 
                            ?>
                            <div class="row">
                                <div class="col-md-3 col-sm-12 col-xs-12"  > 
                                        <h5 style="color:white;"><?php echo $divNa; ?>&nbsp; </h5> 
                                </div>
                                <?php
                                    //Select Team Name.
                                     if($team_id==0){
                                              $teamNa   = "";

                                    }else{
                                       $teamSQL   = "SELECT * FROM `team` WHERE `team_id` = $team_id";
                                       $teamQuery = mysqli_query($con, $teamSQL);
                                       $teamRow   = mysqli_fetch_assoc($teamQuery);
                                       $teamNa    = $teamRow['team_name'];
                                       
                                   }
                                   ?>

                                <div class="col-md-9 col-sm-12 col-xs-12 ">
                                  <h5 style="color:white;"><?php echo $teamNa; ?>&nbsp;&nbsp;

                                  <?php
                                  $pSQL = "SELECT * FROM `employee`  WHERE `team` = '$team_id'" ;
                                  $pQry = mysqli_query($con, $pSQL);
                                  $pnor = mysqli_num_rows($pQry);
                                  ?>
                                   &nbsp;&nbsp;|&nbsp;&nbsp;Employees&nbsp;&nbsp;
                                    <span class="badge badge-light" style="background:blue;">
                                        <?php if($pnor >= 0){ echo $pnor;} ?> 
                                    </span> 
                                  </h5>
                                </div> 
                            </div>
                       </div>
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <!-- Button to Open the Modal -->
                            <a href="manage_employee.php" class="btn btn-primary">Back to list</a>
                        </div>
                    </div>
                    <!--Generate Print Report-->
                    <div class="col-md-2 col-md-offset-7">
                        <form action="genarate_pdf.php" method="post" name="submit">
                        <strong><a href="generate_pdf.php?team_id=<?php echo $team_id; ?>&amp;devision=<?php echo $devision; ?>" name="submit" style="color: gray; padding-right: 10px; float: right;"><i class="fa fa-print fa-2x" style="color: gray;"></i>&nbsp;&nbsp;Print</a></strong>
                        </form>
                    </div> 
                </div>
                <hr/>
 
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


                 $mtSQL   = "SELECT * FROM `employee` WHERE `devision` = '$devision' AND `team` = '$team_id' ";
                 $mtQry = mysqli_query($con, $mtSQL);
                 $mtnor = mysqli_num_rows($mtQry);
                  if($mtnor > 0){
                    while($mtRow   = mysqli_fetch_assoc($mtQry)){
                   $mtid           = $mtRow['emp_id'];
                   $mtepfNo        = $mtRow['epf_no'];  
                   $mtepf_no       = $mtRow['epf_no']; 
                   $mtposId        = $mtRow['position'];
                   $mtename        = $mtRow['ename'];
                   $mtnic          = $mtRow['nic'];
                   $mtdevId        = $mtRow['devision'];
                   $mtteamId       = $mtRow['team'];
                    
                    if($mtRow['ephoto'] == "noimage.png"){
                      $mtimage = "../images/employee/noimage/".$mtRow['ephoto'];
                   }else{
                      $mtimage = "../images/employee/".$mtRow['ephoto'];
                   }

                   //Select Postion Name.
                if($mtposId==0){
                    $mtposNa   = "";

                }else{

                   $mtposSQL   = "SELECT * FROM `position` WHERE `position_id` = $mtposId";
                   $mtposQuery = mysqli_query($con, $mtposSQL);
                   $mtposRow   = mysqli_fetch_assoc($mtposQuery);
                   $mtposNa    = $mtposRow['position'];
                   
               }

                   //Select Divition Name.
                   if($mtdevId==0){
                          $mtdivNa   = "";

                    }else{
                                
                   $mtdivSQL   = "SELECT * FROM `devision` WHERE `dev_id` = $mtdevId";
                   $mtdivQuery = mysqli_query($con, $mtdivSQL);
                   $mtdivRow   = mysqli_fetch_assoc($mtdivQuery);
                   $mtdivNa    = $mtdivRow['dev_name'];  
  
                }


                  //Select Team Name.
                 if($mtteamId==0){
                          $mtteamNa   = "";

                }else{
                   $mtteamSQL   = "SELECT * FROM `team` WHERE `team_id` = $mtteamId";
                   $mtteamQuery = mysqli_query($con, $mtteamSQL);
                   $mtteamRow   = mysqli_fetch_assoc($mtteamQuery);
                   $mtteamNa    = $mtteamRow['team_name'];
                   
               }
                   
             ?>


                  <tr>
                    <td><?php echo $mtepfNo; ?></td>
                    <td><?php echo $mtename; ?></td>
                    <td><?php echo $mtposNa; ?></td>
                    <td><?php echo $mtnic; ?></td>
                    <td><?php echo $mtdivNa; ?></td>
                    <td><?php echo $mtteamNa; ?></td>
                    <td><img src="<?php echo $mtimage; ?>"  width="70"></td>
                    <td class="text-center"><a href="manage_employee_more.php?emp_id=<?php echo $mtid;?>" class="btn btn-primary btn-xs">More</a></td>
                    <td class="text-center"><a href="manage_employee_update.php?update=<?php echo $mtid; ?>" class="btn btn-success btn-xs">Update</a></td>
                    <td class="text-center"><a onclick="deleteme(<?php echo $mtRow['emp_id']; ?>)" class="btn btn-danger btn-xs">Remove</a></td>
                    
              
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
    <?php } ?>
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