<?php
//New Consumer registration
include_once('includes/db_con.php');
if(isset($_REQUEST['conid']))
{
	$cid = $_REQUEST['conid'];
	$cmno = $_REQUEST['cmno'];
	$cpass = $_REQUEST['cpass'];
	
	//check user is registered?
	$result=mysqli_query($conn,"select status from consumer_detail where cid='$cid'") or die(mysqli_error($conn));
	$r=mysqli_fetch_row($result);
	
	if(mysqli_num_rows($result)==0)
	{
		echo 'We did not get any consumer id that linked with your mobile no.';
	}
	else if($r[0]=='Active' or $r[0]=='Deactive')
	{
		echo 'Your account/mobile no. is already registered.';
	}
	else if($r[0]=='Not Registered')
	{
		$q = "UPDATE `consumer_detail` SET `pwd`='$cpass',`reg_date`=CURRENT_DATE(),`status`='Active' WHERE cid=$cid";		
		mysqli_query($conn,$q) or die(mysqli_error($conn));
		
		echo "<script>alert('Your registration has been done, Now you can do log-in.');</script>";
		
		echo 'True';
	}
}
else
{
	header('Location:index.php');
}
?>