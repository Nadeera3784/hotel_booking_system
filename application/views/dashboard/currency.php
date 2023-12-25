<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Currency</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/currency"><span>Currency</span></a></li>
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
                    <div id="AjaxResponse"></div>
						<div class="panel panel-default border-panel card-view">
							<div class="panel-heading">
								<div class="pull-left">
									<h6 class="panel-title txt-dark">Currency</h6>
                                </div>
                                <div class="pull-right">
                                   <button type="button" class="btn btn-sm btn-primary shadow shadow--big" data-toggle="modal" data-target="#myModal">New</button>
                                   <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h5 class="modal-title" id="myModalLabel">Add New Currency</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" id="currencyForm">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <div id="errors"></div>
                                                        </div>
                                                    </div>
												       <div class="form-group">
													     <label class="control-label mb-10 col-sm-4" for="currency_code">Currency Code:</label>
												             <div class="col-sm-8">
													              <input type="text" class="form-control" name="currency_code" id="currency_code" placeholder="Currency Code">
												             </div>
                                                        </div>
                                                        <div class="form-group">
													     <label class="control-label mb-10 col-sm-4" for="currency_symbol">Currency Symbol:</label>
												             <div class="col-sm-8">
													              <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" placeholder="Currency Symbol">
												             </div>
												        </div>
                                                        <div class="form-group">
													     <label class="control-label mb-10 col-sm-4" for="exchange_rate">Exchange Rate:</label>
												             <div class="col-sm-5">
													              <input type="text" class="form-control" id="exchange_rate" name="exchange_rate" placeholder="Exchange Rate">
												             </div>
                                                             <div class="col-sm-3">
                                                                <button type="button" class="btn btn-default" id="update_currency">Update</button>
                                                             </div>
												        </div>
                                                        <div class="form-group"> 
                                                            <div class="col-sm-offset-4 col-sm-8">
                                                            <div class="checkbox checkbox-primary">
                                                                <input id="default_currency" type="checkbox">
                                                                <label for="checkbox_hr">
                                                                   Default Currency?
                                                                </label>
                                                            </div>
                                                            </div>
                                                        </div> 
												    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-default" id="save_currency">Save</button>
                                                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="panel-wrapper collapse in">
								<div class="panel-body">
									<div class="table-wrap">
										<div class="table-responsive">
											<table id="currency_datable" class="table table-hover display  pb-30" >
												<thead>
													<tr>
														<th>Currency Code</th>
														<th>Currency Symbol</th>
														<th>Exchange Rate</th>
														<th>Default Currency?</th>
														<th>MANAGE</th>
													</tr>
												</thead>
												<tbody>
                                                <?php foreach($currency as $currnc):?>
													<tr>
														<td><?=$currnc['currency_code'];?></td>
														<td><?=$currnc['currency_symbl'];?></td>
														<td><?=$currnc['exchange_rate'];?></td>
														<td>
                                                            <?php echo ($currnc['default_c'] == 1) ? "Yes" : "No";?>
                                                        </td>
														<td>
                                                        <?php if($currnc['default_c'] == 1): ?>
                                                           <a href="<?php echo base_url();?>dashboard/get_currency_by_id/<?php echo $currnc['id']; ?>" class="btn btn-xs btn-primary">Edit</a>                       
                                                        <?php else:?>
                                                            <a href="<?php echo base_url();?>dashboard/get_currency_by_id/<?php echo $currnc['id']; ?>" class="btn btn-xs btn-primary">Edit</a>  
                                                            <button type="button" id="delete_currency" data-id="<?=base64_encode($currnc['id']);?>" class="btn btn-xs btn-default">Delete</button>                                                      
                                                        <?php endif;?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
                <!-- /Row -->
                
        <!-- Footer -->
		<?php $this->load->view('dashboard/footer_copyright'); ?>
		<!-- /Footer -->
	</div>
</div>