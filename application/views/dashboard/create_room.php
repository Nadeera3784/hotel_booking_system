<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Add rooms</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/rooms"><span>Rooms</span></a></li>
                    <li class="active"><span>Add rooms</span></li>
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
                            <h6 class="panel-title txt-dark">Add rooms</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <?php $attr = array("class" => "form-horizontal");?>
							<?php echo form_open('dashboard/create_room', $attr);?>
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="no_of_rooms">Number of Room :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="no_of_rooms" name="no_of_rooms">
                                        <?php echo form_error('no_of_rooms'); ?>
                                    </div>
                                </div>        
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="roomtype_id">Room Type: :</label>
                                    <div class="col-sm-8">
                                       <select name="roomtype_id" id="roomtype_id" class="form-control">
                                             <option value="0">--- Select ---</option>
                                             <?php foreach($roomtype as $roomtp) :?>
                                                <option value="<?=$roomtp->roomtype_ID;?>"><?=$roomtp->type_name;?></option>
                                             <?php endforeach;?>
                                        </select>
                                        <?php echo form_error('roomtype_id'); ?>
                                    </div>
                                </div>      
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="capacity_id">Adult: :</label>
                                    <div class="col-sm-8">
                                       <select name="capacity_id" id="capacity_id" class="form-control">
                                             <option value="0">--- Select ---</option>
                                             <?php foreach($capacity as $cpc) :?>
                                                <option value="<?=$cpc->id;?>"><?=$cpc->title;?></option>
                                             <?php endforeach;?>
                                        </select>
                                        <?php echo form_error('capacity_id'); ?>
                                    </div>
                                </div>      
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="child_per_room">Child  :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="child_per_room" name="child_per_room">
                                        <span class="help-block mt-10 mb-0"><small>Note: leave blank if None.</small></span>
                                    </div>
                                </div>          
                                <div class="form-group mb-0"> 
                                    <div class="col-sm-offset-4 col-sm-8">
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