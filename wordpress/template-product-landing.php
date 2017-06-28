<?php
/*
Template Name: Product Landing
*/
?>

<div class="container">
  <div class="heading-txt">
    <?php $product_landing_sub_title = get_field('product_landing_sub_title');  ?>
    <?php $main_products_heading = get_field('main_products_heading');  ?>
    <h1><?php echo roots_title(); ?></h1>
    <h2><?php echo $product_landing_sub_title ?></h2>
  </div>
</div>
<div class="section-9">
  <div class="container">
    <?php
	$pet_type_selector = get_field('pet_type_selector');
		$args= array(
			'post_type'=>'product',
			'post_status'=>'publish',
			'posts_per_page'=>'2',
			'orderby'         => 'ID',
      		'order'           => 'ASC',
			'tax_query'        => array(
					array(
						'taxonomy' => 'product-category',
						'field'    => 'slug',
						'terms'    => $pet_type_selector,
					),
				),
		);

		$query = new WP_Query( $args);
		if ( $query->have_posts() ) : ?>
    <?php
	if ($main_products_heading) {
	echo '<h2>' . $main_products_heading . '</h2>';
	} ?>
    <div class="aside-bg">
      <?php while ( $query->have_posts() ) : $query->the_post(); ?>
      <?php $product_line_type = get_field('product_line_type');  ?>
      <?php $product_landing_intro = get_field('product_landing_intro');  ?>
        <?php if( have_rows('product_image_list') ): ?>
          <?php $i = 0; ?>
          <?php while( have_rows('product_image_list') ): the_row();
            if($i==0){
            // vars
            $image_id = get_sub_field('product_image');
            $image_arr = wp_get_attachment_image_src($image_id, 'medium');

            }
          ?>
          <?php $i++; ?>
          <?php endwhile; ?>
        <?php endif; ?>
      <aside>
        <?php echo '<figure style="background:url(' . $image_arr[0]  . ')"></figure>'; ?>
        <h4><?php the_title(); ?><br>
          <span class="capital-case"><?php echo $product_line_type . ' Line' ; ?></span>
        </h4>
        <?php echo $product_landing_intro ?>
        <div class="read-more-bg"> <a href="<?php the_permalink(); ?>" class="read-more">Learn More</a> </div>
      </aside>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <!-- show pagination here -->
    <?php else : ?>
    <!-- show 404 error here -->
    <?php endif; ?>
  </div>
</div>
<?php
		if( have_rows('related_products_list') ): ?>
<div class="section-10">
  <div class="container">
  <?php $product_description = get_field('related_products_heading');  ?>
    <h2><?php echo $product_description; ?></h2>
    <div class="aside-bg">

    <?php

			while ( have_rows('related_products_list') ) : the_row();

        $product_id = get_sub_field('related_products_selector');

?>
<?php if( $product_id ): ?>
    <?php foreach( $product_id as $post): // variable must be called $post (IMPORTANT) ?>
        <?php setup_postdata($post); ?>
        <?php $p_url = get_permalink(); ?>
        <?php $product_landing_intro = get_field('product_landing_intro'); ?>
        <?php if( have_rows('product_image_list') ): ?>
        <?php $i = 0; ?>
          <?php while( have_rows('product_image_list') ): the_row();
            if($i==0){
              // vars
              $image_id = get_sub_field('product_image');
              $image_arr = wp_get_attachment_image_src($image_id, 'medium');
            }
          ?>
          <?php $i++; ?>
          <?php endwhile; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; ?>
<?php
				// 2 Column Layout
				echo '<aside>';
				$related_products_title = get_sub_field('related_products_title');
				echo '<figure style="background:url(' . $image_arr[0]  . ')"></figure>';
				echo '<h4><a href="'.$p_url.'">' . $related_products_title . '</a></h4>';
				echo '<p>' . $product_landing_intro . '</p>';
				echo '</aside>';




			endwhile;

    ?>
    </div>
  </div>
</div>
<?php endif; ?>
<?php
		if( have_rows('additional_content_bands') ):
			while ( have_rows('additional_content_bands') ) : the_row();

			// Band Title
				if( get_row_layout() == 'band_title' ):
					$section_title = get_sub_field('section_title');
					echo '<div class="container band-title">';
					echo '<h3>' . $section_title . '</h3>';
					echo '</div>';
				endif;

				// Band Title
				if( get_row_layout() == 'band_link' ):
					$section_link_label = get_sub_field('section_link_label');
					$section_link = get_sub_field('section_link');
					echo '<div class="container band-link text-center">';
					echo '<a href="' . $section_link . '" class="read-more">' . $section_link_label . '</a>';
					echo '</div>';
				endif;
				// 3 Column Layout
				if( get_row_layout() == 'three_column_layout' ):
				echo '<div class="section-11"><div class="container"><div class="aside-bg">';
					$column_text_1 = get_sub_field('column_text_1');
					$column_text_2 = get_sub_field('column_text_2');
					$column_text_3 = get_sub_field('column_text_3');
					echo '<aside>' . $column_text_1 . '</aside>';
					echo '<aside>' . $column_text_2 . '</aside>';
					echo '<aside>' . $column_text_3 . '</aside>';
					echo '</div></div></div>';
				endif;

				// 2 Column Layout
				if( get_row_layout() == 'two_column_layout' ):
				echo '<div class="section-12"><div class="container">';
					$column_2_text_1 = get_sub_field('column_2_text_1');
					$column_2_text_2 = get_sub_field('column_2_text_2');
					echo '<aside>' . $column_2_text_1 . '</aside>';
					echo '<aside>' . $column_2_text_2 . '</aside>';
					echo '</div></div>';
				endif;

				// 2 Box Layout
				if( get_row_layout() == 'box_layout' ):
				echo '<div class="section-13"><div class="container">';
					$column_3_text_1 = get_sub_field('column_3_text_1');
					$column_3_text_2 = get_sub_field('column_3_text_2');
					echo '<article><aside>' . $column_3_text_1 . '</aside></article>';
					echo '<article><aside>' . $column_3_text_2 . '</aside></article>';
					echo '</div></div>';
				endif;


			endwhile;
		endif;
    ?>
