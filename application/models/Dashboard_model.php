<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model{

    public function get_today_checkin_list($date){
        $query = $this->db->query(
            "SELECT booking_id, DATE_FORMAT(start_date, '".$date."') AS start_date, DATE_FORMAT(end_date, '".$date."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$date."') AS booking_time, payment_type, client_id  
             FROM app_bookings WHERE payment_success=true AND is_block=false AND is_deleted=0   AND DATE_FORMAT(start_date, '%Y-%m-%d')=CURDATE()");
        return $query->result();   
    }

    public function get_today_checkout_list($date){
        $query = $this->db->query(
            "SELECT booking_id, DATE_FORMAT(start_date, '".$date."') AS start_date, DATE_FORMAT(end_date, '".$date."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$date."') AS booking_time, payment_type, client_id  
            FROM app_bookings WHERE payment_success=true AND is_block=false AND is_deleted=0   AND  DATE_FORMAT(end_date, '%Y-%m-%d')=CURDATE()");
        return $query->result();
    }

    public function get_global_settings(){
        $query = $this->db->get('configure');
        return $query->result_array();
    }

    public function get_currency(){
        $query = $this->db->get('currency');
        return $query->result_array();
    }

    public function get_currency_by_id($currency_id){
        $this->db->where('id', $currency_id);
        $query = $this->db->get('currency');
        return $query->row(); 
    }

    public function update_currency($currency_code, $currency_symbol, $exchange_rate, $default_currency, $currency_id){
        $data = array(
            'currency_code'  => $currency_code,
            'currency_symbl' => $currency_symbol,
            'exchange_rate'  =>  $exchange_rate,
            'default_c'      => $default_currency
        );
        $this->db->where('id', $currency_id); 
        $this->db->update('currency', $data);
    }

    public function update_global_settings($key, $value){
        $data = array(
            'conf_value' => $value
        );
        $this->db->where('conf_key', $key); 
        $this->db->update('configure', $data);
    }
    
    public function get_roomtype(){
        $query = $this->db->get('roomtype');
        return $query->result();
    }

    public function update_roomtype($form_data, $roomtype_id){
        $this->db->where('roomtype_ID', $roomtype_id); 
        $this->db->update('roomtype', $form_data);
    }
    
    public function get_room_type_by_id($room_type_id){
        $this->db->where('roomtype_ID', $room_type_id);
        $query = $this->db->get('roomtype'); 
        return $query->row_array();
    }

    public function get_capacity_title_by_id($capacity_id){
        $this->db->where('id', $capacity_id);
        $query = $this->db->get('capacity'); 
        $capacity_title = $query->row_array();
        return $capacity_title['title'];
    }

    public function get_capacity_by_id($capacity_id){
        $this->db->where('id', $capacity_id);
        $query = $this->db->get('capacity'); 
        return $query->row_array();
    }

    public function get_capacity(){
        $query = $this->db->get('capacity');
        return $query->result();
    }

    public function update_capacity($form_data, $capacity_id){
        $this->db->where('id', $capacity_id); 
        $this->db->update('capacity', $form_data);
    }

    public function update_price_plan($sun, $mon, $tue, $wed, $thu, $fri, $sat, $plan_id){
        $data = array(
            'sun' => $sun,
            'mon' => $mon,
            'tue' => $tue,
            'wed' => $wed,
            'thu' => $thu,
            'fri' => $fri,
            'sat' => $sat
        );
        $this->db->where('plan_id', $plan_id); 
        $this->db->update('priceplan', $data);
    }
    
    public function get_special_offer($user_date_format){
        $query = $this->db->query("SELECT id, offer_title, date_format(start_date,'".$user_date_format."') as start_date,date_format(end_date,'".$user_date_format."')as end_date,room_type,price_deduc,min_stay from app_special_offer");
        return $query->result();
    }

    public function create_special_offer($form_data){
        $this->db->insert('special_offer', $form_data);
        return $this->db->insert_id();
    }

    public function update_special_offer($special_offer_id, $form_data){
        $this->db->where('id', $special_offer_id); 
        $this->db->update('special_offer',$form_data);
        return $this->db->insert_id();
    }

    public function get_verified_offer_id($offer_id){
        $this->db->where('id', $offer_id);
        $result = $this->db->get('special_offer');
        if($result->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function get_verified_payment_method_id($method_id){
        $this->db->where('id', $method_id);
        $result = $this->db->get('payment_gateway');
        if($result->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function get_verified_roomtype_id($roomtype_id){
        $this->db->where('roomtype_ID', $roomtype_id);
        $result = $this->db->get('roomtype');
        if($result->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function get_verified_capacity_id($capacity_id){
        $this->db->where('id', $capacity_id);
        $result = $this->db->get('capacity');
        if($result->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function get_special_offer_by_id($user_date_format, $id){
        $query = $this->db->query("SELECT offer_title,room_type,id,date_format(start_date,'".$user_date_format."') AS start_date,date_format(end_date,'".$user_date_format."')AS end_date,room_type,price_deduc,min_stay FROM app_special_offer WHERE id='$id' ORDER BY id desc");
        return $query->row();
    }

    public function set_logger($type, $description){
        $data = array(
            'type' => $type,
            'description' => $description,
        );
        $this->db->insert('logs', $data);
    }
    
    public function get_advance_payment(){
        $query = $this->db->get('advance_payment'); 
        return $query->result();
    }

    public function get_rooms(){
        $this->db->select("room.roomtype_id,room.no_of_child,room.capacity_id");
        $this->db->from('room');
        $this->db->join('roomtype', 'roomtype.roomtype_ID=room.roomtype_id','inner');
        $this->db->join('capacity', 'capacity.id=room.capacity_id','inner');
        $this->db->where('room.roomtype_id', "roomtype.roomtype_ID");
        $this->db->where('room.capacity_id', "capacity.id");
        $this->db->group_by('room.roomtype_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function update_rooms_with_capacity($form_data){
        $this->db->insert('room', $form_data);
        $room_id = $this->db->insert_id();
        $data = array(
            'room_no' => $room_id
        );
        $this->db->where('room_ID', $room_id); 
        $this->db->update('room',$data);
    }

    public function update_rooms_with_child($form_data, $child_per_room){
        $this->db->insert('room', $form_data);
        $room_id = $this->db->insert_id();
        $data = array(
            'room_no' => $room_id,
            'no_of_child' =>  $child_per_room
        );
        $this->db->where('room_ID', $room_id); 
        $this->db->update('room',$data);
    }

    public function create_gallery($form_data){
        $this->db->insert('gallery', $form_data);
        return $this->db->insert_id();
    }

    public function get_clients(){
        $query = $this->db->get('clients');
        return $query->result();
    }

    public function get_client_by_id($client_id){
        $this->db->where('client_id', $client_id); 
        $query = $this->db->get('clients');
        return $query->row_array();
    }

    public function get_payment_getways(){
        $query = $this->db->get('payment_gateway');
        return $query->result();
    }

    public function get_todays_revenue(){
        $this->db->where('DATE(booking_time)',date('Y-m-d'));
        $this->db->where('payment_success', 1);
		$this->db->select_sum('total_cost');
		return $this->db->get('bookings')->row();
    }

    public function get_total_rooms(){
        $this->db->select_sum('capacity');
		return $this->db->get('capacity')->row();
    }

    public function get_total_guest(){
        $query = $this->db->query('SELECT COUNT(client_id) as numc FROM `app_clients`');
        return $query->row();   
    }

}