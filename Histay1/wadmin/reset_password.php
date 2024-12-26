<?php
session_start();
include("header.php");
if(isset($_GET['ftoken']) && isset($_GET['email']))
{	    
    $sel_query = "select id from $master_admin_users_table WHERE email='$_GET[email]' and forgot_token='$_GET[ftoken]' and status!='E'";
	$is_found = $con->query($sel_query) or die(mysqli_error($con));
    if($is_found->num_rows > 0)
    {
        $data = $is_found->fetch_array();
        
        if(isset($_POST["reset_password"]))
        {
        	extract($_POST);
        	if($password == $confirm_password)
        	{
        		//update forgot token
        		$update_qry = "update $master_admin_users_table set password='$password' where id='$data[id]'";
            	$con->query($update_qry);
        	    
            	echo "<script>alert('Password updated successfully!');</script>";
        		echo "<script>window.location.href='index.php';</script>";
        	}
        	else
        	{
        		echo "<script>alert('Both passwords does not match!');</script>";
        		echo "<script>window.location.href='forgot_password.php';</script>";
        	}
        }
?>
 <section class="recover-area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="card-box-shared">
                    <div class="card-box-shared-body">
                        <div class="contact-form-action">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-box">
                                            <label class="label-text">New Password<span class="primary-color-2 ml-1">*</span></label>
                                            <div class="form-group">
                                                <input class="form-control" type="password" name="password" id="new_password" placeholder="Enter The New Password ">
                                                <span class="la la-envelope input-icon"></span>
                                            </div>
                                        </div>
                                        <div class="input-box">
                                            <label class="label-text">Conform Password<span class="primary-color-2 ml-1">*</span></label>
                                            <div class="form-group">
                                                <input class="form-control" type="password" name="confirm_password" id="new_password" >
                                                <span class="la la-envelope input-icon"></span>
                                            </div>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <button class="theme-btn" type="submit" name="reset_password">reset password</button>
                                        </div>
                                    </div><!-- end col-lg-12 -->
                                    <div class="col-lg-6">
                                        <p><a href="login.php" class="primary-color-2">Login</a></p>
                                    </div><!-- end col-lg-6 -->
                                    <div class="col-lg-6">
                                        <p class="text-right register-text">Not a member? <a href="sign-up.html" class="primary-color-2">Register</a></p>
                                    </div><!-- end col-lg-6 -->
                                </div><!-- end row -->
                            </form>
                        </div><!-- end contact-form -->
                    </div>
                </div>
            </div><!-- end col-lg-7 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end recover-area -->

<?php
    }
}
?>


<?php include("footer.php");?>