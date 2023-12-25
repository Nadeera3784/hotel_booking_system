<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment{

	private $guestsPerRoom		= 0;
	private $checkInDate		= '';
	private $checkOutDate		= '';
	private $noOfNights			= 0;
	private $noOfRooms			= 0;  
	private $mysqlCheckInDate	= '';
	private $mysqlCheckOutDate	= '';	
	private $clientdata			= array();		
	private $expTime			= 0;	
	private $roomIdsOnly		= '';
	private $pricedata			= array();
	private $taxAmount 			= 0.00;
	private $taxPercent			= 0.00;
	private $grandTotalAmount 	= 0.00;	
	private $currencySymbol		= '';
	private $depositenabled		= false;
    private $taxWithPrice;
    
	public $clientId			= 0;
	public $clientName			= '';
	public $clientEmail			= '';
	public $bookingId			= 0;
	public $paymentGatewayCode	= '';		
	public $totalPaymentAmount 	= 0.00;	
    public $invoiceHtml			= '';
    public $ci;

    public function __construct(){
        $this->ci = &get_instance();
		$this->ci->load->library('config_manager');
		$this->ci->load->helper('security');
        $this->set_my_request_params();
		$this->remove_session_variables();
		$this->check_availability();
		$this->save_client_data();
		$this->save_booking_data();
		$this->create_invoice();
    }
	//Set POST AND SESSION params
    private function set_my_request_params(){ 
		$this->set_my_param_value($this->guestsPerRoom, 'SESSION', 'sv_guestperroom', 0, true);	
		$this->set_my_param_value($this->checkInDate, 'SESSION', 'sv_checkindate', NULL, true);
		$this->set_my_param_value($this->checkOutDate, 'SESSION', 'sv_checkoutdate', NULL, true);
		$this->set_my_param_value($this->noOfNights, 'SESSION', 'sv_nightcount', 0, true);
		$this->set_my_param_value($this->mysqlCheckInDate, 'SESSION', 'sv_mcheckindate', NULL, true);
		$this->set_my_param_value($this->mysqlCheckOutDate, 'SESSION', 'sv_mcheckoutdate', NULL, true);
		$this->set_my_param_value($this->roomIdsOnly, 'SESSION', 'dv_roomidsonly', '', true);		
		$this->set_my_param_value($this->reservationdata2, 'SESSION', 'dvars_details2', NULL, true);	
		$this->set_my_param_value($this->reservationdata, 'SESSION', 'dvars_details', NULL, true);						
		$this->set_my_param_value($this->pricedata, 'SESSION', 'dvars_roomprices', NULL, true);		
				
		$this->set_my_param_value($this->clientdata['title'], 'POST', 'title', true); 
		$this->set_my_param_value($this->clientdata['fname'], 'POST', 'first_name', '', true);
		$this->set_my_param_value($this->clientdata['lname'], 'POST', 'last_name', '', true);
		$this->set_my_param_value($this->clientdata['address'], 'POST', 'address', '', true);
		$this->set_my_param_value($this->clientdata['city'], 'POST', 'city', '', true);
		//$this->set_my_param_value($this->clientdata['state'], 'POST', 'state', '', true);
		$this->set_my_param_value($this->clientdata['zipcode'], 'POST', 'postal_code', '', true);
		$this->set_my_param_value($this->clientdata['country'], 'POST', 'country', '', true);
		$this->set_my_param_value($this->clientdata['phone'], 'POST', 'phone', '', true);
		//$this->set_my_param_value($this->clientdata['fax'], 'POST', 'fax', '', false); //optionlal
		$this->set_my_param_value($this->clientdata['email'], 'POST', 'email', '', true);
		//$this->set_my_param_value($this->clientdata['password'], 'POST', 'password', '', true);
		$this->set_my_param_value($this->clientdata['id_type'], 'POST', 'identity_type', '', true);
		$this->set_my_param_value($this->clientdata['id_number'], 'POST', 'identity_number', '', true);
		$this->set_my_param_value($this->clientdata['message'], 'POST', 'additional_requests', '', false);
		$this->set_my_param_value($this->clientdata['clientip'], 'SERVER', 'REMOTE_ADDR', '', false);					
		$this->set_my_param_value($this->paymentGatewayCode, 'POST', 'payoption','', true);	
		
		$this->bookingId		= time();		
		$this->expTime 			= intval($this->ci->config_manager->config['conf_booking_exptime']);	
		$this->currencySymbol 	= $this->ci->config_manager->get_default_currency_symbol();
		$this->taxPercent 		= $this->ci->config_manager->config['conf_tax_amount'];
		$this->clientName 		= $this->clientdata['fname']." ". $this->clientdata['lname'];
		$this->clientEmail		= $this->clientdata['email'];
		$this->noOfRooms		= count(explode(",", $this->roomIdsOnly));
		$this->taxWithPrice     = $this->ci->config_manager->config['conf_price_with_tax'];
			
		if($this->ci->config_manager->config['conf_enabled_deposit'])
			$this->depositenabled = true;			
		
		$this->taxAmount 			= $this->pricedata['totaltax'];
		$this->grandTotalAmount 	= $this->pricedata['grandtotal'];
		$this->totalPaymentAmount 	= $this->pricedata['advanceamount'];
	
	}
    //Check params
	private function set_my_param_value(&$membervariable, $vartype, $param, $defaultvalue, $required = false){
		switch($vartype){
			case "POST": 
				if($required){if(!isset($_POST[$param])){$this->invalid_request("POST");} 
					else{$membervariable =  $this->ci->security->xss_clean($_POST[$param]);}}
				else{if(isset($_POST[$param])){$membervariable = $this->ci->security->xss_clean($_POST[$param]);} 
					else{$membervariable = $defaultvalue;}}				
				break;	
			case "GET":
				if($required){if(!isset($_GET[$param])){$this->invalid_request("GET");} 
					else{$membervariable =  $this->ci->security->xss_clean($_GET[$param]);}}
				else{if(isset($_GET[$param])){$membervariable =  $this->ci->security->xss_clean($_GET[$param]);} 
					else{$membervariable = $defaultvalue;}}				
				break;	
			case "SESSION":
				if($required){if(!isset($_SESSION[$param])){$this->invalid_request("SESSION");} 
					else{$membervariable = $_SESSION[$param];}}
				else{if(isset($_SESSION[$param])){$membervariable = $_SESSION[$param];} 
					else{$membervariable = $defaultvalue;}}				
				break;	
			case "REQUEST":
				if($required){if(!isset($_REQUEST[$param])){$this->invalid_request("REQUEST");}
					else{$membervariable =  $this->ci->security->xss_clean($_REQUEST[$param]);}}
				else{if(isset($_REQUEST[$param])){$membervariable =  $this->ci->security->xss_clean($_REQUEST[$param]);}
					else{$membervariable = $defaultvalue;}}				
				break;
			case "SERVER":
				if($required){if(!isset($_SERVER[$param])){$this->invalid_request("SERVER");}
					else{$membervariable = $_SERVER[$param];}}
				else{if(isset($_SERVER[$param])){$membervariable = $_SERVER[$param];}
					else{$membervariable = $defaultvalue;}}				
				break;			
		}		
	}	    
    //Clear  $_SESSION
    private function remove_session_variables(){
		if(isset($_SESSION['sv_checkindate'])) unset($_SESSION['sv_checkindate']);
		if(isset($_SESSION['sv_checkoutdate'])) unset($_SESSION['sv_checkoutdate']);
		if(isset($_SESSION['sv_mcheckindate'])) unset($_SESSION['sv_mcheckindate']);
		if(isset($_SESSION['sv_mcheckoutdate'])) unset($_SESSION['sv_mcheckoutdate']);	
		if(isset($_SESSION['sv_nightcount'])) unset($_SESSION['sv_nightcount']);
		if(isset($_SESSION['sv_guestperroom'])) unset($_SESSION['sv_guestperroom']);
		if(isset($_SESSION['sv_childcount'])) unset($_SESSION['sv_childcount']);	
		if(isset($_SESSION['svars_details'])) unset($_SESSION['svars_details']);
		if(isset($_SESSION['dvars_details'])) unset($_SESSION['dvars_details']);
		if(isset($_SESSION['dv_roomidsonly'])) unset($_SESSION['dv_roomidsonly']);	
		if(isset($_SESSION['dvars_roomprices'])) unset($_SESSION['dvars_roomprices']);
    }
    //Check availability of rooms
	private function check_availability(){
		$query = $this->ci->db->query(
        "SELECT resv.room_id
		 FROM app_reservation resv, app_bookings boks
		 WHERE     resv.bookings_id = boks.booking_id
			   AND ((NOW() - boks.booking_time) < ".$this->expTime.")
			   AND boks.is_deleted = FALSE
			   AND resv.room_id IN (".$this->roomIdsOnly.")
			   AND (('".$this->mysqlCheckInDate."' BETWEEN boks.start_date AND DATE_SUB(boks.end_date, INTERVAL 1 DAY))
				OR (DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY) BETWEEN boks.start_date AND DATE_SUB(boks.end_date, INTERVAL 1 DAY))
				OR (boks.start_date BETWEEN '".$this->mysqlCheckInDate."' AND DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY))
				OR (DATE_SUB(boks.end_date, INTERVAL 1 DAY) BETWEEN '".$this->mysqlCheckInDate."' AND DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY)))");
            				
		if($query->num_rows()){	
			$this->invalid_request("check_availability");
			die;
		}
    }
    //Add client info to app_clients table    
    private function save_client_data(){
        $query = $this->ci->db->query("SELECT client_id FROM app_clients WHERE email = '".$this->clientdata['email']."'");
        if($query->num_rows() > 0){
            $clientrow = $query->row_array();
            $this->clientId = $clientrow["client_id"];	
            $this->ci->db->query("UPDATE app_clients SET first_name = '".$this->clientdata['fname']."', surname = '".$this->clientdata['lname']."', title = '".$this->clientdata['title']."', street_addr = '".$this->clientdata['address']."', city = '".$this->clientdata['city']."' , zip = '".$this->clientdata['zipcode']."', country = '".$this->clientdata['country']."', phone = '".$this->clientdata['phone']."',  id_type = '".$this->clientdata['id_type']."',  id_number = '".$this->clientdata['id_number']."',  additional_comments = '".$this->clientdata['message']."', ip = '".$this->clientdata['clientip']."' WHERE client_id = ".$this->clientId);
        }else{
            $this->ci->db->query("INSERT INTO app_clients (first_name, surname, title, street_addr, city, zip, country, phone, email,  id_type, id_number, additional_comments, ip) values('".$this->clientdata['fname']."', '".$this->clientdata['lname']."', '".$this->clientdata['title']."', '".$this->clientdata['address']."', '".$this->clientdata['city']."' , '".$this->clientdata['zipcode']."', '".$this->clientdata['country']."', '".$this->clientdata['phone']."', '".$this->clientdata['email']."', '".$this->clientdata['id_type']."', '".$this->clientdata['id_number']."', '".$this->clientdata['message']."', '".$this->clientdata['clientip']."')");
            $this->clientId = $this->ci->db->insert_id();
        }

	}
	//Add booking info to  app_bookings and app_reservation table
    private function save_booking_data(){
        $this->ci->db->query("INSERT INTO app_bookings (booking_id, booking_time, start_date, end_date, client_id, total_cost, payment_amount, payment_type, special_requests) values(".$this->bookingId.", NOW(), '".$this->mysqlCheckInDate."', '".$this->mysqlCheckOutDate."', ".$this->clientId.", ".$this->grandTotalAmount.", ".$this->totalPaymentAmount.", '".$this->paymentGatewayCode."', '".$this->clientdata['message']."')");
        foreach($this->reservationdata as $revdata){
            foreach($revdata['availablerooms'] as $rooms){
                $this->ci->db->query("INSERT INTO app_reservation (bookings_id, room_id, room_type_id) values(".$this->bookingId.",  ".$rooms['roomid'].", ".$revdata['roomtypeid'].")");
            }
        }
	}
	//Create invoice details
	private function create_invoice(){
		$this->invoiceHtml = 
		'<hr class="light-grey-hr row mt-10 mb-15">
		<div class="label-chatrs mb-10">
			<div class="">
				<span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
					<span class="block font-15  mt-5">Booking Number</span>
				</span>
				<div class="pull-right"><button type="button" id="showinfo" class="btn btn-default"><i class="icon-plus text-blue mr-10"></i> '.$this->bookingId.'</button></div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="table-responsive" id="invoice_ws">
		<table class="table table-bordered">
		      <tbody>	
		        <tr class="txt-dark weight-500">
					<th>'.$this->ci->security->xss_clean('Check-In Date').'</th>
					<th>'.$this->ci->security->xss_clean('Check-Out Date').'</th>
					<th>'.$this->ci->security->xss_clean('Total Nights').'</th>
					<th>'.$this->ci->security->xss_clean('Total Rooms').'</th>
		        </tr>
			   <tr>
				  <td>'.$this->checkInDate.'</td>
				  <td>'.$this->checkOutDate.'</td>
				  <td>'.$this->noOfNights.'</td>
				  <td>'.$this->noOfRooms.'</td>
				</tr>
				<tr class="txt-dark weight-500">
				   <th>'.$this->ci->security->xss_clean('Number of rooms').'</th>
		           <th>'.$this->ci->security->xss_clean('Room type').'</th>
		           <th>'.$this->ci->security->xss_clean('Max Occupancy').'</th>
				   <th>'.$this->ci->security->xss_clean('Gross Total').'</th>
				</tr>';		
			
		foreach($this->reservationdata2 as $revdata){
			$child_title2=($revdata['child_flag2'])? " + ".$revdata['childcount3']." ".'Child'."":""; 
			$this->invoiceHtml.= '<tr>
									<td>'.$revdata['roomno'].'</td>
									<td>'.$revdata['roomtype'].' ('.$revdata['capacitytitle'].')</td>
									<td>'.$revdata['capacity'].' '.'Adult'.' '.$child_title2;		
				$this->invoiceHtml.= '</td>
										<td>'.(($this->ci->config_manager->config['conf_invoice_currency']=='1')? $this->ci->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->ci->config_manager->get_exchange_money($revdata['grosstotal'],$_SESSION['sv_currency']) : $this->currencySymbol.number_format($revdata['grosstotal'], 2 ) ).'</td>
								    </tr>';
		}
		
		$this->invoiceHtml.= '<tr>
							  <td></td>
							  <td></td>
							  <td>'.$this->ci->security->xss_clean('Sub Total').'</td>
							  <td>'.(($this->ci->config_manager->config['conf_invoice_currency']=='1')?  $this->ci->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->ci->config_manager->get_exchange_money($this->pricedata['subtotal'],$_SESSION['sv_currency']) : $this->currencySymbol.number_format($this->pricedata['subtotal'], 2)).'</td>
							  </tr>';
					
		if($this->taxPercent > 0 &&  $this->taxWithPrice == 0){ 	
		$this->invoiceHtml.= '<tr>
								 <td></td>
								 <td></td>
		                         <td>'.$this->ci->security->xss_clean('Tax').'('.number_format($this->taxPercent, 2 , '.', '').'%)</td>
		                         <td>(+) '.(($this->ci->config_manager->config['conf_invoice_currency']=='1')?  $this->ci->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->ci->config_manager->get_exchange_money($this->taxAmount,$_SESSION['sv_currency']) : $this->currencySymbol.number_format($this->taxAmount, 2)).'</td>
							 </tr>
							 <tr>
							    <td></td>
							    <td></td>
							    <td>'.$this->ci->security->xss_clean('Grand Total').'</td>
								<td class="text-primary">'.(($this->ci->config_manager->config['conf_invoice_currency']=='1')?  $this->ci->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->ci->config_manager->get_exchange_money($this->grandTotalAmount,$_SESSION['sv_currency']) : $this->currencySymbol.number_format($this->grandTotalAmount, 2)).'</td>
							 </tr>';
		}else{
			$this->invoiceHtml.= '<tr>
									<td></td>
									<td></td>
			                        <td>'.'Grand Total'.'</td>
									<td class="text-primary">'.(($this->ci->config_manager->config['conf_invoice_currency']=='1')? $this->ci->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->ci->config_manager->get_exchange_money($this->grandTotalAmount,$_SESSION['sv_currency'])  : $this->currencySymbol.number_format($this->grandTotalAmount, 2)).'</td>
									</tr>';	
		}
		if($this->depositenabled && ($this->pricedata['advancepercentage'] > 0 && $this->pricedata['advancepercentage'] < 100)){
			
			$this->invoiceHtml.= '<tr>
									<td></td>
									<td></td>
			                        <td>'.$this->ci->security->xss_clean('Advance Payment').'('.number_format($this->pricedata['advancepercentage'], 2 , '.', '').'% '.$this->ci->security->xss_clean('Of Grand total').')</td>
									<td class="text-primary">'.(($this->ci->config_manager->config['conf_invoice_currency']=='1')? $$this->ci->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->ci->config_manager->get_exchange_money($this->totalPaymentAmount,$_SESSION['sv_currency']) : $this->currencySymbol.number_format($this->totalPaymentAmount, 2)).'</td>
								 </tr>';
		} 
		$this->invoiceHtml.= '</tbody></table></div>';
		
		if($this->clientdata['message'] != ""){
			$this->invoiceHtml.= '
			<div class="label-chatrs">
				<div class="">
					<span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
						<span class="block font-15  mt-5">'.$this->ci->security->xss_clean('Additional requests').'</span>
					</span>
					<div class="pull-right"><span class="font-18">'.$this->clientdata['message'].'</span></div>
					<div class="clearfix"></div>
				</div>
		    </div>';				
		}
		
		
		//if($this->paymentGatewayCode == "poa"){
		//	$paymentGatewayDetails = $bsiCore->loadPaymentGateways();
			//$payoptions = $paymentGatewayDetails['poa']['name'];		
			$payoptions =  $this->paymentGatewayCode;
			$this->invoiceHtml.= '
			<div class="label-chatrs">
			<div class="">
				<span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
					<span class="block font-15  mt-5">'.$this->ci->security->xss_clean('Payment Option').'</span>
				</span>
				<div class="pull-right"><span class="font-18">'.$payoptions.'</span></div>
				<div class="clearfix"></div>
			</div>
		    </div>
            <hr class="light-grey-hr row mt-10 mb-15">
			<div class="label-chatrs">
			<div class="">
				<span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
					<span class="block font-15  mt-5">'.$this->ci->security->xss_clean('Transaction ID').'</span>
				</span>
				<div class="pull-right"><span class="font-18">NA</span></div>
				<div class="clearfix"></div>
			</div>
			</div>';					
		//}
		
		$this->ci->db->query("INSERT INTO app_invoice(booking_id, client_name, client_email, invoice) values(".$this->bookingId.", '".$this->clientName."', '".$this->clientdata['email']."', '".$this->invoiceHtml."')");	
	}
	//Debug helper
    private function invalid_request($errocode = 9){		
        //header('Location: booking-failure.php?error_code='.$errocode.'');
        echo "Payment error".$errocode;
		die;
    }
    
}