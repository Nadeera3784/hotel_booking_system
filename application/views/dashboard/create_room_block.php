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
                    <li class="active"><span>Create Room Block</span></li>
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
                            <h6 class="panel-title txt-dark">Create Room Block</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <?php echo form_open("dashboard/create_room_block");?>  
                            <div class="form-inline mb-30">
                                <div class="form-group mr-15">
                                    <label class="control-label mr-10" for="blockstartdate">Check-in Date:</label>
                                    <input type="hidden" name="capacity" value="1" />
                                    <input type="text" class="form-control" id="blockstartdate" name="check_in" data-toggle="datetimepicker" data-target="#blockstartdate">
                                </div>
                                <div class="form-group mr-15">
                                    <label class="control-label mr-10" for="blockclosingdate">Check-out Date:</label>
                                    <input type="text" class="form-control" id="blockclosingdate" name="check_out" data-toggle="datetimepicker" data-target="#blockclosingdate">
                                </div>	
                                <div class="form-group mr-15">
                                    <button type="submit" name="search" class="btn  btn-primary">Search</button>
                                </div>
                            </div>
                        <?php echo form_close();?>

                        <?php if(isset($_POST['search'])):?>
                          <h4 class="mb-30 weight-500">Search Result :  <span class="txt-orange counter-anim data-rep"><?=$this->input->post('check_in', TRUE);?></span> <i class="ti ti-arrow-right"></i>  <span class="txt-orange counter-anim data-rep"><?=$this->input->post('check_out', TRUE);?></span> <i class="ti ti-arrow-right"></i> <span class="txt-orange counter-anim data-rep"><?=$this->block->nightCount;?></span> Night</h4>
                        <?php echo form_open("dashboard/update_room_block");?>  

                        <div class="form-wrap" id="visibility">		
						    <div class="form-group mr-15">
							    <label class="control-label mr-10" for="block_name">Description Or Name:</label>
							    <input type="text" class="form-control" name="block_name" id="block_name">
							</div>
                        </div>
                                                               
                        <table class="table  mb-0" id="visibility">
                            <thead>
                                <tr>
                                    <th>Room Type</th>
                                    <th>Availablity</th>
                                </tr>
                            </thead>
                            <tbody>

                        <?php
                           $gotSearchResult = false;
                           $idgenrator = 0;
                        ?>
                        <?php foreach($this->block->roomType as $room_type): ?>
                        <?php foreach($this->block->multiCapacity as $capid=>$capvalues): ?>

                            <?php
                                $room_result = $this->block->get_available_rooms($room_type['rtid'], $room_type['rtname'], $capid);
                            ?>
                            <?php if(intval($room_result['roomcnt']) > 0):?>
                            <?php $gotSearchResult = true; ?>	             
                             <tr>
                                <td class="month-name"><?=$room_type['rtname'];?>(<?=$capvalues['captitle'];?>)</td>
                                <td>
                                    <select class="form-control"  name="svars_selectedrooms[]">
                                        <?=$room_result['roomdropdown']?>
                                    </select>
                                </td>
                            </tr>
                            <?php $idgenrator++; ?>
                        <?php endif;?>
                        <?php endforeach;?>
                        <?php endforeach;?>
                        <?php if(!$gotSearchResult):?>
                        <style>
                           #visibility{
                               display: none;
                           }
                        </style>
                        <div class="alert alert-info alert-dismissable alert-style-1">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="zmdi zmdi-info-outline"></i>Sorry no room available as your searching criteria
                        </div>                         
                        <?php endif;?>
                            </tbody>
                        </table>
                        <?php if($gotSearchResult):?>
                           <button type="submit" name="submit" class="btn btn-sm btn-primary mt-10 ">Block</button>
                        <?php endif;?>
                        <?php echo form_close();?>   
                        <?php endif;?>
                        </div>
                    </div>
                </div>	
            </div>
		</div>
		<?php $this->load->view('dashboard/footer_copyright'); ?>
	</div>
</div>