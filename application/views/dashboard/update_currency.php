<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Update currency</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/currency"><span>Currency</span></a></li>
                    <li class="active"><span>Update Currency</span></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default border-panel card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Update Currency</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <?php $attr = array("class" => "form-horizontal");?>
							<?php echo form_open('dashboard/update_currency', $attr);?>
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-4" for="currency_code">Currency Code:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="currency_code" id="currency_code" value="<?php echo $currency->currency_code;?>">
                                            <?php echo form_error('currency_code'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-4" for="currency_symbol">Currency Symbol:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" value="<?php echo $currency->currency_symbl;?>">
                                            <?php echo form_error('currency_symbol'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 col-sm-4" for="exchange_rate">Exchange Rate:</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="exchange_rate" name="exchange_rate" value="<?php echo $currency->exchange_rate;?>">
                                            <?php echo form_error('exchange_rate'); ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-default" id="update_currency">Update</button>
                                        </div>
                                    </div>
                                    <div class="form-group"> 
                                        <div class="col-sm-offset-4 col-sm-8">
                                        <div class="checkbox checkbox-primary">
                                            <?php $is_default = ($currency->default_c == 1) ? "checked" : "" ;?>
                                            <input id="default_currency" name="default_currency" type="checkbox" checked="<?php echo $is_default;?>" >
                                            <label for="checkbox_hr">
                                                Default Currency?
                                            </label>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0"> 
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <input name="currency_id" value="<?php echo $currency->id;?>"  type="hidden">
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