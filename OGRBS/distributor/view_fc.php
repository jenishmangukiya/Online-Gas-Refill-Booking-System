<?php
session_start();
include_once('../includes/db_con.php');

if(isset($_SESSION['did']))
{
	$title='Feedback & Complaints';
	$did=$_SESSION['did'];
	
	$result=mysqli_query($conn,"select name from distributor_detail where did=$did");
	$r=mysqli_fetch_row($result);
	
	$dis_name=' '.$r[0];
	$path='design/';
	
	include_once('design/header.php');
	
	//Add active class for navigation bar
	echo "
	<script>
	$(document).ready(function(){
        $('#4').addClass('active');
	});
	</script>
	";

	//fetch feedbacks of current distributor
	$result=mysqli_query($conn,"select c.cid,name,date,time,type,subject,description from feedback_complain fc
								INNER JOIN consumer_detail c 
								ON fc.cid=c.cid
								where fc.did=$did") or die(mysqli_error($conn));	

	echo '
	<div class="container">
		<br>
		<div class="panel panel-default">
			<div class="panel-heading"><h2>'.$title.'</h2></div>
			<div class="panel-body">
	
			<div class="table-responsive">
			
			<script>
					$(document).ready(function(){
					  $("#tinput_c").on("keyup", function() {
						var value = $(this).val().toLowerCase();
						$("#com_ord tr").filter(function() {
						  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
						});
					  });
					});
			</script>
				
				<div class="row" style="margin-left:0;margin-right:0">
					<div class="col-md-10">
						<input class="form-control" id="tinput_c" type="text" placeholder="Search..">
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
				
				<table class="table table-striped" style="font-size:95%">
					<thead>
						  <tr>
							<th>Consumer Id</th>
							<th>Consumer Name</th>
							<th>Date</th>
							<th>Time</th>
							<th>Type</th>
							<th>Subject</th>
							<th>Description</th>
						  </tr>
					</thead>
					<tbody id="com_ord">';
					//contain each record
					$d='';
					while($r=mysqli_fetch_row($result))
					{
							$d.='<tr>';
								foreach($r as $v)
									$d.='<td>'.$v.'</td>';
							$d.='</tr>';
					}
					echo $d;
					echo '</tBody>			
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