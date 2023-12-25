<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Block {

    public $ci;
    public $checkInDate = '';
    public $checkOutDate = '';	
	public $mysqlCheckInDate = '';
    public $mysqlCheckOutDate = '';
	public $guestsPerRoom = 0;
	public $childPerRoom = 0;
	public $extrabedPerRoom = false;
	public $nightCount = 0;	
	public $fullDateRange;
	public $roomType = array();	
	public $multiCapacity = array();
	public $searchCode = "SUCCESS";
    
    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->library('config_manager');
        $this->set_request_params();
        $this->get_night_count();
        $this->check_search_engine();
        if($this->searchCode == "SUCCESS"){
            $this->load_multi_capacity();
            $this->load_room_types();
			$this->fullDateRange = $this->get_date_range_array($this->mysqlCheckInDate, $this->mysqlCheckOutDate);
            $this->set_my_session_vars();

        }

    }
    //Set POST params 
    private function set_request_params() {		
	    $tmpVar = isset($_POST['check_in'])? $_POST['check_in'] : NULL;
		$this->set_my_param_value($this->checkInDate, $tmpVar, NULL, true);
		$tmpVar = isset($_POST['check_out'])? $_POST['check_out'] : NULL; 
		$this->set_my_param_value($this->checkOutDate, $tmpVar, NULL, true); 
	    $tmpVar = isset($_POST['capacity'])? $_POST['capacity'] : 0;
		$this->set_my_param_value($this->guestsPerRoom, $tmpVar, 0, true); 
				
		$this->mysqlCheckInDate  = $this->ci->config_manager->get_mysql_date($this->checkInDate);   	  
		$this->mysqlCheckOutDate = $this->ci->config_manager->get_mysql_date($this->checkOutDate);	  			
    }
    //Check if params
    private function set_my_param_value(&$membervariable, $paramvalue, $defaultvalue, $required = false){
		if($required){
            if(!isset($paramvalue)){
                $this->invalid_request("set_param_value");
            }
        }

		if(isset($paramvalue)){
            $membervariable = $paramvalue;
        }else{
            $membervariable = $defaultvalue;
        }
    }
    //Set  $_SESSION and clear previous $_SESSION
    private function set_my_session_vars(){
		if(isset($_SESSION['sv_checkindate'])) unset($_SESSION['sv_checkindate']);
		if(isset($_SESSION['sv_checkoutdate'])) unset($_SESSION['sv_checkoutdate']);
		if(isset($_SESSION['sv_mcheckindate'])) unset($_SESSION['sv_mcheckindate']);
		if(isset($_SESSION['sv_mcheckoutdate'])) unset($_SESSION['sv_mcheckoutdate']);
		if(isset($_SESSION['sv_nightcount'])) unset($_SESSION['sv_nightcount']);
		if(isset($_SESSION['sv_guestperroom'])) unset($_SESSION['sv_guestperroom']);
		
	    $_SESSION['sv_checkindate']    = $this->checkInDate;
		$_SESSION['sv_checkoutdate']   = $this->checkOutDate;
		$_SESSION['sv_mcheckindate']   = $this->mysqlCheckInDate;
		$_SESSION['sv_mcheckoutdate']  = $this->mysqlCheckOutDate;
		$_SESSION['sv_nightcount']     = $this->nightCount;		
		$_SESSION['sv_guestperroom']   = $this->guestsPerRoom;		
		$_SESSION['svars_details']     = array();
    }
    //Set nightCount
    private function get_night_count() {		
		$checkin_date      = getdate(strtotime($this->mysqlCheckInDate));
		$checkout_date     = getdate(strtotime($this->mysqlCheckOutDate));
		$checkin_date_new  = mktime( 12, 0, 0, $checkin_date['mon'], $checkin_date['mday'], $checkin_date['year']);
		$checkout_date_new = mktime( 12, 0, 0, $checkout_date['mon'], $checkout_date['mday'], $checkout_date['year']);
		$this->nightCount  = round(abs($checkin_date_new - $checkout_date_new) / 86400);
    }
    //Get dates range between given two dates
    private function get_date_range_array($startDate, $endDate, $nightAdjustment = true) {	
		$date_arr = array(); 
		$day_array=array(); 
		$total_array=array();
	     $time_from = mktime(1,0,0,substr($startDate,5,2), substr($startDate,8,2),substr($startDate,0,4));
		 $time_to = mktime(1,0,0,substr($endDate,5,2), substr($endDate,8,2),substr($endDate,0,4));		
		if ($time_to >= $time_from) { 
			if($nightAdjustment){
				while ($time_from < $time_to) {      
					array_push($date_arr, date('Y-m-d',$time_from));
					array_push($day_array, date('D',$time_from));
					$time_from+= 86400; 
				}
			}else{
				while($time_from <= $time_to) {      
					array_push($date_arr, date('Y-m-d',$time_from));
					array_push($day_array, $time_from);
					$time_from+= 86400;
				}
			}			
		}  
		array_push($total_array, $date_arr);
		array_push($total_array, $day_array);
		return $total_array;		
    }
    //Check conf_booking_turn_off in database configuration
    private function check_search_engine(){
		if(intval($this->ci->config_manager->config['conf_booking_turn_off']) > 0){
			$this->searchCode = "SEARCH_ENGINE_TURN_OFF";
			return 0;
        }
        $query = $this->ci->db->query("SELECT DATEDIFF('".$this->mysqlCheckOutDate."', '".$this->mysqlCheckInDate."') AS INOUTDIFF");
        $diffrow = $query->row_array();
        $dateDiff = intval($diffrow['INOUTDIFF']);
        if($dateDiff < 0){
			$this->searchCode = "OUT_BEFORE_IN";
			return 0;
		}else if($dateDiff < intval($this->ci->config_manager->config['conf_min_night_booking'])){
			$this->searchCode = "NOT_MINNIMUM_NIGHT";
			return 0;
        }
		$userInputDate = strtotime($this->mysqlCheckInDate);
		$hotelDateTime = strtotime(date("Y-m-d"));
		$timezonediff =  ($userInputDate - $hotelDateTime);
		if($timezonediff < 0){
			$this->searchCode = "TIME_ZONE_MISMATCH";
			return 0;
		}
    }
    //Get all room types
	private function load_room_types() {	
        $query = $this->ci->db->query("SELECT * FROM app_roomtype");
        foreach ($query->result() as $currentrow){
			array_push($this->roomType, array('rtid'=>$currentrow->roomtype_ID, 'rtname'=>$currentrow->type_name));
        }
    }	
    //Get capacity based on $this->guestsPerRoom
    private function load_multi_capacity() {
        $query = $this->ci->db->query("SELECT * FROM app_capacity WHERE capacity >= ".$this->guestsPerRoom);
        foreach ($query->result() as $currentrow){
            $this->multiCapacity[$currentrow->id] = array('capval'=>$currentrow->capacity,'captitle'=>$currentrow->title);
        }
    }
    // Get available rooms
    public function get_available_rooms($roomTypeId, $roomTypeName, $capcityid){
        $currency_symbol = $this->ci->config_manager->get_default_currency_symbol();
        $searchresult = array('roomtypeid'=>$roomTypeId, 'roomtypename'=>$roomTypeName, 'capacityid'=>$capcityid, 'capacitytitle'=>$this->multiCapacity[$capcityid]['captitle'], 'capacity'=>$this->multiCapacity[$capcityid]['capval'], 'maxchild'=>$this->childPerRoom);
        $room_count = 0;
		$dropdown_html = '<option value="0" selected="selected">0</option>';
		$price_details_html = '';
		$total_price_amount = 0;
		$calculated_extraprice = 0;
        $extraSearchParam = "";
        $query = $this->ci->db->query(
        "SELECT rm.room_ID, rm.room_no 
        FROM app_room rm WHERE rm.roomtype_id = ".$roomTypeId."  AND rm.capacity_id = ".$capcityid."".$extraSearchParam."  AND rm.room_id NOT IN  (SELECT resv.room_id  FROM app_reservation resv, app_bookings boks  WHERE  boks.is_deleted = FALSE AND resv.bookings_id = boks.booking_id
		AND resv.room_type_id = ".$roomTypeId." AND (('".$this->mysqlCheckInDate."' BETWEEN boks.start_date AND DATE_SUB(boks.end_date, INTERVAL 1 DAY))
        OR (DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY) BETWEEN boks.start_date AND DATE_SUB(boks.end_date, INTERVAL 1 DAY)) OR (boks.start_date BETWEEN '".$this->mysqlCheckInDate."' AND DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY)) OR (DATE_SUB(boks.end_date, INTERVAL 1 DAY) BETWEEN '".$this->mysqlCheckInDate."' AND DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY))))");
        $tmpctr = 1;
        $searchresult['availablerooms'] = array();
        foreach ($query->result() as $currentrow){
			$dropdown_html.= '<option value="'.$tmpctr.'">'.$tmpctr.'</option>';
			array_push($searchresult['availablerooms'], array('roomid'=>$currentrow->room_ID, 'roomno'=>$currentrow->room_no));
			$tmpctr++;
        }

        if($tmpctr > 1){
            $totalDays = $this->get_date_range_array($this->mysqlCheckInDate, $this->mysqlCheckOutDate);	
			$totalamt3=0;
            $dayName=array_count_values($totalDays[1]);
			$_month = date('M',strtotime($this->mysqlCheckInDate));
			$month_ = date('M',strtotime($this->mysqlCheckOutDate));
			$_color = '#f2f2f2';
			$color_ = '#f2f2f2';
			if($_month == $month_){
				$mon = $_month;
			}else{
				$mon = $_month.' - '.$month_;
            }
            
            $price_details_html='<tr><td bgcolor='.$_color.'><b>'."MONTH".'</b></td>';
            foreach($dayName as $days => $totalnum){
               if($days == 'Sat' || $days == 'Sun'){
                    $price_details_html.='<td bgcolor='.$_color.'><b>'.$totalnum.' x '.strtoupper($days).'</b></td>';
                }else{
                   $price_details_html.='<td bgcolor='.$color_.'><b>'.$totalnum.' x '.strtoupper($days).'</b></td>';
               }
               $$days=0;
           }

           $price_details_html.='<td bgcolor='.$color_.' align="right"><b>'.$this->nightCount.' Night(s)</b></td></tr>';

           foreach($totalDays[0] as $date2 => $val){
               $query = $this->ci->db->query("SELECT * FROM app_priceplan WHERE roomtype_id = ".$roomTypeId." AND capacity_id = ".$capcityid." AND ('".$val."' BETWEEN start_date AND end_date)");
               if($query->num_rows()){
                  $row = $query->row_array();
               }else{
                 $query2 = $this->ci->db->query("SELECT * FROM app_priceplan WHERE roomtype_id = ".$roomTypeId." AND capacity_id = ".$capcityid." AND  default_plan=1");
                 $row = $query2->row_array();
               }
               $day = date('D',strtotime($val));
               $$day += $row[strtolower($day)];
           }

           $night_count_at_customprice = 0;	
           $searchresult['prices'] = array();	
           $price_details_html.='<tr>';	

           if($this->ci->config_manager->config['conf_tax_amount'] > 0 && $this->ci->config_manager->config['conf_price_with_tax']==1){ 
            $price_details_html.='<td bgcolor='.$_color.'>'.$mon.'</td>';
            foreach($dayName as $days => $totalnum){
                $pricewithtax=$$days+(($$days * $this->ci->config_manager->config['conf_tax_amount'])/100);
                if($days == 'Sat' || $days == 'Sun'){
                     $price_details_html.='<td bgcolor='.$_color.'>'.$currency_symbol.number_format($pricewithtax, 2 , '.', ',').'</td>';		
                }else{
                    $price_details_html.='<td bgcolor='.$color_.'>'.$currency_symbol.number_format($pricewithtax, 2 , '.', ',').'</td>';					
                } 	
                $totalamt3=$totalamt3+$pricewithtax;
            }
         }else{
            $price_details_html.='<td bgcolor='.$_color.'>'.$mon.'</td>';					
            foreach($dayName as $days => $totalnum){
               if($days == 'Sat' || $days == 'Sun'){						 
                     $price_details_html.='<td bgcolor='.$_color.'>'.$currency_symbol.number_format($$days, 2 , '.', ',').'</td>';			
               }else{ 
                    $price_details_html.='<td bgcolor='.$color_.'>'.$currency_symbol.number_format($$days, 2 , '.', ',').'</td>';						
               } 
               $totalamt3=$totalamt3+$$days;				 
            } 
         }

         $total_price_amount=$totalamt3;
         $price_details_html.='<td bgcolor='.$color_.' align="right">'.$currency_symbol.number_format($total_price_amount, 2 , '.', ',').'</td></tr>';

        }

        $searchresult['roomprice'] = $total_price_amount;				
		if($tmpctr > 1) array_push($_SESSION['svars_details'], $searchresult);
        unset($searchresult);
        
        return array(
            'roomcnt' => $tmpctr-1,		
            'roomdropdown' => $dropdown_html,
            'pricedetails' => $price_details_html,		
            'totalprice' => number_format($total_price_amount, 2 , '.', ',')
        ); 

    }
    // debug helper
    private function invalid_request($errocode = 9){
        //header('Location: booking-failure.php?error_code=9');
        echo "Blocking Class error".$errocode;
        //die;
    }
}