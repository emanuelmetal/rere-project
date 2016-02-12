<?php /*
Template Name: savePaP
*/

$ds = DIRECTORY_SEPARATOR;
$root_folder = ABSPATH .'pap_upload';
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

    die('You didn\'t tell the magic words!!');
}

global $wpdb;

$content = addslashes($_POST["content"]);

$message = strip_tags($_POST["message"]);

$file0 = $_POST["file0"];
$file1 = $_POST["file1"];
$file2 = $_POST["file2"];

$subject = 'A new Property was posted!';
$attachments = array();
if ($file0 != ""){
	$attachments[] = $root_folder . $ds. $file0;
}

if ($file1 != ""){
	$attachments[] = $root_folder . $ds. $file1;
}

if ($file2 != ""){
	$attachments[] = $root_folder . $ds. $file2;
}
error_log(print_r($attachments, TRUE)); 
wp_mail('prado.daniels@gmail.com', $subject, $message, '',$attachments);

echo 1;
