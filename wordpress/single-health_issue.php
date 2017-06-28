<div class="container">
<div class="heading-txt">
  <?php $health_issue_sub_title = get_field('health_issue_sub_title');  ?>
  <h1><?php echo roots_title(); ?></h1>
  <h2><?php echo $health_issue_sub_title ?></h2>
</div>
<div class="allergi-block">
  <figure>
  <?php if ( has_post_thumbnail() ) {
	the_post_thumbnail('full', array('class' => 'alignleft'));
} ?></figure>
  <?php the_content(); ?>
</div>
<?php $health_issue_additional_content_band = get_field('health_issue_additional_content_band');  ?>
<div class="col-box-bg"> <?php echo $health_issue_additional_content_band ?> </div>
</div>
