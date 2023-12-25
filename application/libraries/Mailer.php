<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailer{

    public function send_app_mail($to, $subject, $message) {
        $email_config = Array('charset' => 'utf-8','mailtype' => 'html');
        $Cm = get_instance();
        $Cm->load->library('email', $email_config);
        $Cm->load->library('config_manager');
        $Cm->email->clear(true); //clear previous message and attachment
        $Cm->email->set_newline("\r\n");
        $Cm->email->from($Cm->config_manager->config['conf_hotel_email'], $Cm->config_manager->config['conf_hotel_name']);
        $Cm->email->to($to);
        $Cm->email->subject($subject);
        $Cm->email->message($message);

        //send email
        if ($Cm->email->send() === TRUE) {
            return true;
        } else {
            //show error message in none production version
            if (ENVIRONMENT !== 'production') {
                show_error($Cm->email->print_debugger());
            }
            return false;
        }
    }
}