<?php
$orders_per_page = wad_get_option('orders_per_page');
$orders_per_page_dropdown = wad_get_option('orders_per_page_dropdown');
?>
<script type="text/javascript">
var BASE_URL = '<?php echo BASE_URL; ?>',
	ORDERS_PER_PAGE = '<?php echo $orders_per_page; ?>',
	ORDERS_PER_PAGE_DROPDOWN = '<?php echo $orders_per_page_dropdown; ?>',
	WAD_AJAX_URL = BASE_URL+'/ajax';
</script>
<script src="<?php echo BASE_URL; ?>/assets/js/custom.js"></script>