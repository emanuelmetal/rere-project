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

			<input id="page" name="s" placeholder="<?php echo $sq; ?>"/><!--
         -->
		</div>
        <div>
            <input class="submit" type="submit" value="Search" />
        </div>
	</fieldset>
</form>