<?php get_header(); ?>
<div class="rere-content">
    <h1>search</h1>
	<div id="content">
		<?php if(have_posts()):?>
			<?php while(have_posts()): the_post();?>
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <div class="panel panel-primary display">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a href="<?php the_permalink()?>"><?php the_title();?> <span aria-hidden="true" class="glyphicon glyphicon-open"></span></a>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <p class="info" style="display: none;"><strong class="date"><?php the_time('F jS, Y') ?></strong> by <?php the_author(); ?></p>
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>
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
</div>
<?php get_footer(); ?>
