<?php
/*
* Plugin Name: WRDSB Staff List
* Plugin URI: https://github.com/wrdsb/wordpress-plugin-staff-list
* Description: Displays staff lists on websites, based on local WP user data.
* Author: WRDSB
* Author URI: https://github.com/wrdsb
* Version: 0.1.7
* License: GPLv2 or later
* GitHub Plugin URI: wrdsb/wordpress-plugin-staff-list
* GitHub Branch: master
*/

require_once dirname( __FILE__ ) . "/admin-pages/menu-functions.php";

add_filter( 'user_contactmethods','wrdsb_remove_user_profile_fields',10,1);
add_action( 'show_user_profile', 'wrdsb_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'wrdsb_extra_user_profile_fields' );
add_action( 'personal_options_update', 'wrdsb_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'wrdsb_save_extra_user_profile_fields' );

function wrdsb_remove_user_profile_fields($contactmethods) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
  return $contactmethods;
}

function wrdsb_save_extra_user_profile_fields($user_id) {
  if (!current_user_can('edit_user', $user_id)) { return false; }
  update_user_option($user_id, 'wrdsb_voicemail', $_POST['wrdsb_voicemail']);
  update_user_option($user_id, 'wrdsb_job_title', $_POST['wrdsb_job_title']);
  update_user_option($user_id, 'wrdsb_display_in_staff_list', $_POST['wrdsb_display_in_staff_list']);
  update_user_option($user_id, 'wrdsb_contact_options', $_POST['wrdsb_contact_options']);
  update_user_option($user_id, 'wrdsb_website_url', $_POST['wrdsb_website_url']);
}

function wrdsb_extra_user_profile_fields($user) { ?>
  <h3>Staff List Options for this Website</h3>
  <p>The following options determine what, if any, information is displayed about you
     in this website's Staff List. <strong>This information can be different for each website.</strong></p>
  <table class="form-table">
    <tr>
      <th><label for="wrdsb_job_title">Your Role</label></th>
      <td>
        <select id="wrdsb_job_title" name="wrdsb_job_title">
          <option value=""                      <?php selected('', get_user_option('wrdsb_job_title', $user->ID)); ?>>Blank</option>
          <option value="Custodian"             <?php selected('Custodian', get_user_option('wrdsb_job_title', $user->ID)); ?>>Custodian</option>
          <option value="CYW"                   <?php selected('CYW', get_user_option('wrdsb_job_title', $user->ID)); ?>>CYW</option>
          <option value="DECE"                  <?php selected('DECE', get_user_option('wrdsb_job_title', $user->ID)); ?>>DECE</option>
          <option value="Department Head"       <?php selected('Department Head', get_user_option('wrdsb_job_title', $user->ID)); ?>>Department Head</option>
          <option value="Educational Assistant" <?php selected('Educational Assistant', get_user_option('wrdsb_job_title', $user->ID)); ?>>Educational Assistant</option>
          <option value="Head Secretary"        <?php selected('Head Secretary', get_user_option('wrdsb_job_title', $user->ID)); ?>>Head Secretary</option>
          <option value="Library Clerk"         <?php selected('Library Clerk', get_user_option('wrdsb_job_title', $user->ID)); ?>>Library Clerk</option>
          <option value="Office Manager"        <?php selected('Office Manager', get_user_option('wrdsb_job_title', $user->ID)); ?>>Office Manager</option>
          <option value="Principal"             <?php selected('Principal', get_user_option('wrdsb_job_title', $user->ID)); ?>>Principal</option>
          <option value="School Social Worker"  <?php selected('School Social Worker', get_user_option('wrdsb_job_title', $user->ID)); ?>>School Social Worker</option>
          <option value="Secretary"             <?php selected('Secretary', get_user_option('wrdsb_job_title', $user->ID)); ?>>Secretary</option>
          <option value="Teacher"               <?php selected('Teacher', get_user_option('wrdsb_job_title', $user->ID)); ?>>Teacher</option>
          <option value="Vice-Principal"        <?php selected('Vice-Principal', get_user_option('wrdsb_job_title', $user->ID)); ?>>Vice-Principal</option>
        </select>
        <br /><span class="description">If you do not see your role in this list, please file an <a href="https://itservicedesk.wrdsb.ca/">IT Service Desk ticket</a> and we'll happily add it for you. While you are waiting for the role to be added, please choose Blank from this list, or choose to not display your information in the Staff List.</span>
      </td>
    </tr>
    <tr>
      <th><label for="wrdsb_contact_options">Display which contact information?</label></th>
      <td>
        <select id="wrdsb_contact_options" name="wrdsb_contact_options">
          <option value="Both" <?php selected('Both', get_user_option('wrdsb_contact_options', $user->ID)); ?>>Both email and voicemail</option>
          <option value="Email" <?php selected('Email', get_user_option('wrdsb_contact_options', $user->ID)); ?>>Email only</option>
          <option value="Voicemail" <?php selected('Voicemail', get_user_option('wrdsb_contact_options', $user->ID)); ?>>Voicemail only</option>
        </select>
      </td>
    </tr>
    <tr>
      <th><label for="wrdsb_voicemail">Voicemail Extension</label></th>
      <td>
        <input type="text" id="wrdsb_voicemail" name="wrdsb_voicemail" size="6" value="<?php echo esc_attr(get_user_option('wrdsb_voicemail', $user->ID)); ?>" />
        <span class="description">Enter a voicemail extension (12345)</span>
      </td>
    </tr>
    <tr>
      <th><label for="wrdsb_website_url">Website URL</label></th>
      <td>
        <input type="text" id="wrdsb_website_url" name="wrdsb_website_url" size="50" value="<?php echo esc_attr(get_user_option('wrdsb_website_url', $user->ID )); ?>" />
        <br /><span class="description">Enter a wrdsb.ca website URL (http://teachers.wrdsb.ca/mysite or http://blogs.wrdsb.ca/myblog). Non-WRDSB website URLs will not be displayed. Please create a teachers.wrdsb.ca website and link to outside websites from there. Don't forget the http://</span>
      </td>
    </tr>
    <tr>
      <th><label for="wrdsb_display_in_staff_list">Display in Staff List?</label></th>
      <td>
        <input type="checkbox"
               id="wrdsb_display_in_staff_list"
               name="wrdsb_display_in_staff_list"
               <?php if ((get_user_option('wrdsb_display_in_staff_list', $user->ID)) == '1') { ?>checked="checked"<?php } ?>
               value="1"
        />
        <span class="description">This box must be checked if you wish to appear in this website's Staff List.</span>
      </td>
    </tr>
  </table>
  <script>
    jQuery(document).ready(function() {
      jQuery('#nickname').parent().parent().hide();
      jQuery('#display_name').parent().parent().hide();
      jQuery('#url').parent().parent().hide();
    });
  </script>
<?php } ?>
