<?php get_header(); 
	global $page_title;
	$page_title = get_the_title();
?>
<!-- page.php -->
<div id="main">
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
	</div>
<div id="sidebar">
		<div class="section form-holder">
				<h2><a href="http://www.re-re.info/manifesto">MANHATTAN MANIFESTO</a></h2>
			<h2><a href="http://www.re-re.info/navigating-highlights">NAVIGATING HIGHLIGHTS</a></h2>
			<?php get_search_form(); ?>
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
				<?php if (has_post_thumbnail()){?><a href="<?php the_permalink();?>"><?php the_post_thumbnail('post-thumbnails');?></a><?php }?>
				<?php the_content('');?>
				<a href="<?php the_permalink();?>">See More »</a>
			</div>
	</div>
		<?php endwhile; endif;?>
		<?php wp_reset_query();?>
		<?php dynamic_sidebar('socials'); ?>
	</div>
</div>
<?php get_footer(); ?>