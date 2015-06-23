jQuery.noConflict();
var explanationOpen = true;
var beenThereSeenThat = false;
var locationsDropdownsVisible = true;
jQuery.jStorage.set("formLocationPart", jQuery.jStorage.get("formLocationPart", ""));  // so it will always be there at least as a null
var places = jQuery.jStorage.index();

jQuery(document).ready(function(){

// first, the dropdown submenu animations
	jQuery("ul#nav > li").each(function(j){ 
		jQuery(this).find("li").each(
			function(i){	/* layer the menu items - must be id="#nav" */
				if (i) {jQuery(this).css("margin-top", "-32px");};
			jQuery(this).css("z-index", 30-i);
			}
		);
	});

	jQuery("ul#nav > li").hoverIntent(	
		function(){  							/* on mouse entry, spread out the top to make them appear */
			jQuery(this).find("li").each(
				function(i){
					jQuery(this).animate({"margin-top": "0px", "opacity": 1.0}, 500);
				}
			);
		},
		function(){   							/* on mouse exit, collapse the top to make them disappear */
			jQuery(this).find("li").each(
				function(i){
					if (i) {
						jQuery(this).animate({"margin-top": "-32px", "opacity": 0.0}, 500);
					} else {
						jQuery(this).animate({"opacity": 0.0}, 500);
					}
				}
			);
		}
	);
// end of the dropdown submenu animations
	
// now, some odd little exclamation-mark explanatory devices
	jQuery(".exclamation a.exlink").click(function(event){
		window.location.href = jQuery(this).attr("href");
		event.preventDefault();
	});
	
	jQuery(".exclamation").find(".explanation").each(
		function(i){
			if (sessionStorage.getItem("beenThereSeenThat") != "1") {
					// alert("first time");
					sessionStorage.setItem("beenThereSeenThat", "1");
					return;
			}
			// alert("beenThereSeenThat");
			jQuery(this).attr("title", jQuery(this).height()); 
			jQuery(this).css("height", "0px"); 
			jQuery(this).css("opacity", "0.0");
			
		});
		
	jQuery(".exclamation").click(
		function(event){  
			jQuery(this).find(".explanation").each(
				function(i){
					if (jQuery(this).height()) {
						jQuery(this).attr("title", jQuery(this).height()); 
						jQuery(this).animate({"height": "0px", "opacity": 0.0}, 1200);
						explanationOpen = false;						
					} else {
						jQuery(this).animate({"height": jQuery(this).attr("title"), "opacity": 1.0}, 1200);
						explanationOpen = true;						
					}
				}
			);
			event.preventDefault();
		}
	);
	
	
// what follows are a large set of handlers for various tricks on the Search form
	
	// these next two do what the two below do, only these are for after a page refresh
	jQuery("#rlistingtype-forsale:checked").each(
			function(event){ 
			jQuery("div.budget-forsale").css("display", "inline");
			jQuery("div.budget-forrent").css("display", "none");
			jQuery("div.rental-type").css("display", "none");
			jQuery(".for_sale").css("display", "inline-block");
		}
	);
	
	jQuery("#rlistingtype-forrent:checked").each(
			function(event){ 
			jQuery("div.budget-forsale").css("display", "none");
			jQuery("div.budget-forrent").css("display", "inline");
			jQuery("div.rental-type").css("display", "inline-block");
			jQuery(".for_sale").css("display", "none");
		}
	);
	
	jQuery("#rlistingtype-forsale").click(
		function(event){ 
			jQuery("div.budget-forsale").css("display", "inline");
			jQuery("div.budget-forrent").css("display", "none");
			jQuery("div.rental-type").css("display", "none");
			jQuery(".for_sale").css("display", "inline-block");
		}
	);
	
	jQuery("#rlistingtype-forrent").click(
		function(event){ 
			jQuery("div.budget-forsale").css("display", "none");
			jQuery("div.budget-forrent").css("display", "inline");
			jQuery("div.rental-type").css("display", "inline-block");
			jQuery(".for_sale").css("display", "none");
		}
	);
	
	jQuery(".ownership").css("opacity", "0.0");
	jQuery("#apartment_houses").css("display", "none");
	jQuery("#private_houses").css("display", "none");
	
	jQuery("#lofts:checked").each(function(i){ 
		jQuery(".ownership").css("opacity", "1.0");
	});
	
	jQuery("#private_houses_main:checked").each(function(i){ 
		jQuery("#private_houses").css("display", "inline-block");
	});
	
	jQuery("#apartment_houses_main:checked").each(
			function(i){ 
			jQuery(".ownership").css("opacity", "1.0");
			jQuery("#apartment_houses").css("display", "inline-block");
	});
	
	jQuery("#lofts").click(function(event){
		jQuery(".ownership").css("opacity", "0.0");
		jQuery("#lofts:checked").each(function(i){ 
			jQuery(".ownership").css("opacity", "1.0");
		});
	});
	
	/* jQuery("#private_houses_main").click(function(event){
		jQuery("#private_houses").css("display", "none");
		jQuery("#private_houses_main:checked").each(function(i){ 
			jQuery("#private_houses").css("display", "inline-block");
		}); 
	}); */
	
	jQuery("#apartment_houses_main").click(function(event){
		jQuery(".ownership").css("opacity", "0.0");
		jQuery("#apartment_houses").css("display", "none");
		jQuery("#apartment_houses_main:checked").each(function(i){ 
			jQuery(".ownership").css("opacity", "1.0");
			jQuery("#apartment_houses").css("display", "inline-block");
		});
	});
		
		
	if (Number(jQuery("select#rooms").val()) >= 6 || Number(jQuery("select#rooms").val()) == 0) {
		jQuery(".library, .maids").css("display", "inline-block");
	}
	 jQuery("select#rooms").change(function(){
		if (Number(jQuery("select#rooms").val()) >= 6 || Number(jQuery("select#rooms").val()) == 0) {
			jQuery(".library, .maids, #library, #maids_quarters").css("display", "inline-block");
		} else {
			jQuery(".library, .maids, , #library, #maids_quarters").css("display", "none");
		}
	});
	
	jQuery("#rshowingtype-a").click(
		function(event){ 
			jQuery("#ddatetime").css("display", "none");
		}
	);
	jQuery("#rshowingtype-s").click(
		function(event){ 
			jQuery("#ddatetime").css("display", "block");
		}
	);
	jQuery("#rlistingtype-p").click(
		function(event){ 
			jQuery("#dprice").css("display", "block");
			jQuery("#dfinancing").css("display", "block");
			jQuery("#drent").css("display", "none");
		}
	);
	jQuery("#rlistingtype-o").click(
		function(event){ 
			jQuery("#dprice").css("display", "block");
			jQuery("#dfinancing").css("display", "block");
			jQuery("#drent").css("display", "none");
		}
	);
	jQuery("#rlistingtype-rcondo").click(
		function(event){ 
			jQuery("#dprice").css("display", "none");
			jQuery("#dfinancing").css("display", "none");
			jQuery("#drent").css("display", "block");
		}
	);				
	jQuery("#rlistingtype-rco-op").click(
		function(event){ 
			jQuery("#dprice").css("display", "none");
			jQuery("#dfinancing").css("display", "none");
			jQuery("#drent").css("display", "block");
		}
	);
	jQuery("#role-buyer").click(
		function(event){ 
			jQuery("#buyer").css("display", "block");
			jQuery("#broker").css("display", "none");
		}
	);
	jQuery("#role-broker").click(
		function(event){ 
			jQuery("#broker").css("display", "block");
			jQuery("#buyer").css("display", "none");
		}
	);
jQuery("#rlistingtype-rco-op").click(
		function(event){ 
			jQuery("#drent-l").css("display", "block");
			jQuery("#drent-h").css("display", "block");
			jQuery("#dprice-l").css("display", "none");
			jQuery("#dprice-h").css("display", "none");
		}
	);
	jQuery("#rlistingtype-rcondo").click(
		function(event){ 
			jQuery("#drent-l").css("display", "block");
			jQuery("#drent-h").css("display", "block");
			jQuery("#dprice-l").css("display", "none");
			jQuery("#dprice-h").css("display", "none");
		}
	);
	jQuery("#rlistingtype-p").click(
		function(event){ 
			jQuery("#drent-l").css("display", "none");
			jQuery("#drent-h").css("display", "none");
			jQuery("#dprice-l").css("display", "block");
			jQuery("#dprice-h").css("display", "block");
		}
	);
	jQuery("#rlistingtype-o").click(
		function(event){ 
			jQuery("#drent-l").css("display", "none");
			jQuery("#drent-h").css("display", "none");
			jQuery("#dprice-l").css("display", "block");
			jQuery("#dprice-h").css("display", "block");
		}
	);
	jQuery("#rlistingtype-t").click(
		function(event){ 
			jQuery("#drent-l").css("display", "none");
			jQuery("#drent-h").css("display", "none");
			jQuery("#dprice-l").css("display", "block");
			jQuery("#dprice-h").css("display", "block");
		}
	);
	jQuery("#rlistingtype-s").click(
		function(event){ 
			jQuery("#drent-l").css("display", "none");
			jQuery("#drent-h").css("display", "none");
			jQuery("#dprice-l").css("display", "block");
			jQuery("#dprice-h").css("display", "block");
		}
	);
	jQuery("#rlistingtype-25").click(
		function(event){ 
			jQuery("#drent-l").css("display", "none");
			jQuery("#drent-h").css("display", "none");
			jQuery("#dprice-l").css("display", "block");
			jQuery("#dprice-h").css("display", "block");
		}
	); 
	
	if (jQuery("#price-l").length) {   //  if we have the search form on the page, resubmit the form every time something changes, after the first submit
		jQuery("select,input").change(function(){
			if (sessionStorage.getItem("searchSubmitted") != "1") {return;}   // set in processSearch.js when a search is submitted
			jQuery("form:first").submit();
		});
	}
// end of handlers for various tricks on the Search form
			
			
// next we have map outline/selection logic
	jQuery('#zipmap').mapster({
		fillColor: '000000',
		render_highlight: {
			fillOpacity: 0.3
		},
		render_select: {
			fillOpacity: 0.5
		},
		fade: true,
		fadeDuration: 200
	});
	
	jQuery('#zipmap2img').mapster({
		fill: true,
		render_highlight: {
			fillOpacity: 0.3
		},
		render_select: {
			fillOpacity: 0.0
		},
		stroke: true,
		strokeColor: 'ff0000',
		strokeWidth: 2,
		isSelectable: false
	});
	
	var firstPlace;  // passing all these data items to the function below is sooo tedious, we'll just move them up here ;)
	var secondPlace;
	var street;  
	var number;
	var lowNumber;
	var highNumber;
	var street2;
	var number2;
	var lowNumber2;
	var highNumber2;
	var firstOdd;
	if (jQuery('#zipmap2').length) { // if this page has a zipmap2
		var sqlQuery = jQuery.jStorage.get("formLocationPart", "");
		var thisZip = jQuery("div.thiszip").text()
		jQuery("#queryresults").load("http://re-re.info/qualquery", {query: sqlQuery, thiszip: thisZip}, function(){
			jQuery('#zipmap2 area').each(function(i){  // once the qualquery results are loaded, sequence through the hotspots to see if they qualify 
				var url =  jQuery(this).attr('href');
				if (url.indexOf(",") > -1) {   // now pick apart this hotspot's location spec; similar code appears in processSearch.js
					firstPlace = url.substr(0, url.indexOf(","));
					secondPlace = url.substr(url.indexOf(",")+1);
				} else {
					firstPlace = url;
					secondPlace = "";
				}
				street = firstPlace.substr(0, firstPlace.indexOf(":"));
				number = firstPlace.substr(firstPlace.indexOf(":")+1);
				lowNumber = number.substr(0, number.indexOf("-"));
				highNumber = number.substr(number.indexOf("-")+1);
				if (secondPlace != "") {
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
				}
				if (firstPlace.indexOf("Avenue") > -1) {
					var x = 0;
				}
				matchLocSpecWithQueryResults(this);  // now that we've got this hotspot's location spec digested, see if any of the queryresults match it
			});		
		});
		localStorage.setItem("searchInfoChanged", "0");
		setInterval("chkRefreshNeeded();", 1000);
	}
	
	
	function matchLocSpecWithQueryResults(obj){
		jQuery('div.address').each(function(i){  // loop through the qualquery results to see if any match this hotspot's location spec
			if ((jQuery(this).find("div.street_name").text() == street || jQuery(this).find("div.street_name").text() == street + " ") && 
				Number(jQuery(this).find("div.address_number").text()) >= Number(lowNumber) && 
				Number(jQuery(this).find("div.address_number").text()) <= Number(highNumber)) {  // street name matches, building number is within range
				if (secondPlace == "") {  // not a block, a whole street/avenue, so we don't care about odd/even
					jQuery(obj).mapster('select');
					return(false);   // no need to look further, this one's qualified - (return(false) breaks the .each loop)
				} else {
					if (firstOdd) {
						if (Number(jQuery(this).find("div.address_number").text()%2 == 1)) {
							jQuery(obj).mapster('select');
							return(false);   // no need to look further, this one's qualified - (return(false) breaks the .each loop)
						}
					} else { 
						if (Number(jQuery(this).find("div.address_number").text()%2 == 0)) {
							jQuery(obj).mapster('select');
							return(false);   // no need to look further, this one's qualified - (return(false) breaks the .each loop)
						}
					}
				}
			}
			if (secondPlace != "" &&   // for blocks (double address location specs), they get a second chance to qualified based on the other street
				jQuery(this).find("div.street_name").text() == street2  && 
				Number(jQuery(this).find("div.address_number").text()) >= Number(lowNumber2) && 
				Number(jQuery(this).find("div.address_number").text()) <= Number(highNumber2)) {
				if (!firstOdd) {  // is the first address isn't odd the second (this address) must be
					if (Number(jQuery(this).find("div.address_number").text()%2 == 1)) {
						jQuery(obj).mapster('select');
						return(false);   // no need to look further, this one's qualified - (return(false) breaks the .each loop)
					}
				} else { 
					if (Number(jQuery(this).find("div.address_number").text()%2 == 0)) {
						jQuery(obj).mapster('select');
						return(false);   // no need to look further, this one's qualified - (return(false) breaks the .each loop)
					}
				}
			}
		});
	}
	

	
	jQuery('#zipmap1 area').each(function(i){
		var url =  jQuery(this).attr('href');
		if (url != "" && url.indexOf("re-re.info") == -1) {
			/* jQuery(this).mapster('set', false, {stroke: true, strokeColor: 'ff0000'}); */
			if (jQuery.jStorage.get(url, "deselected") == "selected") {
				/* jQuery(this).mapster('set', true, {stroke: true, strokeColor: 'ff0000'}); */
				jQuery(this).mapster('select');
				jQuery(this).attr('target', "_new");		/* this is an internal tag for selected areas */
				/* jQuery(this).prop('title', 'selected');	*/
				jQuery(this).mapster('set', true, {stroke: true, strokeColor: 'ff0000'});
			} 
		} 
	});

	/* jQuery("#zipmap1 area").click(function(e){  // if zipmap1 caught the click, there must not be a zipmap2 on this page (e.g. part-of-town pages)
		var url = jQuery(this).attr('href');
		if (url.indexOf("re-re.info") > -1) { // adjacent neighborhood links, i.e. real urls, should be left to do their default action 
			location.href = url;
			return;
		}
	}); */
	 
	jQuery("#zipmap2 area, #zipmap1 area").click(function(e){ // if zipmap1 caught the click, there must not be a zipmap2 on this page (e.g. part-of-town pages)
		var url = jQuery(this).attr('href');
		if (url.indexOf("re-re.info") > -1) { // adjacent neighborhood links, i.e. real urls, should be left to do their default action 
			location.href = url;
			return;
		}
		matchURL(url);   // find the lower layer's URL that matches this layer's clicked=area URL, set it selected (messy if zipmap2 isn't present, but works)
/*		if (jQuery(this).mapster('get_options', 'selected')) {  //  toggle the upper layer's select state back to what it was
			jQuery(this).mapster('select')
		}else {
			jQuery(this).mapster('deselect')
		} */
		jQuery("a b:contains('Search')").css("background", "#ddd");
		e.preventDefault();
	});
	
	jQuery("#clear_all").click(function(e){
		clearThisMap();		// to deselect via mapster - also deselects via jStorage which is redundant w/ the following flush 
		jQuery.jStorage.flush();
		// jQuery("#locations_selected").html("");
		jQuery(".search_locations").show();	// in case we're on the search form 
		locationsDropdownsVisible = true;
		jQuery(".locations_selected").hide();
		e.preventDefault();
	});
	
	jQuery("#clear_this_map").click(function(e){
		clearThisMap();
	});
	
	if (jQuery("#clear_this_map").length) {   // if we're on a map page, modify the actionof the Search link
		jQuery("a b:contains('Search')").click(function(e){
			if (Number(localStorage.getItem("searchActive")) > 0) {  // if a Search page is open, tell it to rerun the query
				localStorage.setItem("mapsInfoChanged", Number(localStorage.getItem("searchActive")));  // each Search form decrements the number when it reruns the query
				e.preventDefault();
			}
			jQuery("a b:contains('Search')").css("background", "#FFFEE7");
		});
	}
	
	function matchURL(upperURL){
		jQuery('#zipmap').css("zindex", "3");
		jQuery('#zipmap1 area').each(function(i){
			var lowerURL =  jQuery(this).attr('href');
			if (lowerURL == upperURL) {
				if (jQuery(this).attr('target') == "_new")  {
					jQuery.jStorage.deleteKey(lowerURL);
					jQuery(this).attr('target', "_blank");
					jQuery(this).mapster('deselect');
				} else {
					jQuery.jStorage.set(lowerURL, "selected");
					jQuery(this).attr('target', "_new");
					jQuery(this).mapster('select');
				}
			}
		});
	}
		
	function clearThisMap(){
		jQuery('#zipmap').css("zindex", "3");
		jQuery('#zipmap1 area').each(function(i){
			var url = jQuery(this).attr('href');
			jQuery.jStorage.deleteKey(url);
			jQuery(this).mapster('deselect');
			jQuery(this).attr('target', "_blank");
		});
	}
				
	jQuery("#locations_selected").each(function() {  return; // for now, no map loc specs are displayed on the search form
		var introLabelDone = 0;
		for (var i=1; i<places.length; i++)  { // formLocationsPart will always be there as the first one (places[0])
			if (introLabelDone  == 0) {
				jQuery(this).html("<h3>Apartment houses are<br/>  selected on the maps by:</h3> ");
				jQuery(this).html(jQuery(this).html() + places[i]);
				introLabelDone = 1;
			} else {
				jQuery(this).html(jQuery(this).html() + "," + places[i]);
			}
		}
	});
// end map outline/selection logic

	if (jQuery(".locations_selected").length) {  // if on a Search page, watch for updates from a maps page
		var i = Number(localStorage.getItem("searchActive"));
		if (! (i >= 0)) {i = 0;}   // in case it's not initialized
		localStorage.setItem("searchActive", i+1);   // this tells the map pages to initiate a search by setting mapsInfoChanged rather than bring up a search page
		setInterval("chkForChangesOnMaps();", 1000);  // keep an eye out for mapsInfoChanged
		jQuery(window).unload(function(){
			localStorage.setItem("searchActive", Number(localStorage.getItem("searchActive"))-1);
		});
	}
		
	// the existence of a #qba div is a signal to re-execute the search when the page loads
	jQuery("#qba").each(function() {
		runQuery();
	});
	
// the following manipulates the Locations section of the Search form to show whether location are controlled via the maps
	if (places.length > 1) {   // formLocationsPart will always be there
		jQuery(".search_locations").hide();
		locationsDropdownsVisible = false;
		jQuery(".locations_selected").show();
	} else {
		jQuery(".locations_selected").hide();
		locationsDropdownsVisible = true;
		jQuery(".search_locations").show();
	}
	
});

function chkRefreshNeeded(){   // see if the Search form has had its criteria changed - called periodically on map pages via setInterval()
	if (localStorage.getItem("searchInfoChanged") == "1") {
		location.reload();
	}
}

function chkForChangesOnMaps(){   // see if the Search form has had its criteria changed - called periodically on map pages via setInterval()
	if (Number(localStorage.getItem("mapsInfoChanged")) > 0) {
		processForm('RE-EXEC');
		if (places.length > 1) {   // see if there are any map selections left, just like when we loaded the page (FYI, formLocationsPart will always be there)
			jQuery(".search_locations").hide();
			locationsDropdownsVisible = false;
			jQuery(".locations_selected").show();
		} else {
			jQuery(".locations_selected").hide();
			locationsDropdownsVisible = true;
			jQuery(".search_locations").show();
		}
		// localStorage.setItem("mapsInfoChanged", "0");
		localStorage.setItem("mapsInfoChanged", Number(localStorage.getItem("mapsInfoChanged"))-1);
	}
}
