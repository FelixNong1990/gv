<?php
function unpro_get_external_code(){
	ob_start();
	?>
	<link rel='stylesheet' id='usernoise-button-css'  href='<?php echo usernoise_url('/css/button.css?ver=' . UN_VERSION) ?>' type='text/css' media='all' />
	<script type='text/javascript' src='<?php echo includes_url('js/jquery/jquery.js') ?>'></script>
	<script type='text/javascript'>
	/* <![CDATA[ */
	var usernoiseButton = <?php echo json_encode(un_get_localization_array()); ?>
	/* ]]> */
	</script>
		<script type='text/javascript' src='<?php echo usernoise_url('/js/usernoise.js?ver='. UN_VERSION) ?>'></script>
	<script type='text/javascript' src='<?php echo usernoise_url('/js/button.js?ver='. UN_VERSION) ?>'></script>
	<?php
	return ob_get_clean();
}