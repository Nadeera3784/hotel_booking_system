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

<div class="container pt-5">
    <div class="page-overlay">
        <div class="spinner"><span class="sp sp1"></span><span class="sp sp2"></span><span class="sp sp3"></span></div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card receipt-card" data-aos="fade-down">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><?php echo $this->lang->line('app_booking_details_check_in');?></td>
                                    <td class="text-right">
                                      <?=$this->booking->checkInDate; ?>
                                       <input type="hidden" id="checkInDate" value="<?php echo (date('n', strtotime($this->booking->checkInDate)) - 1); ?>">
                                     </td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('app_booking_details_check_Out');?></td>
                                    <td class="text-right"><?=$this->booking->checkOutDate; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('app_booking_details_total_nights');?></td>
                                    <td class="text-right"><?=$this->booking->nightCount; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('app_booking_details_adult_rooms');?></td>
                                    <td class="text-right"><?=$this->booking->guestsPerRoom; ?></td>
                                </tr> 
                                <tr>
                                    <td><?php echo $this->lang->line('app_booking_details_child_rooms');?></td>
                                    <td class="text-right"><?=$this->booking->childPerRoom; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

        </div>
    </div>
    <?php
     $gotSearchResult = false;
     $idgenrator = 0;
     $ik=1;
     ?>
    <!-- <div class="row">
        <div class="col-md-12 pb-3">
                     
        </div>
    </div>  -->
<form name="searchresult" id="searchresult" method="post" action="<?php echo base_url(); ?>receipt/index">

<div class="clearfix pb-3">
    <a href="<?php echo base_url(); ?>app/index" class="btn btn-primary float-left"  data-aos="fade-right"><i class="mdi mdi-arrow-left"></i> <?php echo $this->lang->line('app_booking_form_button_search');?></a>
    <button type="submit"  class="btn btn-primary float-right"  data-aos="fade-left"><?php echo $this->lang->line('app_booking_form_button_continue');?>  <i class="mdi mdi-arrow-right"></i></button>
</div> 

<?php foreach($this->booking->roomType as $room_type): ?>
   <?php foreach($this->booking->multiCapacity as $capid => $capvalues): ?>
     <?php $room_result = $this->booking->get_available_rooms($room_type['rtid'], $room_type['rtname'], $capid); ?>
         <?php if($this->booking->room_checker($room_type['rtid'], $capid)): ?>
         <div class="strip list_view">
            <div class="row no-gutters">
                <div class="col-lg-5">
                    <?php  if($this->booking->get_room_images($room_type['rtid'], $capid)) :?>
                        <?php 
                            $images = $this->booking->get_room_images($room_type['rtid'], $capid);
                            $images_array = explode(',',$images['img_path']);
                        ;?>
                        <div class="slider">
                            <?php foreach($images_array as $imagA):?>
                             <figure>
                    
                                <a href="#">
                                <img src="<?php echo base_url(); ?>assets/images/rooms/<?=$imagA;?>" class="img-fluid" alt="<?=$imagA;?>">
                                       <div class="read_more"><span><?php echo ($room_result['rooms_left'])? $room_result['rooms_left'] : 0 ; ?> Rooms left</span></div>
                                </a>
                                  <small><?php echo $room_type['rtname']; ?></small>
                            </figure>
                            <?php endforeach;?>
                        </div>
                            <?php else: ?>
                        <figure>
                            <a href="#">
                                <img src="<?php echo base_url(); ?>assets/images/no_image.jpg" class="img-fluid" alt="no image">
                                    <div class="read_more"><span><?php echo ($room_result['rooms_left'])? $room_result['rooms_left'] : 0 ; ?> Rooms left</span></div>
                            </a>
                                <small><?php echo $room_type['rtname']; ?></small>
                        </figure>
                        <?php endif;?>
                </div>
                <div class="col-lg-7 <?php echo $room_result['specail_price_flag']  ? "offer-hightlight" : "" ?>">
                    <div class="wrapper">
                        <a href="#" id="calcheck"  data-rtype="<?php echo $room_type['rtid'];?>" data-cid="<?php echo $capid; ?>" class="wish_bt"><i class="mdi mdi-calendar-check pluse"></i></a>
                        <h3><a class="search-title" href="detail-restaurant.html"><?php echo $room_type['rtname']; ?>(<?php echo $capvalues['captitle']; ?>)</a></h3>
                        <small></small>
                        <p><?php echo $this->booking->get_room_description($room_type['rtid'])["description"]; ?></p>
                        <?php if(intval($room_result['roomcnt']) > 0) : ?>
                        <?php $gotSearchResult = true; ?>
                        <label for="colFormLabelSm" class="mr-5"><?php echo $this->lang->line('app_booking_details_select_number_of_rooms');?></label>
                        <select name="svars_selectedrooms[]" class="custom-select-rooms">
                            <?php echo $room_result['roomdropdown']; ?>
                        </select>
                        <?php else : ?>
                        <p>Not Available</p>
                        <?php endif; ?>
                    </div>
                    <ul>
                        <li><span class="loc_open">
                            <?php echo $capvalues['capval'] . " " . "Adult per Room"; ?>
                            <?php if($room_result['child_flag']) : ?>
                            <?php echo $this->booking->childPerRoom . " " . "Adult per Room";?>
                            <?php endif; ?>
                        </span></li>
                        <li>
                            <div class="score">
                               
                                    <?php if($room_result['specail_price_flag']): ?>
                                    <strong>
                                    <span>    
                                    <?php echo $this->config_manager->get_currency_symbol($this->booking->currency).$this->config_manager->get_exchange_money($room_result['totalprice'],$this->booking->currency); ?>
                                    </span>
                                    <?php echo $this->config_manager->get_currency_symbol($this->booking->currency).$this->config_manager->get_exchange_money($room_result['total_specail_price'],$this->booking->currency); ?>
                                    </strong>
                                    <?php else:?>
                                    <strong>
                                      <?php echo $this->config_manager->get_currency_symbol($this->booking->currency).$this->config_manager->get_exchange_money($room_result['totalprice'],$this->booking->currency); ?>
                                    </strong>
                                    <?php endif; ?>
                                
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
       
        <?php endif; ?>          
    <?php endforeach; ?>
<?php endforeach; ?>
<?php 
   if($this->booking->searchCode == "SEARCH_ENGINE_TURN_OFF"){
      alert('danger',  $this->lang->line('app_sorry_online_booking_currently_not_available_please_try_later'));
   }else if ($this->booking->searchCode == "OUT_BEFORE_IN") {
      alert('danger',  $this->lang->line('app_sorry_you_have_entered_a_invalid_searching_criteria'));
   }else if($this->booking->searchCode == "NOT_MINNIMUM_NIGHT"){
      alert('danger',  $this->lang->line('app_minimum_number_of_night_should_not_be_less_than'). ' ' .$this->config_manager->config['conf_min_night_booking'] . ' ' . $this->lang->line('app_please_modify_your_searching_criteria'));
   }else if($this->booking->searchCode == "TIME_ZONE_MISMATCH"){
      $tempdate = date("l F j, Y G:i:s T");
      alert('danger',  $this->lang->line('app_booking_not_possible_for_check_in_date') . ' ' . $this->booking->checkInDate .' '. $this->lang->line('app_please_modify_your_search _criteria_according_to_hotels_date_time').' '.$tempdate);
   }
   

?>
</form>
<div class="modal" id="amodal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $this->lang->line('app_booking_details_check_availability');?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div  id="calendar"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>



