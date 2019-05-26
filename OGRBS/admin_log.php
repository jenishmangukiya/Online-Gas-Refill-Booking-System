<?php
session_start();
include_once('includes/db_con.php');

if(isset($_REQUEST['aid']))
{
	$aid = $_REQUEST['aid'];
	$apass = $_REQUEST['apass'];
	
	$result=mysqli_query($conn,"SELECT pwd from admin where aid='$aid'") or die(mysqli_error($conn));
	$r=mysqli_fetch_row($result);
	
	if($r[0]==$apass)
	{
		$_SESSION['aid']=$aid;
		echo 'True';
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