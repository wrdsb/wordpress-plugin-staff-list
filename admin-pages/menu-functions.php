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
  //Create an instance of our package class...
  $staff_list_table = new Staff_List_Table();
  //Fetch, prepare, sort, and filter our data...
  $staff_list_table->prepare_items();
  ?>
    <div class="wrap">

        <div id="icon-users" class="icon32"><br/></div>
        <h2>Staff List Management</h2>

        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="staff-filter" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $staff_list_table->display() ?>
        </form>

    </div>
<?php } ?>
