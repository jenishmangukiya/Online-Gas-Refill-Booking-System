<?php
session_start();
include_once('../includes/db_con.php');

if(isset($_SESSION['aid']))
{
	$title='Feedback & Complaints';
	$aid=$_SESSION['aid'];
	
	$path='design/';
	
	include_once('design/header.php');
	
	//Add active class for navigation bar
	echo "
	<script>
	$(document).ready(function(){
        $('#2').addClass('active');
	});
	</script>
	";
	//fetch all distributor name for fill in dropdwon
	$result=mysqli_query($conn,"select name from distributor_detail") or die(mysqli_error($conn));
	$d_n="<option value='none'>-All-</option>";
	while($r=mysqli_fetch_row($result))
	{
		$d_n.="<option value='$r[0]'>$r[0]</option>";
	}
	
	//fetch feedbacks of all distributor
	$result=mysqli_query($conn,"select fc.cid,c.name,d.did,d.name,date,time,type,subject,description from feedback_complain fc
								INNER JOIN consumer_detail c
								ON c.cid=fc.cid
								INNER JOIN distributor_detail d
								ON d.did=fc.did
							") or die(mysqli_error($conn));
	echo '
	<div class="container">
		<br>
		<div class="panel panel-default">
			<div class="panel-heading"><h2>'.$title.'</h2></div>
			<div class="panel-body">
	
			<div class="table-responsive">
			
				<script>
					$(document).ready(function(){
					  $("#tinput").on("keyup", function() {
						var value = $(this).val().toLowerCase();
						$("#myTable tr").filter(function() {
						  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
						});
					  });
					  //on dropdown value change update table
					  $("#by_dn").change(
						function()
						{
							var value = $(this).val().toLowerCase();
							if(value!=="none")
							{
								$("#myTable tr").filter(function() {
								  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
								});
							}
							else
								location.reload();
						}
					  );
					});
				</script>
				
				<div class=row style="margin:0">
					<div class="col-md-5">
						<label class="col-sm-5 col-form-label">By Distributor name:</label>
						<div class="col-sm-7">
							<select class="form-control" id="by_dn">
								'.$d_n.'
							</select>
						</div>						
					</div>
					<div class="col-md-1" style="text-align:center;font-size:20px">
						Or
					</div>
					<div class="col-md-4">
						<input class="form-control" id="tinput" type="text" placeholder="Search..">
					</div>
					<div class="col-md-2">
						<style type="text/css" media="print">
							@page { size: A3 landscape; }
						</style>
						<p data-placement="top" data-toggle="tooltip" title="Print">
							<button class="btn btn-success btn-block" onclick="window.print();"><span class="	glyphicon glyphicon-print"></span> Print/PDF</button>
						</p>
					</div>
				</div>
				<br>
				<!--
				<input class="form-control" id="tinput" type="text" placeholder="Search..">-->
				<table class="table table-striped" style="font-size:95%">
					<thead>
					  <tr>
						<th>Consumer Id</th>
						<th>Consumer Name</th>
						<th>Distributor Id</th>
						<th>Distributor Name</th>
						<th>Date</th>
						<th>Time</th>
						<th>Type</th>
						<th>Subject</th>
						<th>Description</th>
					  </tr>
					</thead>
					<tbody id="myTable">
					  '; 
					$d=''; // contain each record
					while($r=mysqli_fetch_row($result))
					{
							$d.='<tr>';
							$counter=1;
								foreach($r as $v)
								{
									if($counter==4)
										$d.='<td id="d_name_td">'.$v.'</td>';
									else
										$d.='<td>'.$v.'</td>';	
									$counter++;
								}
							$d.='</tr>';
					}
					echo $d;
					
					echo '
					</tbody>
				  </table> 
				  
			</div>
				
			</div>
			
		</div>
	</div>
	';

	include_once('design/footer.php');
}
else
{
	header('Location:../index.php');
}
?>