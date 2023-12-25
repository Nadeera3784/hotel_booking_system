<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Customer lookup</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/customer_lookup"><span>Customer lookup</span></a></li>
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
                            <h6 class="panel-title txt-dark">Customer lookup</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table  class="table" id="customer_table">
                                    <thead>
                                        <tr>
                                            <th>Guset Name</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>MANAGE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($clients as $client):?>
                                        <tr>
                                            <td><?=$client->title.$client->first_name.$client->surname;?></td>
                                            <td><?=$client->city.",".$client->country;?></td>
                                            <td><?=$client->phone;?></td>
                                            <td><?=$client->email;?></td>
                                            <td>
                                               <a href="<?php echo base_url();?>dashboard/booking_list_by_client/<?=$this->hasher->encrypt($client->client_id);?>" class="btn btn-xs btn-default">View</a>                       
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