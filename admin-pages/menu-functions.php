<?php
add_action( 'admin_menu', 'register_wrdsb_staff_list_options' );

// add a SchoolPress menu with reports page
function register_wrdsb_staff_list_options() {
  add_menu_page(
    'Options',
    'Staff List',
    'manage_options',
    'options',
    'wrdsb_staff_list_options_page'
  );
}

// function to load admin page
function wrdsb_staff_list_options_page() {
  require_once dirname( __FILE__ ) . "/options.php";
}
?>
