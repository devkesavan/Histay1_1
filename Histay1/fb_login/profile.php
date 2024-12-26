<?php
session_start();
include("../wadmin/db-config.php");

if($_SESSION['fb_id'])
{
    $name = $_SESSION['fb_name'];
    $email = $_SESSION['fb_email'];
    $profile_photo = $_SESSION['fb_pic'];
    $mobile = "";
    $address = "";
    $data = array(
    'key' => $json_key,
    'action' => 'member_fb_login',
    'name' => $name, 
    'address' => $address,
    'email' => $email,
    'mobile' => $mobile,  
    'password' => "",
    'profile_photo' => "$profile_photo"
    );
    $result = call_json($data);
    
    if($result['success'] == 1)
    {
      if($result['status'] == 'A')
      {
          $_SESSION['member_uid'] = $result['member_id'];
          $_SESSION['member_email']   = $result['email'];
          $_SESSION['member_name']   = $result['name'];
          $_SESSION['member_photo']   = $result['profile_photo'];
          $_SESSION['member_login_token']   = $result['login_token'];
          
          $number = "9944151706";
          $message = "Hi $_SESSION[member_name], Welcome to ECR Checkin! Thank you for joining us!!";
          
          /*if($result['new_member'] == "Y")
            send_whatsapp($number,$message);*/
          
          echo "<script>window.location.href='../index.php';</script>";
      }
      else
      {
          echo "<script>alert('Access Denied');</script>";
          echo "<script>window.location.href='../index.php';</script>";
      }
    }
    else
    {
        echo "<script>alert('The Email ID or password you have entered is incorrect.');</script>";
        echo "<script>window.location.href='../index.php';</script>";
    }
}
?>
<!--<head>
     <title>Login with Facebook</title>
     <link
        href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        rel = "stylesheet">
  </head>
  <body>     
  <?php if($_SESSION['fb_id']) {?>
        <div class = "container">
           <div class = "jumbotron">
              <h1>Hello <?php echo $_SESSION['fb_name']; ?></h1>
              <p>Welcome to Cloudways</p>
           </div>
              <ul class = "nav nav-list">
                 <h4>Image</h4>
                 <li><?php echo $_SESSION['fb_pic']?></li>
                 <h4>Facebook ID</h4>
                 <li><?php echo  $_SESSION['fb_id']; ?></li>
                 <h4>Facebook fullname</h4>
                 <li><?php echo $_SESSION['fb_name']; ?></li>
                 <h4>Facebook Email</h4>
                 <li><?php echo $_SESSION['fb_email']; ?></li>
              </ul>
          </div>
<?php } ?>
  </body>
</html>-->