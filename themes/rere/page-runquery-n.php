
<?php /*
Template Name: runquery
*/ ?>
<!-- page-runquery.php -->
<?php 
global $wpdb;

$query = "SELECT * FROM wp_listings_data WHERE 1=1" . str_replace("\'", "'", htmlentities($_POST["query"]));

echo "Query:  "; echo $query; echo "<br/><br/>"; 
// echo "Prepared Query:  "; echo $wpdb->prepare($query); echo "<br/><br/>"; 

$wpdb->flush();
$results = $wpdb->get_results($query, ARRAY_A);


if (count($results)) {
	print "<h3>" . count($results) . " properties found which match your criteria</h3>";
	$i = 0;
	$old_address_number = "";
	$old_street_name = "";
	foreach ($results as $row) { 
		 // print_r($row); 
		 $i++;
		 if ($i > 499) {
			print "<h1>Limit exceeded</h1>";
			break;
		}
		if ($row["address_number"] != $old_address_number || $row["street_name"] != $old_street_name) {  // new building, print all the building info 
			$old_address_number = $row["address_number"];
			$old_street_name = $row["street_name"];
			print '<div class="results_row">';	
			print '<div class="results_text">';
			
			// first, where it is
			print '<div class="summary_address">';
			print $row["address_number"] . " " . $row["street_name"] . '</div>';
			print '<div class="summary_part_of_town">' . "[" . $row["part_of_town"] . ']</div>';
			print '<div class="summary_neighborhood">' . "[" . $row["neighborhood"] . ']</div>';
			//  if ($row["source"]  == "DD") {	print '<div class="source">' . "(past sales)" . '</div>';} 
			if ($row["source"]  == "AV") {	print '<div class="source">' . "(for sale)" . '</div>';}
			if ($row["source"]  == "OH") {	print '<div class="source">' . "(open house)" . '</div>';}
			if ($row["source"]  == "RO" && $row["source"]  == "RP") {	print '<div class="source">' . "(for rent)" . '</div>';}
			print "<br/>";
			
			// now, what it is
			if ($row["co_op"] == "X") { print '<div class="summary_ownership">' . "(co-op)" . '</div>';}
			if ($row["condo"] == "X") { print '<div class="summary_ownership">' . "(condo)" . '</div>';}
			if ($row["buildingname"] != "") { print '<div class="summary_buildingname">' . "Building name: " . $row["buildingname"] . '</div>';	}
			if ($row["built"] > 0 ) { print '<div class="summary_built">' . "Year built: " . $row["built"] . '</div>';}
			print '<hr/>';
			
			print '<div class="summary_features">';
			print '<div class="summary_doorman">' . "doorman: " . $row["doorman"] . '</div>';
			print '<div class="summary_concierge">' . "concierge: " . $row["concierge"] . '</div>';
			print '<div class="summary_manned_elevator">' . "manned elevator: " . $row["manned_elevator"] . '</div>';
			print '<br/>';
			print '<div class="summary_pets">' . "pets: " . $row["pets"] . '</div>';
			print '<div class="summary_washer_dryer">' . "washer dryer: " . $row["washer_dryer"] . '</div>';
			print '<div class="summary_parking">' . "parking: " . $row["parking"] . '</div>';
			print '<br/>';
			print '<div class="summary_health_club">' . "health club: " . $row["health_club"] . '</div>';
			print '<div class="summary_exercise_room">' . "exercise room: " . $row["exercise_room"] . '</div>';
			print '<div class="summary_central_air">' . "central air: " . $row["central_air"] . '</div>';
			print '<br/>';
			print '<div class="summary_gas">' . "gas: " . $row["gas"] . '</div>';
			print '<div class="summary_electricity">' . "electricity: " . $row["electricity"] . '</div>';
			print '<div class="summary_cable">' . "cable: " . $row["cable"] . '</div>';
			print '<br/>';
			print '<div class="summary_outdoor_space">' . "outdoor space: " . $row["outdoor_space"] . '</div>';
			print '<div class="summary_meeting_space">' . "meeting space: " . $row["meeting_space"] . '</div>';
			print '<br/>';
			print '<div class="summary_playroom">' . "playroom: " . $row["playroom"] . '</div>';
			print '<div class="summary_storage">' . "storage: " . $row["storage"] . '</div>';
			print ' </div>';

			print '<br/>';
			if ($row["financing_allowed"] == "") {$row["financing_allowed"] = "n/a";}
			print '<div class="summary_financing_allowed">' . "Financing: " . $row["financing_allowed"] . '%</div>';
			if ($row["RE_Taxes"] == "") {$row["RE_Taxes"] = "n/a";}
			print '<div class="summary_RE_Taxes">' . "RE Taxes: " . $row["RE_Taxes"] . '</div>';
			if ($row["maint_cc"] == "") {$row["maint_cc"] = "n/a";}
			print '<div class="summary_maint_cc">' . "Maintenance: " . $row["maint_cc"] . '</div>';
			print '<br/>';
	
			if ($row["tax_deductible"] == "") {$row["tax_deductible"] = "n/a";}
			print '<div class="summary_tax_deductible">' . "Tax deductible: " . $row["tax_deductible"] . '</div>';
			if ($row["flip_tax"] == "") {$row["flip_tax"] = "n/a";}
			print '<div class="summary_flip_tax">' . "Flip tax: " . $row["flip_tax"] . '</div>';

			print '</div>'; // close results_text
			
			// Now get associated images
			$iquery = "SELECT DISTINCT * FROM wp_listings_images WHERE address_numberImages=";
			$iquery .= $row["address_number"];
			$iquery .= " AND street_nameImages = '";
			$iquery .= $row["street_name"];
			$iquery .= "'";
			// echo "Image Query:  "; echo $wpdb->prepare($iquery); echo "<br/><br/>"; 
			$wpdb->flush();
			$iresults = $wpdb->get_results($wpdb->prepare($iquery), ARRAY_A);
			
			print '<div class="Images">';
			$number_of_images = 0;
			if (count($iresults > 0)) {
				foreach ($iresults as $irow) {
					if (strpos($irow["relative_path_image"],".pdf") > 0) break;
					$irow["relative_path_image"] = str_replace("_BY_ZIPCODE", "Dwellings-by-Zip-Codes", $irow["relative_path_image"]);
					print '<a target="_new" href="http://re-re.info/wp-content/uploads/building-data/' . $irow["relative_path_image"] . '">';
					print '<img class="Image" height="140"  src="http://re-re.info/wp-content/uploads/building-data/' . $irow["relative_path_image"] . '"/>';
					print '</a>';
					if (++$number_of_images > 2) break;
				}
			}
			print '</div></div>'; // close Images, results_row;
		}
	
	// per-unit output goes here
	print '<div class="unit_row">';
	print '';
	print '<a href="//re-re.info/single-listing?address_number=';
	print $row["address_number"] . "&street_name='";
	print str_replace(" ", "-", $row["street_name"]);
	print "'&unit_number='" .  $row["unit_number"]; 
	print "'&source='" .  $row["source"];
	print "'" . '"' . " target='_new'>"; 
	print '<div class="summary_unit_number">' . "#" .  $row["unit_number"] . '</div>';
	print "</a>";
	// if ($row["asking_price"] > 0) {print '<div class="summary_asking_price">' . " <b>$" . number_format($row["asking_price"], 0) . '</b></div>';}
	print '<div class="summary_Rooms">' . "Rooms: <b>" . $row["Rooms"] . '</b></div>';
	print '<div class="summary_Beds">' . "Bedrooms: <b>" . $row["Beds"] . '</b></div>';
	print '<div class="summary_Baths">' . "Bathrooms: <b>" . $row["Baths"] . '</b></div>';
	if ($row["OverallCondition"] == "") {$row["OverallCondition"] = "n/a";}
	print '<div class="summary_OverallCondition">' . "Condition: " . $row["OverallCondition"] . '</div>';
	// print '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	if ($row["Private_Outdoor"] == "") {$row["Private_Outdoor"] = "n/a";}
	print '<div class="summary_Private_Outdoor">' . "Private Outdoor: " . $row["Private_Outdoor"] . '</div>';
	if ($row["Views"] == "") {$row["Views"] = "n/a";}
	print '<div class="summary_Views">' . "Views: " . $row["Views"];
	print '</div>';
	print '</div>';  // close unit_row div
	}
} else {
		print "<h3>Sorry, no properties were found which met your specifications</h3>";
}

?> 


