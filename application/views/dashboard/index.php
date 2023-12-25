<div class="page-wrapper">
    <div class="container pt-30">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4 col-xs-6">
                    <div class="panel panel-default card-view pa-0">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body pa-0">
                                <div class="sm-data-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                <span class="txt-dark block counter">
                                                    <span><?php echo ($trevenue->total_cost)? $trevenue->total_cost : "0.00";?> </span>
                                                </span>
                                                <span class="capitalize-font block">Revenue</span>
                                            </div>
                                            <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                <i class="pe-7s-wallet data-right-rep-icon text-blue"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <div class="panel panel-default card-view pa-0">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body pa-0">
                                <div class="sm-data-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                <span class="txt-dark block counter"><span><?php echo $total_rooms->capacity;?></span></span>
                                                <span class="capitalize-font block">Rooms</span>
                                            </div>
                                            <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                <i class="icon-home data-right-rep-icon text-blue"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <div class="panel panel-default card-view pa-0">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body pa-0">
                                <div class="sm-data-box">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                <span class="txt-dark block counter"><?php echo $total_guest->numc;?></span>
                                                <span class="capitalize-font block">Guest</span>
                                            </div>
                                            <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                <i class="icon-people  data-right-rep-icon text-blue"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="panel panel-default border-panel card-view panel-refresh">
                        <div class="refresh-container">
                            <div class="la-anim-1"></div>
                        </div>
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h6 class="panel-title txt-dark">Weekly Revenue Report <?php echo date('Y-m-d', strtotime('- 6 days'))?> - <?php echo date('Y-m-d');?></h6>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="pull-left inline-block refresh mr-15">
                                    <i class="zmdi zmdi-replay"></i>
                                </a>
                                <a href="#" class="pull-left inline-block full-screen mr-15">
                                    <i class="zmdi zmdi-fullscreen"></i>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body row pa-0">
                              <div id="weeklyrevenuechart"></div>
                            </div>	
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="panel panel-default border-panel card-view panel-refresh">
                        <div class="refresh-container">
                            <div class="la-anim-1"></div>
                        </div>
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h6 class="panel-title txt-dark">Today Check-Out List</h6>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="pull-left inline-block refresh mr-15">
                                    <i class="zmdi zmdi-replay"></i>
                                </a>
                                <a href="#" class="pull-left inline-block full-screen mr-15">
                                    <i class="zmdi zmdi-fullscreen"></i>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body row pa-0">
                            <div class="table-responsive">
							<table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Name</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Amount</th>
                                        <th>Booking Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($checking_out as $checkingout):?>
                                    <tr>
                                        <td><?=$checkingout->booking_id;?></td>
                                        <td>
                                        <?php
                                        $client = $this->common->get_client_by_id($checkingout->client_id);
                                        echo  $client['title'] . $client['first_name'] . $client['surname'];
                                        ?>
                                        </td>
                                        <td><?=$checkingout->start_date;?></td>
                                        <td><?=$checkingout->end_date;?></td>
                                        <td><?=$checkingout->total_cost;?></td>
                                        <td><?=$checkingout->booking_time;?></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                            </div>	
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <div class="panel panel-default border-panel card-view panel-refresh">
                        <div class="refresh-container">
                            <div class="la-anim-1"></div>
                        </div>
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h6 class="panel-title txt-dark">Today Check-In List</h6>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="pull-left inline-block refresh mr-15">
                                    <i class="zmdi zmdi-replay"></i>
                                </a>
                                <a href="#" class="pull-left inline-block full-screen mr-15">
                                    <i class="zmdi zmdi-fullscreen"></i>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body row pa-0">
                            <div class="table-responsive">
							<table class="table mb-0" id="room_table">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Name</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Amount</th>
                                        <th>Booking Date</th>
                                        <th>manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($checking_list as $check_l):?>
                                    <tr>
                                        <td><?=$check_l->booking_id;?></td>
                                        <td>
                                        <?php
                                        $client = $this->common->get_client_by_id($check_l->client_id);
                                        echo  $client['title'] . $client['first_name'] . $client['surname'];
                                        ?>
                                        </td>
                                        <td><?=$check_l->start_date;?></td>
                                        <td><?=$check_l->end_date;?></td>
                                        <td><?=$check_l->total_cost;?></td>
                                        <td><?=$check_l->booking_time;?></td>
                                        <td>
                                        <button type="button" id="view_single_booking" data-id="<?=$this->hasher->encrypt($check_l->booking_id);?>" class="btn btn-sm btn-primary">View</button>
                                            <div id="view_booking_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h5 class="modal-title" id="myModalLabel">Booking Details</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    <div class="label-chatrs">
                                                        <div class="">
                                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                                                <span class="block font-15  mt-5">Name</span>
                                                            </span>
                                                            <div class="pull-right"><span class="font-18" id="name"></span></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <hr class="light-grey-hr row mt-10 mb-15">
                                                    <div class="label-chatrs">
                                                        <div class="">
                                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                                                <span class="block font-15  mt-5">Email</span>
                                                            </span>
                                                            <div class="pull-right"><span class="font-18" id="email"></span></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>                                                   
                                                    <hr class="light-grey-hr row mt-10 mb-15">
                                                    <div class="label-chatrs">
                                                        <div class="">
                                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                                                <span class="block font-15  mt-5">Phone</span>
                                                            </span>
                                                            <div class="pull-right"><span class="font-18" id="phone"></span></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <hr class="light-grey-hr row mt-10 mb-15">
                                                    <div class="label-chatrs">
                                                        <div class="">
                                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                                                <span class="block font-15  mt-5">Address</span>
                                                            </span>
                                                            <div class="pull-right"><span class="font-18" id="address"></span></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>                                                    
                                                    <hr class="light-grey-hr row mt-10 mb-15">
                                                    <div class="label-chatrs">
                                                        <div class="">
                                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                                                <span class="block font-15  mt-5">City</span>
                                                            </span>
                                                            <div class="pull-right"><span class="font-18" id="city"></span></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>                                                    
                                                    <hr class="light-grey-hr row mt-10 mb-15">
                                                    <div class="label-chatrs">
                                                        <div class="">
                                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                                                <span class="block font-15  mt-5">Country</span>
                                                            </span>
                                                            <div class="pull-right"><span class="font-18" id="country"></span></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <hr class="light-grey-hr row mt-10 mb-15">
                                                    <div class="label-chatrs">
                                                        <div class="">
                                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                                                <span class="block font-15  mt-5">Zip Code</span>
                                                            </span>
                                                            <div class="pull-right"><span class="font-18" id="zip_code"></span></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <hr class="light-grey-hr row mt-10 mb-15">
                                                    <div class="label-chatrs">
                                                        <div class="">
                                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                                                <span class="block font-15  mt-5">Identity Type</span>
                                                            </span>
                                                            <div class="pull-right"><span class="font-18" id="i_type"></span></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <hr class="light-grey-hr row mt-10 mb-15">
                                                    <div class="label-chatrs">
                                                        <div class="">
                                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                                                <span class="block font-15  mt-5">Identity Number</span>
                                                            </span>
                                                            <div class="pull-right"><span class="font-18" id="i_number"></span></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <hr class="light-grey-hr row mt-10 mb-15">
                                                    <div class="label-chatrs">
                                                        <div class="">
                                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                                                <span class="block font-15  mt-5">Additional Request</span>
                                                            </span>
                                                            <div class="pull-right"><span class="font-18" id="ar"></span></div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <div id="invoice"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                                 </div>
									        </div>                                            
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

	</div>
		<?php $this->load->view('dashboard/footer_copyright'); ?>
	</div>
</div>