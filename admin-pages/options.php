<?php
$users = get_users();

// Table of users, with options.
echo '<table border="1" width="100%">';
  echo '<tr>';
    echo '<th>Display?</th>';
    echo '<th>Last Name</th>';
    echo '<th>First Name</th>';
    echo '<th>Job Description</th>';
    echo '<th>Email</th>';
    echo '<th>Voicemail</th>';
  echo '</tr>';
  //TODO We should figure out how to grab all the meta fields with one query
  foreach ( $users as $user ) {
    echo '<tr>';
      echo '<td>' . get_user_meta($user->ID, 'in_staff_list', true)   . '</td>';
      echo '<td>' . get_user_meta($user->ID, 'last_name', true)       . '</td>';
      echo '<td>' . get_user_meta($user->ID, 'first_name', true)      . '</td>';
      echo '<td>' . get_user_meta($user->ID, 'job_description', true) . '</td>';
      echo '<td>' . esc_html($user->user_email)                       . '</td>';
      echo '<td>' . get_user_meta($user->ID, 'voicemail', true)       . '</td>';
    echo '</tr>';
  }
echo '</table>';
?>
