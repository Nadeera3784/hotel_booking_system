<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Advance payments</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/advance_payment"><span>Advance payments</span></a></li>
                    <li class="active"><span>Advance payments</span></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if($this->session->flashdata('success')): ?>
                    <?php alert_dismissable('success', $this->session->flashdata('success')); ?>
                <?php endif; ?>
                <div id="AjaxResponse"></div>
                <div class="page-overlay">
                        <div class="spinner"><span class="sp sp1"></span><span class="sp sp2"></span><span class="sp sp3"></span></div>
                </div>
                <div class="panel panel-default border-panel card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Advance payments</h6>
                        </div>
                        <div class="pull-right">
							<span class="data-text weight-500 pr-5">Status</span>
								<span class="no-margin-switcher">
                                    <?php
                                    $depo_val='';
                                    if($this->config_manager->config['conf_enabled_deposit'] ==1){
                                        $depo_val  = 1;
                                         $deposit_check = "checked";
                                    }else{
                                        $depo_val=0;
                                         $deposit_check = "";
                                    }
                                    ?>
                                  <input value="<?=$this->config_manager->config['conf_enabled_deposit'];?>"  type="checkbox"  class="payment-switch"  data-size="small" <?=$deposit_check;?>/>	
								</span>	
						</div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <?php echo form_open("dashboard/update_advance_payment");?>  
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>month</th>
                                        <th>price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($advance_payments as $adp) :?>
                                        <tr>
                                            <td class="month-name"><?=$adp->month;?></td>
                                            <td class="text-right">
                                              <input type="text" class="form-control" name="<?=$adp->month_num;?>" value="<?=$adp->deposit_percent;?>">                                     
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <button type="submit" class="btn btn-large  btn-primary">save</button>
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