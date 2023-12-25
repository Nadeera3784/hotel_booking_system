<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model{
    
    public function get_week_booking_report($date){
        $this->db->group_by(array('MONTH(booking_time)'));
        $this->db->where('DATE(booking_time)', $date);
        $this->db->select('COUNT(booking_id) as total');
        return  $this->db->get('bookings')->row();
    }

    public function get_year_booking_report($y,$m){
                $this->db->where('MONTH(booking_time)', $m);
               $this->db->where('YEAR(booking_time)', $y);
               $this->db->select('COUNT(booking_id) as total');
       return  $this->db->get('bookings')->row();
    }

    
    public function get_this_date_financial($date){
        $this->db->group_by(array('MONTH(booking_time)'));
        $this->db->where('DATE(booking_time)', $date);
        $this->db->where('payment_success', 1);
        $this->db->select('SUM(total_cost) as total');
        return  $this->db->get('bookings')->row();
    }

    public function get_this_year_financial($y,$m){
               $this->db->where('MONTH(P.booking_time)', $m);
               $this->db->where('YEAR(P.booking_time)', $y);
               $this->db->where('P.payment_success', 1);
               $this->db->select('SUM(P.total_cost) as total');
       return  $this->db->get('bookings P')->row();
   }

   public function get_payment_by_date($date){
        $this->db->group_by(array('MONTH(booking_time)'));
        $this->db->where('DATE(booking_time)',$date);
        $this->db->where('payment_success', 1);
        $this->db->select('SUM(total_cost) as total');
        return $this->db->get('bookings')->row();
    } 

}