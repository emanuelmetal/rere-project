<?php /*
Template Name: saveFMaM
*/

if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

    die('You didn\'t tell the magic words!!');
}

global $wpdb;

$content = addslashes($_POST["content"]);
$form = addslashes($_POST["form"]);
$message = strip_tags($_POST["message"]);
$query = "INSERT INTO wp_fmam_json (content, form) VALUES ('{$content}', '{$form}')";

$results = $wpdb->query($query);

if ($form == 'buyers') {
    $subject = 'Find me a Match request from a buyer';
}
else {
    $subject = 'Find me a Match request from a seller';
}
wp_mail('ljgrere@gmail.com', $subject, $message);

echo "1";
