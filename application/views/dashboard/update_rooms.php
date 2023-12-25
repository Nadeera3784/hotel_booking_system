<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Update rooms</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/rooms"><span>Rooms</span></a></li>
                    <li class="active"><span>Update Rooms</span></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if($this->session->flashdata('success')): ?>
                    <?php alert_dismissable('success', $this->session->flashdata('success')); ?>
                <?php endif; ?>
                <?php if($this->session->flashdata('error')): ?>
                    <?php alert_dismissable('info', $this->session->flashdata('error')); ?>
                <?php endif; ?>

                <div class="panel panel-default border-panel card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Update rooms</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <?php $attr = array("class" => "form-horizontal");?>
							<?php echo form_open('dashboard/update_rooms', $attr);?>
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="no_of_room">Number of Room:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="no_of_room" id="no_of_room" value="<?=$room->NoOfRoom;?>">
                                        <input type="hidden" name="pre_room_cnt" value="<?=$room->NoOfRoom;?>">
                                        <?php echo form_error('no_of_room'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="child_per_room">Child :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="child_per_room" name="child_per_room" value="<?=$room->no_of_child;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="currency_symbol">Adult :</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static"><?=$room->title;?></p>
                                        <input type="hidden" name="capacity_id" value="<?=$room->capacity_id;?>">
                                    </div>
                                </div>       
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="currency_symbol">Room Type :</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static"><?=$room->type_name;?></p>
                                        <input type="hidden" name="roomtype_id" value="<?=$room->roomtype_id;?>">
                                    </div>
                                </div>                            
                                <div class="form-group mb-0"> 
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <input name="currency_id" value="1" type="hidden">
                                        <button type="submit" class="btn btn-sm btn-primary"><span class="btn-text">Save</span></button>
                                    </div>
                                </div> 
                            <?php echo form_close();?> 
                        </div>
                    </div>
                </div>	
            </div>
		</div>
		<?php $this->load->view('dashboard/footer_copyright'); ?>
	</div>
</div>