<?php

namespace BGP\Classes;

class ContactFormTracker
{

    public function handle(): void
    {
        if ( isset($_REQUEST['action']) || wp_verify_nonce( $_REQUEST['nonce'], 'contact_form_7_tracking' ) ) {
            $val = get_option( 'contact_form_counter', 0) + 1;
            update_option('contact_form_counter', $val);
            wp_send_json_success(['request'=>$_REQUEST,'post'=>$_POST,'get'=>$_GET,'option'=>get_option( 'contact_form_counter' )]);
        }else{
            wp_send_json( ['request'=>$_REQUEST,'option'=>get_option( 'contact_form_counter' )]);
        }

    }
}