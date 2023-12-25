<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Room Blocking</h5>
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
                            <h6 class="panel-title txt-dark">Room Block</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <div class="table-responsive">
							<table class="table" id="client_booking_list">
                                <thead>
                                    <tr>
                                        <th>Booking Id</th>
                                        <th>Name</th>
                                        <th>Check In Date</th>
                                        <th>Check Out Date</th>
                                        <th>Amount</th>
                                        <th>Booking Date</th>
                                        <th>Status</th>
                                        <th>MANAGE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($booking_list_client as $blc):?>
                                    <?php 
                                    if($blc->checkout >= date('Y-m-d') && $blc->is_deleted == 0 && $blc->is_block == 0 ){
                                        $status = '<span class="txt-orange">Active</span>';
                                        $action = '<a class="btn btn-primary btn-sm" href="javascript:;" id="cancel_room_by_client" data-id="'.$this->hasher->encrypt($blc->booking_id).'">Cancel</a>';
                                    }else if($blc->checkout < date('Y-m-d') && $blc->is_deleted == 0 && $blc->is_block == 0){
                                        $status = '<span class="txt-success">Completed</span>';	
                                        $action = '<a  class="btn btn-default btn-sm" href="javascript:;" id="delete_booking_by_client" data-id="'.$this->hasher->encrypt($blc->booking_id).'">Delete</a>';
                                    }else{
                                        $status = '<span class="txt-danger">Cancelled</span>';
                                        $action = '<a  class="btn btn-default btn-sm" href="javascript:;" id="delete_booking_by_client" data-id="'.$this->hasher->encrypt($blc->booking_id).'">Delete</a>';
                                    }
                                    ?>
                                    <tr>
                                        <td><?=$blc->booking_id;?></td>
                                        <td><?=$client['title']. $client['first_name'] . $client['surname'] ;?></td>
                                        <td><?=$blc->start_date;?></td>
                                        <td><?=$blc->end_date;?></td>
                                        <td><?=$this->config_manager->get_default_currency_symbol().$blc->total_cost;?></td>
                                        <td><?=$blc->booking_time;?></td>
                                        <td><?=$status;?></td>
                                        <td>
                                            <?=$action;?>
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