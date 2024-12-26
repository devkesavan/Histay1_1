<?php 
	session_start();  
	if(isset($_SESSION['admin_uid']))
	{ 
		if($_GET['ac'] == 'print')
		{
			$pid = $_GET['pid'];
			//PDF Print section
			include('pdf.php');
			include "db-config.php";
			$con = new mysqli($host, $user, $pass, $db_name) or die(mysqli_error($con));
			$select_query = "SELECT * FROM $customer_table WHERE id='$pid' ";
			$result = $con->query($select_query);
			$htmlcontent = ''; 
			if ($result){
				$row = mysqli_fetch_array($result);
			}
			//Mail Configs
			$mail_website_url = "https://ssrheavydrivingschool.com/";
			$mail_logo = "url(https://ssrheavydrivingschool.com/assets/images/logo.png) no-repeat"; //Image path or color code
			$mail_phone = "+91 98413 25252, +91 98416 66113, 044 - 2226 0613 / 14";
			$mail_email = "saisaranraj_ssr@yahoo.co.uk";
			$mail_copyright = "SSR HEAVY DRIVING SCHOOL";
			$mail_copyright_url = $mail_website_url;
				
			//Mail			
			$mail_h1 = "Register Details";
			$mail_main_msg = "<div style='border:1px solid #000; padding:10px; width:600px; font-size: 14px; letter-spacing: 0.5px; '>
			                    <table cellpadding='5' align='center'>
    								<tr>
    									<td width='100'>Reg No </td>
    									<td width='250'>: ".$row['reg_id']."</td>
    								</tr>
    								<tr>
    									<td width='100'>Full name </td>
    									<td width='250'>: ".$row['full_name']."</td>
    								</tr>
    								<tr>
    									<td width='100'>Father name </td>
    									<td width='250'>: ".$row['father_name']."</td>
    								</tr>
    								<tr>
    									<td width='100'>Address </td>
    									<td width='250'>: ".$row['address1']."</td>
    								</tr>
    								<tr>
    									<td width='100'>Eamil </td>
    									<td width='250'>: ".$row['email']."</td>
    								</tr>
    									<tr>
    									<td width='100'>Phone No </td>
    									<td width='250'>: ".$row['mobile']."</td>
    								</tr>
    								<tr>
    									<td width='100'>Date of Birth </td>
    									<td width='250'>: ".$row['dob']."</td>
    								</tr>
    								<tr>
    									<td width='100'>Identification Mark</td>
    									<td width='250'>: ".$row['identification']."</td>
    								</tr>
    								<tr>
    									<td width='100'>Qualification </td>
    									<td width='250'>: ".$row['qualification']."</td>
    								</tr>
    								<tr>
    									<td width='100'>Blood Group Report </td>
    									<td width='250'>: ".$row['blood_group']."</td>
    								</tr>
    								<tr> 
    								    <td> </td>
    								    <td> </td>
    								</tr>
    								<tr>
    									<td width='100'>Register Date </td>
    									<td width='250'>: ".$row['created_at']."</td>
    								</tr>
							    </table>
			                  </div>";
			
			
			$mail_footer = '<p style="font-size:14px;text-align:center; line-height:24px;"> Address: No: 67, Mudichur Road, West Tambaram, Chennai-600 045.<br>
										E-mail: '.$mail_email.',    Web: '.$mail_website_url.'<br>
										Call: '.$mail_phone.'</p>
									<p style="font-size:14px;text-align:center;">Copyright &copy; '.date("Y").' <a href="'.$mail_copyright_url.'" style="text-decoration:none;font-weight:bold; color: red; ">'.$mail_copyright.'</a></p>';				  
			
			$htmlcontent = '<html>
							 <head>
								<style>
									@page {
										margin: 0cm 0cm;
									}
								</style>
							</head>
							<body style="width:100%; height:100vh;font-family:Arial,Helvetica,sans-serif;margin-top: 2cm;margin-left: 2cm;margin-right: 2cm;margin-bottom: 2cm;">
								<header style="position: fixed;top: 0cm;left: 0cm;right: 0cm;height: 4cm;text-align: center;line-height: 1.5cm;border-bottom: 1px solid  #ccc;border-top: 5px solid  #ccc;">
								   <table style="width:100%; padding-top:25px; padding-bottom:25px;">
										<tr>
											<td style="width:30%;"><img src="https://ssrheavydrivingschool.com/assets/images/ssr-logo.jpg" width="175px" style="padding-left:60px;"></td>
											<td style="width:60%;"> <img src="https://ssrheavydrivingschool.com/assets/images/text-logo.jpg" style="margin-top:-15px;"> </td>
										</tr>
									</table>
								</header>
								<footer style="background: #e7e7e7; position: fixed;bottom: 0cm;left: 0cm;right: 0cm;height: 4cm; text-align: center;">'.$mail_footer.'</footer>
								<main style="margin-top:100px !important;">
									<h1 style="font-family:Arial,Helvetica,sans-serif;font-size:18px;font-weight:bold;padding-top:35px;padding-bottom:20px;text-align:center;">'.$mail_h1.'</h1>
									<div style="padding:15px 10px;">'.$mail_main_msg .'</div>
								</main>
							
							</body>
						</html>';
			
			
			//echo $htmlcontent;				
			$pdf = new Pdf();
			$pdf->load_html($htmlcontent);
			$pdf->setPaper('A4', 'portrait');
			$pdf->render();
			ob_end_clean();
			$pdf->stream("receipt", array("Attachment"=>0));
			exit; 
		}
		
	
	//session End
	$con->close();
	} else {
		echo "<script>window.location.href='login.php';</script>";
	}
?>