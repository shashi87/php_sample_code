<?php get_template_part('templates/page', 'header'); ?>
<?php if (!have_posts()) : ?>

<div class="alert alert-warning">
  <?php _e('Sorry, no results were found.', 'roots'); ?>
</div>
<?php get_search_form(); ?>
<?php endif; ?>
<?php while (have_posts()) : the_post(); ?>
<?php get_template_part('templates/content', get_post_format()); ?>
<?php endwhile; ?>
<?php 
if (function_exists("wp_bs_pagination"))
    {
         wp_bs_pagination();
}
?>
