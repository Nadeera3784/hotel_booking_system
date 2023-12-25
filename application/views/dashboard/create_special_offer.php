<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Create Special Offer</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/special_offer"><span>Special offer</span></a></li>
                    <li class="active"><span>Create Special Offer</span></li>
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
                            <h6 class="panel-title txt-dark">Create Special Offer</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <?php $attr = array("class" => "form-horizontal");?>
							<?php echo form_open('dashboard/create_special_offer', $attr);?>

                               <div class="form-group">
                                    <label class="control-label col-sm-2" for="offer_name">Offer name:</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="offer_name" name="offer_name">
                                    <?php echo form_error('offer_name'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="roomtype">Roomtype:</label>
                                    <div class="col-sm-10">
                                    <select name="roomtype" class="form-control" id="roomtype">
                                            <option value="0">---- All ----</option>'
                                        <?php foreach($rooms as $room) : ?>
                                            <option  value="<?=$room->roomtype_ID;?>"><?=$room->type_name;?></option>;	
                                        <?php endforeach; ?>
                                    </select>   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="startdate">Start date:</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="startdate" name="startdate"  data-toggle="datetimepicker" data-target="#startdate">
                                    <?php echo form_error('startdate'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="closingdate">End date:</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="closingdate" name="closingdate" data-toggle="datetimepicker" data-target="#closingdate">
                                    <?php echo form_error('closingdate'); ?>
                                    </div>
                                </div>	
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="price_deducted">Price Deducted(%):</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="price_deducted" name="price_deducted">
                                    <?php echo form_error('price_deducted'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="min_sty">Minimum Stay(Night):</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" id="min_sty" name="min_sty">
                                      <span class="help-block mt-10 mb-0"><small>leave blank if no minimum night restriction!</small></span>
                                    </div>
                                </div>
                                <div class="form-group">
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
		<?php $this->load->view('dashboard/footer_copyright'); ?>
	</div>
</div>