<?php get_header(); ?>
<div id="main">
	<div id="content">
		<?php if(have_posts()):?>
			<?php while(have_posts()): the_post();?>
			<h2><a href="<?php the_permalink()?>"><?php the_title();?></a></h2>
			<p class="info" style="display: none;"><strong class="date"><?php the_time('F jS, Y') ?></strong> by <?php the_author(); ?></p>
			<?php the_excerpt(); ?>
			<div class="meta" style="display: none;">
				<ul>
					<li>Posted in <?php the_category(', ') ?></li>
					<li><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></li>
					<?php the_tags('<li>Tags: ', ', ', '</li>'); ?>
				</ul>
			</div>
			<?php endwhile;?>
			<div class="navigation">
				<div class="next"><?php next_posts_link('Older Entries &raquo;') ?></div>
				<div class="prev"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
			</div>
		<?php else:?>
			<h2>No posts found.</h2>
			<p> Try a different search?</p>
		<?php endif;?>
	</div>
	<div id="sidebar">
		<div class="section form-holder">
			<h2>MANHATTAN MANIFESTO</h2>
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
			<h2>Galleries</h2>
			<?php endif;?>
			<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
			<div class="post">
				<?php if (has_post_thumbnail()){?><a href="<?php the_permalink();?>"><?php the_post_thumbnail('post-thumbnails');?></a><?php }?>
				<?php $more=0; the_content('');?>
				<a href="<?php the_permalink();?>">See More »</a>
			</div>
		</div>
		<?php endwhile; endif;?>
		<?php wp_reset_query();?>
		<?php dynamic_sidebar('socials'); ?>
	</div>
</div>
<?php get_footer(); ?>
