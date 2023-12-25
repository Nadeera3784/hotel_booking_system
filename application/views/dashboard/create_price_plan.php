<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Create price plan</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/price_plan""><span>Price Plans</span></a></li>
                    <li class="active"><span>Create price plan</span></li>
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
                <div class="page-overlay">
                        <div class="spinner"><span class="sp sp1"></span><span class="sp sp2"></span><span class="sp sp3"></span></div>
                </div>
                <div class="panel panel-default border-panel card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Create price plan</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <?php echo form_open("dashboard/create_price_plan");?>  
                            <div class="form-inline mb-30">
                                <div class="form-group mr-15">
                                    <label class="control-label mr-10" for="roomtype_id">Roomtype:</label>
                                    <select name="roomtype_id" class="form-control" id="roomtype_id">
                                            <option value="0">--- Select ---</option>'
                                        <?php foreach($rooms as $room) : ?>
                                            <option  value="<?=$room->roomtype_ID;?>"><?=$room->type_name;?></option>;	
                                        <?php endforeach; ?>
                                    </select>    
                                </div>
                                <div class="form-group mr-15">
                                    <label class="control-label mr-10" for="startdate">Start date:</label>
                                    <input type="text" class="form-control" id="startdate" name="startdate"  data-toggle="datetimepicker" data-target="#startdate">
                                </div>
                                <div class="form-group mr-15">
                                    <label class="control-label mr-10" for="closingdate">End date:</label>
                                    <input type="text" class="form-control" id="closingdate" name="closingdate" data-toggle="datetimepicker" data-target="#closingdate">
                                </div>	
                                <div class="form-group mr-15">
                                <label class="control-label mr-10" for="pwd_inline">Currency:</label>
                                <input type="hidden" name="roomtype_edit" value="<?=$roomtype_edit;?>" />
                                 <input type="hidden" name="start_date_old" value="<?=$start_date_old;?>" />
                                <input readonly disabled type="text" class="form-control filled-input" value="<?=$this->config_manager->get_default_currency_symbol();?>">
                                </div>
                            </div>
                            <div id="price_plan_updator">
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