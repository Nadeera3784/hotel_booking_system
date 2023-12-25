<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking {

    public $ci;
	public $checkInDate = '';
    public $checkOutDate = '';	
	public $mysqlCheckInDate = '';
    public $mysqlCheckOutDate = '';
	public $currency = '';
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
    //Set $_POST params
    private function set_request_params(){

        $tmpVar = isset($_POST['check_in']) ? $_POST['check_in'] : is_session_exist('sv_checkindate', @$_SESSION['sv_checkindate']);
        $this->set_my_param_value($this->checkInDate, $tmpVar, NULL, true);
        
        $tmpVar = isset($_POST['check_out']) ? $_POST['check_out'] : @$_SESSION['sv_checkoutdate']; 
        $this->set_my_param_value($this->checkOutDate, $tmpVar, NULL, true); 
    
	    $tmpVar = isset($_POST['capacity']) ? $_POST['capacity'] : $_SESSION['sv_guestperroom'];
		$this->set_my_param_value($this->guestsPerRoom, $tmpVar , 0, true); 
		
		$tmpVar = isset($_POST['child_per_room']) ? $_POST['child_per_room'] : $_SESSION['sv_childcount'] ;
		$this->set_my_param_value($this->childPerRoom, $tmpVar, 0, true);
		
		$tmpVar = isset($_REQUEST['currency']) ? $_REQUEST['currency'] : $_SESSION['sv_currency'] ;
		$this->set_my_param_value($this->currency, $tmpVar, 0, true);
				
        $this->mysqlCheckInDate =  $this->ci->config_manager->get_mysql_date($this->checkInDate);   	  
        $this->mysqlCheckOutDate = $this->ci->config_manager->get_mysql_date($this->checkOutDate);  
    }
    //Check params
    private function set_my_param_value(&$membervariable, $paramvalue, $defaultvalue, $required = false){
		if($required){
            if(!isset($paramvalue)){
                $this->invalid_request();
            }
        }
		if(isset($paramvalue)){  $membervariable = $paramvalue;}else{$membervariable = $defaultvalue;}
    }
    // Set $_SESSION variables and clear previous $_SESSION
    private function set_my_session_vars(){
        if(isset($_SESSION['sv_checkindate'])) unset($_SESSION['sv_checkindate']);
		if(isset($_SESSION['sv_checkoutdate'])) unset($_SESSION['sv_checkoutdate']);
		if(isset($_SESSION['sv_mcheckindate'])) unset($_SESSION['sv_mcheckindate']);
		if(isset($_SESSION['sv_mcheckoutdate'])) unset($_SESSION['sv_mcheckoutdate']);
		if(isset($_SESSION['sv_nightcount'])) unset($_SESSION['sv_nightcount']);
		if(isset($_SESSION['sv_guestperroom'])) unset($_SESSION['sv_guestperroom']);
		if(isset($_SESSION['sv_childcount'])) unset($_SESSION['sv_childcount']);
		if(isset($_SESSION['sv_currency'])) unset($_SESSION['sv_currency']);
		
	    $_SESSION['sv_checkindate'] = $this->checkInDate;
		$_SESSION['sv_checkoutdate'] = $this->checkOutDate;
		$_SESSION['sv_mcheckindate'] = $this->mysqlCheckInDate;
		$_SESSION['sv_mcheckoutdate'] = $this->mysqlCheckOutDate;
		$_SESSION['sv_nightcount'] = $this->nightCount;		
		$_SESSION['sv_guestperroom'] = $this->guestsPerRoom;		
		$_SESSION['sv_childcount'] = $this->childPerRoom;	
		$_SESSION['sv_currency'] = $this->currency;	
        $_SESSION['svars_details'] = array();
    }
    //Check conf_booking_turn_off in database configuration
    private function check_search_engine(){
		if(intval($this->ci->config_manager->config['conf_booking_turn_off']) > 0){
			$this->searchCode = "SEARCH_ENGINE_TURN_OFF";
			return 0;
        }
        $query = $this->ci->db->query("SELECT DATEDIFF('".$this->mysqlCheckOutDate."', '".$this->mysqlCheckInDate."') AS INOUTDIFF");
        $diffrow = $query->row();
        $dateDiff = intval($diffrow->INOUTDIFF);
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
    //Set nightCount
    private function get_night_count() {
        $checkin_date = getdate(strtotime($this->mysqlCheckInDate));
		$checkout_date = getdate(strtotime($this->mysqlCheckOutDate));
		$checkin_date_new = mktime( 12, 0, 0, $checkin_date['mon'], $checkin_date['mday'], $checkin_date['year']);
		$checkout_date_new = mktime( 12, 0, 0, $checkout_date['mon'], $checkout_date['mday'], $checkout_date['year']);
		$this->nightCount = round(abs($checkin_date_new - $checkout_date_new) / 86400);
    }
    //Get capacity based on $this->guestsPerRoom
    private function load_multi_capacity() {
        $query = $this->ci->db->query("SELECT * FROM app_capacity WHERE capacity >= ".$this->guestsPerRoom);
        foreach ($query->result() as $currentrow){
            $this->multiCapacity[$currentrow->id] = array('capval'=>$currentrow->capacity,'captitle'=>$currentrow->title);
        }

    }
    //Get all room types
    private function load_room_types() {
        $query = $this->ci->db->get('roomtype');
        foreach ($query->result() as $currentrow){
            array_push($this->roomType, array('rtid'=>$currentrow->roomtype_ID, 'rtname'=>$currentrow->type_name));
        }
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
					$time_from+= 86400; // add 24 hours
				}
			}else{
				while($time_from <= $time_to) {      
					array_push($date_arr, date('Y-m-d',$time_from));
					array_push($day_array, $time_from);
					$time_from+= 86400; // add 24 hours
				}
			}			
		}  
		array_push($total_array, $date_arr);
		array_push($total_array, $day_array);
		return $total_array;		
    }
     // Get available rooms
    public function get_available_rooms($roomTypeId, $roomTypeName, $capcityid){
        $this->ci->load->library('session');
        $searchresult = array(
            'roomtypeid'=>$roomTypeId,
            'roomtypename'=>$roomTypeName, 
            'capacityid'=>$capcityid, 
            'capacitytitle'=>$this->multiCapacity[$capcityid]['captitle'],
            'capacity'=>$this->multiCapacity[$capcityid]['capval'],
            'maxchild'=>$this->childPerRoom
        );

        $room_count = 0;
		$dropdown_html = '<option value="0" selected="selected">0</option>';
        $price_details_html = '';
        $rooms_left = '';
		$total_price_amount = 0;
		$calculated_extraprice = 0;
		$total_specail_price=0;
		$specail_price_flag=0;
		$extraSearchParam = "";
		$minimum_night_flg=1;
		$variable_concat=1;
        $child_flag=false;

        $query = $this->ci->db->query("SELECT rm.room_ID, rm.room_no
                FROM app_room AS rm
                WHERE rm.roomtype_id=".$roomTypeId."
                AND rm.capacity_id = ".$capcityid."".$extraSearchParam."
                AND rm.room_id NOT IN
                (SELECT resv.room_id
                FROM app_reservation as resv, app_bookings as boks
                WHERE  
                boks.is_deleted = FALSE
                AND resv.bookings_id = boks.booking_id
                AND resv.room_type_id = ".$roomTypeId."
                AND (('".$this->mysqlCheckInDate."' BETWEEN boks.start_date AND DATE_SUB(boks.end_date, INTERVAL 1 DAY))
                OR (DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY) BETWEEN boks.start_date AND DATE_SUB(boks.end_date, INTERVAL 1 DAY))			  
                OR (boks.start_date BETWEEN '".$this->mysqlCheckInDate."' AND DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY))   					  
                OR (DATE_SUB(boks.end_date, INTERVAL 1 DAY) BETWEEN '".$this->mysqlCheckInDate."' AND DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY))))");
        $tmpctr = 1;
        $searchresult['availablerooms'] = array();
        foreach ($query->result() as $currentrow){
            $dropdown_html.= '<option value="'.$tmpctr.'">'.$tmpctr.'</option>';
            $rooms_left = $tmpctr;
			array_push($searchresult['availablerooms'], array('roomid'=>$currentrow->room_ID, 'roomno'=>$currentrow->room_no));
			$tmpctr++;
        }


        if($tmpctr >= 1){
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
            
            $price_details_html='<tr><td bgcolor='.$_color.'><b>'.$mon.'</b></td>';
            foreach($dayName as $days => $totalnum){
               $$days=0;
               $h1=$days.$variable_concat;
               $$h1=0;
           }

           $total_child_price=0;
           $total_child_price2=0;
           $price_details_html.='<td bgcolor='.$color_.' align="right"><b>'.$this->nightCount.' Night(s)</b></td></tr>';

           foreach($totalDays[0] as $date2 => $val){
              $query2 = $this->ci->db->query("SELECT * FROM app_priceplan WHERE roomtype_id = ".$roomTypeId." AND capacity_id = ".$capcityid." AND ('".$val."' BETWEEN start_date AND end_date)");
              if($query2->num_rows()){
                $row = $query2->row_array();
              }else{
                $query3 = $this->ci->db->query("SELECT * FROM app_priceplan WHERE roomtype_id = ".$roomTypeId." AND capacity_id = ".$capcityid." AND  default_plan=1"); 
                $row = $query3->row_array();
              }

            $day=date('D',strtotime($val));
            $$day+=$row[strtolower($day)];
            $query4 = $this->ci->db->query("SELECT * FROM app_special_offer WHERE '".$val."' between  `start_date` AND `end_date` AND (room_type=".$roomTypeId ." or room_type=0)"); 
            $row99 = $query4->row_array();

            $h2=$day.$variable_concat;

            if($query4->num_rows()){							
                $c999=round($row[strtolower($day)]- (($row[strtolower($day)]*$row99['price_deduc'])/100),1);
                $$h2+=$c999;
                if($row99['min_stay'] <= $minimum_night_flg){ $specail_price_flag=1; }					
                $minimum_night_flg++;					
            }else{
                $$h2+=$row[strtolower($day)];
            }

            $query5 = $this->ci->db->query("SELECT distinct(`no_of_child`) FROM `app_room` WHERE `capacity_id`=".$capcityid." and `roomtype_id`=".$roomTypeId."");
            foreach ($query5->result() as $chld_row2){
                if($chld_row2->no_of_child >= $this->childPerRoom && $this->childPerRoom != 0){
                    $child_flag=true;
                    $query6 = $this->ci->db->query("SELECT * FROM app_priceplan WHERE roomtype_id = ".$roomTypeId." AND capacity_id =1001 AND ('".$val."' BETWEEN start_date AND end_date)");
                    if($query6->num_rows()){
                        $chrow = $query6->row();
                    }else{
                        $query7 = $this->ci->db->query("SELECT * FROM app_priceplan WHERE roomtype_id = ".$roomTypeId." AND capacity_id =1001 AND  default_plan=1");
                        $chrow = $query7->row();
                    }

                    $day=date('D',strtotime($val));					
                    $$day+=($chrow[strtolower($day)]*$this->childPerRoom); 	

                    $query8 = $this->ci->db->query("SELECT * FROM app_special_offer WHERE '".$val."' between  `start_date` AND `end_date` AND (room_type=".$roomTypeId ." or room_type=0)");
                    if($query8->num_rows()){
                        $row999 = $query8->row();
                        $c999=round(($chrow[strtolower($day)]*$this->childPerRoom)- ((($chrow[strtolower($day)]*$this->childPerRoom)*$row999['price_deduc'])/100),1);
                        $$h2+=$c999;
						$total_child_price2+=$c999;
                    }else{
						$$h2+=($chrow[strtolower($day)]*$this->childPerRoom);
                        $total_child_price2+=($chrow[strtolower($day)]*$this->childPerRoom); 
                    }

                    $total_child_price+=($chrow[strtolower($day)]*$this->childPerRoom); 
            
               }
            }

            $night_count_at_customprice = 0;	
            $searchresult['prices'] = array();	
            
            foreach($dayName as $days => $totalnum){				  
                $totalamt3=$totalamt3+$$days;	
                $h3=$days.$variable_concat;
                $total_specail_price=$total_specail_price+$$h3;
            } 

            $total_price_amount=$totalamt3;

            if($this->ci->config_manager->config['conf_tax_amount'] > 0 && $this->ci->config_manager->config['conf_price_with_tax']==1){ 
                $total_price_amount=$total_price_amount+(($total_price_amount * $this->ci->config_manager->config['conf_tax_amount'])/100);
                $total_specail_price=$total_specail_price+(($total_specail_price * $this->ci->config_manager->config['conf_tax_amount'])/100);
                $total_child_price=$total_child_price+(($total_child_price * $this->ci->config_manager->config['conf_tax_amount'])/100);
                $total_child_price2=$total_child_price2+(($total_child_price2 * $this->ci->config_manager->config['conf_tax_amount'])/100);
            }

        }

        if($specail_price_flag){
			$searchresult['roomprice'] = $total_specail_price;	
		}else{
			$searchresult['roomprice'] = $total_price_amount;	
		}
        if($tmpctr > 1) array_push($_SESSION['svars_details'], $searchresult);
        unset($searchresult);
        
        return array(
            'roomcnt' => $tmpctr-1,		
            'roomdropdown' => $dropdown_html,
            'pricedetails' => $price_details_html,		
            'child_flag'=>$child_flag,
            'specail_price_flag'=>$specail_price_flag,
            'total_specail_price'=>$total_specail_price,
            'total_child_price'=>$total_child_price,
            'total_child_price2'=>$total_child_price2,
            'totalprice' => $total_price_amount,
            'rooms_left' => $rooms_left
        ); 
        
        }
    }
    //Check rooms based on roomtype_id and capacity_id
    public function room_checker($room_type, $capacity_id){
        $query = $this->ci->db->query("SELECT * FROM app_room where roomtype_id=".$room_type." AND capacity_id=".$capacity_id);
        if($query->num_rows()){
            return true;
        }else{
            return false;
        }
    }
    // get room description based on roomtype_ID
    public function get_room_description($typeID){
        $query = $this->ci->db->query("SELECT description FROM app_roomtype WHERE roomtype_ID=".$typeID);
        return $query->row_array();
    }
    // get room images
    public function get_room_images($rid, $cid){
        $this->ci->db->where('roomtype_id', $rid);
        $this->ci->db->where('capacity_id', $cid);
        $query = $this->ci->db->get("gallery"); 
        return $query->row_array();
    }
    // debug helper
    private function invalid_request(){
        //header('Location: booking-failure.php?error_code=9');
        //echo "Booking Class error";
        //die;
        redirect('app/index', 'refresh');
    }
    
}
