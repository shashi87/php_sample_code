<?php
/*
Template Name: Flow step 2
*/
?>
<?php //get_header(); ?>

<?php //get_template_part('templates/content', 'page'); ?>
<?php
  print_r($_SESSION);
  $sessionid = $_COOKIE['PHPSESSID'];  
  if(isset($_SESSION) && !empty($_SESSION['intro_cost']))
  {
	$introcost = $_SESSION['intro_cost'];
  }else{
	$introcost = "14.95";
  }
	  

     $qry = "select * from wp_carts where session_id = '".$sessionid."'";
     $result = $wpdb->get_results($qry, ARRAY_A);
     $i=1;
     $total= 0;
     $dogweight = 0;
     foreach ( $result as $row ) {
	  $natural_actualprice =0;
	  //echo $i;
	// echo '<pre>'; print_r($row);
	$dogweight = $row['pet_weight'];
	 if($pet_type == 0){
	  $weightqry = "select sum(pet_weight) as weight from wp_carts where session_id = '".$sessionid."' and pet_type=0 ";
	  $weightresult = $wpdb->get_row($weightqry, ARRAY_A);
	 
	 }else{
	   $weightqry = "select sum(pet_weight) as weight from wp_carts where session_id = '".$sessionid."' and pet_type=1 ";
	   $weightresult = $wpdb->get_row($weightqry, ARRAY_A);
	
	 }
	//  echo $dogweight;
	  $pet_type = $row['pet_type'];
	  $category_id = $row['category_id'];
	  
	  $qry = "select * from wp_petweight where pet_type = '".$pet_type."' and petweight='".$dogweight."'";
	  $dogResult = $wpdb->get_results($qry, ARRAY_A);
	  
	  $doglbs = round($dogResult[0]['petlswk']);
	  $qry = "select * from wp_order_weight where weight =".$doglbs;
	  $dogWResult = $wpdb->get_results($qry, ARRAY_A);
	  
	  $FinalResult = "SELECT wp_order_weight.*, wp_food.* FROM wp_order_weight
	  INNER JOIN wp_food ON wp_order_weight.id=wp_food.order_weight_id
	  where wp_order_weight.weight = '".$dogWResult[0]['weight']."' AND wp_food.category_id = '".$category_id."'";
	  $fetchResult = $wpdb->get_row($FinalResult, ARRAY_A);
	  //echo '<pre>';print_r($fetchResult);
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
	  $id = $row['id'];
	  
	  
	  $pet_type = $row['pet_type'];
	  $pet_category = $row['category_id'];
	  if(isset($_SESSION) && (($_SESSION['order_species'] == 'dog') || ($_SESSION['order_species'] == 'multiple'))){
	  //echo 'jh';
	 if($pet_type == 0 ) {
		//echo 'here';
	       $getPriceQry = "select * from wp_price where pet_type = '".$pet_type."' and (category_id = '1' or category_id = '2')";
		  $priceResult = $wpdb->get_results($getPriceQry, ARRAY_A);
		  
		  foreach($priceResult as $priceData){
			//echo '<pre>';print_r($priceData);
			if($priceData['category_id']==1){
			  if($priceData['food_type']==0){
				 $natural_beefPrice = $actualbeef * $priceData['price'];
			  }
			  if($priceData['food_type']==1){
				  
				 $natural_chickenPrice = $actualchicken * $priceData['price'];
			  }
			  if($priceData['food_type']==2){
				  $natural_duckPrice = $actualduck * $priceData['price'];
			  }
			  if($priceData['food_type']==3){
				  $natural_turkeyPrice = $actualturkey * $priceData['price'];
			  }
			  if($priceData['food_type']==4){
				  $natural_bisonPrice = $actualbison * $priceData['price'];
			  }
			  $natural_actualprice = $natural_beefPrice + $natural_chickenPrice + $natural_duckPrice + $natural_turkeyPrice + $natural_bisonPrice;
			 
			}
			else{
			  if($priceData['food_type']==0){
				 $zoo_beefPrice = $actualbeef * $priceData['price'];
			  }
			  if($priceData['food_type']==1){
				  $zoo_chickenPrice = $actualchicken * $priceData['price'];
			  }
			  if($priceData['food_type']==2){
				  $zoo_duckPrice = $actualduck * $priceData['price'];
			  }
			  if($priceData['food_type']==3){
				  $zoo_turkeyPrice = $actualturkey * $priceData['price'];
			  }
			  if($priceData['food_type']==4){
				  $zoo_bisonPrice = $actualbison * $priceData['price'];
			  }
			  $zoo_actualprice = $zoo_beefPrice + $zoo_chickenPrice + $zoo_duckPrice + $zoo_turkeyPrice + $zoo_bisonPrice;
			}
			  
			 
		  }
		}
	  }
	  else{
		//echo 'here2';
	       $getPriceQry = "select * from wp_price where pet_type = '".$pet_type."' and category_id = '3'";
		   $priceResult = $wpdb->get_results($getPriceQry, ARRAY_A);
		  
		  foreach($priceResult as $priceData){
		   
			  if($priceData['food_type']==1){
				  
				 $cat_chickenPrice = $actualchicken * $priceData['price'];
			  }
			  if($priceData['food_type']==2){
				  $cat_duckPrice = $actualduck * $priceData['price'];
			  }
			  if($priceData['food_type']==3){
				  $cat_turkeyPrice = $actualturkey * $priceData['price'];
			  }
			  
		 
			  $cat_actualprice =  $cat_chickenPrice + $cat_duckPrice + $cat_turkeyPrice ;
			  }
	  }
	  
//echo $natural_actualprice;echo '---';
	  $total +=round($actualprice,2);
	  $natural_total +=round($natural_actualprice,2);
	  $zoo_total +=round($zoo_actualprice,2);
	  $cat_total +=round($cat_actualprice,2);
	  
	  
	  
	  //echo $i.'---'.round($actualprice,2).'--------'.$total.'<br>';
	  $total_plus_shipping = $total + $_SESSION['shipment_price'];
	  $i++;
	  $query = "UPDATE wp_carts SET weeks= '$actualweeks', pet_food= '$actualfood', beef='$actualbeef',chicken='$actualchicken',duck='$actualduck',turkey='$actualturkey',bison='$actualbison',price='$actualprice' WHERE id = '".$id."'";
	  mysql_query($query);
     
     
     }

     /*<!-------- calculation for shipping ---------->*/
     
     $qry = "select * from wp_carts where session_id = '".$sessionid."'";
     $result = $wpdb->get_results($qry, ARRAY_A);
     $totalShipPrice =0;
     $dogfood = 0;
     $catfood = 0;
     foreach ( $result as $row ) {
	  //print_r($row);
	  $pet_food = $row['pet_food'];
	  if($pet_type == 0){
	       $dogfood += $pet_food;
	  }
	  else{
	       $catfood += $pet_food;
	  }
     }
     $zipcode = $result[0]['pet_zip'];
    
    
     $nowFinal = "SELECT ziptable.*, statetable.*, zonetable.*
     FROM wp_zip_codes as ziptable
     INNER JOIN wp_state_zone as statetable ON ziptable.state = statetable.stateID
     INNER JOIN wp_zone_rates as zonetable ON statetable.zoneID = zonetable.zoneid and zonetable.shipmethod = ziptable.shipmethod 
     where ziptable.zipcode = '".$zipcode."'";
     $finalResult = $wpdb->get_row($nowFinal, ARRAY_A);
     //echo '<pre>';print_r($finalResult);
     if($_SESSION['order_species'] == "dog")
     {
	 //echo $dogfood;
	  $totalShipPrice = $finalResult['materialcharge'] + $finalResult['ship_values'] * $_SESSION['food'];
	  
     }
     elseif($_SESSION['order_species'] == "multiple")
     {
	  $totalShipPrice = $finalResult['materialcharge'] + ($finalResult['ship_values'] * $_SESSION['food'] ) + ($finalResult['ship_values'] * $catfood);
	  
     }
     else{
	  $totalShipPrice = $finalResult['materialcharge'] + $finalResult['ship_values'] * $catfood;
     }
    $_SESSION["shipment_price"] = $totalShipPrice;
 
     /*<!--------- calculation for shipping --------->*/



?>
<div style="display:none;" id="pettypeid"><?php echo $_SESSION['order_species']; ?></div>
<div class="section-8">
<div class="container">
     
     <div class="flow-outer">
     <div class="col-xs-8">

     <div class="left-col-st">
 
          <div class="steps">
	       <ul>
		    <li class="complete">1 About Your Pets</li>      
		    <li class="current">2 Select Product</li>
		    <li>3 Select Meats</li>
	       </ul>
          </div>
          <?php
			  if(($_SESSION['order_species'] == 'dog') || ($_SESSION['order_species'] == 'multiple')){
				$weightqry = "select sum(pet_weight) as weight from wp_carts where session_id = '".$sessionid."' and pet_type=0 ";
				$weightresult = $wpdb->get_row($weightqry, ARRAY_A);
			   // echo $weightresult['weight'];
			   }else{
				 $weightqry = "select sum(pet_weight) as weight from wp_carts where session_id = '".$sessionid."' and pet_type=1 ";
				 $weightresult = $wpdb->get_row($weightqry, ARRAY_A);
			  
			   }
		  ?>
     	
          <div class="heading-top">
          <h2>Step 2 - Select Dog Food Product</h2>
          <p>We recommend a <?php echo $_SESSION['food'];?> lb. package, which will feed your dogs for <?php echo $_SESSION['weeks'];?> weeks</p>
          </div>
          <form action="/step-3a" method="post" id="step2Form">    
     
          <div class="cart-bg">
               <!-- Table-info For Dektop View --> 
               <div class="table-info hide_mobile1">     
               <div class="column-1">
               <ul>
               <li class="heading">
               <div class="outer-bg">
               <div class="inner-bg">Price includes shipping &amp; sales tax</div>
               </div>
               </li>
               
               <li class="first">
               <div class="outer-bg">
               <div class="inner-bg">Meats</div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg">Vegetables</div>
               </div>
               </li>
               
               <li class="second">
               <div class="outer-bg">
               <div class="inner-bg">High protein, low fat formula <br/> (75% meat, 25% vegetables)</div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg">Grain-free</div>
               </div>
               </li>
               
               <li>
               <div class="outer-bg">
               <div class="inner-bg">Complete, nutritionally-balanced</div>
               </div>
               </li>
               </ul>
               </div>
               <div id="dogfood_category">
				<div class="column-2 active">
               <ul>
               <li class="heading">
		    <div class="outer-bg">
		    <div class="inner-bg">
			 <?php
			echo $natural_total.'---'.$_SESSION['shipment_price'];
			 $tot = $natural_total + $_SESSION['shipment_price'];?>
			 <p><span>Natural Selections</span><br/><?php echo '$'.$tot; ?></p>
		    </div>
		    </div>
               </li>
               
               <li class="first">
               <div class="outer-bg">
               <div class="inner-bg">Pasture-raised, cage-free Antibiotic-free</div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg">Organic</div>
               </div>
               </li>
               
               <li class="second">
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li>
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="check">
               <div class="outer-bg">
               <div class="inner-bg"><input name="recurring_order" type="radio" id="recurring_order" value="127.40" checked="checked"></div>
               </div>
               </li>
               </ul>
               </div>
               
               
               <div class="column-3">
               <ul>
               <li class="heading">
               <div class="outer-bg">
               <div class="inner-bg">
                  <?php $total2 = $zoo_total + $_SESSION['shipment_price'];?>
               <p><span>Zoologics</span><br/><?php echo '$'.$total2; ?></p>
               </div>
               </div>
               </li>
               
               <li class="first">
               <div class="outer-bg">
               <div class="inner-bg">Conventionally-raised Occasional antibiotics  may be used</div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg">Conventional</div>
               </div>
               </li>
               
               <li class="second">
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li>
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="check">
               <div class="outer-bg">
               <div class="inner-bg"><input name="recurring_order" id="recurring_order" type="radio" value="102.50"></div>
               </div>
               </li>
               </ul>
               </div>
				
				
				
			   </div>
               <div id="catfood_category">
				
				
			<div class="column-4 active">
               <ul>
               <li class="heading">
		    <div class="outer-bg">
		    <div class="inner-bg">
			 <?php $total3 = $cat_total + $_SESSION['shipment_price'];?>
               <p><span>Cat only</span><br/><?php echo '$'.$total3; ?></p>
		    </div>
		    </div>
               </li>
               
               <li class="first">
               <div class="outer-bg">
               <div class="inner-bg">Pasture-raised, cage-free Antibiotic-free</div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg">Organic</div>
               </div>
               </li>
               
               <li class="second">
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li>
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="check">
               <div class="outer-bg">
               <div class="inner-bg"><input name="recurring_order" type="radio" value="" checked="checked"></div>
               </div>
               </li>
               </ul>
               </div>
				
				
				
			   </div>
               
               </div>
               
               
               
               <!-- Table-info For Mobile View -->  
               <div class="table-info show_mobile1">
               <div class="table-row">
               <div class="column-1">
               <ul>
               <li class="heading">
               <div class="outer-bg">
               <div class="inner-bg">Price includes shipping &amp; sales tax</div>
               </div>
               </li>
               
               <li class="first">
               <div class="outer-bg">
               <div class="inner-bg">Meats</div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg">Vegetables</div>
               </div>
               </li>
               
               <li class="second">
               <div class="outer-bg">
               <div class="inner-bg">High protein, low fat formula <br/> (75% meat, 25% vegetables)</div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg">Grain-free</div>
               </div>
               </li>
               
               <li>
               <div class="outer-bg">
               <div class="inner-bg">Complete, nutritionally-balanced</div>
               </div>
               </li>
               </ul>
               </div>
               
               <div class="column-2 active">
               <ul>
               <li class="heading">
               <div class="outer-bg">
               <div class="inner-bg">
               <p><span>Natural Selections</span><br/>$127.40</p>
               </div>
               </div>
               </li>
               
               <li class="first">
               <div class="outer-bg">
               <div class="inner-bg">Pasture-raised, cage-free Antibiotic-free</div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg">Organic</div>
               </div>
               </li>
               
               <li class="second">
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li>
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="check">
               <div class="outer-bg">
               <div class="inner-bg"><input name="" type="radio" value="" checked="checked"></div>
               </div>
               </li>
               </ul>
               </div>
               </div>
               
               
               <div class="table-row">
               <div class="column-1">
               <ul>
               <li class="heading">
               <div class="outer-bg">
               <div class="inner-bg">Price includes shipping &amp; sales tax</div>
               </div>
               </li>
               
               <li class="first">
               <div class="outer-bg">
               <div class="inner-bg">Meats</div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg">Vegetables</div>
               </div>
               </li>
               
               <li class="second">
               <div class="outer-bg">
               <div class="inner-bg">High protein, low fat formula <br/> (75% meat, 25% vegetables)</div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg">Grain-free</div>
               </div>
               </li>
               
               <li>
               <div class="outer-bg">
               <div class="inner-bg">Complete, nutritionally-balanced</div>
               </div>
               </li>
               </ul>
               </div>
               
               <div class="column-3">
               <ul>
               <li class="heading">
               <div class="outer-bg">
               <div class="inner-bg">
			      <?php $total2 = $cat_total + $_SESSION['shipment_price'];?>
               <p><span>Zoologics</span><br/><?php echo '$'.$total2; ?></p>
            
               </div>
               </div>
               </li>
               
               <li class="first">
               <div class="outer-bg">
               <div class="inner-bg">Conventionally-raised Occasional antibiotics  may be used</div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg">Conventional</div>
               </div>
               </li>
               
               <li class="second">
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li>
               <div class="outer-bg">
               <div class="inner-bg"><img src="http://darwinspet.3mwdev.com/wordpress/wp-content/uploads/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="check">
               <div class="outer-bg">
               <div class="inner-bg"><input name="" type="radio" value=""></div>
               </div>
               </li>
               </ul>
               </div>
               </div>
               </div>
               
               
               <div class="bott-links2"> 
               <a href="/step-1/"  class="read-more">&lt; Back</a>
               <!--<a href="/step-3a/" class="btn">Save &amp; Continue &gt;</a>-->
               <input type="submit" class="btn" value="Save &amp; Continue &gt;"/>
               </div>
          </div>
    
       </form>  </div>    
     </div>

     
     <div class="col-xs-4 right-r">
     <div class="right-col-st">
     
     	<article>
          <h3>Summary</h3>
          
          <div class="order">
          <ul>
          <li>
          <div class="order-left">Introductory order <br/> <span>10 lbs.</span></div>

          <div class="order-right"><?php echo '$'. $introcost; ?></div>
          </li>
	  <li>
          <div class="order-left"> <br /></div>
	  <aside>
          <h5>Recurring order</h5>
          <p>Now you'll setup your recurring order</p>
          <p>Prices includes shipping &amp; sales tax</p>
          </aside>
	  
          <?php
	  $priceqry = "select sum(price) as price from wp_carts where session_id = '".$sessionid."'";
	  $priceResult = $wpdb->get_row($priceqry, ARRAY_A);
	  
	  $total =  $priceResult['price'] + $_SESSION["shipment_price"]; ?>
		  <div class="order-right" id="recurring_order_price"></div>
          </li>
          </ul>     
          </div>
          
         <!-- <aside>
          <h5>Recurring order</h5>
          <p>Now you'll setup your recurring order</p>
          <p>Prices includes shipping & sales tax</p>
          </aside>-->
          
          <div class="order detail">
          <ul>
	 <?php
           
            global $wpdb;
            $sessionid = $_COOKIE['PHPSESSID'];
            $query = "Select * from wp_carts where session_id='$sessionid'";
            
            $results = mysql_query($query);
            while($rows = mysql_fetch_assoc($results)){
	       $pettype = $rows['pet_type'];
	       ?>
                <li>
                <div class="left"><?php if($pettype == 0) { echo 'dog'; }else { echo 'cat'; }?> - <?php echo $rows['pet_name'] ;?></div>
                <div class="right">Weight: <?php echo $rows['pet_weight'] ;?> lbs</div>
                </li>
            <?php } ?>

          </ul>
          </div>
          </article>
          
     </div>
     </div>
     <div class="right-bg"></div>
     
     </div>     
      
</div>
</div>
<script>
     $(document).ready(function(){
	  $("#catfood_category").hide();
	  $("#dogfood_category").hide();
	  var pettypeid = $("#pettypeid").html();
	  
	  if(pettypeid == "dog" || pettypeid == "multiple"){
		$("#dogfood_category").show();
	  }
	  if(pettypeid == "cat"){
		$("#catfood_category").show();
	  }
	  var $chkboxes = $('input[type=radio]');
	  $chkboxes.click(function() {
	       $('.column-2').toggleClass('active');
	       $('.column-3').toggleClass('active');
	      });
	  });
</script>