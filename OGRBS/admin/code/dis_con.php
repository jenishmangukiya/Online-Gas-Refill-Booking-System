<?php
session_start();
include_once('../../includes/db_con.php');
if(isset($_GET['did']) and isset($_SESSION['aid']))
{
	$did = $_GET['did'];
	
	//select all consumer_detail
	$result=mysqli_query($conn,"select cid,name,address,m_no,e_id,reg_date,status from consumer_detail where did=$did") or die(mysqli_error($conn));
	
	if(mysqli_num_rows($result)>0)
	{
		echo '
		<div class="table-responsive">
		<table class="table table-striped" style="font-size:95%">
						<thead>
						  <tr>
							<th>Consumer Id</th>
							<th>Name</th>
							<th>Address</th>
							<th>Contact</th>
							<th>Email</th>
							<th>Online Registration Date</th>
							<th>Account Status</th>
						  </tr>
						</thead>
						<tbody id="myTable">
						  '; 
						 
						$d=''; // contain each record
						while($r=mysqli_fetch_row($result))
						{
							$d.='<tr>';
							foreach($r as $v)
							{
								if($v=='Deactive')
									$d.='<td class=danger>'.$v.'</td>';
								else if($v=='Active')
									$d.='<td class=success>'.$v.'</td>';
								else
									$d.='<td>'.$v.'</td>';
							}

							// edit and delete button
						}
						$d.='</tr>';
						echo $d; // it will print table 
						
						echo '
						</tbody>
					  </table> 
			</div>';
	}
	else
	{
		echo '<script>alert("Record not found.");location.reload();</script>';
	}
}
else
{
	header('Location:../index.php');
}
?>