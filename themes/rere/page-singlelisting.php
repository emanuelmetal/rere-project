<?php /*
Template Name: Single Listing
*/ ?>
<!-- page-single-listing.php -->
<?php get_header(); 
	global $page_title;
	$page_title = get_the_title();
?>
<div id="main">
	<div id="content-wide">

<?php
global $wpdb;

$address =  htmlentities($_GET["address_number"]);
$query = "SELECT * FROM wp_listings_data WHERE address_number = " . $address;
$street = str_replace("\'", "'", htmlentities($_GET["street_name"]));
$street = str_replace("-", " ", $street);
$query .=  " AND street_name = " . $street ;
$unit_number = str_replace("\'", "'", htmlentities($_GET["unit_number"]));
$query .=  " AND unit_number = " . $unit_number ;
$query .=  " AND source = " . str_replace("\'", "'", htmlentities($_GET["source"]));

//echo "Query:  ";  echo $wpdb->prepare($query); echo "<br/><br/>"; 

$wpdb->flush();
$results = $wpdb->get_results($wpdb->prepare($query), ARRAY_A);

$i = 0;
foreach ($results as $row) { 
 if ($i++ > 0) break;
 print "<br/><hr/>";
 print '<div class="fullpage_results_row">';
 print '<div class="fullpage_results_text">';
 print '<div class="fullpage_address">' . $row["address_number"] . " " . $row["street_name"] . '</div>';
 print '<div class="fullpage_unit_number">' . "Unit " . $row["unit_number"] . '</div>';
 print '<div class="fullpage_part_of_town">' . "[" . $row["part_of_town"] . ']</div>';
 print '<div class="fullpage_neighborhood">' . "[" . $row["neighborhood"] . ']</div>';
 if ($row["co_op"] == "X") { print '<div class="fullpage_assoc_type">' . "(co-op)" . '</div>';}
 if ($row["condo"] == "X") { print '<div class="fullpage_assoc_type">' . "(condo)" . '</div>';}
 // if ($row["asking_price"] > 0) {print '<div class="fullpage_asking_price">' . " <b>$" . number_format($row["asking_price"], 0) . '</b></div>';}

 // if ($row["source"]  == "DD") {	print '<div class="fullpage_source">' . "(past sales)" . '</div>';}
 if ($row["source"]  == "AV") {	print '<div class="fullpage_source">' . "(for sale)" . '</div>';}
 if ($row["source"]  == "OH") {	print '<div class="fullpage_source">' . "(open house)" . '</div>';}
 if ($row["source"]  == "RO" || $row["source"]  == "RP") {	print '<div class="fullpage_source">' . "(for rent)" . '</div>';}	
  print '<br/><br/>';
 if ($row["buildingname"] != "") { print '<div class="fullpage_buildingname">' . "Building name: " . $row["buildingname"] . '</div>';	}

 if ($row["built"] > 0 ) { print '<div class="fullpage_built">' . "Year built: " . $row["built"] . '</div>';}
 
 print '<hr/>';

 print "<br/>";
  print '<div class="fullpage_rooms">';
 print '<div class="fullpage_Rooms">' . "Rooms: <b>" . $row["Rooms"] . '</b></div>';
 print '<div class="fullpage_Beds">' . "Bedrooms: <b>" . $row["Beds"] . '</b></div>';
 print '<div class="fullpage_Baths">' . "Bathrooms: <b>" . $row["Baths"] . '</b></div>';
 if ($row["OverallCondition"] == "") {$row["OverallCondition"] = "n/a";}
 print '<div class="fullpage_OverallCondition">' . "Overall Condition: " . $row["OverallCondition"] . '</div>';
 print "<br/><hr/><br/>";
 if ($row["Dinning_Type"] == "") {$row["Dinning_Type"] = "n/a";}
 print '<div class="fullpage_Dinning_Type">' . "Dining Type: " . $row["Dinning_Type"] . '</div>';
 if ($row["Kitchen_Type"] == "") {$row["Kitchen_Type"] = "n/a";}
 print '<div class="fullpage_Kitchen_Type">' . "Kitchen Type: " . $row["Kitchen_Type"] . '</div>';
 if ($row["KitchenCond"] == "") {$row["KitchenCond"] = "n/a";}
 print '<div class="fullpage_KitchenCond">' . "Kitchen Condition: " . $row["KitchenCond"] . '</div>';
 if ($row["BathCond"] == "") {$row["BathCond"] = "n/a";}
 print '<div class="fullpage_BathCond">' . "Bath Condition: " . $row["BathCond"] . '</div>';
 if ($row["Fireplaces"] == "") {$row["Fireplaces"] = "n/a";}
 print '<div class="fullpage_Fireplaces">' . "Fireplaces: " . $row["Fireplaces"] . '</div>';
 print '</div>';

 print '<div class="fullpage_features">';
 print '<div class="fullpage_doorman">' . "doorman: " . $row["doorman"] . '</div>';
 print '<div class="fullpage_concierge">' . "concierge: " . $row["concierge"] . '</div>';
 print '<div class="fullpage_manned_elevator">' . "manned elevator: " . $row["manned_elevator"] . '</div>';
 print '<div class="fullpage_pets">' . "pets: " . $row["pets"] . '</div>';
 print '<div class="fullpage_washer_dryer">' . "washer_dryer: " . $row["washer_dryer"] . '</div>';
 print '<div class="fullpage_parking">' . "parking: " . $row["parking"] . '</div>';
 print '<div class="fullpage_health_club">' . "health club: " . $row["health_club"] . '</div>';
 print '<div class="fullpage_exercise_room">' . "exercise room: " . $row["exercise_room"] . '</div>';
 print '<div class="fullpage_central_air">' . "central_air: " . $row["central_air"] . '</div>';
 print '<div class="fullpage_gas">' . "gas: " . $row["gas"] . '</div>';
 print '<div class="fullpage_electricity">' . "electricity: " . $row["electricity"] . '</div>';
 print '<div class="fullpage_cable">' . "cable: " . $row["cable"] . '</div>';
 print '<div class="fullpage_outdoor_space">' . "outdoor_space: " . $row["outdoor_space"] . '</div>';
 print '<div class="fullpage_meeting_space">' . "meeting_space: " . $row["meeting_space"] . '</div>';
 print '<div class="fullpage_playroom">' . "playroom: " . $row["playroom"] . '</div>';
 print '<div class="fullpage_storage">' . "storage: " . $row["storage"] . '</div>';
print ' </div>';

  print '<div class="fullpage_financials">';
 if ($row["financing_allowed"] == "") {$row["financing_allowed"] = "n/a";}
 print '<div class="fullpage_financing_allowed">' . "Financing allowed: " . $row["financing_allowed"] . '%</div>';
 if ($row["RE_Taxes"] == "") {$row["RE_Taxes"] = "n/a";}
 print '<div class="fullpage_RE_Taxes">' . "RE Taxes: " . $row["RE_Taxes"] . '</div>';
 if ($row["maint_cc"] == "") {$row["maint_cc"] = "n/a";}
 print '<div class="fullpage_maint_cc">' . "Maintenance: " . $row["maint_cc"] . '</div>';
 if ($row["tax_deductible"] == "") {$row["tax_deductible"] = "n/a";}
 print '<div class="fullpage_tax_deductible">' . "Tax deductible: " . $row["tax_deductible"] . '</div>';
 if ($row["flip_tax"] == "") {$row["flip_tax"] = "n/a";}
 print '<div class="fullpage_flip_tax">' . "Flip tax: " . $row["flip_tax"] . '</div>';
 print "</div>";  // close fullpage_financials
 

 print '<div style="clear: right;"></div>';
  print '<div class="fullpage_outside">';
   print "<br/><hr/><br/>";
 if ($row["Exposure"] == "") {$row["Exposure"] = "n/a";}
 print '<div class="fullpage_Exposure">' . "Exposure: " . $row["Exposure"] . '</div>';
 if ($row["Private_Outdoor"] == "") {$row["Private_Outdoor"] = "n/a";}
 print '<div class="fullpage_Private_Outdoor">' . "Private Outdoor: " . $row["Private_Outdoor"] . '</div>';
 if ($row["Views"] == "") {$row["Views"] = "n/a";}
 print '<div class="fullpage_Views">' . "Views: " . $row["Views"] . '</div>'. '<br/>';
print ' </div>';
 

print ' </div>';  // close results_text
print '<div class="clear"></div>';

 // Now get associated images
$iquery = "SELECT DISTINCT * FROM wp_listings_images WHERE address_numberImages=";
$iquery .= $row["address_number"];
$iquery .= " AND street_nameImages = '";
$iquery .= $row["street_name"];
$iquery .= "'";
// echo "Image Query:  "; echo $wpdb->prepare($iquery); echo "<br/><br/>"; 
$wpdb->flush();
$iresults = $wpdb->get_results($wpdb->prepare($iquery), ARRAY_A);

 print "<br/><hr/><br/>";
 print '</div>';
 print '<div class="fullpage_Images">';
$number_of_images = 0;
if (count($iresults > 0)) {
	foreach ($iresults as $irow) {
		if (strpos($irow["relative_path_image"],".pdf") > 0) break;
		$irow["relative_path_image"] = str_replace("_BY_ZIPCODE", "Dwellings-by-Zip-Codes", $irow["relative_path_image"]);
		print '<a target="_new" href="http://re-re.info/wp-content/uploads/' . $irow["relative_path_image"] . '">';
		print '<img class="Image" src="http://re-re.info/wp-content/uploads/building-data/' . $irow["relative_path_image"] . '"/>';
		print '</a>';
		if (++$number_of_images > 2) break;
	}
}

print '</div></div>';
 print "<br/><hr/><br/>";
}

?> 

	
	</div>
</div>
<?php get_footer(); ?>