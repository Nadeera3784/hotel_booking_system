<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Availability calendar
class Api extends CI_Controller {

 public function get_available_calendar(){
    if($this->input->is_ajax_request()){
        $cid  = $this->input->post('capacity_id', TRUE);
        $rid = $this->input->post('roomtype_id', TRUE);

        $from_date = date("Y-m-d");
        $to_date   = date('Y-m-d', strtotime($from_date. ' + '.$this->config_manager->config['conf_maximum_global_years'].' days'));
        $total_dt  = $this->get_date_range_array($from_date,$to_date);
        $selected_dt = $this->get_date_range_array($_SESSION['sv_mcheckindate'],$_SESSION['sv_mcheckoutdate'],false);
        
        $jsonArray = array();
    
        foreach ($total_dt as $key => $value) {
            $query_booked = $this->db->query("SELECT 
            br.room_id FROM `app_bookings` AS bb 
            LEFT JOIN app_reservation AS br ON bb.`booking_id`=br.bookings_id
            JOIN app_room AS brm on br.room_id=  brm.room_ID 
            WHERE ('".$value."' between bb.`start_date` 
            AND DATE_SUB(bb.end_date, INTERVAL 1 DAY)) 
            AND br.room_type_id=".$rid." and bb.payment_success=1 and  is_deleted=0  and brm.capacity_id=".$cid);
    
            $query_total = $this->db->query("SELECT `room_ID` FROM `app_room` WHERE `roomtype_id`=".$rid." AND `capacity_id`=".$cid);
    
            $room_available = ($query_total->num_rows()-$query_booked->num_rows());
    
            $query_01 = $this->db->query("SELECT * FROM `app_priceplan` 
            WHERE ('".$value."' between  `start_date` AND `end_date`) 
            AND `roomtype_id`=".$rid." and `capacity_id`=".$cid."  and `default_plan`=0");
    
            $query_02 = $this->db->query("SELECT * FROM `app_priceplan` WHERE `roomtype_id`=".$rid." AND `capacity_id`=".$cid." AND `default_plan`=1");
    
            $a = strtolower(date('D', strtotime($value)));
    
            if($query_01->num_rows()){			
                $row1=$query_01->row_array();			
                $b=round($row1[$a],1);
            }else{
                $row2=$query_02->row_array();		   
                $b=round($row2[$a],1);
            }
            
            if($this->config_manager->config['conf_tax_amount'] > 0 && $this->config_manager->config['conf_price_with_tax']==1){
                $b=round($b+(($b*$this->config_manager->config['conf_tax_amount'])/100),1);
            }
    
            $query_sp = $this->db->query("SELECT * FROM app_special_offer WHERE '".$value."' between  `start_date` AND `end_date` AND (room_type=".$rid ." or room_type=0)");
    
            $row99 = $query_sp->row_array();
    
            if($query_sp->num_rows()){
                if (in_array($value, $selected_dt) &&  $_SESSION['sv_nightcount'] < $row99['min_stay']){
                    $b=$this->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->config_manager->get_exchange_money($b,$_SESSION['sv_currency']);
    
                }else{
                    $c=round($b - (($b*$row99['price_deduc'])/100),1);
                    $c=$this->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->config_manager->get_exchange_money($c,$_SESSION['sv_currency']);
                    $d=$this->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->config_manager->get_exchange_money($b,$_SESSION['sv_currency']);
                    $b=$d. "  " .$c;   
                }
            }else{
                $b=$this->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->config_manager->get_exchange_money($b,$_SESSION['sv_currency']);
            }
    
            if (in_array($value, $selected_dt)) {
                if($_SESSION['sv_mcheckindate']==$value){
                    $cellclass='cell_custom_available_checkin';
                    $cellcolor='#0fcf74';
                }elseif($_SESSION['sv_mcheckoutdate']==$value){
                    $cellclass='cell_custom_available_checkout';
                    $cellcolor='#0fcf74';
                }else{
                    $cellclass='cell_custom_available_1';
                    $cellcolor='#6d067c';
                }
    
                if($room_available <= 0){
                    $buildjson = array(
                            'id' => $key+1,
                            'title' => "$b", 
                            'start' => "$value", 
                            'className'=>"cell_custom"
                        );
    
                    $buildjson1 = array(
                            'id' => $key+1,
                            'title' => "Booked", 
                            'start' => "$value",
                            'backgroundColor'=>"#21202b", 
                            //'className'=> "$cellclass"
                            'className'=> "cell_custom_booked"
    
                        );
                    }else{
                    $buildjson = array(
                        'id' => $key+1, 'title' => "$b", 'start' => "$value", 'className'=>"cell_custom" 
                    );
                    $buildjson1 = array(
                        'id' => $key+1, 'title' => "Available($room_available)", 'start' => "$value",'backgroundColor'=>"$cellcolor", 'className'=>"$cellclass"
                    );
    
                }
            }else{
                if($room_available >= 1){
                    $buildjson = array('id' => $key+1, 'title' => "$b", 'start' => "$value", 'className'=>"cell_custom" );
                    $buildjson1 = array('id' => $key+1, 'title' => "Available($room_available)", 'start' => "$value",'backgroundColor'=>"#0fcf74", 'className'=>"cell_custom_available_1");
            
                }elseif($room_available <= 0 ){
                    $buildjson = array('id' => $key+1, 'title' => "$b", 'start' => "$value", 'className'=>"cell_custom" );
                     $buildjson1 = array('id' => $key+1, 'title' => "Booked", 'start' => "$value",'backgroundColor'=>"#e0061b", 'className'=>"cell_custom_booked");
    
                }            
            }
            
            array_push($jsonArray, $buildjson);
            array_push($jsonArray, $buildjson1);
    
        }
        header("Content-type: application/json");
        echo json_encode($jsonArray);
        
    }else{
        $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
        header("Content-type: application/json");	
        echo json_encode($response); 
    }
 }

 private function get_date_range_array($startDate, $endDate, $nightAdjustment = true) {	
    $date_arr = array(); 
     $time_from = mktime(1,0,0,substr($startDate,5,2), substr($startDate,8,2),substr($startDate,0,4));
     $time_to = mktime(1,0,0,substr($endDate,5,2), substr($endDate,8,2),substr($endDate,0,4));		
    if ($time_to >= $time_from) { 
        if($nightAdjustment){
            while ($time_from < $time_to) {      
                array_push($date_arr, date('Y-m-d',$time_from));
                $time_from+= 86400; // add 24 hours
            }
        }else{
            while($time_from <= $time_to) {      
                array_push($date_arr, date('Y-m-d',$time_from));
                $time_from+= 86400; // add 24 hours
            }
        }			
    }  
    return $date_arr;		
}

}
