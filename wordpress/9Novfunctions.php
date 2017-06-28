<?php
ob_start();
/**
 * Roots includes
 */
require_once locate_template('/lib/utils.php');           // Utility functions
require_once locate_template('/lib/init.php');            // Initial theme setup and constants
require_once locate_template('/lib/wrapper.php');         // Theme wrapper class
require_once locate_template('/lib/sidebar.php');         // Sidebar class
require_once locate_template('/lib/config.php');          // Configuration
require_once locate_template('/lib/activation.php');      // Theme activation
require_once locate_template('/lib/titles.php');          // Page titles
require_once locate_template('/lib/cleanup.php');         // Cleanup
require_once locate_template('/lib/nav.php');             // Custom nav modifications
require_once locate_template('/lib/gallery.php');         // Custom [gallery] modifications
require_once locate_template('/lib/comments.php');        // Custom comments modifications
require_once locate_template('/lib/relative-urls.php');   // Root relative URLs
require_once locate_template('/lib/widgets.php');         // Sidebars and widgets
require_once locate_template('/lib/scripts.php');         // Scripts and stylesheets
require_once locate_template('/lib/custom.php');          // Custom functions

$session_expiration = time() + 3600 * 24 * 2; // +2 days
session_set_cookie_params($session_expiration);
session_start();
function getStates($sid){
 
     global $wpdb;
     $query = "select * from wp_state_zone where id = '".$sid."'";
     $getDta1 = $wpdb->get_row($query, ARRAY_A);
     return $getDta1;
}
function callSysproApi(){

    global $wpdb;
	$sessionid = $_COOKIE['PHPSESSID'];
	$query = "select orders_table.*,address_table.* from wp_orders as orders_table 
	LEFT JOIN wp_order_address as address_table ON orders_table.session_id = address_table.session_id
	where orders_table.session_id = '$sessionid'";
	$getDta = $wpdb->get_row($query, ARRAY_A);
	//echo '<pre>';print_r($getDta);
    $sid = $getDta['transaction_id'].$getDta['id'];
    
//echo 'here';die;

$id = $getDta['id'];
$order_no = $getDta['order_no'];
$order_detail = unserialize($getDta['order_detail']);
//echo '<pre>';print_r($order_detail);//die;
$session_id = $getDta['session_id'];
$customer_id = $getDta['customer_id'];
$status = $getDta['status'];
$order_date = $getDta['order_date'];
$payment_status = $getDta['payment_status'];
$created_date = $getDta['created_date'];
$customr_profile = $getDta['customr_profile'];
$payment_profile = $getDta['payment_profile'];
$transaction_id = $getDta['transaction_id'];
$total_price = $getDta['total_price'];
$shipping_Fname = $getDta['shipping_Fname'];
$shipping_Lname = $getDta['shipping_Lname'];
$shipping_Email = $getDta['shipping_Email'];
$shipping_Address1 = $getDta['shipping_Address1'];
$shipping_Address2 = $getDta['shipping_Address2'];
$shipping_city = $getDta['shipping_city'];
$shipping_AddrState = getStates($getDta['shipping_state']);
$shipping_state = $shipping_AddrState['stateID'];
$shipping_zipcode = $getDta['shipping_zipcode'];
$shipping_phone_no = $getDta['shipping_phone_no'];
$billing_Fname = $getDta['billing_Fname'];
$billing_Lname = $getDta['billing_Lname'];
$billing_Email = $getDta['billing_Email'];
$billing_Address1 = $getDta['billing_Address1'];
$billing_Address2 = $getDta['billing_Address2'];
$billing_city = $getDta['billing_city'];
$billingAddrState = getStates($getDta['billing_state']);
$billing_state = $billingAddrState['stateID'];
//print_r($billing_state);die;
$billing_zipcode = $getDta['billing_zipcode'];
$billing_phone_no = $getDta['billing_phone_no'];
$promotional_code = $getDta['promotional_code'];
$reffered_by = $getDta['reffered_by'];
$refferal_name = $getDta['refferal_name'];
$cardno = $getDta['cardno'];
$delivery_date = $getDta['delivery_date'];
$template_date = $getDta['template_date'];
$SpecialInstructions = 	$getDta['specialinstructions'];
$dilivery_instruction =	$getDta['dilivery_instruction'];
	$query12 = "select * from wp_carts_final where session_id = '$sessionid'";
	$getDta12 = $wpdb->get_results($query12, ARRAY_A);
	
	
	$query12 = "select * from wp_carts_final where session_id = '$sessionid'";
	$getDta12 = $wpdb->get_results($query12, ARRAY_A);
        //echo "<pre>";
        //print_r($getDta12);
	//print_r($_SESSION);
	//$query = "select orders_table.*,address_table.*,cart_final.* from wp_orders as orders_table 
	//LEFT JOIN wp_order_address as address_table ON orders_table.session_id = address_table.session_id
	//LEFT JOIN wp_carts_final as cart_final ON cart_final.session_id = address_table.session_id
	//where orders_table.session_id = '$sessionid'";
	//$getDta = $wpdb->get_results($query, ARRAY_A);
	//echo '<pre>';//print_r($getDta);die;
	$petKey = 0;
        //echo '<pre>';print_r($getDta12);die;
	foreach($getDta12 as $key){
		$pettype = $key['pet_type'];
		$petcat = $key['category_id'];
		$beef = $key['beef'];
		$chicken = $key['chicken'];
		$duck = $key['duck'];
		$bison = $key['bison'];
		$turkey = $key['turkey'];
        $shipping_frequency = $key['shipping_frequency'];
        
        if($pettype == 0){
          
            $quotient = (int)($shipping_frequency / 4);
            $remainder = $shipping_frequency % 4;
        }else{
            
            $quotient = (int)($shipping_frequency / 3);
            $remainder = $shipping_frequency % 3;
        }
        
		
		$keyData = array_keys($key);
				$i=5;
				//print_r($keyData);
        

					foreach($keyData as $keyvalues){
                        
				
				if($petcat == 3){
					                		
									switch($keyvalues){
                                                                            case "beef":
                                                            if($pettype==0){
                                                                
                                                                             if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){ 
                                                                                $TemplatePartSKU ="NSD-BF02";
										$TemplateQuantity = $beef;
                                                                                $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' =>$TemplateQuantity);
                                        $initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                                
                                                                            }else{
										$TemplatePartSKU ="NSD-BF02";
										$TemplateQuantity = $beef;
                                        $eachFoodforPet = $quotient+$remainder;
										$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
                                        $initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                            }
									}
									
									break;
										   
											case "chicken":
                                                                                    if($pettype==0){        
                                                                                            if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){
                                                                                                $TemplatePartSKU ="NSD-CH02";
												$TemplateQuantity = $chicken;
                                                                                                $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
												$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                                             }else{
												$TemplatePartSKU ="NSD-CH02";
												$TemplateQuantity = $chicken;
                                                                                                $eachFoodforPet = $quotient+$remainder;
												$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
												$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                                            }
                                                                                    }else{
                                                                                        
                                                                                        if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){
                                                                                                $TemplatePartSKU ="NSC-CH02";
												$TemplateQuantity = $chicken;
                                                                                                $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
												$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                                             }else{
												$TemplatePartSKU ="NSC-CH02";
												$TemplateQuantity = $chicken;
                                                                                                $eachFoodforPet = $quotient+$remainder;
												$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
												$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                                            }
                                                                                        
                                                                                        }    
                                                break;
											case "duck":
                                                                                            if($pettype==0){    
                                                                                             if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){
                                                                                                $TemplatePartSKU ="NSD-DK02";
												$TemplateQuantity = $duck;
                                                                                                $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
												$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                                             }else{
												$TemplatePartSKU ="NSD-DK02";
												$TemplateQuantity = $duck;$eachFoodforPet = $quotient;
												$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
												$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                                             }
                                                                                            }else{
                                                                                                 if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){
                                                                                                $TemplatePartSKU ="NSC-DK02";
												$TemplateQuantity = $duck;
                                                                                                $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
												$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                                             }else{
												$TemplatePartSKU ="NSC-DK02";
												$TemplateQuantity = $duck;$eachFoodforPet = $quotient;
												$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
												$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                                             }
                                                                                                }  
                                                break;
											case "turkey":
                                                                                            if($pettype==0){ 
                                                                                              if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){ 
                                                                                               $TemplatePartSKU ="NSD-TK02";
											       $TemplateQuantity = $turkey;
                                                                                               $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' =>$TemplateQuantity);
                                                                                             }else{
                                                                                                $TemplatePartSKU ="NSD-TK02";
												$TemplateQuantity = $turkey;$eachFoodforPet = $quotient;
												$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
                                                                                              }
                                                                                            }else{
                                                                                                 if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){ 
                                                                                               $TemplatePartSKU ="NSC-TK02";
											       $TemplateQuantity = $turkey;
                                                                                               $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' =>$TemplateQuantity);
                                                                                             }else{
                                                                                                $TemplatePartSKU ="NSC-TK02";
												$TemplateQuantity = $turkey;$eachFoodforPet = $quotient;
												$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
                                                                                              }
                                                                                                }  
                                                break;
									}
									
								
						}
					if($petcat == 1){
						switch($keyvalues){
							   case "beef":
                                                            if($beef!=0){
                                                                
                                                                             if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){ 
                                                                                $TemplatePartSKU ="NSD-BF02";
										$TemplateQuantity = $beef;
                                                                                $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' =>$TemplateQuantity);
                                        $initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                                
                                                                            }else{
										$TemplatePartSKU ="NSD-BF02";
										$TemplateQuantity = $beef;
                                        $eachFoodforPet = $quotient+$remainder;
										$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
                                        $initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                            }
									}
									
									break;
								case "chicken":
									if($chicken !=0){
                                                                           
                                                                            if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){
                                                                                $TemplatePartSKU ="NSD-CH02";
										$TemplateQuantity = $chicken;
                                                                                $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' =>$TemplateQuantity);
                                                                         
                                                                            }else{
                                                                            $TemplatePartSKU ="NSD-CH02";
										$TemplateQuantity = $chicken;
                                        $eachFoodforPet = $quotient;
										$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
                                                                            }
                                    }
									break;
								case "duck":
                                                                    if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){
                                                                        $TemplatePartSKU ="NSD-DK02";
									$TemplateQuantity = $duck;
                                                                        $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' =>$TemplateQuantity);
									$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                 
                                                                    }else{
									$TemplatePartSKU ="NSD-DK02";
									$TemplateQuantity = $duck;
                                    $eachFoodforPet = $quotient;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
                                                                	$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                    }
                                    break;
								case "turkey":
                                                                    if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){
									$TemplatePartSKU ="NSD-TK02";
									$TemplateQuantity = $turkey;
                                                                        $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' =>$TemplateQuantity);
									$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                    }else{
                                                                        $TemplatePartSKU ="NSD-TK02";
									$TemplateQuantity = $turkey;
                                    $eachFoodforPet = $quotient;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
									$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                                                  
                                                                        
                                                                    }
                                    break;
								case "bison":
                                    if($bison !=0){
                                         if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){
                                        $TemplatePartSKU ="NSD-BI02";
                                        $TemplateQuantity = $bison;
                                        $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => $TemplateQuantity);
                                        $initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                         }else{
                                        $TemplatePartSKU ="NSD-BI02";
                                        $TemplateQuantity = $bison;
                                        $eachFoodforPet = $quotient;
                                        $data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
                                        $initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                      
                                            
                                         }
                                    }
                                    break;
						}
					}
					if($petcat == 2){
					
					
						switch($keyvalues){
							   case "beef":
									$TemplatePartSKU ="ZLD-BF02";
									$TemplateQuantity = $beef;$eachFoodforPet = $quotient+$remainder;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
									$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                    break;
								case "chicken":
									$TemplatePartSKU ="ZLD-CH02";
									$TemplateQuantity = $chicken;$eachFoodforPet = $quotient;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
									
                                    break;
								case "duck":
									$TemplatePartSKU ="ZLD-DK02";
									$TemplateQuantity = $duck;$eachFoodforPet = $quotient;
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
									$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                    break;
								case "turkey":
									$TemplatePartSKU ="ZLD-TK02";
									$TemplateQuantity = $turkey; $eachFoodforPet = isset($quotient)?$quotient:"";
									$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => $TemplatePartSKU,'TemplateQuantity' => isset($eachFoodforPet)?$eachFoodforPet:$TemplateQuantity);
									$initdata[] =array('InitPartDesc'=>'','InitPartSKU'=>$TemplatePartSKU,'InitQuantity'=>'1');
                                    break;
								
						}
					
				}
				
						
				
					$i++;
				}
							
			
			
	//	$i++;
	
	$petKey++;
	}
	//echo '<pre>';print_r($tempOrderLine);
	
	//$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => 'NSD-BF02','TemplateQuantity' => '7');
	//$data[] =array('TemplatePartDesc' => '','TemplatePartSKU' => 'NSD-CH02','TemplateQuantity' => '2');
	$orderline['TemplateOrderLines']=$data;
	$initorderline['InitOrderLines']=$initdata;	
	$cartquery = "SELECT a.*,b.shipping_price
        FROM wp_carts AS a
        JOIN wp_carts_final AS b ON a.`pet_type` = b.`pet_type`
        AND a.`session_id` = b.`session_id`
        Where a.session_id = '$sessionid'";
	$cartgetDta = $wpdb->get_results($cartquery, ARRAY_A);
	//echo $cartquery;
        $PetInfoParameters=array();
	$petKey = 0;
        //echo '<pre>';
        //print_r($cartgetDta);
	
	foreach($cartgetDta as $cartkey){
		$petname = $cartkey['pet_name'];
		$pet_weight = $cartkey['pet_weight'];
		$pet_weight = $cartkey['pet_weight'];
                
                
		if($cartkey['pet_type']==0){
			$pt = 'Dog';
		}else{$pt = 'Cat';}
$petdata[] =array('DateModified'=>date('Y-M-D'),'PetFirstName'=>$cartkey['pet_name'],'PetID'=>$cartkey['id'],'PetLastName'=>'','ServiceRelated'=>'','Species'=>$pt,'Weight'=>$cartkey['pet_weight'],'shipping_price'=>$cartkey['shipping_price'],'shipping_method'=>$_SESSION['shipping_method']);
                                    
	}
        //echo '<pre>';print_r($petdata);
       //die;
$petdataArray['PetInfoLines']=$petdata;	

       $params['NewCustomerAdd'] = array('AuthorizeCustomerProfileID' =>$customr_profile,
					     'AuthorizePaymentProfileID'=>$payment_profile,
					     'CustomerBillToAddress1'=>$billing_Address1,
					     'CustomerBillToAddress2'=>$billing_Address2,
					     'CustomerBillToCity'=>$billing_city,
					     'CustomerBillToState'=>$billing_state,
					     'CustomerBillToZip'=>$billing_zipcode,
					     'CustomerCountry'=>'US',
					     'CustomerDesignation'=>'',
					     'CustomerEmail2'=>$billing_Email,
					     'CustomerFirstName'=>$billing_Fname,
					     'CustomerLastName'=>$billing_Lname,
					     'CustomerPhone2'=>'',
					     'CustomerPrimaryEmail'=>$billing_Email,
					     'CustomerPrimaryPhone'=>$billing_phone_no,
					     'DeliveryInterval'=>$_SESSION["shipping_weeks"],
					     'DeliveryNotes'=>'',
					     'FirstRegOrderDeliveryDate'=>date('Y-m-d'),
					     'InitDeliveryDate'=>date('Y-m-d'),
					     'InitParameters' => $initorderline,
                         'Last4Digits'=>$cardno,
					     'PetInfoParameters'=>$petdataArray,
                                             'ReferralName'=>$refferal_name,
                                             'ReferralType'=>$reffered_by,
					     'SYSPROCustomerID'=>'',
					     'ShipAddress1'=>$shipping_Address1,
					     'ShipAddress2'=>$shipping_Address2,
					     'ShipCity'=>$shipping_city,
					     'ShipDaofWeek'=>'',
					     'ShipState'=>$shipping_state,
					     'ShipVia'=>'',
					     'ShipZip'=>$shipping_zipcode,
					     'ShippingCosts'=>'',
					     'TaxCode'=>'',
					     'TemplateParameters'=>$orderline,    
					    );
	   
echo '<pre>';print_r($params['NewCustomerAdd']);die;

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
		  mysql_query("UPDATE wp_orders SET SYSPROCustomerID='$SYSPROCustomerID' WHERE session_id = '".$sessionid."'");
	//echo '<pre>';print_r($customerData);
    echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
	
	//die;
    
	$errormsg = $customerData->NewCustAddDCResult->ErrorDescription;
        if($errormsg == 'No Errors'){
            $query = "select * from wp_carts where session_id = '".$sessionid."'";
            $exequery = $wpdb->get_results($query, ARRAY_A);
            //echo '<pre>';print_r($exequery);
           foreach($exequery as $data){
                  $age = '';
                  $Birthdate = '';
                  $Birthyear = '';
                  $Breed = '';
                  $DateModified = '';
                  $DatePetExpired = '';
                  $FoodAllergies = '';
                  $MedicalConcerns = '';
                  $PetFirstName = $data['pet_name'];
                  $PetID = $data['id'];
                  $PetLastName = $data['pet_name'];
                  $SYSPROCustomerID = isset($SYSPROCustomerID)?$SYSPROCustomerID:"";
                  $ServiceRelated = '';
                  $Sex = '';
                  if($data['pet_type'] == 0){$Species="Dog";}else{$Species="Cat";}
                  
                  $TransactionType = '';
                  $Weight = $data['pet_weight'];
           
                  $parameters['petxml'] = array('Age' =>$age,
                                                                                    'Birthdate'=>$Birthdate,
                                                                                    'Birthyear'=>$Birthyear,
                                                                                    'Breed'=>$Breed,
                                                                                    'DateModified'=>$DateModified,
                                                                                    'DatePetExpired'=>$DatePetExpired,
                                                                                    'FoodAllergies'=>$FoodAllergies,
                                                                                    'MedicalConcerns'=>$MedicalConcerns,
                                                                                    'PetFirstName'=>$PetFirstName,
                                                                                    'PetID'=>$PetID,
                                                                                    'PetLastName'=>$PetLastName,
                                                                                    'SYSPROCustomerID'=>$SYSPROCustomerID,
                                                                                    'ServiceRelated'=>$ServiceRelated,
                                                                                    'Sex'=>$Sex,
                                                                                    'Species'=>$Species,
                                                                                    'TransactionType'=>$TransactionType,
                                                                                    'Weight'=>$Weight);
                  
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
                      $petData = $client->PetInfoDC($parameters);
                     // echo '<pre>';print_r($petData);
                    
           }
           return true;
        }
        else{
            echo $errormsg;die;
            return false;
        }
        
	//echo "REQUEST:\n" . $client->__getLastRequest() . "\n";
	
	//die;
	
}