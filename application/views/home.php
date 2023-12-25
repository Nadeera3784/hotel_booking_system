<nav class="navbar navbar-expand-md navbar-dark  fixed-top" id="header">
   <div class="container">
      <a class="navbar-brand" href="index.html#">Appname</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="mdi mdi-apps"></span>
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
<div class="jumbotron">
    <h1 class="text-center text-light mb-5">ENJOY A LUXURY EXPERIENCE</h1>
    <div class="container">
        <?php $attributes = array("id" => "search_form", "novalidate" => "novalidate");?>					 
		<?php echo form_open("app/search", $attributes);?>
        <div class="row">
                <div class="col-md-3">    
                      <label class="booking-form-lable" for="check_in"><?php echo $this->lang->line('app_booking_form_checkin_date');?></label>                
                      <input type="text" class="form-control required"  size="16"  id="check_in" name="check_in" data-date-format="<?php echo $this->config_manager->date_format();?>">             
                </div>
                <div class="col-md-3">
                   <label class="booking-form-lable" for="check_out"><?php echo $this->lang->line('app_booking_form_checkout_date');?></label>      
                   <input type="text" class="form-control required"   id="check_out" name="check_out" size="16" data-date-format="<?php echo $this->config_manager->date_format();?>">          
                </div>
               <div class="col-md-3">
                <input type="hidden" id="min_night_booking" value="<?php echo $this->config_manager->config['conf_min_night_booking'];?>">   
                <input type="hidden" name="currency" value="USD">
                <label class="booking-form-lable"><?php echo $this->lang->line('app_booking_form_number_of_rooms');?></label> 
                   <select class="form-control" name="capacity" id="capacity">
						<?php for($i=1; $i<=$capacity[0]->capa; $i++) : ?>
						   <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
					</select>
                </div>
                <?php if($kids): ?>
                  <div class="col">
						<select class="form-control" id="child_per_room" name="child_per_room">
						    <option value="0" selected><?php echo $this->lang->line('app_booking_form_child_selection_none');?></option>' ;
							<?php for($i=1; $i<=$kids; $i++) : ?>
							   <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php endfor; ?>
						</select>
					</div>	
                <?php else: ?>
				     <input type="hidden" name="child_per_room" id="child_per_room" value="0"/>
				<?php endif; ?>
							
                <div class="col-md-3 pt-4">
                     <button type="submit" class="btn btn-lg btn-primary btn-block"><?php echo $this->lang->line('app_booking_form_button_search');?></button>
                </div>
        </div>
        <?php echo form_close();?>
    </div>
</div>
<section class="site-section" data-scroll-id="about" id="about">
  <div class="container">
    <div class="row mb-5 justify-content-center">
      <div class="col-md-7 text-center">
        <h2 class="section-title mb-3" data-aos="fade-up" data-aos-delay="">Welcome To Our Hotel</h2>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus minima neque tempora reiciendis.</p>
      </div>
    </div>
    
    <div class="row" >
      <div class="col-lg-6 mb-5" data-aos="fade-up" data-aos-delay="">

        <div class="owl-carousel slide-one-item-alt">
          <img src="<?php echo base_url();?>assets/images/slide_1.jpg" alt="Image" class="img-fluid">
          <img src="<?php echo base_url();?>assets/images/slide_2.jpg" alt="Image" class="img-fluid">
          <img src="<?php echo base_url();?>assets/images/slide_3.jpg" alt="Image" class="img-fluid">
          <img src="<?php echo base_url();?>assets/images/slide_4.jpg" alt="Image" class="img-fluid">
        </div>
        <div class="custom-direction">
          <a href="index.html#" class="custom-prev"><span><span class="mdi mdi-arrow-left"></span></span></a>
          <a href="index.html#" class="custom-next"><span><span class="mdi mdi-arrow-left"></span></span></a>
        </div>

      </div>
      <div class="col-lg-6 ml-auto" data-aos="fade-up" data-aos-delay="100">
        
        <div class="owl-carousel slide-one-item-alt-text">
          <div>
          
            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <p>Est qui eos quasi ratione nostrum excepturi id recusandae fugit omnis ullam pariatur itaque nisi voluptas impedit  Quo suscipit omnis iste velit maxime.</p>

            <p><a href="index.html#" class="btn btn-primary mr-2 mb-2">Learn More</a></p>
          </div>
          <div>
           
            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <p>Est qui eos quasi ratione nostrum excepturi id recusandae fugit omnis ullam pariatur itaque nisi voluptas impedit  Quo suscipit omnis iste velit maxime.</p>

            <p><a href="index.html#" class="btn btn-primary mr-2 mb-2">Learn More</a></p>
          </div>
          <div>
           
            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <p>Est qui eos quasi ratione nostrum excepturi id recusandae fugit omnis ullam pariatur itaque nisi voluptas impedit  Quo suscipit omnis iste velit maxime.</p>

            <p><a href="index.html#" class="btn btn-primary mr-2 mb-2">Learn More</a></p>
          </div>
          <div>
            
            <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <p>Est qui eos quasi ratione nostrum excepturi id recusandae fugit omnis ullam pariatur itaque nisi voluptas impedit  Quo suscipit omnis iste velit maxime.</p>

            <p><a href="index.html#" class="btn btn-primary mr-2 mb-2">Learn More</a></p>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</section>
<section class="site-section bg-light-blue" data-scroll-id="services" id="services">
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-6 aos-init aos-animate" data-aos="fade">
        <h2 class="section-title mb-3">Facilities & Services</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.<br> Voluptatibus et dolor blanditiis consequuntur ex <br> voluptates perspiciatis omnis unde minima expedita.</p>
      </div>
      <div class="col-md-6">
        <div class="row">
            <div class="col-md-6" data-aos="fade-up">
                <div class="unit-4">
                  <div class="unit-4-icon mr-4"><span class="text-primary mdi mdi-wifi mdi-48px"></span></div>
                  <div>
                    <h3>Free Wi-Fi</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis quis molestiae vitae eligendi at.</p>
                  </div>
                </div>
     </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="unit-4">
                  <div class="unit-4-icon mr-4"><span class="text-primary mdi mdi-food-fork-drink mdi-48px"></span></div>
                  <div>
                    <h3>Breakfast Buffet</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis quis molestiae vitae eligendi at.</p>
                  </div>
                </div>
            </div>
             <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="unit-4">
                  <div class="unit-4-icon mr-4"><span class="text-primary mdi mdi-headset mdi-48px"></span></div>
                  <div>
                    <h3>Breakfast Buffet</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis quis molestiae vitae eligendi at.</p>
                  </div>
                </div>
            </div>   
             <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="unit-4">
                  <div class="unit-4-icon mr-4"><span class="text-primary mdi mdi-headset mdi-48px"></span></div>
                  <div>
                    <h3>Breakfast Buffet</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis quis molestiae vitae eligendi at.</p>
                  </div>
                </div>
            </div> 
            </div>
         </div>
      </div>
    </div>
  </div>
</section>
<section class="site-section" data-scroll-id="rooms" id="rooms">
  <div class="container">
    <div class="row mb-5 justify-content-center">
      <div class="col-md-7 text-center">
        <h2 class="section-title mb-3" data-aos="fade-up" data-aos-delay="">Rooms & Suites</h2>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus minima neque tempora reiciendis.</p>
      </div>
    </div>
    <div class="row mb-3 align-items-stretch">
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
            <div class="h-entry">
              <img src="<?php echo base_url();?>assets/images/img_1.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid">
              <div class="h-entry-inner">
                <h2 class="font-size-regular"><a href="index.html#">Suite</a></h2>
                <div class="meta mb-4">$125/per night</div>
                <ul class="list-unstyled">
                  <li><span class="font-weight-bold">Adults : </span>2</li>
                  <li><span class="font-weight-bold">Categories : </span>Single</li>
                  <li><span class="font-weight-bold">Facilities : </span>Closet with hangers, Telephone</li>
                  <li><span class="font-weight-bold">Size : </span>20m2</li>
                  <li><span class="font-weight-bold">Bed Type : </span>One bed</li>
                </ul>
              </div>
            </div> 
          </div>
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
            <div class="h-entry">
              <img src="<?php echo base_url();?>assets/images/img_2.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid">
              <div class="h-entry-inner">
                <h2 class="font-size-regular"><a href="index.html#">Family Room</a></h2>
               <div class="meta mb-4">$175/per night</div>
                <ul class="list-unstyled">
                  <li><span class="font-weight-bold">Adults : </span>2</li>
                  <li><span class="font-weight-bold">Categories : </span>Single</li>
                  <li><span class="font-weight-bold">Facilities : </span>Closet with hangers, Telephone</li>
                  <li><span class="font-weight-bold">Size : </span>20m2</li>
                  <li><span class="font-weight-bold">Bed Type : </span>One bed</li>
                </ul>
              </div>
            </div> 
          </div>
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-4" data-aos="fade-up">
            <div class="h-entry">
              <img src="<?php echo base_url();?>assets/images/img_3.jpg" alt="Free Website Template by Free-Template.co" class="img-fluid">
              <div class="h-entry-inner">
                <h2 class="font-size-regular"><a href="index.html#">Double</a></h2>
               <div class="meta mb-4">$235/per night</div>
                <ul class="list-unstyled">
                  <li><span class="font-weight-bold">Adults : </span>2</li>
                  <li><span class="font-weight-bold">Categories : </span>Single</li>
                  <li><span class="font-weight-bold">Facilities : </span>Closet with hangers, Telephone</li>
                  <li><span class="font-weight-bold">Size : </span>20m2</li>
                  <li><span class="font-weight-bold">Bed Type : </span>Two bed</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
  </div>
</section>
<section class="site-section bg-light-blue">
  <div class="container-fluid">
    <div class="row mb-5 justify-content-center">
      <div class="col-md-7 text-center">
        <h2 class="section-title mb-3" data-aos="fade-up" data-aos-delay="">Restaurant & Banquets</h2>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus minima neque tempora reiciendis.</p>
      </div>
    </div>

    <div class="owl-carousel centernonloop">
          <a href="#" class="item-dishes" data-aos="fade-right" data-aos-delay="100">
            <div class="text">
              <p class="dishes-price">$11.50</p>
              <h2 class="dishes-heading">Organic tomato salad, gorgonzola cheese, capers</h2>
            </div>
            <img src="<?php echo base_url();?>assets/images/dishes_1.jpg" alt="" class="img-fluid">
          </a>
          <a href="#" class="item-dishes" data-aos="fade-right" data-aos-delay="200">
            <div class="text">
              <p class="dishes-price">$12.00</p>
              <h2 class="dishes-heading">Baked broccoli</h2>
            </div>
            <img src="<?php echo base_url();?>assets/images/dishes_2.jpg" alt="" class="img-fluid">
          </a>
          <a href="#" class="item-dishes" data-aos="fade-right" data-aos-delay="300">
            <div class="text">
              <p class="dishes-price">$11.00</p>
              <h2 class="dishes-heading">Spicy meatballs</h2>
            </div>
            <img src="<?php echo base_url();?>assets/images/dishes_3.jpg" alt="" class="img-fluid">
          </a>
          <a href="#" class="item-dishes" data-aos="fade-right" data-aos-delay="400">
            <div class="text">
              <p class="dishes-price">$12.00</p>
              <h2 class="dishes-heading">Eggplant parmigiana</h2>
            </div>
            <img src="<?php echo base_url();?>assets/images/dishes_4.jpg" alt="" class="img-fluid">
          </a>
        </div>

  </div>
</section>

