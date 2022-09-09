<?php
include("dbconfig.php");

  ob_start();
  session_start();
  $outputmsg = "";
?>




<?php
$msg = '';
      
if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $con=mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_NAME);
    if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
    //$sql="SELECT username,pw FROM users WHERE username='" . $username . "' AND pw='" . $password . "' AND Category=5";
    $sql= "SELECT user.id AS id,
                  user.username AS username, 
                  user.password AS password,
                  user.category AS category, 
                  user.epf_no   AS  epf_no, 
                  user_category.url AS url, 
                  user_category.description AS description 
            FROM user 
              LEFT JOIN user_category ON user.category=user_category.id 
              LEFT JOIN user_levels ON user.user_level=user_levels.id 
            WHERE username='" . $username . "' AND 
                  password='" . $password . "';" ;
    
    if ($result=mysqli_query($con,$sql)){

        $rowcount=mysqli_num_rows($result);

        switch ($rowcount) {
          case 0:
              ?><div class='alert alert-danger'> 
                <strong>Login Error : </strong> No user found in System </div>"
              <?php
              break;
          case 1:
               
            $row = mysqli_fetch_assoc($result);


				function get_trxn_max()
				{	
					$con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
					mysqli_select_db($con, DB_NAME);
					$trxnmax = mysqli_query($con, "SELECT MAX(`trxn_id`) as max FROM `trxn`");
					while ($trxnRow = mysqli_fetch_assoc($trxnmax)) {

					$trxnid  =  $trxnRow["max"] + 1;
					   
					}
					return $trxnid;
				}


				function get_trxn_dtl_max()
				{	
					$con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
					mysqli_select_db($con, DB_NAME);
					$trxn_dtlmax = mysqli_query($con, "SELECT MAX(`dtl_id`) as max FROM `trxn_dtl`");
					while ($trxn_dtlRow = mysqli_fetch_assoc($trxn_dtlmax)) {

					$trxnDtlid  =  $trxn_dtlRow["max"] + 1;
					   
					}
					return $trxnDtlid;
				}

            
            if($row['description'] =="Admin" AND $row['category'] == 2){

                
            	 $user_id     = $row['id'];

                 $trxnid    = get_trxn_max();
                 $trxnDtlid = get_trxn_dtl_max();
                 $_SESSION['adminUid']       = $user_id;
                 $_SESSION['tranxactionId']  = $trxnid;
                 $_SESSION['adminSession']   = $username;
             


    $trxn = "INSERT INTO `trxn`(`trxn_id`, `user_id`, `status`, `active`) VALUES ('$trxnid','$user_id','unread',1)";

    mysqli_query($con, $trxn);


    $trxn_dtl = "INSERT INTO `trxn_dtl`
    									(`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
    							VALUES 
    							        ('$trxnDtlid','$trxnid',1,CURRENT_TIMESTAMP)";


    mysqli_query($con, $trxn_dtl);


                ?>
                <div class='alert alert-danger'> 
                <strong>Login Error : </strong> one user found, directed to : <?php echo $row['url'] ?></div><?php 
                header('Location: ' . $row['url']);

            }elseif($row['description']=="HR" AND $row['category'] == 3){

            	   
            	 $user_id     = $row['id'];

                 $trxnid    = get_trxn_max();
                 $trxnDtlid = get_trxn_dtl_max();
                 $_SESSION['hrtranxactionId'] = $trxnid;
                 $_SESSION['hrSession']   = $username;
                 $_SESSION['hrUid']       = $user_id;
             


	      $trxn = "INSERT INTO `trxn`(`trxn_id`, `user_id`, `status`, `active`) VALUES ('$trxnid','$user_id','unread',1)";

	      mysqli_query($con, $trxn);


	      $trxn_dtl = "INSERT INTO `trxn_dtl`
	                        (`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
	                    VALUES 
	                            ('$trxnDtlid','$trxnid',1,CURRENT_TIMESTAMP)";


	      mysqli_query($con, $trxn_dtl);
                  

                ?>
                <div class='alert alert-danger'> 
                <strong>Login Error : </strong> one user found, directed to : <?php echo $row['url'] ?></div><?php 
                header('Location: ' . $row['url']);

            }elseif($row['description']=="Manager" AND $row['category'] == 4){


                 $user_id     = $row['id'];

                 $trxnid    = get_trxn_max();
                 $trxnDtlid = get_trxn_dtl_max();
                 $_SESSION['mtranxactionId'] = $trxnid;
                 $_SESSION['mangrSession']   = $username;
                 $_SESSION['mangrUid']       = $user_id;
             


      $trxn = "INSERT INTO `trxn`(`trxn_id`, `user_id`, `status`, `active`) VALUES ('$trxnid','$user_id','unread',1)";

      mysqli_query($con, $trxn);


      $trxn_dtl = "INSERT INTO `trxn_dtl`
                        (`dtl_id`, `trxn_id`, `type`, `trxn_date`) 
                    VALUES 
                            ('$trxnDtlid','$trxnid',1,CURRENT_TIMESTAMP)";


      mysqli_query($con, $trxn_dtl);
        

                  

                ?>
                <div class='alert alert-danger'> 
                <strong>Login Error : </strong> one user found, directed to : <?php echo $row['url'] ?></div><?php 
                header('Location: ' . $row['url']);

            }else{


            }
            
                                
            break;
          default:
              ?><div class='alert alert-danger'> 
                <strong>Login Error : </strong> duplicate users found, pls contact system administrator </div><?php 
        }

    }else {
        echo "SQL Query Error";
    }

}


?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Koggala</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/loginStyle.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

   	<script type="text/javascript" language="javascript" src="assets/js/jquery-1.10.2.js"></script>
   
</head>
<body>


	<div class="home">
		<div class="item">
      <div class="home_btn">
       <a href="koggalaWeb/index.php" class="btn btn-dark
       "><i class="fa fa-home fa-2x"></i></a>
      </div>
			<div class="content">
				<form action="#" method = "post">
					<div class="logo">
						<h1>K</h1>
					</div>
					<div class="input-group lg">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control" name="username" placeholder="User Name" autocomplete="off" id="form_user">
						<span id="username_error_message" class="text-denger font-weight-bold"></span>
					</div>
					<div class="input-group lg">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" id="form_password">
						<span id="password_error_message" class="text-denger font-weight-bold"></span>
					</div>
					<div class="form-group in">
						<input type="submit" name="login" class="btn btn-info btn-block" value="LOG IN">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>