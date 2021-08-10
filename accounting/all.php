<?php wad_header(); ?>
	<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Entry-->
		<div class="d-flex flex-column-fluid">
			<!--begin::Container-->
			<div class="container">
				<div class="card card-custom gutter-b">
					<div class="card-header">
						<div class="card-title">
							<h3 class="card-label">Total Earnings</h3>
						</div>
					</div>
					<div class="card-body" id="orders">
						<?php
						require 'parts/accounting/table/all.php';?>
					</div>
				</div>
			</div>
			<!--end::Container-->
		</div>
		<!--end::Entry-->
	</div>
	<!--end::Content-->
<?php wad_footer(); ?>