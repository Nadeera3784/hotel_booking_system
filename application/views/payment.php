<nav class="navbar navbar-expand-md navbar-dark  fixed-top navbar-fixed-top mb-5">
   <div class="container">
      <a class="navbar-brand" href="index.html#">Appname</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">

        </ul>

      <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a data-scroll class="nav-link" href="#rooms">Rooms </a>
          </li>
          <li class="nav-item">
            <a data-scroll class="nav-link" href="#services">Services </a>
          </li>
          <li class="nav-item">
            <a data-scroll class="nav-link" href="#about">About Us </a>
          </li>
          <li class="nav-item">
            <a data-scroll class="nav-link" href="#contact">Contact </a>
          </li>
      </ul>
      </div>
    </div>
</nav>

  <div class="container">
    <div class="row">
	    <div class="col-md-12">
      <?php $attributes = array("id" => "payment_form", "novalidate" => "novalidate");?>
      <?php echo form_open("app/process_payment", $attributes);?>
        <div class="clearfix pb-3">
            <a href="<?php echo base_url();?>" class="btn btn-primary float-left aos-init aos-animate" data-aos="fade-right"><i class="mdi mdi-arrow-left"></i> <?php echo $this->lang->line('app_booking_form_button_search');?></a>
            <button type="submit" class="btn btn-primary float-right aos-init aos-animate" data-aos="fade-left"><?php echo $this->lang->line('app_booking_form_button_continue');?>  <i class="mdi mdi-arrow-right"></i></button>
        </div>
				<div class="card  mb-5">
					<div class="card-body">
              <h4 class="card-title"><?php echo $this->lang->line('app_booking_payment_title');?></h4>	    					 
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_name_title');?></label>
                    <div class="col-sm-10">
                        <select id="title" name="title" class="form-control">
                            <option value="Mr." selected="selected">Mr.</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Miss.">Miss.</option>
                            <option value="Dr.">Dr.</option>
                            <option value="Prof.">Prof.</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="first_name" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_first_name');?></label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control required" id="first_name" name="first_name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="last_name" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_last_name');?></label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control required" id="last_name" name="last_name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_email_address');?></label>
                    <div class="col-sm-10">
                    <input type="email" class="form-control required email" id="email" name="email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_address');?></label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control required" id="address" name="address">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="city" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_city_of_residence');?></label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control required" id="city" name="city">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="postal_code" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_zip_code');?></label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control required" id="postal_code" name="postal_code">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="country" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_country');?></label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control required" id="country" name="country">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_phone_number');?></label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control required" id="phone" name="phone">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="identity_type" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_identity_type');?></label>
                    <div class="col-sm-10">
                        <!-- <input type="text" class="form-control" id="identity_type" name="identity_type" placeholder="e.g.: passport"> -->
                        <div class="row guttar-15px">                       
                            <div class="col-md-4">
                                <div class="pay-option">
                                <input class="pay-option-check required" type="radio" id="payeth" name="identity_type" value="passport">
                                    <label class="pay-option-label" for="payeth">
                                        <span class="pay-title"><em class="pay-icon cf cf-eth"><i class="mdi mdi-airplane"></i></em>
                                        <span class="pay-cur"><?php echo $this->lang->line('app_booking_payment_passport');?></span>
                                    </label>
                                </div>      
                            </div>
                            <div class="col-md-4">
                                <div class="pay-option">
                                <input class="pay-option-check required" type="radio" id="paylte" name="identity_type" value="national_card">
                                    <label class="pay-option-label" for="paylte">
                                        <span class="pay-title"><em class="pay-icon cf cf-ltc"><i class="mdi mdi-contact-mail"></i></em>
                                        <span class="pay-cur"><?php echo $this->lang->line('app_booking_payment_national_card');?></span>
                                        </span>
                                    </label>
                                </div>      
                            </div>   
                            <div class="col-md-4">
                                <div class="pay-option">
                                <input class="pay-option-check required" type="radio" id="driver’s_license" name="identity_type" value="driver’s_license">
                                    <label class="pay-option-label" for="driver’s_license">
                                        <span class="pay-title"><em class="pay-icon cf cf-ltc"><i class="mdi mdi-car"></i></em>
                                        <span class="pay-cur"><?php echo $this->lang->line('app_booking_payment_driver_license');?></span>
                                        </span>
                                    </label>
                                </div>      
                            </div>              
                          </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="identity_number" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_identity_number');?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control required" id="identity_number" name="identity_number" placeholder="e.g.: passport number">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="payment_method" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_payment_method');?></label>
                    <div class="col-sm-10">
                        <div class="row guttar-15px">                       
                            <div class="col-6">
                                <div class="pay-option">
                                <input class="pay-option-check required" type="radio" id="paypal" name="payoption" value="paypal">
                                    <label class="pay-option-label" for="paypal">
                                        <span class="pay-title"><em class="pay-icon cf cf-eth"><i class="mdi mdi-paypal"></i></em>
                                        <span class="pay-cur">Paypal</span>
                                        </span>
                                        <span class="pay-amount">
                                        <?php echo $this->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->config_manager->get_exchange_money($_SESSION['dvars_roomprices']['grandtotal'], $_SESSION['sv_currency']);?>                                                   
                                       </span>
                                    </label>
                                </div>      
                            </div>
                            <div class="col-6">
                                <div class="pay-option">
                                <input class="pay-option-check required" type="radio" id="offline" name="payoption" value="offline">
                                    <label class="pay-option-label" for="offline">
                                        <span class="pay-title"><em class="pay-icon cf cf-ltc"><i class="mdi mdi-cash-multiple"></i></em>
                                        <span class="pay-cur">Offline</span>
                                        </span>
                                        <span class="pay-amount">
                                        <?php echo $this->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->config_manager->get_exchange_money($_SESSION['dvars_roomprices']['grandtotal'], $_SESSION['sv_currency']);?>  
                                        </span>
                                    </label>
                                </div>      
                            </div>                 
                          </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="additional_requests" class="col-sm-2 col-form-label"><?php echo $this->lang->line('app_booking_payment_additional_requests');?></label>
                    <div class="col-sm-10">
                        <textarea rows="3" id="additional_requests" name="additional_requests" class="form-control"></textarea>
                    </div>
                </div>
					</div>
        </div>
        <?php echo form_close();?>
		  </div>
    </div>
  </div>


