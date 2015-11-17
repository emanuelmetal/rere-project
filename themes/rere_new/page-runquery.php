
<?php /*
Template Name: runquery
*/ ?>
<!-- page-runquery.php -->
<?php
global $wpdb;
$query = str_replace("\'", "'", htmlentities($_POST["query"]));
echo '<div class="debug">';
echo "Query:  "; echo $query;
echo "<br/><br/></div>";
if ($query == ''){
    $query = ' LIMIT 20';
}
//$query = "SELECT * FROM wp_listings_data WHERE 1=1" . $query;
$query = 'SELECT *
  FROM wp_listings_data AS r1 JOIN
       (SELECT CEIL(RAND() *
                     (SELECT MAX(maint_cc)
                        FROM wp_listings_data)) AS maint_cc)
        AS r2
 WHERE r1.maint_cc >= r2.maint_cc
 ORDER BY r1.maint_cc ASC
 LIMIT 20';


// echo "Prepared Query:  "; echo $wpdb->prepare($query); echo "<br/><br/>"; 

$wpdb->flush();
$results = $wpdb->get_results($query, ARRAY_A);

if (count($results)) 
{
	print "<h3>" . count($results) . " properties found which match your criteria</h3>";
	$i = 0;
	$old_address_number = "";
	$old_street_name = "";
	foreach ($results as $row) 
	{ 
		$i++;
		if ($i > 499) 
		{
			print "<h1>Limit exceeded</h1>";
			break;
		}
		
		if ($row["address_number"] != $old_address_number || $row["street_name"] != $old_street_name) 
		{  
			// GET IMAGES FOR APARTMENT HOUSE FACTS
			$iquery = "SELECT DISTINCT * FROM wp_listings_images WHERE address_numberImages=";
			$iquery .= $row["address_number"];
			$iquery .= " AND street_nameImages = '";
			$iquery .= $row["street_name"];
			$iquery .= "'";
			// echo "Image Query:  "; echo $wpdb->prepare($iquery); echo "<br/><br/>"; 
			$wpdb->flush();
			$iresults = $wpdb->get_results($wpdb->prepare($iquery), ARRAY_A);
			
			// GET FLOOR PLANS FOR APARTMENT HOUSE FACTS
			$fpquery = "SELECT DISTINCT * FROM wp_floor_plans WHERE address_numberFloorPlans=";
			$fpquery .= $row["address_number"];
			$fpquery .= " AND street_nameFloorPlans = '";
			$fpquery .= $row["street_name"];
			$fpquery .= "'";
			$wpdb->flush();
			// echo "FP query: : " . $wpdb->prepare($fpquery) . "<br/>";
			$fpresults = $wpdb->get_results($wpdb->prepare($fpquery), ARRAY_A);
			
			$old_address_number = $row["address_number"];
			$old_street_name = $row["street_name"]; 
			
			// APARTMENT HOUSE FACTS SECTION
			print '<table border="1" bordercolor="#000000" width="100%" cellpadding="2" cellspacing="2">';
			print '	<tr style="background-color:#6d98be">';
			print '		<td colspan="5"><H2><div style="color:#FFFFFF">Apartment House Facts</div></H2></td>';
			print '	</tr>';
			
			print '	<tr>';
				if (count($iresults > 0)) 
				{
					foreach ($iresults as $irow) 
					{
						if( strpos( $irow["relative_path_image"],".pdf" ) > 0 ) break;
						$irow["relative_path_image"] = str_replace("_BY_ZIPCODE", "Dwellings-by-Zip-Codes", $irow["relative_path_image"]);
						print '<td rowspan="6"><a target="_new" href="/wp-content/uploads/building-data/' . $irow["relative_path_image"] . '">';
						print '<img class="Image" height="140"  src="/wp-content/uploads/building-data/' . $irow["relative_path_image"] . '"/>';
						print '</a></td>';
						print '		<td colspan="2" align="left"><b><h4>'.$row["address_number"] .' '. $row["street_name"] .'</b></h4></td>';
						print '		<td align="right"><b><h4>'.$row["zipcode"].'</b></h4></td>';
						break;
					}
				}
				else
				{
					print '		<td rowspan="6">No images</td>';
				}
				
				// NEIGBORHOOD MAP IMAGE
				print '<td rowspan="6"><a target="_new" href="/maps-2/' . $row["zipcode"] .'-2/">';
				print '<img class="Image" height="140"  src="/wp-content/uploads/2012/maps/' . $row["zipcode"] .'.png"/>';
				print '</a></td>';
			print '	</tr>';
			
			print '	<tr>';
			print '		<td colspan="3"><h4>'.$row["buildingname"].'<h4></br><hr></td>';
			print '	</tr>';
			
			print '	<tr>';
				if ($row["co_op"] == "X") { print '<td><b>Building Type:</b> Co-Op</td>'; } 
				if ($row["condo"] == "X") { print '<td><b>Building Type:</b> Condo</td>'; } 
			print '		<td><b>Doorman:</b> '.$row["doorman"].'</td>';
			print '		<td><b>Pets:</b> '.$row["pets"].'</td>';
			print '	</tr>';
			
			print '	<tr>';
			print '		<td><b>Year Built:</b> '.$row["built"].'</td>';
			print '		<td><b>Concierge:</b> '.$row["concierge"].'</td>';
			print '		<td><b>Health Club:</b> '. $row["health_club"].'</td>';
			print '	</tr>';
			
			print '	<tr>';
				if( $row["permit"] == "" ){ print '		<td><b>Permit year:</b> n/a</td>';}
				else { print '		<td><b>Permit Year:</b> '.$row["permit"].'</td>';} 
			print '		<td><b>Elevator Man:</b> '.$row["manned_elevator"].'</td>';
			print '		<td><b>Exercise Room:</b> '.$row["exercise_room"].'</td>';
			print '	</tr>';
			
			print '	<tr>';
				if( $row["financing_allowed"] == "" ) {print '		<td><b>Financing:</b> n/a</td>'; }
				else{ print '		<td><b>Financing:</b> '.$row["financing_allowed"].'%</td>'; }
			print '		<td><b>Parking:</b> '.$row["parking"].'</td>';
			print '		<td><b>Pool:</b> '.$row["pool"].'</td>';
			print '	</tr>';
			
			print '	<tr>';
			
				$number_of_images = 0;
				if( count($iresults) == 1 ) 
				{ 
					print '<td rowspan="5">&nbsp;</td>';
				}
				else
				{
					foreach ($iresults as $irow) 
					{
						if( strpos( $irow["relative_path_image"],".pdf" ) > 0 ) break;
						$irow["relative_path_image"] = str_replace("_BY_ZIPCODE", "Dwellings-by-Zip-Codes", $irow["relative_path_image"]);
						
						if( $number_of_images == 1 )
						{
							print '<td rowspan="5"><a target="_new" href="/wp-content/uploads/building-data/' . $irow["relative_path_image"] . '">';
							print '<img class="Image" height="140"  src="/wp-content/uploads/building-data/' . $irow["relative_path_image"] . '"/>';
							print '</a></td>';
							break;
						}
						$number_of_images++;
					}
				}
			
				if( $row["tax_deductible"]== "" ){ print '		<td><b>Tax-deductible:</b> n/a</td>';}
				else { print '		<td><b>Tax-deductible:</b> '.$row["tax_deductible"].'</td>';}
			print '		<td><b>Gas:</b> '.$row["gas"].'</td>';
			print '		<td><b>Outdoor Space:</b> '.$row["outdoor_space"].'</td>';
				
				$number_of_images = 0;
				if( count($fpresults) > 0 ) 
				{
					foreach ($fpresults as $fprow) 
					{
						$fprow["relative_pathFloorPlans"] = str_replace("_BY_ZIPCODE", "Dwellings-by-Zip-Codes", $fprow["relative_pathFloorPlans"]);
						if( strpos($fprow["relative_pathFloorPlans"],'nyre.cul.columbia.edu') !== false )
						{
							print '<td rowspan="5"><a target="_new" href="'.$fprow["relative_pathFloorPlans"].'">';
                            print '<img class="Image" height="140" src="/wp-content/themes/rere/images/floor-plan.png"/></a></td>';
						}
						else
						{
							print '<td rowspan="5"><a target="_new" href="/wp-content/uploads/building-data/' .$fprow["relative_pathFloorPlans"] . '">';
							print '<img class="Image" height="140" src="/wp-content/uploads/building-data/' .$fprow["relative_pathFloorPlans"] .'"/></a></td>';
						}
						if(++$number_of_images > 2) break;
					}
				}
				else
				{
					print '		<td rowspan="5"><img class="Image" height="140" src="/wp-content/themes/rere/images/NoFloorPlan.jpg"></td>';
				}
			print '	</tr>';
			
			print '	<tr>';
			print '		<td>&nbsp;</td>';
			print '		<td><b>Cable:</b> '.$row["cable"].'</td>';
			print '		<td><b>Meeting room:</b> '.$row["meeting_space"].'<td>';
			print '	</tr>';
			
			print '	<tr>';
				if( $row["flip_tax"] == "" ){ print '		<td><b>Flip-tax:</b> n/a</td>';}
				else { print '		<td><b>Flip-tax:</b> '.$row["flip_tax"].'</td>';}
				if( $row["flip_tax"] == "" ){ print '		<td><b>Electricity:</b> n/a</td>';}
				else { print '		<td><b>Electricity:</b> '.$row["electricity"].'</td>';}
			print '		<td><b>Playroom:</b> '.$row["playroom"].'</td>';
			print '	</tr>';
			
			print '	<tr>';
			print '		<td>&nbsp;</td>';
				if( $row["central_air"] == "?" ){ print '		<td><b>Central-air:</b> n/a</td>';}
				else { print '		<td><b>Central-air:</b> '.$row["central_air"].'</td>';}
			print '		<td><b>Storage:</b> '.$row["storage"].'</td>';
			print '	</tr>';
			
			print '	<tr>';
			print '		<td>&nbsp;</td>';
				if( $row["washer_dryer"] == "" ){ print '		<td><b>Laundry:</b> n/a</td>';}
				else { print '		<td><b>Laundry:</b> '.$row["washer_dryer"].'</td>';}
			print '		<td>&nbsp;</td>';
			print '	</tr>';
			
			print '	<tr style="background-color:#6d98be">';
			print '		<td colspan="5"><H3><div style="color:#FFFFFF; vertical-align:middle;">Building Apartments</div></H3></td>';
			print '	</tr>';
			
		}	
		
		// INDVIDUAL UNITS GO HERE	
		
		print '	<tr>';
		print '		<td><b>Apt #:</b> '.$row["unit_number"].'</td>';
		print '		<td><b>Rooms:</b> '.$row["Rooms"].'</td>';
		print '		<td><b>Bedrooms:</b> '.$row["Beds"].'</td>';
		print '		<td><b>Bathrooms:</b> '.$row["Baths"].'</td>';
			if( $row["OverallCondition"] == "" ){ print '		<td><b>Condition:</b> n/a</td>';}
			else { print '		<td><b>Condition:</b> '.$row["OverallCondition"].'</td>';}
		print '	</tr>';
		
		print '	<tr>';
		print '		<td><b>&nbsp;</b></td>';
		print '		<td><b>Kitchen:</b> '.$row["Kitchen"].'</td>';
		print '		<td><b>Condition:</b> '.$row["Condition"].'</td>';
		print '		<td><b>Dining:</b> '.$row["Dinning"].'</td>';
		print '		<td><b>Fireplace:</b> </td>';
		print '	</tr>';
		
		print '	<tr>';
		print '		<td><b>Sale Price:</b> </td>';
		print '		<td><b>Price:</b> '.$row["asking-price"].'</td>';
		print '		<td><b>Maint. Fee:</b> '.$row["maint-cc"].'</td>';
		print '		<td><b>Taxes:</b> '.$row["RE-Taxes"].'</td>';
		print '		<td><b>&nbsp;</b></td>';
		print '	</tr>';
		
		print '	<tr>';
		print '		<td><b>Sale Date:</b> </td>';
		print '		<td><b>Views:</b> '.$row["Views"].'</td>';
		print '		<td><b>Exposure:</b> '.$row["Exposure"].'</td>';
			if( $row["Private_Outdoor"] == "" ){ print '		<td><b>Outdoor:</b> none</td>';}
			else { print '		<td><b>Outdoor:</b> '.$row["Private_Outdoor"].'</td>';}		
		print '		<td><b>&nbsp;</b></td>';
		print '	</tr>';
		
		print '	<tr>';
		print '		<td>&nbsp;</td>';
		print '		<td>&nbsp;</td>';
		print '		<td>&nbsp;</td>';
		print '		<td>&nbsp;</td>';
		print '		<td>&nbsp;</td>';
		print '	</tr>';
	}
	
	print '</table>';
} 
else 
{
	print "<h3>Sorry, no properties were found which met your specifications</h3>";
}

?> 



