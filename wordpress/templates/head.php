<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php wp_head(); ?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
     <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
     <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
     <![endif]-->
     <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/css/magnific-popup.css"> 
    <!-- Magnific Popup core JS file -->
    <script src="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/js/jquery.magnific-popup.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		$('.open-popup-link').magnificPopup({
			type:'inline',
			midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
		});
	});
    </script>
  <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo esc_url(get_feed_link()); ?>">
  <link href="http://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet" type="text/css">
  <!-- Favicons -->
  <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo get_bloginfo ( 'stylesheet_directory' ); ?>/assets/img/favicon/apple-touch-icon-57x57.png" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_bloginfo ( 'stylesheet_directory' ); ?>/assets/img/favicon/apple-touch-icon-114x114.png" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_bloginfo ( 'stylesheet_directory' ); ?>/assets/img/favicon/apple-touch-icon-72x72.png" />
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_bloginfo ( 'stylesheet_directory' ); ?>/assets/img/favicon/apple-touch-icon-144x144.png" />
  <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo get_bloginfo ( 'stylesheet_directory' ); ?>/assets/img/favicon/apple-touch-icon-120x120.png" />
  <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo get_bloginfo ( 'stylesheet_directory' ); ?>/assets/img/favicon/apple-touch-icon-152x152.png" />
  <link rel="icon" type="image/png" href="<?php echo get_bloginfo ( 'stylesheet_directory' ); ?>/assets/img/favicon/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="<?php echo get_bloginfo ( 'stylesheet_directory' ); ?>/assets/img/favicon/favicon-16x16.png" sizes="16x16" />
  <meta name="application-name" content="Darwin's Natural Pet Food"/>
  <meta name="msapplication-TileColor" content="#FFFFFF" />
  <meta name="msapplication-TileImage" content="<?php echo get_bloginfo ( 'stylesheet_directory' ); ?>/assets/img/favicon/mstile-144x144.png" />
  <meta name="msapplication-notification" content="frequency=30;polling-uri=http://notifications.buildmypinnedsite.com/?feed=http://www.darwinspet.com/feed/&amp;id=1;polling-uri2=http://notifications.buildmypinnedsite.com/?feed=http://www.darwinspet.com/feed/&amp;id=2;polling-uri3=http://notifications.buildmypinnedsite.com/?feed=http://www.darwinspet.com/feed/&amp;id=3;polling-uri4=http://notifications.buildmypinnedsite.com/?feed=http://www.darwinspet.com/feed/&amp;id=4;polling-uri5=http://notifications.buildmypinnedsite.com/?feed=http://www.darwinspet.com/feed/&amp;id=5;cycle=1" />
  <link rel="stylesheet" href="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/css/jquery.mmenu.all.css"> 
  <script src="<?php echo get_bloginfo ( 'stylesheet_directory' );  ?>/assets/js/jquery.mmenu.min.all.js"></script>
  <script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu();
			});
		</script>
</head>
