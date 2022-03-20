<?php
/*
Plugin Name: Wiply Gamification for Wordpress
Plugin URI:
Description: Integration between Wiply Platform and Woocommerce Websites
Version: 1.0.0
Author: OmerTal
Author URI:
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WIPLY_VERSION', '1.0.0');


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_wiply()
{
    require_once plugin_dir_path(__FILE__) . 'includes/wiply-activator.php';
    Wiply_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_wiply()
{
    require_once plugin_dir_path(__FILE__) . 'includes/wiply-deactivator.php';
    Wiply_Deactivator::deactivate();
}


register_activation_hook(__FILE__, 'activate_wiply');
register_deactivation_hook(__FILE__, 'deactivate_wiply');


function wiply_header()
{
    echo '<div class="wrap">';
    echo '<div class="headline" style="display:flex;flex-direction: row;margin-bottom:5px;place-content: center;">';
    echo '<img src="https://res.cloudinary.com/shulgirit/image/upload/v1638876959/wiply/W3-01_dcdvuk.png" width="150" />';
    echo '<h1 style="place-self:center">Wiply Gamification Wordpress Plugin</h1></span>';
    echo '</div>';
}


require("includes/wiply_home.php");
require("includes/settings.php");

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/wiply-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wiply()
{

    $wiply = new Wiply_Plugin();
    $wiply->run();
}
run_wiply();
/**
 * Create a coupon programatically
 */
function add_coupon($coupon_code, $amount, $user_email)
{
    $coupon_code_sample = 'UNIQUECODE'; // Code
    $amount = '10'; // Amount
    $discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product

    $coupon = array(
        'post_title' => $coupon_code,
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'shop_coupon'
    );

    $new_coupon_id = wp_insert_post($coupon);

    // Add meta
    update_post_meta($new_coupon_id, 'discount_type', $discount_type);
    update_post_meta($new_coupon_id, 'coupon_amount', $amount);
    update_post_meta($new_coupon_id, 'individual_use', 'no');
    update_post_meta($new_coupon_id, 'product_ids', '');
    update_post_meta($new_coupon_id, 'exclude_product_ids', '');
    update_post_meta($new_coupon_id, 'usage_limit', '');
    update_post_meta($new_coupon_id, 'expiry_date', '');
    update_post_meta($new_coupon_id, 'apply_before_tax', 'yes');
    update_post_meta($new_coupon_id, 'free_shipping', 'no');
}

function myCodes()
{
    return array(
        "investor1" => "111111",
        "investor2" => "222222",
        "investor3" => "333333",
    );
}

add_action('register_form', 'crf_registration_form');
function crf_registration_form()
{

    $referral_code = !empty($_POST['referral_code']) ? ($_POST['referral_code']) : '';

?>
    <p>
        <label style="display: block" for="referral_code"><?php esc_html_e('Referral Code', 'crf') ?> <br />
            <input type="text" id="referral_code" name="referral_code" value="<?php echo esc_attr($referral_code); ?>" class="input" />
        </label>
    </p>
<?php
}

add_filter('registration_errors', 'crf_registration_errors', 10, 3);
function crf_registration_errors($errors, $sanitized_user_login, $user_email)
{


    if (in_array($_POST['referral_code'], myCodes())) {
        $isReferral = true;
    } else {
        $isReferral = false;
    }

    if (empty($_POST['referral_code'])) {
        $errors->add('referral_code_error', __('<strong>Error</strong>: Please enter correct referral code.', 'crf'));
    }

    if (!empty($_POST['referral_code']) && (($isReferral)) === false) {
        $errors->add('referral_code_error', __('<strong>Error</strong>: Referral code Does Not Exist.', 'crf'));
    }

    return $errors;
}

add_action('user_register', 'crf_user_register');
function crf_user_register($user_id)
{
    if (!empty($_POST['referral_code'])) {
        update_user_meta($user_id, 'referral_code', ($_POST['referral_code']));
    }
}

/**
 * Back end registration
 */

add_action('user_new_form', 'crf_admin_registration_form');
function crf_admin_registration_form($operation)
{
    if ('add-new-user' !== $operation) {
        // $operation may also be 'add-existing-user'
        return;
    }

    $referral_code = !empty($_POST['referral_code']) ? ($_POST['referral_code']) : '';

?>
    <h3><?php esc_html_e('Personal Information', 'crf'); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="referral_code"><?php esc_html_e('Referral Code', 'crf'); ?></label> <span class="description"><?php esc_html_e('(required)', 'crf'); ?></span></th>
            <td>
                <input type="text" id="referral_code" name="referral_code" value="<?php echo esc_attr($referral_code); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
<?php
}

add_action('user_profile_update_errors', 'crf_user_profile_update_errors', 10, 3);
function crf_user_profile_update_errors($errors, $update, $user)
{

    if (in_array($_POST['referral_code'], myCodes())) {
        $isReferral = true;
    } else {
        $isReferral = false;
    }

    if ($update) {
        return;
    }

    if (empty($_POST['referral_code'])) {
        $errors->add('referral_code_error', __('<strong>Error</strong>: Please enter correct referral code.', 'crf'));
    }

    if (!empty($_POST['referral_code']) && ($_POST['referral_code']) != $isReferral) {
        $errors->add('referral_code_error', __('<strong>Error</strong>: Referral code Does Not Exist.', 'crf'));
    }
}

add_action('edit_user_created_user', 'crf_user_register');


/**
 * Back end display
 */

add_action('show_user_profile', 'crf_show_extra_profile_fields');
add_action('edit_user_profile', 'crf_show_extra_profile_fields');

function crf_show_extra_profile_fields($user)
{
?>
    <h3><?php esc_html_e('Personal Information', 'crf'); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="referral_code"><?php esc_html_e('Referral Code', 'crf'); ?></label></th>
            <td><?php echo esc_html(get_the_author_meta('referral_code', $user->ID)); ?></td>
        </tr>
    </table>
<?php
}
