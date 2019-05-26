<?php
session_start();
include_once('../../includes/db_con.php');
include_once('../../apis/Way2SMS/way2sms-api.php');
include_once('../../apis/mail_cfg.php');
if(isset($_GET['did']) and isset($_SESSION['aid']))
{
	$did = $_GET['did'];
	$_SESSION['did_e']=$did; // for super global use
	//fetch current distributor details
	$result=mysqli_query($conn,"select * from distributor_detail where did=$did") or die(mysqli_error($conn));
	$r=mysqli_fetch_array($result);
	
			echo '<form method="post" id="dis_edit_form" method="post">
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">Name</label>
							<div class="col-sm-10">
							  <input type="text" class="form-control" id="nm" name="nm" placeholder="First name" value="'.$r['name'].'" maxlength=20 required>
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
							<select id="ct" name="ct" class="form-control" required>
								<option value="Ahmedabad">Ahmedabad</option>
								<option value="Surat">Surat</option>
								<option value="Vadodara">Vadodara</option>
								<option value="Bhavnagar">Bhavnagar</option>
							</select>
							<script>
							//change city value based on table data
							$(document).ready(function(){
								if("'.$r['city'].'"==="Ahmedabad")
									document.getElementById("ct").selectedIndex = 0;
								else if("'.$r['city'].'"==="Surat")
									document.getElementById("ct").selectedIndex = 1;
								else if("'.$r['city'].'"==="Vadodara")
									document.getElementById("ct").selectedIndex = 2;
								else if("'.$r['city'].'"==="Bhavnagar")
									document.getElementById("ct").selectedIndex = 3;
							});
							</script>
						</div>
						
						<label for="pin" class="col-sm-2 col-form-label">Pin-Code</label>
						<div class="col-sm-4">
						  <input type="number" class="form-control" id="pin" name="pin" placeholder="Pin code" value='.$r['pin'].' max=999999 required>
						</div>
					  </div>
					  
					 <div class="form-group row">
						<label for="mno" class="col-sm-2 col-form-label">Mobile no.</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="mno" name="mno" placeholder="Mobile number" value='.$r['m_no'].' pattern="[1-9]{1}[0-9]{9}" title="At least Ten Digits" maxlength=10 required />  
								<small class="text-muted">(Without Country Code & Only 10 Digits.)</small>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="eid" class="col-sm-2 col-form-label">Email id</label>
							<div class="col-sm-10">
								<input type="email" class="form-control" id="eid" name="eid" placeholder="Email id." value='.$r['e_id'].' required />  
							</div>
					</div>
					 
					<div class="form-group row">
						<label for="pwd" class="col-sm-2 col-form-label">Password</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="pwd" name="pwd" placeholder="Password" value='.$r['pwd'].' maxlength="16" required /> 
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
							  echo '
						</div>
					</div>
					
					<div class="form-group row">
						<label for="id" class="col-sm-2 col-form-label">Id Proof</label>
						<div class="col-sm-6">
							<a href=../'.$r['proof'].' target="_blank"><img src=../'.$r['proof'].' class="img-thumbnail" id="id_img" data-toggle="modal" data-target="#myModal"></a>
						</div>
						<div class="col-sm-4">
							<label class="btn btn-primary btn-block">
								<span class="glyphicon glyphicon-edit"></span> Edit<input type="file" id="e_img_btn" name="proof_img" style="display:none;" accept="image/jpg,image/png,image/jpeg">
							</label>
							<br>
							<small class="text-dark">
								<span class="glyphicon glyphicon-chevron-right"></span> Only JPG, JPEG & PNG files are allowed.
								<br>
								<span class="glyphicon glyphicon-chevron-right"></span> File must be less than 2 megabytes.
							</small>
						</div>
						<script>
							//real time chage image
							    function readURL(input) {
									if (input.files && input.files[0]) {
										var reader = new FileReader();
										reader.onload = function (e) {
											$("#id_img").attr("src", e.target.result);
										}
										
										reader.readAsDataURL(input.files[0]);
									}
								}
								$("#e_img_btn").change(function(){
									readURL(this);
								});
						</script>
					</div>	
					
					<hr>
					  <div class="form-group row">
						  <button type="submit" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
					  </div>
					  
					  <p id="ac_msg" class></p>
				</form>
				
				<script>
					$(document).ready(function (e) {
						$("#dis_edit_form").on("submit",(function(e) {
							e.preventDefault();
							$.ajax({
								url: "code/up_dis.php",
								type: "POST",
								data:  new FormData(this),
								contentType: false,
								cache: false,
								processData:false,
								beforeSend: function() { 
										document.getElementById("preload").style="display:inline;";
								},
								success: function(html)
								{
									document.getElementById("preload").style="display:none;";
									$("#ac_msg").html(html);
								} 	        
						   });
						}));
					});
				</script>
				';
}
else if(isset($_POST['nm']) and isset($_SESSION['aid']))
{
	$did=$_SESSION['did_e'];//access from session
	$name=$_POST['nm'];
	$add=$_POST['add'];
	$ct=$_POST['ct'];
	$pin=$_POST['pin'];
	$mno=$_POST['mno'];
	$eid=$_POST['eid'];
	$pwd=$_POST['pwd'];
	$st=$_POST['st'];
	
	$result=mysqli_query($conn,"select * from distributor_detail where m_no=$mno and did!=$did") or die(mysqli_error($conn));
	if (mysqli_num_rows($result) > 0)
	{
		$tp = "danger";
		$bdy = "Given mobile number is already registered!";
	}
	else
	{
		$result=mysqli_query($conn,"select * from distributor_detail where e_id='$eid' and did!=$did") or die(mysqli_error($conn));
		if(mysqli_num_rows($result)>0)
		{
			$tp = "danger";
			$bdy = "Given email-id is already registered!";
		}
		else
		{
				//check before and changed status
				$result=mysqli_query($conn,"select status from distributor_detail where did=$did") or die(mysqli_error($conn));
				$r=mysqli_fetch_row($result);
				if($st!==$r[0])
				{
					if($st==="Active")
						$msg_format="Your account has been activated, Now you can make use of it.";
					elseif($st==="Deactive")
						$msg_format="Your account has been deactivated by your admin.";
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

			//check if image is changed or not
			if($_FILES["proof_img"]["size"]>0)
			{
				if($_FILES["proof_img"]["type"]!="image/jpeg" &&
					$_FILES["proof_img"]["type"]!="image/jpg" &&
					$_FILES["proof_img"]["type"]!="image/png")
				{
					echo "<script>alert('Sorry, only JPG, JPEG & PNG files are allowed.')</script>";
				}
				else if(($_FILES["proof_img"]["size"] > 2097152) || ($_FILES["proof_img"]["size"] == 0))
				{
					echo "<script>alert('File too large. File must be less than 2 megabytes.')</script>";
				}
				else
				{
					//move exising id proof to old_proof folder
					$result=mysqli_query($conn,"select * from distributor_detail where did='$did'") or die(mysqli_error($conn));
					$r=mysqli_fetch_array($result);
					if(file_exists('../../'.$r['proof']))
					{
						$fl=$r['proof'];
						$f=explode('/',$fl);
						rename('../../'.$r['proof'],'../../distributor/proof/old_proof/'.end($f));
					}
					
					//move id proof to desired location
					$info = pathinfo($_FILES['proof_img']['name']);
					$ext = ".".$info['extension'];
					$target_file="distributor/proof/".$did.$ext;
					move_uploaded_file($_FILES["proof_img"]["tmp_name"], '../../'.$target_file);

					//update distributor record
					$q="update distributor_detail set `pwd`='$pwd',`name`='$name',`address`='$add',`city`='$ct',
					`pin`='$pin',`m_no`='$mno',`e_id`='$eid',`status`='$st',`proof`='$target_file' where did=$did";
					mysqli_query($conn,$q) or die(mysqli_error($conn));
					$tp = "success";
					$bdy = "Update successful.";
					
					
				}
			}
			else
			{
				//update record
				$q="update distributor_detail set `pwd`='$pwd',`name`='$name',`address`='$add',`city`='$ct',
					`pin`='$pin',`m_no`='$mno',`e_id`='$eid',`status`='$st' where did=$did";
					mysqli_query($conn,$q) or die(mysqli_error($conn));
					$tp = "success";
					$bdy = "Update successful.";					
			}
		}
	}
	
	//if image error occurs then
	if(isset($tp))
	{
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
}
else
{
	header('Location:../index.php');
}
?>