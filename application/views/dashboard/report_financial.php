<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Financial Report</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?php echo base_url();?>dashboard/report_booking"><span>Financial Report</span></a></li>
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
                            <h6 class="panel-title txt-dark">Financial Report</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <ul role="tablist" class="nav nav-pills" id="myTabs_6">
								<li class="active" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab" id="week_tab" href="#week">Weekly</a></li>
                                <li role="presentation" class=""><a data-toggle="tab" id="month_tab" role="tab" href="#month" aria-expanded="false">Monthly</a></li>
                                <li role="presentation" class=""><a data-toggle="tab" id="yearly_tab" role="tab" href="#yearly" aria-expanded="false">Yearly</a></li>
                            </ul>
                                        
                            <div class="tab-content" id="myTabContent_6">
                                <div id="week" class="tab-pane fade active in" role="tabpanel">
                                    <div id="financial_weekchart"></div>
                                </div>
                                <div id="month" class="tab-pane fade" role="tabpanel">
                                    <div id="financial_monthchart"></div>
                                </div>
                                <div id="yearly" class="tab-pane fade" role="tabpanel">
                                    <div id="financial_yearchart"></div>
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