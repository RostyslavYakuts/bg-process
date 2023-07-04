<?php
/**
 * Plugin Name: BG-Process - Test Non commercial  plugin for WebbyLab company
 * Plugin URI: PLUGIN SITE HERE
 * Description: Test task for WebbyLab
 * Author: Rostyslav Yakuts
 * Author URI: https://
 * Text Domain: bgp
 * Domain Path: /languages
 * Version: 1.0.0
 *
 * @package bgp
 */
if (!defined('WPINC')) {
    die;
}


require_once __DIR__ . '/vendor/autoload.php';

if (BGP\Classes\Helper::plugin_is_active('contact-form-7/wp-contact-form-7.php')) {


    new \BGP\Classes\OptionsPage('BG-Process', 'bg-process', '1.0.0');
    /**
     * Ajax solution for contact form
     */
    add_action('wp_ajax_contact_form_7_tracking', 'contact_form_7_tracking_handler');
    add_action('wp_ajax_nopriv_contact_form_7_tracking', 'contact_form_7_tracking_handler');
    add_action('init', 'reset_contact_form_counter_option');

} else {
    add_action('admin_notices', 'BGP\Classes\ErrorReporter::report_missing_contact_form_plugin');
}

function contact_form_7_tracking_handler(): void
{
    $tracker = new \BGP\Classes\ContactFormTracker;
    $tracker->handle();
}

function reset_contact_form_counter_option(): void
{
    $bgp = new \BGP\Classes\BGP();
    $bgp->reset_counter();
}
