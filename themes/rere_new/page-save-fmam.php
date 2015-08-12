<?php /*
Template Name: saveFMaM
*/

if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

    die('You didn\'t tell the magic words!!');
}

global $wpdb;
$query = "INSERT INTO asd wp_fmam_posting " . str_replace("\'", "'", htmlentities($_POST["query"]));

$results = $wpdb->query($query);

echo $results;
