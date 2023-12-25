<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model('Dashboard_model');
        $this->__is_logged_in();
    }

    public function index(){
        if($this->__permission_checker()){
            $this->load->library('common');
            $data['checking_list'] =  $this->Dashboard_model->get_today_checkin_list($this->config_manager->user_date_format);
            $data['checking_out']  =  $this->Dashboard_model->get_today_checkout_list($this->config_manager->user_date_format);
            $data['trevenue']      =  $this->Dashboard_model->get_todays_revenue();
            $data['total_rooms']   =  $this->Dashboard_model->get_total_rooms();
            $data['total_guest']   =  $this->Dashboard_model->get_total_guest();
            $data['css'] = array(
                'assets/admin/css/jquery.dataTables.min.css',
                'assets/admin/css/responsive.dataTables.min.css',
                'assets/css/dialog.css',
                'assets/admin/css/morris.css'
            );
            $data['js'] = array(
                'assets/admin/js/jquery.dataTables.min.js',
                'assets/admin/js/responsive.dataTables.min.js',
                'assets/js/dialog.js',
                'assets/admin/js/app.js',
                'assets/admin/js/raphael.min.js',
                'assets/admin/js/morris.min.js',
                'assets/admin/js/app_report.js'
            );

            $this->load->view('dashboard/header', $data);
            $this->load->view('dashboard/index', $data);
            $this->load->view('dashboard/footer', $data);
        }else{
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/permission_error');
            $this->load->view('dashboard/footer');           
        }
    }

    public function payment_gateway(){
        $data['payment_getways'] =  $this->Dashboard_model->get_payment_getways();
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/payment_gateway', $data);
        $this->load->view('dashboard/footer');
    }

    public function get_payment_single($payment_method_id){
        if($this->Dashboard_model->get_verified_payment_method_id($this->hasher->decrypt($payment_method_id))){
            $data['payment_method'] = $this->db->get_where('payment_gateway', array('id' => $this->hasher->decrypt($payment_method_id)))->row();
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/payment_single', $data);
            $this->load->view('dashboard/footer');
        }else{
            $this->session->set_flashdata('error','Sorry! Payment method  does not exist!');
            redirect('dashboard/payment_gateway', 'refresh');
        }
    }

    public function update_payment_settings(){
        $settings   = $this->input->post('settings', TRUE);
        $method_id  = $this->input->post('id', TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

        $this->form_validation->set_rules('settings', 'Settings', 'trim|required');

        if ($this->form_validation->run() == FALSE){
            redirect('dashboard/get_payment_single/'.$method_id, 'refresh');
        }else{
            $form_data['account'] =  $settings;
            $this->db->where('id', $this->hasher->decrypt($method_id));
            $this->db->update('payment_gateway', $form_data);

            $this->session->set_flashdata('success','Payment method has been updated successfully!');
            redirect('dashboard/payment_gateway', 'refresh');
        }

    }

    public function customer_lookup(){
        $data['css'] = array(
            'assets/admin/css/jquery.dataTables.min.css',
            'assets/admin/css/responsive.dataTables.min.css'
        );
        $data['js'] = array(
            'assets/admin/js/jquery.dataTables.min.js',
            'assets/admin/js/responsive.dataTables.min.js',
            'assets/admin/js/app.js'
        );
        $data['clients'] =  $this->Dashboard_model->get_clients();
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/customer_lookup', $data);
        $this->load->view('dashboard/footer', $data);
    }

    public function booking_list_by_client($client_id){
        $query = $this->db->query(
            "SELECT booking_id, DATE_FORMAT(start_date, '".$this->config_manager->user_date_format."') 
            AS start_date, DATE_FORMAT(end_date, '".$this->config_manager->user_date_format."')
            AS end_date, end_date as checkout, total_cost, DATE_FORMAT(booking_time, '".$this->config_manager->user_date_format."')
            AS booking_time, payment_type, is_deleted, is_block  
            FROM app_bookings 
            WHERE client_id=".$this->hasher->decrypt($client_id)
        );

        $data['css'] = array(
            'assets/admin/css/jquery.dataTables.min.css',
            'assets/admin/css/responsive.dataTables.min.css',
            'assets/css/dialog.css'
        );
        $data['js'] = array(
            'assets/admin/js/jquery.dataTables.min.js',
            'assets/admin/js/responsive.dataTables.min.js',
            'assets/js/dialog.js',
            'assets/admin/js/app.js'
        );
        $data['booking_list_client'] = $query->result();
        $data['client'] = $this->Dashboard_model->get_client_by_id($this->hasher->decrypt($client_id));
        $this->load->view('dashboard/header',  $data);
        $this->load->view('dashboard/client_booking_list', $data);
        $this->load->view('dashboard/footer',  $data);
    }

    public function booking(){
        if($_POST){
        $this->load->library('common');
        $book_type     = $this->input->post('book_type', TRUE);
        $startdate     = $this->input->post('startdate', TRUE);
        $closingdate   = $this->input->post('closingdate', TRUE);
        $shortby       = $this->input->post('shortby', TRUE);

        if($startdate != "" &&  $closingdate != ""){
            $condition  = " AND (DATE_FORMAT(".$shortby.", '%Y-%m-%d') between '".$this->config_manager->get_mysql_date($startdate)."' AND '".$this->config_manager->get_mysql_date($closingdate)."')";
            $shortbyarr = array(
                "booking_time" => "Booking date", 
                "start_date"   => "Check-in date", 
                "end_date"     => "Check-out date"
            );
            $text_cond  ="<span class=\"txt-orange counter-anim data-rep selectdates\">". $startdate ."</span>"."  <i class=\"ti ti-arrow-right\"></i>"."  <span class=\"txt-orange counter-anim data-rep\">".$closingdate."</span>"."  <i class=\"ti ti-arrow-right\"></i>"." <span class=\"txt-orange counter-anim data-rep\">".$shortbyarr[$shortby]."</span>";
        }else{
            $condition="";
            $text_cond="";
        }

        $title = array(
            1 => "Active",
            2 => "History"
        );

        switch($book_type){
			case 1:
			$sql = "SELECT booking_id,payment_success, DATE_FORMAT(start_date, '".$this->config_manager->user_date_format."') AS start_date, DATE_FORMAT(end_date, '".$this->config_manager->user_date_format."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$this->config_manager->user_date_format."') AS booking_time, payment_type, client_id  FROM app_bookings where payment_success=true and CURDATE() <= end_date and is_deleted=false and is_block=false  ".$condition." ";
			break;
		
			case 2:
			$sql = "SELECT booking_id,payment_success, DATE_FORMAT(start_date, '".$this->config_manager->user_date_format."') AS start_date, DATE_FORMAT(end_date, '".$this->config_manager->user_date_format."') AS end_date, total_cost, DATE_FORMAT(booking_time, '".$this->config_manager->user_date_format."') AS booking_time, payment_type, client_id, is_deleted  FROM app_bookings where payment_success=true and (CURDATE() > end_date OR is_deleted=true)  and is_block=false ".$condition." ";
			break;
			
			case 3:
			$sql = "SELECT booking_id,payment_success,  DATE_FORMAT(start_date, '".$this->config_manager->user_date_format."') AS start_date, DATE_FORMAT(end_date, '".$this->config_manager->user_date_format."') AS end_date, end_date as checkout, total_cost, DATE_FORMAT(booking_time, '".$this->config_manager->user_date_format."') AS booking_time, payment_type, is_deleted, is_block  FROM app_bookings where client_id=0";
			break;
		}
        $query = $this->db->query($sql);
        $data['rooms'] = $query->result();
        $data['text_cond'] =  $text_cond;
        $data['title'] =  $title[$book_type];
        
        $data['css'] = array(
            'assets/admin/css/tempusdominus.css', 
            'assets/css/dialog.css',
            'assets/admin/css/jquery.dataTables.min.css',
            'assets/admin/css/responsive.dataTables.min.css'
        );
        $data['js']  = array(
            'assets/js/moment.min.js', 
            'assets/js/jquery.validate.js', 
            'assets/admin/js/tempusdominus.js', 
            'assets/js/dialog.js',
            'assets/admin/js/jquery.dataTables.min.js',
            'assets/admin/js/responsive.dataTables.min.js',
            'assets/admin/js/app.js'
        );

        $this->load->view('dashboard/header',  $data);
        $this->load->view('dashboard/booking', $data);
        $this->load->view('dashboard/footer',  $data);
       }else{
           $data['css'] = array('assets/admin/css/tempusdominus.css');
           $data['js']  = array('assets/js/moment.min.js', 'assets/js/jquery.validate.js', 'assets/admin/js/tempusdominus.js', 'assets/admin/js/app.js');
           $this->load->view('dashboard/header',  $data);
           $this->load->view('dashboard/booking');
           $this->load->view('dashboard/footer',  $data);
       }
    }

    public function report_financial(){
        $data['css'] = array(
            'assets/admin/css/morris.css'
        );
        $data['js'] = array(
            'assets/admin/js/raphael.min.js',
            'assets/admin/js/morris.min.js',
            'assets/admin/js/app_report.js'
        );
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/report_financial');
        $this->load->view('dashboard/footer', $data);
    }

    public function report_booking(){
        $data['css'] = array(
            'assets/admin/css/morris.css'
        );
        $data['js'] = array(
            'assets/admin/js/raphael.min.js',
            'assets/admin/js/morris.min.js',
            'assets/admin/js/app_report.js'
        );
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/report_booking');
        $this->load->view('dashboard/footer', $data);
    }

    public function room_block(){
        if($this->__permission_checker()){
            $this->load->library('common');
            $data['css'] = array(
                'assets/admin/css/jquery.dataTables.min.css',
                'assets/admin/css/responsive.dataTables.min.css',
                'assets/css/dialog.css'
            );
            $data['js'] = array(
                'assets/admin/js/jquery.dataTables.min.js',
                'assets/admin/js/responsive.dataTables.min.js',
                'assets/js/dialog.js',
                'assets/admin/js/app.js'
            );
            $this->load->view('dashboard/header', $data);
            $this->load->view('dashboard/room_block');
            $this->load->view('dashboard/footer', $data);
        }else{
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/permission_error');
            $this->load->view('dashboard/footer');           
        }
    }

    public function create_room_block(){
        if($this->__permission_checker()){
            if(isset($_POST['search'])){
                $this->load->library('block');
            }
            $data['css'] = array('assets/admin/css/tempusdominus.css');
            $data['js']  = array('assets/js/moment.min.js', 'assets/admin/js/tempusdominus.js', 'assets/admin/js/app.js');
            $this->load->view('dashboard/header', $data);
            $this->load->view('dashboard/create_room_block', $data);
            $this->load->view('dashboard/footer', $data);
        }else{
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/permission_error');
            $this->load->view('dashboard/footer');           
        }
    }

    public function update_room_block(){

        $block_name   = $this->input->post('block_name', TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

        $this->form_validation->set_rules('block_name', 'Description', 'trim|required');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','Description is required  !');
            redirect('dashboard/create_room_block', 'refresh');
        }else{
            $this->load->library('block');
            $this->load->library('receipt');
            $this->receipt->generate_blocking_details();
            $reservationdata = array();
            $reservationdata = $_SESSION['dvars_details'];
            $bookingId       = time();
            $this->db->query("INSERT INTO app_bookings (booking_id, booking_time, start_date, end_date, client_id, is_block, payment_success, block_name) values(".$bookingId.", NOW(), '".$_SESSION['sv_mcheckindate']."', '".$_SESSION['sv_mcheckoutdate']."', '0', 1, 1, '".$block_name."')");
            foreach($reservationdata as $revdata){
                foreach($revdata['availablerooms'] as $rooms){
                    $this->db->query("INSERT INTO app_reservation (bookings_id, room_id, room_type_id) values(".$bookingId.",  ".$rooms['roomid'].", ".$revdata['roomtypeid'].")");
                }
            }
            $this->session->set_flashdata('success','Room bloking has been created successfully!');
            redirect('dashboard/room_block', 'refresh');
        }
    }

    public function calendar(){
        $data['js'] = array(
            'assets/js/moment.min.js',
            'assets/admin/js/fullcalendar.js',
            'assets/admin/js/calendar.js'
        );

        $data['css'] = array(
            'assets/admin/css/fullcalendar.css'
        );

        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/calendar');
        $this->load->view('dashboard/footer', $data);
    }

    public function gallery(){
        $data['js'] = array(
            'assets/js/dialog.js',
            'assets/admin/js/app.js'
        );

        $data['css'] = array(
            'assets/css/dialog.css'
        );
        $data['room_type'] =  $this->Dashboard_model->get_roomtype();
        $data['capacity']  =  $this->Dashboard_model->get_capacity();
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/gallery', $data);
        $this->load->view('dashboard/footer', $data);       
    }

    public function create_gallery(){
        $data['js'] = array(
            'assets/orakuploader/jquery-ui.min.js',
            'assets/orakuploader/orakuploader.js',
            'assets/js/dialog.js',
            'assets/admin/js/app.js'
        );

        $data['css'] = array(
            'assets/orakuploader/orakuploader.css',
            'assets/css/dialog.css'
        );

        $data['room_type'] =  $this->Dashboard_model->get_roomtype();
        $data['capacity']  =  $this->Dashboard_model->get_capacity();
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/create_gallery', $data);
        $this->load->view('dashboard/footer', $data); 
    }

    public function create_gallery_with_images(){
        $rmtype_with_capacity = $this->input->post('roomtype_with_capacity', TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');
        $this->form_validation->set_rules('roomtype_with_capacity','School groups','required|callback_check_roomtype_selection');
        $this->form_validation->set_message('check_roomtype_selection', 'You need to select a least one room type');

        if ($this->form_validation->run() == FALSE){
            $this->create_gallery();
        }else{

            $rmtype_with_capacity_array = explode('#',$rmtype_with_capacity);
            $room_type_id = $rmtype_with_capacity_array[0]; 
            $capacity_id = $rmtype_with_capacity_array[1];
            
            if (isset($_POST['room_image']) && count($_POST['room_image']) > 0) {
                $valid_formats = array("jpg", "jpeg", 'png');
                $countScreen = 0;
                foreach ($_POST['room_image'] as $name) {
                    $filename = stripslashes($name);
                    $ext = get_extension($filename);
                    $ext = strtolower($ext);
                    if (!empty($filename)) {
                        if (in_array($ext, $valid_formats)) {
                        } else {
                              $this->session->set_flashdata('error','Please selec a valid image');
                              redirect('dashboard/create_gallery', 'refresh');
                        }
                        if ($countScreen == 0)
                            $item_screen = $filename;
                        elseif ($countScreen >= 1)
                            $item_screen = $item_screen . "," . $filename;
                        $countScreen++;
                    }
                }
                $form_data['roomtype_id']  = $room_type_id;
                $form_data['capacity_id']  = $capacity_id;
                $form_data['img_path']     = $item_screen;
                $this->Dashboard_model->create_gallery($form_data);
                $this->session->set_flashdata('success','Images has been added successfully!');
                redirect('dashboard/create_gallery', 'refresh');
            }else{
                $this->session->set_flashdata('error','Images is required');
                redirect('dashboard/create_gallery', 'refresh');               
            }
               
        }

    }

    function check_roomtype_selection($post_string){
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    public function capacity(){
        if($this->__permission_checker()){

            $data['css'] = array(
                'assets/admin/css/jquery.dataTables.min.css',
                'assets/admin/css/responsive.dataTables.min.css',
                'assets/css/dialog.css'
            );
            $data['js'] = array(
                'assets/admin/js/jquery.dataTables.min.js',
                'assets/admin/js/responsive.dataTables.min.js',
                'assets/js/dialog.js',
                'assets/admin/js/app.js'
            );

            $data['capacity'] =  $this->Dashboard_model->get_capacity();
            $this->load->view('dashboard/header', $data);
            $this->load->view('dashboard/capacity', $data);
            $this->load->view('dashboard/footer', $data);
        }else{
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/permission_error');
            $this->load->view('dashboard/footer');           
        }
    }

    public function get_capacity_by_id($capacity_id){
        $data['capacity'] = $this->Dashboard_model->get_capacity_by_id($this->hasher->decrypt($capacity_id));
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/capacity_single', $data);
        $this->load->view('dashboard/footer');

    }

    public function update_capacity(){
        $capacity_title   = $this->input->post('capacity_title', TRUE);
        $no_adult         = $this->input->post('no_adult', TRUE);
        $capacity_id      = $this->input->post('capacity_id', TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

        $this->form_validation->set_rules('capacity_title', 'Title', 'trim|required');
        $this->form_validation->set_rules('no_adult', 'Adults', 'trim|required');

        if ($this->form_validation->run() == FALSE){
            $this->get_capacity_by_id($capacity_id);
        }else{
            $form_data['title']    = $capacity_title;
            $form_data['capacity'] = $no_adult;
            $this->Dashboard_model->update_capacity($form_data, $this->hasher->decrypt($capacity_id));
            $this->session->set_flashdata('success','Capacity has been updated successfully!');
            redirect('dashboard/capacity');
        }

    }

    public function room_type(){
        $this->load->helper('text');
        $data['css'] = array(
            'assets/admin/css/jquery.dataTables.min.css',
            'assets/admin/css/responsive.dataTables.min.css',
            'assets/css/dialog.css'
        );
        $data['js'] = array(
            'assets/admin/js/jquery.dataTables.min.js',
            'assets/admin/js/responsive.dataTables.min.js',
            'assets/js/dialog.js',
            'assets/admin/js/app.js'
        );
        
       $data['room_type'] =  $this->Dashboard_model->get_roomtype();
       $this->load->view('dashboard/header', $data);
       $this->load->view('dashboard/room_type', $data);
       $this->load->view('dashboard/footer', $data);
    }

    public function create_roomtype(){
        $roomtype_title   = $this->input->post('roomtype_title', TRUE);
        $description      = $this->input->post('description', TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

        $this->form_validation->set_rules('roomtype_title', 'Type title', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');

        if ($this->form_validation->run() == FALSE){
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/create_roomtype');
            $this->load->view('dashboard/footer');
        }else{
            $form_data['type_name'] = $roomtype_title;
            $form_data['description'] = $description;
            $this->Dashboard_model->create_roomtype($form_data);
            $this->session->set_flashdata('success','Room type has been created successfully!');
            redirect('dashboard/room_type', 'refresh');
        }
    }

    public function get_roomtype_by_id($roomtype_id){
        if($this->Dashboard_model->get_verified_roomtype_id($this->hasher->decrypt($roomtype_id))){
            $data['room_type'] = $this->Dashboard_model->get_room_type_by_id($this->hasher->decrypt($roomtype_id));
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/roomtype_single', $data);
            $this->load->view('dashboard/footer');
        }else{
            $this->session->set_flashdata('error','No matching records found!');
            redirect('dashboard/room_type', 'refresh');
        }
    }

    public function update_roomtype(){
        $roomtype_title   = $this->input->post('roomtype_title', TRUE);
        $description      = $this->input->post('description', TRUE);
        $roomtype_id      = $this->input->post('roomtype_id', TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

        $this->form_validation->set_rules('roomtype_title', 'Type title', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');

        if ($this->form_validation->run() == FALSE){
            $this->get_roomtype_by_id($roomtype_id);
        }else{
            $form_data['type_name']   = $roomtype_title;
            $form_data['description'] = $description;
            $this->Dashboard_model->update_roomtype($form_data, $this->hasher->decrypt($roomtype_id));
            $this->session->set_flashdata('success','Room type has been updated successfully!');
            redirect('dashboard/room_type', 'refresh');
        }
    }

    public function rooms(){
        $query = $this->db->query(
            "SELECT COUNT(*) AS NoOfRoom,app_room.roomtype_id,app_room.no_of_child,app_room.capacity_id,app_capacity.title,app_capacity.capacity,app_roomtype.type_name 
            FROM app_room 
            INNER JOIN app_roomtype
            ON app_room.roomtype_id=app_roomtype.roomtype_ID 
            INNER JOIN app_capacity 
            ON app_room.capacity_id=app_capacity.id 
            WHERE app_room.roomtype_id=app_roomtype.roomtype_ID 
            AND app_room.capacity_id=app_capacity.id 
            GROUP BY app_room.roomtype_id,app_room.capacity_id
        ");
        $resultQueryData = $query->result();
        $data['css'] = array(
            'assets/admin/css/jquery.dataTables.min.css',
            'assets/admin/css/responsive.dataTables.min.css',
            'assets/css/dialog.css'
        );
        $data['js'] = array(
            'assets/admin/js/jquery.dataTables.min.js',
            'assets/admin/js/responsive.dataTables.min.js',
            'assets/js/dialog.js',
            'assets/admin/js/app.js'
        );
        
        $data['rooms']  =   $resultQueryData;
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/rooms', $data);
        $this->load->view('dashboard/footer', $data);
    }

    public function get_room_by_id(){
        $rid     = $this->input->get('rid', TRUE);
        $cid    = $this->input->get('cid', TRUE);
        if(isset($rid) && isset($cid) &&  $rid != "" && $cid != ""){
            $query = $this->db->query(
                "SELECT COUNT(*) AS 
                NoOfRoom,app_room.roomtype_id,app_room.no_of_child,app_room.capacity_id,app_capacity.title,app_capacity.capacity,app_roomtype.type_name
                FROM app_room 
                INNER JOIN app_roomtype 
                ON app_room.roomtype_id=app_roomtype.roomtype_ID 
                INNER JOIN app_capacity 
                ON app_room.capacity_id=app_capacity.id 
                WHERE app_room.roomtype_id= '".$this->hasher->decrypt($rid)."'
                AND  app_room.capacity_id = '".$this->hasher->decrypt($cid)."'
                AND app_room.roomtype_id=app_roomtype.roomtype_ID 
                AND app_room.capacity_id=app_capacity.id 
                GROUP BY app_room.roomtype_id,app_room.capacity_id
                LIMIT 1
            ");
            if($query->num_rows()){
                $data['room'] = $query->row();
                $this->load->view('dashboard/header');
                $this->load->view('dashboard/update_rooms', $data);
                $this->load->view('dashboard/footer');               
            }else{
                $this->session->set_flashdata('error','No matching records found!');
                $this->rooms();
            }
        }else{
            $this->session->set_flashdata('error','No matching records found!');
            $this->rooms();
        }
    }

    public function update_rooms(){
        $no_of_room       = $this->input->post('no_of_room', TRUE);
        $pre_room_cnt     = $this->input->post('pre_room_cnt', TRUE);
        $roomtypeId       = $this->input->post('roomtype_id', TRUE);
        $capacityId       = $this->input->post('capacity_id', TRUE);
        $child_per_room   = $this->input->post('child_per_room', TRUE)  ? $this->input->post('child_per_room', TRUE) : 0;

        $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

        $this->form_validation->set_rules('no_of_room', 'Number of rooms', 'trim|required');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error','Number of rooms field is required!');
            $this->rooms();
        }else{
            if($pre_room_cnt != "" || $pre_room_cnt != NULL){
                if($no_of_room > $pre_room_cnt){
                    $limit = $no_of_room - $pre_room_cnt;
                    for($i=1; $i<=$limit; $i++){
                        $form_data['roomtype_id'] = $roomtypeId;
                        $form_data['room_no']     = '1';
                        $form_data['capacity_id'] = $capacityId;
                        $this->Dashboard_model->update_rooms_with_capacity($form_data);
                    }
                    $this->db->query("UPDATE app_room SET no_of_child='".$child_per_room."' WHERE roomtype_id='".$roomtypeId."' AND capacity_id='".$capacityId."'");
                    $this->session->set_flashdata('success','Room has been updated successfully!');
                    $this->rooms();
                }else{
                    $this->db->query("UPDATE app_room SET no_of_child='".$child_per_room."' WHERE roomtype_id='".$roomtypeId."' AND capacity_id='".$capacityId."'");
                    $this->session->set_flashdata('success','Room has been updated successfully!');
                    $this->rooms();               
                }
    
                if($no_of_room < $pre_room_cnt){
                    $limit = $pre_room_cnt - $no_of_room;
                    $this->db->query("DELETE FROM app_room WHERE roomtype_id=".$roomtypeId." AND capacity_id=".$capacityId." limit ".$limit);
                    $this->session->set_flashdata('success','Room has been updated successfully!');
                    $this->rooms();
                }
            }
        }
    }

    public function create_room(){

        $no_of_room        = $this->input->post('no_of_rooms', TRUE);
        $roomtypeId        = $this->input->post('roomtype_id', TRUE);
        $capacityId        = $this->input->post('capacity_id', TRUE);
        $child_per_room    = $this->input->post('child_per_room', TRUE)  ? $this->input->post('child_per_room', TRUE) : 0;

        $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

        $this->form_validation->set_rules('no_of_rooms', 'Number of Room', 'trim|required');
        $this->form_validation->set_rules('roomtype_id', 'Room Type', 'callback_check_default_roomtype');
        $this->form_validation->set_rules('capacity_id', 'Capacity', 'callback_check_default_capacity');

        if ($this->form_validation->run() == FALSE){
            $data['roomtype'] = $this->Dashboard_model->get_roomtype();
            $data['capacity'] = $this->Dashboard_model->get_capacity();
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/create_room', $data);
            $this->load->view('dashboard/footer');
        }else{
            $query = $this->db->query("SELECT * FROM app_room WHERE roomtype_id=".$roomtypeId." and capacity_id=".$capacityId);
            if(!$query->num_rows()){
                for($i=1; $i<=$no_of_room; $i++){
                    $form_data['roomtype_id'] = $roomtypeId;
                    $form_data['room_no']     = '1';
                    $form_data['capacity_id'] = $capacityId;
                    $this->Dashboard_model->update_rooms_with_child($form_data, $child_per_room);
                }
                $this->session->set_flashdata('success','Room has been created successfully!');
                redirect('dashboard/rooms', 'refresh');
            }else{
                $this->session->set_flashdata('error','Same combination  of room type  already exist');
                redirect('dashboard/rooms', 'refresh');
            }
        }

    }
    
    public function check_default_roomtype(){
        $choice = $this->input->post("roomtype_id");
        if($choice === '0') {
            $this->form_validation->set_message('check_default_roomtype', 'You need to select a least one room type');
            return false;
        } else {
            return true;
        }
    }

    public function check_default_capacity(){
        $choice = $this->input->post("capacity_id");
        if($choice === '0') {
            $this->form_validation->set_message('check_default_capacity', 'You need to select a least one capacity type');
            return false;
        } else {
            return true;
        }
    }

    public function advance_payment(){
        $data['css'] = array(
            'assets/admin/css/switchery.min.css'
        );
        $data['js'] = array(
            'assets/admin/js/switchery.min.js',
            'assets/admin/js/app.js'
        );
        $data['advance_payments'] = $this->Dashboard_model->get_advance_payment();
        $this->load->view('dashboard/header', $data);
        $this->load->view('dashboard/advance_payment', $data);
        $this->load->view('dashboard/footer', $data);
    }

    public function update_advance_payment(){
        for($j=1;$j<=12;$j++){
           $this->db->query("UPDATE `app_advance_payment` SET `deposit_percent`= ".$this->input->post($j, TRUE)."  WHERE month_num=".$j."");
        }
        $this->session->set_flashdata('success','Advance payment has been updated successfully!');
        $this->advance_payment();

    }

    public function  special_offer(){
        $data['css'] = array(
            'assets/admin/css/jquery.dataTables.min.css',
            'assets/admin/css/responsive.dataTables.min.css',
            'assets/css/dialog.css'
        );
        $data['js'] = array(
            'assets/admin/js/jquery.dataTables.min.js',
            'assets/admin/js/responsive.dataTables.min.js',
            'assets/js/dialog.js',
            'assets/admin/js/app.js'
        );
         $data['special_offer'] = $this->Dashboard_model->get_special_offer($this->config_manager->user_date_format);
         $data['room_type'] = $this->Dashboard_model->get_roomtype();
         $this->load->view('dashboard/header', $data);
         $this->load->view('dashboard/special_offer', $data);
         $this->load->view('dashboard/footer', $data);  
    }

    public function get_special_offer_by_id($id){
            $secure_id = $this->hasher->decrypt($id);
            if($this->Dashboard_model->get_verified_offer_id($secure_id)){
                $data['special_offer'] = $this->Dashboard_model->get_special_offer_by_id($this->config_manager->user_date_format, $secure_id);
                $data['rooms'] = $this->Dashboard_model->get_roomtype();
                $data['css'] = array('assets/admin/css/tempusdominus.css');
                $data['js']  = array('assets/js/moment.min.js', 'assets/admin/js/tempusdominus.js', 'assets/admin/js/app.js');
                $this->load->view('dashboard/header', $data);
                $this->load->view('dashboard/special_offer_single', $data);
                $this->load->view('dashboard/footer', $data);
            }else{
                $this->session->set_flashdata('error','No matching records found!');
                $this->special_offer();
            }
    }

    public function update_special_offer(){
        $offer_id       = $this->input->post('offer_id', TRUE);
        $offer_name     = $this->input->post('offer_name', TRUE);
        $roomtype       = $this->input->post('roomtype', TRUE);
        $startdate      = $this->input->post('startdate', TRUE);
        $closingdate    = $this->input->post('closingdate', TRUE);
        $price_deducted = $this->input->post('price_deducted', TRUE);
        $min_sty        = $this->input->post('min_sty', TRUE);
        $Start_date     = $this->config_manager->get_mysql_date($startdate);
        $End_date       = $this->config_manager->get_mysql_date($closingdate);

        $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

        $this->form_validation->set_rules('offer_name', 'Offer name', 'trim|required');
        $this->form_validation->set_rules('startdate', 'Start date', 'trim|required');
        $this->form_validation->set_rules('closingdate', 'End date', 'trim|required');
        $this->form_validation->set_rules('price_deducted', 'Price Deducted', 'trim|required');

        if ($this->form_validation->run() == FALSE){
            $this->get_special_offer_by_id($offer_id);
        }else{
            if($roomtype == "0"){
                $query = $this->db->query("SELECT * FROM app_special_offer WHERE (('".$Start_date."'  BETWEEN start_date AND  end_date) OR  ('".$End_date."' BETWEEN  start_date AND  end_date  ) OR ( start_date  BETWEEN '".$Start_date."' AND 
                '".$End_date."')  OR (end_date BETWEEN '".$Start_date."' AND '".$End_date."')) AND id!=".$this->hasher->decrypt($offer_id));
            }
            if($roomtype!='0'){
                $query = $this->db->query("SELECT * FROM app_special_offer WHERE ((room_type='0' OR room_type='".$roomtype."')   AND (('".$Start_date."'  BETWEEN start_date AND  end_date) OR  ('".$End_date."' BETWEEN  start_date and  end_date  ) OR ( start_date  BETWEEN '".$Start_date."' and 
                '".$End_date."')  OR (end_date BETWEEN '".$Start_date."' AND '".$End_date."'))) AND id!=".$this->hasher->decrypt($offer_id));
            }
            if($query->num_rows()){
                $_SESSION['val1']="1";
            }else{
                $form_data['offer_title'] = $offer_name;
                $form_data['room_type']   = $roomtype;
                $form_data['start_date']  = $Start_date;
                $form_data['end_date']    = $End_date;
                $form_data['price_deduc'] = $price_deducted;
                $form_data['min_stay']    = $min_sty;
                $this->Dashboard_model->update_special_offer($this->hasher->decrypt($offer_id), $form_data);
                $this->session->set_flashdata('success','Special offer has been updated successfully!');
                $this->special_offer();
            }
        }

    }

    public function create_special_offer(){
        if($this->__permission_checker()){

            $offer_name     = $this->input->post('offer_name', TRUE);
            $roomtype       = $this->input->post('roomtype', TRUE);
            $startdate      = $this->input->post('startdate', TRUE);
            $closingdate    = $this->input->post('closingdate', TRUE);
            $price_deducted = $this->input->post('price_deducted', TRUE);
            $min_sty        = $this->input->post('min_sty', TRUE);
            $Start_date     = $this->config_manager->get_mysql_date($startdate);
            $End_date       = $this->config_manager->get_mysql_date($closingdate);

            $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

            $this->form_validation->set_rules('offer_name', 'Offer name', 'trim|required');
            $this->form_validation->set_rules('startdate', 'Start date', 'trim|required');
            $this->form_validation->set_rules('closingdate', 'End date', 'trim|required');
            $this->form_validation->set_rules('price_deducted', 'Price Deducted', 'trim|required');


            if ($this->form_validation->run() == FALSE){
                $data['rooms'] = $this->Dashboard_model->get_roomtype();
                $data['css'] = array('assets/admin/css/tempusdominus.css');
                $data['js']  = array('assets/js/moment.min.js', 'assets/admin/js/tempusdominus.js', 'assets/admin/js/app.js');
                $this->load->view('dashboard/header', $data);
                $this->load->view('dashboard/create_special_offer', $data);
                $this->load->view('dashboard/footer', $data);
            }else{
                if($roomtype != 0){
                    $query = $this->db->query("SELECT * FROM app_special_offer WHERE (room_type='0' OR room_type='".$roomtype."')   AND (('".$Start_date."'  BETWEEN start_date AND  end_date) OR  ('".$End_date."' BETWEEN  start_date AND  end_date  ) OR ( start_date  BETWEEN '".$Start_date."' AND 
                    '".$End_date."')  OR (end_date BETWEEN '".$Start_date."' AND '".$End_date."'))");
                }
                if($roomtype == '0'){
                    $query = $this->db->query("SELECT * FROM app_special_offer WHERE ('".$Start_date."'  BETWEEN start_date AND  end_date) OR  ('".$End_date."' BETWEEN  start_date AND  end_date  ) OR ( start_date  BETWEEN '".$Start_date."' AND 
                    '".$End_date."')  OR (end_date between '".$Start_date."' and '".$End_date."')");
                   
                }

                if($query->num_rows()){
                    $_SESSION['val1']="1";
                    dump("shit");
                }else{
                    $form_data['offer_title'] = $offer_name;
                    $form_data['room_type']   = $roomtype;
                    $form_data['start_date']  = $Start_date;
                    $form_data['end_date']    = $End_date;
                    $form_data['price_deduc'] = $price_deducted;
                    $form_data['min_stay']    = $min_sty;
                    $this->Dashboard_model->create_special_offer($form_data);
                    $this->session->set_flashdata('success','Special offer has been created successfully!');
                    redirect('dashboard/special_offer', 'refresh');
                }

            }

        }else{
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/permission_error');
            $this->load->view('dashboard/footer');           
        } 
    }

    public function price_plan(){
        if($this->__permission_checker()){
            $data['roomtypes'] = $this->Dashboard_model->get_roomtype();
            $data['css'] = array('assets/css/dialog.css');
            $data['js'] = array('assets/js/dialog.js', 'assets/admin/js/app.js');
            $this->load->view('dashboard/header', $data);
            $this->load->view('dashboard/price_plan', $data);
            $this->load->view('dashboard/footer', $data);
        }else{
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/permission_error');
            $this->load->view('dashboard/footer');           
        }
    }
    
    public function price_plan_by_id(){
        if($this->__permission_checker()){
            $id          = $this->input->get('rtype', TRUE);
            $start_dt    = $this->input->get('start_dt', TRUE);
            if($id){
                if($start_dt != '0000-00-00'){
                    $query = $this->db->query("SELECT DATE_FORMAT(start_date, '".$this->config_manager->user_date_format."') AS start_date1,
                    DATE_FORMAT(end_date, '".$this->config_manager->user_date_format."') AS end_date1, start_date, end_date,roomtype_id,capacity_id,sun,mon,tue,wed,thu,fri,sat FROM `app_priceplan`
                    WHERE `plan_id`='".$id."' and start_date='".$start_dt."' and default_plan=0");
                    $row = $query->row_array();
                }else{
                    $query = $this->db->query("SELECT DATE_FORMAT(start_date, '".$this->config_manager->user_date_format."') AS start_date1,
                    DATE_FORMAT(end_date, '".$this->config_manager->user_date_format."') AS end_date1, start_date, end_date,roomtype_id,capacity_id,sun,mon,tue,wed,thu,fri,sat FROM `app_priceplan`  
                    where `plan_id`='".$id."' and start_date='".$start_dt."' and default_plan=1");
                    $row = $query->row_array();
                }

                $query2 = $this->db->query("SELECT * FROM app_roomtype WHERE roomtype_ID='".$row['roomtype_id']."'");
                $rtypeName   = $query2->row_array();

                $data['row'] = $row;
                $data['id']  = $id;
                $data['rtypeName']  = $rtypeName['type_name'];
                $data['capacity_title'] = $this->Dashboard_model->get_capacity_title_by_id($row['capacity_id']);
                $this->load->view('dashboard/header');
                $this->load->view('dashboard/update_price_plan', $data);
                $this->load->view('dashboard/footer'); 
            }else{
                $data['start_date_old']  = '0000-00-00';
                $data['roomtype_edit'] = $id;
                $data['rooms'] = $this->Dashboard_model->get_roomtype();
                $data['css'] = array('assets/admin/css/tempusdominus.css');
                $data['js'] = array('assets/js/moment.min.js', 'assets/admin/js/tempusdominus.js', 'assets/admin/js/app.js');
                $this->load->view('dashboard/header', $data);
                $this->load->view('dashboard/create_price_plan', $data);
                $this->load->view('dashboard/footer', $data); 
            }
            
        }else{
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/permission_error');
            $this->load->view('dashboard/footer');           
        }
    }

    public function price_update_with_new_price(){
        if($this->__permission_checker()){
            if($this->input->post('roomtype_edit', TRUE) > 0){
               $sun          = $this->input->post('sun', TRUE);
               $mon          = $this->input->post('mon', TRUE);
               $tue          = $this->input->post('tue', TRUE);
               $wed          = $this->input->post('wed', TRUE);
               $thu          = $this->input->post('thu', TRUE);
               $fri          = $this->input->post('fri', TRUE);
               $sat          = $this->input->post('sat', TRUE);
               $room_type_id = $this->input->post('roomtype_edit', TRUE);
               $start_date   = $this->input->post('start_date_old', TRUE);

               $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

               $this->form_validation->set_rules('sun', 'Sunday', 'trim|required');
               $this->form_validation->set_rules('mon', 'Monday', 'trim|required');
               $this->form_validation->set_rules('tue', 'Tuesday', 'trim|required');
               $this->form_validation->set_rules('wed', 'Wednesday', 'trim|required');
               $this->form_validation->set_rules('thu', 'Thursday', 'trim|required');
               $this->form_validation->set_rules('fri', 'Friday', 'trim|required');
               $this->form_validation->set_rules('sat', 'Saturday', 'trim|required');

               if ($this->form_validation->run() == FALSE){
                     redirect('dashboard/price_plan_by_id?rtype='.$room_type_id.'&start_dt='.$start_date, 'refresh');
               }else{
                    $query = $this->db->query("SELECT roomtype_id FROM app_priceplan WHERE plan_id=".$room_type_id);
                    $row = $query->row_array();
                    $_SESSION['roomtype_id'] = $row['roomtype_id'];
                    $this->Dashboard_model->update_price_plan($sun, $mon, $tue, $wed, $thu, $fri, $sat, $room_type_id);
                    $this->session->set_flashdata('success','Price plan has been updated successfully!');
                    $this->price_plan();
               }
            }
        }else{
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/permission_error');
            $this->load->view('dashboard/footer');             
        }
    }

    public function create_price_plan(){
        if($this->__permission_checker()){
            $start_date_old    = $this->input->post('start_date_old', TRUE);
            $roomtype          = $this->input->post('roomtype_id', TRUE);
            $startdate         = $this->config_manager->get_mysql_date($this->input->post('startdate', TRUE));
            $closingdate       = $this->config_manager->get_mysql_date($this->input->post('closingdate', TRUE));
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

            $this->form_validation->set_rules('priceplan', 'Priceplan', 'trim|required');

            if ($this->form_validation->run() == FALSE){
                 $this->session->set_flashdata('error','Regular Price Plan Already Exists! You can only edit Regular Price Plan');
                 redirect('dashboard/price_plan_by_id?rtype=0&start_dt=0', 'refresh');
            }else{
                if($startdate == "" && $closingdate == ""){
                    $startdate     = '0000-00-00';
                    $closingdate   = '0000-00-00';
                    $default_plan  = 1;
                    $this->session->set_flashdata('error','Regular Price Plan Already Exists! You can only edit Regular Price Plan');
                    redirect('dashboard/price_plan_by_id?rtype=0&start_dt=0', 'refresh');
                }else{
                    $startdate     = $startdate;
                    $closingdate   = $closingdate;
                    $default_plan  = 0;
                }
                
                $query = $this->db->query("SELECT * FROM app_priceplan WHERE roomtype_id=$roomtype AND (('$startdate'  BETWEEN start_date AND  end_date OR  '$closingdate' BETWEEN  start_date AND  end_date ) OR (start_date BETWEEN '$startdate' AND '$closingdate' OR end_date BETWEEN '$startdate' AND '$closingdate'))  GROUP BY roomtype_id");
                $exist = $query->num_rows();

                if(!$exist){
                    $priceplanArray = $this->input->post('priceplan', TRUE);
                    $priceplanKey = array_keys($priceplanArray);
                    for($i=0;$i<count($priceplanKey);$i++){
                        $priceplanValue = array_values($priceplanArray[$priceplanKey[$i]]);
                        if($this->db->query("INSERT INTO `app_priceplan` (`roomtype_id`, `capacity_id`, `start_date`, `end_date`, `sun`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `default_plan`) VALUES ('".$roomtype."', '".$priceplanKey[$i]."', '".$startdate."', '".$closingdate."', '".$priceplanValue[0]."', '".$priceplanValue[1]."', '".$priceplanValue[2]."', '".$priceplanValue[3]."', '".$priceplanValue[4]."', '".$priceplanValue[5]."', '".$priceplanValue[6]."', '".$default_plan."');")){
                        $_SESSION['roomtype_id'] = $roomtype;
                        }
                    }
                    $this->session->set_flashdata('success','Price plan has been created successfully!');
                    redirect('dashboard/price_plan_by_id?rtype=0&start_dt=0', 'refresh');
                }else{
                    $this->session->set_flashdata('error','Regular Price Plan Already Exists! You can only edit Regular Price Plan');
                    redirect('dashboard/price_plan_by_id?rtype=0&start_dt=0', 'refresh');
                }
            }
        }else{
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/permission_error');
            $this->load->view('dashboard/footer'); 
        }    
    }

    public function currency(){
        if($this->__permission_checker()){
            $data['currency'] = $this->Dashboard_model->get_currency();
            $data['css'] = array(
                'assets/admin/css/jquery.dataTables.min.css',
                'assets/admin/css/responsive.dataTables.min.css',
                'assets/css/dialog.css'
            );
            $data['js'] = array(
                'assets/admin/js/jquery.dataTables.min.js',
                'assets/admin/js/responsive.dataTables.min.js',
                'assets/js/dialog.js',
                'assets/admin/js/app.js'
            );
            $this->load->view('dashboard/header', $data);
            $this->load->view('dashboard/currency', $data);
            $this->load->view('dashboard/footer', $data);
        }else{
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/permission_error');
            $this->load->view('dashboard/footer'); 
        }
    }

    public function get_currency_by_id($currency_id){
        $data['currency'] = $this->Dashboard_model->get_currency_by_id($currency_id);
        $data['js'] = array('assets/dist/js/dataTables-config.js');
        $this->load->view('dashboard/header');
        $this->load->view('dashboard/update_currency', $data);
        $this->load->view('dashboard/footer', $data);
    }
    public function update_currency(){
        
            $currency_code      = $this->input->post('currency_code', TRUE);
            $currency_symbol    = $this->input->post('currency_symbol', TRUE);
            $exchange_rate      = $this->input->post('exchange_rate', TRUE);
            $default_currency   = ($this->input->post('default_currency', TRUE) == "on") ? 1 : 0;
            $currency_id        = $this->input->post('currency_id', TRUE);

            $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');

            $this->form_validation->set_rules('currency_code', 'Currency code', 'trim|required');
            $this->form_validation->set_rules('currency_symbol', 'Currency symbol', 'trim|required');
            $this->form_validation->set_rules('exchange_rate', 'Exchange rate', 'trim|required');

            if ($this->form_validation->run() == FALSE){
                $this->get_currency_by_id($currency_id);
            }else{
                $this->Dashboard_model->update_currency($currency_code, $currency_symbol, $exchange_rate, $default_currency, $currency_id);
                $this->session->set_flashdata('success','Currency has been updated successfully!');
                $this->currency();
            }


    }

    public function global_settings(){
        if($this->__permission_checker()){
            $hotel_name              = $this->input->post('hotel_name', TRUE);
            $hotel_email             = $this->input->post('hotel_email', TRUE);
            $hotel_phone             = $this->input->post('hotel_phone', TRUE);
            $notification_email      = $this->input->post('notification_email', TRUE);
            $booking_search_engine   = $this->input->post('booking_search_engine', TRUE);
            $timezone                = $this->input->post('timezone', TRUE);
            $min_night_booking       = $this->input->post('min_night_booking', TRUE);
            $date_format             = $this->input->post('date_format', TRUE);
            $room_lock               = $this->input->post('room_lock', TRUE);
            $maximum_booking_year    = $this->input->post('generate_global_years', TRUE);
            $tax_amount              = $this->input->post('tax_amount', TRUE);
            $price_inclu_tax         = ($this->input->post('price_inclu_tax', TRUE) == "on") ? 1 : 0;
            $inv_currency            = $this->input->post('inv_currency', TRUE);

            $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');
            
            $this->form_validation->set_rules('hotel_name', 'Hotel Name', 'trim|required');
            $this->form_validation->set_rules('hotel_email', 'Hotel Email', 'trim|required');
            $this->form_validation->set_rules('hotel_phone', 'Hotel Phone Number', 'trim|required');
            $this->form_validation->set_rules('notification_email', 'Notification email', 'trim|required');
            $this->form_validation->set_rules('booking_search_engine', 'Booking search engine', 'trim|required');
            $this->form_validation->set_rules('timezone', 'Timezone', 'trim|required');
            $this->form_validation->set_rules('min_night_booking', 'Minimum booking', 'trim|required');
            $this->form_validation->set_rules('date_format', 'Date Format', 'trim|required');
            $this->form_validation->set_rules('room_lock', 'Room Lock', 'trim|required');
            $this->form_validation->set_rules('generate_global_years', 'Maximum booking year', 'trim|required');
            $this->form_validation->set_rules('tax_amount', 'Tax amount', 'trim|required');

            if ($this->form_validation->run() == FALSE){
                $data['settings'] = $this->Dashboard_model->get_global_settings();
                $this->load->view('dashboard/header');
                $this->load->view('dashboard/global_settings', $data);
                $this->load->view('dashboard/footer');
            }else{
                $this->Dashboard_model->update_global_settings('conf_hotel_name', $hotel_name);
                //$this->Dashboard_model->update_global_settings('conf_hotel_email', $hotel_email);
                $this->Dashboard_model->update_global_settings('conf_hotel_phone', $hotel_phone);
                //$this->Dashboard_model->update_global_settings('conf_notification_email', $notification_email);
                $this->Dashboard_model->update_global_settings('conf_booking_turn_off', $booking_search_engine);
                $this->Dashboard_model->update_global_settings('conf_hotel_timezone', $timezone);
                $this->Dashboard_model->update_global_settings('conf_min_night_booking', $min_night_booking);
                $this->Dashboard_model->update_global_settings('conf_dateformat', $date_format);
                $this->Dashboard_model->update_global_settings('conf_booking_exptime', $room_lock);
                $this->Dashboard_model->update_global_settings('conf_price_with_tax', $price_inclu_tax);
                $this->Dashboard_model->update_global_settings('conf_maximum_global_years', $maximum_booking_year);
                $this->Dashboard_model->update_global_settings('conf_tax_amount', $tax_amount);
                $this->Dashboard_model->update_global_settings('conf_invoice_currency', $inv_currency);

                $this->session->set_flashdata('update_success','Global settings updated successfully!!');

                redirect('dashboard/global_settings', 'refresh');
            }

        }else{
            $this->load->view('dashboard/header');
            $this->load->view('dashboard/permission_error');
            $this->load->view('dashboard/footer');           
        }
    }

    private function __is_logged_in(){
        if (!$this->ion_auth->logged_in()){
			redirect('auth/login');
		}
    }

    private function __permission_checker(){
       if(!$this->ion_auth->in_group('admin')){
            return false;
       }else{
            return true;
       }
    }


}