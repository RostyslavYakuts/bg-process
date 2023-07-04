<?php

namespace BGP\Classes;

class Enqueuer
{

    public string $version;
    public string $name;

    public function __construct(string $version, string $name)
    {
        $this->version = $version;
        $this->name = $name;
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 0);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'), 0);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_front_end_scripts'), 0);
        add_action('wp_enqueue_scripts', array($this, 'localize_custom_script'), 0);
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */


    public function enqueue_styles(): void
    {

        wp_enqueue_style($this->name, plugin_dir_url(__FILE__) . '../assets/css/bgp.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */


    public function enqueue_scripts(): void
    {

        wp_enqueue_script($this->name, plugin_dir_url(__FILE__) . '../assets/js/bgp.js', array('jquery'), $this->version, false);

    }

    public function enqueue_front_end_scripts(): void
    {

        wp_enqueue_script($this->name, plugin_dir_url(__FILE__) . '../../frontend/assets/js/bgp-fe.js', array(), $this->version, true);

    }

    /**
     * Localize custom data for ajax
     * @since 1.0.0
     */
    public function localize_custom_script(): void
    {

        wp_localize_script($this->name, 'bgpLocalizedScript', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'action' => 'contact_form_7_tracking',
                'nonce' => wp_create_nonce('contact_form_7_tracking')
            )
        );
    }


}