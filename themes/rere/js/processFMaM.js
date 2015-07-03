var houseNumber;
var streetName;

function processFMaMForm(){
queryForm = document.forms[0];
var sqlQuery = "";
sqlQuery+="(source,";
sqlQuery+="rental_coop_condo,";  //*************
sqlQuery+="rental_townhouse_loft,";  //************
sqlQuery+="budget_low,"; 
sqlQuery+="budget_high,"; 
sqlQuery += "financing_allowed,";
sqlQuery+="apartment_hotel,"; 
sqlQuery+="private_house,"; 
sqlQuery+="pre_war,"; 
sqlQuery+="post_war,";  
sqlQuery+="townhouse,";  
sqlQuery+="loft,"; 
sqlQuery+="co_op,"; 
sqlQuery+="condo,"; 
sqlQuery+="part_of_town,"; 
sqlQuery+="neighborhood,"; 
// sqlQuery+="zipcode,"; 
sqlQuery+="Rooms,";
sqlQuery+="OverallCondition,";
sqlQuery+="Beds,";
sqlQuery+="Dining_Type,";
sqlQuery+="Baths,";
sqlQuery+="Bath_Cond,";
sqlQuery+="Kitchen_Type,";
sqlQuery+="Library,"; 
sqlQuery+="Maids_quarters,"; 
sqlQuery+="Kitchen_Cond,";
sqlQuery+="Private_Outdoor,";
sqlQuery+="Views,";
sqlQuery+="Exposure,";
sqlQuery+="pets,";
sqlQuery+="washer_dryer,";
sqlQuery+="doorman,";
sqlQuery+="concierge,";
sqlQuery+="manned_elevator,";
sqlQuery+="fireplace,";
sqlQuery+="central_air,";
sqlQuery+="pool,";
sqlQuery+="exercise_room,";
sqlQuery+="parking,";
sqlQuery+="meeting_space,";
sqlQuery+="playroom,";
sqlQuery+="storage,";
sqlQuery+="active,";
sqlQuery+="priorities,";
sqlQuery+="top_priority,";
sqlQuery+="ammenities,";
sqlQuery+="pet_description,";
sqlQuery+="prequal_amount,";
sqlQuery+="cash_down,";
sqlQuery+="email)"; 
sqlQuery+=" VALUES (";

if (queryForm.elements["rlistingtype-forsale"].checked) {sqlQuery+="'AV','',''";}  // ***************** radio buttons - 'AV' includes placeholders for rental-type fields
if (queryForm.elements["rlistingtype-forrent"].checked) {
	sqlQuery+="'RO'";
	if (queryForm.elements["condo-coop-rental"].checked) {sqlQuery+=" ,'X'"} else {sqlQuery+=",''";}
	if (queryForm.elements["townhouse-loft-rental"].checked) {sqlQuery+=" ,'X'"} else {sqlQuery+=",''";}
}

if (queryForm.elements["rlistingtype-forrent"].checked) { 
    sqlQuery+=" , " + (queryForm.elements["rprice-l"].value === "" ? "0" : queryForm.elements["rprice-l"].value);
	sqlQuery+=" , " + (queryForm.elements["rprice-h"].value === "" ? "0" : queryForm.elements["rprice-h"].value);
	sqlQuery+=" ,''";  // financing N/A for rentals
} else {
    sqlQuery+=" , " + (queryForm.elements["price-l"].value === "" ? "0" : queryForm.elements["price-l"].value);
	sqlQuery+=" , " + (queryForm.elements["price-h"].value === "" ? "0" : queryForm.elements["price-h"].value);
	// sqlQuery+=" ,'" + queryForm.elements["financing"].value + "'"; // not on the form yet
	sqlQuery+=" ,''" ; // not on the form yet
}

if (queryForm.elements["apartment_hotel"].checked) {sqlQuery+=" ,'X'";}else {sqlQuery+=",''";}
if (queryForm.elements["private_houses_main"].checked) {sqlQuery+=" ,'X'";}else {sqlQuery+=",''";}
if (queryForm.elements["pre_war"].checked) {sqlQuery+=" ,'X'";}else {sqlQuery+=",''";}
if (queryForm.elements["post_war"].checked) {sqlQuery+=" ,'X'";}else {sqlQuery+=",''";}
sqlQuery+=" ,''" ; // townhouse - not on the form yet
if (queryForm.elements["lofts"].checked) {sqlQuery+=" ,'X'";}else {sqlQuery+=",''";}

if (queryForm.elements["ownership-co-op"].checked) {sqlQuery+=" ,'X'";}else {sqlQuery+=",''";}
if (queryForm.elements["ownership-condo"].checked) {sqlQuery+=" ,'X'";}else {sqlQuery+=",''";}

sqlQuery+=" , '" + queryForm.elements["partoftown"].value +"'" ; 
sqlQuery+=" , '" + queryForm.elements["neighborhood"].value +"'" ; 

sqlQuery+=" ,'" + queryForm.elements["rooms"].value + "'";
sqlQuery+=" ,'" + queryForm.elements["condition"].value + "'" ;
sqlQuery+=" ,'" + queryForm.elements["bedrooms"].value + "'";
sqlQuery+=" ,'" + queryForm.elements["dining"].value + "'" ;
sqlQuery+=" ,'" + queryForm.elements["bathrooms"].value + "'";
sqlQuery+=" ,'" + queryForm.elements["bath_condition"].value + "'"; // Bath_Cond
sqlQuery+=" ,'" + queryForm.elements["kitchen"].value + "'"; //
if (queryForm.elements["library"].checked) {sqlQuery+=" ,'X'";}else {sqlQuery+=",''";}
if (queryForm.elements["maids_quarters"].checked) {sqlQuery+=" ,'X'";}else {sqlQuery+=",''";}
sqlQuery+=" ,'" + queryForm.elements["kitchen_condition"].value + "'"; // Kitchen_Cond

var private_outdoor = ", '";
if (queryForm.elements["terrace"].checked) {private_outdoor += " terrace";}
if (queryForm.elements["balcony"].checked) {private_outdoor += " balcony";}
if (queryForm.elements["garden"].checked) {private_outdoor += " garden";}
sqlQuery+= private_outdoor + "'"; 

var views = ", '";
if (queryForm.elements["park-full"].checked) {views += " park-full";}
if (queryForm.elements["river-full"].checked) {views += " river-full";}
if (queryForm.elements["skyline-full"].checked) {views += " skyline-full";}
if (queryForm.elements["city-full"].checked) {views += " city-full";}
if (queryForm.elements["garden-full"].checked) {views += " garden-full";}
sqlQuery+=views + "'"; 

var exposure = " ,'";
if (queryForm.elements["north"].checked) {exposure += " north";}
if (queryForm.elements["south"].checked) {exposure += " south";}
if (queryForm.elements["east"].checked) {exposure += " east";}
if (queryForm.elements["west"].checked) {exposure += " west";}
sqlQuery+= exposure + "'"; 

if (queryForm.elements["pets"].checked) {sqlQuery+=" ,'yes'";}else {sqlQuery+=" ,'no'";}
if (queryForm.elements["washer"].checked) {sqlQuery+=" ,'yes'";}else {sqlQuery+=" ,'no'";}
sqlQuery+=" ,'yes'";  // doorman - required at this point
if (queryForm.elements["concierge"].checked) {sqlQuery+=" ,'yes'";}else {sqlQuery+=" ,'no'";}
if (queryForm.elements["elevator"].checked) {sqlQuery+=" ,'yes'";}else {sqlQuery+=" ,'no'";}
if (queryForm.elements["fireplace"].checked) {sqlQuery+=" ,1";}else {sqlQuery+=" ,0";}
if (queryForm.elements["central_air"].checked) {sqlQuery+=" ,'yes'";}else {sqlQuery+=" ,'no'";} 
if (queryForm.elements["pool"].checked) {sqlQuery+=" ,'yes'";}else {sqlQuery+=" ,'no'";}
if (queryForm.elements["exercise"].checked) {sqlQuery+=" ,'yes'";}else {sqlQuery+=" ,'no'";}
if (queryForm.elements["garage"].checked) {sqlQuery+=" ,'yes'";}else {sqlQuery+=" ,'no'";}
if (queryForm.elements["meetingroom"].checked) {sqlQuery+=" ,'yes'";}else {sqlQuery+=" ,'no'";}
if (queryForm.elements["playroom"].checked) {sqlQuery+=" ,'yes'";}else {sqlQuery+=" ,'no'";}
if (queryForm.elements["storage"].checked) {sqlQuery+=" ,'yes'";}else {sqlQuery+=" ,'no'";}

sqlQuery+=" ,1"; // active at the beginning

sqlQuery+=" ,'" + queryForm.elements["priorities"].value  +"'" ; ////////////////////
sqlQuery+=" ,'" + queryForm.elements["top_priority"].value  +"'" ; ////////////////////
sqlQuery+=" ,'" + queryForm.elements["ammenities"].value  +"'" ; ////////////////////
sqlQuery+=" ,'" + queryForm.elements["pet_description"].value +"'" ;  ////////////////////
sqlQuery+=" ,'" + queryForm.elements["prequal"].value +"'";  ////////////////////
sqlQuery+=" ,'" + queryForm.elements["cash_down"].value +"'";  ////////////////////
sqlQuery+=" ,'" + queryForm.elements["email"].value  +"'" ; ////////////////////

sqlQuery+=" )";
//jQuery("#queryresults").text(sqlQuery);
//jQuery("#queryresults").load("http://rere.local/savefmam", {query: sqlQuery});
    jQuery.ajax({
        url: 'http://rere.local/savefmam',
        type: 'POST',
        data: {query:sqlQuery},
        success: function(response){
            if (response === '1') {
                jQuery("#queryresults").html('Your request was submitted successfully');
            } else {
                jQuery("#queryresults").html('An error occurred');
            }
        },
        error: function(xhr){
            jQuery("#queryresults").html('An error occurred');
        }
    });
//////
return(0);
}
		
		