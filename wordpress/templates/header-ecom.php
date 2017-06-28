<!-- Header -->
<header>
  <div class="container">
    <div class="logo"> <a href="<?php echo home_url('/') ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo get_field('logo', 'option');?>" alt="DARWINS1" /></a> </div>
    <a class="menu-btn" data-toggle="collapse" data-target=".menu-collapse"> <i class="fa fa-bars"></i> </a>
    <div class="shop-cart"> <a href="#" class="fa fa-shopping-cart"><span>Cart</span></a> </div>
    <div class="nav-bar">
      <!--<div class="caption-txt"><?php echo get_field('header_text', 'option');?>&nbsp; &nbsp;<?php echo get_field('phone', 'option');?></div>
      <div class="menu-collapse collapse">
        <nav>
          <?php
          //if (has_nav_menu('primary_navigation')) :
          //  wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'mnav'));
          //endif;
        ?>
        </nav>
        <div class="top-links">
          <?php
          //if (has_nav_menu('top_navigation')) :
          //  wp_nav_menu(array('theme_location' => 'top_navigation', 'menu_class' => ''));
          //endif;
        ?>
        </div>
        <div class="search-box">
          <form role="search" method="get" class="search-form form-inline" action="<?php echo home_url('/'); ?>">
            <div class="input-bg">
              <input value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" type="search" class="input" placeholder="Search..." />
              <div class="search-btn">
                <input name="" type="submit" class="search-icon" />
              </div>
            </div>
          </form>
        </div>
      </div>-->
    </div>
  </div>
</header>
<!-- /.header --> 

