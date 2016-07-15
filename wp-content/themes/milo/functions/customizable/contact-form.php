<?php
if( !function_exists('ff_contact_form_send_ajax') ) {

    ffContainer()->getWPLayer()->getHookManager()->addAjaxRequestOwner('contactform-send-ajax', 'ff_contact_form_send_ajax');

    function ff_contact_form_send_ajax(  ffAjaxRequest $ajaxRequest ) {

        $data = $ajaxRequest->data;
        $formSerialize = $data['formInput'];


        $output = array();
        parse_str( $formSerialize, $output);



        $contactInfo = $data['contactInfo'];

        $contactInfoDecoded = ffContainer::getInstance()->getCiphers()->freshfaceCipher_decode( $contactInfo );
        $contactInfoParsed = json_decode($contactInfoDecoded);

        $message = '';
        $message .= 'Name: '.esc_attr($output['name']) ."\n";
        $message .= 'Email: '.esc_attr($output['email']) ."\n";
        $message .= 'Subject: '.esc_attr($contactInfoParsed->subject) ."\n";
        $message .= "\n";
        $message .= 'Message: '.esc_attr($output['message']) ."\n";

        if( !empty( $contactInfoParsed->email ) ) {
            $result = wp_mail( $contactInfoParsed->email, $contactInfoParsed->subject, $message );

            if( $result == false ) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }
}