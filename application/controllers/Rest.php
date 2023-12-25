<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rest extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model('Rest_model');       
    }

    public function create_currency(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $currency_code      = $this->input->post('currency_code', TRUE);
                $currency_symbol    = $this->input->post('currency_symbol', TRUE);
                $exchange_rate      = $this->input->post('exchange_rate', TRUE);
                $default_currency   = $this->input->post('default_currency');
                $this->Rest_model->create_currency($currency_code, $currency_symbol, $exchange_rate, $default_currency);
                $response  =  array('type' => 'success', 'message' =>  "Currency has been created successfully!!!");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }
    }

    public function delete_currency(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $currency_id   = $this->input->post('currency_id', TRUE);
                $this->Rest_model->delete_currency(base64_decode($currency_id));
                $response  =  array('type' => 'success', 'message' =>  "Currency has been deleted successfully!!!");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }        
    }

    public function delete_price_plan(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $price_plan_list       = base64_decode($this->input->post('price_plan_id', TRUE));
                $price_plan_list_item = explode("|", $price_plan_list);
                $this->db->query("DELETE FROM app_priceplan WHERE start_date='$price_plan_list_item[1]' AND end_date='$price_plan_list_item[2]' AND roomtype_id=".$price_plan_list_item[3]);
                $_SESSION['roomtype_id'] = $price_plan_list_item[3];
                $response  =  array('type' => 'success', 'message' =>  "Price plan has been deleted successfully!!!");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        } 
    }

    public function delete_special_offer(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $special_offer_id  =  $this->input->post('special_offer_id', TRUE);
                $this->Rest_model->delete_special_offer($this->hasher->decrypt($special_offer_id));
                $response  =  array('type' => 'success', 'message' =>  "Special offer has been deleted successfully!!!");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        } 
    }

    public function get_price_plan_list(){
        $errorcode	= 0;
		$strmsg	= "";
		$pphtml='';
        $roomtype_id = $this->input->post('roomtype_id', TRUE);
        
        $query = $this->db->query("SELECT start_date, end_date, DATE_FORMAT(start_date, '".$this->config_manager->user_date_format."') AS start_date1, DATE_FORMAT(end_date, '".$this->config_manager->user_date_format."') AS end_date1, default_plan FROM app_priceplan WHERE roomtype_id='".$roomtype_id."' GROUP BY start_date, end_date");
        if($query->num_rows()){
            foreach ($query->result() as $row_daterange){
                $query2 = $this->db->query("SELECT * FROM app_priceplan WHERE start_date='".$row_daterange->start_date."' AND end_date='".$row_daterange->end_date."' AND roomtype_id='".$roomtype_id."' ");
                if($row_daterange->default_plan == 1){ 
                    $pphtml.='
                    <div class="table-responsive">
                    <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>Capacity</th>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>    
                        <th>Thu</th>  
                        <th>Fri</th> 
                        <th>Sat</th>
                        <th>Manage</th>
                    </tr></thead>';	
                    
                    $daletetd = $query2->num_rows();	
                    $i1 = $daletetd;
                    foreach($query2->result() as $row_pp){
                        if($row_pp->capacity_id == 1001){
                            $captitle='Per Child'; 
                        }else{
                            $query3= $this->db->query("SELECT * FROM app_capacity WHERE id=".$row_pp->capacity_id);
                            $capacity_title = $query3->row_array();
                            $captitle = $capacity_title['title'];
                        }

                        $pphtml.='<tr>
                        <td>'.$captitle.'</td>
                        <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->sun.'</td>
                        <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->mon.'</td>
                        <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->tue.'</td>
                        <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->wed.'</td>    
                        <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->thu.'</td>  
                        <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->fri.'</td> 
                        <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->sat.'</td>
                        <td><a class="btn btn-primary btn-xs" href="'.base_url().'dashboard/price_plan_by_id?rtype='.$row_pp->plan_id.'&start_dt='.$row_pp->start_date.'">Edit</a></td></tr>';
                        $i1--;
                    }#84
                }else{
                    //<td>Date Range : '.$row_daterange->start_date.'&nbsp; To &nbsp;'.$row_daterange->end_date.'</td>
                    $pphtml.='<thead><tr>
                                <th>Capacity<span class="time"><span class="label time-range">'.$row_daterange->start_date.'</span>&nbsp To &nbsp<span class="label time-range">'.$row_daterange->end_date.'</span><span></th>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>    
                                <th>Thu</th>  
                                <th>Fri</th> 
                                <th>Sat</th>
                                <th>Manage</th>
                            </tr></thead>';
                    $daletetd = $query2->num_rows();	
                    $i1 = $daletetd;
                    foreach($query2->result() as $row_pp){
                        if($row_pp->capacity_id == 1001){
                            $captitle='Per Child'; 
                        }else{
                            $query4= $this->db->query("SELECT * FROM app_capacity WHERE id=".$row_pp->capacity_id);
                            $capacity_title = $query4->row_array();
                            $captitle = $capacity_title['title'];
                        }

                        $delete_btn_02 = '';

                        if($daletetd==$i1){
                            $pln_del = $row_pp->plan_id.'|'.$row_pp->start_date.'|'.$row_pp->end_date.'|'.$row_pp->roomtype_id;
                            $pln_del = base64_encode($pln_del);
                            //$pphtml.='<td align="center" width="90px" rowspan="'.$daletetd.'" style="padding-left:10px;"><b><font color="#666666"  face="Verdana, Arial, Helvetica, sans-serif" size="1"> <a href="javascript:;" onclick="return priceplandelete(\''.$pln_del.'\');">'.DELETE_ROOM_LIST.'</a></font></b></td>';
                            $delete_btn_02 = '<button class="btn btn-default btn-xs" id="delete_price_plan" data-id="'.$pln_del.'">Delete</button>';
                        }

                        $pphtml.='<tr>
                                <td>'.$captitle.'</td>
                                <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->sun.'</td>
                                <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->mon.'</td>
                                <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->tue.'</td>
                                <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->wed.'</td>    
                                <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->thu.'</td>  
                                <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->fri.'</td> 
                                <td>'.$this->config_manager->get_default_currency_symbol().$row_pp->sat.'</td>
                                <td><a class="btn btn-primary btn-xs" href="'.base_url().'dashboard/price_plan_by_id?rtype='.$row_pp->plan_id.'&start_dt='.$row_pp->start_date.'">Edit</a>'. $delete_btn_02.'</td></tr>';

                        $pphtml.='</tr>';								
                        $i1--;
                    }
                }				   
            }//#65
            header("Content-type: application/json");	
            echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$pphtml));	
        }else{
            $errorcode	= 1;
            $strmsg	= "No  data found !";
            header("Content-type: application/json");	
            echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$strmsg));	
        }
    }

    public function get_default_capacity(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $errorcode = 0;
		        $strmsg = "";
                $roomtype_id   = $this->input->post('roomtype_id', TRUE);
                $query = $this->db->query("SELECT * FROM app_capacity");
                if($query->num_rows()){
                    $capacity_input_box = 
                    '<table class="table  table-bordered">
                        <tr>
                            <td>CAPACITY</td>
                            <td>SUN</td>
                            <td>MON</td>
                            <td>TUE</td>
                            <td>WED</td>
                            <td>THU</td>
                            <td>FRI</td>
                            <td>SAT</td>
                        </tr>';
                        foreach($query->result() as $row){
                            $query2 = $this->db->query("SELECT * FROM `app_priceplan` WHERE roomtype_id='".$roomtype_id."' and capacity_id='".$row->id."'");	
                            if($query2->num_rows()){
                                $capacity_input_box.=
                                        '<tr>
                                            <td>'.$row->title.' ('.$row->capacity.') &nbsp;</td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][sun]" id="priceplan['.$row->id.'][sun]"  size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][mon]" id="priceplan['.$row->id.'][mon]"  size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][tue]" id="priceplan['.$row->id.'][tue]"  size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][wed]" id="priceplan['.$row->id.'][wed]"  size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][thu]" id="priceplan['.$row->id.'][thu]"  size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][fri]" id="priceplan['.$row->id.'][fri]"  size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][sat]" id="priceplan['.$row->id.'][sat]"  size="4" /></td>
                                        </tr>';
                            }else{
                                $capacity_input_box.=
				                        '<tr>
                                            <td>'.$row->title.' ('.$row->capacity.') &nbsp;</td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][sun]" id="priceplan['.$row->id.'][sun]" size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][mon]" id="priceplan['.$row->id.'][mon]" size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][tue]" id="priceplan['.$row->id.'][tue]" size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][wed]" id="priceplan['.$row->id.'][wed]" size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][thu]" id="priceplan['.$row->id.'][thu]" size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][fri]" id="priceplan['.$row->id.'][fri]" size="4" /></td>
                                            <td><input type="text" class="form-control"  name="priceplan['.$row->id.'][sat]" id="priceplan['.$row->id.'][sat]" size="4" /></td>
                                        </tr>';
                            }
                        }

                        $capacity_input_box.=
                            '<tr>
                                <td>Per Child</td>
                                <td><input type="text" class="form-control"  name="priceplan[1001][sun]" id="priceplan[1001][sun]" size="4" /></td>
                                <td><input type="text" class="form-control"  name="priceplan[1001][mon]" id="priceplan[1001][mon]" size="4" /></td>
                                <td><input type="text" class="form-control"  name="priceplan[1001][tue]" id="priceplan[1001][tue]" size="4" /></td>
                                <td><input type="text" class="form-control"  name="priceplan[1001][wed]" id="priceplan[1001][wed]" size="4" /></td>
                                <td><input type="text" class="form-control"  name="priceplan[1001][thu]" id="priceplan[1001][thu]" size="4" /></td>
                                <td><input type="text" class="form-control"  name="priceplan[1001][fri]" id="priceplan[1001][fri]" size="4" /></td>
                                <td><input type="text" class="form-control"  name="priceplan[1001][sat]" id="priceplan[1001][sat]" size="4" /></td>
                            </tr>';

                          $capacity_input_box.='</table><input class="btn btn-primary" type="submit" id="submit-priceplan" value="Add"/>';
                          header("Content-type: application/json");		
                          echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$capacity_input_box));			
                }else{
                    $errorcode = 1;
                    $strmsg = "Sorry! Room Type does not exist!";
                    header("Content-type: application/json");		
			        json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
                }
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }      
    }

    public function delete_room(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $roomtype_id  =  $this->input->post('roomtype_id', TRUE);
                $capacity_id  =  $this->input->post('capacity_id', TRUE);
                $this->Rest_model->delete_room($this->hasher->decrypt($roomtype_id), $this->hasher->decrypt($capacity_id));
                $response  =  array('type' => 'success', 'message' =>  "Room has been deleted successfully!!!");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }        
    }

    public function delete_roomtype(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $roomtype_id  =  $this->input->post('roomtype_id', TRUE);
                $this->Rest_model->delete_roomtype($this->hasher->decrypt($roomtype_id));
                $response  =  array('type' => 'success', 'message' =>  "Room type has been deleted successfully!!!");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }        
    }

    public function  create_roomtype(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){

                $roomtype_title   = $this->input->post('roomtype_title', TRUE);
                $description      = $this->input->post('description', TRUE);
                
                $this->form_validation->set_error_delimiters('<div class="alert alert-info alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-info-outline"></i>', '</div>');
        
                $this->form_validation->set_rules('roomtype_title', 'Type title', 'trim|required');
                $this->form_validation->set_rules('description', 'Description', 'trim|required');
        
                if ($this->form_validation->run() == FALSE){
                    $response  =  array('type' => 'error', 'message' =>  "Some errors");
                    header("Content-type: application/json");	
                    echo json_encode($response); 
                }else{
                    $form_data['type_name'] = $roomtype_title;
                    $form_data['description'] = $description;
                    $this->Rest_model->create_roomtype($form_data);
                    $response  =  array('type' => 'success', 'message' =>  "Room type has been created successfully!");
                    header("Content-type: application/json");	
                    echo json_encode($response); 
                }
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }        
    }

    public function create_capacity(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){

                $capacity_title   = $this->input->post('capacity_title', TRUE);
                $no_adult        =  $this->input->post('no_adult', TRUE);

                $this->form_validation->set_rules('capacity_title', 'Title', 'trim|required');
                $this->form_validation->set_rules('no_adult', 'no_adult', 'trim|required');

                if ($this->form_validation->run() == FALSE){
                    $response  =  array('type' => 'error', 'message' =>  "Some errors");
                    header("Content-type: application/json");	
                    echo json_encode($response);                    
                }else{
                    $form_data['title']    = $capacity_title;
                    $form_data['capacity'] = $no_adult;
                    $this->Rest_model->create_capacity($form_data);
                    $response  =  array('type' => 'success', 'message' =>  "Capacity has been created successfully!!!");
                    header("Content-type: application/json");	
                    echo json_encode($response); 
                }
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }            
    }

    public function delete_capacity(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $capacity_id  =  $this->input->post('capacity_id', TRUE);
                $this->Rest_model->delete_capacity($this->hasher->decrypt($capacity_id));
                $response  =  array('type' => 'success', 'message' =>  "Capacity  has been deleted successfully!!!");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }         
    }

    public function get_capacity(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){

                $rmtype_with_capacity_array = array();

                $combine_room_cap  =  $this->input->get('room_cap_id', TRUE);

                $rmtype_with_capacity_array = explode('#', $combine_room_cap);

                $roomtype_id = $rmtype_with_capacity_array[0]; 

                $capacity_id = $rmtype_with_capacity_array[1];

                $data['capacity'] = $this->Rest_model->get_capacity_roomtype_by_id($roomtype_id, $capacity_id);

                if($data){
                    $response  =  array('type' => 'success', 'message' =>   $data);
                    header("Content-type: application/json");	
                    echo json_encode($response);
                }else{
                    $response  =  array('type' => 'error', 'message' =>  "No data found");
                    header("Content-type: application/json");	
                    echo json_encode($response); 
                }
 
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }        
    }

    public function get_rooms(){

        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){

                $room_array = array();

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

                foreach($query->result() as $room){
                    $r = new stdClass();
                    $r->id = $room->roomtype_id;
                    $r->name =  $room->type_name;
                    $r->capacity = $room->capacity;
                    $room_array[] = $r;
                }

                $response  =  array('type' => 'success', 'message' =>  $room_array);
                header("Content-type: application/json");	
                echo json_encode($response); 
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }  
    }

    public function delete_image(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $picture_id     = $this->input->post('picture_id', TRUE);
                $picture_name   = $this->input->post('picture_name', TRUE);
                $dbimages       = $this->Rest_model->get_image_by_id($picture_id);
                $image_array    = explode(',', $dbimages->img_path);
                if(count($image_array) == 1){
                    if(file_exists('assets/images/rooms/'.$picture_name)){
                        unlink('assets/images/rooms/'.$picture_name);
                        unlink('assets/images/rooms/thumbnail/'.$picture_name);
                        $this->Rest_model->delete_single_image($picture_id);
                        $response  =  array('type' => 'success', 'message' =>  "Image has been deleted successfully!!!");
                        header("Content-type: application/json");	
                        echo json_encode($response);
                    }else{
                        $response  =  array('type' => 'error', 'message' =>  "The file does not exist");
                        header("Content-type: application/json");	
                        echo json_encode($response);
                    }
                }else{
                $pos = '';
                $pos = array_search($picture_name, $image_array);
                if ($pos !== false){
                    unlink("assets/images/rooms/".$image_array[$pos]);
                    unlink("assets/images/rooms/thumbnail/".$image_array[$pos]);
                    unset($image_array[$pos]);
                    $image_array2 = implode(',',$image_array);
                    $this->Rest_model->update_image($picture_id,  $image_array2);
                    $response  =  array('type' => 'success', 'message' =>  "Image has been deleted successfully!!!");
                    header("Content-type: application/json");	
                    echo json_encode($response);
                }
                
                }
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }         
    }

    public function unblock_rooms(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $booking_id   =  $this->input->post('booking_id', TRUE);
                $roomtype_id  =  $this->input->post('roomtype_id', TRUE);
                $capacity_id  =  $this->input->post('capacity_id', TRUE);

                $query = $this->db->query("SELECT count(*) AS cn FROM app_reservation WHERE  bookings_id=".$booking_id."  AND  room_type_id=".$roomtype_id." GROUP BY  room_type_id");
                $row = $query->row_array();

                if($row['cn']<=1){
                    $this->db->query("DELETE FROM app_reservation WHERE bookings_id=".$booking_id." AND room_type_id=".$roomtype_id);
                    $this->db->query("DELETE FROM app_bookings WHERE booking_id=".$booking_id."");
                }else{
                    $this->db->query("DELETE brv.* FROM `app_reservation` brv, app_room br WHERE brv.room_id=br.room_id AND brv.`room_type_id`=".$roomtype_id." AND br.capacity_id=".$capacity_id." AND brv.`bookings_id`=".$booking_id);
                    //$this->db->query("DELETE FROM app_bookings WHERE booking_id=".$booking_id."");
                }
                $response  =  array('type' => 'success', 'message' =>  "Room has been unblocked successfully!!!");
                header("Content-type: application/json");	
                echo json_encode($response);
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }         
    }

    public function advance_payment_switcher(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $status    =  ($this->input->post('status', TRUE) == 1) ? "0" : "1";
                $form_data['conf_value'] = $status;
                $this->Rest_model->advance_payment_switcher($form_data);
                if($status === 1){
                    $response  =  array('type' => 'success', 'message' =>  "Payment has been disabled successfully!!!");
                    header("Content-type: application/json");	
                    echo json_encode($response); 
                }else{
                    $response  =  array('type' => 'success', 'message' =>  "Payment has been enabled successfully!!!");
                    header("Content-type: application/json");	
                    echo json_encode($response);                    
                }                
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }         
    }

    public function get_room_week_report(){
        $this->load->model('Report_model');
        $data['weekdata']	=	array();
        $weekstart	=	date("Y-m-d", strtotime("- 6 DAYS"));
        $wbegin = new DateTime($weekstart);
        $wend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
        $winterval = DateInterval::createFromDateString('1 day');
        $wperiod = new DatePeriod($wbegin, $winterval, $wend);
        $i=0;
        
        foreach($wperiod as $dt){
            $date		=	 $dt->format( "Y-m-d" );	
            $dayno		=	 $dt->format( "N" );
            $day		=	 $dt->format( "D" );
            $day		=	strtolower($day);
            $weekdata	=	$this->Report_model->get_week_booking_report($date);
            $data['weekdata'][$i]['date']	=	date('d M', strtotime($date));
            $data['weekdata'][$i]['booking']	=	@$weekdata->total;
        $i++;
        }
        
        header("Content-type: application/json");	
        echo json_encode($data);
    }

    public function get_room_month_report(){
        $this->load->model('Report_model');
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $data['monthdata']	=	array();
                $mbegin             = new DateTime(date("Y-m-d", strtotime("- 30 DAYS")));
                $mend               = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
                $minterval          = DateInterval::createFromDateString('1 day');
                $mperiod            = new DatePeriod($mbegin, $minterval, $mend);
                $i=0;
                foreach($mperiod as $dt){
                    $date		=	 $dt->format( "Y-m-d" );	
                    $dayno		=	 $dt->format( "N" );
                    $day		=	 $dt->format( "D" );
                    $day		=	strtolower($day);
                    $monthdata	=	$this->Report_model->get_week_booking_report($date);
                    $data['monthdata'][$i]['date']	=	date('d M', strtotime($date));
                    $data['monthdata'][$i]['booking']	=	@$monthdata->total;
                $i++;
                }
                $response  =  array('type' => 'success', 'message' =>  $data);
                header("Content-type: application/json");	
                echo json_encode($response);                
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }  
    }

    public function get_room_year_report(){
        $this->load->model('Report_model');
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $data['yeardata']	=	array();
                $start = $month = strtotime("- 365 days");
				$end = strtotime('+ 1 day');
                $i=0;
                while($month < $end){
                    $month = strtotime("+1 month", $month);
                     $Y	= date('Y', $month);
                     $M	= date('m', $month);
                    $yeardata	=	$this->Report_model->get_year_booking_report($Y,$M); 
                    $data['yeardata'][$i]['date']	    =	date('M', $month)." ".date('Y', $month);
                    $data['yeardata'][$i]['booking']	=	@$yeardata->total;
                    $i++;	 
                }                        
                $response  =  array('type' => 'success', 'message' =>  $data);
                header("Content-type: application/json");	
                echo json_encode($response);                
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }  
    }

    public function get_financial_week_report(){
        $this->load->model('Report_model');
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $data['weekdata']	=	array();
                $weekstart	=	date("Y-m-d", strtotime("- 6 DAYS"));
                $wbegin = new DateTime($weekstart);
                $wend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
                
                $winterval = DateInterval::createFromDateString('1 day');
                $wperiod = new DatePeriod($wbegin, $winterval, $wend);
                $i=0;
                foreach($wperiod as $dt){
                    $date		=	 $dt->format( "Y-m-d" );	
                    $dayno		=	 $dt->format( "N" );
                    $day		=	 $dt->format( "D" );
                    $day		=	strtolower($day);
                    $weekdata	=	$this->Report_model->get_this_date_financial($date);
                    $data['weekdata'][$i]['date']	=	date('d M', strtotime($date));
                    $data['weekdata'][$i]['total']	=	@$weekdata->total;
                $i++;
                }                     
                $response  =  array('type' => 'success', 'message' =>  $data);
                header("Content-type: application/json");	
                echo json_encode($response);                
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        } 


    }

    public function get_financial_month_report(){
        $this->load->model('Report_model');
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $data['monthdata']	=	array();

                $mbegin = new DateTime(date("Y-m-d", strtotime("- 30 DAYS")));
                $mend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
                
                $minterval = DateInterval::createFromDateString('1 day');
                $mperiod = new DatePeriod($mbegin, $minterval, $mend);
                $i=0;
                
                foreach($mperiod as $dt){
                    $date		=	 $dt->format( "Y-m-d" );	
                    $dayno		=	 $dt->format( "N" );
                    $day		=	 $dt->format( "D" );
                    $day		=	strtolower($day);
                    $monthdata	=	$this->Report_model->get_this_date_financial($date);
                    $data['monthdata'][$i]['date']	=	date('M', strtotime($date));
                    $data['monthdata'][$i]['total']	=	@$monthdata->total;
                $i++;
                }	

                $response  =  array('type' => 'success', 'message' =>  $data);
                header("Content-type: application/json");	
                echo json_encode($response);                
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        } 


    }

    public function get_financial_year_report(){
        $this->load->model('Report_model');
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $data['yeardata']	=	array();
                $start = $month = strtotime("- 365 days");
                $end = strtotime('+ 1 day');
                $i=0;
                while($month < $end){
                    $month = strtotime("+1 month", $month);
                     $Y	= date('Y', $month);
                     $M	= date('m', $month);
                    $yeardata	=	$this->Report_model->get_this_year_financial($Y,$M); 
                    
                    $data['yeardata'][$i]['date']	=	date('M', $month)." ".date('Y', $month);
                    $data['yeardata'][$i]['total']	=	@$yeardata->total;
                    $i++;	 
                }
                $response  =  array('type' => 'success', 'message' =>  $data);
                header("Content-type: application/json");	
                echo json_encode($response);                
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        } 

    }

    public function get_weekly_revenue_report(){
        $this->load->model('Report_model');
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){
                $data['weekdata']	=	array();
                $weekstart	=	date("Y-m-d", strtotime("- 6 DAYS"));
                $wbegin = new DateTime($weekstart);
                $wend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
                
                $winterval = DateInterval::createFromDateString('1 day');
                $wperiod = new DatePeriod($wbegin, $winterval, $wend);
                $i=0;
                foreach($wperiod as $dt){
                    $date		=	 $dt->format( "Y-m-d" );	
                    $dayno		=	 $dt->format( "N" );
                    $day		=	 $dt->format( "D" );
                    $day		=	strtolower($day);
                    $weekdata	=	$this->Report_model->get_payment_by_date($date);
                    $data['weekdata'][$i]['date']	=	date('d M', strtotime($date));
                    $data['weekdata'][$i]['total']	=	@$weekdata->total;
                $i++;
                }                     

                $response  =  array('type' => 'success', 'message' =>  $data);
                header("Content-type: application/json");	
                echo json_encode($response);                
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        } 

    }

    public function get_calendar_events(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){      
                $calendar_events = $this->Rest_model->get_calendar_events();
                $data = array();
                foreach($calendar_events as $ce){
                    $events = new stdClass();
                    if($ce->payment_success == 1){
                        $classname = 'colorv1';
                    }else{
                        $classname = 'colorv3';
                    }
                    $events->id = $ce->booking_id;
                    $events->start = $ce->start_date;
                    $events->end = $ce->end_date;
                    $events->title = $ce->booking_id;
                    $events->className = $classname;                    
                    array_push($data, $events);
                    // $data[] = array(
                    //     'id'      => $ce->booking_id,
                    //     'title'   => $ce->booking_id,
                    //     'start'   =>  $ce->start_date,
                    //     'end'     => $ce->end_date,
                    //     'color'   => "#18b9e6"
                    // );
                       
                }
               header("Content-type: application/json");	
               echo json_encode($data);                
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }        
    }

    public function get_single_booking(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){      
                $booking_id   = $this->input->get('booking_id', TRUE);
                if($this->Rest_model->get_verified_booking_id($this->hasher->decrypt($booking_id))){
                    //$query = $this->db->query("SELECT bc.*, bb.* FROM app_bookings AS bb, app_clients AS bc WHERE  bb.client_id=bc.client_id AND booking_id=".$this->hasher->decrypt($booking_id)."");
                    $this->db->select('bookings.*, clients.*, invoice.*');
                    $this->db->from('bookings');
                    $this->db->join('clients', 'bookings.client_id = clients.client_id','inner');
                    $this->db->join('invoice', 'bookings.booking_id = invoice.booking_id','inner');
                    $this->db->where('bookings.booking_id', $this->hasher->decrypt($booking_id)); 
                    $query = $this->db->get();
                    $data =  $query->row_array();
                    $response  =  array('type' => 'success', 'message' =>  $data);
                    header("Content-type: application/json");	
                    echo json_encode($response);
                }else{
                    $this->session->set_flashdata('error','No matching records found!');
                    redirect('dashboard/booking', 'refresh');
                }                
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }        
    }

    public function delete_room_booking(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){      
                $booking_id   = $this->input->post('booking_id', TRUE);
                $this->Rest_model->delete_room_booking($this->hasher->decrypt($booking_id));
                $response  =  array('type' => 'success', 'message' =>  "Booking has been deleted successfully!!!");
                header("Content-type: application/json");	
                echo json_encode($response);
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }         
    }

    public function cancel_room_booking(){
        if ($this->ion_auth->logged_in()){
            if($this->input->is_ajax_request()){ 
                $this->load->library('common');   
                $this->load->library('mailer');     
                $booking_id   = $this->input->post('booking_id', TRUE);
                $form_data['is_deleted']  = true;
                $this->Rest_model->cancel_room_booking($this->hasher->decrypt($booking_id), $form_data);
                $customer_details =  $this->common->get_invoice_by_booking_id($this->hasher->decrypt($booking_id));
                $mailSubject = "Booking has been canceled!!";
                $mailBody = "Dear ".$customer_details['client_name'];
                //$mailBody .= $customer_details['invoice'];
                $mailBody .= "Booking has been canceled successfully!!!";
                $mailBody .= "Please contact us if you have any questions. Phone :".$this->config_manager->config['conf_hotel_phone'];
                $this->mailer->send_app_mail($customer_details['client_email'], $mailSubject,  $mailBody);
                $response  =  array('type' => 'success', 'message' =>  "Booking has been canceled successfully!!!");
                header("Content-type: application/json");	
                echo json_encode($response);
            }else{
                $response  =  array('type' => 'error', 'message' =>  "No direct script access allowed");
                header("Content-type: application/json");	
                echo json_encode($response); 
            }

		}else{
            $response  =  array('type' => 'error', 'message' =>  "Unauthorized access");
            header("Content-type: application/json");	
            echo json_encode($response); 
        }          
    }

}