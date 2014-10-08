<?php
require_once dirname( __FILE__ ) . "/staff-list-table-class.php";

add_action( 'admin_menu', 'register_wrdsb_staff_list_options' );

// add a SchoolPress menu with reports page
function register_wrdsb_staff_list_options() {
  add_menu_page(
    'Options',
    'Staff List',
    'manage_options',
    'staff-list-options',
    'wrdsb_staff_list_render_list_page'
  );
}

function wrdsb_staff_list_render_list_page() {
  echo '<div class="wrap">';
  echo '<h2>Staff List Management</h2>';
  //Prepare Table of elements
  $staff_list_table = new Staff_List_Table();
  $staff_list_table->prepare_items();

  //Table of elements
  $staff_list_table->display();
  echo '</div>';
}
?>
