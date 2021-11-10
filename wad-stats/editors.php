<?php wad_header(); ?>
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	
	<?php $stats = wad_get_current_page_relative_class(); ?>
	
	<div class="<?php echo $stats; ?>-wrapper loading-content-wrapper" data-stats="<?php echo $stats; ?>">
		
		<div class="blockElement loading text-center">
			<div class="blockui"><span>Please wait...</span><span class="spinner spinner-loader spinner-primary "></span></div>
		</div>

		<div class="<?php echo $stats; ?>-inner loading-content hide">

			<form class="form-<?php echo $stats; ?>" method="post" action="<?php echo $stats; ?>">
			
				<!--begin::Subheader-->
				<div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
					<div class="container align-items-center justify-content-between flex-wrap flex-sm-nowrap">
						<!--begin::Details-->
						<div class="d-flex align-items-center flex-wrap mr-2">
							<!--begin::Title-->
							<h5 class="text-dark font-weight-bold mt-2 mb-4 mr-5">Stats</h5>
							<!--end::Title-->
							<!--begin::Separator-->
							<!--<div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div> -->
						</div>
						<div class="d-flex flex-wrap mr-2">
								<div class="mr-2 mb-2 mt-2">
									<div class="input-daterange input-group" id="kt_datepicker_5">
										<div class="input-group-append">
										   <span class="input-group-text">From</span>
										  </div>
										<input type="text" class="form-control w-150px" name="date_start" placeholder="Start date"/>
										<div class="input-group-append">
										   <span class="input-group-text">To</span>
										  </div>
										<input type="text" class="form-control w-150px" name="date_end" placeholder="End date" />
									</div>
								</div>
								<div class="mr-2 mb-2 mt-2">
									<?php $editors = wad_get_users("spp_id, name","role='editor' AND is_archive=0"); ?>
									<select name="editors[]" class="form-control dropdown-editors selectpicker" data-none-selected-text="Select editor(s)" data-actions-box="true" data-live-search="true" data-count-selected-text="{0} editors selected" data-selected-text-format="count" data-width="300px" multiple="multiple">
										<?php foreach($editors as $editor): ?>
											<option value="<?php echo $editor['spp_id']; ?>"><?php echo $editor['name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="mr-2 mb-2 mt-2">
									<?php $editors_archived = wad_get_users("spp_id, name","role='editor' AND is_archive=1"); ?>
									<select name="editors_archived[]" class="form-control dropdown-editors selectpicker" data-none-selected-text="Add archived editor(s)" data-actions-box="true" data-live-search="true" data-count-selected-text="{0} archived editors selected" data-selected-text-format="count" data-width="220px" multiple="multiple">
										<?php foreach($editors_archived as $editor): ?>
											<option value="<?php echo $editor['spp_id']; ?>"><?php echo $editor['name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="mr-2 mb-2 mt-2">
									<?php
									
									$columns = array(
										'completed_words' => 'Total Number of Words Completed',
										
										'completed_orders_count' => 'Total Number of Completed Orders',	
										'completed_orders' => 'Completed Orders',
										
										'ontime_completed_orders_count' => 'Total Number of Ontime Completed Orders',	
										'ontime_completed_orders' => 'Ontime Completed Orders',
										
										'completed_orders_with_seo_addons_count' => 'Total Number of Completed Orders with SEO Addons',
										'completed_orders_with_seo_addons' => 'Completed Orders with SEO Addons',
										
										'overdue_orders_count' => 'Total Number of Overdue Orders',
										'overdue_orders' => 'Overdue Orders',
										
										'final_review_count' => 'Total Number of Orders sent to Final Review',
										'final_review' => 'Orders sent to Final Review',
										
										'editor_revision_count' => 'Total Number of Orders sent to Editor Revision',
										'editor_revision' => 'Orders sent to Editor Revision',
										
										'editor_revision_previous_month_count' => 'Total Number of Orders sent to Editor Revision Over the Previous Month',
										'editor_revision_previous_month' => 'Orders sent to Editor Revision Over the Previous Month',
										
										'client_revision_count' => 'Total Number of Orders sent to Client Revision',
										'client_revision' => 'Orders sent to Client Revision',

										'client_revision_previous_month_count' => 'Total Number of Orders sent to Client Revision Over the Previous Month',
										'client_revision_previous_month' => 'Orders sent to Client Revision Over the Previous Month',
									);
									
									?>
									<select name="columns[]" class="form-control selectpicker" data-live-search="true" data-none-selected-text="Enable/disable columns" data-actions-box="true"  data-count-selected-text="{0} columns selected" data-selected-text-format="count" data-width="550px" multiple="multiple">
										<?php foreach($columns as $key=>$val): ?>
											<option value="<?php echo $key; ?>" <?php if(in_array($key,$globals['stats_editors_columns_default'])){ echo 'selected'; } ?>><?php echo $val; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="mb-2 mt-2">
								<button type="submit" class="btn btn-primary">Filter</button>
								</div>
						</div>
						<!--end::Details-->
					</div>
				</div>
				<!--end::Subheader-->
				
				<input type="hidden" name="ajax" value="1" />
				<input type="hidden" name="stats" value="<?php echo $stats; ?>" />
				<input type="hidden" name="page" value="<?php echo ( isset($_REQUEST['page']) ? $_REQUEST['page'] : 1 ) ?>" />
				<input type="hidden" name="per_page" value="<?php echo wad_get_per_page(); ?>" />
				<input type="hidden" name="export" value="" />
				
			</form>
		
			<!--begin::Entry-->
			<div class="d-flex flex-column-fluid content-<?php echo $stats; ?>-wrapper">
				<!--begin::Container-->
				<div class="container">
					<!--begin::Card-->
					<div class="card card-custom">
						<!--begin::Header-->
						<div class="card-header flex-wrap border-0 pt-6 pb-6">
							<div class="card-title">
								<h3 class="card-label">Editors</h3>
							</div>
							<div class="card-toolbar">
								<!--begin::Dropdown-->
								<div class="dropdown dropdown-inline mr-2">
								
									<?php /* <select class="select-export selectpicker" name="select-export" data-hide-disabled="false" data-none-selected-text="Export" data-style="btn-primary btn-export" multiple data-max-options="1" data-width="130px" >
										<option value="displaying">Displaying</option>
										<option value="all">All</option>
									</select> */ ?>
								
									<button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle btn-export" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="svg-icon svg-icon-md"></span>Export
									</button>
									<!--begin::Dropdown Menu-->
									<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right dropdown-export">
										<!--begin::Navigation-->
										<ul class="navi flex-column navi-hover py-2">
											<li class="navi-item">
												<a href="javascript:void(0)" class="navi-link" data-value="displaying">
													<span class="navi-icon">
														<i class="la la-print"></i>
													</span>
													<span class="navi-text">Displaying</span>
												</a>
											</li>
											<li class="navi-item">
												<a href="javascript:void(0)" class="navi-link" data-value="all">
													<span class="navi-icon">
														<i class="la la-copy"></i>
													</span>
													<span class="navi-text">All</span>
												</a>
											</li>
										</ul>
										<!--end::Navigation-->
									</div>
									<!--end::Dropdown Menu-->
								</div>
								<!--end::Dropdown-->
							</div>
						</div>
						<!--end::Header-->
						<!--begin::Body-->
						<div class="card-body">
							<!--begin: table-->
							<?php echo wad_stats_editors($stats); ?>
							<!--end: table-->
						</div>
						<!--end::Body-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Container-->
			</div>
			<!--end::Entry-->
		</div>
	</div>
</div>
<!--end::Content-->
<?php wad_footer(); ?>