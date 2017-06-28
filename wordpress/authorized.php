<?php require_once 'authorise/AuthorizeNet.php'; define("AUTHORIZENET_API_LOGIN_ID", "84A6vF9VfMa"); define("AUTHORIZENET_TRANSACTION_KEY", "86H2835qX7BpMxaw"); $request = new AuthorizeNetCIM;
// Create new customer profile

$customerProfile = new AuthorizeNetCustomer; $customerProfile->description = "Description of customer";
$customerProfile->merchantCustomerId= time();
$customerProfile->email = "test@domain.com";
$response = $request->createCustomerProfile($customerProfile);
print_r($response);    die;

if ($response->isOk()) { $customerProfileId = $response->getCustomerProfileId(); }
?>


<?php         	 	 
	$month = 5; 
         $year = 2016;    
         $email = "engg@gmail.com"; 	  
         $ccn = "4111111111111111";   
         $ccv = "123";                  
  	$loginid = "84A6vF9VfMa";      $trankey = "86H2835qX7BpMxaw";   /*sandbox credentials*/    
         require_once('authorise/AuthorizeNet.php');
  			 define("AUTHORIZENET_API_LOGIN_ID", $loginid);
  			 define("AUTHORIZENET_TRANSACTION_KEY", $trankey);
  			 define("AUTHORIZENET_SANDBOX", false);
			 
  			 // Create new customer profile
  			 $request = new AuthorizeNetCIM; 
  			 $customerProfile = new AuthorizeNetCustomer;	
  			 //////////////////get profile and payment profileid//////////
  			 $customerProfile->description = "Online Payment";
  			 $customerProfile->merchantCustomerId = time().rand(1,100);
  			 $customerProfile->email = $email;   //pr($customerProfile);  
  			 // Add payment profile.
  			 $paymentProfile = new AuthorizeNetPaymentProfile;
  			 $paymentProfile->customerType = "individual";
  			 $paymentProfile->payment->creditCard->cardNumber = $ccn;
  			 $paymentProfile->payment->creditCard->expirationDate = $year."-"."02";
  			 $customerProfile->paymentProfiles[] = $paymentProfile;
  			 $paymentProfile->payment->creditCard->cardCode = $ccv;
          //pr($paymentProfile); 
  			 $response = $request->createCustomerProfile($customerProfile);   
         echo "<pre>"; print_r($response); die; //pr($response); //die;
  			 $res=$response->xml->messages->message->text; 	
  			 $success = settype($res[0],'string');
		     if($res=='Successful.')
			   {			  
  			      $data['GeodesicClassified']['customerProfileId']=$response->xml->customerProfileId;
  			      $data['GeodesicClassified']['numericString']=$response->xml->customerPaymentProfileIdList->numericString;			        			        			      			   	     			      			      
  			      $post_url = "https://test.authorize.net/gateway/transact.dll";
  			      //$post_url = "https://secure.authorize.net/gateway/transact.dll";		      
  			      $card_number = $ccn;
  			      $exp_date = $year."-".$month; 	       			       			      			   	     			       
              $amount=10;              	              		      	                          
              $first_name = "sunny";
              $last_name = "sood";
              $address = "chandigarh";
              $state = "chandigarh";
              $zip = "91302";
              $email = $email;
              $card_code = $ccv;
              
              $post_values = array(	
                    "x_login"=>$loginid,
                    "x_tran_key"=>$trankey,"x_version"=>"3.1","x_delim_data"=>"TRUE",
                    "x_delim_char"=> "|","x_relay_response"=>"FALSE","x_type"=>"AUTH_CAPTURE",
                    "x_method"		=> "CC","x_card_num"		=> $card_number,
                    "x_exp_date"		=> $exp_date,"x_amount"		=> $amount,
                    "x_description"		=> "Registration Amount","x_first_name"		=> $first_name,
                    "x_last_name"		=> $last_name,"x_address"		=> $address,
                    "x_state"			=> $state,"x_zip"			=> $zip,
                    "x_email"                   => $email,"x_card_code"=> $card_code);
              
              
	            $post_string = "";
  			      foreach( $post_values as $key => $value )
  				      { $post_string .= "$key=" . urlencode( $value ) . "&"; }
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
  			      $error_code = $response['3'];
  			      $error_msg = $response['4'];
  			      $response_code = $response['1'];
  			      $response_sub_code = $response['2'];  			      
			    }
         
?>