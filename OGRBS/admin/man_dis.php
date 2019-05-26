<?php
session_start();
include_once('../includes/db_con.php');

if(isset($_SESSION['aid']))
{
	$title='Manage Distributors';
	$aid=$_SESSION['aid'];
	
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

	//select all distributor_detail
	$result=mysqli_query($conn,"select did,name,address,city,m_no,e_id,status from distributor_detail") or die(mysqli_error($conn));
	
	echo '
	<div class="container">
		<br>
		<div class="panel panel-default">
			<div class="panel-heading"><h2>'.$title.'</h2></div>
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
						<p data-placement="top" data-toggle="tooltip" title="Print">
							<button class="btn btn-success btn-block" onclick="window.print();"><span class="	glyphicon glyphicon-print"></span> Print/PDF</button>
						</p>
					</div>
				</div>
				<table class="table table-striped" style="font-size:95%">
					<thead>
					  <tr>
						<th>Distributor Id</th>
						<th>Name</th>
						<th>Address</th>
						<th>City</th>
						<th>Mobile no.</th>
						<th>Email</th>
						<th>Account Status</th>
						<th>Edit</th>
						<th>Delete</th>
						<th>View Consumers</th>
					  </tr>
					</thead>
					<tbody id="myTable">
					  '; 
					 
					$d=''; // contain each record
					while($r=mysqli_fetch_row($result))
					{
						$d.='<tr>';
						foreach($r as $v)
						{
							if($v=='Deactive')
								$d.='<td class=danger>'.$v.'</td>';
							else if($v=='Active')
								$d.='<td class=success>'.$v.'</td>';
							else
								$d.='<td>'.$v.'</td>';
						}

						// edit and delete button
						$d.='<td>
								<p data-placement="top" data-toggle="tooltip" title="Edit">
									<button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" id='.$r[0].' onclick="return up_data_form(this.id)">
										<span class="glyphicon glyphicon-pencil"></span>
									</button>
								</p>
							</td>
							<td>
								<p data-placement="top" data-toggle="tooltip" title="Delete">
									<button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" id='.$r[0].' onclick="return Deleteqry('.$r[0].');">
										<span class="glyphicon glyphicon-trash"></span>
									</button>
								</p>
							</td>
							<td>
								<p data-placement="top" data-toggle="tooltip" title="View Consumers of '.$r[1].'">							
									<button class="btn btn-info btn-xs" data-title="Delete" data-toggle="modal" data-target="#view_con" id='.$r[0].' value="'.$r[1].'" onclick="return con_fetch(this.id,this.value)">
										<span class="glyphicon glyphicon-list-alt"></span>
									</button>
								</p>								
							</td>							
							';
					}
					$d.='</tr>';
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
							z-index: 1051;
						</style>
					
					<script>
					// Delete record
					i=0;
					function Deleteqry(id)
					{ 
						window.i=id;
						return false;
					}
					function sendDelReq()
					{
							window.location="code/del_rec.php?del="+window.i;				
					}
					</script>
				
					
					<script>
					//send id for create form with pre definded value in edit button
					function up_data_form(did)
					{
						$.ajax({
									type: "GET",
									url: "code/up_dis.php",
									data: "did="+did,
									success: function(html)
										{
											$("#edit_model_body").html(html);
											/*
											var chk=document.getElementById("clmsg").innerHTML;
											
											if(chk==="True")
											{
												alert("You have been successfully logged in.");
												location.href= "consumer/";
												//window.location.reload()
											}*/
										}
						});
						return false;
					}
					
					//linked consumer fetch
					function con_fetch(did,name)
					{
						$("#un_con_heading").html("Underlying consumers of "+"<b>"+name+"</b>");
						$.ajax({
							type:"GET",
							url: "code/dis_con.php",
							data: "did="+did,
							success: function(html)
							{
								$("#dc_model_body").html(html);
							}
						});
						return false;
					}
					</script>
			</div>
				
			</div>
			
		</div>
	</div>
	
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Edit Detail</h4>
      </div>
          <div class="modal-body" id="edit_model_body">
			
		<!-- Edited form from ajax -->
			
      </div>
	  <!--
          <div class="modal-footer ">
        <button type="button" class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
      </div>
	  -->
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>
    
    
    
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
      </div>
          <div class="modal-body">
       
       <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
       
      </div>
        <div class="modal-footer ">
        <button type="button" class="btn btn-success" id="dy" onclick="sendDelReq();"><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog -->
    </div>
	
	<!-- View consumers model -->
	<div class="modal fade" id="view_con" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog modal-lg">
		<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
				<h4 class="modal-title custom_align" id="un_con_heading"></h4>
			  </div>
			  <div class="modal-body" id="dc_model_body">
					<!-- Edited form from ajax -->
		      </div>
		</div>
		<!-- /.modal-content --> 
	  </div>
		  <!-- /.modal-dialog --> 
    </div>
	';
	
	include_once('design/footer.php');
}
else
{
	header('Location:../index.php');
}
?>