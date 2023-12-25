<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Capacity</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/capacity"><span>Capacity</span></a></li>
                    <li class="active"><span>Capacity</span></li>
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
                            <h6 class="panel-title txt-dark">Capacity</h6>
                        </div>
                        <div class="pull-right">
                           <button type="button" class="btn btn-sm btn-primary shadow shadow--big" data-toggle="modal" data-target="#capacityeModal">New</button>
                           <div id="capacityeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h5 class="modal-title" id="myModalLabel">Add New Capacity</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form  id="capacityForm">
                                                        <div class="form-group">
                                                            <div id="errors"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label mb-10" for="capacity_title">Title:</label>
                                                            <input type="text" class="form-control" name="capacity_title" id="capacity_title">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label mb-10" for="no_adult">Adult:</label>
                                                            <input type="number" class="form-control" name="no_adult" id="no_adult">
                                                        </div>
												    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-default" id="save_capacity">Save</button>
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
                        <div class="table-responsive">
							<table class="table mb-0" id="room-capacity">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>adult</th>
                                        <th>MANAGE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($capacity as $cap):?>
                                    <tr>
                                        <td><?=$cap->title;?></td>
                                        <td><?=$cap->capacity;?></td>
                                        <td>
                                           <a href="<?php echo base_url();?>dashboard/get_capacity_by_id/<?=$this->hasher->encrypt($cap->id);?>" class="btn btn-xs btn-primary">Edit</a>
                                            <button type="button" id="delete_capacity"  data-id="<?=$this->hasher->encrypt($cap->id);?>" class="btn btn-xs btn-default">Delete</button>
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
		<?php $this->load->view('dashboard/footer_copyright'); ?>
	</div>
</div>