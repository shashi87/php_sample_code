<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

require( '../../../wp-load.php' );
if($_GET['action']=='getPrice'){
   getPrice();
}
if($_GET['action']=='addToCart'){
   addToCart();
}
if($_GET['action']=='getPetweight'){
   getPetweight();
}
if($_GET['action']=='deletePet'){
   deletePet();
}
if($_GET['action']=='changeShipFreq'){
   changeShipFreq();
}
if($_GET['action']=='getStateszip'){
   getStateszip();
}
   $sessionid = $_COOKIE['PHPSESSID'];
   function addToCart(){
      global $wpdb;
      $stored = array();
      $actualprice=0;
      $sessionid = $_COOKIE['PHPSESSID'];
      $pet_type  = trim($_POST['type']);
      $name  = trim($_POST['name']);
      $weight  = trim($_POST['weight']);
      $zipcode  = trim($_POST['zipcode']);
      $_SESSION['zipcode']  = trim($_POST['zipcode']);
      $category_id  = trim($_POST['category']);
      $fun_type  = trim($_POST['fun_type']);
      $sessionid = $_COOKIE['PHPSESSID'];
      $actualprice1;
      if($pet_type==1) $category_id=3;
      else $category_id =$category_id;
      // $_SESSION['items'][] = array( 'type' => $pet_type,'name' => $name,'weight' => $weight,'zipcode' => $zipcode );
      // session_destroy();
      // $_SESSION['items']["petname"] = $name;
      // $_SESSION['items']["weight"] = $weight;
      // $_SESSION['items']["zipcode"] = $zipcode;
      
      if($pet_type != "" && $weight != "" && $zipcode !=""){
	
      //echo $weight;die;
      $qry = "select * from wp_petweight where pet_type = '".$pet_type."' and petweight='".$weight."'";
      $dogResult = $wpdb->get_results($qry, ARRAY_A);
      
      $doglbs = round($dogResult[0]['petlswk']);
      $petlbs = $dogResult[0]['petlswk'];
      $qry = "select * from wp_order_weight where weight =".$doglbs;
      $dogWResult = $wpdb->get_results($qry, ARRAY_A);
      
      $FinalResult = "SELECT wp_order_weight.*, wp_food.* FROM wp_order_weight
      INNER JOIN wp_food ON wp_order_weight.id=wp_food.order_weight_id
      where wp_order_weight.weight = '".$dogWResult[0]['weight']."' AND wp_food.category_id = '".$category_id."'";
      $fetchResult = $wpdb->get_row($FinalResult, ARRAY_A);
     // echo '<pre>';print_r($fetchResult);die;
      $actualbeef = $fetchResult['beef'];
      $actualchicken = $fetchResult['chicken'];
      $actualduck = $fetchResult['duck'];
      $actualturkey = $fetchResult['turkey'];
      $actualbison = $fetchResult['bison'];
      $actualfood = $fetchResult['food'];
      $actualweeks = $fetchResult['weeks'];
      $actualweight = $fetchResult['weight'];
      $actualpet_type = $fetchResult['pet_type'];
      $actualpet_category = $fetchResult['category_id'];
      $getPriceQry = "select * from wp_price where pet_type = '".$pet_type."' and category_id = '".$category_id."'";
      $priceResult = $wpdb->get_results($getPriceQry, ARRAY_A);
      foreach($priceResult as $priceData){
	 //echo '<pre>';print_r($priceData);
	 // if($priceData['category_id']==1){
	 if($priceData['food_type']==0){
	    $beefPrice = $actualbeef * $priceData['price'];
	 }
	 if($priceData['food_type']==1){
	 
	    $chickenPrice = $actualchicken * $priceData['price'];
	 }
	 if($priceData['food_type']==2){
	    $duckPrice = $actualduck * $priceData['price'];
	 }
	 if($priceData['food_type']==3){
	    $turkeyPrice = $actualturkey * $priceData['price'];
	 }
	 if($priceData['food_type']==4){
	    $bisonPrice = $actualbison * $priceData['price'];
	 }
	 $actualprice = $beefPrice + $chickenPrice + $duckPrice + $turkeyPrice + $bisonPrice;
	 
	 //}
	    
      }
      
	$query = "INSERT INTO wp_carts (session_id,pet_type,category_id, pet_name, pet_round_weight,pet_lbs_weight,pet_weight,pet_zip, weeks,      pet_food,beef,chicken,duck,turkey,bison,price  ) VALUES ('$sessionid' ,'$pet_type', '$category_id','$name','$doglbs','$petlbs', '$weight','$zipcode','$actualweeks','$actualfood','$actualbeef','$actualchicken','$actualduck','$actualturkey','$actualbison','$actualprice')";
	$data = mysql_query($query);
	$query = "UPDATE wp_carts SET pet_zip = '$zipcode' WHERE session_id = '".$sessionid."'";
	       mysql_query($query);
	 }	
        if($fun_type == "savecontinue"){
      
	  $sumqry = "SELECT SUM(`pet_lbs_weight`) as sum, pet_type ,pet_zip, category_id FROM wp_carts WHERE `session_id`='".$sessionid."' group by pet_type";
	  
	   $sumresult = $wpdb->get_results($sumqry, ARRAY_A);
	   
	   
	   foreach($sumresult as $SumData)
	   {
	       $beefPrice=0;
	       $chickenPrice=0;
	       $duckPrice=0;
	       $turkeyPrice=0;
	       $bisonPrice=0;
	       
	       // print_r($SumData);
	       $type = $SumData['pet_type'];
	       $pet_zip = $SumData['pet_zip'];
	       $category_id = $SumData['category_id'];
	       $pet_total_weight = round($SumData['sum']);
	       $weightQry = "select * from wp_petweight where pet_type = '".$type."' and petweight='".$pet_total_weight."'";
	    
	    
	    
	       $dogResult = $wpdb->get_row($weightQry, ARRAY_A);
	       $doglbs = round($dogResult['petlswk']);
	       $petlbs = $dogResult['petweight'];
	      // $qry = "select * from wp_order_weight where weight =".$doglbs;
	       $qry = "select * from wp_order_weight where weight ='".round($petlbs)."'";
	       $dogWResult = $wpdb->get_row($qry, ARRAY_A);
	       
	       $FinalResult = "SELECT wp_order_weight.*, wp_food.* FROM wp_order_weight
	       INNER JOIN wp_food ON wp_order_weight.id=wp_food.order_weight_id
	       where wp_order_weight.weight = '".$dogWResult['weight']."' AND wp_food.category_id = '".$category_id."'";
	       $fetchResult = $wpdb->get_row($FinalResult, ARRAY_A);
	       //echo '<pre>';print_r($fetchResult);die;
	       
	       $pet_type = $type;
	       $beef = $fetchResult['beef'];
	       $chicken = $fetchResult['chicken'];
	       $duck = $fetchResult['duck'];
	       $turkey = $fetchResult['turkey'];
	       $bison = $fetchResult['bison'];
	       $food = $fetchResult['food'];
	       $weeks = $fetchResult['weeks'];
	       $weight = $fetchResult['weight'];
	       $category_id = $fetchResult['category_id'];
	      // $id = $row['id'];
	       $getPriceQry = "select * from wp_price where pet_type = '".$pet_type."' and category_id = '".$category_id."'";
	       $priceResult = $wpdb->get_results($getPriceQry, ARRAY_A);
	       foreach($priceResult as $priceData){
		     //echo '<pre>';print_r($priceData);
		    // if($priceData['category_id']==1){
		       if($priceData['food_type']==0){
			      //$beefPrice = $actualbeef * $priceData['price'];
			      $beefPrice = $beef * $priceData['price'];
			    //  echo 'beef'.$beef * $priceData['price'].'<br>';
		       }
		       if($priceData['food_type']==1){
			       
			      //$chickenPrice = $actualchicken * $priceData['price'];
			      $chickenPrice = $chicken * $priceData['price'];
			   //   echo 'ch'.$chicken * $priceData['price'].'<br>';
		       }
		       if($priceData['food_type']==2){
			       //$duckPrice = $actualduck * $priceData['price'];
			       $duckPrice = $duck * $priceData['price'];
			     // echo 'duck'.$duck * $priceData['price'].'<br>';
		       }
		       if($priceData['food_type']==3){
			       //$turkeyPrice = $actualturkey * $priceData['price'];
			       $turkeyPrice = $turkey * $priceData['price'];
			     //  echo 'tur'.$turkey * $priceData['price'].'<br>';
		       }
		       if($priceData['food_type']==4){
			       //$bisonPrice = $actualbison * $priceData['price'];
			       $bisonPrice = $bison * $priceData['price'];
			     // echo 'bis'.$bison * $priceData['price'].'<br>';
		       }
		       $actualprice = $beefPrice + $chickenPrice + $duckPrice + $turkeyPrice + $bisonPrice;
		     // echo 'price'.$actualprice;
		     //}
		      
	       }
	      // echo '<br>price'.$actualprice;

	       //  
	      $finalTableData = "select * from wp_carts_final where session_id = '".$sessionid."' and pet_type = '".$pet_type."'";
	      $finalTableResult = $wpdb->get_row($finalTableData, ARRAY_A);
	      
	      
	      
	      if($finalTableResult){
	       
		 $query = "UPDATE wp_carts_final SET session_id = '$sessionid',pet_type = '$pet_type',category_id = '$category_id', pet_name = '',pet_round_weight = '$doglbs',pet_lbs_weight = '$petlbs', pet_weight = '$pet_total_weight',pet_zip = '$pet_zip',weeks = '$weeks',pet_food = '$food',beef = '$beef', chicken = '$chicken', duck = '$duck',turkey = '$turkey',bison = '$bison',price = '$actualprice'
		  WHERE id = '".$finalTableResult['id']."'";
		  mysql_query($query);
	       }
		else{
		 $query = "INSERT INTO wp_carts_final (session_id,pet_type,category_id, pet_name,pet_round_weight, pet_lbs_weight,pet_weight,pet_zip,weeks,pet_food,beef, chicken, duck,turkey,bison,price	
		  ) VALUES ('$sessionid' ,'$pet_type', '$category_id','', '$doglbs','$petlbs','$pet_total_weight','$zipcode','$weeks', '$food','$beef','$chicken','$duck','$turkey','$bison',$actualprice)";
		  
		  mysql_query($query);
	       }
	       if($pet_type == 0){
		  $_SESSION['dog']['pet_type'] = $pet_type;
		  $_SESSION['dog']['beef'] = $fetchResult['beef'];
		  $_SESSION['dog']['chicken'] = $fetchResult['chicken'];
		  $_SESSION['dog']['duck'] = $fetchResult['duck'];
		  $_SESSION['dog']['turkey'] = $fetchResult['turkey'];
		  $_SESSION['dog']['bison'] = $fetchResult['bison'];
		  $_SESSION['dog']['food'] = $fetchResult['food'];
		  $_SESSION['dog']['weeks'] = $fetchResult['weeks'];
		  $_SESSION['dog']['weight'] = $fetchResult['weight'];
		  //$_SESSION['dog']['pet_type'] = $fetchResult['pet_type'];
		  $_SESSION['dog']['category_id'] = $fetchResult['category_id'];
		  $sumofmeats = ($fetchResult['beef'] + $fetchResult['chicken'] +$fetchResult['duck'] +$fetchResult['turkey'] + $fetchResult['bison']);
		  $_SESSION['dog']['sum_of_meats'] = $sumofmeats;
	       }
	       else{
		  $_SESSION['cat']['pet_type'] = $pet_type;
		  $_SESSION['cat']['beef'] = $fetchResult['beef'];
		  $_SESSION['cat']['chicken'] = $fetchResult['chicken'];
		  $_SESSION['cat']['duck'] = $fetchResult['duck'];
		  $_SESSION['cat']['turkey'] = $fetchResult['turkey'];
		  $_SESSION['cat']['bison'] = $fetchResult['bison'];
		  $_SESSION['cat']['food'] = $fetchResult['food'];
		  $_SESSION['cat']['weeks'] = $fetchResult['weeks'];
		  $_SESSION['cat']['weight'] = $fetchResult['weight'];
		  // $_SESSION['cat']['pet_type'] = $fetchResult['pet_type'];
		  $_SESSION['cat']['category_id'] = $fetchResult['category_id'];
		  $sumofmeats = ($fetchResult['beef'] + $fetchResult['chicken'] +$fetchResult['duck'] +$fetchResult['turkey'] + $fetchResult['bison']);
		  $_SESSION['cat']['sum_of_meats'] = $sumofmeats;
	       }
	       
	       
	    }
	    
	    
	 }
     
	 $qry = "select * from wp_carts where session_id = '".$sessionid."' GROUP BY pet_type";
	 $result = $wpdb->get_results($qry, ARRAY_A);
	 $qry1 = "select * from wp_carts where session_id = '".$sessionid."'";
	 $result1 = $wpdb->get_results($qry1, ARRAY_A);
	 if ( $result )
	 {
	    
	    foreach ( $result1 as $rowData ) { 
		   $resultArr['petData'][] = $rowData;
	    }
	   	
	    if (count($result) > 1) {
	    
	       // output data of each row
	       $resultArr['pettype'] = "multiple";
	      // echo $row["id"];
	       $_SESSION['order_species']=trim("multiple");
	       
	       /*// code for Multi species order shipping frequency*/
	       /*
	       Formula is :
	       Dog 1 food amount -  8.73 lbs/wk
	       Cat 1 food amount - 2.52 lbs/wk
	       Cat 2 food amount - 1.68 lbs/wk
	       Total amount of food per week for all pets:  12.9266 lbs/wk
		
	       Recurring Order calculation:
	       Number of weeks to reach past 20 lbs:  1.54 weeks  (20/12.9266)
	       Rounding up the frequency:  2.0 weeks
	       Rounding the food amount:  25.853 goes to 26 lbs
		
	       Cat food amount = ((2.52+1.68)/12.9266*26)=8.4477 round down to 8 lbs (4 pkgs)
	       Dog food amount = 26-8= 18 lbs (9 pkgs)

	       
	       
	       */

	       $singlepetfood_in_lbs ='';
	       foreach ( $result1 as $singleData ) {
		  if($singleData['pet_type'] == 0){
		    $dogfoodlbs = $singleData['pet_lbs_weight'];
		  }else{
		    $catfoodlbs += $singleData['pet_lbs_weight'];
		  }
	       $singlepetfood_in_lbs += $singleData['pet_lbs_weight'];
		  
	       }
	       $pet_weeks = 20 / $singlepetfood_in_lbs;
	       $round_of_pet_week = ceil($pet_weeks);
	       $food_amount = $singlepetfood_in_lbs * $round_of_pet_week;
	       $round_of_food_amount = round($food_amount);
	       $cat_food_amount = $catfoodlbs/$singlepetfood_in_lbs * $round_of_food_amount;
	       $roundof_cat_food_amount = round($cat_food_amount);
	       $cat_food = round($roundof_cat_food_amount/2);
	       $dog_food = round($food_amount - $roundof_cat_food_amount)/2;
	       
	       
	       
	       
	       $cat_chicken=floor($cat_food/3);
	       $cat_duck=floor($cat_food/3);
	       $cat_turkey=floor($cat_food/3);
	       $cat_ct=$cat_food%3;
	       
	       $dog_beef=floor($dog_food/4);
	       $dog_chicken=floor($dog_food/4);
	       $dog_duck=floor($dog_food/4);
	       $dog_turkey=floor($dog_food/4);
	       $dog_ct=$dog_food%4;
	       
	        for($i=1;$i<=$cat_ct;$i++){
		  if($i==1){
		  $cat_chicken=$cat_chicken+1;
		  }
		  if($i==2){
		  $cat_duck=$cat_duck+1;
		  }
		  if($i==3){
		  $cat_turkey=$cat_turkey+1;
		  }
	       }
	       for($j=1;$j<=$dog_ct;$j++){
		  if($j==1){
		  $dog_beef=$dog_beef+1;
		  }
		  if($j==2){
		  $dog_chicken=$dog_chicken+1;
		  }
		  if($j==3){
		  $dog_duck=$dog_duck+1;
		  }
		  if($j==4){
		  $dog_turkey=$dog_turkey+1;
		  }
		  
	       }
	        
		
	       $cartfinalUpdate = "select * from wp_carts_final where session_id = '".$sessionid."'";
	       $cartfinalUpdata = $wpdb->get_results($cartfinalUpdate, ARRAY_A);
	       foreach($cartfinalUpdata as $cartTableData){
		  if($cartTableData['pet_type'] == 0){
		    $petshipfreq = round($dog_food);
		  }else{
		    $petshipfreq = round($cat_food);
		  }
		  $_SESSION['shippingfreq'] = round($dog_food + $cat_food);
		  $_SESSION["shipping_weeks"] = $round_of_pet_week;
		  $_SESSION["shipping_foodlbs"] = $round_of_food_amount;
		  if($cartTableData['pet_type']==0){
		      $pet_food=floor($dog_food)*2;
      $getPriceQry = "select * from wp_price where pet_type = '0' and category_id = '".$cartTableData['category_id']."'";
      $priceResult = $wpdb->get_results($getPriceQry, ARRAY_A);
      $total_price=0;
      foreach($priceResult as $priceData){
	 //echo '<pre>';print_r($priceData);
	 // if($priceData['category_id']==1){
	 if($priceData['food_type']==0){
	    $beefPrice = $dog_beef * $priceData['price'];
	 }
	 if($priceData['food_type']==1){
	 
	    $chickenPrice = $dog_chicken * $priceData['price'];
	 }
	 if($priceData['food_type']==2){
	    $duckPrice = $dog_duck * $priceData['price'];
	 }
	 if($priceData['food_type']==3){
	    $turkeyPrice = $dog_turkey * $priceData['price'];
	 }
	 
	  $total_price = $beefPrice + $chickenPrice + $duckPrice + $turkeyPrice ;
	 
	 //}
	    
      }   
		//echo $total_price;     
      $query = "UPDATE wp_carts_final SET pet_food='$pet_food',beef='$dog_beef',chicken='$dog_chicken',duck='$dog_duck',turkey='$dog_turkey',shipping_frequency = '$petshipfreq',weeks = '$round_of_pet_week',shipping_weeks = '$round_of_pet_week',price='$total_price' WHERE id = '".$cartTableData['id']."'";
      $query1 = "UPDATE wp_carts SET pet_food='$pet_food',beef='$dog_beef',chicken='$dog_chicken',duck='$dog_duck',turkey='$dog_turkey', price='$total_price' WHERE pet_type='0' and session_id = '".$sessionid."'";
		           
		  }else{
      $pet_food=floor($cat_food)*2;
      $getPriceQry = "select * from wp_price where pet_type = '1' and  category_id = '".$cartTableData['category_id']."'";
      $priceResult = $wpdb->get_results($getPriceQry, ARRAY_A);
      foreach($priceResult as $priceData){
	 //echo '<pre>';print_r($priceData);
	 // if($priceData['category_id']==1){
	
	 if($priceData['food_type']==1){
	 
	    $chickenPrice = $cat_chicken * $priceData['price'];
	 }
	 if($priceData['food_type']==2){
	    $duckPrice = $cat_duck * $priceData['price'];
	 }
	 if($priceData['food_type']==3){
	    $turkeyPrice = $cat_turkey * $priceData['price'];
	 }
	 
	 $actualprice1= $chickenPrice + $duckPrice + $turkeyPrice;
	 
	 //}
	    
      }     
		     
		    
		  $query = "UPDATE wp_carts_final SET pet_food='$pet_food',beef='0',chicken='$cat_chicken',duck='$cat_duck',turkey='$cat_turkey',shipping_frequency = '$petshipfreq',shipping_weeks = '$round_of_pet_week', price='$actualprice1' WHERE id = '".$cartTableData['id']."'";
		 
		  $query1 = "UPDATE wp_carts SET pet_food='$pet_food',beef='0',chicken='$cat_chicken',duck='$cat_duck',turkey='$cat_turkey' ,price='$actualprice1' WHERE pet_type='1' and session_id = '".$sessionid."'";
		
		 
		  }
		  
		 
		  mysql_query($query1);
		  
		  mysql_query($query);
		  
		  
		 }
	       
	       
	       
	       
	       
		  
	       /*// end code for Multi species order shipping frequency*/
	    }
	    else {
	       foreach ( $result as $row ) { 
		  if($row["pet_type"] == '0') {
		      $resultArr['pettype'] =  "dog";
		      //echo $row["id"];
		      $_SESSION['order_species']=trim("dog");
		     }
		  if($row["pet_type"] == '1') {
			$resultArr['pettype'] = "cat";
			//echo $row["id"];
			$_SESSION['order_species']=trim("cat");
		     }
	       }
	    }
	    
	     /************  //Shipping  Calculation******************/
	    $qry = "select * from wp_carts_final where session_id = '".$sessionid."'";
	    $result = $wpdb->get_results($qry, ARRAY_A);
	    $dogfood = 0;
	    $catfood = 0;
	    foreach ( $result as $row ) {
	      // echo 'here';
	       $pet_food = $row['pet_food'];
	       $pet_type = $row['pet_type'];
	       $category_id = $row['category_id'];
	       $zipcode = $row['pet_zip'];
	        $nowFinal = "SELECT ziptable.*, statetable.*, zonetable.*,shipping_method.*
	       FROM wp_zip_codes as ziptable
	       INNER JOIN wp_state_zone as statetable ON ziptable.state = statetable.stateID
	       INNER JOIN wp_zone_rates as zonetable ON statetable.zoneID = zonetable.zoneid and zonetable.shipmethod = ziptable.shipmethod
	       INNER JOIN wp_shipping_methods as shipping_method ON shipping_method.id=zonetable.shipmethod
	       where ziptable.zipcode = '".$zipcode."'";
	      // echo '<br>';
	       $finalResult = $wpdb->get_row($nowFinal, ARRAY_A);
	      // echo 'mc'.$finalResult['materialcharge'] .'<br>';
	      // echo 'ship_values'.$finalResult['ship_values'] .'<br>';
	      // echo 'food'.$pet_food .'<br>';
	      
	      
	      
	      $_SESSION['shipping_method']=$finalResult['method'];
	      if($finalResult['ship_values'] != 0){
		  if (count($result)>1) {
		  $shipping=$finalResult['materialcharge']/2;
		  $totalShipPrice =$shipping+ $finalResult['ship_values'] * $pet_food;
		 }else{
		  $totalShipPrice = $finalResult['materialcharge'] + $finalResult['ship_values'] * $pet_food;
		 }
	      }else{
	       $totalShipPrice = 0;
	      }
	      
	       $query = "UPDATE wp_carts_final SET shipping_price = '$totalShipPrice' WHERE id = '".$row['id']."'";
	       mysql_query($query);
	       $_SESSION["shipment_price"] = $totalShipPrice;
	//        echo "food=====".$pet_food;
	//	echo "ship values====".$finalResult['ship_values'];
	//	echo "material====".$finalResult['materialcharge'];
	//	echo "zip code=====".$zipcode."=======";
	//	echo "price====".$_SESSION["shipment_price"];
	//	
	    }

	     /************ End Shipping  Calculation******************/
	     
	     echo( json_encode($resultArr));
	 }
	 else{
	 
	    echo "no record found";
	 }
     
   }
   function getPrice(){
      global $wpdb;
      $sessionid = $_COOKIE['PHPSESSID'];
      //       $qry = "select * from wp_carts where session_id = '".$sessionid."'";
      //       $result = $wpdb->get_results($qry, ARRAY_A);
      //       //echo '<pre>';print_r($result);
      //       foreach ( $result as $row ) {
      //	       if($row['pet_type']==0){
      //		       $dogweight += $row['pet_weight'];
      //	       }else{
      //		       $catweight += $row['pet_weight'];
      //	       }
      //       }
      $beef = $_POST['beef'];
      $chicken = $_POST['chicken'];
      $duck = $_POST['duck'];
      $turkey = $_POST['turkey'];
      $bison = $_POST['bison'];
      $category = $_POST['category'];
      $pet_type = $_POST['pet_type'];
      $id = $_POST['id'];
      $sumoffood = $_POST['sumoffood'];
      $getPriceQry = "select * from wp_price where pet_type = '".$pet_type."' and category_id = '".$category."'";
      $result = $wpdb->get_results($getPriceQry, ARRAY_A);
      foreach($result as $priceData){
	 if($priceData['food_type']==0){
	    $beefPrice = $beef * $priceData['price'];
	 }
	 if($priceData['food_type']==1){
	    $chickenPrice = $chicken * $priceData['price'];
	 }
	 if($priceData['food_type']==2){
	    $duckPrice = $duck * $priceData['price'];
	 }
	 if($priceData['food_type']==3){
	    $turkeyPrice = $turkey * $priceData['price'];
	 }
	 if($priceData['food_type']==4){
	    $bisonPrice = $bison * $priceData['price'];
	 }
	 if($priceData['pet_type'] == 0){
	    $price = $beefPrice + $chickenPrice + $duckPrice + $turkeyPrice + $bisonPrice;
	 }
	 else{
	    $price =  $chickenPrice + $duckPrice + $turkeyPrice;
	 }
      }
      $query = "UPDATE wp_carts_final SET beef='$beef',chicken='$chicken',duck='$duck',turkey='$turkey',bison='$bison',price='$price',pet_round_weight='$sumoffood' WHERE id = '".$id."'";
      
      mysql_query($query);
      if($query){
	 $priceqry = "select sum(price) as price from wp_carts_final where session_id = '".$sessionid."'";
	 $priceResult = $wpdb->get_row($priceqry, ARRAY_A);
	 $qry = "select * from wp_carts_final where session_id = '".$sessionid."' and id = '".$id."' and pet_type = '".$pet_type."'";
	 
	 $result = $wpdb->get_row($qry, ARRAY_A);
	 if ( $result )
	 {
	    $jasonData['pet_round_weight'] = $result['pet_round_weight'];
	    $jasonData['specices_price'] = $result['price'];
	    $jasonData['price'] = $priceResult['price'];
	    $jasonData['pet_type'] = $result['pet_type'];
	    $jasonData['beef'] = $result['beef'];
	    $jasonData['chicken'] = $result['chicken'];
	    $jasonData['duck'] = $result['duck'];
	    $jasonData['turkey'] = $result['turkey'];
	    $jasonData['bison'] = $result['bison'];
	    $qrydata = "select * from wp_carts_final where session_id = '".$sessionid."'";
	    $getData = $wpdb->get_results($qrydata, ARRAY_A);
	    foreach( $getData as $dta){
	       $jasonData['petData'][] = $dta;
	       if($dta["pet_type"] == '0') { $jasonData['specices_dog'] = "dog"; }
	       if($dta["pet_type"] == '1') { $jasonData['specices_cat'] = "cat"; }
	    
	    }
	 //$jasonData['count'] = $count;
	 
	 }
      }
      // echo 'here';die;
      $output = json_encode($jasonData);
      echo $output;
      die;
   }
   function getPetweight(){
      global $wpdb;
      $pet_type = $_POST['pettype'];
      $qry = "select * from wp_petweight where pet_type = '".$pet_type."'";
      $result = $wpdb->get_results($qry, ARRAY_A);
      $data = '<option value="">Select Weight...</option>';
      foreach ( $result as $row )  { 
	 $data .= '<option value="'.$row['petweight'].'">'.$row['petweight'].'</option>';
      }
      echo $data;
   }
   function deletePet(){
      $sessionid = $_COOKIE['PHPSESSID'];
      
      global $wpdb;
      $id = $_POST['id'];
      $pettype = $_POST['pettype'];
      $category_id = $_POST['category_id'];
     // echo "delete from wp_carts where id ='".$id."'";die;
      $delRecord = mysql_query("delete from wp_carts where id ='".$id."'");
      $finalTableData = "select * from wp_carts_final where session_id = '".$sessionid."' and pet_type = '".$pettype."' and category_id = '".$category_id."'";
      $finalTableResult = $wpdb->get_row($finalTableData, ARRAY_A);
      if($finalTableResult){
       $qry1 = "delete from wp_carts_final where session_id = '".$sessionid."' and pet_type = '".$pettype."' and category_id = '".$category_id."'";
       $result1 = $wpdb->get_results($qry1, ARRAY_A);

       }
     
	  $sumqry = "SELECT SUM(`pet_weight`) as sum, pet_type , category_id FROM wp_carts WHERE `session_id`='".$sessionid."' group by pet_type";
	   
	   $sumresult = $wpdb->get_results($sumqry, ARRAY_A);
	   if($sumresult){
	   foreach($sumresult as $SumData)
	   {
	     
	       // print_r($SumData);
	       $type = $SumData['pet_type'];
	       $category_id = $SumData['category_id'];
	       $pet_total_weight = $SumData['sum'];
	       $weightQry = "select * from wp_petweight where pet_type = '".$type."' and petweight='".$pet_total_weight."'";
	    
	    
	    
	       $dogResult = $wpdb->get_row($weightQry, ARRAY_A);
	       $doglbs = round($dogResult['petlswk']);
	       $qry = "select * from wp_order_weight where weight =".$doglbs;
	       $dogWResult = $wpdb->get_row($qry, ARRAY_A);
	       
	       $FinalResult = "SELECT wp_order_weight.*, wp_food.* FROM wp_order_weight
	       INNER JOIN wp_food ON wp_order_weight.id=wp_food.order_weight_id
	       where wp_order_weight.weight = '".$dogWResult['weight']."' AND wp_food.category_id = '".$category_id."'";
	       $fetchResult = $wpdb->get_row($FinalResult, ARRAY_A);
	      // echo '<pre>';print_r($fetchResult);die;
	       
	       $pet_type = $type;
	       $beef = $fetchResult['beef'];
	       $chicken = $fetchResult['chicken'];
	       $duck = $fetchResult['duck'];
	       $turkey = $fetchResult['turkey'];
	       $bison = $fetchResult['bison'];
	       $food = $fetchResult['food'];
	       $weeks = $fetchResult['weeks'];
	       $weight = $fetchResult['weight'];
	       $category_id = $fetchResult['category_id'];
	      // $id = $row['id'];
	       $getPriceQry = "select * from wp_price where pet_type = '".$pet_type."' and category_id = '".$category_id."'";
	       $priceResult = $wpdb->get_results($getPriceQry, ARRAY_A);
	       
	       foreach($priceResult as $priceData){
		     //echo '<pre>';print_r($priceData);
		    // if($priceData['category_id']==1){
		       if($priceData['food_type']==0){
			      $beefPrice = $actualbeef * $priceData['price'];
		       }
		       if($priceData['food_type']==1){
			       
			      $chickenPrice = $actualchicken * $priceData['price'];
		       }
		       if($priceData['food_type']==2){
			       $duckPrice = $actualduck * $priceData['price'];
		       }
		       if($priceData['food_type']==3){
			       $turkeyPrice = $actualturkey * $priceData['price'];
		       }
		       if($priceData['food_type']==4){
			       $bisonPrice = $actualbison * $priceData['price'];
		       }
		       $actualprice = $beefPrice + $chickenPrice + $duckPrice + $turkeyPrice + $bisonPrice;
		      
		     //}
		      
	       }
	      
	       
	       //  
	      

	       if($pet_type == 0){
		  $_SESSION['dog']['pet_type'] = $pet_type;
		  $_SESSION['dog']['beef'] = $fetchResult['beef'];
		  $_SESSION['dog']['chicken'] = $fetchResult['chicken'];
		  $_SESSION['dog']['duck'] = $fetchResult['duck'];
		  $_SESSION['dog']['turkey'] = $fetchResult['turkey'];
		  $_SESSION['dog']['bison'] = $fetchResult['bison'];
		  $_SESSION['dog']['food'] = $fetchResult['food'];
		  $_SESSION['dog']['weeks'] = $fetchResult['weeks'];
		  $_SESSION['dog']['weight'] = $fetchResult['weight'];
		  //$_SESSION['dog']['pet_type'] = $fetchResult['pet_type'];
		  $_SESSION['dog']['category_id'] = $fetchResult['category_id'];
		  $sumofmeats = ($fetchResult['beef'] + $fetchResult['chicken'] +$fetchResult['duck'] +$fetchResult['turkey'] + $fetchResult['bison']);
		  $_SESSION['dog']['sum_of_meats'] = $sumofmeats;
	       }
	       else{
		  $_SESSION['cat']['pet_type'] = $pet_type;
		  $_SESSION['cat']['beef'] = $fetchResult['beef'];
		  $_SESSION['cat']['chicken'] = $fetchResult['chicken'];
		  $_SESSION['cat']['duck'] = $fetchResult['duck'];
		  $_SESSION['cat']['turkey'] = $fetchResult['turkey'];
		  $_SESSION['cat']['bison'] = $fetchResult['bison'];
		  $_SESSION['cat']['food'] = $fetchResult['food'];
		  $_SESSION['cat']['weeks'] = $fetchResult['weeks'];
		  $_SESSION['cat']['weight'] = $fetchResult['weight'];
		  // $_SESSION['cat']['pet_type'] = $fetchResult['pet_type'];
		  $_SESSION['cat']['category_id'] = $fetchResult['category_id'];
		  $sumofmeats = ($fetchResult['beef'] + $fetchResult['chicken'] +$fetchResult['duck'] +$fetchResult['turkey'] + $fetchResult['bison']);
		  $_SESSION['cat']['sum_of_meats'] = $sumofmeats;
	       }
	       
	       
	    }
	   
	// }
	    }
	    
	 $qry = "select * from wp_carts where session_id = '".$sessionid."'";
	 $result = $wpdb->get_results($qry, ARRAY_A);
	//echo '<pre>'; print_r($result);die;
	//$resultArr['petData'] =array();
	 if ( $result )
	 {
	    foreach($result as $r){
		//echo '<pre>';	print_r($r);
	       $resultArr[] = $r;
	    }
	    echo( json_encode($resultArr));	
	 }
	 else{
	 
	    echo "0";
	    $qry1 = "delete from wp_carts_final where session_id = '".$sessionid."'";
	    $result1 = $wpdb->get_results($qry1, ARRAY_A);
	    $qry2 = "delete from wp_orders where session_id = '".$sessionid."'";
	    $result2 = $wpdb->get_results($qry2, ARRAY_A);
	    $qry3 = "delete from wp_order_address where session_id = '".$sessionid."'";
	    $result3 = $wpdb->get_results($qry3, ARRAY_A);

	    unset($_SESSION['cat']);
	    unset($_SESSION['dog']);
	 }
     
}

   function changeShipFreq(){
      global $wpdb;
      $id = $_POST['id'];
      $weeks = $_POST['weeks'];
      $_SESSION['shipping_weeks'] = $weeks;
      //$q = "update wp_carts_final SET weeks = '$weeks' where id = '".$id."'";
      //$qry = mysql_query($q);
      die;

   }
   function getStateszip(){
      global $wpdb;
      $stateid = $_POST['state'];
      $zipcode = $_POST['zipcode'];
      $getstatecode = "select * from wp_state_zone where id = '".$stateid."'";
      $result = $wpdb->get_row($getstatecode, ARRAY_A);
     $q = "select * from wp_zip_codes where zipcode = '".$zipcode."' and state = '".$result['stateID']."'";
      $qry = $wpdb->get_row($q, ARRAY_A);
      if($qry){echo '1';}else{echo '0';}
      //echo(json_encode($qry));
      die;

   } 
   
?>
 
