<?php
session_start();
include_once('../includes/db_con.php');

if(isset($_SESSION['cid']))
{
	
	$title='Profile';
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
        $('').addClass('active');
	});
	</script>
	";
	
	//fetch current consumer detail
	$result = mysqli_query($conn,"select * from consumer_detail where cid=$cid") or die(mysqli_error($conn));
	$r = mysqli_fetch_array($result);
	
	echo '
	<div class="container">
		<br>
		<div class="panel panel-default">
			<div class="panel-heading"><h2>'.$title.'</h2></div>
			<div class="panel-body">
	
				<form>
					<div class="form-group row">
						<label for="cid" class="col-sm-2 col-form-label">Counsumer ID :</label>
							<div class="col-sm-10">
								<p class="form-control-static">'.$r['cid'].'</p>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">Name :</label>
							<div class="col-sm-10">
								<p class="form-control-static">'.$r['name'].'</p>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="address" class="col-sm-2 col-form-label">Address :</label>
							<div class="col-sm-10">
								<p class="form-control-static">'.$r['address'].'</p>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="city" class="col-sm-2 col-form-label">City :</label>
							<div class="col-sm-10">
								<p class="form-control-static">'.$r['city'].'</p>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="pincode" class="col-sm-2 col-form-label">Pincode :</label>
							<div class="col-sm-10">
								<p class="form-control-static">'.$r['pin'].'</p>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="mno" class="col-sm-2 col-form-label">Mobile no. :</label>
							<div class="col-sm-2">
								<p class="form-control-static" id="s_mno">'.$r['m_no'].'</p>
							</div>
							<div class="col-sm-8">
									<button class="btn btn-primary btn-xs" id="mno_edit" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="return up(this.id);">
										<span class="glyphicon glyphicon-pencil"></span>
									</button>
							</div>
					</div>					
					
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">Email :</label>
							<div class="col-sm-2">
								<p class="form-control-static" id="s_email">'.$r['e_id'].'</p>
							</div>
							<div class="col-sm-8">
									<button class="btn btn-primary btn-xs" id="email_edit" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="return up(this.id);">
										<span class="glyphicon glyphicon-pencil"></span>
									</button>
							</div>
					</div>	
					
					<div class="form-group row">
						<label for="pwd" class="col-sm-2 col-form-label">Password :</label>
							<div class="col-sm-2">
								<p class="form-control-static" id="h_pwd">******</p>
								<p class="form-control-static" id="s_pwd" style="display:none">'.$r['pwd'].'</p>
							</div>
							<div class="col-sm-8">
									<button class="btn btn-alert btn-xs" onclick="return p_hs()">
										<span class="glyphicon glyphicon-eye-open" id="peye"></span>
									</button>
									<script>
										function p_hs()
										{
											if($("#h_pwd").css("display")!=="none")
											{
												$("#h_pwd").css("display", "none");
												$("#s_pwd").css("display", "block");
												$("#peye").removeClass("glyphicon glyphicon-eye-open");
												$("#peye").addClass("glyphicon glyphicon-eye-close");
											}
											else if($("#s_pwd").css("display")!=="none")
											{
												$("#s_pwd").css("display", "none");
												$("#h_pwd").css("display", "block");
												$("#peye").removeClass("glyphicon glyphicon-eye-close");
												$("#peye").addClass("glyphicon glyphicon-eye-open");
											}											
											return false;
										}
									</script>
									<button class="btn btn-primary btn-xs" id="pwd_edit" data-title="Edit" data-toggle="modal" data-target="#edit" onclick="return up(this.id);">
										<span class="glyphicon glyphicon-pencil"></span>
									</button>
							</div>
					</div>
					
					<div class="form-group row">
						<label for="reg_date" class="col-sm-2 col-form-label">Registration Date :</label>
							<div class="col-sm-10">
								<p class="form-control-static">'.$r['reg_date'].'</p>
							</div>
					</div>
					
					<!--
					
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
						
					-->
				</form>
				
			</div>
		</div>
	</div>
	
  <!-- Edit model-->
  <div class="modal fade" id="edit" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="em_h_title"></h4>
        </div>
        <div class="modal-body" id="e_form">
			<!-- This area filled by ajax -->
        </div>
		<!--
        <div class="modal-footer">
			<!--
			<butoon type="submit" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-ok"></span> Update</button>
			
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			-->
        </div>
		-->
      </div>
      
    </div>
  </div>
	';

	echo '
		<script>
			$(document).ready(function(){
				$("#mno_edit").click(function(){
					$("#em_h_title").html("Edit Mobile no.");
				});
				$("#email_edit").click(function(){
					$("#em_h_title").html("Edit Email");
				});
				$("#pwd_edit").click(function(){
					$("#em_h_title").html("Edit Password");
				});	
			});
		</script>
		<script>
		function up(id)
		{
			if(id==="mno_edit")
			{
				var val=$("#s_mno").html();
			}
			else if(id=="email_edit")
			{
				var val=$("#s_email").html();
			}
			else if(id=="pwd_edit")
			{
				var val=$("#s_pwd").html();
			}
			$.ajax({
					type: "POST",
					url: "code/up_pro.php",
					data: "edit_type="+id+"&val="+val,
					success: function(html)
					{
						$("#e_form").html(html);
					}
			});	
			return false;
		}
		</script>
	';
	include_once('design/footer.php');
}
else
{
	header('Location:../index.php');
}
?>