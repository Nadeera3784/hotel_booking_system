
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipt extends CI_Controller {

    public $guestsPerRoom      = 0;			
	public $nightCount         = 0;	
	public $checkInDate        = '';
	public $checkOutDate       = '';	
	public $totalRoomCount     = 0;	
	public $roomPrices         = array();
	public $depositPlans       = array();
	private $selectedRooms     = '';
	private $mysqlCheckInDate  = '';
	private $mysqlCheckOutDate = '';
	private $searchVars        = array();
    private $detailVars	       = array();
	
	
    public function __construct(){
		parent::__construct();
		$this->load->library('session');
    }

    public function index(){
		$this->set_request_rarams();
		$this->advance_payment();
		$data['booking_details'] = $this->generate_booking_details();
		$data['checkInDate'] = $this->checkInDate;
		$data['checkOutDate'] = $this->checkOutDate;
		$data['nightCount'] = $this->nightCount;
		$data['totalRoomCount'] = $this->totalRoomCount;
		$data['roomPrices'] = $this->roomPrices;
		$data['bodyclass'] = "body-wrapper";
		$this->load->view('header', $data);
		$this->load->view('receipt', $data);
		$this->load->view('footer');
		
    }
    //Set Params
    private function set_request_rarams() {

		$this->set_my_param_value($this->guestsPerRoom, 'SESSION', 'sv_guestperroom', NULL, true);		
 
		$this->set_my_param_value($this->checkInDate, 'SESSION', 'sv_checkindate', NULL, true);
 
		$this->set_my_param_value($this->mysqlCheckInDate, 'SESSION', 'sv_mcheckindate', NULL, true);
 
		$this->set_my_param_value($this->checkOutDate, 'SESSION', 'sv_checkoutdate', NULL, true);
 
		$this->set_my_param_value($this->mysqlCheckOutDate, 'SESSION', 'sv_mcheckoutdate', NULL, true);
 
		$this->set_my_param_value($this->nightCount, 'SESSION', 'sv_nightcount', NULL, true);		
 
		$this->set_my_param_value($this->searchVars, 'SESSION', 'svars_details', NULL, true);
 
		$this->set_my_param_value($this->selectedRooms, 'POST_SPECIAL', 'svars_selectedrooms', NULL, true);	

		$selected = 0;
 
		foreach($this->selectedRooms as &$val){		

			if($val) $selected++;
 
		}			
 
		if($selected == 0) $this->invalid_request(9);
    }
       
    private function set_my_param_value(&$membervariable, $vartype, $param, $defaultvalue, $required = false){
 
		switch($vartype){
 
			case "POST": 
 
				if($required){
					if(!isset($_POST[$param])){
						$this->invalid_request(9);
					}else{$membervariable = $_POST[$param];
					}
				}else{
					if(isset($_POST[$param])){
						$membervariable = $_POST[$param];
					}else{
						$membervariable = $defaultvalue;
					}
				}				
 
				break;	
 
			case "POST_SPECIAL":
 
				if($required){
					if(!isset($_POST[$param])){
						$this->invalid_request(9);
					}else{
						$membervariable = $_POST[$param];
					}
				}else{
					if(isset($_POST[$param])){
						$membervariable = $_POST[$param];
					}else{
						$membervariable = $defaultvalue;
					}
				}				
 
				break;	
 
			case "GET":
 
				if($required){
					if(!isset($_GET[$param])){
						$this->invalid_request(9);
					}else{
						$membervariable = $_GET[$param];
					}
				}else{
					if(isset($_GET[$param])){
						$membervariable = $_GET[$param];
					}else{
						$membervariable = $defaultvalue;
					}
				}				
 
				break;	
 
			case "SESSION":
 
				if($required){
					if(!isset($_SESSION[$param])){
						$this->invalid_request(9);
					}else{
						$membervariable = $_SESSION[$param];
					}
				}else{
					if(isset($_SESSION[$param])){
						$membervariable = $_SESSION[$param];
					}else{
						$membervariable = $defaultvalue;
					}
				}				
 
				break;	
 
			case "REQUEST":
 
				if($required){if(!isset($_REQUEST[$param])){$this->invalid_request(9);}
 
					else{$membervariable = $_REQUEST[$param];}}
 
				else{if(isset($_REQUEST[$param])){$membervariable = $_REQUEST[$param];}
 
					else{$membervariable = $defaultvalue;}}				
 
				break;
 
			case "SERVER":
 
				if($required){if(!isset($_SERVER[$param])){$this->invalid_request(9);}
 
					else{$membervariable = $_SERVER[$param];}}
 
				else{if(isset($_SERVER[$param])){$membervariable = $_SERVER[$param];}
 
					else{$membervariable = $defaultvalue;}}				
 
				break;	
 
					
 
		}		
 
    }	
    //Get advance payment from  app_advance_payment table
    private function advance_payment(){
	   
        $month  = intval(substr($this->mysqlCheckInDate, 5, 2)) ;
 
        $query = $this->db->query("SELECT * FROM app_advance_payment WHERE month_num = ".$month);
 
        $this->depositPlans =  $query->row_array();
                
    }
    //Get booking details
    public function generate_booking_details() {

        $result = array();
    
        $_SESSION['dvars_details2'] = array();
        

        $dvroomidsonly = "";
    
        $selectedRoomsCount = count($this->selectedRooms);		
    
        $this->roomPrices['subtotal']   = 0.00;	
    
        $this->roomPrices['totaltax']   = 0.00;			
    
        $this->roomPrices['grandtotal'] = 0.00;	
    
        
    
        $dvarsCtr = 0;
    
        for($i = 0; $i < $selectedRoomsCount; $i++){
    
            if($this->selectedRooms[$i] > 0){		
    
                $this->detailVars[$dvarsCtr] = $this->searchVars[$i]; //selected only							
    
                $tmpTotalPrice = 0;
    
                $tmpTotalPrice2 = 0;
    
                $tmpTotalPrice = $this->detailVars[$dvarsCtr]['roomprice'];
    
                $this->detailVars[$dvarsCtr]['totalprice'] = $tmpTotalPrice;
    
                
    
                $tmpRoomCounter = 0;								
    
                foreach($this->detailVars[$dvarsCtr]['availablerooms'] as $availablerooms){	
    
                    $this->roomPrices['subtotal'] = $this->roomPrices['subtotal'] + $tmpTotalPrice;	
    
                    $dvroomidsonly.= $availablerooms['roomid'].",";													
    
                    $tmpRoomCounter++;	
    
                    if($tmpRoomCounter == $this->selectedRooms[$i]){
    
                        $tmpAvRmSize = count($this->detailVars[$dvarsCtr]['availablerooms']);
    
                        for($akey = $tmpRoomCounter; $akey < $tmpAvRmSize; $akey++){
    
                            unset($this->detailVars[$dvarsCtr]['availablerooms'][$akey]);
    
                        }
    
                        break;		
    
                    }			
    
                }
                
                $child_flag2 = false;
    
                $query = $this->db->query("SELECT distinct(`no_of_child`) FROM `app_room` WHERE `capacity_id`=".$this->detailVars[$dvarsCtr]['capacityid']." and `roomtype_id`=".$this->detailVars[$dvarsCtr]['roomtypeid']."");
    
                $chld_row2 =  $query->row_array();
                
                if($chld_row2['no_of_child'] >= $_SESSION['sv_childcount'] && $_SESSION['sv_childcount'] != 0){
                    $child_flag2=true;
                }
    
                array_push($result, array('roomno'=>$tmpRoomCounter, 'roomtype'=>$this->detailVars[$dvarsCtr]['roomtypename'], 'capacitytitle'=>$this->detailVars[$dvarsCtr]['capacitytitle'] ,'capacity'=>$this->detailVars[$dvarsCtr]['capacity'], 'details'=>$tmpRoomCounter."x".$tmpTotalPrice, 'grosstotal'=>$tmpRoomCounter*$tmpTotalPrice, 'child_flag2'=>$child_flag2, 'childcount3'=>$_SESSION['sv_childcount'] ));
    
                $dvarsCtr++;				
    
            }
    
        }
    
        
    
        
    
        if(isset($_SESSION['dvars_details']))unset($_SESSION['dvars_details']);
    
        $_SESSION['dvars_details'] = $this->detailVars;
    
        
    
        if(isset($_SESSION['dvars_details2']))unset($_SESSION['dvars_details2']);
    
        $_SESSION['dvars_details2'] = $result;
    
                
    
        if(isset($_SESSION['dv_roomidsonly']))unset($_SESSION['dv_roomidsonly']);
    
        $_SESSION['dv_roomidsonly'] = substr($dvroomidsonly, 0, -1);
    
            
    
        $this->totalRoomCount =  count(explode(",", $_SESSION['dv_roomidsonly']));
    
        
    
        
    
        /* -------------------------------- calculate pricing ------------------------------------ */	
    
                                            
    
        if($this->config_manager->config['conf_tax_amount'] > 0 &&  $this->config_manager->config['conf_price_with_tax']==0){ 
    
            $this->roomPrices['totaltax'] = ($this->roomPrices['subtotal'] * $this->config_manager->config['conf_tax_amount'])/100;
    
            $this->roomPrices['grandtotal'] = $this->roomPrices['subtotal'] + $this->roomPrices['totaltax'];	
    
        }else{
            $this->roomPrices['grandtotal'] = $this->roomPrices['subtotal'];
        }
    
        
    
        $this->roomPrices['advanceamount'] = $this->roomPrices['grandtotal'];
    
        if($this->config_manager->config['conf_enabled_deposit']){
    
            $this->roomPrices['advancepercentage'] = $this->depositPlans['deposit_percent'];			
    
            if($this->roomPrices['advancepercentage'] > 0 && $this->roomPrices['advancepercentage'] < 100){
    
                $this->roomPrices['advanceamount'] = ($this->roomPrices['grandtotal'] * $this->roomPrices['advancepercentage'])/100;
    
            }
    
        }
    
        
    
        //format currencies round upto 2 decimal places		
    
        $this->roomPrices['subtotal'] = number_format($this->roomPrices['subtotal'], 2 , '.', '');	
    
        $this->roomPrices['totaltax'] = number_format($this->roomPrices['totaltax'], 2 , '.', '');			
    
        $this->roomPrices['grandtotal'] = number_format($this->roomPrices['grandtotal'], 2 , '.', '');
    
        if($this->config_manager->config['conf_enabled_deposit']){	
    
        $this->roomPrices['advancepercentage'] = number_format($this->roomPrices['advancepercentage'], 2 , '.', '');
    
        $this->roomPrices['advanceamount'] = number_format($this->roomPrices['advanceamount'], 2 , '.', '');
    
        }
    
        if(isset($_SESSION['dvars_roomprices']))unset($_SESSION['dvars_roomprices']);
    
        $_SESSION['dvars_roomprices'] = $this->roomPrices;
    
        
    
        return $result;
    
    }	
    //Debug helper
    private function invalid_request($errocode = 9){		
        //echo "Test controller error" . $errocode;
        //header('Location: booking-failure.php?error_code='.$errocode.'');
		redirect('app/index', 'refresh'); 
        //die;
    
    }
}