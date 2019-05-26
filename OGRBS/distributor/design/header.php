<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
	
    <link rel="stylesheet" href="<?php echo $path;?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $path;?>assets/css/user.css">
	<link rel="icon" href="../fev.png" type="image/png" />
	<style>
		.col-form-label{
			font-size: medium;
			padding-top:5px;
		}
		textarea {
			resize: none;
		}
		.form-control-static
		{
			font-size: medium;	
		}
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
	</style>
</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="index.php">Distributor</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li id=1 role="presentation"><a href="add_con.php">Add Connection</a></li>
					<li id=2 role="presentation"><a href="man_con.php">Manage Consumers</a></li>
                    <li id=3 role="presentation"><a href="chk_ord.php">Check Orders</a></li>
                    <li id=4 role="presentation"><a href="view_fc.php">View Feedback &amp; Complaints</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#"><i class="glyphicon glyphicon-user"></i><?php echo $dis_name; ?><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation"><a href="d_prof.php"><span class="glyphicon glyphicon-folder-open"></span> Profile</a></li>
                            <li role="presentation"><a href="../logout.php"> <span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="<?php echo $path;?>assets/js/jquery.min.js"></script>
    <script src="<?php echo $path;?>assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>