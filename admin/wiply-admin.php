<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wiply.com
 * @since      1.0.0
 *
 * @package    Wiply
 * @subpackage Wiply/includes
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wiply
 * @subpackage wiply/includes
 * @author     Omer Tal <omer@wiply.com>
 */
class Wiply_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $wiply    The ID of this plugin.
     */
    private $wiply;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $wiply       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($wiply, $version)
    {

        $this->wiply = $wiply;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in wiply_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The wiply_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->wiply, plugin_dir_url(__FILE__) . 'css/wiply-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in wiply_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The wiply_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->wiply, plugin_dir_url(__FILE__) . 'js/wiply-admin.js', array('jquery'), $this->version, false);
    }
}
