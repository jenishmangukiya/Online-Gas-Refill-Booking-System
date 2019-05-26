<?php
session_start();
include_once('../includes/db_con.php');

if(isset($_SESSION['did']))
{
	$title='Distributor-Dashboard';
	$did=$_SESSION['did'];
	
	$result=mysqli_query($conn,"select name from distributor_detail where did=$did");
	$r=mysqli_fetch_row($result);
	
	$dis_name=' '.$r[0];
	$path='design/';
	
	include_once('design/header.php');
	
	//fetch current distributor details
	$result=mysqli_query($conn,"select * from distributor_detail where did=$did") or die(mysqli_error($conn));
	$r=mysqli_fetch_array($result);
	
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
									<th colspan=2 class="text-center">Distributor Details</th>
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
						</table>
					</div>
					
				  </div>';
		
		echo '
				  <div class="col-sm-6">
					
					<div class="row">
						<div class="col-sm-6">
							<div class="square-service-block">
								<a href="d_prof.php" class="btn btn-info btn-lg">
								<span class="glyphicon glyphicon-user"></span> 
								<br><b>Profile<b>
								</a>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="square-service-block">
								<a href="add_con.php" class="btn btn-success btn-lg">
								<span class="glyphicon glyphicon-copy"></span> 
								<br><b>Add Connection<b>
								</a>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="square-service-block">
								<a href="man_con.php" class="btn btn-primary btn-lg">
								<span class="	glyphicon glyphicon-tasks"></span> 
								<br><b>Manage Consumers<b>
								</a>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="square-service-block">
								<a href="chk_ord.php" class="btn btn-warning btn-lg">
								<span class="glyphicon glyphicon-retweet"></span> 
								<br><b>Check Orders<b>
								</a>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="square-service-block">
								<a href="view_fc.php" class="btn btn-danger btn-lg">
								<span class="glyphicon glyphicon-edit"></span> 
								<br><b>View <br>Feedback & Complaint<b>
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