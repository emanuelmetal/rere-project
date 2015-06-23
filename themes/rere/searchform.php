<?php 
global $page_title;
if (is_home()) { 
	$pagename = "Home page";
} else {
	$pagename = $page_title;
}
$sq = get_search_query() ? get_search_query() : $pagename; 
$sq = " " . $sq;
$pos = strpos($sq, '<span id="can_be_hidden"');

if ($pos>0) {
	$sq = substr($sq, 1, $pos-1);
} else {
	$sq = substr($sq, 1);
}

?>
<form method="get" class="search" id="searchform" action="<?php bloginfo('url'); ?>" >
	<fieldset>
		<div class="area">
			<textarea rows="2" cols="20" id="page" name="s" /><?php echo $sq; ?></textarea>
		</div>
		<input class="submit" type="submit" value="Search" />
	</fieldset>
</form>