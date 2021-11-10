<?php
global $globals;
$orders_per_page = wad_get_option('orders_per_page');
$orders_per_page_dropdown = wad_get_option('orders_per_page_dropdown');
?>
<script type="text/javascript">
var BASE_URL = '<?php echo BASE_URL; ?>',
	ORDERS_PER_PAGE = '<?php echo $orders_per_page; ?>',
	ORDERS_PER_PAGE_DROPDOWN = '<?php echo $orders_per_page_dropdown; ?>',
	WAD_AJAX_URL = BASE_URL+'/ajax';
</script>
<?php
if(is_user_logged_in()):
	$order_complete_client_email_templates = $globals['order_complete_client_email_templates']; ?>
	<script type="text/javascript">
	var ORDER_COMPLETE_CLIENT_EMAIL_TEMPLATE_1 = '<?php echo $order_complete_client_email_templates[0]; ?>',
		ORDER_COMPLETE_CLIENT_EMAIL_TEMPLATE_2 = '<?php echo $order_complete_client_email_templates[1]; ?>';
	</script> <?php
endif; ?>
<script src="<?php echo BASE_URL; ?>/assets/js/custom.js"></script>