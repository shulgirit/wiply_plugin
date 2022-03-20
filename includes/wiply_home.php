<?php


/**
 * Front end registration
 */

/** Step 2 (from text above). */
add_action('admin_menu', 'wiply_menu_home');

/** Step 1. */
function wiply_menu_home()
{
    add_menu_page('Wiply', 'Wiply', 'manage_options', 'wiply_games', 'create_home', 'dashicons-games');
}

/** Step 3. */
function create_home()
{
    wiply_header();
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
   
    echo '<iframe src="https://platform.wiply.com" width="100%" style="height:80vh; border:1px solid black;">';
    echo '</div>';
}
