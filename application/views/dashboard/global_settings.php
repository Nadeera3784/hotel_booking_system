<div class="page-wrapper">
    <div class="container">
		<div class="row heading-bg">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h5 class="txt-dark">Global Settings</h5>
			</div>
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url();?>dashboard/index">Dashboard</a></li>
					<li class="active"><span>Global Settings</span></li>
				</ol>
			</div>	
		</div>
				<!-- /Title -->
			<div class="row">
          <div class="col-sm-12">
					<?php if($this->session->flashdata('update_success')): ?>
					   <?php alert_dismissable('success', $this->session->flashdata('update_success')); ?>
          <?php endif; ?>
					<div class="panel panel-default border-panel card-view">
						<div class="panel-heading">
							<div class="pull-left">
								<h6 class="panel-title txt-dark">Global Settings</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div class="form-wrap">
								<?php $attr = array("class" => "form-horizontal");?>
								<?php echo form_open('dashboard/global_settings', $attr);?>
								       <div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="hotel_name">Hotel Name:</label>
										    <div class="col-sm-10">
												<input type="text" class="form-control" id="hotel_name:" name="hotel_name" value="<?php echo $this->config_manager->config['conf_hotel_name']; ?>" placeholder="Enter Hotel Name">
											  	<?php echo form_error('hotel_name'); ?>
										    </div>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="hotel_email">Hotel Email:</label>
										    <div class="col-sm-10">
												<input type="email" class="form-control" id="hotel_email" name="hotel_email" value="<?php echo $this->config_manager->config['conf_hotel_email']; ?>" placeholder="Enter Hotel Email">
												<span class="help-block mt-10 mb-0"><small>Note: SMTP not supported(Gmail/yahoo..).</small></span>
											  	<?php echo form_error('hotel_email'); ?>
										    </div>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="hotel_phone">Hotel Phone Number:</label>
										    <div class="col-sm-10">
												<input type="text" class="form-control" id="hotel_phone" name="hotel_phone" value="<?php echo $this->config_manager->config['conf_hotel_phone']; ?>" placeholder="Enter Phone Number">
											  	<?php echo form_error('hotel_phone'); ?>
										    </div>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="notification_email">Email Notification:</label>
										    <div class="col-sm-10">
												<input type="email" class="form-control" id="notification_email" name="notification_email" value="<?php echo $this->config_manager->config['conf_notification_email']; ?>" placeholder="Enter email">
											  	<?php echo form_error('notification_email'); ?>
										    </div>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="booking_search_engine">Booking Engine:</label>
										<div class="col-sm-10"> 
											<select class="form-control" id="booking_search_engine" name="booking_search_engine">
												<?php
												if($this->config_manager->config['conf_booking_turn_off'] == 0){
													$select_booking_turn='		<option value="0" selected="selected">'.$this->lang->line('app_booking_turn_on').'</option>' . "\n";
													$select_booking_turn.='		<option value="1">'.$this->lang->line('app_booking_turn_off').'</option>' . "\n";
												}else{
													$select_booking_turn='		<option value="1" selected="selected">'.$this->lang->line('app_booking_turn_off').'</option>' . "\n";
													$select_booking_turn.='		<option value="0">'.$this->lang->line('app_booking_turn_on').'</option>' . "\n";
												}
												 echo $select_booking_turn;
												?>
											</select>
											<?php echo form_error('booking_search_engine'); ?>
										</div>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="timezone">Hotel Timezone:</label>
										    <div class="col-sm-10">
												<select name="timezone" id="timezone" class="form-control">		
														<?php
															$zonelist = array('Kwajalein' => '(GMT-12:00) International Date Line West',
															'Pacific/Midway' => '(GMT-11:00) Midway Island',
															'Pacific/Samoa' => '(GMT-11:00) Samoa',
															'Pacific/Honolulu' => '(GMT-10:00) Hawaii',
															'America/Anchorage' => '(GMT-09:00) Alaska',
															'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US &amp; Canada)',
															'America/Tijuana' => '(GMT-08:00) Tijuana, Baja California',
															'America/Denver' => '(GMT-07:00) Mountain Time (US &amp; Canada)',
															'America/Chihuahua' => '(GMT-07:00) Chihuahua',
															'America/Mazatlan' => '(GMT-07:00) Mazatlan',
															'America/Phoenix' => '(GMT-07:00) Arizona',
															'America/Regina' => '(GMT-06:00) Saskatchewan',
															'America/Tegucigalpa' => '(GMT-06:00) Central America',
															'America/Chicago' => '(GMT-06:00) Central Time (US &amp; Canada)',
															'America/Mexico_City' => '(GMT-06:00) Mexico City',
															'America/Monterrey' => '(GMT-06:00) Monterrey',
															'America/New_York' => '(GMT-05:00) Eastern Time (US &amp; Canada)',
															'America/Bogota' => '(GMT-05:00) Bogota',
															'America/Lima' => '(GMT-05:00) Lima',
															'America/Rio_Branco' => '(GMT-05:00) Rio Branco',
															'America/Indiana/Indianapolis' => '(GMT-05:00) Indiana (East)',
															'America/Caracas' => '(GMT-04:30) Caracas',
															'America/Halifax' => '(GMT-04:00) Atlantic Time (Canada)',
															'America/Manaus' => '(GMT-04:00) Manaus',
															'America/Santiago' => '(GMT-04:00) Santiago',
															'America/La_Paz' => '(GMT-04:00) La Paz',
															'America/St_Johns' => '(GMT-03:30) Newfoundland',
															'America/Argentina/Buenos_Aires' => '(GMT-03:00) Georgetown',
															'America/Sao_Paulo' => '(GMT-03:00) Brasilia',
															'America/Godthab' => '(GMT-03:00) Greenland',
															'America/Montevideo' => '(GMT-03:00) Montevideo',
															'Atlantic/South_Georgia' => '(GMT-02:00) Mid-Atlantic',
															'Atlantic/Azores' => '(GMT-01:00) Azores',
															'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
															'Europe/Dublin' => '(GMT) Dublin',
															'Europe/Lisbon' => '(GMT) Lisbon',
															'Europe/London' => '(GMT) London',
															'Africa/Monrovia' => '(GMT) Monrovia',
															'Atlantic/Reykjavik' => '(GMT) Reykjavik',
															'Africa/Casablanca' => '(GMT) Casablanca',
															'Europe/Belgrade' => '(GMT+01:00) Belgrade',
															'Europe/Bratislava' => '(GMT+01:00) Bratislava',
															'Europe/Budapest' => '(GMT+01:00) Budapest',
															'Europe/Ljubljana' => '(GMT+01:00) Ljubljana',
															'Europe/Prague' => '(GMT+01:00) Prague',
															'Europe/Sarajevo' => '(GMT+01:00) Sarajevo',
															'Europe/Skopje' => '(GMT+01:00) Skopje',
															'Europe/Warsaw' => '(GMT+01:00) Warsaw',
															'Europe/Zagreb' => '(GMT+01:00) Zagreb',
															'Europe/Brussels' => '(GMT+01:00) Brussels',
															'Europe/Copenhagen' => '(GMT+01:00) Copenhagen',
															'Europe/Madrid' => '(GMT+01:00) Madrid',
															'Europe/Paris' => '(GMT+01:00) Paris',
															'Africa/Algiers' => '(GMT+01:00) West Central Africa',
															'Europe/Amsterdam' => '(GMT+01:00) Amsterdam',
															'Europe/Berlin' => '(GMT+01:00) Berlin',
															'Europe/Rome' => '(GMT+01:00) Rome',
															'Europe/Stockholm' => '(GMT+01:00) Stockholm',
															'Europe/Vienna' => '(GMT+01:00) Vienna',
															'Europe/Minsk' => '(GMT+02:00) Minsk',
															'Africa/Cairo' => '(GMT+02:00) Cairo',
															'Europe/Helsinki' => '(GMT+02:00) Helsinki',
															'Europe/Riga' => '(GMT+02:00) Riga',
															'Europe/Sofia' => '(GMT+02:00) Sofia',
															'Europe/Tallinn' => '(GMT+02:00) Tallinn',
															'Europe/Vilnius' => '(GMT+02:00) Vilnius',
															'Europe/Athens' => '(GMT+02:00) Athens',
															'Europe/Bucharest' => '(GMT+02:00) Bucharest',
															'Europe/Istanbul' => '(GMT+02:00) Istanbul',
															'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
															'Asia/Amman' => '(GMT+02:00) Amman',
															'Asia/Beirut' => '(GMT+02:00) Beirut',
															'Africa/Windhoek' => '(GMT+02:00) Windhoek',
															'Africa/Harare' => '(GMT+02:00) Harare',
															'Asia/Kuwait' => '(GMT+03:00) Kuwait',
															'Asia/Riyadh' => '(GMT+03:00) Riyadh',
															'Asia/Baghdad' => '(GMT+03:00) Baghdad',
															'Africa/Nairobi' => '(GMT+03:00) Nairobi',
															'Asia/Tbilisi' => '(GMT+03:00) Tbilisi',
															'Europe/Moscow' => '(GMT+03:00) Moscow',
															'Europe/Volgograd' => '(GMT+03:00) Volgograd',
															'Asia/Tehran' => '(GMT+03:30) Tehran',
															'Asia/Muscat' => '(GMT+04:00) Muscat',
															'Asia/Baku' => '(GMT+04:00) Baku',
															'Asia/Yerevan' => '(GMT+04:00) Yerevan',
															'Asia/Yekaterinburg' => '(GMT+05:00) Ekaterinburg',
															'Asia/Karachi' => '(GMT+05:00) Karachi',
															'Asia/Tashkent' => '(GMT+05:00) Tashkent',
															'Asia/Calcutta' => '(GMT+05:30) Calcutta',
															'Asia/Colombo' => '(GMT+05:30) Sri Jayawardenepura',
															'Asia/Katmandu' => '(GMT+05:45) Kathmandu',
															'Asia/Dhaka' => '(GMT+06:00) Dhaka',
															'Asia/Almaty' => '(GMT+06:00) Almaty',
															'Asia/Novosibirsk' => '(GMT+06:00) Novosibirsk',
															'Asia/Rangoon' => '(GMT+06:30) Yangon (Rangoon)',
															'Asia/Krasnoyarsk' => '(GMT+07:00) Krasnoyarsk',
															'Asia/Bangkok' => '(GMT+07:00) Bangkok',
															'Asia/Jakarta' => '(GMT+07:00) Jakarta',
															'Asia/Brunei' => '(GMT+08:00) Beijing',
															'Asia/Chongqing' => '(GMT+08:00) Chongqing',
															'Asia/Hong_Kong' => '(GMT+08:00) Hong Kong',
															'Asia/Urumqi' => '(GMT+08:00) Urumqi',
															'Asia/Irkutsk' => '(GMT+08:00) Irkutsk',
															'Asia/Ulaanbaatar' => '(GMT+08:00) Ulaan Bataar',
															'Asia/Kuala_Lumpur' => '(GMT+08:00) Kuala Lumpur',
															'Asia/Singapore' => '(GMT+08:00) Singapore',
															'Asia/Taipei' => '(GMT+08:00) Taipei',
															'Australia/Perth' => '(GMT+08:00) Perth',
															'Asia/Seoul' => '(GMT+09:00) Seoul',
															'Asia/Tokyo' => '(GMT+09:00) Tokyo',
															'Asia/Yakutsk' => '(GMT+09:00) Yakutsk',
															'Australia/Darwin' => '(GMT+09:30) Darwin',
															'Australia/Adelaide' => '(GMT+09:30) Adelaide',
															'Australia/Canberra' => '(GMT+10:00) Canberra',
															'Australia/Melbourne' => '(GMT+10:00) Melbourne',
															'Australia/Sydney' => '(GMT+10:00) Sydney',
															'Australia/Brisbane' => '(GMT+10:00) Brisbane',
															'Australia/Hobart' => '(GMT+10:00) Hobart',
															'Asia/Vladivostok' => '(GMT+10:00) Vladivostok',
															'Pacific/Guam' => '(GMT+10:00) Guam',
															'Pacific/Port_Moresby' => '(GMT+10:00) Port Moresby',
															'Asia/Magadan' => '(GMT+11:00) Magadan',
															'Pacific/Fiji' => '(GMT+12:00) Fiji',
															'Asia/Kamchatka' => '(GMT+12:00) Kamchatka',
															'Pacific/Auckland' => '(GMT+12:00) Auckland',
															'Pacific/Tongatapu' => '(GMT+13:00) Nukualofa'
														);
															$select_timezone="";
															foreach($zonelist as $key => $value) {
																if($key == $this->config_manager->config['conf_hotel_timezone']){
																  $select_timezone.='<option value="' . $key . '" selected="selected">' . $value . '</option>' . "\n";
																}else{
																  $select_timezone.='<option value="' . $key . '">' . $value . '</option>' . "\n";
																}
															}
															echo $select_timezone;
														?>
												</select>
												<?php echo form_error('timezone'); ?>
										    </div>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="min_night_booking">Minimum Booking:</label>
										    <div class="col-sm-10">
											  <select class="form-control" id="min_night_booking" name="min_night_booking">
												  <?php
													$select_min_booking = "";
													for($k=1; $k<11; $k++){
														if($this->config_manager->config['conf_min_night_booking'] == $k){
														$select_min_booking.='<option value="' . $k . '" selected="selected">' . $k . '</option>' . "\n";
														}else{
														$select_min_booking.='<option value="' . $k . '">' . $k . '</option>' . "\n";
														}
													}
													echo $select_min_booking;
												  ?>
												</select>
												<?php echo form_error('min_night_booking'); ?>
										    </div>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="date_format">Date Format:</label>
										    <div class="col-sm-10">
								                <select name="date_format" id="date_format" class="form-control">
													<?php 
													   $dt_format_array=array("mm/dd/yy","dd/mm/yy","mm-dd-yy","dd-mm-yy","mm.dd.yy","dd.mm.yy","yy-mm-dd");
													   $select_dt_format="";
													   for($p=0; $p<7; $p++){
													   if($dt_format_array[$p] == $this->config_manager->config['conf_dateformat']){
														 $select_dt_format.='<option value="'.$dt_format_array[$p].'" selected="selected">'.strtoupper($dt_format_array[$p]).'</option>';
													   }else{
														 $select_dt_format.='<option value="'.$dt_format_array[$p].'" >'.strtoupper($dt_format_array[$p]).'</option>';
													    } 
													   }

													   echo $select_dt_format;
													?>
																</select>
																<?php echo form_error('date_format'); ?>
										    </div>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="room_lock">Room Lock Time:</label>
										    <div class="col-sm-10">
											    <select name="room_lock" id="room_lock" class="form-control">
													<?php
													$room_lock = array(
														'200' => '2 Minute',
														'500' => '5 Minute',
														'1000' => '10 Minute',
														'2000' => '20 Minute',
														'3000' => '30 Minute'
													);									
										            $select_room_lock = "";
													foreach($room_lock as $key => $value) {
														if($key == $this->config_manager->config['conf_booking_exptime']){
														   $select_room_lock.='		<option value="' . $key . '" selected="selected">' . $value . '</option>' . "\n";
														}else{
														   $select_room_lock.='		<option value="' . $key . '">' . $value . '</option>' . "\n";
														}
													}
													echo $select_room_lock;
													?>
												</select>
												<?php echo form_error('room_lock'); ?>
											    <span class="help-block mt-10 mb-0"><small>Note: Duration for customer selected Room(s) will be lock when checkout redirect to payment gateway.</small></span>
										    </div>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="generate_global_years">Maximum Booking Year:</label>
										    <div class="col-sm-10">
                                                 <select name="generate_global_years" id="generate_global_years" class="form-control">
												   <?php
												    $generate_global_years = '';
													   $yrs_value = array('1'=>'365','2'=>'730','3'=>'1095');
															foreach($yrs_value as $key=>$val){
																if($val == $this->config_manager->config['conf_maximum_global_years']){
																	$generate_global_years.= '<option value="'.$val.'" selected="selected">'.$key.' Year(s)</option>' ;
																}else{
																	$generate_global_years.= '<option value="'.$val.'">'.$key.' Year(s)</option>' ;
																}
																
															}	
													  echo  $generate_global_years;
												   ?>               
													</select>
													<?php echo form_error('generate_global_years'); ?>
										    </div>
										</div>
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="tax_amount">Tax(%):</label>
										    <div class="col-sm-10">
															<input type="text" class="form-control" id="tax_amount" name="tax_amount" value="<?php echo $this->config_manager->config['conf_tax_amount']; ?>" placeholder="%">
															<?php echo form_error('tax_amount'); ?>
										    </div>
										</div>	
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="email_hr">Invoice Currency :</label>
										    <div class="col-sm-10">
												<select name="inv_currency" class="form-control">
													<?php
													 $generate_inv_val = '';
													 $vals2= array("0"=>'Default Currency('. $this->config_manager->get_currency_code().')',"1"=>'User Currency');	
													 foreach($vals2 as $key=>$val){
														 if($key == $this->config_manager->config['conf_invoice_currency']){
														   $generate_inv_val.='<option value="'.$key.'" selected="selected">'.$val.'</option>';
														 }else{
														   $generate_inv_val.='<option value="'.$key.'">'.$val.'</option>'; 
														 }
													 }
													 echo  $generate_inv_val;
													?>
												</select>
										    </div>
										</div>	
										<div class="form-group">
											<label class="control-label mb-10 col-sm-2" for="email_hr">Price Including Tax?:</label>
										    <div class="col-sm-10">
                          <div class="checkbox checkbox-primary">
														<?php  if($this->config_manager->config['conf_price_with_tax'] == 1): ?>
														   <input type="checkbox" name="price_inclu_tax" id="price_inclu_tax" checked="checked" />
														<?php else: ?>
														<input type="checkbox" name="price_inclu_tax" id="price_inclu_tax" />
													    <?php endif;?>
														<label for="checkbox_hr">
														</label>
												</div>
										    </div>
										</div>																		
										<div class="form-group mb-0"> 
											<div class="col-sm-offset-2 col-sm-10">
											  <button type="submit" class="btn btn-sm btn-primary"><span class="btn-text">Save</span></button>
											</div>
										</div>
										<?php echo form_close();?>
								</div>
							</div>
						</div>
					</div>
				</div>				
			</div>
				<!-- Footer -->
				<?php $this->load->view('dashboard/footer_copyright'); ?>
			   <!-- /Footer -->
			</div>
		</div>
        <!-- /Main Content -->