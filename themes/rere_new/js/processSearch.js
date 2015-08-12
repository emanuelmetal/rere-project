function processForm(action)
{
queryForm = document.forms[0];
var sqlQuery = "";
var noLocSqlQuery = "";
var formLocationPart;
var apartmentFactsOnly;
if (locationsDropdownsVisible) { // if they're hidden, all location criteria are taken from the map clicks
	if (queryForm.elements["partoftown"].value != "Any" || queryForm.elements["neighborhood"].value != "Any") {
		sqlQuery += " AND (";
	}
	if (queryForm.elements["partoftown"].value != "Any") {
		sqlQuery += "part_of_town = '" + queryForm.elements["partoftown"].value + "'";
	}
	if (queryForm.elements["neighborhood"].value != "Any") {
		if (queryForm.elements["partoftown"].value != "Any" ) {
			sqlQuery += " AND ";
		}
		sqlQuery += "neighborhood = '" + queryForm.elements["neighborhood"].value + "'";
	}
	if (queryForm.elements["partoftown"].value != "Any" || queryForm.elements["neighborhood"].value != "Any") {
		sqlQuery += ")";
	}
}
formLocationPart = sqlQuery.length;  // remember where the location info ended (to pass the query to the maps w/o loc info)


// now make the rental price or sale price fields hidden according to whether they're look at rentals or sales
if (queryForm.elements["rlistingtype-forsale"].checked)	{
	if (queryForm.elements["price-l"].value != "") {
		lowPrice = (queryForm.elements["price-l"].value);
		if (lowPrice == "0") lowPrice = 0;
	} else {
		lowPrice = 0;
	}
	if (queryForm.elements["price-h"].value != "") {
		highPrice = (queryForm.elements["price-h"].value);
		if (highPrice == "0") highPrice = 10000000000;
	} else {
	highPrice = 10000000000;
	}
} else {
	if (queryForm.elements["rprice-l"].value != "") {
	   lowPrice = (queryForm.elements["rprice-l"].value);
		if (lowPrice == "0") lowPrice = 0;
	} else {
		lowPrice = 0;
	}
	if (queryForm.elements["rprice-h"].value != "") {
		highPrice = (queryForm.elements["rprice-h"].value);
		if (highPrice == "0") highPrice = 10000000000;
	} else {
		highPrice = 10000000000;
	}
}
sqlQuery += " AND asking_price BETWEEN " + lowPrice + " AND " + highPrice;
	
/* 
if (!queryForm.elements["rlistingtype-rcondo"].checked) {
   if (!queryForm.elements["rlistingtype-rco-op"].checked) {
        sqlQuery += " AND asking_price BETWEEN " + lowPrice + " AND " + highPrice;
   }
}
*/

/* 
if (queryForm.elements["r_listingtype_forsale"].checked) {
    sqlQuery += " AND asking_price BETWEEN " + lowPrice + " AND " + highPrice;
}
*/
/* if (queryForm.elements["rlistingtype-rco-op"].checked) {
    sqlQuery += " AND asking_price BETWEEN " + lowPrice + " AND " + highPrice;
} */

// in this next section, we set the "source" field to distinguish between current listings, prior sale, etc.

apartmentFactsOnly = false;
if (queryForm.elements["rlistingtype-forrent"].checked) {
    sqlQuery += " AND (source = 'RO')";
	if (queryForm.elements["condo-coop-rental"].checked || 
		queryForm.elements["townhouse-loft-rental"].checked) {
		sqlQuery += " AND (";
		if (queryForm.elements["condo-coop-rental"].checked) {
			sqlQuery += " rental_coop_condo = 'X'  OR";
			apartmentFactsOnly = false;
		}
		if (queryForm.elements["townhouse-loft-rental"].checked) { 
			sqlQuery += " rental_townhouse_loft = 'X' OR";
			apartmentFactsOnly = false;
		}
		sqlQuery = sqlQuery.substr(0, sqlQuery.length-3) + ")";    // trim off the last OR, and close the parens
	}
} else {
	apartmentFactsOnly = true;
	if (queryForm.elements["posted_properties"].checked || 
		queryForm.elements["sold_data"].checked || 
		queryForm.elements["open_house"].checked) {
		sqlQuery += " AND (";
		if (queryForm.elements["posted_properties"].checked) {
			sqlQuery += " source = 'AV'  OR";
			apartmentFactsOnly = false;
		}
		if (queryForm.elements["sold_data"].checked) { 
			sqlQuery += " source = 'DD' OR";
			apartmentFactsOnly = false;
		}
		if (queryForm.elements["open_house"].checked) {
			sqlQuery += " source = 'OH' OR";
			apartmentFactsOnly = false;
		}
		sqlQuery = sqlQuery.substr(0, sqlQuery.length-3) + ")";    // trim off the last OR, and close the parens
	}
}

/* if (queryForm.elements["rlistingtype-o"].checked) {
    sqlQuery += " AND (source = 'OH'";
} */
/* if (queryForm.elements["rlistingtype-t"].checked) {
    sqlQuery += " AND (source = 'TL'";
}
if (queryForm.elements["rlistingtype-25"].checked) {
    sqlQuery += " AND (source = '25'";
} */
/* if (queryForm.elements["rlistingtype-s"].checked) {
    sqlQuery += " AND (source = 'SH'";
} */

/* if (queryForm.elements["rlistingtype-rco-op"].checked) {
    sqlQuery += " AND (source = 'RP'";
} */

if (queryForm.elements["lofts"].checked ||
	queryForm.elements["apartment_houses_main"].checked ||
	queryForm.elements["private_houses_main"].checked) {
	sqlQuery += " AND (";
	if (queryForm.elements["lofts"].checked) {
		sqlQuery += "loft = 'X' OR ";
	}
	if (queryForm.elements["apartment_houses_main"].checked) {
		if (! queryForm.elements["apartment_hotel"].checked && 
			! queryForm.elements["pre_war"].checked && 
			! queryForm.elements["post_war"].checked) {
			sqlQuery += "apartment_hotel = 'X' OR ";
			sqlQuery += "pre_war = 'X' OR ";
			sqlQuery += "post_war = 'X' OR ";
		}
		if (queryForm.elements["apartment_hotel"].checked) {
			sqlQuery += "apartment_hotel = 'X' OR ";
		}
		if (queryForm.elements["pre_war"].checked) {
			sqlQuery += "pre_war = 'X' OR ";
		}		
		if (queryForm.elements["post_war"].checked) {
			sqlQuery += "post_war = 'X' OR ";
		}
	}
	if (queryForm.elements["private_houses_main"].checked) {
			sqlQuery += "private_house = 'X' OR ";	
	}
	sqlQuery = sqlQuery.substr(0, sqlQuery.length-3) + ")";    // trim off the last OR, and close the parens
	if (queryForm.elements["lofts"].checked || queryForm.elements["apartment_houses_main"].checked) {
		if (queryForm.elements["ownership-co-op"].checked ||
			queryForm.elements["ownership-condo"].checked) {
			sqlQuery += " AND (";
			if (queryForm.elements["ownership-co-op"].checked) {
				sqlQuery += "co_op = 'X' OR ";
			}
			 if (queryForm.elements["ownership-condo"].checked) {
				sqlQuery += "condo = 'X' OR ";
			}
			sqlQuery = sqlQuery.substr(0, sqlQuery.length-3) + ")";    // trim off the last OR, and close the parens
		}
	}
}


/* if (queryForm.elements["period-prewar"].checked) {
    sqlQuery += " AND (pre-post-war = 'pre' OR pre-post-war = '')";
}
if (queryForm.elements["period-postwar"].checked) {
    sqlQuery += " AND (pre_post_war = 'post' OR pre_post_war = '')"; 
} */
if (queryForm.elements["financing"].value != "Any") {
    if (queryForm.elements["financing"].value == "none") {
        sqlQuery += " AND (financing_allowed = 0 OR financing_allowed IS NULL)";
    } else {
        sqlQuery += " AND (financing_allowed BETWEEN " + queryForm.elements["financing"].value + " AND 101 OR financing_allowed IS NULL)";
    }
}
if (! apartmentFactsOnly) {
	if (queryForm.elements["rooms"].value != "0") {
		if (queryForm.elements["rooms"].value != "9999") {
			sqlQuery += " AND Rooms = " + queryForm.elements["rooms"].value;
		} else {
			sqlQuery += " AND Rooms BETWEEN 9 and 9999";
		}
		if (Number(queryForm.elements["rooms"].value > 6)) {
			if (queryForm.elements["library"].checked) {
				sqlQuery += " AND (Library = 'yes' OR Library = '')";
			}
			if (queryForm.elements["maids_quarters"].checked) {
				sqlQuery += " AND (Maids_quarters = 'yes' OR Maids_quarters = '')";
			}
		}
	}
	if (queryForm.elements["bedrooms"].value != "0") {
		if (queryForm.elements["bedrooms"].value != "9999") {
			sqlQuery += " AND Beds = " + queryForm.elements["bedrooms"].value;
		} else {
			sqlQuery += " AND Beds BETWEEN 5 and 9999";
		}
	}
	if (queryForm.elements["bathrooms"].value != "0") {
		if (queryForm.elements["bathrooms"].value != "9999") {
			sqlQuery += " AND Baths = " + queryForm.elements["bathrooms"].value;
		} else {
			sqlQuery += " AND Baths BETWEEN 5 and 9999";
		}
	}

	if (queryForm.elements["kitchen"].value != "") {
		sqlQuery += " AND Kitchen_Type = '" + queryForm.elements["kitchen"].value + "'";
	}
	if (queryForm.elements["dinning"].value != "") {
		sqlQuery += " AND Dinning_Type = '" + queryForm.elements["dinning"].value + "'"; 
	}
}

if (queryForm.elements["fireplace"].checked) {
    sqlQuery += " AND (Fireplaces_wood > 0 OR Fireplaces_gas > 0 Or Fireplaces_decorative > 0)";
}
if (queryForm.elements["concierge"].checked) {
    sqlQuery += " AND (concierge = 'yes' OR concierge = '')";
}
if (queryForm.elements["elevator"].checked) {
    sqlQuery += " AND (manned_elevator = 'yes' OR manned_elevator = '')";
}
if (queryForm.elements["pool"].checked) {
    sqlQuery += " AND (pool = 'yes' OR pool = '')";
}
if (queryForm.elements["garage"].checked) {
    sqlQuery += " AND (parking = 'yes' OR parking = '')";
}
if (queryForm.elements["pets"].checked) {
    sqlQuery += " AND (pets = 'yes' OR pets = '')";
}
if (queryForm.elements["washer"].checked) {
    sqlQuery += " AND (washer_dryer = 'yes' OR washer_dryer = '')";
}
if (queryForm.elements["healthclub"].checked) {
    sqlQuery += " AND (health_club = 'yes' OR health_club = '')";
}
if (queryForm.elements["exercise"].checked) {
    sqlQuery += " AND (exercise_room = 'yes' OR exercise_room = '')";
}
if (queryForm.elements["meetingroom"].checked) {
    sqlQuery += " AND (meeting_space = 'yes' OR meeting_space = '')";
}
if (queryForm.elements["storage"].checked) {
    sqlQuery += " AND (storage = 'yes' OR storage = '')";
}
if (queryForm.elements["playroom"].checked) {
    sqlQuery += " AND (playroom = 'yes' OR playroom = '')";
}

if (! apartmentFactsOnly) {
	if (queryForm.elements["city-full"].checked  ||
		queryForm.elements["skyline-full"].checked  || 
		queryForm.elements["park-full"].checked  || 
		queryForm.elements["garden-full"].checked  || 
		queryForm.elements["river-full"].checked) {
		sqlQuery += " AND (";
		if (queryForm.elements["city-full"].checked) {
			sqlQuery += "Views Like '%City%' OR ";
		}
		if (queryForm.elements["skyline-full"].checked) {
			sqlQuery += "Views Like '%Skyline%' OR ";
		}
		if (queryForm.elements["park-full"].checked) {
			sqlQuery += "Views Like '%Park%' OR ";
		}
		if (queryForm.elements["river-full"].checked) {
			sqlQuery += "Views Like '%River%' OR ";
		}
		if (queryForm.elements["garden-full"].checked) {
			sqlQuery += "Views Like '%Garden%' OR ";
		}
		sqlQuery = sqlQuery.substr(0, sqlQuery.length-3) + ")";    // trim off the last OR, and close the parens
	}

	if (queryForm.elements["terrace"].checked  || queryForm.elements["balcony"].checked || queryForm.elements["garden"].checked)  {
		sqlQuery += " AND (";
		if (queryForm.elements["terrace"].checked) {
			sqlQuery += "Private_Outdoor Like '%Terrace%' OR ";
		}
		if (queryForm.elements["balcony"].checked) {
			sqlQuery += "Private_Outdoor Like '%Balcony%' OR ";
		}
		if (queryForm.elements["garden"].checked) {
			sqlQuery += "Private_Outdoor Like '%Garden%' OR ";
		}
		sqlQuery = sqlQuery.substr(0, sqlQuery.length-3) + ")";  
	}
	
	if (queryForm.elements["north"].checked  || queryForm.elements["south"].checked || queryForm.elements["east"].checked || queryForm.elements["west"].checked)  {
		sqlQuery += " AND (";
		if (queryForm.elements["north"].checked) {
			sqlQuery += "Exposure Like '%N%' OR ";
		}
		if (queryForm.elements["south"].checked) {
			sqlQuery += "Exposure Like '%S%' OR ";
		}
		if (queryForm.elements["east"].checked) {
			sqlQuery += "Exposure Like '%E%' OR ";
		}
		if (queryForm.elements["west"].checked) {
			sqlQuery += "Exposure Like '%W%' OR ";
		}
		sqlQuery = sqlQuery.substr(0, sqlQuery.length-3) + ")";  
	}

	if (queryForm.elements["condition"].value != "Poor") {
		if (queryForm.elements["condition"].value == "Mint") {
			sqlQuery += " AND OverallCondition = 'Mint'";
		}
		if (queryForm.elements["condition"].value == "Excellent") {
			sqlQuery += " AND (OverallCondition = 'Mint' OR OverallCondition = 'Excellent')";
		}
		if (queryForm.elements["condition"].value == "Good") {
			sqlQuery += " AND (OverallCondition = 'Mint' OR OverallCondition = 'Excellent'  OR OverallCondition = 'Good')";
		}
		if (queryForm.elements["condition"].value == "Fair") {
			sqlQuery += " AND (OverallCondition = 'Mint' OR OverallCondition = 'Excellent'  OR OverallCondition = 'Good'   OR OverallCondition = 'Fair')";
		}
	}
	
	if (queryForm.elements["bath_condition"].value != "Poor") {
		if (queryForm.elements["bath_condition"].value == "Mint") {
			sqlQuery += " AND Bath_Cond = 'Mint'";
		}
		if (queryForm.elements["bath_condition"].value == "Excellent") {
			sqlQuery += " AND (Bath_Cond = 'Mint' OR Bath_Cond = 'Excellent')";
		}
		if (queryForm.elements["bath_condition"].value == "Good") {
			sqlQuery += " AND (Bath_Cond = 'Mint' OR Bath_Cond = 'Excellent'  OR Bath_Cond = 'Good')";
		}
		if (queryForm.elements["bath_condition"].value == "Fair") {
			sqlQuery += " AND (Bath_Cond = 'Mint' OR Bath_Cond = 'Excellent'  OR Bath_Cond = 'Good'   OR Bath_Cond = 'Fair')";
		}
	}
	
	if (queryForm.elements["kitchen_condition"].value != "Poor") {
		if (queryForm.elements["kitchen_condition"].value == "Mint") {
			sqlQuery += " AND Kitchen_Cond = 'Mint'";
		}
		if (queryForm.elements["kitchen_condition"].value == "Excellent") {
			sqlQuery += " AND (Kitchen_Cond = 'Mint' OR Kitchen_Cond = 'Excellent')";
		}
		if (queryForm.elements["kitchen_condition"].value == "Good") {
			sqlQuery += " AND (Kitchen_Cond = 'Mint' OR Kitchen_Cond = 'Excellent'  OR Kitchen_Cond = 'Good')";
		}
		if (queryForm.elements["kitchen_condition"].value == "Fair") {
			sqlQuery += " AND (Kitchen_Cond = 'Mint' OR Kitchen_Cond = 'Excellent'  OR Kitchen_Cond = 'Good'   OR Kitchen_Cond = 'Fair')";
		}
	}
	
}  // end "if (! apartmentFactsOnly) "

// save the query, sans the location and sort specs, for use in the maps (to show which places meet these criteria)
noLocSqlQuery = sqlQuery.substr(formLocationPart);
jQuery.jStorage.set("formLocationPart", noLocSqlQuery);

//alert(sqlQuery);
// now add location specs from the maps
var street;  
var number;
var lowNumber;
var highNumber;
var street2;
var number2;
var lowNumber2;
var highNumber2;
var firstOdd;
places = jQuery.jStorage.index();
if (places.length > 1) { // formLocationsPart will always be there 
	sqlQuery += " AND ("
	for (var i=0; i<places.length; i++)  {
		if (places[i] == "formLocationPart") continue;
		if (places[i].indexOf("-") > -1 && places[i] != "Neighborhood:Riverside Drive-West End Avenue") {  // if there's a dash, it's a street spec (except RSD-WEA), otherwise it's a neighborhood spec
			if (places[i].indexOf(",") > -1) {
				firstPlace = places[i].substr(0, places[i].indexOf(","));
				secondPlace = places[i].substr(places[i].indexOf(",")+1);
			} else {
				firstPlace = places[i];
				secondPlace = "";
			}
			street = firstPlace.substr(0, firstPlace.indexOf(":"));
			number = firstPlace.substr(firstPlace.indexOf(":")+1);
			lowNumber = number.substr(0, number.indexOf("-"));
			highNumber = number.substr(number.indexOf("-")+1);
			if (secondPlace == "") {  // if a whole street/avenue spec, don't worry about odd/even addresses
				sqlQuery += " (street_name = '"  + street + "' AND address_number between " + lowNumber + " AND " + highNumber + " )";
			} else {
				street2 = secondPlace.substr(0, secondPlace.indexOf(":"));
				number2 = secondPlace.substr(secondPlace.indexOf(":")+1);
				lowNumber2 = number.substr(0, number.indexOf("-"));
				highNumber2 = number.substr(number.indexOf("-")+1);
				// the following is needed to handle odd/even addresses properly - only matters on block-style loc specs (two piece)
				var street1num = street.substr(street.indexOf(" ")+1);
				street1num = street1num.substr(0,street1num.indexOf(" "));
				var street2num = street2.substr(street2.indexOf(" ")+1);
				street2num = street2num.substr(0,street2num.indexOf(" "));
				if (Number(street1num) < Number(street2num)) {
					firstOdd = true;
				} else {
					firstOdd = false;
				}
				if (firstOdd) {
					sqlQuery += " (street_name = '"  + street + "' AND address_number between " + lowNumber + " AND " + highNumber + " AND  (address_number % 2) = 1)";
				} else {
					sqlQuery += " (street_name = '"  + street + "' AND address_number between " + lowNumber + " AND " + highNumber + " AND  (address_number % 2) = 0)";
				}
				sqlQuery += " OR ";
				street = secondPlace.substr(0, secondPlace.indexOf(":"));
				number = secondPlace.substr(secondPlace.indexOf(":")+1);
				lowNumber = number.substr(0, number.indexOf("-"));
				highNumber = number.substr(number.indexOf("-")+1);
				if (!firstOdd) {
					sqlQuery += " (street_name = '"  + street2 + "' AND address_number between " + lowNumber2 + " AND " + highNumber2 + " AND  (address_number % 2) = 1)";
				} else {
					sqlQuery += " (street_name = '"  + street2 + "' AND address_number between " + lowNumber2 + " AND " + highNumber2 + " AND  (address_number % 2) = 0)";
				}
			}
		} else {
			neighborhoodName = places[i].substr(places[i].indexOf(":")+1);
			sqlQuery += " neighborhood = '"  + neighborhoodName + "'";
		}
		sqlQuery += " OR ";
	}
	sqlQuery = sqlQuery.substr(0, sqlQuery.length-3) + ")";    // trim off the last OR, and close the parens
}
sqlQuery += " ORDER BY neighborhood, street_name LIMIT 40"
// + queryForm.elements["sort1"].value  + ", " + queryForm.elements["sort2"].value  + ", " + queryForm.elements["sort3"].value + " LIMIT 40";
// action != EXEC or Re-EXEC is used by the maps to create a query in jQuery.jStorage called formLocationPart (see just above) to feed to page-qualquery.php for redlining
if (action == "EXEC" || action == "RE-EXEC") {  // EXEC is initiated within the Search Form, RE-EXEC is a response to changes on the maps
	jQuery("#queryresults").load("http://re-re.info/runquery", {query: sqlQuery});
} else {
	parsedQuery = sqlQuery;
}
if (action != "RE-EXEC") {  // this test prevents a loop between the Search form and the maps ping-pong responding to each others' updates
	localStorage.setItem("searchInfoChanged", "1");  // tells map pages to refresh with new search criteria
}

sessionStorage.setItem("searchSubmitted", "1");    //  tells the search form to autosubmit on changes (after the first one is submitted)
return(0);
}

/* function priceToInteger(price) {
	if (! price > "") return("0");
	price = price.replace(/ /g, "");
	price = price.replace(/,/g, "");
	price = price.replace(".00", "");
	price = price.replace("$", "");
	price = price.replace("$", "");
	if (isNaN(price)) {
		alert("Sorry, but we cannot understand your budget range as entered");
		return("0");
	} else { 
		return(price);
	}
}
*/