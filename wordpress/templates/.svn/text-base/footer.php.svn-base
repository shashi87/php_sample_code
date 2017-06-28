<!-- Footer
================================================== -->
<!--<script src="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/js/idTabs.js"></script>
<script src="<?php echo bloginfo('template_url');?>/validator/lib/jquery.js"></script>-->
<script src="<?php echo bloginfo('template_url');?>/validator/dist/jquery.validate.js"></script>
<script src="<?php echo bloginfo('template_url');?>/validator/jquery.maskedinput.js"></script>
<script src="<?php echo bloginfo('template_url');?>/assets/js/script.js"></script>
<footer>
  <div class="container"> <span class="cont-no"><?php echo get_field('phone', 'option');?></span>
    <div class="footer-links">
      <?php
          if (has_nav_menu('footer_navigation')) :
            wp_nav_menu(array('theme_location' => 'footer_navigation', 'menu_class' => ''));
          endif;
        ?>
    </div><!-- /.footer-links --> 
    <div class="footer-info">
      <div class="logo-section"> <?php echo get_field('footer_widget', 'option');?> </div>
      <div class="social-links">
        <ul>
          <?php if( have_rows('social_media', 'option') ):
			    while ( have_rows('social_media', 'option') ) : the_row();
					
					$social_channel_icon = get_sub_field('social_channel_icon', 'option');
					$social_channel_name = get_sub_field('social_channel_name', 'option');
					$social_channel_color = get_sub_field('social_channel_color', 'option');
					$social_channel_link = get_sub_field('social_channel_link', 'option');
					echo '<li><a href="' . $social_channel_link . '" style=" background:' . $social_channel_color . '" target="_blank" title="' . $social_channel_name . '" ><i class="fa ' . $social_channel_icon . '"></i></a></li>';
				endwhile;
			endif;
			?>
        </ul>
      </div>
      <div class="copy-right">
        <p> Copyright &copy; <?php echo date('Y'); ?>
          <?php bloginfo('name'); ?>. All Rights Reserved.</p>
      </div>
    </div><!-- /.footer-info -->
  </div>
</footer>
<!-- /.footer -->
<?php echo get_field('google_tag_code', 'option');?>
    <!-- Custom
     ================================================== -->
     <script src="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/js/app.js"></script>
    <!-- Accordion
     ================================================== -->
     <script src="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/js/accord.js"></script>

     <!-- SelectBox 
     ================================================== -->
     <script src="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/js/idTabs.js"></script>
<?php wp_footer(); ?>
