<?php
session_start();
include_once('includes/db_con.php');

if(isset($_REQUEST['conid']))
{
	$cid = $_REQUEST['conid'];
	$cpass = $_REQUEST['cpass'];
	
	$result=mysqli_query($conn,"SELECT pwd from consumer_detail where cid=$cid") or die(mysqli_error($conn));
	$r=mysqli_fetch_row($result);
		
	if($r[0]==$cpass)
	{
		$result=mysqli_query($conn,"SELECT status from consumer_detail where cid=$cid") or die(mysqli_error($conn));	
		$r=mysqli_fetch_row($result);
		
		if($r[0]=='Deactive')
		{
			echo 'Your account is now deactivated due to not access since last five month.';
		}
		else
		{
			$_SESSION['cid']=$cid;
			echo 'True';
		}
	}
	else
	{
		echo 'Invalid ID or Password.';
	}
}
else
{
	header('Location:index.php');
}
?>