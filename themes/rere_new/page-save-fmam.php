<?php /*
Template Name: saveFMaM
*/

if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

    die('You didn\'t tell the magic words!!');
}

global $wpdb;

$content = addslashes($_POST["content"]);
$form = addslashes($_POST["form"]);
$query = "INSERT INTO wp_fmam_json (content, form) VALUES ('{$content}', '{$form}')";

$results = $wpdb->query($query);

echo "1";
