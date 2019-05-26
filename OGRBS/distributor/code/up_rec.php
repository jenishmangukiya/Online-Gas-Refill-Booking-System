<?php
session_start();
include_once('../../includes/db_con.php');
include_once('../../apis/Way2SMS/way2sms-api.php');
include_once('../../apis/mail_cfg.php');
if(isset($_GET['cid']) and isset($_SESSION['did']))
{
	$cid = $_GET['cid'];
	
	//Fetch selected consumer details and fill it inside model-form
	$result=mysqli_query($conn,"select * from consumer_detail where cid=$cid") or die(mysqli_error($conn));
	$r=mysqli_fetch_array($result);

	$name_parts = explode(' ', $r['name']);
	
			echo '
			<form id="ac_form" method="post" onSubmit="return up_sub();">
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">Name</label>
							<div class="col-sm-4">
							  <input type="text" class="form-control" id="fn" name="fn" placeholder="First name" value="'.$name_parts[0].'" maxlength=10 required>
							</div>
							<div class="col-sm-3">
							  <input type="text" class="form-control" id="mn" name="mn" placeholder="Middle name" value="'.$name_parts[1].'" maxlength=10 required>
							</div>
							<div class="col-sm-3">
							  <input type="text" class="form-control" id="ln" name="ln" placeholder="Last name" value="'.$name_parts[2].'" maxlength=10 required>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="add" class="col-sm-2 col-form-label">Address</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="2" id="add" name="add" placeholder="Address" maxlength=100 required>'.$r['address'].'</textarea>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="ct" class="col-sm-2 col-form-label">City</label>
						
						<div class="col-sm-4">
						  <input type="text" class="form-control" id="ct" name="ct" value="'.$r['city'].'" readonly required>
						</div>
						
						<label for="pin" class="col-sm-2 col-form-label">Pin-Code</label>
						<div class="col-sm-4">
						  <input type="number" class="form-control" id="pin" name="pin" placeholder="Pin code" value='.$r['pin'].' max=999999 required>
						</div>
					  </div>
					  
					 <div class="form-group row">
						<label for="mno" class="col-sm-2 col-form-label">Mobile no.</label>
							<div class="col-sm-10">
								<input type="text" name="mno" class="form-control" id="mno" name="mno" placeholder="Mobile number" value='.$r['m_no'].' pattern="[1-9]{1}[0-9]{9}" title="At least Ten Digits" maxlength=10 required />  
								<small class="text-muted">(Without Country Code & Only 10 Digits.)</small>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="eid" class="col-sm-2 col-form-label">Email id</label>
							<div class="col-sm-10">
								<input type="email" name="eid" class="form-control" id="eid" name="eid" placeholder="Email id." value='.$r['e_id'].' required />  
							</div>
					</div>
					 
					<div class="form-group row">
						<label for="pwd" class="col-sm-2 col-form-label">Password</label>
							<div class="col-sm-10">';
							
							if($r['status']=='Not Registered')
							{
								echo '
								<input type="text" name="pwd" class="form-control" id="pwd" name="pwd" placeholder="Password" value="-" maxlength="16"  disabled required /> '; 
							}
							else
							{
								echo '
								<input type="text" name="pwd" class="form-control" id="pwd" name="pwd" placeholder="Password" value='.$r['pwd'].' maxlength="16" required /> '; 								
							}
							
							echo '
							</div>
					</div>
					
					<div class="form-group row">
						<label for="st" class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-10">';
						if($r['status']=='Active')
						{
							echo '
							  <select class="form-control" id="st" name="st" required>
								<option value="Active" selected>Active</option>
								<option value="Deactive">Deactive</option>
							  </select>
							  ';
						}
						else if($r['status']=='Deactive')
						{
							echo '
							  <select class="form-control" id="st" name="st" required>
								<option value="Active">Active</option>
								<option value="Deactive" selected>Deactive</option>
							  </select>
							  ';							
						}
						else if($r['status']=='Not Registered')
						{
							echo '
							  <input type=text class="form-control" id="st" name="st" value="Not Registered" readonly required/>
							  ';							  
						}
							  echo '
						</div>
					</div>
					<hr>
					  <div class="form-group row">
						  <button type="submit" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
					  </div>
					  
					  <p id="ac_msg" class></p>
				</form>
				
				<script>
					$("#fn,#mn,#ln").on("keydown", function (e) {
						return e.which !== 32;
					});
					//send id for create form with pre definded value in edit button

					function up_sub()
					{
						var cid='.$cid.';
						var name = $("#fn").val()+" "+$("#mn").val()+" "+$("#ln").val();
						var add = $("#add").val(); 
						var ct = $("#ct").val();
						var pin = $("#pin").val();
						var mno = $("#mno").val();
						var eid = $("#eid").val(); 
						var pwd = $("#pwd").val();
						var st = $("#st").val();
						
						$.ajax({
									type: "POST",
									url: "code/up_rec.php",
									data: "cid="+cid+"&name="+name+"&add="+add+"&ct="+ct+"&pin="+pin+"&mno="+mno+"&eid="+eid+"&pwd="+pwd+"&st="+st,
									beforeSend: function() { 
										document.getElementById("preload").style="display:inline;";
									},
									success: function(html)
									{
										document.getElementById("preload").style="display:none;";
										$("#ac_msg").html(html);
									}
						});

						return false;
					}
				</script>
				';
}
else if(isset($_POST['cid']) and isset($_SESSION['did']))
{
	$cid=$_POST['cid'];
	$name=$_POST['name'];
	$add=$_POST['add'];
	$pin=$_POST['pin'];
	$mno=$_POST['mno'];
	$eid=$_POST['eid'];
	$pwd=$_POST['pwd'];
	$st=$_POST['st'];
	
	
	$result=mysqli_query($conn,"select * from consumer_detail where m_no=$mno and cid!=$cid") or die(mysqli_error($conn));
	if(mysqli_num_rows($result)>0)
	{
		$tp = "danger";
		$bdy = "Given mobile number is already registered!";
	}
	else
	{
		$result=mysqli_query($conn,"select * from consumer_detail where e_id='$eid' and cid!=$cid") or die(mysqli_error($conn));
		if(mysqli_num_rows($result)>0)
		{
			$tp = "danger";
			$bdy = "Given email-id is already registered!";
		}
		else
		{	
			//update 
			if($st=='Not Registered')
			{
				$result=mysqli_query($conn,"update consumer_detail set name='$name',address='$add',pin='$pin',m_no='$mno',e_id='$eid',status='$st' where cid=$cid") or die(mysqli_error($conn));
			}
			else if($st=='Active' or $st=='Deactive')
			{
				//check before and changed status
				$result=mysqli_query($conn,"select status from consumer_detail where cid=$cid") or die(mysqli_error($conn));
				$r=mysqli_fetch_row($result);
				if($st!==$r[0])
				{
					if($st==="Active")
						$msg_format="Your account has been activated, Now you can make use of it.";
					elseif($st==="Deactive")
						$msg_format="Your account has been deactivated by your distributor.";
					//sms
					sendWay2SMS("9904436106","MJENISH8",$mno,$msg_format);
					//email
					$mail->addAddress("$eid");
					$mail->Subject = 'Account state changed.';
					$mail->isHTML(true);
					$mailContent = "<h2>".$msg_format."</h2>";
					$mail->Body = $mailContent;
					$mail->send();
				}
				
				$result=mysqli_query($conn,"update consumer_detail set pwd='$pwd',name='$name',address='$add',pin='$pin',m_no='$mno',e_id='$eid',status='$st' where cid=$cid") or die(mysqli_error($conn));			
			}
			$tp = "success";
			$bdy = "Update successful.";			
		}
	}
	
	echo '<div class="alert alert-'.$tp.'" role="alert" style="margin-bottom:0">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				'.$bdy.'
			</div>
			<script>
				window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
				});
				}, 4000);
			</script>';
		if($bdy == "Update successful.")
		{
			echo "<script>
				alert('Data updated.');
				setTimeout('myFun()', 4000)
				function myFun()
				{
					window.location.reload();
				}
				</script>";
		}	
}
else
{
	header('Location:../index.php');
}
?>