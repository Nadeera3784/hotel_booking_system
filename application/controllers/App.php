<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('common');
		$this->load->library('mailer');
		//$this->common->clear_expired_bookings();
	}
	//Home page
	public function index(){
		$data['capacity'] = $this->Booking_model->get_capacity();
		$data['kids'] = $this->Booking_model->get_number_of_kids();
		$data['bodyclass'] = "";
		$this->load->view('header',  $data);
		$this->load->view('home', $data);
		$this->load->view('footer');
	}

	//Search details
	public function search(){
	    $data['bodyclass'] = "body-wrapper";
		$data['currency'] = $this->Booking_model->get_currency();
        $this->load->library('booking');
		$this->load->view('header', $data);
		$this->load->view('booking_details', $data);
		$this->load->view('footer');
	}

	//Payment page
	public function payment(){
	    $data['bodyclass'] = "body-wrapper";
		$this->load->view('header',  $data);
		$this->load->view('payment');
		$this->load->view('footer');
		
	}

	public function process_payment(){
		$this->load->library("payment");
		$this->session->set_userdata('bookingId', $this->payment->bookingId);
		switch($this->payment->paymentGatewayCode){
			case "offline":
			$this->offline_pay_method($this->payment->bookingId, $this->payment->clientEmail, $this->payment->clientName, $this->payment->invoiceHtml);
			break;

			case "paypal": 		
			$this->paypal_pay_method($this->payment->totalPaymentAmount);
			break;	
		}
	}

	public function payment_success(){
		if(isset($_POST['custom'])){
			$bookingId   =  $_POST['custom'];
			if($bookingId == $this->session->userdata('bookingId')){
				if($_POST['payment_status'] == "Completed"){
					$form_data['payment_success '] =  1;
				    $form_data['payment_txnid ']   =  $_POST['txn_id'];
				    $form_data['paypal_email ']    =  $_POST['payer_email'];
					$this->Booking_model->update_booking_payment($bookingId, $form_data);
					$customer_details =  $this->common->get_invoice_by_booking_id($bookingId);
					$mailSubject = "Booking has been canceled!!";
					$mailBody = "Dear ".$customer_details['client_name']."<br>";
					$mailBody .= "<b>Your Booking Details:</b><br>".$customer_details['invoice']."<br>";
					$mailBody .= "<br>". $this->config_manager->config['conf_hotel_name']. $this->config_manager->config['conf_hotel_phone'] . "<br>";
					$is_send = $this->mailer->send_app_mail($customer_details['client_email'], $mailSubject,  $mailBody);
					if($is_send){
						$notifyEmailSubject = "Booking no.".$bookingId." - Notification of Room Booking by ".$customer_details['client_name'];
						$this->mailer->send_app_mail($this->config_manager->config['conf_hotel_email'], $notifyEmailSubject,  $mailBody);	
					}
					$data['bodyclass'] = "body-wrapper";
				    $this->load->view('header',  $data);
				    $this->load->view('payment_success');
					$this->load->view('footer');
				}else{
					redirect('app/payment_cancel', 'refresh');
				}
			}
		}else{
		    $data['bodyclass'] = "body-wrapper";
			$this->load->view('header',  $data);
			$this->load->view('payment_success');
			$this->load->view('footer');
		}
	}

	public function payment_cancel(){
	    $data['bodyclass'] = "body-wrapper";
		$this->session->sess_destroy();
		$this->load->view('header');
		$this->load->view('payment_cancel');
		$this->load->view('footer');
	}

	public function offline_pay_method($booking_id, $clientEmail, $clientName, $invoiceHtml){
		if($this->Booking_model->get_verified_booking_id($booking_id)){
			$form_data['payment_success']  = 1;
			$this->Booking_model->update_booking_status($booking_id, $form_data);
			$form_data2['existing_client']  = 1;
			$this->Booking_model->update_existing_client_email($clientEmail, $form_data2);
			$subject  = "Booking is confirmed";
			$mailBody = "Dear ".$clientName."<br>";
			$mailBody .= $invoiceHtml;
			$mailBody .= "<br>". $this->config_manager->config['conf_hotel_name']. $this->config_manager->config['conf_hotel_phone'] . "<br>";
			$is_send  = $this->mailer->send_app_mail($clientEmail, $subject,  $mailBody);
			if($is_send){
				$notifyEmailSubject = "Booking no.".$booking_id." - Notification of Room Booking by ".$clientName;
				$this->mailer->send_app_mail($this->config_manager->config['conf_hotel_email'], $notifyEmailSubject,  $mailBody);		
			}
			redirect('app/payment_success', 'refresh');
		}else{
			redirect('app/payment_cancel', 'refresh');
		}
	}

	public function paypal_pay_method($totalamout){
		$paypal_settings = $this->Booking_model->get_paypal_mail();
		$this->load->library('paypal');
		$this->paypal->add_field('rm', 2);
		$this->paypal->add_field('cmd', '_xclick');
		$this->paypal->add_field('business',  $paypal_settings['account']);
		$this->paypal->add_field('item_name',  $this->config_manager->config['conf_hotel_name']);
		$this->paypal->add_field('amount',  $totalamout);
		$this->paypal->add_field('currency_code',  $this->config_manager->get_currency_code());
		$this->paypal->add_field('custom', $this->session->userdata('bookingId'));

		$this->paypal->add_field('notify_url', base_url().'app/paypal_ipn');
		$this->paypal->add_field('cancel_return', base_url().'app/payment_cancel');
		$this->paypal->add_field('return', base_url().'app/payment_success');
		
		$this->paypal->submit_paypal_post();
	}

	public function paypal_ipn(){
		$this->load->library('paypal');
		if ($this->paypal->validate_ipn() == true) {
			$bookingId   =  $_POST['custom'];
			if($bookingId == $this->session->userdata('bookingId')){
				if($this->paypal->ipn_data['payment_status'] == "Completed"){
					$form_data['payment_success '] =  1;
					$form_data['payment_txnid ']   =  $_POST['txn_id'];
					$form_data['paypal_email ']    =  $_POST['payer_email'];
					$this->Booking_model->update_booking_payment($bookingId, $form_data);
				}
			}
		}
		
	}

}
