        </div>
<!--		<div id="footer">-->
<!--			<div class="footer-holder">-->
<!--				<div class="footer-frame">-->
<!--					--><?php //wp_nav_menu( array('container' => false,
//						 'theme_location' => 'footer',
//						 'menu_id' => '',
//						 'menu_class' => '',
//						 ) ); ?>
<!---->
<!--                                        <p>&copy; Regarding Real Estate, re-re.info</p>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
       <footer class="footer-basic-centered">
           <p class="footer-links">
               <a href="/personal-planners/">PERSONNAL PLANNERS</a>&nbsp;&middot;
               <a href="/findme-a-match/">FIND ME A MATCH</a>&nbsp;&middot;
               <a href="/manhattan-coop-condo-advertisements/">POST A PROPERTY</a>&nbsp;&middot;
               <a href="/letter-from-the-editor/">ABOUT</a>&nbsp;&middot;
               <a href="/mastering-manhattan/manhattan-real-estate-search-hints-tips-conventional-wisoms/">QUESTIONS</a>
<!--               <a href="#">CONTACT</a>-->
           </p>
           <div class="social">
               <a href="/">
                   <i class="fa fa-home"></i>
               </a>
<!--               <a href="#" title="Regarding Real Estate @ Facebook">-->
<!--                   <i class="fa fa-facebook"></i>-->
<!--               </a>-->
               <a href="https://twitter.com/rereinfo" target="_blank" title="Regarding Real Estate @ Twitter">
                   <i class="fa fa-twitter"></i>
               </a>
               <a href="https://www.linkedin.com/company/3149970?trk=tyah" target="_blank" title="Regarding Real Estate @ LinkedIn">
                   <i class="fa fa-linkedin"></i>
               </a>
               <a href="https://www.pinterest.com/rereinfo/" target="_blank" title="Regarding Real Estate @ Pinteres">
                   <i class="fa fa-pinterest"></i>
               </a>
           </div>
       </footer>
        <?php wp_enqueue_script('jquery');
              wp_enqueue_script('bootstrap');
              wp_enqueue_script('pgwSlideshow');
              wp_enqueue_script('jquery-serialize-object');
              wp_enqueue_script('parsley');
        ?>
        <script>
            var searchForm = jQuery("#search-form");
            var searchButton = jQuery("#search-button");
            var searchInput = jQuery("#search-input");

            searchButton.click(function () {
                if (searchInput.val() !== '') {
                    searchForm.submit();
                }
            });

            searchForm.on('submit', function (e) {
                if (searchInput.val().trim() === '') {
                    e.preventDefault();
                }
            });
        </script>
<!--       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

<!--       <script src="--><?php //bloginfo('template_url'); ?><!--/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
<!--        <script src="--><?php //bloginfo('template_url'); ?><!--/bower_components/pgwslideshow/pgwslideshow.min.js"></script>-->
	</body>
</html>