<?php
/*
Template Name: Thanks
*/
?>
<?php //get_header();?>
<?php
	if(isset($_SESSION) && !empty($_SESSION['intro_cost']))
	{
	 $introcost = $_SESSION['intro_cost'];
	}else{
	 $introcost = "14.95";
	}
global $wpdb;

?>

<div class="section-8">
<div class="container">
   <?php   $postid = $post->ID;   ?>
   <?php while (have_posts()) : the_post(); ?>
   <?php the_content(); ?>
   <?php endwhile; ?>

</div></div>
<?php
 /*  global $wpdb;
	$sessionid = $_COOKIE['PHPSESSID'];

	$query12 = "select * from wp_carts_final where session_id = '$sessionid'";
	$getDta12 = $wpdb->get_results($query12, ARRAY_A);
	
	//$query = "select orders_table.*,address_table.*,cart_final.* from wp_orders as orders_table 
	//LEFT JOIN wp_order_address as address_table ON orders_table.session_id = address_table.session_id
	//LEFT JOIN wp_carts_final as cart_final ON cart_final.session_id = address_table.session_id
	//where orders_table.session_id = '$sessionid'";
	//$getDta = $wpdb->get_results($query, ARRAY_A);
	//echo '<pre>';//print_r($getDta);die;
	$petKey = 0;echo '<pre>';
	//print_r($getDta12);
	foreach($getDta12 as $key){
		$pettype = $key['pet_type'];
		$petcat = $key['category_id'];
		$beef = $key['beef'];
		$chicken = $key['chicken'];
		$duck = $key['duck'];
		$bison = $key['bison'];
		$turkey = $key['turkey'];
		$keyData = array_keys($key);
				$i=5;
				//print_r($keyData);die;
					foreach($keyData as $keyvalues){
					if($petcat == 1){
						switch($keyvalues){
							   case "beef":
									if($beef !=0){
										$TemplatePartSKU ="NSD-BF02";
										$TemplateQuantity = $beef;
										$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
                                        
									}
									
									break;
								case "chicken":
									if($chicken !=0){
										$TemplatePartSKU ="NSD-CH02";
										$TemplateQuantity = $chicken;
										$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
									}
									break;
								case "duck":
									$TemplatePartSKU ="NSD-DK02";
									$TemplateQuantity = $duck;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
									break;
								case "turkey":
									$TemplatePartSKU ="NSD-TK02";
									$TemplateQuantity = $turkey;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
									break;
								case "bison":
									$TemplatePartSKU ="NSD-BI02";
									$TemplateQuantity = $bison;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
									break;
						}
					}
					if($petcat == 2){
					
					
						switch($keyvalues){
							   case "beef":
									$TemplatePartSKU ="ZLD-BF02";
									$TemplateQuantity = $beef;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
									break;
								case "chicken":
									$TemplatePartSKU ="ZLD-CH02";
									$TemplateQuantity = $chicken;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
									break;
								case "duck":
									$TemplatePartSKU ="ZLD-DK02";
									$TemplateQuantity = $duck;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
									break;
								case "turkey":
									$TemplatePartSKU ="ZLD-TK02";
									$TemplateQuantity = $turkey;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
									break;
								
						}
					
				}
				
				
				if($petcat == 3){
								
									switch($keyvalues){
										   
											case "chicken":
												$TemplatePartSKU ="NSD-CH02";
												$TemplateQuantity = $chicken;
												$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
												break;
											case "duck":
												$TemplatePartSKU ="NSC-DK02";
												$TemplateQuantity = $duck;
												$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
												break;
											case "turkey":
												$TemplatePartSKU ="NSC-TK02";
												$TemplateQuantity = $turkey;
												$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
												break;
									}
									
								
						}
						
				
					$i++;
				}
							
			
			
	//	$i++;
	
	$petKey++;
	}
	//echo '<pre>';print_r($tempOrderLine);;
	
	//$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => 'NSD-BF02','TemplateQuantity' => '7');
	//$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => 'NSD-CH02','TemplateQuantity' => '2');
	$orderline['TemplateOrderLines']=$data;
	 //echo '<pre>';print_r($orderline); 
//   global $wpdb;
//	$sessionid = $_COOKIE['PHPSESSID'];
//
//	$cartquery = "select * from wp_carts where session_id = '$sessionid'";
//	$cartgetDta = $wpdb->get_results($cartquery, ARRAY_A);
//	$PetInfoParameters=array();
//	$petKey = 0;
//	//echo '<pre>';	print_r($cartgetDta);
//	foreach($cartgetDta as $cartkey){
//		$petname = $cartkey['pet_name'];
//		$pet_weight = $cartkey['pet_weight'];
//		$pet_weight = $cartkey['pet_weight'];
//		if($cartkey['pet_type']==0){
//			$pt = 'Dog';
//		}
//		else{$pt = 'Cat';}
//		
//		
//	}
	

	//$PetInfoParameters[]=$cartpetinfo;
	//echo '<pre>';print_r($PetInfoParameters);die;
	       $params['NewCustomerAdd'] = array('AuthorizeCustomerProfileID' =>23232,
					     'AuthorizePaymentProfileID'=>3323,
					     'CustomerBillToAddress1'=>'350 Treck Drive',
					     'CustomerBillToAddress2'=>23,
					     'CustomerBillToCity'=>'Tukwila',
					     'CustomerBillToState'=>'WA',
					     'CustomerBillToZip'=>'98188',
					     'CustomerCountry'=>'US',
					     'CustomerDesignation'=>'',
					     'CustomerEmail2'=>'',
					     'CustomerFirstName'=>'Russell',
					     'CustomerLastName'=>'Wilson',
					     'CustomerPhone2'=>'',
					     'CustomerPrimaryEmail'=>'don@trump.com',
					     'CustomerPrimaryPhone'=>'555-555-1212',
					     'DeliveryInterval'=>'4',
					     'DeliveryNotes'=>'Front Porch',
					     'FirstRegOrderDeliveryDate'=>'2015-10-30',
					     'InitDeliveryDate'=>'2015-10-15',
					     'InitOrderLines'=>array('InitPartDesc'=>'','InitPartSKU'=>'NSD-BF02','InitQuantity'=>'1'),
                                             'Last4Digits'=>'',
					     'PetInfoParameters'=>array('Age' => '',
									'Birthdate' => '',
									'Birthyear' => '',
									'Breed'=> '',
									'DateModified' => date('Y-m-d'),
									'DatePetExpired' => '',
									'FoodAllergies' => '',
									'MedicalConcerns' => '',
									'PetFirstName' => $petname,
									'PetID' => '',
									'PetLastName' => $shipping_Lname,
									'SYSPROCustomerID' => '',
									'ServiceRelated' => '',
									'Sex' => '',
									'Species' => $pt,
									'TransactionType' => 'A',
									'Weight' => $pet_weight
									),
                                             'ReferralName'=>'fgfg',
                                             'ReferralType'=>'fgfg',
					     'SYSPROCustomerID'=>'',
					     'ShipAddress1'=>'350 Treck Drive',
					     'ShipAddress2'=>'Tukwila',
					     'ShipCity'=>'Tukwila',
					     'ShipDaofWeek'=>'T',
					     'ShipState'=>'WA',
					     'ShipVia'=>'',
					     'ShipZip'=>'98188',
					     'ShippingCosts'=>'',
					     'TaxCode'=>'',
					     'TemplateParameters'=>$orderline,                                         
					     'Warehouse'=>'',
					     'NewInit'=>array('InitPartDesc'=>'','InitPartSKU'=>'NSD-BF02','InitQuantity'=>'1'),
					     'NewTemplate'=>array('TemplatePartDesc'=>'','TemplatePartSKU'=>'NSD-BF02','TemplateQuantity'=>'1'));
//		array_merge($params['NewCustomerAdd'],$PetInfoParameters);   
//echo '<pre>';print_r($params['NewCustomerAdd']);die;

			$wsdlurl = "http://69.164.170.68/Service1.svc?singleWsdl";
		  // No WSDL parameter for location URL
		  $localurl = "http://69.164.170.68/Service1.svc";
	      
		  // Set up client to use SOAP 1.1 and NO CACHE for WSDL. You can choose between
		  // exceptions or status checking. Here we use status checking. Trace is for Debug only
		  // Works better with MS Web Services where
		  // WSDL is split into several files. Will fetch all the WSDL up front.
	      
		  $options = array('exceptions'=>0,'trace'=>1);
		  // WSDL Based calls use a proxy, so this is the best way
		  // to call FAC PG Operations as it creates the methods for you
	      
		  $client = new SoapClient($wsdlurl, $options);
		  $customerData = $client->NewCustAddDC($params);
		  $SYSPROCustomerID =  $customerData->NewCustAddDCResult->SYSPROCustomerID;
		//  mysql_query("UPDATE wp_orders SET SYSPROCustomerID='$SYSPROCustomerID' WHERE session_id = '".$sessionid."'");
	//print_r($customerData);//die;
	
	echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
	
	//die;
  */
	?>
