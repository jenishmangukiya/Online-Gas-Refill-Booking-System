<?php
session_start();
include_once('../includes/db_con.php');

if(isset($_SESSION['did']))
{
	
	$title='Check Orders';
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
        $('#3').addClass('active');
	});
	</script>
	";
	
	//select  city name from distributor
	//$dct=mysqli_fetch_row(mysqli_query($conn,"select city from distributor_detail where did=1"))[0] or die(mysqli_error($conn));
	
	//fetch all order whose status is not Delivered
	$result=mysqli_query($conn,"select o.oid,o.cid,c.name,o.date,o.time,o.amt,o.status from consumer_detail c
								INNER JOIN order_detail o
								ON c.cid=o.cid
								where o.did=$did and o.status!='Delivered'
								order by o.date,o.time ") or die(mysqli_error($conn));
	
	echo '
	<div class="container">
		<br>
		<div class="panel panel-default" id="runOrd">
			<div class="panel-heading"><h2>Running Orders</h2></div>
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
					});
				</script>
				
				<div class="row" style="margin-left:0;margin-right:0">
					<div class="col-md-10">
						<input class="form-control" id="tinput" type="text" placeholder="Search..">
					</div>
					<div class="col-md-2">
						<style type="text/css" media="print">
							@page { size: A3 landscape; }
						</style>
						<script>
							function printDiv(divName) {
								 var printContents = document.getElementById(divName).innerHTML;
								 var originalContents = document.body.innerHTML;

								 document.body.innerHTML = printContents;

								 window.print();

								 document.body.innerHTML = originalContents;
							}
						</script>
						<p data-placement="top" data-toggle="tooltip" title="Print">
							<button class="btn btn-success btn-block" onclick="printDiv('."'runOrd'".')"><span class="	glyphicon glyphicon-print"></span> Print/PDF</button>
						</p>
					</div>
				</div>	
  
				<table class="table table-striped" style="font-size:95%">
					<thead>
					  <tr>
						<th>Order Id</th>
						<th>Consumer Id</th>
						<th>Consumer Name</th>
						<th>Order Date</th>
						<th>Order Time</th>
						<th>Amount</th>
						<th>Order Status</th>
					  </tr>
					</thead>
					<tbody id="myTable">
					  '; 
					 
					$d=''; // contain each record
					while($r=mysqli_fetch_row($result))
					{
						$d.='<tr>';
							$d.='<td>'.$r[0].'</td>
								 <td>'.$r[1].'</td>
								 <td>'.$r[2].'</td>								
								 <td>'.$r[3].'</td>								
								 <td>'.$r[4].'</td>	
								 <td>'.$r[5].'</td>
								 <td>
									<select class="form-control" name="status" id="'.$r[0].'" onChange="return s_up(this.id,this.value);">';
									if($r[6]=='Pending')
									{
										$d.='<option value="Pending">Pending</option>
											<option value="Approved">Approved</option>
											<option value="Out for delivery">Out for delivery</option>
											<option value="Delivered">Delivered</option>';
									}
									else if($r[6]=='Approved')
									{
										$d.='<option value="Approved">Approved</option>
											<option value="Out for delivery">Out for delivery</option>
											<option value="Delivered">Delivered</option>';										
									}
									else if($r[6]=='Out for delivery')
									{
										$d.='<option value="Out for delivery">Out for delivery</option>
											<option value="Delivered">Delivered</option>';										
									}	
								 $d.='</select>
									</td>								 
								';
						$d.='</tr>';
					}
					echo $d; // it will print table 
					
					echo '
					</tbody>
				  </table> 
				  
						<!--Loading bar-->
						<div id="preload">
							<img src="../process.gif" width=35% style="margin-top:40px;filter: invert(100%) brightness(130%);">
						</div>
						<style>
							#preload { 
							display:none;
							width:100%;
							height: 100%;
							top:0;
							left:0;
							position: fixed;
							text-align:center;
							background: rgba(0, 0, 0, 0.5);
						</style>
						
					<script>
						function s_up(oid,s_val)
						{
							var flag=confirm("Are you sure, you want to update status of order-id="+oid);
							
							if(flag==1)
							{
								$.ajax({
										type: "GET",
										url: "code/up_o_status.php",
										data: "oid="+oid+"&s_val="+s_val,
										beforeSend: function() { 
											document.getElementById("preload").style="display:inline;";
										},
										success: function(html)
											{
												document.getElementById("preload").style="display:none;";
												alert(html);
												window.location.reload();
											}
								});
							}
							else
							{
								window.location.reload();
							}
							return false;
						}
					</script>
					</div></div></div></div>
	';
	
	//fetch all order whose status is Delivered
	$result=mysqli_query($conn,"select o.oid,o.cid,c.name,o.date,o.time,o.amt,o.status from consumer_detail c
								INNER JOIN order_detail o
								ON c.cid=o.cid
								where o.did=$did and o.status='Delivered'
								order by o.date,o.time ") or die(mysqli_error($conn));	
	//Completed order
	echo '
	<div class="container">
		<br>
		<div class="panel panel-default" id="delOrd">
			<div class="panel-heading"><h2>Delivered Orders</h2></div>
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
							<button class="btn btn-success btn-block" onclick="printDiv('."'delOrd'".')"><span class="	glyphicon glyphicon-print"></span> Print/PDF</button>
						</p>
					</div>
				</div>
  
				<table class="table table-striped" style="font-size:95%">
					<thead>
						  <tr>
							<th>Order Id</th>
							<th>Consumer Id</th>
							<th>Consumer Name</th>
							<th>Order Date</th>
							<th>Order Time</th>
							<th>Amount</th>
							<th>Order Status</th>
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