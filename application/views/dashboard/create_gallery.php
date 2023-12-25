<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Create gallery</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/gallery"><span>Gallery</span></a></li>
                    <li class="active"><span>Create gallery</span></li>
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
                            <h6 class="panel-title txt-dark">Create gallery</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <div class="form-wrap">
                            <?php $attr = array("class" => "form-horizontal");?>
                            <?php echo form_open_multipart('dashboard/create_gallery_with_images', $attr);?>
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="roomtype_with_capacity">Select Room Type :</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="roomtype_with_capacity" id="roomtype_with_capacity">
                                        <option value="0">---- Select ----</option>
                                        <?php foreach($room_type as $rt): ?>
                                            <?php foreach($capacity as $cap): ?>
                                                <option   value="<?=$rt->roomtype_ID.'#'.$cap->id;?>"><?=$rt->type_name;?>(<?=$cap->title;?>)</option>
                                            <?php endforeach;?>
                                        <?php endforeach;?>
                                        </select> 
                                        <?php echo form_error('roomtype_with_capacity'); ?>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="no_of_rooms">Images :</label>
                                    <div class="col-sm-8">
                                        <div id="photo-field">
                                            <div id="room_image" orakuploader="on"></div>
                                        </div> 
                                        <div id="AjaxResponse"></div>
                                        <?php echo form_error('room_image'); ?>
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
		</div>
		<?php $this->load->view('dashboard/footer_copyright'); ?>
	</div>
</div>