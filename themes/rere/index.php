<?php get_header(); ?>
<!-- index.php -->

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
		<?php 
			if($current_category == "") {
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

		<div class="gallery">
			<ul class="slide-show">
				
				<?php while(have_posts()): the_post();?>
				<li>
					<?php if (has_post_thumbnail()){?><a href="<?php the_permalink()?>">
					<?php /* oddness follows: get_the_post_thumbnail doesn't recognize a size change */
					echo get_the_post_thumbnail($page->ID, 'gallery-thumbnails');?></a><?php }?>
					<strong class="caption"><span><a href="<?php the_permalink()?>"><?php the_title();?></a></span><em></em></strong>
				</li>
				<?php endwhile;?>
			</ul>
			<div class="switcher">
				<div class="switcher-l"></div>
				<div class="switcher-holder">
				<?php $url = get_bloginfo('template_url'); ?>
					<a class="prev" href="#"><img src="<?php echo $url . '/images/back.gif'; ?>" style='margin: -6px 0 12px 0; height: 24px;'/></a>
					<a class="play-pause" href="#"><img src="<?php echo $url . '/images/stop.gif'; ?>" style='margin: -6px 0 12px 0;height: 24px;'/></a>
					<a class="next" href="#"><img src="<?php echo $url . '/images/forward.gif'; ?>" style='margin: -6px 0 12px 0; height: 24px;'/></a>
				</div>
				<div class="switcher-r"></div>
			</div>
			
		</div>
		</div>

		<?php endif;?>


			<div class="exclamation">
				<center><a href="#"><img src="<?php echo $url . '/images/punct2.jpg'; ?>" 
						style="padding: 0;"
title="Click on this island image to close the text below." />
				</a> 
				<div class="explanation">
				<br/>	<span class="colored1">Re</span>garding <span class="colored1">Re</span>al Estate makes the Manhattan realty world accessible and
understandable &mdash; whether you are a buyer or seller. Read <a class="exlink" href="http://re-re.info/manifesto/"><span class="colored2">Manhattan Manifesto</span></a>
(upper right) for an overview. <a class="exlink" href="http://re-re.info/navigating-highlights/"><span class="colored2">Navigating Highlights</span></a> (beneath Manhattan
Manifesto) explains how to get around the site. Our <a class="exlink" href="http://re-re.info/search/><span class="colored2">Property Locator</span></a> (also
upper right) will start a property search. <br/><br/>Hover your cursor over any of the
headings on the menu bar above, a drop-down menu of options will appear.<br/><br/>
Alternatively, click on a heading, and a new "landing page" pops up. On each
of these landing pages, you'll see a grid of nine, like the ones below.<br/><br/>
<a class="exlink" href="http://re-re.info/category/city-desk/"><span class="colored2">City Desk</span></a> has all the latest realty news;<br/><br/> <a class="exlink" href="http://re-re.info/category/mastering-manhattan/"><span class="colored2">Mastering Manhattan</span></a> contains our real
estate 'How-To;' <br/><br/><a class="exlink" href="http://re-re.info/category/dwellings/"><span class="colored2">Dwellings</span></a> details the different kinds of properties available
in Manhattan; <br/><br/><a class="exlink" href="http://re-re.info/category/of-human-interest/"><span class="colored2">Of Human Interest</span></a> describes the Manhattan lifestyles of different
properties and neighborhoods; <br/><br/><a class="exlink" href="http://re-re.info/category/answering-service/"><span class="colored2">Answering Service</span></a> answers FAQs, and more;<br/><br/>
<a class="exlink" href="http://re-re.info/category/communication-compartments/"><span class="colored2">Communication Compartment</span></a> includes ways to contact us, and much,
much more. <br/><br/>Enjoy!
				</div>
				</center> 
			</div>

		<h3><?php /* echo $current_category; */?></h3>

		<?php wp_reset_query();?>
		<?php 
			global $query_string;
			if ($current_category == "") {
				query_posts(array(
				'cat'=>frontpageCategoryID,
				)); 
			} else {
				query_posts( array ('category_name' => $current_category, 'orderby'=>'date', 'order'=>'DESC',));
			}
		?>
			
		<?php if(have_posts()):?>
		<div class="row-holder">
			<?php $posts_count=0;?>
			<div class="row">
			<?php while(have_posts()): the_post();?>
			<?php $posts_count++;?>
				<div class="box" style="left: <?php echo ((($posts_count-1)%3) * 223)?>px" >
					<div class="heading"><h2><?php the_title(); /* echo $posts_count; */?></h2></div>
					<div class="text">
						<div class="default-text">
							<?php the_excerpt();?>
						</div>
						<div class="block">
							<?php the_content('');?>	
						</div>
					</div>
					<div class="more"><a href="#"><span>READ MORE</span></a></div>
					<a class="close" href="#">close</a>
				</div>
			<?php if(($posts_count%3==0)&&($posts_count<$wp_query->post_count)):?>
			</div><div class="row">
			<?php endif;?>
			<?php endwhile;?>
			</div>
		</div>
		<?php endif;?>
		<?php wp_reset_query();?>
	</div>
	<div id="sidebar">
		<div class="section form-holder">
			<h2><a href="/manifesto">MANHATTAN MANIFESTO</a></h2>
			<h2><a href="/navigating-highlights">NAVIGATING HIGHLIGHTS</a></h2>
			<br/><h2><a href="http://re-re.info/search">Property Locator</a></h2>
			<form action="" method="post" onsubmit="processLocator(); return false;">
			<div><label id="laddress">Address</label> <input id="address" type="text" name="address" size="40" maxlength="255" onBlur="normalizeAddress()"/><br/>
			</div>
			<div> <input type="submit" value="Search"></div><br/>
			</form>
			<hr/><br/>
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
				<?php if (has_post_thumbnail()){?><a href="<?php the_permalink();?>"><?php the_post_thumbnail('post-thumbnails');?></a><?php }?>
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
