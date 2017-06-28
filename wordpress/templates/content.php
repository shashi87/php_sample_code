<article <?php post_class(); ?>>
  <h2 class="entry-title"><a href="<?php the_permalink(); ?>">
    <?php the_title(); ?>
    </a></h2>
  
  <?php 
	if (!is_search()) {
		get_template_part('templates/entry-meta'); 
		if ( get_the_post_thumbnail($post_id) != '' ) {
			the_post_thumbnail('large', array( 'class' => 'img-responsive featured-image' ) );
		} else {
			echo '<img src="';
			echo catch_that_image();
			echo '" alt="Featured Image" class="img-responsive featured-image" />';
		} 
	}
  ?>
  <div class="entry-summary">
    <?php the_excerpt(); ?>
  </div>
  <?php  if (!is_search()) { ?>
  <div class="entry-footer">
    <div class="entry-cats">Categories:
      <?php the_category(', '); ?>
    </div>
    <?php the_tags('<div class="entry-tags">Tags: ',', ','</div>'); ?>
  </div>
  <?php } ?>
</article>
