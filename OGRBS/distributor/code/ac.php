<?php
session_start();
include_once('../../includes/db_con.php');
if($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_SESSION['did']))
{
	$cid=$_POST["cid"];
	$name=$_POST["name"];
	$add=$_POST["add"];
	$ct=$_POST["ct"];
	$pin=$_POST["pin"];
	$mno=$_POST["mno"];
	$eid=$_POST["eid"];

	$result=mysqli_query($conn,"select * from consumer_detail where cid=$cid") or die(mysqli_error($conn));
	if(mysqli_num_rows($result)>0)
	{
		$tp = "danger";
		$bdy = "Given consumer id is already registered!";		
	}
	else
		{
		$result=mysqli_query($conn,"select * from consumer_detail where m_no=$mno") or die(mysqli_error($conn));
		if(mysqli_num_rows($result)>0)
		{
			$tp = "danger";
			$bdy = "Given mobile number is already registered!";
		}
		else
		{
			$result=mysqli_query($conn,"select * from consumer_detail where e_id='$eid'") or die(mysqli_error($conn));
			if(mysqli_num_rows($result)>0)
			{
				$tp = "danger";
				$bdy = "Given email-id is already registered!";
			}
			else
			{
				$did = $_SESSION['did'];
				mysqli_query($conn,"INSERT INTO `consumer_detail`(`cid`,`did`, `name`, `address`, `city`, `pin`, `m_no`, `e_id`) 
							VALUES ('$cid', '$did', '$name', '$add', '$ct', '$pin', '$mno', '$eid')") or die(mysqli_error($conn));
				$tp = "success";
				$bdy = "Registration successful.";			
			}
		}
	}
	echo '<div class="alert alert-'.$tp.'" role="alert" style="margin-bottom:0">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				'.$bdy.'
			</div>
			<script>
				window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
				});
				}, 4000);
			</script>';
		if($bdy == "Registration successful.")
		{
			echo '<script>
				myFunction();
					function myFunction() {
					document.getElementById("ac_form").reset();
					}
				</script>';
		}
}
else
{
	header('Location:../index.php');
}
?>