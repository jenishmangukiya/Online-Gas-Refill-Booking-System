<?php
session_start();
include_once('../includes/db_con.php');

if(isset($_SESSION['cid']))
{
	$title='Consumer-Dashboard';
	$cid=$_SESSION['cid'];
	
	$result=mysqli_query($conn,"select name from consumer_detail where cid=$cid");
	$r=mysqli_fetch_row($result);
	
	$con_name=' '.$r[0];
	$path='design/';
	
	include_once('design/header.php');
	
	//Add active class for navigation bar
	echo "
	<script>
	$(document).ready(function(){
        $('').addClass('active');
	});
	</script>
	";
	
	//fetch current consumer detail
	$result = mysqli_query($conn,"select * from consumer_detail where cid=$cid") or die(mysqli_error($conn));
	$r = mysqli_fetch_array($result);
	
	echo '
	<style>
	.row .glyphicon {
		font-size: 50px;
	}
	.square-service-block
	{
		
		position:relative;
		overflow:hidden;
		margin:15px auto;
		//padding:10px;
	}
	.square-service-block a {
	  border-radius: 5px;
	  display: block;
	  padding: 30px 10px;
	  text-align: center;
	  width: 100%;
	}
	.square-service-block a:hover b{
		text-decoration:underline;
	}
	table
	{
		font-size:medium;
	}
	thead tr{
		 background: #009688;
		 color:white;
	}
	</style>
	
	<div class="container">
		<br>
		<div class="panel panel-default">
			<div class="panel-heading"><h2>'.$title.'</h2></div>
			<div class="panel-body">
	
				<div class="row">

				  <div class="col-sm-6">
				  
					<div class="table-responsive">  
						<table class="table table-striped">
							<thead>
								<tr>
									<th colspan=2 class="text-center">Consumer Details</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>Consumer ID :</th>
									<td>'.$r['cid'].'</td>
								</tr>
								<tr>
									<th>Consumer Name :</th>
									<td>'.$r['name'].'</td>
								</tr>
								<tr>
									<th>Registered Address :</th>
									<td>'.$r['address'].'</td>
								</tr>
								<tr>
									<th>Registered Mobile No. :</th>
									<td>'.$r['m_no'].'</td>
								</tr>	
								<tr>
									<th>Registered Email :</th>
									<td>'.$r['e_id'].'</td>
								</tr>								
							</tbody>
						</table>';

		//fetch linked distributor detail
		$did=$r['did'];
		$result = mysqli_query($conn,"select * from distributor_detail where did=$did") or die(mysqli_error($conn));
		$r = mysqli_fetch_array($result);						
						
					echo '
						<table class="table table-striped">
							<thead>
								<tr>
									<th colspan=2 class="text-center">Linked Distributor Details</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>Distributor ID :</th>
									<td>'.$r['did'].'</td>
								</tr>
								<tr>
									<th>Distributor Name :</th>
									<td>'.$r['name'].'</td>
								</tr>
							</tbody>
						</table>
						
					</div>
					
				  </div>
				  <div class="col-sm-6">
					
					<div class="row">
						<div class="col-sm-6">
							<div class="square-service-block">
								<a href="c_prof.php" class="btn btn-info btn-lg">
								<span class="glyphicon glyphicon-user"></span> 
								<br><b>Profile<b>
								</a>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="square-service-block">
								<a href="book_ord.php" class="btn btn-success btn-lg">
								<span class="glyphicon glyphicon-shopping-cart"></span> 
								<br><b>Book Order<b>
								</a>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="square-service-block">
								<a href="track_refill.php" class="btn btn-primary btn-lg">
								<span class="glyphicon glyphicon-hourglass"></span> 
								<br><b>Track Order<b>
								</a>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="square-service-block">
								<a href="ord_history.php" class="btn btn-warning btn-lg">
								<span class="glyphicon glyphicon-copy"></span> 
								<br><b>Order History<b>
								</a>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="square-service-block">
								<a href="feed_com.php" class="btn btn-danger btn-lg">
								<span class="glyphicon glyphicon-edit"></span> 
								<br><b>Feedback & Complaint<b>
								</a>
							</div>
						</div>						
					</div>
									
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