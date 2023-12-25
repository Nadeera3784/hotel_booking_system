<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Update capacity</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/capacity"><span>Capacity</span></a></li>
                    <li class="active"><span>Update capacity</span></li>
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
                            <h6 class="panel-title txt-dark">Update capacity</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <?php $attr = array("class" => "form-horizontal");?>
							<?php echo form_open('dashboard/update_capacity', $attr);?>
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-4" for="capacity_title">Title:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="capacity_title" id="capacity_title" value="<?php echo $capacity['title'];?>">
                                            <?php echo form_error('capacity_title'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-4" for="no_adult">Adult:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="no_adult" name="no_adult" value="<?php echo $capacity['capacity'];?>">
                                            <?php echo form_error('no_adult'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0"> 
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <input name="capacity_id" value="<?php echo $this->hasher->encrypt($capacity['id']);?>"  type="hidden">
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