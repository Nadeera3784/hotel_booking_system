<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Booking List</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/booking"><span>Booking List</span></a></li>
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
                            <h6 class="panel-title txt-dark">Booking List</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <?php $attributes = array("id" => "booking_form_cp", "novalidate" => "novalidate");?>
                        <?php echo form_open("dashboard/booking", $attributes);?>      
                            <div class="form-inline mb-30">
                                <div class="form-group mr-15">
                                    <label class="control-label mr-10" for="book_type">Roomtype:</label>
                                    <select name="book_type" id="book_type" class="form-control required">
                                        <option value="">---Select Type---</option>
                                        <option value="1">Active Booking</option>
                                        <option value="2">Booking History</option>
                                    </select>  
                                </div>
                                <div class="form-group mr-15">
                                    <label class="control-label mr-10" for="startdatebooking">From:</label>
                                    <input type="text" class="form-control" id="startdatebooking" name="startdate" data-toggle="datetimepicker" data-target="#startdatebooking">
                                </div>
                                <div class="form-group mr-15">
                                    <label class="control-label mr-10" for="closingdatebooking">To:</label>
                                    <input type="text" class="form-control" id="closingdatebooking" name="closingdate" data-toggle="datetimepicker" data-target="#closingdatebooking">
                                </div>	
                                <div class="form-group mr-15">
                                    <label class="control-label mr-10" for="shortby">By:</label>
                                    <select name="shortby"  class="form-control">
                                        <option value="booking_time" selected="selected">Booking Date</option>
                                        <option value="start_date">Check-in Date</option>
                                        <option value="end_date">Check-out Date</option>
                                    </select>
                                </div>
                                <div class="form-group mr-15">
                                        <button type="submit" name="submit_booking_form"  class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        <?php echo form_close();?>
                        <?php if(isset($text_cond)) :?>
                        <h4><?php echo $text_cond;?></h4>
                        <hr class="light-grey-hr row mt-10 mb-15">
                        <?php endif;?>
                        <?php if(isset($rooms)):?>
                            <div class="table-responsive">
                                <table class="table" id="room_table">
                                    <thead>
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Name</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Amount</th>
                                            <th>Booking Date</th>
                                            <th>Status</th>
                                            <th>manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($rooms as $room): ?>
                                        <tr>
                                            <td><?=$room->booking_id;?></td>
                                            <td>
                                                <?php
                                                   $client = $this->common->get_client_by_id($room->client_id);
                                                   echo  $client['title'] . $client['first_name'] . $client['surname'];
                                                ?>
                                            </td>
                                            <td><?=$room->start_date;?></td>
                                            <td><?=$room->end_date;?></td>
                                            <td><?=$this->config_manager->get_default_currency_symbol().$room->total_cost;?></td>
                                            <td><?=$room->booking_time;?></td>
                                            <td><span class="label label-<?=($room->payment_success == 1)? "primary": "default";?>"><?=($room->payment_success == 1)? "confirmed": "pending";?></span></td>
                                            <td>
                                            <button type="button" id="view_single_booking" data-id="<?=$this->hasher->encrypt($room->booking_id);?>" class="btn btn-sm btn-primary">View</button>
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

                                                <?php if($title == "Active"): ?>
                                                <a href="#" id="cancel_room" data-id="<?=$this->hasher->encrypt($room->booking_id);?>" data-type="active" class="btn btn-sm btn-default">Cancel</a>
                                                <?php else: ?>
                                                <a href="#" id="delete_booking_room" data-id="<?=$this->hasher->encrypt($room->booking_id);?>" class="btn btn-sm btn-default">Delete</a>
                                                <?php endif;?>
                                            </td>
                                        </tr>
                                     <?php endforeach;?>
                                    <tbody>                                
                                </table>
                            </div>
                        <?php endif;?>
                        </div>
                    </div>
                </div>	
            </div>
		</div>
		<?php $this->load->view('dashboard/footer_copyright'); ?>
	</div>
</div>