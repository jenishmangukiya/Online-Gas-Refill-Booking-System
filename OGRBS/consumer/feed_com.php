<?php
session_start();
include_once('../includes/db_con.php');

if(isset($_SESSION['cid']))
{
	
	$title='Feedback & Complaint';
	$cid=$_SESSION['cid'];
	
	$result=mysqli_query($conn,"select name from consumer_detail where cid=$cid") or die(mysqli_error($conn));
	$r=mysqli_fetch_row($result);
	
	$con_name=' '.$r[0];
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

	echo '
	<div class="container">
		<br>
		<div class="panel panel-default">
			<div class="panel-heading"><h2>'.$title.'</h2></div>
			<div class="panel-body">
				
				<form method="post" onSubmit="alert('."'Thank You.'".')">
					<div class="form-group row">
						<label for="type" class="col-sm-2 col-form-label">Type</label>
							<div class="col-sm-10">
								<label class="radio-inline"><input type="radio" name="type" value="Feedback" checked required>Feedback</label>
								<label class="radio-inline"><input type="radio" name="type" value="Complaint">Complaint</label>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="sub" class="col-sm-2 col-form-label">Subject</label>
						<div class="col-sm-10">
							<select class="form-control" id="f_sub" name="f_sub" onchange="other_show(this.value)">
								<option value="Product related">Product related</option>
								<option value="Website related">Website related</option>
								<option value="Other">-Other-</option>
							</select>
							<select class="form-control" id="c_sub" name="c_sub" onchange="other_show(this.value)">
								<option value="Product related">Product related</option>
								<option value="Delivery related">Delivery related</option>
								<option value="Other">-Other-</option>
							</select>
							<br>
							<input class="form-control" type=text maxlength=30 id="o_s" name="o_s" placeholder="Subject title..."/>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="msg" class="col-sm-2 col-form-label">Message</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="3" id="msg" name="msg" placeholder="Your message..." maxlength=300 required></textarea>
						</div>
					</div>
					  
					<div class="form-group row">
						<div class="col-sm-12">
						 <button type="submit" class="btn btn-primary btn-block" name="submit">Submit your response</button>
						</div>
					</div>
					  
					<p id="ac_msg"></p>
				</form>
				
				<script>
					$(document).ready(function(){
						$("#c_sub").hide();	//default hide complaint subject dropdown
						$("#o_s").hide(); //default hide other subject textbox
						$("input[name$=';echo 'type'; echo ']").click(function(){
						 var radio = $(this).val();
							if(radio=="Feedback")
							{
								$("#f_sub").show();
								$("#c_sub").hide();	
							}
							else if(radio=="Complaint")
							{
								$("#c_sub").show();
								$("#f_sub").hide();	
							}
						 });
					 });
					 function other_show(val)
					 {
						$(document).ready(function(){
							if(val=="Other")
							{
								$("#o_s").show();
								$("#o_s").required=true;
							}
							else
							{
								$("#o_s").hide();
								$("#o_s").required=false;
							}
						});						 
					 }
				</script>
			</div>
			
		</div>
	</div>
	';
	include_once('design/footer.php');
	
	if((isset($_SESSION['cid'])) && isset($_POST['submit']))
	{
		$type=$_POST['type'];
		$msg=addslashes($_POST['msg']);
		
		//for feedback
		if($type=='Feedback')
		{
			$f_sub=$_POST['f_sub'];
			//check subject is other
			if($f_sub=='Other')
			{
				$o_s=$_POST['o_s'];
				mysqli_query($conn,"insert into feedback_complain values($cid,(select did from consumer_detail where cid=$cid),CURRENT_DATE,CURRENT_TIME,'$type','$o_s','$msg')") or die(mysqli_error($conn));
			}
			else
			{
				mysqli_query($conn,"insert into feedback_complain values($cid,(select did from consumer_detail where cid=$cid),CURRENT_DATE,CURRENT_TIME,'$type','$f_sub','$msg')") or die(mysqli_error($conn));
			}
		}
		//for complaint
		else if($type==='Complaint')
		{
			$c_sub=$_POST['c_sub'];
			//check subject is other
			if($c_sub=='Other')
			{
				$o_s=$_POST['o_s'];	
				mysqli_query($conn,"insert into feedback_complain values($cid,(select did from consumer_detail where cid=$cid),CURRENT_DATE,CURRENT_TIME,'$type','$o_s','$msg')") or die(mysqli_error($conn));
			}
			else
			{	
				mysqli_query($conn,"insert into feedback_complain values($cid,(select did from consumer_detail where cid=$cid),CURRENT_DATE,CURRENT_TIME,'$type','$c_sub','$msg')") or die(mysqli_error($conn));				
			}
			
		}
	}
}
else
{
	header('Location:../index.php');
}
?>