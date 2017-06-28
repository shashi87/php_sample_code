<?php
/*
Template Name: Flow
*/
?>
<?php //get_header(); ?>
<?php //get_template_part('templates/content', 'page');
  //  print_r($_SESSION);
//session_destroy();
	global $wpdb;
     $pet_type = $_SESSION['pet_type'];
	 if(isset($_SESSION) && !empty($_SESSION['category']))
	 {
		$category = $_SESSION['category'];
	 }
	 else{
		$_SESSION['category']=1;
		$category = $_SESSION['category'];
	 }
     
	 
     $qry = "select * from wp_petweight where pet_type = '".$pet_type."'";
     $result = $wpdb->get_results($qry, ARRAY_A);
	
?>

<div class="section-8">
  <div class="container">
    <div id="loading-image"></div>
    <div class="flow-outer">
      <div class="col-xs-8">
        <div class="left-col-st">
          <div class="steps">
            <ul>
              <li class="current">1 About Your Pets</li>
              <li>2 Select Product</li>
              <li>3 Select Meats</li>
            </ul>
          </div>
          <div class="heading-top">
            <h2>Step 1 - Tell Us About Your Pet</h2>
          </div>
          <div class="cart-bg">
            <div class="form-block">
              <form action="/step-2" method="post" id="step1Form">
                <ul>
                  <li class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                      <label class="top">What is your pet's name?</label>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                      <input name="petname" id="petname" type="text" value="" class="input">
                      <input name="category" id="category" type="hidden" value="<?php echo $category; ?>" class="input" >
                    </div>
                  </li>
                  <li class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                      <label>My pet is a:</label>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5"> <span class="radio-bg">
                      <input name="pettype" type="radio" value="0" <?php if($pet_type==0){ echo 'checked="checked"'; } ?> class="radio1" />
                      <span class="txt1">Dog</span> </span> <span class="radio-bg">
                      <input name="pettype" id type="radio" value="1" <?php if($pet_type==1){ echo 'checked="checked"'; } ?>  class="radio1" />
                      <span class="txt1">Cat</span> </span> </div>
                  </li>
                  <li class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                      <label>How much does your pet weigh? <br />
                        <span> For puppies and kittens, enter their expected adult weight</span></label>
                    </div>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                      <select name="weight" id="weight" class="select">
                        <option value="">Select Weight...</option>
                        <?php  foreach ( $result as $row )  { ?>
                        <option value="<?php echo $row['petweight']; ?>"><?php echo $row['petweight']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </li>
                  <li class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                      <label class="top">What would be the delivery location?</label>
                    </div>
                   <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                      <?php $readonly = ""; //if(isset($_SESSION)){ $readonly = "readonly";} ?>
                      <input name="zipcode" maxlength="5" id="zipcode" type="text" class="input" <?php echo $readonly;  ?> placeholder="Enter zip code" value="<?php if(isset($_SESSION)){ echo $_SESSION['zipcode'];}?>"/>
                    </div>
                  </li>
                </ul>
                <div class="bott-links"> 
                <ul><li>
                  <!--<div class="txt-link">-->
                  <div class="row">
                    <!--<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 voffset"> <a href="javascript:void();" onclick="history.go(-1);" class="read-more">&lt; Back to product page</a> </div>-->
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 voffset">
                      <input type="button" id="savepet" name="savepet" value="Add another pet" class="btn1">
                      <!--<a href="#" class="read-more rightal" id="savepet" >Add another pet</a>
					 <input type="submit"  id ="savepet" class="linkclass" id="savepet" value="Save &amp; add another pet" >--> 
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 voffset">
                      <input type="button" id="savecontinue" name="savecontinue" value="Save &amp; Continue &gt;" class="btn pull-right">
                    </div>
                  </div></li></ul>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div  id="left_bar" class="col-xs-4 right-r">
        <div class="right-col-st">
          <article>
            <h3>Summary</h3>
            <div class="order detail">
              <div class="cart-info">
                <?php
           
            global $wpdb;
            $sessionid = $_COOKIE['PHPSESSID'];
            $query = "Select * from wp_carts where session_id='$sessionid'";
            
            $results = mysql_query($query);
			if($results){
				while($rows = mysql_fetch_assoc($results)){
					//print_r($rows);
					$pettype = $rows['pet_type'];
					$category_id = $rows['category_id'];
					?>
                
                  <div class="row voffset-small">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                      <span class="label"><?php if($pettype == 0) { echo 'Dog'; }else { echo 'Cat'; }?>
                      - <span class="text-capitalize"><?php echo $rows['pet_name'] ;?></span></span></div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-weight">Weight: <?php echo $rows['pet_weight'] ;?> lbs</div>
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                      <div class="crossBtn" id="crossBtn_<?php echo $rows['id']; ?>" onclick="deletediv(<?php echo $rows['id']; ?>,<?php echo $pettype; ?>,<?php echo $category_id; ?>);">
                        <input type="hidden" value="<?php echo $rows['id']; ?>" id="recordid" style="display:none;"  />
                      </div>
                    </div>
                  </div>
                
                <?php } } ?>
              </div>
            </div>
          </article>
        </div>
      </div>
      <div class="right-bg"></div>
    </div>
  </div>
</div>
