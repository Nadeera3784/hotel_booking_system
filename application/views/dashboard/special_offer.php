<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Special offer</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/special_offer"><span>Special offer</span></a></li>
                    <li class="active"><span>Special offer</span></li>
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
                            <h6 class="panel-title txt-dark">Special offer</h6>
                        </div>
                        <div class="pull-right">
                           <a href="<?php echo base_url();?>dashboard/create_special_offer" class="btn btn-sm btn-primary shadow shadow--big">New</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                           <div class="table-responsive">
                            <table class="table mb-0" id="special_offer_datable">
                                    <thead>
                                        <tr>
                                        <th>Offer Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Room Type</th>
                                        <th>Price Deducted</th>
                                        <th>Minimum Stay</th>
                                        <th>Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($special_offer as $specialoff):?>
                                        <tr>
                                        <td><?=$specialoff->offer_title;?></td>
                                        <td><?=$specialoff->start_date;?></td>
                                        <td><?=$specialoff->end_date;?></td>
                                        <td>
                                        <?php
                                            $this->db->where('roomtype_ID',  $specialoff->room_type);
                                            $query = $this->db->get('roomtype'); 
                                            $room_type_results =  $query->row_array();
                                            $rtypename = ($specialoff->room_type=='0')? "All Room Type" : $room_type_results['type_name'];
                                            echo $rtypename;
                                       ;?>
                                        
                                        </td>
                                        <td><?=$specialoff->price_deduc ."% of room price";?></td>
                                        <td><?=$specialoff->min_stay." Night(s)";?></td>
                                        <td>
                                        <a href="<?php echo base_url();?>dashboard/get_special_offer_by_id/<?php echo $this->hasher->encrypt($specialoff->id); ?>" class="btn btn-xs btn-primary">Edit</a>
                                        <button type="button" id="delete_special_offer" data-id="<?=$this->hasher->encrypt($specialoff->id);?>" class="btn btn-xs btn-default">Delete</button>
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