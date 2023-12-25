<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Update room type</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/room_type"><span>Room type</span></a></li>
                    <li class="active"><span>Update Room type</span></li>
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
                <div id="AjaxResponse"></div>
                <div class="panel panel-default border-panel card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Update room type</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <?php $attr = array("class" => "form-horizontal");?>
							<?php echo form_open('dashboard/update_roomtype', $attr);?>
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-4" for="roomtype_title">Type Title:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="roomtype_title" id="roomtype_title" value="<?=$room_type['type_name'];?>">
                                            <input type="hidden"  name="roomtype_id"  value="<?=$this->hasher->encrypt($room_type['roomtype_ID']);?>">
                                            <?php echo form_error('roomtype_title'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-4" for="description">Amenities:</label>
                                        <div class="col-sm-8">
                                            <textarea rows="5" cols="3" name="description" id="description" class="form-control"><?=$room_type['description'];?></textarea>
                                            <?php echo form_error('description'); ?>
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