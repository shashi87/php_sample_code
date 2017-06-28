<?php if(is_page_template( 'template-health-landing.php' ) || is_page_template( 'template-product-landing.php' )) { ?>
<?php } else { ?>

<div class="container">
  <?php } ?>
  <?php while (have_posts()) : the_post(); ?>
  <?php the_content(); ?>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
  <?php endwhile; ?>
  <?php if(is_page_template( 'template-health-landing.php' ) || is_page_template( 'template-product-landing.php' )) { ?>
  <?php } else { ?>
</div>
<?php } ?>
