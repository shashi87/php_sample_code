<?php get_template_part('templates/head'); ?>
<body id="page" <?php body_class(); ?>>
<!--[if IE 9]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    </div>
  <![endif]--> 
<!--[if lt IE 9]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    </div>
  <![endif]-->

<?php
    do_action('get_header');
    // Use Bootstrap's navbar if enabled in config.php
    if (current_theme_supports('bootstrap-top-navbar')) {
      get_template_part('templates/header-top-navbar');
    } else {
      get_template_part('templates/header');
    }
  ?>
<?php if( is_front_page()) { ?>
<!-- Banner
================================================== -->
<?php
// Top Clicks Band Layout

$hero_image = get_field('hero_image');
$hero_title = get_field('hero_title');
$hero_subtitle = get_field('hero_subtitle');
$hero_description = get_field('hero_description');
echo '<div class="banner-main" style="background-image:url( ' . $hero_image . ');"><div class="container"><div class="heading-txt">';

      echo '<h1>' . $hero_title . '</h1>';
      echo '<h2>' . $hero_subtitle . '</h2>';
    echo '</div>';
    echo '<div class="aside-bg">';
      echo '<aside>';
        //echo '<p>' . $hero_description . '</p>';
        echo $hero_description;

		if( have_rows('hero_buttons') ):

					while ( have_rows('hero_buttons') ) : the_row();
					$hero_button_label = get_sub_field('hero_button_label');
					$hero_button_url = get_sub_field('hero_button_url');

					echo '<a href="' . $hero_button_url . '" class="btn">' . $hero_button_label . '</a>';

					endwhile;
			endif;
      echo '</aside><div class="links-bg">';
      echo '</div></div></div></div>';
?>

<!-- Content
================================================== -->

<?php
	if( have_rows('home_content_bands') ):
		while ( have_rows('home_content_bands') ) : the_row();

		// Top Clicks Band Layout
        if( get_row_layout() == 'top_clicks_band_layout' ):
		$team_section_title = get_sub_field('team_section_title');
		echo '<div class="section-1"><div class="container">';
        	if( have_rows('top_clicks_band') ):
			    while ( have_rows('top_clicks_band') ) : the_row();

					$attachment_id = get_sub_field('top_click_icon');
					$size = "full"; 
					$image = wp_get_attachment_image_src( $attachment_id, $size );
					$alt_text = get_post_meta($attachment_id , '_wp_attachment_image_alt', true);
					$top_click_title = get_sub_field('top_click_title');
					$top_click_description = get_sub_field('top_click_description');
					echo '<article>';
					echo '<div class="icon-bg"><img src="' . $image[0] . '" alt="'. $alt_text . '" /></div>';
					echo '<h2>' . $top_click_title . '</h2>';
					echo $top_click_description;
					echo '</article>';
				endwhile;
			endif;
			echo '</div></div>';
        endif;

		// Testimonial Layout
		if( get_row_layout() == 'testimonials_band_layout' ):
				$testimonial_band_color = get_sub_field('testimonial_band_color');
				$testimonial_band_title = get_sub_field('testimonial_band_title');
				$testimonial_band_customer_title = get_sub_field('testimonial_band_customer_title');
				$testimonial_band_experts_title = get_sub_field('testimonial_band_experts_title');

				echo '<div class="section-2" style="background: ' . $testimonial_band_color . ';" ><div class="container">';
				echo '<h2>' . $testimonial_band_title . '</h2>';
				echo '<div class="col-xs-5"><h4>' . $testimonial_band_customer_title . '</h4>';


		$args= array(
			'post_type'=>'testimonial',
			'post_status'=>'publish',
			'orderby'         => 'date',
      'order'           => 'DESC',
      'meta_query' => array(
          array(
            'key' => 'testimonial_is_featured',
            'value' => '1',
            'compare' => '=='
          )
        ),
			/*'showposts' => '2',*/
			'tax_query'        => array(
					array(
						'taxonomy' => 'testimonial-category',
						'field'    => 'slug',
						'terms'    => 'customer-quotes',
					),
				),
		);

		$query = new WP_Query( $args);
		if ( $query->have_posts() ) : ?>
<div class="testimonial-list">
  <?php while ( $query->have_posts() ) : $query->the_post();
                if( get_field('testimonial_is_featured') )
{
	echo '<article>';
	echo '<aside>';
	the_post_thumbnail('thumbnail', array( 'class' => 'alignleft testimonial-image' ));
	echo '<p>“' .  excerpt(31) . '</p>';
	echo '<p><span> — ' . get_the_title() . ' </span></p>';
	echo '</aside>';
	echo '</article>';

}
                 endwhile; wp_reset_postdata(); ?>
</div>
<!-- show pagination here -->
<?php else : ?>
<!-- show 404 error here -->
<?php endif;

			echo '<div class="read-more-bg"> <a href="#customer-testimonials" class="open-popup-link read-more">More ></a> </div></div>';
			echo '<div id="customer-testimonials" class="white-popup mfp-hide testimonials-popup customer-testimonials">';


		$args= array(
					'post_type'=>'testimonial',
					'post_status'=>'publish',
					'orderby'         => 'date',
					'order'           => 'DESC',
					'posts_per_page' => -1,
					'tax_query'        => array(
							array(
								'taxonomy' => 'testimonial-category',
								'field'    => 'slug',
								'terms'    => 'customer-quotes',
							),
						),
				);

				$query = new WP_Query( $args);
				if ( $query->have_posts() ) : ?>
<?php while ( $query->have_posts() ) : $query->the_post();
	echo '<article class="clearfix">';
	echo '<aside>';
	the_post_thumbnail('thumbnail', array( 'class' => 'alignleft testimonial-image' ));
	echo '<p>“' .  excerpt(31) . '</p>';
	echo '<p><span> — ' . get_the_title() . ' </span></p>';
	echo '</aside>';
	echo '</article>';
						 endwhile; wp_reset_postdata(); ?>
<!-- show pagination here -->
<?php else : ?>
<!-- show 404 error here -->
<?php endif;



			echo '</div>';
			echo '<div class="col-xs-5 right-r"><h4>' . $testimonial_band_experts_title . '</h4>';

			$args= array(
			'post_type'=>'testimonial',
			'post_status'=>'publish',
			'orderby'         => 'date',
      		'order'           => 'DESC',
			'tax_query'        => array(
					array(
						'taxonomy' => 'testimonial-category',
						'field'    => 'slug',
						'terms'    => 'expert-quotes',
					),
				),
		);

		$query = new WP_Query( $args);
		if ( $query->have_posts() ) : ?>
<div class="testimonial-list">
  <?php while ( $query->have_posts() ) : $query->the_post();
        if( get_field('testimonial_is_featured') ) {
			echo '<article>';
			echo '<aside>';
			the_post_thumbnail('thumbnail', array( 'class' => 'alignleft testimonial-image' ));
			echo '<p>“' .  excerpt(31) . '</p>';
			echo '<p><span> — ' . get_the_title() . ' </span></p>';
			echo '</aside>';
			echo '</article>';
		
		}
                 endwhile; wp_reset_postdata(); ?>
</div>
<!-- show pagination here -->
<?php else : ?>
<!-- show 404 error here -->
<?php endif;

			echo '<div class="read-more-bg"> <a href="#expert-testimonials" class="open-popup-link read-more">More ></a> </div></div>';

			echo '<div id="expert-testimonials" class="white-popup mfp-hide testimonials-popup expert-testimonials"> ';
$args= array(
					'post_type'=>'testimonial',
					'post_status'=>'publish',
					'orderby'         => 'date',
					'order'           => 'DESC',
					'posts_per_page' => -1,
					'tax_query'        => array(
							array(
								'taxonomy' => 'testimonial-category',
								'field'    => 'slug',
								'terms'    => 'expert-quotes',
							),
						),
				);

				$query = new WP_Query( $args);
				if ( $query->have_posts() ) : ?>
<?php while ( $query->have_posts() ) : $query->the_post();
			echo '<article class="clearfix">';
			echo '<aside>';
			the_post_thumbnail('thumbnail', array( 'class' => 'alignleft testimonial-image' ));
			echo '<p>“' .  excerpt(31) . '</p>';
			echo '<p><span> — ' . get_the_title() . ' </span></p>';
			echo '</aside>';
			echo '</article>';
						 endwhile; wp_reset_postdata(); ?>
<!-- show pagination here -->
<?php else : ?>
<!-- show 404 error here -->
<?php endif;


			echo '</div></div></div>';

        endif;

		// Conditions Layout
		if( get_row_layout() == 'conditions_band_layout' ):
		$conditions_band_title = get_sub_field('conditions_band_title');
				$conditions_dog_health_title = get_sub_field('conditions_dog_health_title');
				$conditions_band_image = get_sub_field('conditions_band_image');
				$conditions_cat_health_title = get_sub_field('conditions_cat_health_title');
				echo '<div class="section-3" style="background-image:url(' . $conditions_band_image . ');"><div class="container" >';
				
				echo '<h2>' . $conditions_band_title . '</h2>';
				echo '<article class="col-sm-5 col-md-5 col-lg-5">';
				echo '<h4>' . $conditions_dog_health_title . '</h4>';
        	if( have_rows('conditions_dog_health_links') ):
			 	echo '<ul class="dog-health">';
			    while ( have_rows('conditions_dog_health_links') ) : the_row();
					$dog_health_link = get_sub_field('dog_health_link');
					$dog_health_condition = get_sub_field('dog_health_condition');
					echo '<li><a href="' . $dog_health_link . '">' . $dog_health_condition . '</a></li>';
				endwhile;
				echo '</ul>';
			endif;

			echo '</article>';
			echo '<article class="col-sm-5 col-md-5 col-lg-5 col-lg-offset-2"><h4>' . $conditions_cat_health_title . '</h4>';
			if( have_rows('conditions_cat_health_links') ):
			 	echo '<ul class="cat-health">';
			    while ( have_rows('conditions_cat_health_links') ) : the_row();
					$cat_health_links = get_sub_field('cat_health_links');
					$cat_health_conditions = get_sub_field('cat_health_conditions');
					echo '<li><a href="' . $cat_health_links . '">' . $cat_health_conditions . '</a></li>';
				endwhile;
				echo '</ul>';
			endif;
			echo '</article>';
			echo '</div></div>';
        endif;


		// Advantage Band Layout
        if( get_row_layout() == 'advantage_band_layout' ):
		$advantage_band_title = get_sub_field('advantage_band_title');
		$advantage_band_color = get_sub_field('advantage_band_color');
		echo '<div class="section-4" style="background: ' . $advantage_band_color . ';"><div class="container"><h2>' . $advantage_band_title . '</h2><div class="aside-bg">';
        	if( have_rows('advantage_band_blocks') ):
			    while ( have_rows('advantage_band_blocks') ) : the_row();

					$advantage_image = get_sub_field('advantage_image');
					$advantage_title = get_sub_field('advantage_title');
					$advantage_link = get_sub_field('advantage_link');
					$advantage_description = get_sub_field('advantage_description');
					echo '<aside>';
					echo '<figure style="background-image:url(' . $advantage_image . ');"></figure>';
					echo '<h4><a href="' . $advantage_link . '" >' . $advantage_title . '</a></h4>';
					echo $advantage_description;
					echo '</aside>';
				endwhile;
			endif;
			echo '</div></div></div>';
        endif;

		// CTA Band Layout
        if( get_row_layout() == 'cta_band_layout' ):
		$cta_title = get_sub_field('cta_title');
		$cta_subtitle = get_sub_field('cta_subtitle');
		echo '<div class="section-5"><div class="container"><h2>' . $cta_title . '</h2><h4>' . $cta_subtitle . '</h4>';
        	if( have_rows('cta_buttons') ):
			    while ( have_rows('cta_buttons') ) : the_row();

					$cta_button_label = get_sub_field('cta_button_label');
					$cta_button_link = get_sub_field('cta_button_link');
					echo '<a href="' . $cta_button_link . '" class="btn">' . $cta_button_label . '</a>';
				endwhile;
			endif;
			echo '</div></div>';
        endif;


    endwhile;

else :
    // no layouts found
endif;
?>
<?php } else if ( is_home() || is_single() || is_archive()  || is_search() ) { ?>
<div class="container">
  <div class="breadcrumb">
    <p>
      <?php
      if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb();
		}
		?>
    </p>
  </div>
</div>
<div class="container">
  <div class="row">
    <main class="main <?php echo roots_main_class(); ?>" role="main">
      <?php include roots_template_path(); ?>
    </main>
    <!-- /.main -->
    <?php if (roots_display_sidebar()) : ?>
    <aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
      <?php include roots_sidebar_path(); ?>
    </aside>
    <!-- /.sidebar -->
    
    <?php endif; ?>
  </div>
</div>
<?php } else if ( is_page_template( 'template-page-with-sidebar.php' )) { ?>
<?php include roots_template_path(); ?>
<?php } else { ?>
<div class="content-main" role="document">
  <main class="main <?php echo roots_main_class(); ?>" role="main">
    <div class="container">
      <div class="breadcrumb">
        <p>
          <?php
      if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb();
		}
		?>
        </p>
      </div>
    </div>
    <?php include roots_template_path(); ?>
  </main>
  <!-- /.main -->
  <?php if (roots_display_sidebar()) : ?>
  <aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
    <?php include roots_sidebar_path(); ?>
  </aside>
  <!-- /.sidebar -->
  <?php endif; ?>
  
  <!-- /.content --> 
</div>
<!-- /.wrap -->
<?php } ?>

<?php 
if (is_singular( 'product' ) ) {
$product_cta_band_title = get_field('product_cta_band_title');
$product_cta_band_description = get_field('product_cta_band_description');
#$product_cta_thumbnail = get_field('product_cta_thumbnail');
$product_cta_right_images = get_field('product_cta_right_images');

$attachment_id = get_field('product_cta_thumbnail');
$size = "full"; 
$image = wp_get_attachment_image_src( $attachment_id, $size );
$alt_text = get_post_meta($attachment_id , '_wp_attachment_image_alt', true);
if ($product_cta_band_title) {
?>
<div class="section-15">
  <div class=" container">
    <?php
			
				echo ' <div class="heading-txt"><h2>' . $product_cta_band_title . '</h2></div>';
				echo '<div class="col-xs-9"><div class="article">';
				if ($product_cta_thumbnail) { 
				echo '<figure><img src="' . $image[0] . ' " alt="'. $alt_text . '" /></figure>';
				}
				echo '<aside>' . $product_cta_band_description . '</aside>' ;
				echo '</div></div>';
				echo '<div class="col-xs-3"><div class="links-bg">';
				echo $product_cta_right_images;
				
				echo '</div></div>';
    ?>
  </div>
</div>
<!-- /.section-15 --> 

<?php }
 } ?>


<?php get_template_part('templates/footer'); ?>
<nav id="menu">
  <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(array('theme_location' => 'primary_navigation',  'walker'=> new themeslug_walker_nav_menu() ));
          endif;
        ?>
</nav>
</body>
</html>