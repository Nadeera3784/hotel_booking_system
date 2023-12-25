<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rest_model extends CI_Model{

    public function create_currency($currency_code, $currency_symbol, $exchange_rate, $default_currency){
        $data = array(
            'currency_code'  => $currency_code,
            'currency_symbl' => $currency_symbol,
            'exchange_rate'  => $exchange_rate,
            'default_c'      => $default_currency
          
      );
      $this->db->insert('currency', $data);
    }

    public function delete_currency($currency_id){
        $this->db->where('id', $currency_id);
		$this->db->delete('currency');
    }

    public function delete_special_offer($special_offer_id){
        $this->db->where('id', $special_offer_id);
		$this->db->delete('special_offer');
    }

    public function delete_room($roomtype_id, $capacity_id){
        $this->db->where('roomtype_id', $roomtype_id);
        $this->db->where('capacity_id', $capacity_id);
		$this->db->delete('room');
    }

    public function create_roomtype($form_data){
        $this->db->insert('roomtype', $form_data);
        $roomtype_id = $this->db->insert_id();
        $query = $this->db->get('capacity');
        if($query->num_rows()){
            foreach($query->result() as $row ){
                $this->db->query(
                    "INSERT INTO `app_priceplan` (`roomtype_id`, `capacity_id`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_plan`) 
                    VALUES (".$roomtype_id.", '".$row->id."', '0000-00-00', '0000-00-00', '0', '0', '0', '0', '0', '0', '0', '1')"
                    );
            }
            $this->db->query(
                "INSERT INTO `app_priceplan` (`roomtype_id`, `capacity_id`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_plan`) 
                VALUES (".$roomtype_id.", '1001', '0000-00-00', '0000-00-00', '0', '0', '0', '0', '0', '0', '0', '1')"
                );
        }

    }
       
    public function delete_roomtype($roomtype_id){
        $this->db->where('roomtype_ID', $roomtype_id);
        $this->db->delete('roomtype');

        $this->db->where('roomtype_id', $roomtype_id);
        $this->db->delete('room');

        $this->db->where('roomtype_id',  $roomtype_id);
        $this->db->delete('priceplan');

        $this->db->where('room_type',  $roomtype_id);
        $this->db->delete('special_offer');
    }

    public function create_capacity($form_data){
        $this->db->insert('capacity', $form_data);
        $capacity_id = $this->db->insert_id();
        $query = $this->db->query("SELECT start_date, end_date, roomtype_id, default_plan FROM app_priceplan GROUP BY start_date, end_date, roomtype_id");
        if($query->num_rows()){
            foreach($query->result() as $row ){
                $this->db->query(
                    "INSERT INTO `app_priceplan` (`roomtype_id`, `capacity_id`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_plan`)
                     VALUES (".$row->roomtype_id.", ".$capacity_id.", '".$row->start_date."', '".$row->end_date."', '0', '0', '0', '0', '0', '0', '0', '".$row->default_plan."')");
            }
        }else{
            $query2 = $this->db->get('capacity');
            if($query2->num_rows()){
                foreach($query2->result() as $row ){
                    $this->db->query(
                        "INSERT INTO `app_priceplan` (`roomtype_id`, `capacity_id`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_plan`)
                         VALUES (".$row->roomtype_ID.", '".$capacity_id."', '0000-00-00', '0000-00-00', '0', '0', '0', '0', '0', '0', '0', '1')");
                }
            }
        }
    }

    public function delete_capacity($capacity_id){
        $this->db->where('id', $capacity_id);
        $this->db->delete('capacity');

        $this->db->where('capacity_id', $capacity_id);
        $this->db->delete('room');

        $this->db->where('capacity_id', $capacity_id);
        $this->db->delete('priceplan');
    }

    public function get_capacity_roomtype_by_id($roomtype_id, $capacity_id){
        $this->db->where('roomtype_id', $roomtype_id);
        $this->db->where('capacity_id', $capacity_id);
        $query = $this->db->get('gallery');
        return $query->row_array();
    }

    public function get_image_by_id($pic_id){
        $this->db->limit(1);
        $this->db->select('img_path');
        $this->db->from('gallery');
        $this->db->where('pic_id', $pic_id);
        $query = $this->db->get(); 
        return $query->row(); 
    }

    public function update_image($picture_id, $picture_name){
        $data = array(
            'img_path' => $picture_name
        );
        $this->db->where('pic_id', $picture_id); 
        $this->db->update('gallery', $data);
    }

    public function delete_single_image($picture_id){
        $this->db->where('pic_id', $picture_id);
        $this->db->delete('gallery');
    }

    public function advance_payment_switcher($form_data){
        $this->db->where('conf_key', 'conf_enabled_deposit');
        $this->db->update('configure', $form_data);
    }

    public function get_calendar_events(){
        $query = $this->db->get('bookings');
        return $query->result(); 
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

    public function delete_room_booking($booking_id){
        $this->db->where('booking_id', $booking_id);
        $this->db->delete('bookings');
        $this->db->where('bookings_id', $booking_id);
        $this->db->delete('reservation');
        //$this->db->where('booking_id', $booking_id);
        //$this->db->delete('invoice');
    }

    public function cancel_room_booking($booking_id, $form_data){
        $this->db->where('booking_id', $booking_id);
        $this->db->update('bookings', $form_data);
    }
}