<?php
//Our class extends the WP_List_Table class, so we need to make sure that it's there
if(!class_exists('WP_List_Table')){
  require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Staff_List_Table extends WP_List_Table {
 /*
  * Constructor, we override the parent to pass our own arguments
  * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
  */
  function __construct() {
    parent::__construct( array(
      'singular' => 'Staff List Management', //Singular label
      'plural'   => 'Staff List Management', //plural label, also this well be one of the table css class
      'ajax'     =>  false                   //We won't support Ajax for this table
    ) );
  }

 /**
  * Add extra markup in the toolbars before or after the list
  * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
  */
  function extra_tablenav( $which ) {
    if ( $which == "top" ){
      //The code that goes before the table is here
      echo "Hello, I'm before the table";
    }
    if ( $which == "bottom" ){
      //The code that goes after the table is there
      echo "Hi, I'm after the table";
    }
  }

  function get_bulk_actions() {
    return array(
      'Option1' => 'Add to Staff List',
      'Option2' => 'Remove from Staff List'
    );
  }

  function column_cb($item) {
    return sprintf(
      '<input type="checkbox" name="user[]" value="%s" />', $item->ID
    );
  }

 /**
  * This method is called when the parent class can't find a method
  * specifically build for a given column.
  */
  function column_default($user, $column_name){
    switch($column_name){
      case 'col_display':
        if (($user->get('wrdsb_display_in_staff_list')) == 1) {
          $display_me = 'Yes';
        } else {
          $display_me = 'No';
        }
        return $display_me;
      case 'col_last_name':
        return $user->get('last_name');
      case 'col_first_name':
        return $user->get('first_name');
      case 'col_job_title':
        return $user->get('wrdsb_job_title');
      case 'col_email':
        return esc_html($user->user_email);
      case 'col_voicemail':
        return $user->get('wrdsb_voicemail');
      case 'col_website':
        return $user->get('user_url');
      default:
        return print_r($user,true); //Show the whole array for troubleshooting purposes
    }
  }

 /**
  * Define the columns that are going to be used in the table
  * @return array $columns, the array of columns to use with the table
  */
  function get_columns() {
    $columns = array(
      'cb'                  => '<input type="checkbox" />',
      'col_display'         => 'Displayed?',
      'col_last_name'       => 'Last Name',
      'col_first_name'      => 'First Name',
      'col_job_title'       => 'Job Title',
      'col_email'           => 'Email',
      'col_voicemail'       => 'Voicemail',
      'col_website'         => 'Website'
    );
    return $columns;
  }

 /**
  * Decide which columns to activate the sorting functionality on
  * @return array $sortable, the array of columns that can be sorted by the user
  */
  public function get_sortable_columns() {
    return $sortable = array(
      'col_last_name'       => 'last_name',
      'col_first_name'      => 'first_name',
      'col_job_title'       => 'wrdsb_job_title',
      'col_email'           => 'email'
    );
  }

 /**
  * Prepare the table with different parameters, pagination, columns and table elements
  */
  function prepare_items() {
    $this->_column_headers = array(
      $this->get_columns(),             // columns
      array(),                          // hidden
      $this->get_sortable_columns(),    // sortable
    );

    /* -- Register the Columns -- */
    $columns = $this->get_columns();

    /* -- Fetch the items -- */
    $this->items = get_users();
  }
}
?>
