<div class="container">
  <div class="heading-txt">
    <?php $product_sub_title = get_field('product_sub_title');  ?>
    <?php $product_line_type = get_field('product_line_type');  ?>
    <h1><span class="capital-case"><?php echo roots_title(); ?></span></h1>
    <h2><?php echo $product_sub_title ?></h2>
  </div>
  <div class="deatil-block">
    <div class="col-xs-4">
      <div class="section-slide">
        <div class="large-view">
          <?php
		  $rows = get_field('product_image_list');
		  $row_count = count($rows);
		  //echo $row_count;
		if( have_rows('product_image_list') ):
		$i = 0;
			while ( have_rows('product_image_list') ) : the_row();
				$attachment_id = get_sub_field('product_image');
				$size = "product-large"; 
				$image = wp_get_attachment_image_src( $attachment_id, $size );
				$alt_text = get_post_meta($attachment_id , '_wp_attachment_image_alt', true);
				echo '<figure id="';
				$i++;
				echo 'photo' . $i; 
				echo '"';
				if( $i == 1 )
					{ echo ' class="active"'; }
				echo ' ><img src="' . $image[0] . '" alt="' . $alt_text .  '" /></figure>';
			endwhile;
		endif;
    ?>
        </div>
        
        <?php if( $row_count > 1 ) { ?>
        <ul class="idTabs">
          <?php
		if( have_rows('product_image_list') ):
		$i = 0;
			while ( have_rows('product_image_list') ) : the_row();
				$attachment_id = get_sub_field('product_image');
				$size = "product-thumb"; 
				$image = wp_get_attachment_image_src( $attachment_id, $size );
				$alt_text = get_post_meta($attachment_id , '_wp_attachment_image_alt', true);
				echo '<li><a href="#';
				$i++;
				echo 'photo' . $i; 
				echo '"';
				if( $i == 1 )
					{ echo ' class="selected"'; }
				echo ' ><img src="' . $image[0] . '" alt="' . $alt_text .  '" /></a></li>';
			endwhile;
		endif;
    ?>
        </ul>
        <?php } ?>
      </div>
    </div>
    <div class="col-xs-8 right-r">
      <div class="article-box">
        <?php $product_overview = get_field('product_overview');  ?>
        <?php $product_description = get_field('product_description');  ?>
        <?php $product_purchase_label = get_field('product_purchase_label');  ?>
        <?php $product_intro_offer = get_field('product_intro_offer');  ?>
        <?php $buy_now_link = get_field('buy_now_link', 'option');  ?>
        <?php echo $product_overview ?>
        <?php if ($product_description) { ?>
        <aside>
          <div class="aside-in"><?php echo $product_description ?> 
          <?php if ($product_purchase_label) { ?> <a href="<?php echo $buy_now_link ?>" class="btn btn-product"><?php  echo $product_purchase_label  ?></a> <?php } ?>
          </div>
        </aside>
        <?php } ?>
        <div class="product-logo"><?php echo $product_intro_offer ?></div>
      </div>
    </div>
  </div>
  <!-- /.deatil-block -->
  <div class="section-tabs">
    <!--<div class="tab-links">
      <ul class="idTabs">-->
        <?php
    if( have_rows('product_information_tabs_band') ):
	$i = 0;
		while ( have_rows('product_information_tabs_band') ) : the_row();
			$product_tab_title = get_sub_field('product_tab_title');
			$tab_id = str_replace(' ', '', $product_tab_title);
			$product_tab_description = get_sub_field('product_tab_description');
			echo do_shortcode( '[tabby title="' . $product_tab_title .'"]' . $product_tab_description );
		endwhile;
		echo do_shortcode( '[tabbyending]' );
    endif;
    ?>
      <!--</ul>
    </div>
    <div class="tab-cont">-->
      <?php
    /*if( have_rows('product_information_tabs_band') ):
	$i = 0;
		while ( have_rows('product_information_tabs_band') ) : the_row();
			$product_tab_title = get_sub_field('product_tab_title');
			$product_tab_description = get_sub_field('product_tab_description');
			$tab_id = str_replace(' ', '', $product_tab_title);
			echo '<div id="' . $tab_id . '" class="accord-cont active"><aside>';
			echo $product_tab_description ;
			echo '</aside></div>';
		endwhile;
    endif;*/
    ?>
    <!--</div>-->
  </div>
  <!-- /.section-tabs --> 
</div>

