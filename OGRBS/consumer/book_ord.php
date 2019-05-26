<?php
session_start();
include_once('../includes/db_con.php');

if(isset($_SESSION['cid']))
{
	
	$title='Book Order';
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
        $('#1').addClass('active');
	});
	</script>
	";
	
	
	echo '
	<div class="container">
		<br>
		<div class="panel panel-default">
			<div class="panel-heading"><h2>'.$title.'</h2></div>
			<div class="panel-body">
	
				<form onSubmit="return t_sub();" method="post">

					<div class="form-group">
						<label><b>Terms & Conditions *</b></label>
						<div style="border: 1px solid #e5e5e5; height: 300px; overflow: auto; padding: 10px;">
							<p><i class="glyphicon glyphicon-chevron-right"></i> Current price for single gas-cylinder is <span class="text-success">&#x20B9;475.</span></p>
							<p><i class="glyphicon glyphicon-chevron-right"></i> Order cannot be canceled once you place order.</p>
							<p><i class="glyphicon glyphicon-chevron-right"></i> Prices may be change as per government rules.</p>
							<p><i class="glyphicon glyphicon-chevron-right"></i> You cannot place order for more than one gas cylinder.</p>
							<p><i class="glyphicon glyphicon-chevron-right"></i> Once your order will deliver then and then you can place order for another refill.</p>
							<p><i class="glyphicon glyphicon-chevron-right"></i> Order will be delivered to registered address.</p>
							<p><i class="glyphicon glyphicon-chevron-right"></i> Order status update will be drop via SMS(Linked mobile no.) & Email(Linked email address).</p>
							<p><i class="glyphicon glyphicon-chevron-right"></i> Order will be delivered with week, If not then you can write complain to us.</p>
							<p><i class="glyphicon glyphicon-chevron-right"></i> Product delivery is strictly on first come first served basis.</p>
						</div>
					</div>
				
					<div class="form-group">
						<div class="checkbox">
							<label>
								<input id="co_cb" onChange="return chk(this);" type="checkbox" name="agree" value="agree"/> Agree with the terms and conditions
							</label>
						</div>
					</div>
				
					<div class="form-group">
						<button type="submit" id="submit" class="btn btn-warning" disabled>Confirm Order</button>
						
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
						
					</div>
					
				</form>
				<p id="oc_msg" class="text-danger"></p>
				<script>
				/*
					$("#fn,#mn,#ln").on("keydown", function (e) {
						return e.which !== 32;
					}); */
					function chk(co_cb)
					{
						if(co_cb.checked==false)
						{
							document.getElementById("submit").disabled=true;
						}
						else if(co_cb.checked==true)
						{
							document.getElementById("submit").disabled=false;
						}
						return false;
					}
					function t_sub()
					{
						$.ajax({
									type: "POST",
									url: "code/confirm_ord.php",
									data: "",
									beforeSend: function() { 
										document.getElementById("preload").style="display:inline;";
									},
									success: function(html)
										{
											document.getElementById("preload").style="display:none;";
											$("#oc_msg").html(html);								
										}
						});
					
						return false;
					}
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