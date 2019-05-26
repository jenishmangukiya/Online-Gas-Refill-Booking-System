<?php
session_start();
include_once('../../includes/db_con.php');
include_once('../../apis/Way2SMS/way2sms-api.php');
include_once('../../apis/mail_cfg.php');
if(isset($_GET['oid']) and isset($_SESSION['did']))
{
	$oid=$_GET['oid'];
	$sval=$_GET['s_val'];
	
		//fetch mobile no,email of consumer_detail
		$result=mysqli_query($conn,"select * from consumer_detail where cid=(select cid from order_detail where oid=$oid)") or die(mysqli_error($conn));
		$r=mysqli_fetch_assoc($result);
		$mno=$r['m_no'];
		$eid=$r['e_id'];
		
		if($sval==="Approved")
			$msg_format="Your order has been approved.";
		else if($sval==="Out for delivery")
			$msg_format="Your order is out for delivery.";
		else if($sval==="Delivered")
			$msg_format="We successfully delivered your order, And you can contact us if you have any query regarding our services/product.";
		
		//sms
		sendWay2SMS("9904436106","MJENISH8",$mno,"Your order id - ".$oid.", ".$msg_format);
		//email
		$mail->addAddress("$eid");
		$mail->Subject = 'Order status.';
		$mail->isHTML(true);
		$mailContent = "<h2>Order Id - ".$oid.".</h2>
						<h2>".$msg_format."</h2>
						";
		$mail->Body = $mailContent;
		$mail->send();
		
	if(mysqli_query($conn,"update order_detail set status='$sval' where oid=$oid") or mysqli_error($conn))
		echo 'Order status has been updated.';
}
else
{
	header('Location:../index.php');
}
?>