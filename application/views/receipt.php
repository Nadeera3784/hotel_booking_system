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
        <div class="col-md-12 pb-3">
            <div class="clearfix pb-3">
                <a href="<?php echo base_url(); ?>app/index" class="btn btn-primary float-left" data-aos="fade-right"><i class="mdi mdi-arrow-left"></i> <?php echo $this->lang->line('app_booking_form_button_search');?></a>
                <a href="<?php echo base_url(); ?>app/payment" class="btn btn-primary float-right" data-aos="fade-left"><i class="mdi mdi-arrow-right"></i> <?php echo $this->lang->line('app_booking_form_button_continue');?> </a>
            </div>                     
        </div> 
        <div class="col-md-12">
            <div class="card receipt-card mb-5">
                <div class="card-body">
                        <h4 class="card-title"><?php echo $this->lang->line('app_booking_receipt_title');?></h4>	
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="date-indicator"><?php echo $this->lang->line('app_booking_receipt_arrive');?></span> <br>
                                       <?php echo $checkInDate;?>
                                    </td>
                                    <td class="text-right">
                                       <span class="date-indicator"><?php echo $this->lang->line('app_booking_receipt_depart');?></span><br>
                                       <?php echo $checkOutDate;?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('app_booking_details_total_nights');?></td>
                                    <td class="text-right"><?php echo $nightCount;?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('app_booking_receipt_total_rooms');?></td>
                                    <td class="text-right"><?php echo $totalRoomCount;?></td>
                                </tr>
                                <?php foreach($booking_details as $books): ?>
                                <tr>
                                    <td><?php echo $this->lang->line('app_booking_receipt_number_of_rooms');?></td>
                                    <td class="text-right"><?php echo $books['roomno'];?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('app_booking_receipt_room_type');?></td>
                                    <td class="text-right"><?php echo $books['roomtype']."(".$books['capacitytitle'].")";?></td>
                                </tr> 
                                <tr>   
                                    <td><?php echo $this->lang->line('app_booking_receipt_max_occupancy');?></td>
                                    <?php $child_title2=($books['child_flag2'])? " + ".$books['childcount3']." "."Child"." ":""; ?>
                                    <td class="text-right"><?php echo $books['capacity']." Adult".$child_title2;?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('app_booking_receipt_gross_total');?></td>
                                    <td class="text-right"><?php echo $this->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->config_manager->get_exchange_money($books['grosstotal'], $_SESSION['sv_currency']);?></td>
                                </tr>
                                <?php endforeach;?>
                                <tr>
                                    <td><?php echo $this->lang->line('app_booking_receipt_sub_total');?></td>
                                    <td class="text-right"><?php echo $this->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->config_manager->get_exchange_money($roomPrices['subtotal'], $_SESSION['sv_currency']);?></td>
                                </tr>
                                <tr>
                                    <td>Tax  (<?php echo $this->config_manager->config['conf_tax_amount']; ?>%)</td>
                                    <td class="text-right">
                                     <?php if($this->config_manager->config['conf_tax_amount'] > 0  &&  $this->config_manager->config['conf_price_with_tax'] == 0 ): ?>
                                     <?php echo $this->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->config_manager->get_exchange_money($roomPrices['totaltax'], $_SESSION['sv_currency']);?>
                                     <?php else: ?>
                                     0.00
                                     <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><h4><?php echo $this->lang->line('app_booking_receipt_grand_total');?></h4></td>
                                    <td class="text-right" colspan="2">
                                    <h3>
                                    <?php echo $this->config_manager->get_currency_symbol($_SESSION['sv_currency']).$this->config_manager->get_exchange_money($roomPrices['grandtotal'], $_SESSION['sv_currency']);?>      
                                    </h3>                              
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>


