<?php

namespace BGP\Classes;

class BGP
{
    public function reset_counter(): void
    {
        if (isset($_GET['bgp']) && $_GET['bgp'] === 'reset') {
            $current_counter = get_option('contact_form_counter');
            $this->send_report($current_counter);
            update_option('contact_form_counter', 0);
        }
    }

    private function send_report($counter_value): void
    {
        $current_site = get_bloginfo('name');
        $email_list = get_option('bgp_emails');
        if($email_list){
            $emailTo = $email_list;
            $subject = 'Count' .' from ' . $current_site;
            $body = "Count of mail sent: $counter_value";
            $headers = 'From: '.$current_site.' <'.$emailTo.'>' . 'rn' . 'Reply-To: ';
            $body    = wp_specialchars_decode( $body, ENT_QUOTES );
            $subject = wp_specialchars_decode( $subject, ENT_QUOTES );
            wp_mail($emailTo, $subject, $body, $headers);
        }
    }

}