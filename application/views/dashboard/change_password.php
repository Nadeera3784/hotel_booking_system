<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Change Password</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>auth/change_password"><span>Change Password</span></a></li>
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
                            <h6 class="panel-title txt-dark">Change Password</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <div id="infoMessage"><?php echo $message;?></div>
                            <?php $attr = array("class" => "form-horizontal");?>
							<?php echo form_open('auth/change_password', $attr);?>
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="old">Old Password :</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="old" name="old">
                                        <?php echo form_error('old'); ?>
                                    </div>
                                </div>        
     
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="new">New Password  :</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="new" name="new" pattern="^.{8}.*$">
                                        <span class="help-block mt-10 mb-0"><small>at least 8 characters long</small></span>
                                        <?php echo form_error('new'); ?>
                                    </div>
                                </div>  
                                
                                <div class="form-group">
                                    <label class="control-label mb-10 col-sm-4" for="new_confirm">Confirm New Password :</label>
                                    <div class="col-sm-8">
                                        <?php echo form_input($user_id);?>
                                        <input type="password" class="form-control" id="new_confirm" name="new_confirm" pattern="^.{8}.*$">
                                        <?php echo form_error('new_confirm'); ?>
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