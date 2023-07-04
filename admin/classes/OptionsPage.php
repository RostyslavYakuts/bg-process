<?php

namespace BGP\Classes;


class OptionsPage {

    protected string $transient_key = 'bgp_12ej973h23g83y324f';

    protected $bgp_settings;
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private string $plugin_name;


	/**
	 * @since 1.0.0
	 * @access private
	 * @var string $plugin_slug
	 */
	private string $plugin_slug;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private string $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $plugin_slug The slug of plugin
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */

	public function __construct(string $plugin_name, string $plugin_slug, string $version ) {
		$this->plugin_name = $plugin_name;
		$this->plugin_slug = $plugin_slug;
		$this->version     = $version;
        add_action( 'admin_init', array( $this, 'create_display_type_settings' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		new Enqueuer( $this->version, $this->plugin_name );
        add_option('ContactFormCounter');
	}


	/**
	 *  Adding menu and submenu pages
	 */
	public function admin_menu(): void
    {
		add_menu_page(
			$this->plugin_slug,
			'BG-Process',
			'manage_options',
			$this->plugin_slug,
			array( $this, 'bgp_main_info' ),
			'dashicons-filter',
			1
		);
		add_submenu_page(
			$this->plugin_slug,
			'How to use',
			'How to use',
			'manage_options',
			'bgp-how-to-use',
			array( $this, 'bgp_how_to_use' )
		);
        add_submenu_page(
            $this->plugin_slug,
            'BGP Settings',
            'BGP Settings',
            'manage_options',
            'bgp-settings',
            array( $this, 'bgp_settings_page' )
        );
	}

    public function create_display_type_settings(): void
    {
        if( ! get_option('contact_form_counter') ){
            add_option('contact_form_counter',0);
        }

        register_setting( 'bgp_settings_section', 'bgp_emails', array( $this, 'bgp_settings_sanitize_callback' ) );
        add_settings_section( 'bgp_display_section', 'Add emails of receivers', array( $this, 'display_bgp_options' ), 'bgp-settings' );
        add_settings_field( 'bgp_emails', 'Display emails', array( $this, 'bgp_emails' ), 'bgp-settings', 'bgp_display_section' );
    }

    public function display_bgp_options(): void
    {
        $this->bgp_settings = get_option( 'bgp_emails' ) ?? '';
    }

    public function bgp_emails(): void
    {
        $count = get_option('contact_form_counter',0);
        $emails = $this->bgp_settings;
        ?>
        <label for="bgp_emails">Emails</label> <br>
        <input type="text" name="bgp_emails" id="bgp_emails" class="regular-text" value="<?php echo $emails ?>">
        <p class="description">Insert admin emails as comma separated text. We will send messages with count of contact form (<?php echo $count; ?>) submitting once a day</p>
        <?php
    }

	public function bgp_main_info(): void
    {
		echo '<div class="wrap">
		<div id="icon-options-general" class="icon32"><br></div>
		<h1 class="title-options-h1">Main info</h1></div>
		<h2>Abstract</h2>
		<p>This plugin is sending the short report about count of the success contact form 7 submits and emails sent.</p>';
	}

	public function bgp_how_to_use(): void
    {

		echo '<div class="wrap how-to-use-wrapper">
                <div id="icon-options-general" class="icon32"><br></div>
        <h1>How to use</h1>
        <p>After installing this plugin and filling in the option field email(s), first of all we need to create bash script that will just visit your site with following get params (it is important). For example:
        <code>
                #!/bin/bash<br>
      
        curl http://www.example.com?bgp=reset
        </code>
        Next - lets make the bash script executable - in terminal run
        <code>
        chmod +x your_script_name.sh
        </code>
        After this step lets make cron job on the server side. 
        <code>
            crontab -e        
        </code>
        After add this, for example to run bash every day et 3 AM
        <code>
        0 3 * * * /your/custom/path/to/bash/script.sh
        </code>
        Or the same it is easy to do using C-Panel tools
        So what we do - now we make executable bash script to run as cron job and visit our website using special get params.<br>
        When our plugin gets the GET query with this params plugin  will send email with report and counter of from submits will be equal 0 - for the next day collecting. 
        </p>
        <p><b>We are not using wp_cron feature in this plugin</b></p>
        
        </div>';
	}

    public function bgp_settings_sanitize_callback( $data ) {

        $transient_key = $this->transient_key;
        delete_transient( $transient_key );

        return $data;
    }


    public function bgp_settings_page(): void
    {
        ?>
        <div class="wrap" id="news_reviews">
            <?php settings_errors(); ?>
            <h1>BGP Settings</h1>
            <form method="post" action="options.php">
                <?php

                settings_fields( 'bgp_settings_section' );

                do_settings_sections( 'bgp-settings' );

                submit_button();

                ?>
            </form>
        </div>
        <?php
    }


}
