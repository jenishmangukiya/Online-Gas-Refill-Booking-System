<?php
session_start();
include_once('../../includes/db_con.php');
if(isset($_GET['del']) and isset($_SESSION['aid']))
{
	mysqli_query($conn,'delete from distributor_detail where did='.$_GET['del'].'') or die(mysqli_error($conn));
	header('Location:../man_dis.php');
}
else
{
	header('Location:../index.php');
}
?>