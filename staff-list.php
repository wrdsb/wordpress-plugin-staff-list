<?php
/*
* Plugin Name: WRDSB Staff List
* Plugin URI: https://github.com/wrdsb/wordpress-plugin-staff-list
* Description: Displays staff lists on websites, based on local WP user data.
* Author: James Schumann
* Author URI: http://james.schumann.ca
* Version: 0.0.1
* License: GPLv2 or later
*/

require_once dirname( __FILE__ ) . "/admin-pages/menu-functions.php";

add_action( 'show_user_profile', 'wrdsb_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'wrdsb_extra_user_profile_fields' );
add_action( 'personal_options_update', 'wrdsb_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'wrdsb_save_extra_user_profile_fields' );

function wrdsb_save_extra_user_profile_fields($user_id) {
  if (!current_user_can('edit_user', $user_id)) { return false; }
  update_user_meta($user_id, 'wrdsb_job_title', $_POST['wrdsb_job_title']);
  update_user_meta($user_id, 'wrdsb_voicemail', $_POST['wrdsb_voicemail']);
  update_user_meta($user_id, 'wrdsb_display_in_staff_list', $_POST['wrdsb_display_in_staff_list']);
  update_user_meta($user_id, 'wrdsb_contact_options', $_POST['wrdsb_contact_options']);
}

function wrdsb_extra_user_profile_fields($user) { ?>
  <h3>Staff List Options</h3>
  <table class="form-table">
    <tr>
      <th><label for="wrdsb_job_title">Your Role</label></th>
      <td>
        <select id="wrdsb_job_title" name="wrdsb_job_title">
          <option value="Principal"       <?php selected('Principal', get_the_author_meta('wrdsb_job_title', $user->ID)); ?>>Principal</option>
          <option value="Vice-Principal"  <?php selected('Vice-Principal', get_the_author_meta('wrdsb_job_title', $user->ID)); ?>>Vice-Principal</option>
          <option value="Head Secretary"  <?php selected('Head Secretary', get_the_author_meta('wrdsb_job_title', $user->ID)); ?>>Head Secretary</option>
          <option value="Office Manager"  <?php selected('Office Manager', get_the_author_meta('wrdsb_job_title', $user->ID)); ?>>Office Manager</option>
          <option value="Secretary"       <?php selected('Secretary', get_the_author_meta('wrdsb_job_title', $user->ID)); ?>>Secretary</option>
          <option value="Teacher"         <?php selected('Teacher', get_the_author_meta('wrdsb_job_title', $user->ID)); ?>>Teacher</option>
          <option value="Department Head" <?php selected('Department Head', get_the_author_meta('wrdsb_job_title', $user->ID)); ?>>Department Head</option>
          <option value="Educational Assistant" <?php selected('Educational Assistant', get_the_author_meta('wrdsb_job_title', $user->ID)); ?>>Educational Assistant</option>
          <option value="Custodian"       <?php selected('Custodian', get_the_author_meta('wrdsb_job_title', $user->ID)); ?>>Custodian</option>
        </select>
      </td>
    </tr>
    <tr>
      <th><label for="wrdsb_voicemail">Voicemail</label></th>
      <td>
        <input type="text" id="wrdsb_voicemail" name="wrdsb_voicemail" size="6" value="<?php echo esc_attr(get_the_author_meta('wrdsb_voicemail', $user->ID )); ?>">
        <span class="description">Enter a voicemail extension (12345)</span>
      </td>
    </tr>
    <tr>
      <th><label for="wrdsb_display_in_staff_list">Display in Staff List?</label></th>
      <td>
        <input type="checkbox"
               id="wrdsb_display_in_staff_list"
               name="wrdsb_display_in_staff_list"
               <?php if ((get_the_author_meta('wrdsb_display_in_staff_list', $user->ID)) == '1') { ?>checked="checked"<?php } ?>
               value="1"
        >
        <span class="description">Should this user appear in the site's Staff List?</span>
      </td>
    </tr>
    </tr>
      <th><label for="wrdsb_contact_options">Display which contact information?</label></th>
      <td>
        <select id="wrdsb_contact_options" name="wrdsb_contact_options">
          <option value="Both" <?php selected('Both', get_the_author_meta('wrdsb_contact_options', $user->ID)); ?>>Both email and voicemail</option>
          <option value="Email" <?php selected('Email', get_the_author_meta('wrdsb_contact_options', $user->ID)); ?>>Email only</option>
          <option value="Voicemail" <?php selected('Voicemail', get_the_author_meta('wrdsb_contact_options', $user->ID)); ?>>Voicemail only</option>
        </select>
      </td>
    </tr>
  </table>
<?php } ?>
