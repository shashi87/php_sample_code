<?php
/*
Template Name: Page With Sidebar
*/
?>

<div class="content-main" role="document">
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
    <?php get_template_part('templates/page', 'header'); ?>
    <div class="row">
    <main class="main col-lg-9" role="main">
      <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
      <?php endwhile; ?>
    </main>
    <!-- /.main -->
    <aside class="sidebar col-lg-3" role="complementary">
      <?php $sidebar_content = get_field('sidebar_content'); ?>
      <?php echo $sidebar_content; ?> </aside>
    <!-- /.sidebar -->
    </div>
  </div>
  <!-- /.content --> 
</div>
<!-- /.wrap --> 

