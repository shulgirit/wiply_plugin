<?php


/**
 * Front end registration
 */

/** Step 2 (from text above). */
add_action('admin_menu', 'my_plugin_menu');

/** Step 1. */
function my_plugin_menu()
{
    add_submenu_page('wiply_games', 'wiply_settings', 'Settings', 'manage_options', 'wiply_settings', 'my_plugin_options');
}

/** Step 3. */
function my_plugin_options()
{
    wiply_header();
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    echo '<div class="wrap">';
    echo '<div class="headline" style="display:flex;flex-direction: row;margin-bottom:5px;">';
   
    echo '<h1 style="place-self:center">Wiply sdfksdlfjsa;d Wordpress Plugin</h1></span>';
    echo '</div>';
    echo '</div>';
}
