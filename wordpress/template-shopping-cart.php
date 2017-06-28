<?php
/*
Template Name: Shopping cart
*/
?>
<?php //get_header();
$total1= 0;
$recurring_order_lbs=0;
	if(isset($_SESSION) && !empty($_SESSION['intro_cost']))
	{
	 $introcost = $_SESSION['intro_cost'];
	}else{
	 $introcost = "14.95";
	}
	//echo '<pre>'; 	print_r($_SESSION);
	  $sessionid = $_COOKIE['PHPSESSID'];
	  $qry = "select * from wp_carts_final where session_id = '".$sessionid."'";
	  $result = $wpdb->get_results($qry, ARRAY_A);
	//  echo '<pre>';
	  //print_r($result);
	    /* code for Intro Order Delivery Date: */
	    // A time in London.
	  date_default_timezone_set("America/Los_Angeles");
	 // date('Y-m-d H:i:s');
	
	  foreach ( $result as $row ) {
	  // echo'<pre>';
	   //print_r($row);
	   $recurring_order_lbs += $row['pet_food'];
	   }
	  $currentday = date("N", strtotime( "today" ));
	  //echo "select * from wp_zip_codes where zipcode = '".$_SESSION['zipcode']."'".'<br>';
	  $getZipData = $wpdb->get_row("select * from wp_zip_codes where zipcode = '".$_SESSION['zipcode']."'",ARRAY_A);
	  $shipdays = $getZipData['shipday'];
	  if($currentday == 6 || $currentday == 7){
	       $delivery_date =  date('Y-m-d 23:59:00', strtotime( "next sunday" ));
	       $d = strtotime('+48 hours',strtotime($delivery_date));
	       $new_time = date('Y-m-d H:i:s',$d);
	  }else{
	       $delivery_date =  date('Y-m-d H:i:s', strtotime( "today" ));;
	       $d = strtotime('+48 hours',strtotime($delivery_date));
	       $new_time = date('Y-m-d H:i:s',$d);
	       $calculatedday = date("N", strtotime( $new_time ));
	       
	  }
	  $_SESSION['shipdayofweek'] = $shipdays;
	 //echo '<br>shipdays'.$shipdays;
	  switch($shipdays){
	       case 'M':
		    $shipday =1;
		    $shipdayname ='monday';
		    break;
	       case 'T':
		    $shipday =2;
		    $shipdayname ='tuesday';
		    
		    break;
	       case 'W':
		   $shipday =3;
		    $shipdayname ='wednesday';
		    break;
	       case 'Th':
		    $shipday =4;
		    $shipdayname ='thursday';
		    break;
	       case 'F':
		    $shipday =5;
		    $shipdayname ='friday';
		    break;
	       case 'SA':
		    $shipday =6;
		    $shipdayname ='Saturday';
		    break;
	       case 'Su':
		    $shipday =7;
		    $shipdayname ='Sunday';
		    break;	       
	  }
	//echo '<br>shipday'.$shipday;
	  if($calculatedday <= $shipday){
	       $deliverydate = $new_time;
	  }
	  else{//if($calculatedday > $shipdays){
	       $deliverydate = date('Y-m-d H:i:s',strtotime("$new_time  next monday"));
	  }
	  /*end code for Intro Order Delivery Date: */
	  /*code for Recurring Order Template Date */
	  $shipweeks = $_SESSION["shipping_weeks"]*10;
	  
	 // echo $recurring_order_lbs;
	  
	 
	   $totalweeks = round($shipweeks/$recurring_order_lbs) + 1;
	  
	  $template_date = strtotime("+$totalweeks weeks",strtotime($deliverydate));
	  $new_time1 = date('Y-m-d H:i:s',$template_date);
	    $temp= date('Y-m-d H:i:s',$template_date);
	    $timestamp = strtotime($temp);
	    $day = date('D', $timestamp);
	  
	  switch($day){
	       case 'Mon':
		    $finalday =1;
		    break;
	       case 'Tue':
		    $finalday =2;
		    break;
	       case 'Wed':
		   $finalday =3;
		   break;
	       case 'Thu':
		    $finalday =4;
		   break;
	       case 'Fri':
		    $finalday =5;
		    break;
	       case 'Sat':
		    $finalday =6;
		    break;
	       case 'Sun':
		    $finalday =7;
		    break;	       
	  }
	//echo $finalday."====";
	//echo $shipday."====";
	  if($shipday>$finalday){
	   
	    $numberOfDays=(int)$shipday-(int)$finalday;
	     $templatedate = date('Y-m-d H:i:s',strtotime($temp."+ ".$numberOfDays." days"));
	  }else{
	      $numberOfDays=$shipday-$finalday;
	      $templatedate = date('Y-m-d H:i:s',strtotime($temp.$numberOfDays." days"));
	   }
        $numberOfDays;
	$templatedate ;
          
	  

	// $calculatedday1 = date("N", strtotime( $new_time1 ));
	  //if($calculatedday1 <= $shipday){
	      //$templatedate = $new_time1;
	  //    $templatedate = date('Y-m-d H:i:s',strtotime("$new_time1  next $shipdayname"));
	  //}
	  //else{
	  //     $templatedate = date('Y-m-d H:i:s',strtotime("$new_time1  next monday"));
	  //}
	  /*end code for Recurring Order Template Date */
	  //echo 'deliverydate==>'. $deliverydate.'<br>';
	 // echo 'templatedate==>'. $templatedate;
	//echo '<br>'. $query = "INSERT INTO wp_orders (session_id,order_detail, status,total_price,delivery_date,template_date) VALUES ('$sessionid' , '$serilizedata','0','$price','$deliverydate','$templatedate')";
	  
	 // print_r($_POST);
	  if($_POST['addtocart']){
	     //  echo 'here';
	       
	       $price = $_POST['grandtotal'];
	       $serilizedata = mysql_real_escape_string(serialize($_POST));
	       $query = "INSERT INTO wp_orders (session_id,order_detail, status,total_price,delivery_date,template_date) VALUES ('$sessionid' , '$serilizedata','0','$price','$deliverydate','$templatedate')";
		$exequery = mysql_query($query);
	  }
	  
?>

<div class="section-8">
<div class="container">
     <div class="section-14">
          <div class="article-out-bg">
          <div class="article-out">
          <div class="heading-txt hide_mobile1">
          <div class="item-txt">
          <h4>Item</h4>
          </div>
          
          <div class="weight-txt">
          <h4>Weight</h4>
          </div>
          
          <div class="total-txt">
          <h4> Total</h4>
          </div>
          </div>
          
          
          <div class="article-in">
          <ul>
	  
             <li>
             
          <div class="col-full">
          <h4 class="voffset-bottom">Congratulations! <br class="hide_mobile1" /> You Qualify for Our Introductory Offer</h4>
          <div class="col-lg-2">
          <div class="left show_mobile1"><h4>Item</h4></div>
          <div class="right">
          <figure><img src="<?php echo bloginfo('template_url'); ?>/assets/img/photo32.jpg" alt="photo32" width="98" height="98" class="alignnone size-full wp-image-568" /></figure>
          
          </div>
          </div>
          <div class="col-lg-10">
         
          <div class="col-1">
          <aside class="clearfix ">
          <div class="aside-txt">
	  <?php foreach ( $result as $row ) { ?>
          
	  <?php
	  if($_SESSION['order_species']=="multiple" || $_SESSION['order_species']=="dog")
	    { 
	       if($row['category_id'] == 1){
		   echo  $heading = "<h5>Natural Selections Meals for Dogs</h5>";
	       } else if($row['category_id'] == 2){ 
		   echo  $heading = "<h5>Zoological Meals for Dogs</h5>";
	       }
	    }else{
		   echo  $heading = "<h5>Natural Selections Meals for cats</h5>";
	       }?>
	       
	  <?php } ?>
          <ul class="bullets">
          <li> This is a one-time shipment only</li>
          <li> Your card will only be charged $14.95 when shipped</li>
          <li> Price includes free shipping</li>
          </ul>
          <!--<p class="small">Your first order $14.95 will be charged when shipped.</p>-->
          </div>
          </aside>
          </div><div class="col-2">
          <div class="left show_mobile1">
          <h4>Weight</h4>
          </div>
          
          <div class="right"><div class="aside-txt">10 lbs.</div></div>
          </div>
          
          <div class="col-3">
          <div class="left show_mobile1">
          <h4>Total</h4>
          </div>
          
          <div class="right"><div class="aside-txt">$14.95</div></div>
          </div></div>
          </div>
          
          
          </li>
         <li><div class="col-12"><h4>Your Recurring Order</h4>
          
          <ul class="noborder repeatData<?php echo $i; ?> bullets compact">
	  <?php if(isset($_SESSION) && $_SESSION["order_species"] == 'multiple'){ ?>
          <li>Starting <?php echo $_SESSION["shipping_weeks"]; ?> weeks after your introductory order, your recurring order will be shipped to you every <?php echo $_SESSION["shipping_weeks"];?> weeks <span><!--<a href="/step-3/" >Change shipping frequency</a>--></span></li>
	  <?php }else{ ?>
	  
	   <li class="shipfeq">Starting 2 weeks after your introductory order, your recurring order will be shipped to you every <?php echo $row['weeks'];?> weeks <span><!--<a href="/step-3/" >Change shipping frequency</a>--></span></li>
          <?php } ?>
          <li>Price includes shipping</li>
          <li>You'll receive a reminder email a few days before each shipment</li>
          
          <li>Your card will be charged at time of shipment</li>
          
          <li><strong>No risk or obligation</strong> - you can change, postpone, or cancel your deliveries at any time before shipment</li>
          </ul></div></li>
          <li><div class="col-sm-2">
          <div class="left show_mobile1"><h4>Item</h4></div>
          <div class="right">
          <figure><img src="<?php echo bloginfo('template_url'); ?>/assets/img/photo33.jpg" alt="photo33" width="98" height="98" class="alignnone size-full wp-image-569" /></figure>
          <aside class="aside-bottom">
          
          </aside></div></div>
          <div class="col-sm-10">
          
          <?php
$price=0; $i=1;
	  //echo '<pre>';print_r($_SESSION);
	  foreach ( $result as $row ) {
	    $food1 = $row['pet_round_weight']*2;
				$total = $row['beef']+$row['chicken']+$row['duck']+$row['turkey']+$row['bison'];
				$tatalfinal = $total*2;
	   
	   
	   ?>
          <div id="petreccuring<?php echo $i; ?>">
          <div class="col-1"><aside class="aside-bottom">
          
	  <?php  if($row['pet_type']==0) { ?>
	       <div class="aside-txt">
          <h5><?php
	       if($row['category_id'] == 1){
		    echo "Natural Selections Meals for Dogs";
	       } else if($row['category_id'] == 2){ 
		    echo "Zoological Meals for Dogs";
	       } ?>
	  
	  </h5>
          <ul class="bullets">
          <li><?php $keyData = array_keys($row);
	 // print_r($keyData);
	  echo ucwords('beef').' - '.$row['beef'].' packages'; ?></li>
          <li><?php echo ucwords('chicken').' - '.$row['chicken'].' packages'; ?></li>
          <li><?php echo ucwords('duck').' - '.$row['duck'].' packages'; ?></li>
          <li><?php echo ucwords('turkey').' - '.$row['turkey'].' packages'; ?></li>
          <!--<li><?php //echo ucwords('bison').' - '.$row['bison'].' packages'; ?></li>-->
          </ul>
          </div>
	  <?php	  }	
	  else
	  { ?>
	    <div class="aside-txt">
          <h5><?php if($row['category_id'] == 3){ echo "Natural Selections Meals for Cats"; } ?></h5>
          <ul class="bullets">
          <li><?php echo ucwords('chicken').' - '.$row['chicken'].' packages'; ?></li>
          <li><?php echo ucwords('duck').' - '.$row['duck'].' packages'; ?></li>
          <li><?php echo ucwords('turkey').' - '.$row['turkey'].' packages'; ?></li>
          </ul>
          </div>   
	<?php  } ?>
          
          </aside>
          </div>
          
          
          
          <div class="col-2">
          <div class="left show_mobile1">
          <h4>Weight</h4>
          </div>
          
          <div class="right"><div class="aside-txt"><?php echo $tatalfinal.' lbs.'; ?></div></div>
          </div>
          
          <div class="col-3">
          <div class="left show_mobile1">
          <h4> Total</h4>
          </div>
          
          <div class="right"><div class="aside-txt"><?php
	  $total = $row['price'] + $_SESSION['shipment_price'];
	  echo '$'.number_format($total, 2, '.', '');
	  $price += $total;
	  
	  ?></div></div>
          </div>
          </div><?php $i++;  }
		  
	  ?>
      </div></li>
          </ul>
          <div class="clearfix voffset" style="padding-top:20px; clear:both;">Your first order is $14.95 with free shipping.<br/> You will only be charged for this when it is shipped.</div>
           <form action="/checkout-step-1/" method="post"/>
          <div class="total-txt">
          <ul>
	       <li>
	       <div class="text-left voffset">Special Instructions</div>
	       <textarea name="specialinstructions" rows="1" cols="50" value="Special Instructions">
<?php if(!empty($_SESSION['specialinstructions'])) {echo $_SESSION['specialinstructions'];}else{ echo 'Special Instructions';}  ?>
</textarea>
          
	       </li>
          </ul>
          </div>
          <div class="row voffset">
	       <div class="col-lg-6"><a class="prev-link" href="/step-3a/">Back</a></div>
	      <!-- <div class="col-lg-6"> <a href="/checkout-step-1/" class="btn">Checkout Now</a></div>-->
	      <div class="col-lg-6"> <input type="submit" name="checkoutnow" class="btn" value="Checkout Now"></div>
	  </div>
         </form>
          </div>
          </div>
          
          <div class="logo-section">
	       <div class="cont-us">
		    <div class="icon"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/img-icon04.png" alt="img-icon04" width="32" height="31" class="alignnone size-full wp-image-570" /></div>
		    <aside>
		    <p>Checkout By Phone</p>
		    <h4>1-877-738-6325</h4>
		    </aside>
	       </div>
	       
	       <ul>
		    <li><a href="#"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/logo-mcafee-secure.png" alt="logo-mcafee-secure" width="88" height="48" class="alignnone size-full wp-image-566" /></a></li>
		    <li><a href="#"><img src="<?php echo bloginfo('template_url'); ?>/assets/img/logo-norton-secured.png" alt="logo-norton-secured" width="90" height="49" class="alignnone size-full wp-image-567" /></a></li>
	       </ul>
          </div>
          
          <div class="logo-section-bg"></div>
          </div>
     </div>
     
</div>
</div>
