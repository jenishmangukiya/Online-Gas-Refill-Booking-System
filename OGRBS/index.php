<?php
session_start();
if(isset($_SESSION['cid']))
	header("Location:consumer/");
else if(isset($_SESSION['did']))
	header("Location:distributor/");
else if(isset($_SESSION['aid']))
	header("Location:admin/");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gas Booking Portal</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
	<link rel="icon" href="fev.png" type="image/png" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<style>
		input[type=number]::-webkit-inner-spin-button, 
		input[type=number]::-webkit-outer-spin-button { 
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			margin: 0; 
		}
		input[type=number]{
			-moz-appearance:textfield;
		}
		
		#box .row{
			margin-top:20px;
		}
		textarea {
			resize: none;
		}
	</style>
</head>

<body>
    <nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header"><a href="index.php" class="navbar-brand navbar-link"><i class="glyphicon glyphicon-fire text-info"></i>Gas Booking Portal</a>
            <button data-toggle="collapse" data-target="#navcol-1" class="navbar-toggle collapsed"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav navbar-right">
                <li role="presentation" class="active"><a href="index.php"><i class="fa fa-home"></i> Home </a></li>
                <li role="presentation"><a href="#" data-toggle="modal" data-target="#signModal"><i class="glyphicon glyphicon-pencil"></i> Sign Up</a></li>
				<li role="presentation"><a href="#" data-toggle="modal" data-target="#loginModal"><i class="glyphicon glyphicon-user"></i> Log-In</a></li>
            </ul>
        </div>
    </div>
</nav>
    <div class="jumbotron hero">
        <div class="modal fade" role="dialog" tabindex="-1" id="signModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Sign Up</h4></div>
            <div class="modal-body">
                <!--<p>The content of your modal.</p>-->
            
			<ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#con">New Consumer</a></li>
    <li><a data-toggle="pill" href="#dis">New Distributor</a></li>
  </ul>
  
  <div class="tab-content">
    <div id="con" class="tab-pane fade in active">
	
		<br>
      <p class='text-success'>Only valid Consumers to register on the site. Please ensure you give a correct mobile no. that mapped with your Customer ID. All future notifications will be sent to this mobile no. only.</p>
	  
	  
	  <form class="bootstrap-form-with-validation" onSubmit="return sub();" method="post">
        <!--<h2 class="text-center">Bootstrap form basic</h2>-->
        <div class="form-group">
            <label class="control-label" for="text-input">Consumer ID</label>
            <input class="form-control" type="number" name="conid" id="conid" min=1 max=9999999999 required />
        </div>
		<div class="form-group">
            <label class="control-label" for="text-input" >Mobile<small> (Without Country Code & Only 10 Digits.)</small></label>
            <input class="form-control" type="text" name="cmno" id="cmno" pattern="[1-9]{1}[0-9]{9}" title="At least Ten Digits" maxlength=10 required />         
		</div>
		
        <div class="form-group">
            <label class="control-label" for="password-input" >Password Input</label><small> (Must contain at least 6 or more characters)</small>
            <input class="form-control" type="password" name="pass" id="password" pattern=".{6,}" title="Six or more characters" required maxlength=16/>
        </div>
         <div class="form-group">
            <label class="control-label" for="password-input" >Confirm Password</label>
            <input class="form-control" type="password" name="cpass" id="cpass" required maxlength=16/>
			
			<script>
			var password = document.getElementById("password")
  , confirm_password = document.getElementById("cpass");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
			
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit" name="ncon_sub">Submit</button>
			<br>
			<p id='msg' class="text-danger"></p>
        </div>
    </form>
	
	
<script>
 function sub()
	{
		
	    var name = $("#conid").val(); 
	    var mno = $("#cmno").val(); 
	    var pass = $("#cpass").val(); 

		$.ajax({
					type: "POST",
					url: "ncon.php",
					data: "conid="+name+"&cmno="+mno+"&cpass="+pass,
					success: function(html)
						{
                            $('#msg').html(html);
							
							var chk=document.getElementById('msg').innerHTML;
							if(chk==='True')
							{
								alert('You have been successfully registered.');
								//location.href= "index.php";
								window.location.reload()
							}
						}
		});
		
		
	
		return false;
	}
</script>

    </div>
	
	
    <div id="dis" class="tab-pane fade">
	  <br>
      <p class='text-success'>After this process we will verify you.</p>
	  
	  
	  <form class="bootstrap-form-with-validation" method="post" id="new_con_form">
	  
        <div class="form-group">
            <label class="control-label" for="text-input">Distributor Name</label>
            <input class="form-control" type="text" name="dname" id="dname" maxlength=20 required />
        </div>
        <div class="form-group">
            <label class="control-label" for="textarea-input">Address </label>
            <textarea class="form-control" name="dadd" id="dadd" maxlength=100 required></textarea>
        </div>
		<div class="form-group">
			<label for="inputState">City</label>
			<select id="dcity" name="dcity" class="form-control" required>
				<option value='Ahmedabad'>Ahmedabad</option>
				<option value='Surat'>Surat</option>
				<option value='Vadodara'>Vadodara</option>
				<option value='Bhavnagar'>Bhavnagar</option>
			</select>
		</div>
		<div class="form-group">
			<label for="inputZip">Pin-Code</label>
			<input type="text" class="form-control" id="dpin" name="dpin" pattern=".{6,}" title="Six Digits" maxlength=6 required>
		</div>
		<div class="form-group">
            <label class="control-label" for="email-input">Email</label>
            <input class="form-control" type="email" name="demail" id="demail" maxlength=30 required />
        </div>
		<div class="form-group">
            <label class="control-label" for="text-input" >Mobile<small> (Without Country Code & Only 10 Digits.)</small></label>
            <input class="form-control" type="text" name="dmno" id="dmno" pattern="[1-9]{1}[0-9]{9}" title="At least Ten Digits" maxlength=10 required/>         
		</div>
		<div class="form-group">
			<label class="control-label" for="text-input" >Identification Proof<small> (Only PAN card accepted & It must be image and size sould be &lt;2MB)</small></label>
			<input class="form-control" type="file" name="id_img" required />
		</div>
        <div class="form-group">
            <label class="control-label" for="password-input" >Password Input</label><small> (Must contain at least 6 or more characters)</small>
            <input class="form-control" type="password" name="dpass" id="dpass" maxlength=16 pattern=".{6,}" title="Six or more characters" required/>
        </div>
         <div class="form-group">
            <label class="control-label" for="password-input" >Confirm Password</label>
            <input class="form-control" type="password" name="dcpass" id="dcpass" maxlength=16 required />
			
			<script>
			var password = document.getElementById("dpass")
  , confirm_password = document.getElementById("dcpass");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
			
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit" name="ncon_sub">Submit</button>
			<br>
			<p id='dmsg' class="text-danger"></p>
        </div>
    </form>
	
	
<script>	
$(document).ready(function (e) {
	$("#new_con_form").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "ndis.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(html)
		    {
				$("#dmsg").html(html);
				var chk=document.getElementById('dmsgg').innerHTML;
				if(chk==='True')
				{
					alert('Your response has been registered, After verification we will notify you.');
					window.location.reload()
				}
		    } 	        
	   });
	}));
});
</script>
	  
	  
	  
    </div>

  </div>

  
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                <!--<button class="btn btn-primary" type="button">Save</button>-->
            </div>
        </div>
    </div>
</div>












        <div class="modal fade" role="dialog" tabindex="-1" id="loginModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Log-In</h4></div>
            <div class="modal-body">
                <p><b>Select your role</b></p>
            
			<ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#conLogin">Consumer</a></li>
    <li><a data-toggle="pill" href="#disLogin">Distributor</a></li>
	<li><a data-toggle="pill" href="#adminLogin">Admin</a></li>
  </ul>
  
  <div class="tab-content">
    <div id="conLogin" class="tab-pane fade in active">
	  
	  
	  <form class="bootstrap-form-with-validation" onSubmit="return cl_sub();" method="post">
	  <br>
        <div class="form-group">
            <label class="control-label" for="text-input">Consumer ID</label>
            <input class="form-control" type="number" name="Lconid" id="Lconid" min=1 max=9999999999 required />
        </div>

        <div class="form-group">
            <label class="control-label" for="password-input" >Password Input</label><small> (Must contain at least 6 or more characters)</small>
            <input class="form-control" type="password" name="Lcpass" id="Lcpass" pattern=".{6,}" title="Six or more characters" required maxlength=16/>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit" name="c_login">Log-In</button>
			<a href="fg_pwd.php?con" target="_parent" class="btn btn-primary" onclick="window.open('fg_pwd.php?con','newwindow','width=400,height=350');return false;"> Forgot Password?</a>
			<br><br>
			<p class="text-danger" id='clmsg'></p>
        </div>
    </form>
	
	
		<script>
		 function cl_sub()
			{
				
				var conid = $("#Lconid").val(); 
				var cpass = $("#Lcpass").val(); 

				$.ajax({
							type: "POST",
							url: "c_log.php",
							data: "conid="+conid+"&cpass="+cpass,
							success: function(html)
								{
									$('#clmsg').html(html);
									
									var chk=document.getElementById('clmsg').innerHTML;
									
									if(chk==='True')
									{
										alert('You have been successfully logged in.');
										location.href= "consumer/";
										//window.location.reload()
									}
								}
				});
			
				return false;
			}
		</script>

    </div>
	
	    <div id="disLogin" class="tab-pane fade in">
	  
	  
	  <form class="bootstrap-form-with-validation" onSubmit="return dl_sub();" method="post">
	  <br>
        <div class="form-group">
            <label class="control-label" for="text-input">Distributor ID</label>
            <input class="form-control" type="number" name="Ldisid" id="Ldisid" min=1 max=99999 required />
        </div>

        <div class="form-group">
            <label class="control-label" for="password-input" >Password</label><small> (Must contain at least 6 or more characters)</small>
            <input class="form-control" type="password" name="Ldpass" id="Ldpass" pattern=".{6,}" title="Six or more characters" required maxlength=16/>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit" name="d_login">Log-In</button>
			<a href="fg_pwd.php?dis" target="_parent" class="btn btn-primary" onclick="window.open('fg_pwd.php?dis','newwindow','width=400,height=350');return false;"> Forgot Password?</a>
			<br><br>
			<p class="text-danger" id='dlmsg'></p>
        </div>
    </form>
	
	
		<script>
		 function dl_sub()
			{
				
				var disid = $("#Ldisid").val(); 
				var dispass = $("#Ldpass").val(); 

				$.ajax({
							type: "POST",
							url: "d_log.php",
							data: "disid="+disid+"&dispass="+dispass,
							success: function(html)
								{
									$('#dlmsg').html(html);
									
									var chk=document.getElementById('dlmsg').innerHTML;
									if(chk==='True')
									{
										alert('You have been successfully logged in.');
										location.href= "distributor/";
										//window.location.reload()
									}
								}
				});
			
				return false;
			}
		</script>

    </div>
	
	    <div id="adminLogin" class="tab-pane fade in">
	  
	  
	  <form class="bootstrap-form-with-validation" onSubmit="return al_sub();" method="post">
	  <br>
        <div class="form-group">
            <label class="control-label" for="text-input">Admin ID</label>
            <input class="form-control" type="text" name="Ladid" id="Ladid" min=1 max=9999999999 required />
        </div>

        <div class="form-group">
            <label class="control-label" for="password-input" >Password Input</label><small> (Must contain at least 6 or more characters)</small>
            <input class="form-control" type="password" name="Ladpass" id="Ladpass" pattern=".{6,}" title="Six or more characters" required maxlength=16/>
        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit" name="ad_login">Log-In</button>
			<br><br>
			<p class="text-danger" id='almsg'></p>
        </div>
    </form>
	
	
		<script>
		 function al_sub()
			{
				
				var aid = $("#Ladid").val(); 
				var apass = $("#Ladpass").val(); 

				$.ajax({
							type: "POST",
							url: "admin_log.php",
							data: "aid="+aid+"&apass="+apass,
							success: function(html)
								{
									$('#almsg').html(html);
									
									var chk=document.getElementById('almsg').innerHTML;
									if(chk==='True')
									{
										alert('You have been successfully logged in.');
										location.href= "admin/";
										//window.location.reload()
									}
								}
				});
			
				return false;
			}
		</script>

    </div>

  </div>

  
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                <!--<button class="btn btn-primary" type="button">Save</button>-->
            </div>
        </div>
    </div>
</div>
























<!--
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-push-7 phone-preview">
                    <div class="iphone-mockup"><img src="assets/img/iphone.svg" class="device">
                        <div class="screen"></div>
                    </div>
                </div>
                <div class="col-md-6 col-md-pull-3 get-it">
                    <h1>Our Fantastic App</h1>
                    <p>Nullam id dolor id nibh ultricies vehicula ut id elit. Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>
                    <p><a class="btn btn-primary btn-lg" role="button" href="#"><i class="fa fa-apple"></i> Available on the App Store</a><a class="btn btn-success btn-lg" role="button" href="#"><i class="fa fa-google"></i> Available on Google Play</a></p>
                </div>
            </div>
        </div> -->
        <div class="carousel slide" data-ride="carousel" id="carousel-1">
            <div class="carousel-inner" role="listbox">
                <div class="item active"><img style=" margin: 0 auto;" src="assets/img/1.jpg" alt="First Image"></div>
				<div class="item"><img style=" margin: 0 auto;" src="assets/img/2.jpg" alt="Second Image"></div>
				<div class="item"><img style=" margin: 0 auto;" src="assets/img/3.jpg" alt="Third Image"></div>
				<div class="item"><img style=" margin: 0 auto;" src="assets/img/4.jpg" width="1000px" height="400px" alt="Fourth Image"></div>
            </div>
            <div><a class="left carousel-control" href="#carousel-1" role="button" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i><span class="sr-only">Previous</span></a><a class="right carousel-control" href="#carousel-1" role="button"
                data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i><span class="sr-only">Next</span></a></div>
				<!--
            <ol class="carousel-indicators">
                <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-1" data-slide-to="1"></li>
                <li data-target="#carousel-1" data-slide-to="3"></li>
				<li data-target="#carousel-1" data-slide-to="4"></li>
            </ol>
			-->
        </div>
    </div>
    <section class="testimonials">
        <h2 class="text-center">Safety Tips For LPG Home - Do’s & Don’ts</h2>
		<div class="container ">
				<div class="row" id='box'>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12" style="text-align:center">
								<u><h3><span class="glyphicon glyphicon-ok text-success"></span> DO'S</h3></u>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<img class="bg-success" style="padding:10px; width:60px;height:60px" src="assets/img/tips/a1.png" />
							</div>
							<div class="col-md-9">
								<h4>Use LPG in Ventilated Area</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<img class="bg-success" style="padding:10px; width:60px;height:60px" src="assets/img/tips/a2.png" />
							</div>
							<div class="col-md-9">
								<h4>Before connecting, check for LPG leakage</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<img class="bg-success" style="padding:10px; width:60px;height:60px" src="assets/img/tips/a3.png" />
							</div>
							<div class="col-md-9">
								<h4>Close the regulator knob once you finish cooking</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<img class="bg-success" style="padding:10px; width:60px;height:60px" src="assets/img/tips/a4.png" />
							</div>
							<div class="col-md-9">
								<h4>Always keep the cylinder vertical, upright during usage and storage</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<img class="bg-success" style="padding:10px; width:60px;height:60px" src="assets/img/tips/a5.png" />
							</div>
							<div class="col-md-9">
								<h4>Always install LPG pipeline above ground level</h3>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12" style="text-align:center">
								<u><h3><span class="glyphicon glyphicon-remove text-danger"></span> DON'T</h3></u>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<img class="bg-danger" style="padding:10px; width:60px;height:60px" src="assets/img/tips/b1.png" />
							</div>
							<div class="col-md-9">
								<h4>Don’t place cylinders in closed areas.</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<img class="bg-danger" style="padding:10px; width:60px;height:60px" src="assets/img/tips/b2.png" />
							</div>
							<div class="col-md-9">
								<h4>Do not use any flammable objects near or over the burner</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<img class="bg-danger" style="padding:10px; width:60px;height:60px" src="assets/img/tips/b3.png" />
							</div>
							<div class="col-md-9">
								<h4>Do not switch on or off any lights or electrical equipment, smoke or use naked flames incase of leakage</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<img class="bg-danger" style="padding:10px; width:60px;height:60px" src="assets/img/tips/b4.png" />
							</div>
							<div class="col-md-9">
								<h4>Do not roll the cylinder</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<img class="bg-danger" style="padding:10px; width:60px;height:60px" src="assets/img/tips/b5.png" />
							</div>
							<div class="col-md-9">
								<h4>Never store LPG in basement, cellar, elevated platforms</h3>
							</div>
						</div>
					</div>
				</div>
		</div>
		<!--
        <blockquote>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
            <footer>Famous tech website</footer>
        </blockquote>
		-->
    </section>
    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>Get in touch</h2>
					<form action="mailto:kd.lukhi99@gmail.com" method="post" enctype="text/plain">
						<div class="form-group">
							<input id="name" type="text" class="form-control" name="name" placeholder="Name" required>
						</div>
						<div class="form-group">
							<input id="email" type="email" class="form-control" name="email" placeholder="Email" required>
						</div>
						<div class="form-group">
							<input id="mno" type="number" class="form-control" name="mno" placeholder="Mobile No."  max=9999999999 required>
						</div>
						<div class="form-group">
						  <textarea id="msg" name="msg" class="form-control" rows="5" id="comment" placeholder="Message" required></textarea>
						</div>
						<button type="submit" class="btn btn-default btn-block bg-success"><span class="glyphicon glyphicon-send"></span> Submit</button>
					</form>
                </div>
                <div class="col-md-6">
					<br>
					<div id="map" style="width:100%;height:400px;border-radius:5px"></div>
					<script>
						function myMap() {
						  var myCenter = new google.maps.LatLng(22.6064729,72.8165446);
						  var mapCanvas = document.getElementById("map");
						  var mapOptions = {center: myCenter, zoom: 13};
						  var map = new google.maps.Map(mapCanvas, mapOptions);
						  var marker = new google.maps.Marker({position:myCenter});
						  marker.setMap(map);
						}
					</script>
					<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDekdn4w7om4HjEgGDb75-pJV_S3gOJBPU&callback=myMap"></script>
                </div>
            </div>
        </div>
    </section>
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Copyright © 2018</h5></div>
			</div>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>