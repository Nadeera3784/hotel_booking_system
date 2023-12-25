<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Price Plans</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/price_plan"><span>Price Plans</span></a></li>
                    <li class="active"><span>Price Plans</span></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if($this->session->flashdata('success')): ?>
                    <?php alert_dismissable('success', $this->session->flashdata('success')); ?>
                <?php endif; ?>
                <div class="page-overlay">
                        <div class="spinner"><span class="sp sp1"></span><span class="sp sp2"></span><span class="sp sp3"></span></div>
                </div>
                <div class="panel panel-default border-panel card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Price Plans</h6>
                        </div>
                        <div class="pull-right">
                           <a href="<?php echo base_url();?>dashboard/price_plan_by_id?rtype=0&start_dt=0" class="btn btn-sm btn-primary shadow shadow--big">New</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <div class="form-wrap">
                            <form class="form-inline">
                                <div class="form-group mr-15">
                                    <label class="control-label mr-10" for="email_inline">Select Room Type:</label>
                                    <?php
                                        $roomtype = '<select  class="form-control" name="roomtype"  id="roomtype"><option value="0">---- Select ----</option>';
                                        foreach($roomtypes as $roomtp){
                                          $roomtype .='<option value="'.$roomtp->roomtype_ID.'">'.$roomtp->type_name.'</option>';
                                        }
                                        $roomtype .= '</select>';
                                        echo $roomtype;
                                    ?>
                                </div>
                            </form>
						</div>
                        <div id="price_plan_updator" class="pt-5 mt-5"></div>
                        </div>
                    </div>
                </div>	
            </div>
		</div>
		<?php $this->load->view('dashboard/footer_copyright'); ?>
	</div>
</div>