<?php

//index.php

//Include Configuration File
include('config.php');

$login_button = '';


if(isset($_GET["code"]))
{

 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


 if(!isset($token['error']))
 {
 
  $google_client->setAccessToken($token['access_token']);

 
  $_SESSION['access_token'] = $token['access_token'];
    $google_service = new Google_Service_Oauth2($google_client);

 
  $data = $google_service->userinfo->get();

 
  if(!empty($data['given_name']))
  {
   $_SESSION['user_first_name'] = $data['given_name'];
  }

  if(!empty($data['family_name']))
  {
   $_SESSION['user_last_name'] = $data['family_name'];
  }

  if(!empty($data['email']))
  {
   $_SESSION['user_email_address'] = $data['email'];
  }

  if(!empty($data['gender']))
  {
   $_SESSION['user_gender'] = $data['gender'];
  }

  if(!empty($data['picture']))
  {
   $_SESSION['user_image'] = $data['picture'];
  }
 }
}


if(!isset($_SESSION['access_token']))
{

 $login_button = '<a href="'.$google_client->createAuthUrl().'" id="connect"></a>';
}

?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>ECR Checkin - Google Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
 
 </head>
 <body onload="document.getElementById('connect').click();">
  <div class="container">
   <div class="panel panel-default">
   <?php
   if($login_button == '')
   {
    /*echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
    echo '<img src="'.$_SESSION["user_image"].'" class="img-responsive img-circle img-thumbnail" />';
    echo '<h3><b>Name :</b> '.$_SESSION['user_first_name'].' '.$_SESSION['user_last_name'].'</h3>';
    echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
    echo '<h3><a href="logout.php">Logout</h3></div>';*/
    
    include("../wadmin/db-config.php");
    $name = $_SESSION['user_first_name'].' '.$_SESSION['user_last_name'];
    $email = $_SESSION['user_email_address'];
    $profile_photo = $_SESSION['user_image'];
    $mobile = "";
    $address = "";
    $data = array(
    'key' => $json_key,
    'action' => 'member_google_login',
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
          $_SESSION['member_mobile']   = $result['mobile'];
          $_SESSION['member_address']   = $result['address'];
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
   else
   {
    echo '<div align="center">'.$login_button . '</div>';
   }
   ?>
   </div>
  </div>
 </body>
</html>