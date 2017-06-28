<?php
/*
Template Name: Flow step 2
*/
?>
<?php //get_header(); ?>
<?php //echo '<pre>'; print_r($_SESSION); ?>
<?php //get_template_part('templates/content', 'page'); ?>
<?php
error_reporting(0);
  //echo '<pre>';
 // print_r($_SESSION);
  $sessionid = $_COOKIE['PHPSESSID'];  
  if(isset($_SESSION) && !empty($_SESSION['intro_cost']))
  {
	$introcost = $_SESSION['intro_cost'];
  }else{
	$introcost = "14.95";
  }
  
  

     
     $qry = "select * from wp_carts_final where pet_type='0' and session_id = '".$sessionid."'";
     $result = $wpdb->get_results($qry, ARRAY_A);
	//echo '<pre>'; print_r($result);
     $totalShipPrice =0;
     $dogfood = 0;
     $catfood = 0;
     foreach ( $result as $row ) {
	  $actualbeef = $row['beef'];
	  $actualchicken = $row['chicken'];
	  $actualduck = $row['duck'];
	  $actualturkey = $row['turkey'];
	  $actualbison = $row['bison'];
	  $actualfood = $row['food'];
	  $actualweeks = $row['weeks'];
	  $actualweight = $row['weight'];
	  $actualpet_type = $row['pet_type'];
	  $actualpet_category = $row['category_id'];
	  $id = $row['id'];
	  
	  //echo '<pre>';print_r($row);
	  $pet_food = $row['pet_food'];
	  $pet_type = $row['pet_type'];
	  $category_id = $row['category_id'];
	  $shipping_price = $row['shipping_price'];
	  if($pet_type == 0){
		//echo 'here';
	       $dogfood += $pet_food;
	  }
	  else{
		//echo 'else';
	       $catfood += $pet_food;
	  }
	  /*price calculation start*/
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
		}else{
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
		
     }
     
 
     /*<!--------- calculation for shipping --------->*/

	
//$dog_natural_price = $natural_actualprice + $_SESSION["shipment_price"];
//$dog_zoo_price = $zoo_actualprice + $_SESSION["shipment_price"];
//$cat_only_price = $cat_actualprice + $_SESSION["shipment_price"];

$dog_natural_price = $natural_actualprice + $shipping_price;
$dog_zoo_price = $zoo_actualprice + $shipping_price;
$cat_only_price = $cat_actualprice + $shipping_price;


//print_r($_SESSION);
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
	  //echo '<pre>';print_r($_SESSION);
			  if(($_SESSION['order_species'] == 'dog') || ($_SESSION['order_species'] == 'multiple')){
			      $petname = "Dog";
			      $petfood = $_SESSION['dog']['food'];
			      $petweeks = $_SESSION['dog']['weeks'];
				$weightqry = "select sum(pet_weight) as weight from wp_carts where session_id = '".$sessionid."' and pet_type=0 ";
				$weightresult = $wpdb->get_row($weightqry, ARRAY_A);
			   // echo $weightresult['weight'];
			   }else{
			       $petname = "Cat";
			       $petfood = $_SESSION['cat']['food'];
			       $petweeks = $_SESSION['cat']['food'];
				 $weightqry = "select sum(pet_weight) as weight from wp_carts where session_id = '".$sessionid."' and pet_type=1 ";
				 $weightresult = $wpdb->get_row($weightqry, ARRAY_A);
			  // echo '---'.$weightresult['weight'];
				//$dogweight += $row['pet_weight'];
			   }
		  ?>
          <div class="heading-top">
            <h2>Step 2 - Select <?php echo $petname; ?> Food Product</h2>
            <?php if(empty($_SESSION['order_species'])){?>
            <p>We recommend a <?php echo $petfood;?> lb. package, which will feed your dogs for <?php echo $petweeks;?> weeks</p>
            <?php }?>
          </div>
          <form action="<?php echo bloginfo('template_url');?>/step3_action.php" method="post" id="step2Form">
            <input name="recurring_order_category" id="recurring_order_category" type="hidden" value="<?php echo $_SESSION['category'];?>">
            <div class="cart-bg"> 
              <!-- Table-info For Dektop View -->
              <div class="table-info hide_mobile1">
                <div class="column-1">
                  <ul>
                    <li class="heading">
                      <div class="outer-bg">
                        <div class="inner-bg">Price includes shipping</div>
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
                        <div class="inner-bg">High protein, low fat formula <br/>
                          (75% meat, 25% vegetables)</div>
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
                            <?php //echo $actualweeks;?>
                            <p><span>Natural Selections</span><br/>
                              <?php echo '$'.number_format($dog_natural_price/$actualweeks, 2, '.', '').'/week'; ?></p>
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
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li class="pink">
                        <div class="outer-bg">
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li>
                        <div class="outer-bg">
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li class="check">
                        <div class="outer-bg">
                          <div class="inner-bg">
                           <?php if($_SESSION["categ"] =="1"){ ?>
		     <input name="recurring_order" type="radio" id="recurring_order_first" data-id= "1"  value="<?php echo $dog_natural_price; ?>" checked/>
		<?php } else {?> 
                 <input name="recurring_order" type="radio" id="recurring_order_first" data-id= "1"  value="<?php echo $dog_natural_price; ?>" checked />
               <?php } ?>  
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="column-3">
                    <ul>
                      <li class="heading">
                        <div class="outer-bg">
                          <div class="inner-bg">
                            <p><span>Zoologics</span><br/>
                              <?php echo '$'.number_format($dog_zoo_price/$actualweeks, 2, '.', '').'/week'; ?></p>
                          </div>
                        </div>
                      </li>
                      <li class="first">
                        <div class="outer-bg">
                          <div class="inner-bg">Conventionally-raised</div>
                        </div>
                      </li>
                      <li class="pink">
                        <div class="outer-bg">
                          <div class="inner-bg">Conventional</div>
                        </div>
                      </li>
                      <li class="second">
                        <div class="outer-bg">
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li class="pink">
                        <div class="outer-bg">
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li>
                        <div class="outer-bg">
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li class="check">
                        <div class="outer-bg">
                          <div class="inner-bg">
                           <?php if($_SESSION["categ"] =="2"){ ?>
		
		   <input checked="checked" name="recurring_order" id="recurring_order" type="radio" data-id= "2" value="<?php echo $dog_zoo_price; ?>">
		<script>
		  $(document).ready(function() {
    $(".column-2").removeClass("active");
    // $(".tab").addClass("active"); // instead of this do the below 
    $(".column-3").addClass("active");   

});
		  
		</script>
		
		<?php } else {?> 
               <input name="recurring_order" id="recurring_order" type="radio" data-id= "2" value="<?php echo $dog_zoo_price; ?>">
               <?php } ?>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- <div id="catfood_category">
				
				
			<div class="column-4 active">
               <ul>
               <li class="heading">
		    <div class="outer-bg">
		    <div class="inner-bg">
			  
               <p><span>Natural Selections</span><br/><?php //echo '$'.number_format($cat_only_price, 2, '.', ''); ?></p>
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
               <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="pink">
               <div class="outer-bg">
               <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li>
               <div class="outer-bg">
               <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
               </div>
               </li>
               
               <li class="check">
               <div class="outer-bg">
               <div class="inner-bg"><input name="recurring_order" type="radio" value="" data-id= "3" value="<?php echo $cat_only_price; ?>" ></div>
               </div>
               </li>
               </ul>
               </div>
				
				
				
	       </div>--> 
                
              </div>
              
              <!-- Table-info For Mobile View -->
              <div class="table-info show_mobile1">
                <div class="table-row">
                  <div class="column-1">
                    <ul>
                      <li class="heading">
                        <div class="outer-bg">
                          <div class="inner-bg">Price includes shipping</div>
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
                          <div class="inner-bg">High protein, low fat formula <br/>
                            (75% meat, 25% vegetables)</div>
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
                            <p><span>Natural Selections</span><br/>
                              $127.40</p>
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
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li class="pink">
                        <div class="outer-bg">
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li>
                        <div class="outer-bg">
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li class="check">
                        <div class="outer-bg">
                          <div class="inner-bg">
                            <input name="" type="radio" value="" checked="true">
                          </div>
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
                          <div class="inner-bg">Price includes shipping</div>
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
                          <div class="inner-bg">High protein, low fat formula <br/>
                            (75% meat, 25% vegetables)</div>
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
                            <p><span>Zoologics</span><br/>
                              <?php echo '$'.$total2; ?></p>
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
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li class="pink">
                        <div class="outer-bg">
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li>
                        <div class="outer-bg">
                          <div class="inner-bg"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-tick01.png" alt="img-tick01" width="21" height="23" class="alignnone size-full wp-image-587" /></div>
                        </div>
                      </li>
                      <li class="check">
                        <div class="outer-bg">
                          <div class="inner-bg">
                            <input name="" type="radio" value="">
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="bott-links2"> <a href="/step-1/"  class="read-more">&lt; Back</a> 
                <!--<a href="/step-3a/" class="btn">Save &amp; Continue &gt;</a>-->
                <input type="submit" class="btn" value="Save &amp; Continue &gt;"/>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-xs-4 right-r">
        <div class="right-col-st">
          <article>
            <h3>Summary</h3>
            <div class="order detail">
               
                <!--<li>
          <div class="order-left">Introductory order <br/> <span>10 lbs.</span></div>

          <div class="order-right"><?php echo '$'. $introcost; ?></div>
          </li>-->
                
               
                
                <?php 
           
            global $wpdb;
            $sessionid = $_COOKIE['PHPSESSID'];
            $query = "Select * from wp_carts where session_id='$sessionid'";
            
            $results = mysql_query($query);
            while($rows = mysql_fetch_assoc($results)){
	       $pettype = $rows['pet_type'];
	       ?>
                <div class="row">
                  <div class="col-lg-6" >
                    <span class="label"><?php if($pettype == 0) { echo 'Dog'; }else { echo 'Cat'; }?>
                    - <span class="text-capitalize"><?php echo $rows['pet_name'] ;?></span></span></div>
                <div class="col-lg-6 text-right" >Weight: <?php echo $rows['pet_weight'] ;?> lbs</div>
                </div>
                <?php } ?>
                <div class="row">
                <div class="col-lg-12 voffset"><span class="label">Intro Offer </span></div>
                </div>
                    <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">10 lbs.</span></div>
                  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">$14.95</div>
                </div>
                <div class="row">
                <div class="col-lg-12 voffset">
                  <span class="label">Recurring Order</span>
                  <p class="clearfix">Now you'll setup your recurring order for your convenience. Can change at any time.</p>
                  <p>Prices includes shipping</p>
                  <?php
	  $priceqry = "select sum(price) as price from wp_carts where session_id = '".$sessionid."'";
	  $priceResult = $wpdb->get_row($priceqry, ARRAY_A);
	  
	  $total =  $priceResult['price'] + $_SESSION["shipment_price"]; ?>
                  <div class="order-right right pull-right" id="recurring_order_price"></div>
                </div>
              </div>
            </div>
            
            <!-- <aside>
          <h5>Recurring order</h5>
          <p>Now you'll setup your recurring order</p>
          <p>Prices includes shipping & sales tax</p>
          </aside>--> 
            <!--<div class="order detail">
          <ul>
	 <?php
           /*
            global $wpdb;
            $sessionid = $_COOKIE['PHPSESSID'];
            $query = "Select * from wp_carts where session_id='$sessionid'";
            
            $results = mysql_query($query);
            while($rows = mysql_fetch_assoc($results)){
	       $pettype = $rows['pet_type'];
	       ?>
                <li>
                <div class="left"><?php if($pettype == 0) { echo 'Dog'; }else { echo 'Cat'; }?> - <?php echo $rows['pet_name'] ;?></div>
                <div class="right">Weight: <?php echo $rows['pet_weight'] ;?> lbs</div>
                </li>
            <?php }*/ ?>

          </ul>
          </div>--> 
            
          </article>
        </div>
      </div>
      <div class="right-bg"></div>
    </div>
  </div>
</div>
