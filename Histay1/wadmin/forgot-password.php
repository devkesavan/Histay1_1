<!DOCTYPE html>
<html lang="en">
<?php
include("header.php");
//Forget Token
function generateRandomString($length = 37) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

if(isset($_POST["forgot_password"]))
{
    extract($_POST);
        
    $sel_query = "select id from $members_table WHERE email='$email' and status!='E'";
    $is_found = $con->query($sel_query) or die(mysqli_error($con));
    $profile_count = $is_found->num_rows;
    if($profile_count > 0)
    {
        $data = $is_found->fetch_array();
        $forgot_token = generateRandomString();
        
        //update forgot token
        $update_qry = "update $members_table set forgot_token='$forgot_token' where id='$data[id]'";
        $con->query($update_qry);
        
        //Mail
        $mail_h4 = "Forgot password";
        $mail_h1 = "Request";
        $mail_main_msg = "";
        $mail_button = "Reset Password";
        $mail_button_url = $mail_website_url."reset_password.php?reset=1&ftoken=".$forgot_token."&email=".$_POST['email'];
    
        $from_mail = $mail_email;
        $from_name = "Reset Password  - $mail_website";
    
        $to_mail = $_POST['email'];
    
        $subject = "Reset Password | $mail_website";
    
        //Headers
        $headers .= "Reply-To: The Sender <$from_mail>\r\n";
        $headers .= "Return-Path: $from_name <$from_mail>\r\n";
        $headers .= "From: $from_name <$from_mail>\r\n";
    
        $headers .= "Organization: Sender Organization\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
    
        $htmlcontent = '<div style="background:'.$mail_bg.';width:100%;padding:50px 0;">
        <table style="font-family:Arial,Helvetica,sans-serif;color:#222;font-size:13px;width:80%;margin:0 auto;background:#fff;" cellpadding="12">
            <tr>
                <td colspan="2" style="width:200px;"><img src="'.$mail_logo.'" width="250"></td>
                <td colspan="3" style="text-align:right;line-height:1.7"><b>Contact:</b> '.$mail_phone.' <br><b>Email:</b> '.$mail_email.'</td>
            </tr>
            <tr>
                <td colspan="5" style="background:#11D388;padding:15px 0;text-align:center;color:#fff;">
                    <h4>'.$mail_h4.'</h4>
                    <h1>'.$mail_h1.'</h1>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    '.$mail_main_msg.'
                    <a href="'.$mail_button_url.'" style="background:#243F4F;color:#fff;padding:15px 20px;text-decoration:none;font-weight:bold;margin:0 auto;display:table;border-radius:7px;">'.$mail_button.'</a>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="background:#11D388;padding:20px 0;">
                    <p style="font-size:12px;color:#fff;text-align:center;padding:0 30px;">This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.</p>
                    <p style="font-size:12px;color:#fff;text-align:center;">Copyright &copy;  '.date('Y').' <a href="'.$mail_copyright_url.'" style="text-decoration:none;font-weight:bold;color:#fff;">'.$mail_copyright.'</a></p>
                </td>
            </tr>
        </table>
        </div>';
        
        // Send email
        $mail_sent = mail($to_mail, $subject, $htmlcontent, $headers);
        
        if($mail_sent === true)
        {
            echo "<script>alert('A verification email has been sent to your email address! Please check!');</script>";
            echo "<script>window.location.href='index.php';</script>";
        }
    }
    else
    {
        echo "<script>alert('Email id does not match our records!');</script>";
        echo "<script>window.location.href='forgot_password.php';</script>";
    }
}
?>


<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>HOTEL BOOKING</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
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
         
            <div class="card card-auth">
              <div class="card-header card-header-auth">
                <h4>Forgot Password</h4>
              </div>
              <!-- <center>
              <div class="logo-auth">
              	<img alt="image" src="assets/img/logo.png" />
          	  </div>
          	  <div>
          	  	<span class="logo-name-auth">Grexsan</span>
          	  </div>
          	  </center> -->
              <div class="card-body">
                <p class="text-muted">We will send a link to reset your password</p>
                <form method="POST">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-block btn-auth-color" tabindex="4">
                      Forgot Password
                    </button>
                  </div>
                </form>
              </div>
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