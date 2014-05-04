<?php 
/*
Plugin Name: API Add image by URL
Plugin URI: https://github.com/casepress-studio/API-Add-Image-by-URL-to-WordPress
Description: add_attachment_by_url($image_url, $post_id). $post_id - optional.
Version: 20140505
Author: CasePress
Author URI: http://casepress.org
*/

function add_attachment_by_url($image_url, $post_id){


$upload_dir = wp_upload_dir();

$image_data = file_get_contents($image_url);
$filename = basename($image_url);
if(wp_mkdir_p($upload_dir['path']))
    $file = $upload_dir['path'] . '/' . $filename;
else
    $file = $upload_dir['basedir'] . '/' . $filename;

file_put_contents($file, $image_data);
  
$wp_filetype = wp_check_filetype($filename, null );

$attachment = array(
    'post_mime_type' => $wp_filetype['type'],
    'post_title' => sanitize_file_name($filename),
    'post_content' => '',
    'post_status' => 'inherit'
);

//If not $post_id
if(!isset($post_id)) $post_id = 0;

$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

wp_update_attachment_metadata( $attach_id, $attach_data );


}

?>
