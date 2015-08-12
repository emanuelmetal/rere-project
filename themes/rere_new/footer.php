                       </div>
		<div id="footer">
			<div class="footer-holder">
				<div class="footer-frame">
					<?php wp_nav_menu( array('container' => false,
						 'theme_location' => 'footer',
						 'menu_id' => '',
						 'menu_class' => '',
						 ) ); ?>

                                        <p>&copy; Regarding Real Estate, re-re.info</p>
				</div>
			</div>
		</div>
                <?php wp_footer(); ?>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

       <script src="<?php bloginfo('template_url'); ?>/js/bootstrap/js/bootstrap.js"></script>
	</body>
</html>