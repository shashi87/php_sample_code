<?php
/*
Template Name: Full Width
*/
?>

<?php 

$hero_image = get_field('hero_image');
$hero_title = get_field('hero_title');
$hero_subtitle = get_field('hero_subtitle');
$hero_description = get_field('hero_description');
echo '<div class="banner-main" style="background-image:url( ' . $hero_image . ');"><div class="container"><div class="heading-txt">';
  
      echo '<h1>' . $hero_title . '</h1>';
      echo '<h2>' . $hero_subtitle . '</h2>';
    echo '</div>';
	if ($hero_image) {
    echo '<div class="aside-bg">';
      echo '<aside>';
        echo '<p>' . $hero_description . '</p>';
		
		if( have_rows('hero_buttons') ):
				
					while ( have_rows('hero_buttons') ) : the_row();
					$hero_button_label = get_sub_field('hero_button_label');
					$hero_button_url = get_sub_field('hero_button_url');
					
					echo '<a href="' . $hero_button_url . '" class="btn">' . $hero_button_label . '</a>';
					
					endwhile;
			endif;
      echo '</aside>';
      echo '</div>';
	}
	  echo '</div></div>';
?>
<?php 
echo '<div class="section-box"><div class="container">';
$section_title = get_field('section_title');
echo '<h3 class="text-center">' . $section_title . '</h3>';
$loopCount = 0;
if( have_rows('box_items') ):
			while ( have_rows('box_items') ) : the_row();
				
				// 2 Box Full Width Layout
				if ($loopCount == 0) {
					echo '<div class="row">';
				}
				$loopCount ++;
				#$box_image = get_sub_field('box_image');
				$attachment_id = get_sub_field('box_image');
				$size = "full"; 
				$image = wp_get_attachment_image_src( $attachment_id, $size );
				$alt_text = get_post_meta($attachment_id , '_wp_attachment_image_alt', true);
				$box_title = get_sub_field('box_title');
				$box_text = get_sub_field('box_text');
				$box_more_text = get_sub_field('box_more_text');
				$box_more_text_url = get_sub_field('box_more_text_url');
				
				echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
						echo '<figure><img src="' . $image[0] . '" alt="'. $alt_text . '" /></figure>';
						echo '<aside>';
						  echo '<p class="text-green bold"><a href="' . $box_more_text_url . '">' . $box_title . '</a></p>';
						  echo '<p>' . $box_text . '</p>';
						  echo '<p class="text-right"><a class="read-more" href="' . $box_more_text_url . '">' . $box_more_text . '</a></p>';
						echo '</aside>';
					  
				echo '</div>';
				if ($loopCount == 2) {
					echo '</div>';
				$loopCount = 0;	
				}
			endwhile;
		endif;
echo '</div></div>';		
?>

<?php get_template_part('templates/content', 'page'); ?>
