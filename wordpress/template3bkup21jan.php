<?php
<?php
/*
Template Name: Flow step3a
*/
?>
<?php // echo '<pre>'; print_r($_SESSION); ?>
<?php //get_header(); ?>
<?php //get_template_part('templates/content', 'page'); ?>
<?php
$url = get_bloginfo('url').'/shopping-cart/';
$url2 = get_bloginfo('url').'/step-2/';
$url1 = get_bloginfo('url').'/step-1/';

if(!isset($_SERVER['HTTP_REFERER']) && ($_SERVER['HTTP_REFERER'] != $url || $_SERVER['HTTP_REFERER'] != $url2 || $_SERVER['HTTP_REFERER'] != $url1))
{
	header("location:".$url1);
}
error_reporting(0);
//print_r($_POST);
$sessionid = $_COOKIE['PHPSESSID'];
$catid = $_POST['recurring_order_category'];
	
	if(isset($_SESSION) && !empty($_SESSION['intro_cost']))
	{
		$introcost = $_SESSION['intro_cost'];
	}else{
		$introcost = "14.95";
	}
	
	$qry = "select * from wp_carts_final where session_id = '".$sessionid."'";
	$result = $wpdb->get_results($qry, ARRAY_A);
	// print_r($result);
?>

<div class="section-8">
  <div class="container">
    <div class="flow-outer">
      <div class="col-xs-8">
        <div class="left-col-st">
          <div class="steps">
            <ul>
              <li class="complete">1 About Your Pets</li>
              <li class="complete">2 Select Product</li>
              <li class="current">3 Select Meats</li>
            </ul>
          </div>
          <div class="heading-top">
            <h2>Step 3 - Recommended Meats</h2>
            <p><small>We recommend that you feed your pets meals from all main meat types for variety and the most balanced diet, however we recognize that some pets have sensitivities to particular meats.</small></p>
          </div>
          <div class="cart-bg">
            <div class="final-info">
              <form action="/shopping-cart/" method="post"/>
              
              <!--Dog food -->
              <?php
			   $i=1;
			   foreach ( $result as $row ) {
				//echo '<pre>';print_r($row);
				$dogweight = $row['pet_weight'];
				
						$beef = $row['beef'];
						$chicken = $row['chicken'];
						$duck = $row['duck'];
						$turkey = $row['turkey'];
						$bison = $row['bison'];
						$food = $row['pet_food'];
						$food1 = $row['pet_round_weight']*2;
						
						$shipping_price = $row['shipping_price'];
						$pet_round_weight = $beef + $chicken +$duck + $turkey +$bison;
						$total_of_pet_round_weight += $pet_round_weight *2;
						$weeks = $row['weeks'];
						$shippingweeks = $row['shipping_weeks'];
						$weight = $row['pet_weight'];
						$pet_type = $row['pet_type'];
						//$pet_category = $row['category_id'];
						if($pet_type == 0){
							
							$pet_category = $_SESSION["dog"]['category_id'];
						}
						else{
							$pet_category = isset($_SESSION["cat"]['category_id'])?$_SESSION["cat"]['category_id']:3;
						}
						$id = $row['id'];
						$getPriceQry = "select * from wp_price where pet_type = '".$pet_type."' and category_id = '".$pet_category."'";
	  $priceresult = $wpdb->get_results($getPriceQry, ARRAY_A);
	  //echo '<pre>';print_r($result);
	  foreach($priceresult as $priceData){
		  if($priceData['food_type']==0){
			$beef_single_price = $priceData['price'];
		    $beefActualPrice = $beef_single_price / 2;
		  }
		  if($priceData['food_type']==1){
			  $chicken_single_price = $priceData['price'];
		     $chickenActualPrice  = $chicken_single_price/2;
		  }
		  if($priceData['food_type']==2){
			  $duck_single_price = $priceData['price'];
		     $duckActualPrice  = $duck_single_price/2;
		  }
		  if($priceData['food_type']==3){
			  $turkey_single_price = $priceData['price'];
		     $turkeyActualPrice  = $turkey_single_price/2;
		  }
		  if($priceData['food_type']==4){
			 $bison_single_price = $priceData['price'];
		     $bisonActualPrice  = $bison_single_price/2;
		  }
		  
		  
	  }
						//echo '<pre>'; print_r($result);
		if($row['pet_type']==0){
					 
			   ?>
              <div class="items"  id="dogfood_<?php echo $id; ?>">
                <input name="dog_category" type="hidden" class="input" id="pet_category" value="<?php echo $pet_category; ?>" />
                <input name="dog_weeks" type="hidden" class="input" id="pet_weeks" value="<?php echo $weeks; ?>" />
                <input name="dog_type" type="hidden" class="input" id="pet_type" value="<?php echo $pet_type; ?>" />
                <input name="dog_id" type="hidden" class="input" id="id" value="<?php echo $id; ?>" />
                <input name="dog_shipping_price" type="hidden" class="input" id="shipping_price_<?php echo $id; ?>" value="<?php echo $shipping_price; ?>" />
                <input name="dog_intro_price" type="hidden" class="input" id="intro_price_<?php echo $id; ?>" value="<?php echo "14.95"; ?>" />
                <input name="dog_total_price" type="hidden" class="input" id="total_price_<?php echo $id; ?>" value="" />
                <div class="heading-top">
                  <h3><u>For Your Dog</u></h3>
                </div>
                <aside>
                  <ul>
                    <li>
                      <div class="icon-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/icon-beef01.png" alt="Beef" width="37" height="28" class="alignnone size-full wp-image-577" /></div>
                      <label>Beef</label>
                      <div class="editable count input_edit">
                        <input name="dog_beef" type="number" min="0" class="input" id="beef_<?php echo $id; ?>" value="<?php echo $beef; ?>" />
                        <input name="dog_beef_price" type="hidden" class="input" id="beef_price_<?php echo $id; ?>" value="<?php echo $beef_single_price; ?>" />
                      </div>
                      <div class="editable count input_view" id="beef_view_<?php echo $id; ?>"><?php echo $beef; ?> </div>
                      <p class="actualmeal"><?php echo '$'.number_format($beefActualPrice, 2, '.', '').'/lb.'; ?></p>
                    </li>
                    <li>
                      <div class="icon-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/icon-chicken01.png" alt="Chicken" width="23" height="28" class="alignnone size-full wp-image-578" /></div>
                      <label>Chicken</label>
                      <div class="editable count input_edit">
                        <input name="dog_chicken" type="number" min="0" class="input" id="chicken_<?php echo $id; ?>" value="<?php echo $chicken; ?>" />
                        <input name="dog_chicken_price" type="hidden" class="input" id="chicken_price_<?php echo $id; ?>" value="<?php echo $chicken_single_price; ?>" />
                      </div>
                      <div class="editable count input_view"  id="chicken_view_<?php echo $id; ?>"><?php echo $chicken; ?></div>
                      <p class="actualmeal"><?php echo '$'.number_format($chickenActualPrice, 2, '.', '').'/lb.'; ?></p>
                    </li>
                    <li>
                      <div class="icon-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/icon-duck01.png" alt="Duck" width="26" height="28" class="alignnone size-full wp-image-579" /></div>
                      <label>Duck</label>
                      <div class="editable count input_edit">
                        <input name="dog_duck" type="number" min="0" class="input" id="duck_<?php echo $id; ?>" value="<?php echo $duck; ?>" />
                        <input name="dog_duck_price" type="hidden" class="input" id="duck_price_<?php echo $id; ?>" value="<?php echo $duck_single_price; ?>" />
                      </div>
                      <div class="editable count input_view"  id="duck_view_<?php echo $id; ?>"><?php echo $duck; ?></div>
                      <p class="actualmeal"><?php echo '$'.number_format($duckActualPrice, 2, '.', '').'/lb.'; ?></p>
                    </li>
                    <li>
                      <div class="icon-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/icon-turkey01.png" alt="Turkey" width="24" height="28" class="alignnone size-full wp-image-580" /></div>
                      <label>Turkey</label>
                      <div class="editable count input_edit">
                        <input name="dog_turkey" type="number" min="0" class="input" id="turkey_<?php echo $id; ?>" value="<?php echo $turkey; ?>" />
                        <input name="dog_turkey_price" type="hidden" class="input" id="turkey_price_<?php echo $id; ?>" value="<?php echo $turkey_single_price; ?>" />
                      </div>
                      <div class="editable count input_view"  id="turkey_view_<?php echo $id; ?>"><?php echo $turkey; ?></div>
                      <p class="actualmeal"><?php echo '$'.number_format($turkeyActualPrice, 2, '.', '').'/lb.'; ?></p>
                    </li>
                    
                    <!--<li id="bisonId" class="bisonId">
               <div class="icon-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/bison.png" alt="Turkey" width="39" height="28" class="alignnone size-full wp-image-580" /></div>
               <label>Bison</label>
                <div class="editable count input_edit">
				<input name="dog_bison" type="number" min="0" class="input" id="bison_<?php echo $id; ?>" value="<?php echo $bison; ?>" />
				<input name="dog_bison_price" type="hidden" class="input" id="bison_price_<?php echo $id; ?>" value="<?php echo $bison_single_price; ?>" />
				
			   </div>
               <div class="editable count input_view"  id="bison_view_<?php echo $id; ?>"><?php echo $bison; ?></div>
               <p class="actualmeal"><?php echo '$'.number_format($bisonActualPrice, 2, '.', '').'/lb.'; ?></p>
               </li>-->
                  </ul>
                </aside>
                
                <div class="col-txtright">
			<div><div style="float: left;" id="pet_round_weight_<?php echo $i; ?>"><?php echo $pet_round_weight; ?></div><?php echo '&nbsp; packages (2 lb.)'; ?></div>
		<a href="javascript:void(0);" id="dogEdit<?php echo $i; ?>" class="dogEdit">Change Varieties</a>
                  <input type="button" id="dogUpdateBtn_<?php echo $i; ?>" value="Update  &gt;" class="btn dogUpdateBtn">
                </div>
              </div>
              <!--Dog food end-->
              <?php }
			 else{
				$catweight = $row['pet_weight'];
				?>
              <!--Cat food-->
              
              <div class="items" id="catfood_<?php echo $id; ?>">
                <input name="cat_category" type="hidden" class="input" id="pet_category" value="<?php echo $pet_category; ?>" />
				<input name="cat_weeks" type="hidden" class="input" id="pet_weeks" value="<?php echo $weeks; ?>" />
                <input name="cat_type" type="hidden" class="input" id="pet_type" value="<?php echo $pet_type; ?>" />
                <input name="cat_id" type="hidden" class="input" id="id" value="<?php echo $id; ?>" />
                <input name="cat_shipping_price" type="hidden" class="input" id="shipping_price_<?php echo $id; ?>" value="<?php echo $shipping_price; ?>" />
                <input name="cat_intro_price" type="hidden" class="input" id="intro_price_<?php echo $id; ?>" value="<?php echo "14.95"; ?>" />
                <input name="cat_total_price" type="hidden" class="input" id="total_price_<?php echo $id; ?>" value="" />
                <div class="heading-top">
                  <h3><u>For Your Cats</u></h3>
                </div>
                <aside>
                  <ul>
                    <li>
                      <div class="icon-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/icon-chicken01.png" alt="Chicken" width="23" height="28" class="alignnone size-full wp-image-578" /></div>
                      <label>Chicken</label>
                      <div class="editable count input_edit">
                        <input name="cat_chicken" type="number" min="0" class="input" id="chicken_<?php echo $id; ?>" value="<?php echo $chicken; ?>" />
                        <input name="cat_chicken_price" type="hidden" class="input" id="chicken_price_<?php echo $id; ?>" value="<?php echo $chicken_single_price; ?>" />
                      </div>
                      <div class="editable count input_view" id="chicken_view_<?php echo $id; ?>"><?php echo $chicken; ?></div>
                      <p class="catactualmeal"><?php echo '$'.number_format($chickenActualPrice, 2, '.', '').'/lb.'; ?></p>
                    </li>
                    <li>
                      <div class="icon-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/icon-duck01.png" alt="Duck" width="26" height="28" class="alignnone size-full wp-image-579" /></div>
                      <label>Duck</label>
                      <div class="editable count input_edit">
                        <input name="cat_duck" type="number" min="0" class="input" id="duck_<?php echo $id; ?>" value="<?php echo $duck; ?>" />
                        <input name="cat_duck_price" type="hidden" class="input" id="duck_price_<?php echo $id; ?>" value="<?php echo $duck_single_price; ?>" />
                      </div>
                      <div class="editable count input_view" id="duck_view_<?php echo $id; ?>"><?php echo $duck; ?></div>
                      <p class="catactualmeal"><?php echo '$'.number_format($duckActualPrice, 2, '.', '').'/lb.'; ?></p>
                    </li>
                    <li>
                      <div class="icon-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/icon-turkey01.png" alt="Turkey" width="24" height="28" class="alignnone size-full wp-image-580" /></div>
                      <label>Turkey</label>
                      <div class="editable count input_edit">
                        <input name="cat_turkey" type="number" min="0" class="input" id="turkey_<?php echo $id; ?>" value="<?php echo $turkey; ?>" />
                        <input name="cat_turkey_price" type="hidden" class="input" id="turkey_price_<?php echo $id; ?>" value="<?php echo $turkey_single_price; ?>" />
                      </div>
                      <div class="editable count input_view" id="turkey_view_<?php echo $id; ?>"><?php echo $turkey; ?></div>
                      <p class="catactualmeal"><?php echo '$'.number_format($turkeyActualPrice, 2, '.', '').'/lb.'; ?></p>
                    </li>
                  </ul>
                </aside>
                <!-- <div class="col-txtleft"><?php //echo $pet_round_weight. ' (2 lb.) packages' ?></div>-->
                
                <div class="col-txtright">
		<div><div style="float: left;"  id="pet_round_weight_<?php echo $i; ?>"><?php echo $pet_round_weight;  ?></div><?php echo '&nbsp; packages (2 lb.)'; ?></div>
		<a href="javascript:void(0);" id="dogEdit<?php echo $i; ?>" class="dogEdit">Change Varieties</a>
                  <input type="button" id="dogUpdateBtn_<?php echo $i; ?>" value="Update  &gt;" class="btn dogUpdateBtn">
                </div>
                
                <!-- <div class="col-txtleft">16 (2 lb.) packages</div>
               <div class="col-txtright"><a href="javascript:void(0);" id="catEdit">Change Varieties</a>
			   <input type="submit" id="catUpdateBtn" value="Update  &gt;" class="btn"></div>--> 
              </div>
              
              <!--cat food end-->
              <?php
			 }
			 $i++;
			 }
			 
			 ?>
			 
              <input type="hidden" value="" class="grandtotal" name="grandtotal"/>
              <!--<div class="total-info">Total:  $127.40</div>-->
              <div class="total-info"></div>
            </div>
            <?php //echo '<pre>';print_r($_SERVER);
			   if(isset($_SERVER['HTTP_REFERER'])) {
					$parts = explode("/", $_SERVER['HTTP_REFERER']);
					if($parts[3] == "step-2"){
						$url = '/step-2/';
					}else{
						$url = '/step-1/';
					}
					
				}else{
						$url = '/step-1/';
					}
			   ?>
            <div class="bott-links2"> <a href="<?php echo $url; ?>"  class="read-more">&lt; Back</a> 
              <!--<a href="/shopping-cart/" id="addtocartBtn" class="btn">Add to Cart &gt;</a>-->
              <input type="submit" value="Add to Cart" name="addtocart" id="addtocartBtn"  class="btn" >
            </div>
          </div>
        </div>
      </div>
      </form>
      <div class="col-xs-4 right-r">
        <div class="right-col-st">
          <article>
            <h3>Summary</h3>
            <div class="order detail">
              
              <!---->
              
              <?php
           
            global $wpdb;
            $sessionid = $_COOKIE['PHPSESSID'];
            $query = "Select * from wp_carts where session_id='$sessionid'";
            
            $results = mysql_query($query);
            while($rows = mysql_fetch_assoc($results)){
	       $pettype = $rows['pet_type'];
	       ?>
              <div class="row"> 
                <!-- <div class="left"> - </div>
                <div class="right"> </div>-->
                <div class="col-lg-6" ><span class="label">
                  <?php if($pettype == 0) { echo 'Dog'; }else { echo 'Cat'; }?>
                - <span class="text-capitalize"><?php echo $rows['pet_name'] ;?></span></span></div>
                <div class="col-lg-6 text-right" >Weight: <?php echo $rows['pet_weight'] ;?> lbs</div>
              </div>
              <?php } ?>
              <!---->
              <div class="row">
                <div class="col-lg-12 voffset"><span class="label">Intro Offer</span></div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">10 lbs.</div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">$14.95</div>
              </div>
              <!---->
              <div class="row voffset-top">
              <div class="col-lg-12"><span class="label">Recurring Order</span><br>
(For your convenience, can change at any time)</div>
              </div>
              <?php
		$grandtotal = 0; $i=1;
			foreach ( $result as $row ) {
				//echo '<pre>';print_r($row);
				$food = $row['pet_food'];
				$weeks = $row['weeks'];
				$shippingweeks = $row['shipping_weeks'];
				$price = $row['price'];
				$food1 = $row['pet_round_weight']*2;
				$total = $row['beef']+$row['chicken']+$row['duck']+$row['turkey']+$row['bison'];
				$tatalfinal = $total*2;
				
					
									
		?>
              <div class="row voffset-small">
              
                <div class="col-lg-12"><span class="label">
                  <?php if($row['pet_type'] == 0) { echo "Dog Food - "; } else{ echo "Cat Food - "; }
						$pid = $row['id'];
					?>
                  <div id="updatefood_<?php echo $i; ?>" class="inline-div"> <?php echo $tatalfinal." lbs";?></div></span>
                  
                  
                  
                </div>
                <?php
	  //echo '<pre>'
	  //print_r($row);
	  //echo $_SESSION["shipment_price"];
	  $total =  $price + $_SESSION["shipment_price"];
		  $grandtotal += $total;
		  ?>
                <div class="col-lg-12 text-right voffset-top" id="recurring_order_price_<?php echo $i; ?>"><?php echo '$'.number_format($total, 2, '.', ''); ?>/shipment </div>
                <div class="col-lg-12 text-right" id="recurring_order_priceperweek_<?php echo $i; ?>">
                  <?php
				  $priceperweek = $total/$_SESSION["shipping_weeks"];
				   $priceperweek1 = $total/$_SESSION["shipping_weeks"];
						$lenght = strlen($priceperweek);
	
										   if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){
					
						
						
						if($lenght > 5){
							echo '$'.number_format($priceperweek, 2, '.', '').'/week';
						}
						else{
							
							echo '$'.sprintf ("%.2f", $priceperweek).'/week';
							
							
						}
			
				   }/*else{
					 	
					 $priceperweek = $total/$weeks;
					  $lenght = strlen($priceperweek);
					  if($lenght > 5){
						  echo '$'.number_format($priceperweek, 2, '.', '').'/week';
					  }
					  else{
						  echo '$'.sprintf ("%.2f", $priceperweek).'/week';
						  
						  
					  }
				   }*/
			//echo '$'.number_format($priceperweek, 2, '.', '').'/week';
			$sumofweek += $priceperweek;
			  $_SESSION['shipping_weeks'] = $weeks; 
			?>
			
                </div>
      
     
              </div>
              <input type="hidden" name="recring_price" value="<?php echo $grandtotal; ?>"	id="recurring_order_price_<?php echo $row['id']; ?>">
              
              <?php $i++; } ?>
			  
	       <div style="border-top:1px solid #cfcfcf;padding-top:5px;text-align:right;" class="order-rightnew">Total:&nbsp;<?php echo '$'.number_format($grandtotal, 2, '.', ''); ?><br/>&nbsp;
		    <?php
		    $tpriceformat = (int)(($priceperweek1*100))/100;
		    echo '$'.$tpriceformat.'/week';
		    ?>
			
              
              <div class="row"><div class="col-lg-12">
			  <?php if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){ ?>
			  <span class="shipspan">
                <div class="editable count input_edit">
                  <select class="selectship" id="shippingfreq_<?php echo $pid; ?>" style="margin-bottom: 5px;width: 100px;">
                    <option value="">Select Weeks</option>
                    <?php for($j = 0; $j<=50 ;$j++){
					if($j==$shipping_frequency){ $slected = "selected"; } else {  $slected = ""; }
					?>
                    <option value="<?php echo $j; ?>" <?php echo $slected; ?>><?php echo $j; ?></option>
                    <?php	}?>
                  </select>
                  <input name="shippingfreq" type="hidden" min="0" class="input shippingfreq"  value="<?php echo $pid; ?>" />
                </div>
                <div class="editable count input_view"  id="weeks_<?php echo $pid; ?>"><?php echo $shipping_frequency; ?> weeks supply</div>
                <a href="javascript:void(0);" class="changeShipping" id="changeShipping_<?php echo $pid; ?>">Change shipping frequency</a>
                <input type="button" id="shipUpdateBtn_<?php echo $pid; ?>" value="Update  &gt;" class="btn shipUpdateBtn" height: 36px; width: 93px;>
                </span>
				<?php }
				else {
					/*if(isset($_SESSION) && $_SESSION["order_species"] != 'multiple'){*/ ?>
                  <?php 
				  
						if(!isset($_SESSION["shipping_weeks"]) || $_SESSION["shipping_weeks"]=="")
						{
						//	echo 'here';
							$_SESSION["shipping_weeks"]=$weeks;
							$shipping_frequency = $_SESSION["shipping_weeks"];
						}else{
							//echo 'elase';
							$shipping_frequency = $_SESSION["shipping_weeks"];
						}
				  ?><span class="shipspan">
                  <div class="editable count input_edit">
				  
                    <select class="selectship" id="shippingfreq_<?php echo $pid; ?>" style="margin-bottom: 5px;width: 100px;">
                      <option value="">Select Weeks</option>
                      <?php for($j = 0; $j<=50 ;$j++){
					if($j==$shipping_frequency){ $slected = "selected"; } else {  $slected = ""; }
					?>
                      <option value="<?php echo $j; ?>" <?php echo $slected; ?>><?php echo $j; ?></option>
                      <?php	}?>
                    </select>
                    <input name="shippingfreq" type="hidden" min="0" class="input shippingfreq"  value="<?php echo $pid; ?>" />
                  </div>
                  
                  <div class="editable count input_view"  id="weeks_<?php echo $pid; ?>"><?php echo $shipping_frequency; ?> weeks supply</div>
                  <a href="javascript:void(0);" class="changeShipping" id="changeShipping_<?php echo $pid; ?>">Change shipping frequency</a>
                  <input type="button" id="shipUpdateBtn_<?php echo $pid; ?>" value="Update  &gt;" class="btn shipUpdateBtn" height: 36px; width: 93px;>
                  </span>
                  <?php } ?>
			  </div></div>
              
            </div>
            <aside>
              <p>Prices include shipping</p>
            </aside>
          </article>
        </div>
      </div>
      <div class="right-bg"></div>
    </div>
  </div>
</div>
<script>
	$(".input_edit").hide();
	
	$(".dogUpdateBtn").hide();
	$(".shipUpdateBtn").hide();
	

	var total=0;var chi=0;var petfood=0;
	$('.items').each(function(){
		
		var id = $(this).attr("id");
		var sid = id.split('_');
		var bisonQnty = $(this).find('[id^="bison_"]').val();
		//console.log("shi"+<?php echo $_SESSION["shipment_price"]; ?>);
		if(sid[0] == "dogfood"){
			//console.log('here');
			var foodlbs = $(this).find('[id^="pet_round_weight_"]').html();
			var chicken = $(this).find('[id^="chicken_"]').val()*$(this).find('[id^="chicken_price_"]').val();
			var duck = $(this).find('[id^="duck_"]').val()*$(this).find('[id^="duck_price_"]').val();
			var beef = $(this).find('[id^="beef_"]').val()*$(this).find('[id^="beef_price_"]').val();
			var turkey = $(this).find('[id^="turkey_"]').val()*$(this).find('[id^="turkey_price_"]').val();
			var shipping_price = $(this).find('[id^="shipping_price_"]').val();
			//alert(shipping_price);
			//var bison = $(this).find('[id^="bison_"]').val()*$(this).find('[id^="bison_price_"]').val();
			//chi =  chi + chicken + duck + beef + turkey + bison  + parseFloat(<?php echo $_SESSION["shipment_price"]; ?>);
			chi =  chi + chicken + duck + beef + turkey + parseFloat(shipping_price);
			///var individualprice =  chicken + duck + beef + turkey + bison  + parseFloat(<?php echo $_SESSION["shipment_price"]; ?>);
			var individualprice =  chicken + duck + beef + turkey + parseFloat(shipping_price);
			//console.log(chicken + ' + '+ duck + ' + '+ beef + ' + '+ turkey + ' + '+ bison + '+'+ parseFloat(<?php echo $_SESSION["shipment_price"]; ?>)+ '+' +parseFloat(14.95));
			//console.log("foodlbs-"+ foodlbs);
			if(foodlbs < 20 ){
					//console.log('k1');
					$("#addtocartBtn").hide();
				}
		}
		else{
			var foodlbs = $(this).find('[id^="pet_round_weight_"]').html();
			//console.log($(this).find('[id^="duck_"]').val()+'*'+$(this).find('[id^="duck_price_"]').val());
			//console.log($(this).find('[id^="chicken_"]').val()+'*'+$(this).find('[id^="chicken_price_"]').val());
			//console.log($(this).find('[id^="turkey_"]').val()+'*'+$(this).find('[id^="turkey_price_"]').val());
			var duck = $(this).find('[id^="duck_"]').val()*$(this).find('[id^="duck_price_"]').val();
			var chicken = $(this).find('[id^="chicken_"]').val()*$(this).find('[id^="chicken_price_"]').val();
			var turkey = $(this).find('[id^="turkey_"]').val()*$(this).find('[id^="turkey_price_"]').val();
			var shipping_price = $(this).find('[id^="shipping_price_"]').val();
			chi= chi + duck + chicken + turkey + parseFloat(shipping_price);
			var individualprice =  duck + chicken + turkey + parseFloat(shipping_price);
			//console.log( duck + ' + '+ chicken + ' + '+ turkey+ ' + '+ parseFloat(<?php echo $_SESSION["shipment_price"]; ?>)+' + '+parseFloat(14.95));
			//console.log("foodlbs-"+ foodlbs);
			if(foodlbs < 20 ){
					//console.log('k2');
					$("#addtocartBtn").hide();
				}
			
		}
		 petfood = petfood + parseFloat($(this).find('[id^="pet_round_weight_"]').html()) ;
			//console.log("addoffood"+petfood);
				var SinglefoodQnty = petfood * 2;
				
				
				
				
				if(SinglefoodQnty < 20 ){
					//console.log('k3');
					$("#addtocartBtn").hide();
				}
				else{
					//console.log('k4');
					$("#addtocartBtn").show();
					//pointer.parents(".items").find('[id^="pet_round_weight_"]').text(sumoffood);
				}
			
		total =parseFloat(chi)+parseFloat(<?php echo $introcost;?>);
		//console.log("total"+total);
		var totalprice = parseFloat(parseFloat((Math.round( total * 100 )/100 ).toString())).toFixed(2);
		//console.log("totalprice"+totalprice);
		//$('.total-info').html("Total:  $"+totalprice);
		$(this).find('[id^="total_price_"]').val(individualprice);
		
		$('.grandtotal').val(totalprice);
		
		//if(bisonQnty == 0){
		//	
		//	$(".bisonId").hide();
		//	
		//}else if(bisonQnty == "undefined"){
		//	$(".bisonId").hide();
		//}
	});
	
	

	//var spinner = $( "#spinner" ).spinner();
	$(".dogEdit").on("click",function(){
		//var currentVal = $(this).val();
		
		//$(this).parents(".items").find(".bisonId").show();
		$(this).parents(".items").find(".dogUpdateBtn").show();
		$(this).parents(".items").find(".dogEdit").hide();
		$(this).parents(".items").find(".input_edit").show();
		$(this).parents(".items").find(".input_view").hide();
		$(this).parents(".items").find(".actualmeal").css("display", "block");
		
	});
	
	
	$(".changeShipping").on("click",function(){
		
		$(this).parents(".shipspan").find(".input_edit").show();
		$(this).parents(".shipspan").find(".input_view").hide();
		$(this).parents(".shipspan").find(".shipUpdateBtn").show();
		$(this).parents(".shipspan").find(".changeShipping").hide();		
		
	});
	
	$(".shipUpdateBtn").on("click",function(){
		var pointer = $(this);
		 var weeks = $(this).parents(".shipspan").find(".selectship").val();	  
		  var id = $(this).parents(".shipspan").find(".shippingfreq").val();
		  if (confirm('Your order size will stay the same so increasing the number of weeks between deliveries will reduce the amount of food fed per week" (or decreasing the number... will increase the amount...)')) {
			 $.ajax({
				  type: 'POST',
				    url:"<?php bloginfo('wpurl'); ?>/wp-content/themes/dp-ecomm-merged/ajax.php?action=changeShipFreq",
				  //url:"<?php bloginfo('wpurl'); ?>/wp-content/themes/dp/ajax.php?action=changeShipFreq",
				   data: { weeks: weeks,id:id},
				  success: function (msg) {
					//console.log(msg);
					//msg = $.trim(msg);
					pointer.parents(".shipspan").find(".input_view").html(weeks+"&nbsp; weeks supply");
					pointer.parents(".shipspan").find(".input_edit").hide();
					pointer.parents(".shipspan").find(".input_view").show();
					pointer.parents(".shipspan").find(".shipUpdateBtn").hide();
					pointer.parents(".shipspan").find(".changeShipping").show();		
			   },
				  error: function (error) {
					  console.log("Please check your connection");
				  }
			  });
		  }
	});
	
		
	$(".dogUpdateBtn").on("click",function(){
		
		var pointer = $(this);
		var id = $(this).parents(".items").attr("id");
		var sid = id.split('_');
		var dtaprice = 0;
		var addshipping = 0;
		console.log(sid);
		//if(sid[0] == "dogfood"){
		//console.log('ass');
		//}
		var beef = 0; var chicken=0;  var duck=0;  var turkey=0;
		var beef = $(this).parents(".items").find('[id^="beef_"]').val();
		var chicken = $(this).parents(".items").find('[id^="chicken_"]').val();
		var duck = $(this).parents(".items").find('[id^="duck_"]').val();
		var turkey = $(this).parents(".items").find('[id^="turkey_"]').val();
		//var bison = $(this).parents(".items").find('[id^="bison_"]').val();
		var pet_category = $(this).parents(".items").find("#pet_category").val();
		var pet_type = $(this).parents(".items").find("#pet_type").val();
		var id = $(this).parents(".items").find("#id").val();
		//console.log(chicken + ' + '+ duck + ' + '+ beef + ' + '+ turkey + ' + '+ bison);
		//var sumoffood = parseInt(beef) +parseInt(chicken) + parseInt(duck) + parseInt(turkey) + parseInt(bison) ;
		var sumoffood = parseInt(parseInt(beef) +parseInt(chicken) + parseInt(duck) + parseInt(turkey));
		if (pet_type =="1"){
			var sumoffood = parseInt(chicken) + parseInt(duck) + parseInt(turkey);
		var petfooddata = sumoffood*2;
				$('#updatefood_2').html(petfooddata +" lbs");
		
		}else{
			
			var sumoffood = parseInt(parseInt(beef) +parseInt(chicken) + parseInt(duck) + parseInt(turkey));
		var petfooddata = sumoffood*2;
				$('#updatefood_1').html(petfooddata +" lbs");
		}
		
		//console.log(sumoffood);
		if (confirm('This is now different than the recommended amount to feed. Are you sure you want to do this?')) {
		$.ajax({
			type: 'POST',
			//dataType: 'json',
			url:"<?php bloginfo('wpurl'); ?>/wp-content/themes/dp-ecomm-merged/ajax.php?action=getPrice",
			//url:"<?php bloginfo('wpurl'); ?>/wp-content/themes/dp/ajax.php?action=getPrice",
			//data: { beef: beef,chicken:chicken,duck:duck,turkey:turkey,bison:bison,category:pet_category,pet_type:pet_type,id:id,sumoffood:sumoffood},
			data: { beef: beef,chicken:chicken,duck:duck,turkey:turkey,category:pet_category,pet_type:pet_type,id:id,sumoffood:sumoffood},
			success: function (results) {
				
				var data = jQuery.parseJSON(results);
				console.log(data);
				pointer.parents(".items").find('[id^="beef_view_"]').text(data.beef);
				pointer.parents(".items").find('[id^="chicken_view_"]').text(data.chicken);
				pointer.parents(".items").find('[id^="duck_view_"]').text(data.duck);
				pointer.parents(".items").find('[id^="turkey_view_"]').text(data.turkey);
				
				
				//pointer.parents(".items").find('[id^="bison_view_"]').text(data.bison);
				
				//var totalprice = parseFloat(parseFloat(<?php echo $total; ?>)+ parseFloat((Math.round( data.price * 100 )/100 ).toString())).toFixed(2);
				//if(data.specices_dog == "dog")
				//{
				//	dtaprice =  parseFloat(data.price) + parseFloat(<?php echo $_SESSION["shipment_price"]; ?>);
				//}
				//if(data.specices_cat == "cat"){
				//	dtaprice =  parseFloat(data.price) +  parseFloat(<?php echo $_SESSION["shipment_price"]; ?>);
				//	
				//}
				//console.log(data.specices_price +'/z'+parseFloat(data.petData[0].shipping_price));
				addshipping = parseFloat(parseFloat(data.specices_price) + parseFloat(data.petData[0].shipping_price)).toFixed(2);
				
				
				if(data.pet_type == 0){
					$("#recurring_order_price_1").html("$"+addshipping+"/shipment");
					var perweekprice = parseFloat(addshipping/data.petData[0].weeks).toFixed(2);
					 <?php if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){ ?>
					$("#recurring_order_priceperweek_1").html("$"+perweekprice+"/week");
					<?php } ?>
					
					
				}else{
					
					$("#recurring_order_price_2").html("$"+addshipping+"/shipment");
					var perweekprice = parseFloat(addshipping/data.petData[0].weeks).toFixed(2);
					 <?php if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){ ?>
					$("#recurring_order_priceperweek_2").html("$"+perweekprice+"/week");
					<?php } ?>
					
				}
				

				//var totalprice = parseFloat(parseFloat((Math.round( dtaprice * 100 )/100 ).toString())).toFixed(2);
				//var t = parseFloat(parseFloat(totalprice) + parseFloat(<?php echo $introcost;?>)).toFixed(2);
				//console.log("total"+totalprice);
				//console.log("totalprice"+t);				
				
				pointer.parents(".items").find('[id^="total_price_"]').val(addshipping);
				
				//if(data.bison== 0){
				//	pointer.parents(".items").find(".bisonId").hide();
				//}else{
				//	pointer.parents(".items").find(".bisonId").show();
				//}
				//
				pointer.parents(".items").find(".dogUpdateBtn").hide();
				pointer.parents(".items").find(".dogEdit").show();
				pointer.parents(".items").find(".input_edit").hide();
				pointer.parents(".items").find(".input_view").show();
				//console.log(parseInt(data.beef) + '+' +parseInt(data.chicken) + '+' + parseInt(data.duck) + '+' + parseInt(data.turkey) + '+' + parseInt(data.bison));
				//var sumoffood = parseInt(data.beef) +parseInt(data.chicken) + parseInt(data.duck) + parseInt(data.turkey) + parseInt(data.bison) ;
				var sumoffood = 0;
				var sumoffood1 =0;
				
                var petData = data.petData;
				var j = 1;
				var priceCal = 0;
				 $.each(petData, function(i,item){
					console.log("price"+j+'--'+item);
					priceCal += parseFloat(item.price) + parseFloat(item.shipping_price);
					
					//sumoffood = parseInt(item.beef) +parseInt(item.chicken) + parseInt(item.duck) + parseInt(item.turkey) + parseInt(item.bison) ;
					sumoffood = parseInt(item.beef) +parseInt(item.chicken) + parseInt(item.duck) + parseInt(item.turkey) ;
					//console.log('sumoffood'+sumoffood+"#pet_round_weight_"+j);
					$("#pet_round_weight_"+j).text(sumoffood);
					sumoffood1  +=sumoffood ;
					j++;
				});
				
				total = parseFloat(priceCal) + parseFloat(<?php echo $introcost;?>);
				totalprice = parseFloat(parseFloat((Math.round( total * 100 )/100 ).toString())).toFixed(2);
				//console.log("totalkavita"+total);
				//console.log("totalprice"+t);					 
				//$('.total-info').html("Total:  $"+totalprice);
				$('.grandtotal').val(totalprice); 
				//alert(sumoffood1);
				
				var addoffood = parseInt(data.beef) +parseInt(data.chicken) + parseInt(data.duck) + parseInt(data.turkey) + parseInt(data.bison) ;
				var SinglefoodQnty = addoffood * 2;
				
				
					var index=1;
					var total=0;
					$(".final-info div.items").each(function() {
						       
							    total= total+parseInt($(this).find("#pet_round_weight_"+index).html())*2;
							     index++;
							});
		               //alert(total);
				//alert($("div.items").find(".col-txtnumber").children().text())
				//console.log("addoffood"+addoffood);
				if(total<20){
					alert("This amount is below our 20 lb. minimum order. Please increase your order amount. You can reduce the amount fed per week by increasing the number of weeks between orders (shipping frequency link on the right)");
					//var foodQnty = sumoffood1 * 2;
					//if(foodQnty < 20){http://192.155.246.146:8225/step-3a/
					//	alert("Please increase your varieties. You can also reduce the amount fed per week by increasing the number of weeks between orders.");
					//}
					$("#addtocartBtn").hide();
				}
				else{
					$("#addtocartBtn").show();
					//pointer.parents(".items").find('[id^="pet_round_weight_"]').text(sumoffood);
				}
				
				
			},
			error: function (error) {
				alert("Please check your connection");
			}
		});
	}
	});
	
	//function changeShipping(){
	//	
	//}
</script>
<style>
.right-col-st .order ul li .order-left {
    float: left;
    padding: 0 71px 0 0;
    text-align: left;
    width: 100%;
}
</style>
