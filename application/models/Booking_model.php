<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model{

    public function get_capacity(){
        $query = $this->db->query('SELECT Max(capacity) as capa FROM app_capacity WHERE `id` IN (SELECT DISTINCT (capacity_id) FROM app_room) ORDER BY capacity');
        return $query->result();
    }

    public function get_number_of_kids(){
        $this->db->select_max('no_of_child');
        $query = $this->db->get('room');
        foreach ($query->result() as $q){
            if($q->no_of_child > 0){
               return $q->no_of_child;
            }else{
               return false;
            }
        }
    }

    public function get_currency(){
        $this->db->select('currency_symbl,currency_code');
        $this->db->where('default_c', 1);
        $query = $this->db->get('currency');
        return  $query->row();
    }

    public function get_currency_symbol($code){
        $this->db->where('currency_code',  $code);
        $query = $this->db->get('currency');
        return  $query->row_array();
    }

    public function update_booking_status($booking_id, $form_data){
        $this->db->where('booking_id', $booking_id); 
        $this->db->update('bookings', $form_data);
    }

    public function update_existing_client_email($client_email, $form_data){
        $this->db->where('email', $client_email); 
        $this->db->update('clients', $form_data);
    }
    
    public function get_verified_booking_id($booking_id){
        $this->db->where('booking_id', $booking_id);
        $result = $this->db->get('bookings');
        if($result->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function get_paypal_mail(){
        $this->db->where('gateway_code', 'paypal');
        $query = $this->db->get('payment_gateway');
        return  $query->row_array();
    }

    public function update_booking_payment($booking_id, $form_data){
        $this->db->where('booking_id', $booking_id); 
        $this->db->update('bookings', $form_data);
    }

}