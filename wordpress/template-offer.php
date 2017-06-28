<?php
/*
Template Name: Offer
*/
?>

<?php #get_template_part('templates/page', 'header'); ?>
<div class="heading-txt">
  <?php $offer_sub_title = get_field('offer_sub_title');  ?>
  <h1><span class="capital-case"><?php echo roots_title(); ?></h1>
  <h2><?php echo $offer_sub_title ?></h2>
</div>
<?php get_template_part('templates/content', 'page'); ?>
<div class="section-15">
<div class=" container">
  <?php
			$product_cta_band_title = get_field('product_cta_band_title');
			$product_cta_band_description = get_field('product_cta_band_description');
			#$product_cta_thumbnail = get_field('product_cta_thumbnail');
			$attachment_id = get_field('product_cta_thumbnail');
			$size = "full"; 
			$image = wp_get_attachment_image_src( $attachment_id, $size );
			$alt_text = get_post_meta($attachment_id , '_wp_attachment_image_alt', true);
			$product_cta_right_images = get_field('product_cta_right_images');
				echo ' <div class="heading-txt"><h2>' . $product_cta_band_title . '</h2></div>';
				echo '<div class="col-xs-9"><div class="article">';
				echo '<figure><img src="' . $image[0] . ' " alt="'. $alt_text . '" /></figure>';
				echo '<aside>' . $product_cta_band_description . '</aside>' ;
				echo '</div></div>';
				echo '<div class="col-xs-3"><div class="links-bg">';
				echo $product_cta_right_images;
				echo '</div></div>';
    ?>
</div>
</div><!-- /.section-15 -->
