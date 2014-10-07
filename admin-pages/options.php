<?php
$users = get_users();

// Array of WP_User objects.
foreach ( $users as $user ) {
  echo '<p>';
  echo esc_html($user->user_email);
  echo '<pre>';
  print_r(get_user_meta($user->ID));
  echo '</pre>';
  echo '</p>';
}
?>
