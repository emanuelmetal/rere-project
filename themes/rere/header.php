<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="author" content="Mike Eubanks (primary author) mike@rositainternetsolutions.com">
		<link media="all" rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/all.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/style.css"  />
		
		<?php
			wp_deregister_script('jquery');
			wp_register_script('jquery', get_bloginfo('template_url').'/js/jquery-1.6.4.min.js');
			wp_enqueue_script('jquery'); ?>
		<?php wp_head(); ?>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.main.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.hoverIntent.minified.js"></script>
		<script type="text/javascript" src="http://valid.tjp.hu/zoom/tjpzoom.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/process_mkt_opps.js"></script>
				<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/processSearch.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/json2.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jstorage.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.imagemapster.min.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/rere.js"></script>			
<script type="text/javascript">
var addressQuery;
function processLocator(){
	var sqlQuery;
	queryForm = document.forms[0];
	var address = queryForm.elements["address"].value;

	if (address.length == 5) {
		if (address == "10001" || address == "10003" || address == "10010" || 
		address == "10011" || address == "10012" || address == "10014" || 
		address == "10016" || address == "10017" || address == "10019" ||
		address == "10022" || address == "10023" || address == "100024" ||
		address == "100025" || address == "10026" || address == "10029" ||
		address == "10028" || address == "10075" || address == "10021" ||  address == "10065") {						
			sqlQuery = " AND zipcode = '" + address + "'";
		} else {
			alert("Sorry, but our data doesn't include zip code " + address); 
		}
	} else {
		normalizeAddress();
		sqlQuery = ' AND address_number = ' + houseNumber;
		sqlQuery += ' AND street_name = ' + "'" + streetName + "'";
	}
	sessionStorage.setItem("addressQuery", sqlQuery);
	window.location.href = "http://re-re.info/query-by-address-results";
}

function runQuery() {
var sqlQuery = sessionStorage.getItem("addressQuery");
jQuery("#queryresults").load("http://re-re.info/runquery", {query: sqlQuery});
}
</script>
<meta name="google-site-verification" content="jCsxWr2YSrr5rfd2rAqab5xKoN5-fjiXI57_wu9N4KY" />
		
	</head>
	<body>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33546623-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
		<div id="wrapper">
			<div id="header">
				<div class="logo"><a href="<?php bloginfo('url');?>"><?php bloginfo('description')?></a></div>
				<?php wp_nav_menu( array('container' => false,
						 'theme_location' => 'main',
						 'menu_id' => 'nav',
						 'menu_class' => '', 
						 'depth' => 2,
						 'items_wrap' => '<ul id="%1$s" class="%2$s" title="Click">%3$s</ul>',
						 ) ); ?>
			</div>