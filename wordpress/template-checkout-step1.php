<?php
/*
Template Name: Checkout step 1
*/
?>
<?php //get_header(); ?>

<?php //get_template_part('templates/content', 'page'); ?>



<?php
ob_start();
header('Cache-Control: max-age=0, no-cache, must-revalidate');
header('Pragma: no-cache');
$sessionid = $_COOKIE['PHPSESSID'];
	if(isset($_SESSION) && !empty($_SESSION['intro_cost']))
	{
	 $introcost = $_SESSION['intro_cost'];
	}else{
	 $introcost = "14.95";
	}
	global $wpdb;
	//print_r($_POST);
	if ($_POST['checkoutnow']){
		$specialinstructions = $_POST['specialinstructions'];
		$_SESSION['specialinstructions'] = $specialinstructions;
		$query = mysql_query("UPDATE wp_orders SET specialinstructions = '$specialinstructions' WHERE session_id = '".$sessionid."'");
	}
/*if ($_POST['formsubmit']){
	$errors = array();
	if(trim($_POST['inputFirstName']) == ""){
		$errors['firstname'] = "Please Enter your Firstname";
		
	}
	if(trim($_POST['inputLastName']) == ""){
		
		$errors['lastname'] = "Please Enter your Lastname";
	}
	if(trim($_POST['inputAddress1']) == ""){
		
		$errors['address1'] = "Please Enter your Address 1";
	}
	//if(trim($_POST['inputAddress2']) == ""){
	//	
	//	$errors['address2'] = "Please Enter your Address 2";
	//}
	if(trim($_POST['inputCity']) == ""){
		
		$errors['city'] = "Please Enter your City";
	}
	if(trim($_POST['inputZipCode']) == ""){
		
		$errors['zipcode'] = "Please Enter your Zipcode";
	}
	if(trim($_POST['inputEmail']) == ""){
		
		$errors['email'] = "Please Enter your EmailId";
	}
	else if(filter_var($_POST['inputEmail'],FILTER_VALIDATE_EMAIL) === false)
		{
			  $errors['email'] = 'Email is not valid';
		}
	if(trim($_POST['inputConfirmEmail']) == ""){
		
		$errors['cemail'] = "Please Enter your Zipcode";
	}
	elseif($_POST['inputEmail']!=$_POST['inputConfirmEmail']){
		
		$errors['cemail'] = "Email and confirmation email does not matched!";
	}
	if(trim($_POST['inputPhone']) == ""){
		
		$errors['phone'] = "Please Enter your phone no";
	}
	
	
	if(count($errors) == 0){
		//print_r($_POST);
		
	}
	
	
	
}*/
//echo $_GET['id'];

if(isset($_GET) && !empty($_GET['id'])){
	
	global $wpdb;
	$sessionid = $_COOKIE['PHPSESSID'];
	$query = "select addresstable.*,addresstable.id as aid,statetable.* from wp_order_address as addresstable
	INNER JOIN wp_state_zone as statetable ON addresstable.shipping_state = statetable.id where addresstable.session_id = '".$sessionid."' and addresstable.id = '".$_GET['id']."'";
	$exequery = $wpdb->get_row($query, ARRAY_A);
	//print_r($exequery);
	if($exequery){
		$firstname = $exequery['shipping_Fname'];
		$lastname = $exequery['shipping_Lname'];
		$addr1 = $exequery['shipping_Address1'];
		$addr2 = $exequery['shipping_Address2'];
		$city = $exequery['shipping_city'];
		$state = $exequery['name'];
		$stateId = $exequery['id'];
		$zipcode = $exequery['shipping_zipcode'];
		$phone_no = $exequery['shipping_phone_no'];
		$email = $exequery['shipping_Email'];
		$promocode = $exequery['promotional_code'];	
		$refferedby = $exequery['reffered_by'];
		$refferedname = $exequery['refferal_name'];
		$dilivery_instruction = $exequery['dilivery_instruction'];
		
	}
}	
if(isset($_SESSION['firstname'])){
                $firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['shipping_Lname'];
		$addr1 = $_SESSION['shipping_Address1'];
		$addr2 = $_SESSION['shipping_Address2'];
		$city = $_SESSION['shipping_city'];
		$state = $_SESSION['name'];
		$stateId = $_SESSION['id'];
		$zipcode = $_SESSION['shipping_zipcode'];
		$phone_no = $_SESSION['shipping_phone_no'];
		$email = $_SESSION['shipping_Email'];
		$promocode = $_SESSION['promotional_code'];	
		$refferedby = $_SESSION['reffered_by'];
		$refferedname = $_SESSION['refferal_name'];
		$dilivery_instruction = $_SESSION['dilivery_instruction'];
 
 
 
}
?>
<div class="section-8 checkout">
<div class="container">
<h1>Secure Checkout - Shipping Information</h1>
<div class="flow-outer">
<div class="col-xs-8">
<div class="left-col-st">We just need your name, address and payment information to send to your special introductory order and get your pet started on a healthy Darwin's diet.
<h2>Shipping Address</h2>

<div class="form-block">
<form id="shippingform" class="form-horizontal" action="<?php echo bloginfo('template_url');?>/shipping_action.php" method="post">
<input id="hid" name="hid" class="form-control" type="hidden" value="<?php echo $_GET['id']; ?>"/>
<div class="row">
<div class="col-lg-8">
<div class="form-group"><label class="control-label col-lg-4" for="inputFirstName">First Name</label>
<div class="col-lg-8"><input id="inputFirstName" name="inputFirstName" class="form-control" type="text" value="<?php echo $firstname; ?>"/>
<div style="color:red;"><?php if(isset($errors['firstname'])){ echo $errors['firstname'] ;} ?></div></div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputLastName">Last Name</label>
<div class="col-lg-8"><input id="inputLastName" name="inputLastName" class="form-control" type="text" value="<?php echo $lastname; ?>"/>
<div style="color:red;">
<?php if(isset($errors['lastname'])){ echo $errors['lastname'] ;} ?></div>
</div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputAddress1">Address 1</label>
<div class="col-lg-8"><input id="inputAddress1" name="inputAddress1" class="form-control" type="text" value="<?php echo $addr1; ?>"/>
<div style="color:red;">
<?php if(isset($errors['address1'])){ echo $errors['address1'] ;} ?>
</div>
</div></div>
<div class="form-group"><label class="control-label col-lg-4" for="inputAddress2">Address 2</label>
<div class="col-lg-8"><input id="inputAddress2" name="inputAddress2" class="form-control" type="text" value="<?php echo $addr2; ?>"/>
<div style="color:red;">
<?php if(isset($errors['address2'])){ echo $errors['address2'] ;} ?>
</div>
</div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputCity">City</label>
<div class="col-lg-8"><input id="inputCity" name ="inputCity" class="form-control" type="text" value="<?php echo $city; ?>"/>
<div style="color:red;">
<?php if(isset($errors['city'])){ echo $errors['city'] ;} ?>
</div>
</div>
</div>

<div class="form-group">
	<label class="control-label col-lg-4" for="inputState">State</label>
	<div class="col-lg-8 selectContainer">
		<select id= "inputState" class="form-control" name="inputState">
		<option value="">Select</option>
		
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
<div class="col-lg-8"><input id="inputZipCode" name="inputZipCode" class="form-control" type="text" value="<?php if(isset($_SESSION)){ echo $_SESSION['zipcode'];} else {echo $zipcode;} ?>"/><!-- onkeyup="checkStates()"-->
<div id="ziperror" style="color:red;">
<?php if(isset($errors['zipcode'])){ echo $errors['zipcode'] ;} ?>
</div>
</div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputEmail">Email</label>
<div class="col-lg-8"><input id="inputEmail" name="inputEmail" class="form-control" type="email" value="<?php echo $email; ?>"/>
<div style="color:red;">
<?php if(isset($errors['email'])){ echo $errors['email'] ;} ?></div>
</div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputConfirmEmail">Confirm Email</label>
<div class="col-lg-8"><input id="inputConfirmEmail" name="inputConfirmEmail" class="form-control" type="email" value="<?php echo $email; ?>" />
<div style="color:red;">
<?php if(isset($errors['cemail'])){ echo $errors['cemail'] ;} ?></div>
</div>
</div>
<div class="form-group"><label class="control-label col-lg-4" for="inputPhone">Phone</label>
<div class="col-lg-8"><input id="inputPhone" name="inputPhone" class="form-control" type="text" value="<?php echo $phone_no; ?>"/>
<div style="color:red;">
<?php if(isset($errors['phone'])){ echo $errors['phone'] ;} ?></div>
</div>
</div>
</div>
<div class="col-lg-4 clearfix">
<div class="border delivery-address-info-info">Delivery address must be a U.S. street address, we cannot deliver to P.O. boxes or outside the U.S.</div>
</div>
</div>
<div class="row voffset">
<div class="col-lg-8">
<div class="form-group"><label class="control-label text-left col-lg-12" for="inputDeliveryInstructions">Delivery Instructions</label>
<div class="col-lg-12"><textarea id="inputDiliveryInstr" name="inputDiliveryInstr" class="form-control"><?php echo $dilivery_instruction; ?></textarea></div>
</div>
<div class="border privacy-policy-info voffset"><strong>Privacy Policy:</strong>
We will keep your contact information private and only use it to contact you about Darwin's. We will not provide it to anyone else, except as needed to expedite your order.</div>
</div>
<div class="col-lg-4">
<div class="form-group"><label class="control-label text-left col-lg-12" for="inputReferred">Referred by</label>
<div class="col-lg-12">
<div class="checkbox"><label>
<?php
//$expArray = explode(',',$refferedby);
$langs = array_map('trim', explode(",", $refferedby));

?>
<input name="inputReferred[]" id="inputReferred" type="checkbox" <?php echo (in_array('friend', $langs)?'checked="checked"':NULL); ?>  value="friend" />Friend</label>
<label>
<input name="inputReferred[]" id="inputReferred" type="checkbox" <?php echo (in_array('vet', $langs)?'checked="checked"':NULL); ?>  value="vet" />Vet</label>
<label>
<input name="inputReferred[]" id="inputReferred" type="checkbox" <?php echo (in_array('other', $langs)?'checked="checked"':NULL);  ?>  value="other" />Other</label>
<div class="form-group"><label class="text-left col-lg-12" for="inputReferralName">Referral Name</label>
<div class="col-lg-12"><input id="inputReferralName" class="form-control" name="inputReferralName" value="<?php echo $refferedname;?>" type="text" /></div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row voffset">
<div class="col-lg-6"><a class="prev-link" href="/shopping-cart/">Back to Order Summary</a></div>
<div class="col-lg-6"><input class="btn btn-primary" value = "Payment Information" name="formsubmit" type="submit"  /></div>
</div>
</div>
</div>
</div>
<div class="col-xs-4 right-r">
<div class="right-col-st"><article><h3 class="cart-list">Shopping Cart</h3>
<div class="checkout-detail">
<ul>
	<li>
<h3>One Time Order</h3>
<div class="order-type"><strong>Introductory Offer</strong></div>
<ul class="order-detail">
	<li>10 lbs. Natural Selections</li>
</ul>
<div class="order-price">$14.95 - 10 lbs.</div>
<div class="order-checkout-info">(charged when shipped)</div>

	</li>
	<li>
<h3>Recurring Order</h3>
<!--<p>Price includes shipping</p>-->
<div class="border cancellation-info voffset">For your convenience, change or cancel at anytime before shipment.</div>


        <?php
$sessionid = $_COOKIE['PHPSESSID'];
	$qry = "select * from wp_carts_final where session_id = '".$sessionid."'";
	$result = $wpdb->get_results($qry, ARRAY_A);
	foreach ( $result as $row ) {
		//print_r($row);
		$keyData = array_keys($row);
		if($row['pet_type']==0) { ?>
		  <div class="order-type">Dog Food - Recurs Every
		  <?php if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){ ?>
		  <?php echo $_SESSION["shipping_weeks"];?>
		  <?php }else{?>
		  <?php echo $row['weeks']; ?>
		  <?php }?>
		  Weeks
		  </div>     
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
		//echo $_SESSION['shipment_price'];
		$total = $row['price'] + $_SESSION['shipment_price'];
		$recurringTotal=$total+$recurringTotal;
		?>
		<div class="order-price"><?php echo "$".number_format($total, 2, '.', '')." - ".$row['pet_food']." lbs." ?> </div>
	<?php } ?>

<div class="order-checkout-info">Price includes shipping</div>	
<div class="order-checkout-info">(Charged when shipped)</div>
<hr>
<div class="order-checkout-info">Recurring Order Total :  <?php echo "$".number_format($recurringTotal, 2, '.', '') ?></div>

</li>
</ul>
</div>
<div class="voffset promotion-code "><label class="promo-title">Promotional Code</label>
<input class="txtfield promo-field" name="promo-code" type="text" value="<?php echo $promocode;?>"/></div></form>
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
     
<script src="<?php echo bloginfo('template_url');?>/validator/dist/jquery.validate.js"></script>
<script src="<?php echo bloginfo('template_url');?>/assets/js/script.js"></script>
