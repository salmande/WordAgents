		<style>
			:root {
				<?php if( isset($globals_admin['topbar_bg_color']) ): ?>
				--topbar-bg-color: <?php echo $globals_admin['topbar_bg_color']; ?>
				<?php endif;?>
			}
		</style>
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="<?php echo BASE_URL; ?>/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo BASE_URL; ?>/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo BASE_URL; ?>/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<!--end::Layout Themes-->

		<link type="image/png" rel="shortcut icon" href="<?php echo BASE_URL; ?>/assets/media/logos/favicon.png" />

		<!-- Custom CSS -->
		<link href="<?php echo BASE_URL; ?>/assets/css/custom.css" rel="stylesheet" type="text/css" />
				
<?php if( $wad_url == 'orders'): ?>

<style>
/* just for testing purpose */
.user-spp_id-3268 #orders tbody > tr:not([data-test-order]) .btn,
.user-spp_id-3278 #orders tbody > tr:not([data-test-order]) .btn,
.user-spp_id-4165 #orders tbody > tr:not([data-test-order]) .btn
{
	/*pointer-events: none;opacity: .1;*/
}
</style>

<?php endif; ?>