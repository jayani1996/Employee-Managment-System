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
                <strong style="color:green">Add Employees</strong>
            </h3>
            </div>
        </div>
        <hr/>
        <div class="row">
           <div class="col-md-2">
                <div class="form-group">
                    <a href="manage_employee.php" class="btn btn-primary">Back to Menu</a>
                </div>
            </div>
        </div>       
        <hr/>
        <form class="form-add" role="form" action="manage_employeeAddquery.php" method="post" enctype="multipart/form-data">
          <div class="row">
             <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <h4><strong>Personal Details</strong></h4>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>EPF No</label>
                            <input class="form-control" type="text" name="epf_no" placeholder="Enter EPF No." autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Designation</label>
                            <?php
                            $sqlSelect1 = "SELECT * FROM `position`";
                            $sqlQuery1 = mysqli_query($con, $sqlSelect1);
                            $numOfRow1 = mysqli_num_rows($sqlQuery1);
                            ?>
                            <select class="form-control" name="position" class=" form-control">
                                <option value="0">~ SELECT Designation ~</option>
                                <?php
                                    while ($row = mysqli_fetch_assoc($sqlQuery1)) {

                                ?>
                                <option value="<?php echo $row['position_id']; ?>"><?php echo $row['position']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input class="form-control" type="text" name="ename" placeholder="Enter employee name." autocomplete="off" required>
                </div>  
                <div class="form-group">
                    <label>Address</label>
                    <input class="form-control" type="text" name="address"  placeholder="Enter employee address." autocomplete="off" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date Of Birth</label>
                            <input class="form-control" type="date" name="dob" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-6">  
                        <div class="form-group">
                            <label>Gender</label><br>
                            <div class="radio-inline">
                                <label><input type="radio" name="gender" value="MALE" checked>Male</label>
                            </div>
                            <div class="radio-inline">
                                <label><input type="radio" name="gender" value="FEMALE" >Female</label>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Mobile Contact</label>
                        <input class="form-control" type="number" name="tel_personal"  placeholder="Enter mobile number." autocomplete="off" required>
                         </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Residence Contact</label>
                        <input class="form-control" type="number" name="tel_home"  placeholder="Enter mobile number." autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>NIC</label>
                            <input class="form-control" type="text" name="nic"  placeholder="Enter employee NIC." autocomplete="off" required>
                        </div>
                   </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Religion</label>
                            <?php
                            $sqlreli = "SELECT * FROM `religion`";
                            $reliQuery = mysqli_query($con, $sqlreli);
                            ?>
                            <select class="form-control" name="religion">
                                <option value= "" >~ SELECT RELIGION ~</option>
                                <?php
                                    while ($row = mysqli_fetch_assoc($reliQuery)) { 
                                ?>
                                <option value="<?php echo $row['description']; ?>"><?php echo $row['description']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                     </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Civil Status</label>
                            <select class="form-control" name="civilStatus">
                                <option value= "" >~ SELECT CIVIL STATUS ~</option>
                                <option value="SINGLE">SINGLE</option>
                                <option value="MARRIED">MARRIED</option> 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="catogory">
                                <option value= "" >~ SELECT Category ~</option>
                                <option value="STAFF">STAFF</option>
                                <option value="WORKER">WORKER</option> 
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Division</label>
                            <?php
                            $sqlSelect2 = "SELECT * FROM `devision`";
                            $sqlQuery2 = mysqli_query($con, $sqlSelect2);
                            $numOfRow2 = mysqli_num_rows($sqlQuery2); 
                            ?>
                            <select class="form-control" name="devision">
                                <option value= "0" >~ SELECT DIVISION ~</option>
                                <?php
                                    while ($row = mysqli_fetch_assoc($sqlQuery2)) {
                                ?>
                                <option value="<?php echo $row['dev_id']; ?>"><?php echo $row['dev_name']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label value="0" >Team</label>
                            <?php
                            $sqlSelect3 = "SELECT * FROM `team`";
                            $sqlQuery3 = mysqli_query($con, $sqlSelect3);
                            $numOfRow3 = mysqli_num_rows($sqlQuery3);
                            ?>
                            <select class="form-control" name="team">
                                <option value="0" >~ SELECT TEAM ~</option>
                                <?php
                                    while($row = mysqli_fetch_assoc($sqlQuery3)) {
                                ?>
                                 <option value="<?php echo $row['team_id']; ?>"><?php echo $row['team_name']; ?></option>
                                 <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Employee Image</label>
                    <input class="form-control-file" type="file" name="file">
                </div>
                <div class="form-group">
                    <h4><strong>Educational Details</strong></h4>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Education Qualification</label>
                    <?php
                    $eduSQL = "SELECT * FROM `education`";
                    $eduQuery = mysqli_query($con, $eduSQL);
                    $eduNfRow = mysqli_num_rows($eduQuery); 
                    ?>
                    <select class="form-control" name="minimum_edu">
                        <option value= "0" >~ SELECT QUALIFICATION ~</option>
                        <?php
                            while ($eduRow = mysqli_fetch_assoc($eduQuery)) {
                        ?>
                        <option value="<?php echo $eduRow['edu_id']; ?>"><?php echo $eduRow['edu_level']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Other Qualifications</label>
                    <textarea class="form-control" name="extra_edu" rows="4" placeholder="Enter other Qualifications." autocomplete="off"></textarea> 
                </div>
                <div class="form-group">
                    <label>Extra Curricular Activities</label>
                    <textarea class="form-control" name="sports" rows="4" placeholder="Enter Extra Curricular Activities." autocomplete="off"></textarea> 
                </div>
                
                <div class="form-group">
                    <h4><strong>Experience</strong></h4>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-lable">Date Of Join</label>
                            <input class="form-control" type="date" name="e_doj" autocomplete="off" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="table-responsive" style="overflow-x:auto;">
                    <table class="table table-bordered table-responsive" style="border-width: 2px;">
                        <tr>
                            <th class="text-center">Previous Employment</th>
                            <th class="text-center">Occupation</th>
                            <th class="text-center">Service Period</th>
                        </tr>
                        <tr>
                        <td><textarea name="other_company" rows="4" placeholder="Enter other companys." autocomplete="off" style="border:0;" autocomplete="off"></textarea></td>
                        <td><textarea name="occupation" rows="4" placeholder="Enter other companys." autocomplete="off" style="border:0;" autocomplete="off"></textarea></td>
                        <td><textarea name="time_period" rows="4" placeholder="Enter other companys." autocomplete="off" style="border:0;" autocomplete="off"></textarea></td>
                        </tr>
                    </table>
                </div>
            </div>
             <div class="form-group">
                <h3><strong>Skill Metrics</strong></h3>
                <hr>
            </div>
           
            <div class="table-responsive" style="overflow-x:auto;">
                <table class="table table-bordered table-responsive">
                            
                <tr>
                    <th></th>
                    <th class="text-center">O/L</th>
                    <th class="text-center">F/L</th>
                    <th class="text-center">S/N</th>
                    <th class="text-center">D/N</th>
                    <th class="text-center">B/T</th>
                    <th class="text-center">B/H</th>
                    <th class="text-center">B/A</th>
                    <th class="text-center">BICOT</th>
                    
                 
                </tr>
                
        <tr>
            <th>Super</th>
            <td class="text-center"><input type="checkbox" name="over_lock"      value="1" ></td>
            <td class="text-center"><input type="checkbox" name="flat_lock"      value="1" ></td>
            <td class="text-center"><input type="checkbox" name="single_needle"  value="1" ></td>
            <td class="text-center"><input type="checkbox" name="double_needle"  value="1" ></td>
            <td class="text-center"><input type="checkbox" name="bar_tack"       value="1" ></td>
            <td class="text-center"><input type="checkbox" name="button_hole"    value="1" ></td>
            <td class="text-center"><input type="checkbox" name="button_attach"  value="1" ></td>
            <td class="text-center"><input type="checkbox" name="picot"          value="1" ></td>
        </tr>
        <tr>
            <th>Skill</th>
            <td class="text-center"><input type="checkbox" name="over_lock"      value="2" ></td>
            <td class="text-center"><input type="checkbox" name="flat_lock"      value="2" ></td>
            <td class="text-center"><input type="checkbox" name="single_needle"  value="2" ></td>
            <td class="text-center"><input type="checkbox" name="double_needle"  value="2" ></td>
            <td class="text-center"><input type="checkbox" name="bar_tack"       value="2" ></td>
            <td class="text-center"><input type="checkbox" name="button_hole"    value="2" ></td>
            <td class="text-center"><input type="checkbox" name="button_attach"  value="2" ></td>
            <td class="text-center"><input type="checkbox" name="picot"          value="2" ></td>
            
        </tr>
        <tr>
            <th>Poor</th>
            <td class="text-center"><input type="checkbox" name="over_lock"       value="3" ></td>
            <td class="text-center"><input type="checkbox" name="flat_lock"       value="3" ></td>
            <td class="text-center"><input type="checkbox" name="single_needle"   value="3" ></td>
            <td class="text-center"><input type="checkbox" name="double_needle"   value="3" ></td>
            <td class="text-center"><input type="checkbox" name="bar_tack"        value="3" ></td>
            <td class="text-center"><input type="checkbox" name="button_hole"     value="3" ></td>
            <td class="text-center"><input type="checkbox" name="button_attach"   value="3" ></td>
            <td class="text-center"><input type="checkbox" name="picot"           value="3" ></td>
            
        </tr>
      </table>
  </div>
</div>
</div>
<div class="form-group">
    <div class="col-md-12">
         <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
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