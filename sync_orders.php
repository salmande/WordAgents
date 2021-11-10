<?php
wad_header();

$limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 50;
$offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
$end = isset($_REQUEST['end']) ? $_REQUEST['end'] : 0;

?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			
			<?php if( isset($_REQUEST['submit']) ) :
				
				$data = array(
					'limit' => $limit,
					'offset' => $offset,
					'end' => $end,
				);
			
				wad_add_all_orders_from_spp($data);
			
			endif; ?>
	
				<h2 class="mb-6">Add All orders from SPP to OG</h2>
				<form method="post">
					<div class="row">
						<div class="col-xl-12 mb-10">
							<h3>Limit:</h3>
							<input type="text" class="form-control" name="limit" tabindex="3"  value="<?php echo $limit; ?>"/>
						</div>
						<div class="col-xl-12 mb-10">
							<h3>Offset:</h3>
							<input type="text" class="form-control" autofocus tabindex="1" name="offset" value="<?php echo $offset; ?>"/>
						</div>
						<div class="col-xl-12 mb-10">
							<h3>End:</h3>
							<input type="text" class="form-control" autofocus tabindex="2" name="end" value="<?php echo $end; ?>"/>
						</div>
					</div>
					<input type="submit" name="submit" class="btn btn-primary btn-lg btn-block"  tabindex="4"  value="Submit" />
				</form>
		</div>
	</div>
</div>
<?php echo wad_footer(); ?>