<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/user.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<?php
include_once('includes/db_con.php');
include_once('apis/Way2SMS/way2sms-api.php');
include_once('apis/mail_cfg.php');
if(isset($_GET['dis']))
{
	echo '
	<div class="container">
	<h3 class="text-center"><i class="fa fa-lock fa-4x"></i></h3>
    <h2 class="text-center">Forgot Password?</h2>
	<form class="form" method="post">
		<div class="input-group">
			<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			<input id="did" type="text" class="form-control" name="did" placeholder="Your Distributor ID" required>
		</div>
		<br>
		<div class="form-group">
			<button class="btn btn-primary btn-block" type="submit">Notify me</button>
		</div>
	</form>
	</div>
	';
	if(isset($_POST['did']))
	{
		//for distributor pwd
		$did=$_POST['did'];
		$result=mysqli_query($conn,"select m_no,e_id,pwd from distributor_detail where did=$did") or die(mysqli_error($conn));
		
		if(mysqli_num_rows($result)>0)
		{
			$r=mysqli_fetch_row($result);
			
			//sms
			sendWay2SMS("9904436106","MJENISH8",$r[0],"Your password is - ".$r[2]);
			//email
			$mail->addAddress("$r[1]");
			$mail->Subject = 'Password recovery.';
			$mail->isHTML(true);
			$mailContent = "<h1>Distributor Id - $did</h1>
							<h1>Password - $r[2]</h1>
					<p>You can also change your password from profile section.</p>
					<p style='color:red'>Delete this mail after it's use for better security.</p>";
			$mail->Body = $mailContent;
			$mail->send();

			echo "<script>alert('Details send to your registered email-id and mobile no.')</script>";
		}
		else
		{
			echo "<script>alert('Invalid Distributor ID!!')</script>";
		}
	}
}
else if(isset($_GET['con']))
{
	echo '
	<div class="container">
	<h3 class="text-center"><i class="fa fa-lock fa-4x"></i></h3>
    <h2 class="text-center">Forgot Password?</h2>
	<form class="form" method="post">
		<div class="input-group">
			<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			<input id="cid" type="text" class="form-control" name="cid" placeholder="Your Consumer ID" required>
		</div>
		<br>
		<div class="form-group">
			<button class="btn btn-primary btn-block" type="submit">Notify me</button>
		</div>
	</form>
	</div>
	';
	if(isset($_POST['cid']))
	{
		//for consumer pwd
		$cid=$_POST['cid'];
		$result=mysqli_query($conn,"select m_no,e_id,pwd from consumer_detail where cid=$cid") or die(mysqli_error($conn));

		if(mysqli_num_rows($result)>0)
		{
			$r=mysqli_fetch_row($result);
			
			//sms
			sendWay2SMS("9904436106","MJENISH8",$r[0],"Your password is - ".$r[2]);
			
			//email
			$mail->addAddress("$r[1]");
			$mail->Subject = 'Password recovery.';
			$mail->isHTML(true);
			$mailContent = "<h1>Consumer Id - $cid</h1>
							<h1>Password - $r[2]</h1>
					<p>You can also change your password from profile section.</p>
					<p style='color:red'>Delete this mail after it's use for better security.</p>";
			$mail->Body = $mailContent;
			$mail->send();			
			
			echo "<script>alert('Details send to your registered email-id and mobile no.')</script>";
		}
		else
		{
			echo "<script>alert('Invalid Consumer ID!!')</script>";
		}	
	}
}
else
{
		header("Location:index.php");
}
?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>