<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Rooms</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li class="active"><a href="<?=base_url();?>dashboard/rooms"><span>Rooms</span></a></li>
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
                            <h6 class="panel-title txt-dark">Rooms</h6>
                        </div>
                        <div class="pull-right">
                           <a href="<?php echo base_url();?>dashboard/create_room" class="btn btn-sm btn-primary shadow shadow--big">New</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <div class="table-responsive">
							<table class="table mb-0" id="room-table">
                                <thead>
                                    <tr>
                                        <th>room type</th>
                                        <th>adult</th>
                                        <th>child</th>
                                        <th>total room</th>
                                        <th>MANAGE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($rooms as $room):?>
                                    <tr>
                                        <td><?=$room->type_name;?></td>
                                        <td><?=$room->title;?>  <span class="label label-primary"><?=$room->capacity;?></span></td>
                                        <td><?=$room->no_of_child;?></td>
                                        <td><?=$room->NoOfRoom;?></td>
                                        <td>
                                           <a href="<?php echo base_url();?>dashboard/get_room_by_id?rid=<?=$this->hasher->encrypt($room->roomtype_id);?>&cid=<?=$this->hasher->encrypt($room->capacity_id);?>" class="btn btn-xs btn-primary">Edit</a>
                                            <button type="button" id="delete_room"  data-rid="<?=$this->hasher->encrypt($room->roomtype_id);?>" data-cid="<?=$this->hasher->encrypt($room->capacity_id);?>" class="btn btn-xs btn-default">Delete</button>
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