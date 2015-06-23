
<?php /*
Template Name: saveFMaM
*/ ?>
<!-- page-save-fmam.php -->
<?php 
global $wpdb;
$query = "INSERT INTO wp_fmam_posting " . str_replace("\'", "'", htmlentities($_POST["query"]));
echo '<div class="debug">';
echo "Query:  "; echo $query; 
echo "<br/><br/></div>"; 

//$wpdb->flush();
$wpdb->show_errors();
$results = $wpdb->query($query);
if ($results === false) {
	print "Error<br/>";
}

$wpdb->print_error();
print "results: " . $results;

?>  