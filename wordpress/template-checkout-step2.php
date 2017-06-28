<?php
/*
Template Name: Checkout step 2
*/
?>
<?php //get_header(); ?>

<?php //get_template_part('templates/content', 'page'); ?>
<?php
header('Cache-Control: max-age=0, no-cache, must-revalidate');
header('Pragma: no-cache');
	if(isset($_SESSION) && !empty($_SESSION['intro_cost']))
	{
		$introcost = $_SESSION['intro_cost'];
	}else{
		$introcost = "14.95";
	}
global $wpdb;


	global $wpdb;
	$sessionid = $_COOKIE['PHPSESSID'];
	 $query = "select addresstable.*,addresstable.id as aid,statetable.* from wp_order_address as addresstable
	INNER JOIN wp_state_zone as statetable ON addresstable.shipping_state = statetable.id where session_id = '".$sessionid."' ORDER BY addresstable.id DESC ";
	$exequery = $wpdb->get_row($query, ARRAY_A);
	//echo '<pre>';print_r($exequery);die;
	
	$addrid = $exequery['aid'];
	$firstname = $exequery['billing_Fname'];
	$lastname = $exequery['billing_Lname'];
	$addr1 = $exequery['billing_Address1'];
	$addr2 = $exequery['billing_Address2'];
	$city = $exequery['billing_city'];
	$state = $exequery['name'];
	$stateId = $exequery['id'];
	$zipcode = $exequery['billing_zipcode'];
	$phone_no = $exequery['billing_phone_no'];
	$email = $exequery['billing_Email'];
	
	$shipping_firstname = $exequery['shipping_Fname'];
	$shipping_lastname = $exequery['shipping_Lname'];
	$shipping_addr1 = $exequery['shipping_Address1'];
	$shipping_addr2 = $exequery['shipping_Address2'];
	$shipping_city = $exequery['shipping_city'];
	$shipping_state = $exequery['name'];
	$shipping_stateId = $exequery['id'];
	$shipping_zipcode = $exequery['shipping_zipcode'];
	$shipping_phone_no = $exequery['shipping_phone_no'];
	$shipping_email = $exequery['shipping_Email'];	
	$promocode = $exequery['promotional_code'];	

if($exequery['shipping_Fname']){
$_SESSION['firstname'] = $exequery['shipping_Fname'];
$_SESSION['shipping_Lname'] = $exequery['shipping_Lname'];
$_SESSION['shipping_Address1'] = $exequery['shipping_Address1'];
$_SESSION['shipping_Address2'] = $exequery['shipping_Address2'];
$_SESSION['shipping_city'] = $exequery['shipping_city'];
$_SESSION['id'] = $exequery['id'];
$_SESSION['name'] = $exequery['name'];
$_SESSION['shipping_zipcode'] = $exequery['shipping_zipcode'];
$_SESSION['shipping_phone_no'] = $exequery['shipping_phone_no'];
$_SESSION['shipping_Email'] = $exequery['shipping_Email'];
$_SESSION['reffered_by'] = $exequery['reffered_by'];
$_SESSION['refferal_name'] = $exequery['refferal_name'];
$_SESSION['promotional_code'] = $exequery['promotional_code'];
$_SESSION['dilivery_instruction'] = $exequery['dilivery_instruction'];

}


	if($_POST['billingsubmit']){
		
		require_once('authorise/AuthorizeNet.php');	  
		$ccn = trim($_POST['inputCardNumber']);
		$month =  trim($_POST['expMonth']); 
		$year =  trim($_POST['expYear']);
		$ccname =  trim($_POST['inputCardholderName']);   
		$emailid = $email;
		$ccv = trim($_POST['inputCardID']);
		//$loginid = "84A6vF9VfMa";
		//$trankey = "86H2835qX7BpMxaw";	
		$loginid = "6Pt7Ec2N";
		$trankey = "33V782Qga3dW5fU7";	
		$errors = array();
		if(trim($ccn) == ""){
			$errors['card'] = "Please Enter your card number";
			
		}
		if(trim($month) == ""){
			
			$errors['month'] = "Please Select month";
		}
		if(trim($year) == ""){
			
			$errors['year'] = "Please select year";
		}
		
		if(trim($ccv) == ""){
			
			$errors['ccv'] = "Please Enter your CCV code";
		}
		if(trim($ccname) == ""){
			
			$errors['ccname'] = "Please Enter your name";
		}
			
	
		 
		/*sandbox credentials*/    
		
		define("AUTHORIZENET_API_LOGIN_ID", $loginid);
		define("AUTHORIZENET_TRANSACTION_KEY", $trankey);
		define("AUTHORIZENET_SANDBOX", true);
		
		// Create new customer profile
		$request =new AuthorizeNetCIM; 
		$customerProfile = new AuthorizeNetCustomer;	
		//////////////////get profile and payment profileid//////////
		$customerProfile->description = $firstname.' '.$lastname;
		$customerProfile->merchantCustomerId = time().rand(1,100);
		$customerProfile->email = $emailid;   //pr($customerProfile);
		
		
	

		
		// Add payment profile.
		$paymentProfile = new AuthorizeNetPaymentProfile;
		$paymentProfile->customerType = "individual";
		$paymentProfile->billTo->firstName = $firstname;   //pr($customerProfile);
		$paymentProfile->billTo->lastName = $lastname;
		$paymentProfile->billTo->company = "Darwin";
		$paymentProfile->billTo->address = $addr1;
		$paymentProfile->billTo->city = $city;
		$paymentProfile->billTo->state = $state;
		$paymentProfile->billTo->country = "US";
		$paymentProfile->billTo->zip = $zipcode;
		$paymentProfile->billTo->phoneNumber = $phone_no;
		$paymentProfile->payment->creditCard->cardNumber = $ccn;
		$paymentProfile->payment->creditCard->expirationDate = $year."-"."02";
		$customerProfile->paymentProfiles[] = $paymentProfile;
		$paymentProfile->payment->creditCard->cardCode = $ccv;
		//echo '<pre>';print_r($paymentProfile); echo '--------';
		$response = $request->createCustomerProfile($customerProfile);
		$paymentPrfid = (array)$response->xml->customerPaymentProfileIdList->numericString;
		$customerPrfid = (array)$response->xml->customerProfileId;
		$payid = $paymentPrfid[0];
		$custid = $customerPrfid[0];
		if($custid != ""){
			//print_r($customerProfile);echo '--------';
			//echo "<pre>"; print_r($response->xml->customerPaymentProfileIdList->numericString[0]);
			
			 //print_r($response); die;
			// $errors['ccname'] = "Please Enter your name";
			$res=$response->xml->messages->message->text;
			//	print_r($res);	 
			$success = settype($res[0],'string');
			if($res=='Successful.')
			{			  
				$data['GeodesicClassified']['customerProfileId']=$response->xml->customerProfileId;
				$data['GeodesicClassified']['numericString']=$response->xml->customerPaymentProfileIdList->numericString;			        			        		      
				$post_url = "https://test.authorize.net/gateway/transact.dll";
				//$post_url = "https://secure.authorize.net/gateway/transact.dll";		      
				$card_number = $ccn;
				$exp_date = $year."-".$month; 	       			       			      			   	     			       
				$amount=0;              	              		      	                          
				$first_name = $firstname;
				$last_name = $lastname;
				$address = $addr1;
				$state = $state;
				$zip = $zipcode;
				$email = $email;
				$card_code = $ccv;
					  
				$post_values = array(	
					  "x_login"=>$loginid,
					  "x_tran_key"=>$trankey,"x_version"=>"3.1","x_delim_data"=>"TRUE",
					  "x_delim_char"=> "|","x_relay_response"=>"FALSE","x_type"=>"AUTH_ONLY",
					  "x_method"		=> "CC","x_card_num"		=> $card_number,
					  "x_exp_date"		=> $exp_date,"x_amount"		=> $amount,
					  "x_description"		=> "Registration Amount","x_first_name"		=> $first_name,
					  "x_last_name"		=> $last_name,"x_address"		=> $address,
					  "x_state"			=> $state,"x_zip"			=> $zip,
					  "x_email"                   => $email,"x_card_code"=> $card_code);
				
				
				$post_string = "";
				foreach( $post_values as $key => $value ){	$post_string .= "$key=" . urlencode( $value ) . "&"; }
							  
							  
				$post_string = rtrim( $post_string, "& " );
				$request = curl_init($post_url); // initiate curl object
				curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
				curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
				curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
				curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
				$post_response = curl_exec($request); // execute curl post and store results in $post_response
				curl_close ($request); // close curl object
				$response = explode($post_values["x_delim_char"],$post_response);     
				//echo "<pre>"; print_r($response); die; //pr($response); //die;
				  switch($response[0]){
					case 1:
						$transactionid = $response['6'];
						$today = date("Y-m-d H:i:s");
						$lastdccndigits = substr($ccn, -4);
						 $query = "UPDATE wp_orders SET transaction_id='$transactionid',payment_profile='$payid',customr_profile='$custid',payment_status='1',order_date='$today',cardno='$lastdccndigits' WHERE session_id = '".$sessionid."'";
						mysql_query($query);
						$bfname = trim($_POST['billing_inputFirstName']);
						
						$blname = trim($_POST['billing_inputLastName']);
						$bemail = trim($_POST['billing_inputEmail']);
						$baddress1 = trim($_POST['billing_inputAddress1']);
						$baddress2 = trim($_POST['billing_inputAddress2']);
						$bcity = trim($_POST['billing_inputCity']);
						$bstate= trim($_POST['billing_inputState']);
						$bzip= trim($_POST['billing_inputZipCode']);
						$bphone= trim($_POST['billing_inputPhone']);
						$bsessionid = $_COOKIE['PHPSESSID'];	
						$bquery = "UPDATE wp_order_address SET billing_Fname='$bfname',billing_Lname='$blname',billing_Email='$bemail',billing_Address1='$baddress1',billing_Address2='$baddress2',billing_city='$bcity' ,billing_state='$bstate',billing_zipcode='$bzip',billing_phone_no='$bphone' WHERE session_id = '".$sessionid."'";
						mysql_query($bquery);
						$apidata = callSysproApi();
						if($apidata == 1){
							$errors['error_code'] = $response['3'];
						
							
							mysql_query("UPDATE wp_order_address SET session_id='$sid' WHERE session_id = '$sessionid'");
							mysql_query("UPDATE wp_orders SET session_id='$sid' WHERE session_id = '$sessionid'");
							mysql_query("UPDATE wp_carts_final SET session_id='$sid' WHERE session_id = '$sessionid'");
							mysql_query("UPDATE  wp_carts SET session_id='$sid' WHERE session_id = '$sessionid'");
							session_destroy();
							header("Location:/thank-you-for-ordering/");die;
						}else{
							$errors['error_code'] = 'Some thing went wrong. please try later';
						}
						
						break;
					case 2:
						$errors['error_code'] = $response['3'];
						break;
					case 3:
						$errors['error_code']  = $response['3'];
						break;
					case 4:
						$errors['error_code'] = $response['3'];
						break;
				  }
				//if($response[0]=="1"){
				//	}
			}
			else{
				$errors['error_code'] = 'Some thing went wrong. please try later';
			}
		}
		else{
			$errors['error_code'] = 'Some thing went wrong. please try later';
		}

	
	}



?>


<div class="section-8 checkout step2">
<div class="container">
<h1>Secure Checkout &#8211; Payment Information</h1>
<div class="flow-outer">
<div class="col-xs-8">
<div class="left-col-st">
<div class="checkbox clearfix"><label>
<input id="inputSameasShippingAddress" checked="checked"  name="inputSameasShippingAddress" type="checkbox"/> Billing same as Shipping Address</label></div>
<div class="form-block">
<form id="billingform" class="form-horizontal" action="" method="post">
<div class="col-lg-8">
<div class="border voffset shipping-address-info">
<h2>Shipping Address</h2>
<?php


echo ucwords($shipping_firstname).' '.ucwords($shipping_lastname);
echo '<br/>';
echo $shipping_addr1;
echo '<br/>';
echo $shipping_city. ' '.$shipping_state.',';
echo '<br/>';
echo $shipping_zipcode;

?>

<br/>
<a href="/checkout-step-1?id=<?php echo $addrid; ?>" <!--onclick="showBillingaddress()"-->>Edit Address</a>

</div>
<div class="voffset billing-address">
<div class="form-group"><label class="control-label col-lg-4" for="inputFirstName">First Name</label>
<div class="col-lg-8"><input id="billing_inputFirstName" name="billing_inputFirstName" class="form-control" type="text" value="<?php echo $firstname;?>"/></div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputLastName">Last Name</label>
<div class="col-lg-8"><input id="billing_inputLastName" name="billing_inputLastName" class="form-control" type="text" value="<?php echo $lastname;?>"/></div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputAddress1">Address 1</label>
<div class="col-lg-8"><input id="billing_inputAddress1" name="billing_inputAddress1" class="form-control" type="text" value="<?php echo $addr1;?>"/></div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputAddress2">Address 2</label>
<div class="col-lg-8"><input id="billing_inputAddress2" name="billing_inputAddress2" class="form-control" type="text" value="<?php echo $addr2;?>"/></div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputCity">City</label>
<div class="col-lg-8"><input id="billing_inputCity" name="billing_inputCity" class="form-control" type="text" value="<?php echo $city;?>"/></div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputState">State</label>
<div class="col-lg-8 selectContainer">
<select class="form-control" name="billing_inputState">
	<option>Select</option>
	<?php 
		global $wpdb;
		$qry = "select * from wp_state_zone";
		$results = $wpdb->get_results($qry, ARRAY_A);
		foreach($results as $rows){
			if($stateId == $rows['id'])
			{
				$selected = "Selected";
			}
			else{
				$selected ="";
			}
	   ?>
	   <option value="<?php echo $rows['id']; ?>" <?php echo $selected;?>><?php echo $rows['name']; ?></option>
	   
	   <?php } ?>
</select>
</div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputZipCode">Zip Code</label>
<div class="col-lg-8"><input id="billing_inputZipCode" name="billing_inputZipCode" class="form-control" type="text" value="<?php echo $zipcode;?>"/></div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputEmail">Email</label>
<div class="col-lg-8"><input id="billing_inputEmail" name="billing_inputEmail" class="form-control" type="email" value="<?php echo $email;?>"/></div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputConfirmEmail">Confirm Email</label>
<div class="col-lg-8"><input id="billing_inputConfirmEmail" name="billing_inputConfirmEmail" class="form-control" type="email" value="<?php echo $email;?>"/></div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputPhone">Phone</label>
<div class="col-lg-8"><input id="billing_inputPhone" name="billing_inputPhone"  class="form-control" type="text" value="<?php echo $phone_no;?>"/></div>
</div>
</div>
<div style="color:red;"><?php if(isset($errors['error_code'])){ echo $errors['error_code'] ;} ?></div>

<h2 class="voffset">Payment Information</h2>
<div class="form-group"><label class="control-label col-lg-4" for="inputCardholderName">Cardholder Name</label>
<div class="col-lg-8"><input id="inputCardholderName" name="inputCardholderName"  class="form-control" type="text" />
<div style="color:red;"><?php if(isset($errors['ccname'])){ echo $errors['ccname'] ;} ?></div>
</div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputCardNumber">Card Number</label>
<div class="col-lg-8"><input id="inputCardNumber" name="inputCardNumber" class="form-control" type="text" />
<div style="color:red;"><?php if(isset($errors['card'])){ echo $errors['card'] ;} ?></div>
</div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputExpirationDate">Expiration Date</label>
<div class="col-lg-8"><select id="Month" class="form-control" name="expMonth" style="width: 106px;">
<option value="">Month</option>
<option value="01">Jan</option>
<option value="02">Feb</option>
<option value="03">Mar</option>
<option value="04">Apr</option>
<option value="05">May</option>
<option value="06">Jun</option>
<option value="07">Jul</option>
<option value="08">Aug</option>
<option value="09">Sep</option>
<option value="10">Oct</option>
<option value="11">Nov</option>
<option value="12">Dec</option>
</select>
<div style="color:red;"><?php if(isset($errors['month'])){ echo $errors['month'] ;} ?></div>
<select style="width: 106px; margin-left: 4px;" name="expYear" class="form-control" id="ExpYear">


<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2017">2017</option>
<option value="2018">2018</option>
<option value="2019">2019</option>
<option value="2020">2020</option>
<option value="2021">2021</option>
<option value="2022">2022</option>
<option value="2023">2023</option>
<option value="2024">2024</option>
<option value="2025">2025</option>
<option value="2026">2026</option>
<option value="2027">2027</option>
<option value="2028">2028</option>
<option value="2029">2029</option>
<option value="2030">2030</option>
<option value="2031">2031</option>
<option value="2032">2032</option>
<option value="2033">2033</option>
<option value="2034">2034</option>
<option value="2035">2035</option>
<option value="2036">2036</option>
<option value="2037">2037</option>
<option value="2038">2038</option>
<option value="2039">2039</option>
<option value="2040">2040</option>
<option value="2041">2041</option>
<option value="2042">2042</option>
<option value="2043">2043</option>
<option value="2044">2044</option>
<option value="2045">2045</option>
<option value="2046">2046</option>
<option value="2047">2047</option>
<option value="2048">2048</option>
<option value="2049">2049</option>
<option value="2050">2050</option>
</select>
<div style="color:red;"><?php if(isset($errors['year'])){ echo $errors['year'] ;} ?></div>
</div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputCardID">Card ID</label>
<div class="col-lg-8"><input id="inputCardID" name="inputCardID" class="form-control" type="text" />
<div style="color:red;"><?php if(isset($errors['ccv'])){ echo $errors['ccv'] ;} ?></div>
</div>
</div>
<div class="form-group">
<div class="col-lg-4">&nbsp;</div>
<div class="col-lg-8"><img src="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/img/visa.png" width="50" height="30" alt="Visa"/> <img src="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/img/mastercard.png" width="50" height="30" alt="Mastercard"/> <img src="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/img/amex.png" width="50" height="30" alt="American Express"/> <img src="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/img/discover.png" width="50" height="30" alt="Discover"/></div>
</div>
<div class="small-text">All personal information you submit is encrypted and secure</div>
<!--<input id="customername" name="customername" class="form-control" type="hidden" />
<input id="customeremail" name="customeremail" class="form-control" type="hidden" />
<input id="customeraddress" name="customeraddress" class="form-control" type="hidden" />
<input id="state" name="state" class="form-control" type="hidden" />
<input id="zipcode" name="zipcode" class="form-control" type="hidden" />
<input id="phoneno" name="phoneno" class="form-control" type="hidden" />-->
</div>
<div class="row voffset">
<div class="border voffset acknowledgement-info">

Please send me my introductory offer of 10 lbs of Darwin's meals for $14.95 - including Free Shipping - right away. I understand that I will receive my first regular order of 32 lbs in 4 weeks after my special introductory order, and every 2 weeks thereafter, and that I can change or cancel my order at any time by contacting Darwin's prior to shipping. I authorize Darwin's to charge my credit card for these orders when they ship.
<p class="small-text">You will only be charged $14.95 for your introductory order. Future shipments will be charged upon shipment.</p>

</div>
</div>
<div class="row voffset">
<div class="col-lg-6"><a class="prev-link" href="/checkout-step-1/">Return to Name and Address</a></div>
<div class="col-lg-6">
<input class="btn btn-primary" value = "Confirm Order" name="billingsubmit" type="submit"  />
</div>
</div>
</form></div>
</div>
</div>
<div class="col-xs-4 right-r">
<div class="right-col-st white-bg"><article>
<h2 class="cart-list">Shopping Cart</h2>
<div class="checkout-detail">
<ul>
	<li>
<h3>One Time Order</h3>
<div class="order-type">Introductory Offer</div>
<ul class="order-detail">
	<li>10 lbs. Natural Selections</li>
</ul>
<div class="order-price">$14.95 - 10 lbs.</div>
<div class="order-checkout-info">(charged when shipped)</div></li>

<?php 	//	$result = get_cartData();
	$sessionid = $_COOKIE['PHPSESSID'];
	$qry = "select * from wp_carts_final where session_id = '".$sessionid."'";
	$result = $wpdb->get_results($qry, ARRAY_A);
	
	?>

<li>
<h3>Recurring Order</h3>
<div class="border cancellation-info voffset">For your convenience, change or cancel at anytime before shipment.</div>


        <?php

	foreach ( $result as $row ) {
		//print_r($row);
		$keyData = array_keys($row);
		if($row['pet_type']==0) { ?>
		  <div class="order-type">Dog Food - Recurs Every <?php if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){ ?>
		  <?php echo $_SESSION["shipping_weeks"];?>
		  <?php }else{?>
		  <?php echo $row['weeks']; ?>
		  <?php }?> Weeks</div>     
		  <ul class="order-detail">
		  <li><?php echo 'Beef - '.$row['beef'].' packages'; ?></li>
		  <li><?php echo 'Chicken - '.$row['chicken'].' packages'; ?></li>
		  <li><?php echo 'Duck - '.$row['duck'].' packages'; ?></li>
		  <li><?php echo 'Turkey - '.$row['turkey'].' packages'; ?></li>
		  </ul>
		  
		  <?php	  } else { ?>
		  <div class="order-type">Cat Food - Recurs Every <?php if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){ ?>
		  <?php echo $_SESSION["shipping_weeks"];?>
		  <?php }else{?>
		  <?php echo $row['weeks']; ?>
		  <?php }?> Weeks</div>  
		  <ul class="order-detail">
		  <li><?php echo 'Chicken - '.$row['chicken'].' packages'; ?></li>
		  <li><?php echo 'Duck - '.$row['duck'].' packages'; ?></li>
		  <li><?php echo 'Turkey - '.$row['turkey'].' packages'; ?></li>
		  </ul>
		 
		<?php  }
		$total = $row['price'] + $_SESSION['shipment_price'];
		$recurringTotal=$total+$recurringTotal;
		?>
		<div class="order-price"><?php echo "$".number_format($total, 2, '.', '')."- ".$row['pet_food']." lbs." ?> </div>
	<?php } ?>
<div class="order-checkout-info">(Charged when shipped)</div>
<hr>
<div class="order-checkout-info">Recurring Order Total :  <?php echo "$".number_format($recurringTotal, 2, '.', '') ?></div>
</li>
</ul>
</div>
<div class="border cancellation-info voffset">For your convenience, change or cancel at anytime before shipment.</div>
<div class="voffset promotion-code "><label class="promo-title">Promotional Code</label>
<input class="txtfield promo-field" name="promo-code" type="text" readonly value="<?php if(isset($promocode)){echo $promocode;}?>" /></div>
<div class="row voffset">
<div class="col-md-6 col-lg-6"><a href="#">Guarantee and Return Information</a></div>
<div class="col-md-6 col-lg-6">Transactional Trust Emblems (desaturated)</div>
</div>
</article></div>
</div>
<div class="right-bg"></div>
</div>
</div>
</div>

<script>
$( document ).ready(function() {
$("#inputSameasShippingAddress").change(function() {
    if(this.checked) {
        $('.billing-address').css('display', 'none')
		$('.shipping-address-info').css('display', 'block')
		 
    } else {
		$('.billing-address').css('display', 'block')
		$('.shipping-address-info').css('display', 'none')
	}
});
	
});

$('#inputSameasShippingAddress').click(function(){ 
	    
		if($(this).not(":checked")) { 
			//alert("asda");
			$('.billing-address').css('display', 'block')
		$('.shipping-address-info').css('display', 'none')

		}
		if($(this).is(":checked")) { 
		
			$('.billing-address').css('display', 'none')
		$('.shipping-address-info').css('display', 'block')

		}

	});
function showBillingaddress(){
    if($('#inputSameasShippingAddress').attr('checked', false)){
		
		$('.billing-address').css('display', 'block')
		$('.shipping-address-info').css('display', 'none')
	}else{
		$('.billing-address').css('display', 'none')
		$('.shipping-address-info').css('display', 'block')
		}
		
	}
</script>
<script src="<?php echo bloginfo('template_url');?>/validator/dist/jquery.validate.js"></script>
