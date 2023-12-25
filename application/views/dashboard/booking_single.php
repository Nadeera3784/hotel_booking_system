<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Booking Details</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/room_block"><span>Room Blocking</span></a></li>
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
                            <h6 class="panel-title txt-dark">Booking Details</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                <div class="form-horizontal">
                                     <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                    <label class="control-label col-md-3">Name:</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"><?=$booking['title'].$booking['first_name'].$booking['surname'];?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Email:</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"><?=$booking['email'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Phone:</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"><?=$booking['phone'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Address:</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"><?=$booking['street_addr'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">City:</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"><?=$booking['city'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Country:</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"><?=$booking['country'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Zip Code:</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"><?=$booking['zip'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Identity Type:</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"><?=$booking['id_type'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Identity Number:</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"><?=$booking['id_number'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Additional Requests:</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static"><?=($booking['special_requests'])? $booking['special_requests'] : "-"  ;?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	
            </div>
		</div>
		<?php $this->load->view('dashboard/footer_copyright'); ?>
	</div>
</div>