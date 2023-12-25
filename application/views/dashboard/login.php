<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>dashboard</title>
		<meta name="description" content="#" />
		<meta name="keywords" content="#" />
		<meta name="author" content="#"/>
		<link rel="shortcut icon" href="favicon.ico">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link href="<?php echo base_url(); ?>assets/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo base_url(); ?>assets/admin/css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>	
		<div class="wrapper  pa-0">
			<div class="page-wrapper pa-0 ma-0 auth-page">
				<div class="container">
					<div class="table-struct full-width full-height">
						<div class="table-cell vertical-align-middle auth-form-wrap">
							<div class="auth-form  ml-auto mr-auto no-float card-view pt-30 pb-30">
								<div class="row">
									<div class="col-sm-12 col-xs-12">
										<div class="mb-30">
											<h3 class="text-center txt-dark mb-10">Sign in to Dashboard</h3>
											<h6 class="text-center nonecase-font txt-grey">Enter your details below</h6>
										</div>	
										<div class="form-wrap">
                                            <?php echo form_open("auth/login");?>
                                            <?php if($this->session->flashdata('message')): ?>
                                               <?php echo $this->session->flashdata('message'); ?>
                                            <?php endif;?>
												<div class="form-group">
													<label class="control-label mb-10" for="identity"><?php echo lang('login_identity_label', 'identity');?></label>
													<input type="text" class="form-control"  name="identity" id="identity" placeholder="Enter email">
                                                    <?php echo form_error('identity'); ?>
												</div>
												<div class="form-group">
													<label class="pull-left control-label mb-10" for="password"><?php echo lang('login_password_label', 'password');?></label>
													<a class="capitalize-font txt-orange block mb-10 pull-right font-12" href="forgot-password.html">forgot password ?</a>
													<div class="clearfix"></div>
													<input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                                                    <?php echo form_error('password'); ?>
												</div>
												
												<div class="form-group">
													<div class="checkbox checkbox-primary pr-10 pull-left">
														<input id="remember"  name="remember" value="1" type="checkbox">
														<label for="checkbox_2"> Keep me logged in</label>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="form-group text-center">
													<button type="submit" class="btn btn-primary btn-block">sign in</button>
												</div>
                                            <?php echo form_close();?>
										</div>
									</div>	
								</div>
							</div>
						</div>
					</div>	
				</div>	
			</div>
		</div>
		<script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/admin/js/jquery.slimscroll.js"></script>
		<script src="<?php echo base_url(); ?>assets/admin/js/plugins.js"></script>
	</body>
</html>
