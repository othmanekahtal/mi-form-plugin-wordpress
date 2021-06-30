<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
// drop a custom database table
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS wp_mi_creator_fields_data,wp_mi_creator_fields");
