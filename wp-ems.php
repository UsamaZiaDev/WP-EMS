<?php
/*
 * Plugin Name:       Employee Management System
 * Description:       This is a CRUD Employee Management System.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            usama Zia
 * Author URI:        https://usamazia.dev/
 * License:           GPL
 * Text Domain:       ems
 */

define("EMP_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("EMP_PLUGIN_URL", plugin_dir_url(__FILE__));


// add enqueue scripts
function ems_enqueue_scripts(){
    wp_enqueue_style("ems-bootstrap", EMP_PLUGIN_URL."assets/css/bootstrap.css", array(), "1.0.0", false);
    wp_enqueue_style("ems-data-tables", EMP_PLUGIN_URL."assets/css/data-tables.css", array(), "1.0.0", false);

    wp_enqueue_script( "ems-data-tables", EMP_PLUGIN_URL."assets/js/data-tables.js", array("jquery"), "1.0.0", true );
    wp_enqueue_script( "ems-scripts", EMP_PLUGIN_URL."assets/js/ems-scripts.js", array(), "1.0.0", true );
}
add_action("admin_enqueue_scripts", "ems_enqueue_scripts");


// add menu page
function ems_add_admin_menu(){
    add_menu_page(
        "Employee System | Employee Management System ", "Employee System", "manage_options", "employee-system", "ems_crud_system","dashicons-list-view", 60
    );

    add_submenu_page( "employee-system", "List Employee", "List Employee", "manage_options", "employee-system", "ems_crud_system");
    add_submenu_page( "employee-system", "Add Employee", "Add Employee", "manage_options", "add-employee", "ems_add_employee");
}
add_action("admin_menu", "ems_add_admin_menu");

function ems_crud_system(){
    require_once(EMP_PLUGIN_PATH."pages/list-employee.php");
}

function ems_add_employee(){
    require_once(EMP_PLUGIN_PATH."pages/add-employee.php");
}


function ems_create_table(){

    global $wpdb;
    $tablePrefix = $wpdb->prefix;
    
    $sqlQuery =  "CREATE TABLE `{$tablePrefix}ems_form_data` (
                    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `name` varchar(50) NULL,
                    `email` varchar(50) NULL,
                    `phone` int(15) NULL,
                    `gender` enum('male','female','other') NULL,
                    `designation` varchar(50) NULL
                )";

    include_once ABSPATH . "wp-admin/includes/upgrade.php";
    dbDelta($sqlQuery);
}
register_activation_hook(__FILE__, "ems_create_table");


function ems_drop_table(){
    global $wpdb;
    $tablePrefix = $wpdb -> prefix;
    $sqlQuery = "DROP TABLE  IF EXISTS {$tablePrefix}ems_form_data";
    $wpdb -> query($sqlQuery);
}
register_deactivation_hook(__FILE__, "ems_drop_table");