<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class  Common {

public $ci;

public function __construct(){
    $this->ci = &get_instance();
    $this->ci->load->library('config_manager');
}
//Get blocked rooms details
public function get_block_room_details(){
    $getHtml='<tbody>';
    $query = $this->ci->db->query("SELECT booking_id,block_name,DATE_FORMAT(start_date, '".$this->ci->config_manager->user_date_format."') AS StartDate, DATE_FORMAT(end_date, '".$this->ci->config_manager->user_date_format."') AS EndDate FROM app_bookings WHERE payment_success='1' AND is_block='1'");
    if($query->num_rows()){
        foreach($query->result() as $row){
            $query2 = $this->ci->db->query("SELECT `room_type_id`, count(*) AS total_room, br.capacity_id FROM app_reservation rs, app_room br WHERE  rs.`bookings_id`='".$row->booking_id."' AND rs.`room_id`=br.room_ID group by rs.`room_type_id`,br.capacity_id");
            foreach($query2->result() as $row2){
                $query3 = $this->ci->db->query("SELECT title FROM app_capacity WHERE id='".$row2->capacity_id."'");
                $cap_title = $query3->row_array();
                $query4 = $this->ci->db->query("SELECT type_name FROM app_roomtype WHERE roomtype_ID='".$row2->room_type_id."'");
                $type_title = $query4->row_array();
                $getHtml.='<tr><td>'.$row->block_name.'</td><td>'.$row->StartDate."  <i class='ti ti-arrow-right'></i>  ".$row->EndDate.'</td><td>'.$type_title['type_name']."(".$cap_title['title'].')</td><td>'.$row2->total_room.'</td><td><a class="btn btn-sm btn-default" href="javascript:;" id="unblock" data-bid="'.$row->booking_id.'" data-rti="'.$row2->room_type_id.'" data-cid="'.$row2->capacity_id.'">'."Un-block".'</a></td></tr>'; 
            }
        }
    }
    $getHtml .= '<tbody>';
    return $getHtml;
}
//Get client data by client_id
public function get_client_by_id($client_id){
    $this->ci->db->where('client_id', $client_id);
    $query = $this->ci->db->get('clients'); 
    return $query->row_array();
}

//clear expired booking  app_invoice/app_reservation/app_bookings
public function clear_expired_bookings(){
    $query = $this->ci->db->query("SELECT booking_id FROM app_bookings WHERE payment_success = false AND ((NOW() - booking_time) > ".intval($this->ci->config_manager->config['conf_booking_exptime'])." )");
    foreach($query->result() as $currentRow){
        $this->ci->db->query("DELETE FROM app_invoice WHERE booking_id = '".$currentRow->booking_id."'");
        $this->ci->db->query("DELETE FROM app_reservation WHERE bookings_id = '".$currentRow->booking_id."'");
        $this->ci->db->query("DELETE FROM app_bookings WHERE booking_id = '".$currentRow->booking_id."'");
    }	
}

public function get_invoice_by_booking_id($booking_id){
    $this->ci->db->where('booking_id', $booking_id);
    $query = $this->ci->db->get('invoice'); 
    return $query->row_array();
}

}