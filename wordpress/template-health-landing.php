<?php
/*
Template Name: Health Landing
*/
?>

<div class="container">
  <div class="heading-txt">
  <?php $health_issues_subtitle = get_field('health_issues_subtitle');  ?>
    <h1><?php echo roots_title(); ?></h1>
    <h2><?php echo $health_issues_subtitle ?></h2>
  </div>
</div>
<div class="article-catelist">
  <div class="container">
  <?php $dogs_section_title = get_field('dogs_section_title');  ?>
    <h2><?php echo $dogs_section_title ?></h2>
    <div class="article-bg">
      <?php
		$args= array(
			'post_type'=>'health_issue',
			'post_status'=>'publish',
			/*'posts_per_page'=>'6',*/
			'orderby'         => 'ID',
      		'order'           => 'ASC',
			'tax_query'        => array(
					array(
						'taxonomy' => 'health-issue-for',
						'field'    => 'slug',
						'terms'    => 'dogs',
					),
				),
		);		
	
		$query = new WP_Query( $args);
		if ( $query->have_posts() ) : ?>
         <?php $term =	$wp_query->queried_object;
echo '<h1>'.$term->name.'</h1>';?>
      <?php while ( $query->have_posts() ) : $query->the_post(); ?>
      <article>
        <figure><a href="<?php the_permalink(); ?>">
          <?php if ( has_post_thumbnail() ) {
	the_post_thumbnail('full', array('class' => 'alignleft'));
} ?>
          </a></figure>
        <aside>
          <h4><a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
            </a></h4>
          <div class="health-excerpt">
            <?php the_excerpt(); ?>
            <!--<a href="<?php the_permalink(); ?>" class="read-more-sml">More ></a>--></div>
        </aside>
      </article>
      <?php endwhile; wp_reset_postdata(); ?>
      <!-- show pagination here -->
      <?php else : ?>
      <!-- show 404 error here -->
      <?php endif; ?>
    </div>
    <?php 
	$learn_more_label_dogs = get_field('learn_more_label_dogs');
	$learn_more_link_dogs = get_field('learn_more_link_dogs');
	 ?>
    <div class="read-more-bg"> <a href="<?php echo $learn_more_link_dogs; ?>" class="read-more"><?php echo $learn_more_label_dogs; ?></a> </div>
  </div>
</div>
<div class="article-catelist bg-white">
  <div class="container">
    <?php $cats_section_title = get_field('cats_section_title');  ?>
    <h2><?php echo $cats_section_title ?></h2>
    <div class="article-bg">
      <?php
		$args= array(
			'post_type'=>'health_issue',
			'post_status'=>'publish',
			/*'posts_per_page'=>'4',*/
			'orderby'         => 'ID',
      		'order'           => 'ASC',
			'tax_query'        => array(
					array(
						'taxonomy' => 'health-issue-for',
						'field'    => 'slug',
						'terms'    => 'cats',
					),
				),
		);		
	
		$query = new WP_Query( $args);
		if ( $query->have_posts() ) : ?>
      <?php while ( $query->have_posts() ) : $query->the_post(); ?>
      <article>
        <figure><a href="<?php the_permalink(); ?>">
          <?php if ( has_post_thumbnail() ) {
	the_post_thumbnail('full', array('class' => 'alignleft'));
} ?>
          </a></figure>
        <aside>
          <h4><a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
            </a></h4>
          <div class="health-excerpt">
            <?php the_excerpt(); ?>
            <!--<a href="<?php the_permalink(); ?>" class="read-more-sml">More ></a>--></div>
        </aside>
      </article>
      <?php endwhile; wp_reset_postdata(); ?>
      <!-- show pagination here -->
      <?php else : ?>
      <!-- show 404 error here -->
      <?php endif; ?>
    </div>
    <?php 
	$learn_more_label_cats = get_field('learn_more_label_cats');
	$learn_more_link_cats = get_field('learn_more_link_cats');
	 ?>
    <div class="read-more-bg"> <a href="<?php echo $learn_more_link_cats; ?>" class="read-more"><?php echo $learn_more_label_cats; ?></a> </div>
  </div>
</div>
