<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>
      <?php echo do_shortcode('[supsystic-social-sharing id="1"]') ?>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
