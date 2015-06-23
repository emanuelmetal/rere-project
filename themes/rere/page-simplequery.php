<?php /*
Template Name: Simplequery
*/ ?>

<?php get_header(); ?>
<!-- ss3.php -->
<div id="main">
<?php
global $page_title;
$current_category = single_cat_title("", false); 

if (is_page()) {
	$page_title = get_the_title();
} else {
	$page_title = $current_category;
}

$current_category = single_cat_title("", false); 
$description = category_description();


?>

	<div id="content-wide">
			<?php if(have_posts()):?>
			<?php while(have_posts()): the_post();?>
			<h2><?php the_title();?></h2>
			<?php the_content('');?>
			<?php endwhile;?>
		<?php else:?>
			<h2>Not Found</h2>
			<p>Sorry, but you are looking for something that isn't here.</p>
		<?php endif;?>
		<?php 
			if($current_category == "x") {
				query_posts(array(
				'post_type'=>'Gallery',
				'category_name'=>"home-images"
					));
			} else {
				query_posts(array(
				'post_type'=>'Gallery',
				'category_name'=>$current_category .  "-images"
					));
			}
		?>	
		<?php if(have_posts()):?>
		<div style="position: relative; z-index: 20;">			


		</div>

		<?php endif;?>

	</div>
	
</div>
<?php get_footer(); ?>
