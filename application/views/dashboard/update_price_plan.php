<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Update price plan</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/price_plan"><span>Price Plans</span></a></li>
                    <li class="active"><span>Update price plan</span></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default border-panel card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Update price plan</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <?php if(isset($id)):?>
                                <div class="row">
                                    <?php if($row['start_date'] != '0000-00-00' || $row['end_date'] != '0000-00-00'):?>
                                    <div class="token-rate col-md-6 col-lg-12">
                                        <span class="card-sub-title">Start Date</span>
                                        <span class="text-blue font-mid"><?=$row['start_date'];?></span>
                                   </div>  
                                   <div class="token-rate col-md-6 col-lg-12">
                                        <span class="card-sub-title">End Date</span>
                                        <span class="text-blue font-mid"><?=$row['end_date'];?></span>
                                   </div>                                            
                                    <?php endif;?> 
                                  <div class="token-rate col-md-6 col-lg-12">
                                    <span class="card-sub-title">ROOM TYPE</span>
                                    <span class="text-blue font-mid"><?=$rtypeName;?></span>
                                  </div>
                                  <div class="token-rate col-md-6 col-lg-12">
                                     <span class="card-sub-title">CAPACITY</span>
                                     <span class="text-blue font-mid"><?=($row['capacity_id']==1001)? 'Per Child' : $capacity_title;?></span>
                                  </div>
                                  <div class="token-rate col-md-6 col-lg-12">
                                     <span class="card-sub-title">CURRENCY</span>
                                     <span class="text-blue font-mid"><?=$this->config_manager->get_default_currency_symbol();?></span>
                                  </div>
                                </div>

                                <?php echo form_open("dashboard/price_update_with_new_price");?>                          
                                <input type="hidden" name="roomtype_edit" value="<?=$id?>" />
                                <input type="hidden" name="roomtype" value="<?=$row['roomtype_id']?>" />
                                <input type="hidden" name="start_date_old" value="<?=$row['start_date'];?>" />
                                <div class="task">
                                    <div class="checklist">
                                        <div class="item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                            <div class="custom-control custom-checkbox">
                                                <span>Sunday</span>
                                                <label class="custom-control-label" for="checklist-item-2"></label>
                                                <input type="text" placeholder="Add price" name="sun" id="sun" value="<?=$row['sun'];?>">
                                                <?php echo form_error('sun'); ?>
                                            </div>
                                            <div class="dropdown show">
                                            <button class="btn btn-<?php echo ($row['sun'] > 0 ) ? "primary" : "default";?> btn-circle"> <i class="ti  <?php echo ($row['sun'] > 0 ) ? "ti-check" : "ti-info-alt";?>"></i></button>
                                            </div>
                                        </div>

                                        <div class="item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                            <div class="custom-control custom-checkbox">
                                                <span>Monday</span>
                                                <label class="custom-control-label" for="checklist-item-2"></label>
                                                <input type="text" placeholder="Add price"  name="mon" id="mon" value="<?=$row['mon'];?>">
                                                <?php echo form_error('mon'); ?>
                                            </div>
                                            <div class="dropdown show">
                                            <button class="btn btn-<?php echo ($row['mon'] > 0 ) ? "primary" : "default";?> btn-circle"> <i class="ti  <?php echo ($row['mon'] > 0 ) ? "ti-check" : "ti-info-alt";?>"></i></button>
                                            </div>
                                        </div>

                                        <div class="item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                            <div class="custom-control custom-checkbox">
                                                <span>Tuesday</span>
                                                <label class="custom-control-label" for="checklist-item-2"></label>
                                                <input type="text" placeholder="Add price"  name="tue" id="tue" value="<?=$row['tue'];?>">
                                                <?php echo form_error('tue'); ?>
                                            </div>
                                            <div class="dropdown show">
                                            <button class="btn btn-<?php echo ($row['tue'] > 0 ) ? "primary" : "default";?> btn-circle"> <i class="ti  <?php echo ($row['tue'] > 0 ) ? "ti-check" : "ti-info-alt";?>"></i></button>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                            <div class="custom-control custom-checkbox">
                                                <span>Wednesday</span>
                                                <label class="custom-control-label" for="checklist-item-2"></label>
                                                <input type="text" placeholder="Add price" name="wed" id="wed" value="<?=$row['wed'];?>">
                                                <?php echo form_error('wed'); ?>
                                            </div>
                                            <div class="dropdown show">
                                            <button class="btn btn-<?php echo ($row['wed'] > 0 ) ? "primary" : "default";?> btn-circle"> <i class="ti  <?php echo ($row['wed'] > 0 ) ? "ti-check" : "ti-info-alt";?>"></i></button>
                                            </div>
                                        </div>

                                        <div class="item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                            <div class="custom-control custom-checkbox">
                                                <span>Thursday</span>
                                                <label class="custom-control-label" for="checklist-item-2"></label>
                                                <input type="text" placeholder="Add price" name="thu" id="thu" value="<?=$row['thu'];?>">
                                                <?php echo form_error('thu'); ?>
                                            </div>
                                            <div class="dropdown show">
                                            <button class="btn btn-<?php echo ($row['thu'] > 0 ) ? "primary" : "default";?> btn-circle"> <i class="ti  <?php echo ($row['thu'] > 0 ) ? "ti-check" : "ti-info-alt";?>"></i></button>
                                            </div>
                                        </div>

                                        <div class="item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                            <div class="custom-control custom-checkbox">
                                                <span>Friday</span>
                                                <label class="custom-control-label" for="checklist-item-2"></label>
                                                <input type="text" placeholder="Add price" name="fri" id="fri"  value="<?=$row['fri'];?>">
                                                <?php echo form_error('fri'); ?>
                                            </div>
                                            <div class="dropdown show">
                                                <button class="btn btn-<?php echo ($row['fri'] > 0 ) ? "primary" : "default";?> btn-circle"> <i class="ti  <?php echo ($row['fri'] > 0 ) ? "ti-check" : "ti-info-alt";?>"></i></button>
                                            </div>
                                        </div>

                                        <div class="item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                            <div class="custom-control custom-checkbox">
                                                <span>Saturday</span>
                                                <label class="custom-control-label" for="checklist-item-2"></label>
                                                <input type="text" placeholder="Add price" name="sat" id="sat" value="<?=$row['sat'];?>">
                                                <?php echo form_error('sat'); ?>
                                            </div> 
                                            <div class="dropdown show">
                                                <button class="btn btn-<?php echo ($row['sat'] > 0 ) ? "primary" : "default";?> btn-circle"> <i class="ti  <?php echo ($row['sat'] > 0 ) ? "ti-check" : "ti-info-alt";?>"></i></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><span class="btn-text">Save</span></button>
                                </div>
                                <?php echo form_close();?>

                          <?php endif;?>
                        </div>
                    </div>
                </div>	
            </div>
		</div>
		<?php $this->load->view('dashboard/footer_copyright'); ?>
	</div>
</div>