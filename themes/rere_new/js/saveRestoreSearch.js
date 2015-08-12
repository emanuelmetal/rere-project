function saveSearch(key)
{
processForm("NOEXEC");  // processes Search form and builds parsedQuery, doesn't call the runquery page

var sqlQuery = "DELETE FROM wp_saved_search WHERE userid = '" + key + "'";
jQuery("#query").load("http://re-re.info/runquery", {query: sqlQuery});

sqlQuery = "INSERT INTO wp_saved_search (userid, querytext) VALUES ( '" + key + "', '" + parsedQuery + "')";
jQuery("#query").load("http://re-re.info/runquery", {query: sqlQuery});
return(0);
}


function restoreSearch(key)
{
var tmp, tnum, lowAddr, hiAddr;
queryForm = document.forms[0];
var sqlQuery = "SELECT querytext FROM wp_saved_search WHERE userid = '" + key + "'";
jQuery("#query").load("http://re-re.info/runquery", {query: sqlQuery});
sqlQuery = jQuery("#query").html();

if (sqlQuery.indexOf("zip = " != -1) {
	queryForm.elements["zip"].value = sqlQuery.substr(sqlQuery.indexOf("zip = ")+7, 5);
	jQuery.jStorage.flush(); 
	jQuery("#locations_selected").html("");
	jQuery("#search_locations").show();	/* in case we're on the search form */
}

if (sqlQuery.indexOf("part_of_town = " != -1) {
	tmp = sqlQuery.substr(sqlQuery.indexOf("part_of_town = ")+16);
	queryForm.elements["part_of_town"].value = tmp.substr(0,tmp.indexOf("'")-1);
	jQuery.jStorage.flush(); 
	jQuery("#locations_selected").html("");
	jQuery("#search_locations").show();	/* in case we're on the search form */
}

f (sqlQuery.indexOf("neighborhood = " != -1) {
	tmp = sqlQuery.substr(sqlQuery.indexOf("neighborhood = ")+16);  // yes, 16, too
	queryForm.elements["neighborhood"].value = tmp.substr(0,tmp.indexOf("'")-1);
	jQuery.jStorage.flush(); 
	jQuery("#locations_selected").html("");
	jQuery("#search_locations").show();	/* in case we're on the search form */
}

tmp = sqlQuery.substr(sqlQuery.indexOf("asking_price BETWEEN")+21);
tnum = tmp.substr(0,tmp.indexOf(" AND")-1)
if (sqlQuery.indexOf("source = 'RO'" == -1) {
	queryForm.elements["price-l"].value = tnum;
	tnum = tmp.substr(tmp.indexOf(" AND")+1)
	queryForm.elements["price-h"].value = tnum;
} else {
	queryForm.elements["rent-l"].value = tnum
	tnum = tmp.substr(tmp.indexOf(" AND")+1)
	queryForm.elements["rent-h"].value = tnum;
	iqueryForm.elements["rlistingtype-rcondo"].checked = true;
}

if (sqlQuery.indexOf("source = 'AV'")  != -1) {
	queryForm.elements["rlistingtype-a"].checked = true;
}
if (sqlQuery.indexOf("source = 'OH'")  != -1) {
	queryForm.elements["rlistingtype-o"].checked = true;
}
if (sqlQuery.indexOf("source = 'SH'")  != -1) {
	queryForm.elements["rlistingtype-s"].checked = true;
}
if (sqlQuery.indexOf("source = 'DD'")  != -1) {
	queryForm.elements["rsolddata-y"].checked = true;
}

// display price/rent fields depending on source
if (sqlQuery.indexOf("source = 'AV'")  != -1 || sqlQuery.indexOf("source = 'OH'")  != -1 || sqlQuery.indexOf("source = 'SH'")  != -1)
	jQuery("#dprice").css("display", "block");
	jQuery("#dfinancing").css("display", "block");
	jQuery("#drent").css("display", "none");
} else {
	jQuery("#dprice").css("display", "none");
	jQuery("#dfinancing").css("display", "none");
	jQuery("#drent").css("display", "block");
}

if (sqlQuery.indexOf("co_op = 'X'")  != -1 && sqlQuery.indexOf("condo = 'X'")  != -1) {
	queryForm.elements["ownership-both"].checked = true;
} else {
	if (sqlQuery.indexOf("co_op = 'X'") ) {
		queryForm.elements["ownership-co-op"].checked = true;
	}
	if (sqlQuery.indexOf("condo = 'X'")  != -1) {
		queryForm.elements["ownership-condo"].checked = true;
	}
}
 
if (sqlQuery.indexOf("financing_allowed = 0" != -1) {
	queryForm.elements["financing"].value = "none";
} else {
	tmp = sqlQuery.substr(sqlQuery.indexOf("financing_allowed BETWEEN")+26);
	tnum = tmp.substr(0,tmp.indexOf(" AND")-1)
	queryForm.elements["financing"].value = tnum;
}
 
tmp = sqlQuery.substr(sqlQuery.indexOf("Rooms BETWEEN")+14);
tnum = tmp.substr(0,tmp.indexOf(" AND")-1)
queryForm.elements["rooms"].value = tnum;
tmp = sqlQuery.substr(sqlQuery.indexOf("Beds BETWEEN")+14);
tnum = tmp.substr(0,tmp.indexOf(" AND")-1)
queryForm.elements["beds"].value = tnum;
tmp = sqlQuery.substr(sqlQuery.indexOf("Baths BETWEEN")+14);
tnum = tmp.substr(0,tmp.indexOf(" AND")-1)
queryForm.elements["baths"].value = tnum;

if (sqlQuery.indexOf("doorman= 'yes'" != -1) {
	queryForm.elements["doorman"].checked= true;
}
if (sqlQuery.indexOf("doorman= 'yes'" != -1) {
	queryForm.elements["concierge"].checked= true;
}
if (sqlQuery.indexOf("doorman= 'yes'" != -1) {
	queryForm.elements["elevator"].checked= true;
}
if (sqlQuery.indexOf("washer_dryer = 'yes' " != -1) {
	queryForm.elements["washer"].checked= true;
}
if (sqlQuery.indexOf("pets = 'yes'" != -1) {
	queryForm.elements["pets"].checked= true;
 }
if (sqlQuery.indexOf("health_club = 'yes'" != -1) {
	queryForm.elements["healthclub"].checked= true;
}

// Full only tested if no Partial, because Partial always accepts Full, e.g. "City Partial" tests for" "City Partial" OR "City Full"
if (sqlQuery.indexOf("Views Like '%Partial%'" != -1) {
	queryForm.elements["any-views"].checked=true;
} else {
	if (sqlQuery.indexOf("Views Like '%Full%'" != -1) {
		queryForm.elements["any-full"].checked=true;
	} 
}
if (sqlQuery.indexOf("Views Like '%City Partial%'" != -1) {
	queryForm.elements["city-partial"].checked=true;
} else {
	if (sqlQuery.indexOf("Views Like '%City Full%'" != -1) {
		queryForm.elements["city-full"].checked=true;
	}
}
if (sqlQuery.indexOf("Views Like '%Skyline Partial%'" != -1) {
	queryForm.elements["skyline-partial"].checked=true;
} else {
	if (sqlQuery.indexOf("Views Like '%Skyline Full%'" != -1) {
		queryForm.elements["skyline-full"].checked=true;
	}
}
if (sqlQuery.indexOf("Views Like '%Park Partial%'" != -1) {
	queryForm.elements["park-partial"].checked=true;
} else {
	if (sqlQuery.indexOf("Views Like '%Park Full%'" != -1) {
		queryForm.elements["park-full"].checked=true;
	}
}
if (sqlQuery.indexOf("Views Like '%River Partial%'" != -1) {
	queryForm.elements["river-partial"].checked=true;
} else {
	if (sqlQuery.indexOf("Views Like '%River Full%'" != -1) {
		queryForm.elements["river-full"].checked=true;
	}
}


if (sqlQuery.indexOf("Private_Outdoor Like '%Terrace%'" > -1) {
	queryForm.elements["terrace"].checked = true;
}
if (sqlQuery.indexOf("Private_Outdoor Like '%Balcony%'" > -1) {
	queryForm.elements["balcony"].checked = true;
}
if (sqlQuery.indexOf("Private_Outdoor Like '%Garden%'" > -1) {
	queryForm.elements["garden"].checked = true;
}

// nested because condition always accepts better than specified, e.g. "Good" tests for: "Good" OR Excellent" OR "Mint"
if (sqlQuery.indexOf("OverallCondition = 'Fair'" > -1) {
	queryForm.elements["condition"].value = "Fair";
} else {
	if (sqlQuery.indexOf("OverallCondition = 'Good'" > -1) {
		queryForm.elements["condition"].value = "Good";
	} else {
		if (sqlQuery.indexOf("OverallCondition = 'Excellent'" > -1) {
			queryForm.elements["condition"].value = "Excellent";
		} else {
			if (sqlQuery.indexOf("OverallCondition = 'Mint'" > -1) {
				queryForm.elements["condition"].value = "Mint";
			}
		}
	}
}


if (sqlQuery.indexOf("street_name = '") > -1) {  // locations from maps are included
	jQuery("#search_locations").hide();
	jQuery.jStorage.flush();
	while (sqlQuery.indexOf("street_name = '") > -1) {
		sqlQuery = sqlQuery.substr(sqlQuery.indexOf("street_name = '")+1);  // strip off "street_name = '"
		tmp = sqlQuery.substr(0, sqlQuery.indexOf("'"));  // extract street name
		sqlQuery = sqlQuery.substr(sqlQuery.indexOf("'")+30); // strip off street name + "' AND address_number between "
		lowAddr = sqlQuery.substr(0, sqlQuery.indexOf(" AND ")-1);  // extract lower address
		sqlQuery = sqlQuery.substr(sqlQuery.indexOf("AND ")+4);  // strip off lower address + "AND "
		hiAddr = sqlQuery.substr(0, sqlQuery.indexOf(" ")-1);  // extract higher address
		// now put into JStorage
		tmp += ": " + lowAddr + "-" hiAddr;   // does it have a blank in it ????????????????
		jQuery.jStorage.set(tmp, "selected");
	}

	var places = jQuery.jStorage.index();
	jQuery("#locations_selected").each(function() {
		var introLabelDone = 0;
		for (var i=0; i<places.length; i++)  {
			if (introLabelDone  == 0) {
				jQuery(this).html("<h3>Locations selected via maps: </h3> ");
				jQuery(this).html(jQuery(this).html() + places[i]);
				introLabelDone = 1;
			} else {
				jQuery(this).html(jQuery(this).html() + "," + places[i]);
			}
		}
	});
}

sqlQuery = sqlQuery.substr(sqlQuery.indexOf(" ORDER BY ")+1);
queryForm.elements["sort1"].value = sqlQuery.substr(sqlQuery.indexOf(" ")-1);
sqlQuery = sqlQuery.substr(sqlQuery.indexOf(" ")+1);
queryForm.elements["sort1ad"].value = sqlQuery.substr(sqlQuery.indexOf(", ")-1);
sqlQuery = sqlQuery.substr(sqlQuery.indexOf(", ")+1);
queryForm.elements["sort2"].value = sqlQuery.substr(sqlQuery.indexOf(" ")-1);
sqlQuery = sqlQuery.substr(sqlQuery.indexOf(" ")+1);
queryForm.elements["sort2ad"].value = sqlQuery.substr(sqlQuery.indexOf(", ")-1);
sqlQuery = sqlQuery.substr(sqlQuery.indexOf(", ")+1);
queryForm.elements["sort3"].value = sqlQuery.substr(sqlQuery.indexOf(" ")-1);
sqlQuery = sqlQuery.substr(sqlQuery.indexOf(" ")+1);
queryForm.elements["sort3ad"].value = sqlQuery.substr(sqlQuery.indexOf(", ")-1);

return(0);
}
