<?php
session_start();
include_once('../includes/db_con.php');

if(isset($_SESSION['aid']))
{	
	$title='Admin-Dashboard';
	$path='design/';
	
	include_once('design/header.php');
	echo '
	<style>
	.b{
		padding:10px;
		padding-top:20px;
		margin:5px;
		color:white;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
		transition: all 0.3s cubic-bezier(.25,.8,.25,1);
	}
	.b:hover
	{
		box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
	}
	.row .glyphicon {
		font-size: 60px;
		padding:10px;
	}
	</style>
	';
	$tc = mysqli_fetch_row(mysqli_query($conn,"select count(cid) from consumer_detail"))[0];
	$td = mysqli_fetch_row(mysqli_query($conn,"select count(did) from distributor_detail"))[0];
	$tfc = mysqli_fetch_row(mysqli_query($conn,"select count(subject) from feedback_complain"))[0];
	
	//order fetch
	$po = mysqli_fetch_row(mysqli_query($conn,"select count(oid) from order_detail where status='Pending'"))[0]; //Pending
	$ao = mysqli_fetch_row(mysqli_query($conn,"select count(oid) from order_detail where status='Approved'"))[0]; //Approved
	$ofdo = mysqli_fetch_row(mysqli_query($conn,"select count(oid) from order_detail where status='Out for delivery'"))[0]; //Out for delivery
	$do = mysqli_fetch_row(mysqli_query($conn,"select count(oid) from order_detail where status='Delivered'"))[0]; //Delivered
	
	echo '
	<div class="container">
		<br>
		<div class="panel panel-default">
			<div class="panel-heading"><h2>'.$title.'</h2></div>
			<div class="panel-body">
				<div class="row" style="padding:10px">
					<div class="col-sm-4">
						<div class="b row" style="background:#00b8d4">
							<div class="col-md-4">
								<span class="glyphicon glyphicon-user"></span>
							</div>
							<div class="col-md-8">
								<h4><strong>Total Consumers</strong></h4>
								<h3>'.$tc.'</h3>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="b row" style="background:#00c853">
							<div class="col-md-4">
								<span class="glyphicon glyphicon-user"></span>
							</div>
							<div class="col-md-8">
								<h4><strong>Total Distributors</strong></h4>
								<h3>'.$td.'</h3>
							</div>
						</div>							
					</div>
					<div class="col-sm-4">
						<div class="b row" style="background:#455a64">
							<div class="col-md-4">
								<span class="glyphicon glyphicon-list-alt"></span>
							</div>
							<div class="col-md-8">
								<h4><strong>Feedback & Complaints</strong></h4>
								<h3>'.$tfc.'</h3>
							</div>	
						</div>
					</div>
				</div>
			
				<!-- order chart -->
				<!-- MDB core JavaScript -->
				<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.0/js/mdb.min.js"></script>
				
				<div class="row" style="padding:30px">
					<div class="col-sm-12" style="box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
						<h3 style="text-align:center">Orders statistics</h3>
						<canvas id="doughnutChart"></canvas>
					</div>
				</div>
				<script>		
					//doughnut
					var ctxD = document.getElementById("doughnutChart").getContext("2d");
					var myLineChart = new Chart(ctxD, {
						type: "doughnut",
						data: {
							labels: ["Pending", "Approved", "Out for delivery", "Delivered"],
							datasets: [
								{
									data: ['.$po.','.$ao.','.$ofdo.','.$do.'],
									backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1"],
									hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5"]
								}
							]
						},
						options: {
							responsive: true
						}    
					});
				</script>
				
				
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