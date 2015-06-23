
function vettBroker(){
queryForm = document.forms[0];
var sqlQuery = "";

// sqlQuery+=" )";
//jQuery("#queryresults").text(sqlQuery);
jQuery("#queryresults").load("http://re-re.info/fmampostboard", {query: sqlQuery});
//////
return(0);
}
		
		