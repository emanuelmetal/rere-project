
<?php /*
Template Name: fmampostboard
*/ ?>
<!-- page-fmampostboard.php -->
<?php 
global $wpdb;
$query = str_replace("\'", "'", htmlentities($_POST["query"]));
//echo '<div class="debug">';
//echo "Query:  "; echo $query; 
//echo "<br/><br/></div>"; 
$query = "SELECT * FROM  wp_fmam_posting ORDER BY part_of_town, neighborhood, budget_high DESC";



// echo "Prepared Query:  "; echo $wpdb->prepare($query); echo "<br/><br/>"; 

$wpdb->flush();
$results = $wpdb->get_results($query, ARRAY_A);

if (count($results)) {
	print "<h3>" . count($results) . " Find Me a Match! postings</h3>";
	$i = 0;
	$old_part_of_town = "";
	$old_neighborhood = "";
	foreach ($results as $row) { 
		$i++;
		/*if ($i > 499) 
		{
			print "<h1>Limit exceeded</h1>";
			break;
		} */
		if ($row["part_of_town"] != $old_part_of_town) {
			print '		<h2>'.$row["part_of_town"].'</h2>'	;	
			$old_part_of_town = $row["part_of_town"];	
			print '<hr/>';
		}
		if ($row["neighborhood"] != $neighborhood) {
			print '		<h3> '.$row["neighborhood"].'</h3>'	;	
			$neighborhood = $row["neighborhood"];	
			print '<hr/>';
		}
		print '	 Listing type: ';
		if ($row["source"] == "AV") { print 'For Sale</b><br/>'; } else { print 'For Rent</b><br/>'; } 
		
		print '		Budget:</b> '.$row["budget_low"].' to '. $row["budget_high"] . '<br/>';
		
		print '<b>Dwelling Type(s):</b><br/>';
		if ($row["apartment_hotel"] == "X") { print 'Apartment hotel<br/>'; } 
		if ($row["pre-war"] == "X") { print 'Pre-war<br/>'; } 
		if ($row["post_war"] == "X") { print 'Post-war<br/>'; } 
		if ($row["loft"] == "X") { print 'Loft<br/>'; } 
		if ($row["co_op"] == "X") { print 'Ownership: Co-Op</td><br/>'; } 
		if ($row["condo"] == "X") { print 'Ownership: Condo</td><br/>'; } 
		if ($row["townhouse"] == "X") { print 'Townhouse<br/>'; } 
		if ($row["private_house"] == "X") { print 'Private House<br/>'; } 
		
		print '		Rooms: '.$row["Rooms"].'<br/>';
		print '		Bedrooms: '.$row["Beds"].'<br/>';
		print '		Bathrooms: '.$row["Baths"].'<br/>';
		
		print '		Kitchen: '.$row["Kitchen_Type"].'<br/>';
		print '		Dining: '.$row["Dining_Type"].'<br/>';
		
		if ($row["Library"] == "X") { print 'Library<br/>'; } 
		if ($row["Maids_quarters"] == "X") { print 'Maids Quarters<br/>'; } 
		
		print '		Overall Condition: '.$row["OverallCondition"].'<br/>';
		print '		Kitchen Condition: '.$row["Kitchen_cond"].'<br/>';
		print '		Bath Condition: '.$row["Bath_Cond"].'<br/>';
	
		print '		Views: '.$row["Views"].'<br/>';
		print '		Exposure: '.$row["Exposure"].'<br/>';
		if( $row["Private_Outdoor"] == "" ){ print '		Outdoor: not specified</td>';}
		else { print '		Outdoor: '.$row["Private_Outdoor"].'<br/>';}		
		
//		print '		Doorman: '.$row["doorman"].'<br/>';
		print '	    Dwelling Type(s):<br/>';
		print '		Pets: '.$row["pets"].'<br/>'	;	
		print '		Concierge: '.$row["concierge"].'<br/>';
		print '		Health Club: '. $row["health_club"].'<br/>';
		print '		Elevator Attendant: '.$row["manned_elevator"].'<br/>';
		print '		Spa-Exercise Room: '.$row["exercise_room"].'<br/>';
		print '		Parking: '.$row["parking"].'<br/>';
		print '		Pool: '.$row["pool"].'<br/>';
		print '		Outdoor Space: '.$row["outdoor_space"].'<br/>';			
		print '		Cable: '.$row["cable"].'<br/>';
		print '		Fireplace:'.$row["fireplace"].'<br/>';
		print '		Meeting room: '.$row["meeting_space"].'<br/>';
		print '		Playroom: '.$row["playroom"].'<br/>';
		print '		Central-air: '.$row["central_air"].'<br/>';
		print '		Storage: '.$row["storage"].'<br/>';		
		print '      Laundry: '.$row["washer_dryer"].'<br/>';
		print '	   <form action=""><input type="submit" value="Respond"></form>';
		print '<hr/>';
	}
} else {
	print "<h3>Sorry, no current postings</h3>";
}

?> 



