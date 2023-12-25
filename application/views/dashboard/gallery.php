<div class="page-wrapper">
    <div class="container">
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Gallery</h5>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url();?>dashboard/index">Dashboard</a></li>
                    <li><a href="<?=base_url();?>dashboard/gallery"><span>Gallery</span></a></li>
                    <li class="active"><span>Gallery</span></li>
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
                <div class="page-overlay">
                    <div class="spinner"><span class="sp sp1"></span><span class="sp sp2"></span><span class="sp sp3"></span></div>
                </div>
                <div id="AjaxResponse"></div>

                <div class="panel panel-default border-panel card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Gallery</h6>
                        </div>
                        <div class="pull-right">
                           <a href="<?php echo base_url();?>dashboard/create_gallery" class="btn btn-sm btn-primary shadow shadow--big">New</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                        <div class="form-wrap">
                            <form class="form-inline">
                                <div class="form-group mr-15">
                                    <label class="control-label mr-10" for="email_inline">Select Room Type:</label>
                                    <select class="form-control" name="room_gallery" id="room_gallery">
                                      <option value="0">---- Select ----</option>
                                       <?php foreach($room_type as $rt): ?>
                                           <?php foreach($capacity as $cap): ?>
                                               <option   value="<?=$rt->roomtype_ID.'#'.$cap->id;?>"><?=$rt->type_name;?>(<?=$cap->title;?>)</option>
                                           <?php endforeach;?>
                                       <?php endforeach;?>
                                    </select>                                
                                </div>
                            </form>
                            <div class="row">
                                <div class="image-container"></div>
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