<?php

require( '../../../wp-load.php' );
if ($_POST['formsubmit']){
	//echo '<pre>';print_r($_POST); die;
	$fname = trim($_POST['inputFirstName']);
	$lname = trim($_POST['inputLastName']);
	$email = trim($_POST['inputEmail']);
	$address1 = trim($_POST['inputAddress1']);
	$address2 = trim($_POST['inputAddress2']);
	$city = trim($_POST['inputCity']);
	$state= trim($_POST['inputState']);
	$zip= trim($_POST['inputZipCode']);
	$phone= trim($_POST['inputPhone']);
	$sessionid = $_COOKIE['PHPSESSID'];
	$reffereby = $_POST['inputReferred'];
	$promocode =  trim($_POST['promo-code']);
	$reffrename =  trim($_POST['inputReferralName']);
	$dilivery_instruction =  trim($_POST['inputDiliveryInstr']);
	$Regio = array();
	$adds = "";
	
	if(count($reffereby) > 0) {
	  foreach($reffereby as $key=>$value)
	    $Regio[] = $value;
	}
	
	$adds = implode(',', $Regio);
	//print_r($adds);die;
	 //$query = "UPDATE wp_carts SET customerFname='$fname',customerLname='$lname',customerEmail='$email',customerAddress1='$address1',customerAddress2='$address2',city='$city' ,state='$state',zipcode='$zip',phone_no='$phone' WHERE session_id = '".$sessionid."'";
	if($_POST['hid']){
		$query = "UPDATE wp_order_address SET shipping_Fname='$fname',shipping_Lname='$lname',shipping_Email='$email',shipping_Address1='$address1',shipping_Address2='$address2',shipping_city='$city' ,shipping_state='$state',shipping_zipcode='$zip',shipping_phone_no='$phone',
		promotional_code='$promocode',reffered_by='$adds',refferal_name='$reffrename',dilivery_instruction='$dilivery_instruction'
		WHERE session_id = '".$sessionid."' and id = '".$_POST['hid']."'";
		
	}
	else{
		$query = "INSERT INTO wp_order_address (session_id,shipping_Fname,shipping_Lname, shipping_Email, shipping_Address1,shipping_Address2,shipping_city,shipping_state,shipping_zipcode,shipping_phone_no,
		billing_Fname,billing_Lname, billing_Email, billing_Address1,billing_Address2,billing_city,billing_state,billing_zipcode,billing_phone_no,promotional_code,reffered_by,refferal_name,dilivery_instruction
		
		) VALUES ('$sessionid' ,'$fname', '$lname','$email', '$address1','$address2','$city','$state','$zip','$phone'
		,'$fname', '$lname','$email', '$address1','$address2','$city','$state','$zip','$phone','$promocode','$adds','$reffrename','$dilivery_instruction')";
	}
	
    
    
    $exequery = mysql_query($query);
    if($exequery){
		//echo "Data saved successfully.";
		//header("Location:/thank-you-for-ordering/");die;
		header('Location:http:/checkout-step-2/');die;
     }
	
}
?>