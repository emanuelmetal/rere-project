<?php /*
Template Name: SS2
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
	<div id="content">
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
	<div id="sidebar">
		<div class="section form-holder">
			<h2><a href="/manifesto">MANHATTAN MANIFESTO</a></h2>
			<h2><a href="/navigating-highlights">NAVIGATING HIGHLIGHTS</a></h2>
			<?php get_search_form(); ?>
			<br/><br/><hr/><br/><h2><a href="http://re-re.info/search">Property Locator</a></h2><br/>
		</div>
		<?php query_posts(array(
				'cat'=>upcomingUpdatesCategoryID,
				'showposts'=>3,
					));?>
		<?php if(have_posts()):?>
		<div class="section list-holder">
			<h2>Upcoming UPDATES</h2>
			<ul class="list">
				<?php while(have_posts()): the_post();?>
				<li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
				<?php endwhile;?>
			</ul>
		</div>
		<?php endif;?>
		<?php wp_reset_query();?>
		<?php query_posts(array(
				'cat'=>galleryCategoryID,
				'showposts'=>3,
					));?>
		<?php print_r($query);?>
		<?php if(have_posts()):?>
		<?php $posts_count=0?>
		<?php while(have_posts()): the_post();?>
		<?php $posts_count++?>
		<div class="section">
			<?php if($posts_count==1):?>
			<h2>Shortcuts (to vital information)</h2>
			<?php endif;?>
			<h3><?php /* the_title();n */ ?></h3>
			<div class="post">
				<?php if (has_post_thumbnail()){?><a href="<?php the_permalink();?>"><?php the_post_thumbnail('post-thumbnails')?></a><?php; }?>
				<?php the_content('');?>
				<a href="<?php the_permalink();?>">See More »</a>
			</div>
		</div>
		<?php endwhile; endif;?>
		<?php wp_reset_query();?>
		<?php dynamic_sidebar('right'); ?>
		<?php dynamic_sidebar('socials'); ?>
	</div>
</div>
<?php get_footer(); ?>
