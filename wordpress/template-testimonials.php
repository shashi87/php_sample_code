<?php
/*
Template Name: Testimonials
*/
?>

<div class="container">
<?php get_template_part('templates/page', 'header'); ?>
  <?php
  $testimonial_type_selector = get_field('testimonial_type_selector');
		$args= array(
					'post_type'=>'testimonial',
					'post_status'=>'publish',
					'posts_per_page' => -1,
					'orderby'         => 'ID',
					'order'           => 'ASC',
					'tax_query'        => array(
					array(
						'taxonomy' => 'testimonial-category',
						'field'    => 'slug',
						'terms'    => $testimonial_type_selector,
					),
				),
		);

		$query = new WP_Query( $args);
		if ( $query->have_posts() ) : ?>
  <div class="testimonial-list">
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <blockquote class="testimonial-item">
      <?php if ( has_post_thumbnail() ) {
				the_post_thumbnail('full', array( 'class' => 'alignleft' ) );
			} ?>
      <div class="quote"> <?php echo get_the_content(); ?> </div>
      <div class="quote-by">
        <?php the_title(); ?>
      </div>
    </blockquote>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>
  <!-- show pagination here -->
  <?php else : ?>
  <!-- show 404 error here -->
  <?php endif; ?>
</div>
<?php get_template_part('templates/content', 'page'); ?>
