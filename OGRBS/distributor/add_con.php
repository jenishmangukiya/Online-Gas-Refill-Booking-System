<?php
session_start();
include_once('../includes/db_con.php');

if(isset($_SESSION['did']))
{
	
	$title='Add Connection';
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
        $('#1').addClass('active');
	});
	</script>
	";
	
	//select  city name from distributor
	$dct=mysqli_fetch_row(mysqli_query($conn,"select city from distributor_detail where did=1"))[0] or die(mysqli_error($conn));
	
	echo '
	<div class="container">
		<br>
		<div class="panel panel-default">
			<div class="panel-heading"><h2>'.$title.'</h2></div>
			<div class="panel-body">
	
				<form id="ac_form" method="post" onSubmit="return nc_sub();">
					<div class="form-group row">
						<label for="cid" class="col-sm-2 col-form-label">Consumer ID</label>
						<div class="col-sm-10">
							<input type=number class="form-control" id="cid" name="cid" placeholder="Consumer ID" max=9999999999 required/>
						</div>
					</div>
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">Name</label>
							<div class="col-sm-4">
							  <input type="text" class="form-control" id="fn" name="fn" placeholder="First name" maxlength=10 required>
							</div>
							<div class="col-sm-3">
							  <input type="text" class="form-control" id="mn" name="mn" placeholder="Middle name" maxlength=10 required>
							</div>
							<div class="col-sm-3">
							  <input type="text" class="form-control" id="ln" name="ln" placeholder="Last name" maxlength=10 required>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="add" class="col-sm-2 col-form-label">Address</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="2" id="add" name="add" placeholder="Address" maxlength=100 required></textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="ct" class="col-sm-2 col-form-label">City</label>
						
						<div class="col-sm-4">
						  <input type="text" class="form-control" id="ct" name="ct" value="'.$dct.'" readonly required>
						</div>
						
						<!--
						<div class="col-sm-4">
						  <select class="form-control" id="ct" name="ct" required>
							<option value="" selected>-select any city-</option>
							<option value="Surat">Surat</option>
							<option value="Ahmedabad">Ahmedabad</option>
							<option value="Vadodara">Vadodara</option>
							<option value="Bhavnagar">Bhavnagar</option>
						  </select>
						</div>
						-->
						
						<label for="pin" class="col-sm-2 col-form-label">Pin-Code</label>
						<div class="col-sm-4">
						  <input type="number" class="form-control" id="pin" name="pin" placeholder="Pin code" max=999999 required>
						</div>
					  </div>
					  
					 <div class="form-group row">
						<label for="mno" class="col-sm-2 col-form-label">Mobile no.</label>
							<div class="col-sm-10">
								<input type="text" name="mno" class="form-control" id="mno"  name="mno" placeholder="Mobile number" pattern="[1-9]{1}[0-9]{9}" title="At least Ten Digits" maxlength=10 required />  
								<small class="text-muted">(Without Country Code & Only 10 Digits.)</small>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="eid" class="col-sm-2 col-form-label">Email id</label>
							<div class="col-sm-10">
								<input type="email" name="mno" class="form-control" id="eid"  name="eid" placeholder="Email id." required />  
							</div>
					</div>
					  
					  <div class="form-group row">
						<div class="col-sm-10">
						  <button type="submit" class="btn btn-primary">Submit</button>
						</div>
					  </div>
					  
					  <p id="ac_msg"></p>
				</form>
				<script>
					$("#fn,#mn,#ln").on("keydown", function (e) {
						return e.which !== 32;
					});
				</script>
				'; 
				
				?>
				
<script>
 function nc_sub()
	{
		var cid = $("#cid").val();
	    var name = $("#fn").val()+' '+$("#mn").val()+' '+$("#ln").val();
	    var add = $("#add").val(); 
		var ct = $("#ct").val();
		var pin = $("#pin").val();
		var mno = $("#mno").val();
		var eid = $("#eid").val(); 
		
		$.ajax({
					type: "POST",
					url: "code/ac.php",
					data: "cid="+cid+"&name="+name+"&add="+add+"&ct="+ct+"&pin="+pin+"&mno="+mno+"&eid="+eid,
					success: function(html)
						{
                            $('#ac_msg').html(html);
						}
		});
	
		return false;
	}
</script>

<?php
			echo'</div>
			
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