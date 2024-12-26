<?php
	session_start();
	if(!isset($_SESSION['admin_uid']))
	{
		include_once ("db-config.php");
		//Connection Creation
		$con = new mysqli($host,$user,$pass,$db_name); 		
		$logo_dir = 'business_logo';
?>

<?php
	if(isset($_POST['btn_login']))
	{

		$eng_name = $_POST['eng_name'];
		$username = $_POST['username'];
		$paswd = mysqli_real_escape_string($con,$_POST['paswd']);
		//$paswd = base64_encode($paswd);
		
		$cur_date 	= date('Y-m-d');
		$created_at = date('Y-m-d H:i:s');
		
		$status 	= "A";
		$select_query = "SELECT * FROM $admin_table WHERE username='$username' AND password='$paswd'";
		$sel_query = $con->query($select_query) or die(mysqli_error($con));			
		$data      = $sel_query->fetch_array();
		$count     = $sel_query->num_rows;			
		if($count>0)
		{
			if($data['status'] == 'A')
			{
				$_SESSION['admin_uid'] 	= $data['id'];
				$_SESSION['uname'] 	= $data['username'];
				$_SESSION['uType'] 	= $data['user_type'];
				$_SESSION['name'] 	= $data['full_name'];

        echo "<script>window.location.href='index.php';</script>";
			}
			else
			{
				echo "<script>alert('Access Denied');</script>";
				echo "<script>window.location.href='login.php';</script>";
			}				
		}
		else
		{
			echo "<script>alert('The username or password you have entered is incorrect.');</script>";
			echo "<script>window.location.href='login.php';</script>";
		}	
	}
	?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>HOTEL BOOKING</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
</head>

<body class="background-image-body">
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
			<!-- <div class="login-brand login-brand-color">
            	<img alt="image" src="<?php echo $logo_dir.'/'.$data['business_logo'];?>" />
				SSR 
            </div> -->
			<div class="card card-auth">
              <div class="card-header card-header-auth">
                <h4><?php echo TITLE;?> Login</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="#" class="needs-validation" novalidate="" autocomplete="off">
                   <div class="form-group">
					  <label>Select</label>
					  <select name="eng_name" class="form-control" required>
						<option value=""> -- Select one -- </option>
						<option value="admin"> Admin</option>
						<option value="eng"> Employees</option>
					  </select>
				  </div>              
				  <div class="form-group">
                    <label for="email">User Name</label>
                    <input id="username" name="username"  type="text" class="form-control"  tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your name
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="forgot-password.php" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="paswd" name="paswd" type="password" class="form-control" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" name="btn_login" class="btn btn-lg btn-block btn-auth-color" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
                <div class="text-center mt-4 mb-3">
                  <div class="text-job text-muted">Login With Social</div>
                </div>
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="tel:+919841325252">Contact Admin</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>  
</body>
</html>

<?php 
		$con->close();
	} else {
		echo "<script>window.location.href='index.php'</script>";
		exit();
	}
?>	