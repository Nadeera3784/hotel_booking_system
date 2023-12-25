</div>
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js"></script>
	<?php
	if(isset($js)){
		$arrlength = count($js);
		for($x = 0; $x < $arrlength; $x++) {
			echo '<script src="'.base_url() . $js[$x].'"></script>';
		}
	}
	?>
	<script src="<?php echo base_url(); ?>assets/admin/js/jquery.slimscroll.js"></script>
	<script src="<?php echo base_url(); ?>assets/admin/js/dropdown-bootstrap-extended.js"></script>
	<script src="<?php echo base_url(); ?>assets/admin/js/plugins.js"></script>
	<script type="application/javascript"> var base = "<?php echo base_url(); ?>";</script>
</body>
</html>
