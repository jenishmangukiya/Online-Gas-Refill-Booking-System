<?php
//New distributor registration
include_once('includes/db_con.php');		
if(isset($_REQUEST['dname']))
{
	//print_r($_FILES['id_img']);
	$dname = $_REQUEST['dname'];
	$dadd = $_REQUEST['dadd'];
	$dcity = $_REQUEST['dcity'];
	$dpin = $_REQUEST['dpin'];
	$demail = $_REQUEST['demail'];
	$dmno = $_REQUEST['dmno'];
	$dcpass = $_REQUEST['dcpass'];
	

	$result=mysqli_query($conn,'select * from distributor_detail where m_no='.$dmno.' or e_id="'.$demail.'"') or die(mysqli_error($conn));
	
	if (mysqli_num_rows($result) > 0)
	{
		echo 'Given mobile no. or email is already registered.';
	}
	else
	{
		if($_FILES["id_img"]["type"]!="image/jpeg" &&
				$_FILES["id_img"]["type"]!="image/jpg" &&
				$_FILES["id_img"]["type"]!="image/png")
		{
			echo "<script>alert('Sorry, only JPG, JPEG & PNG files are allowed.')</script>";
		}
		else if(($_FILES["id_img"]["size"] > 2097152) || ($_FILES["id_img"]["size"] == 0))
		{
			echo "<script>alert('File too large. File must be less than 2 megabytes.')</script>";
		}
		
		else
		{			
			// For data insert
			$q = "INSERT INTO `distributor_detail`(`pwd`, `name`, `address`, `city`, `pin`, `m_no`, `e_id`) 
					VALUES ('$dcpass', '$dname', '$dadd', '$dcity', $dpin, $dmno, '$demail');";
			mysqli_query($conn,$q) or die(mysqli_error($conn));
			
			$result=mysqli_query($conn,"select did from distributor_detail where m_no=$dmno") or die(mysqli_error($conn));
			$r=mysqli_fetch_row($result);
			
			//move file to desired location
			$info = pathinfo($_FILES['id_img']['name']);
			$ext = ".".$info['extension'];
			$target_file="distributor/proof/".$r[0].$ext;
			move_uploaded_file($_FILES["id_img"]["tmp_name"], $target_file);
			mysqli_query($conn,"update distributor_detail set `proof`='$target_file' where m_no=$dmno") or die(mysqli_error($conn));
			
			// For send back distibutor id 
			$q = "SELECT `did` FROM `distributor_detail` WHERE m_no=$dmno";
			$result=mysqli_query($conn,$q) or die(mysqli_error($conn));
			$r=mysqli_fetch_row($result);
			
			echo "<script>
			alert('Your Distibutor ID is $r[0], It will be used for system log-in.');
			</script>";
			
			echo '<p id=dmsgg >True</p>';
		}
	}
}
else
{
	header('Location:index.php');
}
?>