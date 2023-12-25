<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Update payment settings</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/payment_gateway"><span>Payment settings</span></a></li>
                    <li class="active"><span>Update payment settings</span></li>
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
                <div class="page-overlay">
                    <div class="spinner"><span class="sp sp1"></span><span class="sp sp2"></span><span class="sp sp3"></span></div>
                </div>
                <div class="panel panel-default border-panel card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Update payment settings</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                <?php $attr = array("class" => "form-horizontal");?>
                                <?php echo form_open('dashboard/update_payment_settings', $attr);?>
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-2" for="email_hr">Payment method:</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-static"><?php echo $payment_method->gateway_name;?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-2" for="settings">Settings:</label>
                                        <div class="col-sm-10"> 
                                          <input type="hidden" name="id"  value="<?php echo $this->hasher->encrypt($payment_method->id);?>">
                                          <input type="text" class="form-control" name="settings"  id="settings" value="<?php echo $payment_method->account;?>">
                                          <?php echo form_error('settings'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0"> 
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-primary btn-sm"><span class="btn-text">Save</span></button>
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