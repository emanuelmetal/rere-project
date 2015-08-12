
<?php /*
Template Name: qualquery
*/ ?>
<!-- page-qualquery.php -->
<?php 
global $wpdb;

$thiszip = htmlentities($_POST["thiszip"]);
$query = "SELECT DISTINCT address_number, street_name FROM wp_listings_data WHERE zipcode = '" . $thiszip . "'"  . str_replace("\'", "'", htmlentities($_POST["query"])) . ' ORDER BY street_name';

// echo "Query:  "; echo $query; echo "<br/><br/>"; 
// echo "Prepared Query:  "; echo $wpdb->prepare($query); echo "<br/><br/>"; 

$wpdb->flush();
$results = $wpdb->get_results($query, ARRAY_A);

$i = 0;
	// print count($results);
if (count($results)) {
	foreach ($results as $row) { 
		 $i++;
/* 		 
		if ($i > 499) {
			break;
		}
*/
		print '<div class="address">';
		print '<div class="address_number">' . $row["address_number"] . '</div>'; 
		print '<div class="street_name">' . $row["street_name"] . '</div>';
		print '</div>';
	}
} else {
		print "<h3>Sorry, no properties were found which met your specifications</h3>";
}

?> 


