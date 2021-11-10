<?php global $globals; ?>
<?php wad_header(); 

$enable_weekly_quota = $user['enable_weekly_quota'];
$enable_onetime_quota = $user['enable_onetime_quota'];
$claim_one_order = $user['claim_one_order'];
$editor_revision_count_limit = $user['editor_revision_count_limit'];
$enable_claim = $user['enable_claim'];
$is_archive = $user['is_archive'];
//echo '<pre>'; print_r($user); echo '</pre>';?>
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<?php /*<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
							<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-1">
									<!--begin::Mobile Toggle-->
									<button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none" id="kt_subheader_mobile_toggle">
										<span></span>
									</button>
									<!--end::Mobile Toggle-->
									<!--begin::Page Heading-->
									<div class="d-flex align-items-baseline flex-wrap mr-5">
										<!--begin::Page Title-->
										<h5 class="text-dark font-weight-bold my-1 mr-5">Profile 2</h5>
										<!--end::Page Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
											<li class="breadcrumb-item">
												<a href="" class="text-muted">Apps</a>
											</li>
											<li class="breadcrumb-item">
												<a href="" class="text-muted">Profile</a>
											</li>
											<li class="breadcrumb-item">
												<a href="" class="text-muted">Profile 2</a>
											</li>
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page Heading-->
								</div>
								<!--end::Info-->
								<!--begin::Toolbar-->
								<div class="d-flex align-items-center">
									<!--begin::Actions-->
									<a href="#" class="btn btn-light-primary font-weight-bolder btn-sm">Actions</a>
									<!--end::Actions-->
									<!--begin::Dropdown-->
									<div class="dropdown dropdown-inline" data-toggle="tooltip" title="Quick actions" data-placement="left">
										<a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="svg-icon svg-icon-success svg-icon-2x">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Files/File-plus.svg-->
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24" />
														<path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000" />
													</g>
												</svg>
												<!--end::Svg Icon-->
											</span>
										</a>
										<div class="dropdown-menu dropdown-menu-md dropdown-menu-right p-0 m-0">
											<!--begin::Navigation-->
											<ul class="navi navi-hover">
												<li class="navi-header font-weight-bold py-4">
													<span class="font-size-lg">Choose Label:</span>
													<i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="Click to learn more..."></i>
												</li>
												<li class="navi-separator mb-3 opacity-70"></li>
												<li class="navi-item">
													<a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-success">Customer</span>
														</span>
													</a>
												</li>
												<li class="navi-item">
													<a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-danger">Partner</span>
														</span>
													</a>
												</li>
												<li class="navi-item">
													<a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-warning">Suplier</span>
														</span>
													</a>
												</li>
												<li class="navi-item">
													<a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-primary">Member</span>
														</span>
													</a>
												</li>
												<li class="navi-item">
													<a href="#" class="navi-link">
														<span class="navi-text">
															<span class="label label-xl label-inline label-light-dark">Staff</span>
														</span>
													</a>
												</li>
												<li class="navi-separator mt-3 opacity-70"></li>
												<li class="navi-footer py-4">
													<a class="btn btn-clean font-weight-bold btn-sm" href="#">
													<i class="ki ki-plus icon-sm"></i>Add new</a>
												</li>
											</ul>
											<!--end::Navigation-->
										</div>
									</div>
									<!--end::Dropdown-->
								</div>
								<!--end::Toolbar-->
							</div>
						</div> */ ?>
						<!--end::Subheader-->
						<!--begin::Entry-->
						<div class="d-flex">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Profile 2-->
								<div class="d-flex flex-row">
									<!--begin::Aside-->
									<div class="flex-row-auto card card-custom offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
										<!--begin::Card-->
										<div class="">
											<!--begin::Body-->
											<div class="card-body pt-15">
												<!--begin::User-->
												<div class="text-center mb-10">
													<div class="symbol symbol-60 symbol-circle symbol-xl-90">
														<!-- <div class="symbol-label" style="background-image:url('assets/media/users/300_21.jpg')"></div> -->
														<span class="symbol-label font-size-h5 font-weight-bold"><?php echo $user['name'][0]; ?></span>
														<!-- <i class="symbol-badge symbol-badge-bottom bg-success"></i> -->
													</div>
													<h4 class="font-weight-bold my-2"><?php echo $user['name']; ?></h4>
													<div class="text-muted mb-2"><?php echo $user['role']; ?></div>
													<?php /* <span class="label label-light-warning label-inline font-weight-bold label-lg">Active</span> */ ?>
													
													
													
												</div>
												<!--end::User-->
												<!--begin::Contact-->
												<?php /*<div class="mb-10 text-center">
													<a href="#" class="btn btn-icon btn-circle btn-light-facebook mr-2">
														<i class="socicon-facebook"></i>
													</a>
													<a href="#" class="btn btn-icon btn-circle btn-light-twitter mr-2">
														<i class="socicon-twitter"></i>
													</a>
													<a href="#" class="btn btn-icon btn-circle btn-light-google">
														<i class="socicon-google"></i>
													</a>
												</div>*/ ?>
												
												
												
												
												<!--end::Contact-->
												<!--begin::Nav-->
												<ul class="nav flex-column nav-pills">
												<?php /* <li class="nav-item"><a href="#" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block" data-toggle="tab" data-target="#wad_profile_overview" role="tab">Profile Overview</a></li> */ ?>
												<li class="nav-item"><a href="#" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block active" data-toggle="tab" data-target="#wad_profile_personal_info" role="tab">Personal info</a></li>
												<?php /* <a href="#" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block">Account Info</a>
												<a href="#" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block">Change Passwort</a>
												<a href="#" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block">Email Settings</a>
												<a href="#" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block">Saved Credit Cards</a>
												<a href="#" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block">Tax information</a> */ ?>
												</ul>
												<!--end::Nav-->
											</div>
											<!--end::Body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Aside-->
									<!--begin::Content-->
									<div class="flex-row-fluid ml-lg-8">
										<div class="tab-content">
											<!--begin::Profile Overview-->
											<div class="tab-pane fade" id="wad_profile_overview">
												<!--begin::Row-->
												<div class="row">
													<div class="col-lg-6">
														<!--begin::List Widget 10-->
														<div class="card card-custom card-stretch gutter-b">
															<!--begin::Header-->
															<div class="card-header border-0">
																<h3 class="card-title font-weight-bolder text-dark">Notifications</h3>
																<div class="card-toolbar">
																	<div class="dropdown dropdown-inline">
																		<a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																			<i class="ki ki-bold-more-ver"></i>
																		</a>
																		<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
																			<!--begin::Naviigation-->
																			<ul class="navi">
																				<li class="navi-header font-weight-bold py-5">
																					<span class="font-size-lg">Add New:</span>
																					<i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="Click to learn more..."></i>
																				</li>
																				<li class="navi-separator mb-3 opacity-70"></li>
																				<li class="navi-item">
																					<a href="#" class="navi-link">
																						<span class="navi-icon">
																							<i class="flaticon2-shopping-cart-1"></i>
																						</span>
																						<span class="navi-text">Order</span>
																					</a>
																				</li>
																				<li class="navi-item">
																					<a href="#" class="navi-link">
																						<span class="navi-icon">
																							<i class="navi-icon flaticon2-calendar-8"></i>
																						</span>
																						<span class="navi-text">Members</span>
																						<span class="navi-label">
																							<span class="label label-light-danger label-rounded font-weight-bold">3</span>
																						</span>
																					</a>
																				</li>
																				<li class="navi-item">
																					<a href="#" class="navi-link">
																						<span class="navi-icon">
																							<i class="navi-icon flaticon2-telegram-logo"></i>
																						</span>
																						<span class="navi-text">Project</span>
																					</a>
																				</li>
																				<li class="navi-item">
																					<a href="#" class="navi-link">
																						<span class="navi-icon">
																							<i class="navi-icon flaticon2-new-email"></i>
																						</span>
																						<span class="navi-text">Record</span>
																						<span class="navi-label">
																							<span class="label label-light-success label-rounded font-weight-bold">5</span>
																						</span>
																					</a>
																				</li>
																				<li class="navi-separator mt-3 opacity-70"></li>
																				<li class="navi-footer pt-5 pb-4">
																					<a class="btn btn-light-primary font-weight-bolder btn-sm" href="#">More options</a>
																					<a class="btn btn-clean font-weight-bold btn-sm d-none" href="#" data-toggle="tooltip" data-placement="right" title="Click to learn more...">Learn more</a>
																				</li>
																			</ul>
																			<!--end::Naviigation-->
																		</div>
																	</div>
																</div>
															</div>
															<!--end::Header-->
															<!--begin::Body-->
															<div class="card-body pt-0">
																<!--begin::Item-->
																<div class="mb-6">
																	<!--begin::Content-->
																	<div class="d-flex align-items-center flex-grow-1">
																		<!--begin::Checkbox-->
																		<label class="checkbox checkbox-lg checkbox-lg flex-shrink-0 mr-4">
																			<input type="checkbox" value="1" />
																			<span></span>
																		</label>
																		<!--end::Checkbox-->
																		<!--begin::Section-->
																		<div class="d-flex flex-wrap align-items-center justify-content-between w-100">
																			<!--begin::Info-->
																			<div class="d-flex flex-column align-items-cente py-2 w-75">
																				<!--begin::Title-->
																				<a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Daily Standup Meeting</a>
																				<!--end::Title-->
																				<!--begin::Data-->
																				<span class="text-muted font-weight-bold">Due in 2 Days</span>
																				<!--end::Data-->
																			</div>
																			<!--end::Info-->
																			<!--begin::Label-->
																			<span class="label label-lg label-light-primary label-inline font-weight-bold py-4">Approved</span>
																			<!--end::Label-->
																		</div>
																		<!--end::Section-->
																	</div>
																	<!--end::Content-->
																</div>
																<!--end::Item-->
																<!--begin::Item-->
																<div class="mb-6">
																	<!--begin::Content-->
																	<div class="d-flex align-items-center flex-grow-1">
																		<!--begin::Checkbox-->
																		<label class="checkbox checkbox-lg checkbox-lg flex-shrink-0 mr-4">
																			<input type="checkbox" value="1" />
																			<span></span>
																		</label>
																		<!--end::Checkbox-->
																		<!--begin::Section-->
																		<div class="d-flex flex-wrap align-items-center justify-content-between w-100">
																			<!--begin::Info-->
																			<div class="d-flex flex-column align-items-cente py-2 w-75">
																				<!--begin::Title-->
																				<a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Group Town Hall Meet-up with showcase</a>
																				<!--end::Title-->
																				<!--begin::Data-->
																				<span class="text-muted font-weight-bold">Due in 2 Days</span>
																				<!--end::Data-->
																			</div>
																			<!--end::Info-->
																			<!--begin::Label-->
																			<span class="label label-lg label-light-warning label-inline font-weight-bold py-4">In Progress</span>
																			<!--end::Label-->
																		</div>
																		<!--end::Section-->
																	</div>
																	<!--end::Content-->
																</div>
																<!--end::Item-->
																<!--begin::Item-->
																<div class="mb-6">
																	<!--begin::Content-->
																	<div class="d-flex align-items-center flex-grow-1">
																		<!--begin::Checkbox-->
																		<label class="checkbox checkbox-lg checkbox-lg flex-shrink-0 mr-4">
																			<input type="checkbox" value="1" />
																			<span></span>
																		</label>
																		<!--end::Checkbox-->
																		<!--begin::Section-->
																		<div class="d-flex flex-wrap align-items-center justify-content-between w-100">
																			<!--begin::Info-->
																			<div class="d-flex flex-column align-items-cente py-2 w-75">
																				<!--begin::Title-->
																				<a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Next sprint planning and estimations</a>
																				<!--end::Title-->
																				<!--begin::Data-->
																				<span class="text-muted font-weight-bold">Due in 2 Days</span>
																				<!--end::Data-->
																			</div>
																			<!--end::Info-->
																			<!--begin::Label-->
																			<span class="label label-lg label-light-success label-inline font-weight-bold py-4">Success</span>
																			<!--end::Label-->
																		</div>
																		<!--end::Section-->
																	</div>
																	<!--end::Content-->
																</div>
																<!--end::Item-->
																<!--begin::Item-->
																<div class="mb-6">
																	<!--begin::Content-->
																	<div class="d-flex align-items-center flex-grow-1">
																		<!--begin::Checkbox-->
																		<label class="checkbox checkbox-lg checkbox-lg flex-shrink-0 mr-4">
																			<input type="checkbox" value="1" />
																			<span></span>
																		</label>
																		<!--end::Checkbox-->
																		<!--begin::Section-->
																		<div class="d-flex flex-wrap align-items-center justify-content-between w-100">
																			<!--begin::Info-->
																			<div class="d-flex flex-column align-items-cente py-2 w-75">
																				<!--begin::Title-->
																				<a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Sprint delivery and project deployment</a>
																				<!--end::Title-->
																				<!--begin::Data-->
																				<span class="text-muted font-weight-bold">Due in 2 Days</span>
																				<!--end::Data-->
																			</div>
																			<!--end::Info-->
																			<!--begin::Label-->
																			<span class="label label-lg label-light-danger label-inline font-weight-bold py-4">Rejected</span>
																			<!--end::Label-->
																		</div>
																		<!--end::Section-->
																	</div>
																	<!--end::Content-->
																</div>
																<!--end: Item-->
																<!--begin: Item-->
																<div class="">
																	<!--begin::Content-->
																	<div class="d-flex align-items-center flex-grow-1">
																		<!--begin::Checkbox-->
																		<label class="checkbox checkbox-lg checkbox-lg flex-shrink-0 mr-4">
																			<input type="checkbox" value="1" />
																			<span></span>
																		</label>
																		<!--end::Checkbox-->
																		<!--begin::Section-->
																		<div class="d-flex flex-wrap align-items-center justify-content-between w-100">
																			<!--begin::Info-->
																			<div class="d-flex flex-column align-items-cente py-2 w-75">
																				<!--begin::Title-->
																				<a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">Data analytics research showcase</a>
																				<!--end::Title-->
																				<!--begin::Data-->
																				<span class="text-muted font-weight-bold">Due in 2 Days</span>
																				<!--end::Data-->
																			</div>
																			<!--end::Info-->
																			<!--begin::Label-->
																			<span class="label label-lg label-light-warning label-inline font-weight-bold py-4">In Progress</span>
																			<!--end::Label-->
																		</div>
																		<!--end::Section-->
																	</div>
																	<!--end::Content-->
																</div>
																<!--end: Item-->
															</div>
															<!--end: Card Body-->
														</div>
														<!--end: Card-->
														<!--end: List Widget 10-->
													</div>
													<div class="col-lg-6">
														<!--begin::Mixed Widget 5-->
														<div class="card card-custom bg-radial-gradient-primary card-stretch gutter-b">
															<!--begin::Header-->
															<div class="card-header border-0 py-5">
																<h3 class="card-title font-weight-bolder text-white">Sales Progress</h3>
																<div class="card-toolbar">
																	<div class="dropdown dropdown-inline">
																		<a href="#" class="btn btn-text-white btn-hover-white btn-sm btn-icon border-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																			<i class="ki ki-bold-more-hor"></i>
																		</a>
																		<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
																			<!--begin::Navigation-->
																			<ul class="navi navi-hover">
																				<li class="navi-header font-weight-bold py-4">
																					<span class="font-size-lg">Choose Label:</span>
																					<i class="flaticon2-information icon-md text-muted" data-toggle="tooltip" data-placement="right" title="Click to learn more..."></i>
																				</li>
																				<li class="navi-separator mb-3 opacity-70"></li>
																				<li class="navi-item">
																					<a href="#" class="navi-link">
																						<span class="navi-text">
																							<span class="label label-xl label-inline label-light-success">Customer</span>
																						</span>
																					</a>
																				</li>
																				<li class="navi-item">
																					<a href="#" class="navi-link">
																						<span class="navi-text">
																							<span class="label label-xl label-inline label-light-danger">Partner</span>
																						</span>
																					</a>
																				</li>
																				<li class="navi-item">
																					<a href="#" class="navi-link">
																						<span class="navi-text">
																							<span class="label label-xl label-inline label-light-warning">Suplier</span>
																						</span>
																					</a>
																				</li>
																				<li class="navi-item">
																					<a href="#" class="navi-link">
																						<span class="navi-text">
																							<span class="label label-xl label-inline label-light-primary">Member</span>
																						</span>
																					</a>
																				</li>
																				<li class="navi-item">
																					<a href="#" class="navi-link">
																						<span class="navi-text">
																							<span class="label label-xl label-inline label-light-dark">Staff</span>
																						</span>
																					</a>
																				</li>
																				<li class="navi-separator mt-3 opacity-70"></li>
																				<li class="navi-footer py-4">
																					<a class="btn btn-clean font-weight-bold btn-sm" href="#">
																					<i class="ki ki-plus icon-sm"></i>Add new</a>
																				</li>
																			</ul>
																			<!--end::Navigation-->
																		</div>
																	</div>
																</div>
															</div>
															<!--end::Header-->
															<!--begin::Body-->
															<div class="card-body d-flex flex-column p-0">
																<!--begin::Chart-->
																<div id="kt_mixed_widget_5_chart" style="height: 200px"></div>
																<!--end::Chart-->
																<!--begin::Stats-->
																<div class="card-spacer bg-white card-rounded flex-grow-1">
																	<!--begin::Row-->
																	<div class="row m-0">
																		<div class="col px-8 py-6 mr-8">
																			<div class="font-size-sm text-muted font-weight-bold">Average Sale</div>
																			<div class="font-size-h4 font-weight-bolder">$650</div>
																		</div>
																		<div class="col px-8 py-6">
																			<div class="font-size-sm text-muted font-weight-bold">Commission</div>
																			<div class="font-size-h4 font-weight-bolder">$233,600</div>
																		</div>
																	</div>
																	<!--end::Row-->
																	<!--begin::Row-->
																	<div class="row m-0">
																		<div class="col px-8 py-6 mr-8">
																			<div class="font-size-sm text-muted font-weight-bold">Annual Taxes</div>
																			<div class="font-size-h4 font-weight-bolder">$29,004</div>
																		</div>
																		<div class="col px-8 py-6">
																			<div class="font-size-sm text-muted font-weight-bold">Annual Income</div>
																			<div class="font-size-h4 font-weight-bolder">$1,480,00</div>
																		</div>
																	</div>
																	<!--end::Row-->
																</div>
																<!--end::Stats-->
															</div>
															<!--end::Body-->
														</div>
														<!--end::Mixed Widget 5-->
													</div>
												</div>
												<!--end::Row-->
												<!--begin::Advance Table Widget 5-->
												<div class="card card-custom gutter-b">
													<!--begin::Header-->
													<div class="card-header border-0 py-5">
														<h3 class="card-title align-items-start flex-column">
															<span class="card-label font-weight-bolder text-dark">Agents Stats</span>
															<span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+ new members</span>
														</h3>
														<div class="card-toolbar">
															<a href="#" class="btn btn-info font-weight-bolder font-size-sm">New Report</a>
														</div>
													</div>
													<!--end::Header-->
													<!--begin::Body-->
													<div class="card-body py-0">
														<!--begin::Table-->
														<div class="table-responsive">
															<table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_2">
																<thead>
																	<tr class="text-uppercase">
																		<th class="pl-0" style="width: 40px">
																			<label class="checkbox checkbox-lg checkbox-inline mr-2">
																				<input type="checkbox" value="1" />
																				<span></span>
																			</label>
																		</th>
																		<th class="pl-0" style="min-width: 100px">order id</th>
																		<th style="min-width: 120px">country</th>
																		<th style="min-width: 150px">
																			<span class="text-primary">Data &amp; status</span>
																			<span class="svg-icon svg-icon-sm svg-icon-primary">
																				<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Down-2.svg-->
																				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																						<polygon points="0 0 24 0 24 24 0 24" />
																						<rect fill="#000000" opacity="0.3" x="11" y="4" width="2" height="10" rx="1" />
																						<path d="M6.70710678,19.7071068 C6.31658249,20.0976311 5.68341751,20.0976311 5.29289322,19.7071068 C4.90236893,19.3165825 4.90236893,18.6834175 5.29289322,18.2928932 L11.2928932,12.2928932 C11.6714722,11.9143143 12.2810586,11.9010687 12.6757246,12.2628459 L18.6757246,17.7628459 C19.0828436,18.1360383 19.1103465,18.7686056 18.7371541,19.1757246 C18.3639617,19.5828436 17.7313944,19.6103465 17.3242754,19.2371541 L12.0300757,14.3841378 L6.70710678,19.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 15.999999) scale(1, -1) translate(-12.000003, -15.999999)" />
																					</g>
																				</svg>
																				<!--end::Svg Icon-->
																			</span>
																		</th>
																		<th style="min-width: 150px">company</th>
																		<th style="min-width: 130px">status</th>
																		<th class="pr-0 text-right" style="min-width: 160px">action</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td class="pl-0 py-6">
																			<label class="checkbox checkbox-lg checkbox-inline">
																				<input type="checkbox" value="1" />
																				<span></span>
																			</label>
																		</td>
																		<td class="pl-0">
																			<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg">56037-XDER</a>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">Brasil</span>
																			<span class="text-muted font-weight-bold">Code: BR</span>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">05/28/2020</span>
																			<span class="text-muted font-weight-bold">Paid</span>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">Intertico</span>
																			<span class="text-muted font-weight-bold">Web, UI/UX Design</span>
																		</td>
																		<td>
																			<span class="label label-lg label-light-primary label-inline">Approved</span>
																		</td>
																		<td class="pr-0 text-right">
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000" />
																							<path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
																							<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
																							<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																		</td>
																	</tr>
																	<tr>
																		<td class="pl-0 py-6">
																			<label class="checkbox checkbox-lg checkbox-inline">
																				<input type="checkbox" value="1" />
																				<span></span>
																			</label>
																		</td>
																		<td class="pl-0">
																			<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary font-size-lg">05822-FXSP</a>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">Belarus</span>
																			<span class="text-muted font-weight-bold">Code: BY</span>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">02/04/2020</span>
																			<span class="text-muted font-weight-bold">Rejected</span>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">Agoda</span>
																			<span class="text-muted font-weight-bold">Houses &amp; Hotels</span>
																		</td>
																		<td>
																			<span class="label label-lg label-light-warning label-inline">In Progress</span>
																		</td>
																		<td class="pr-0 text-right">
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000" />
																							<path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
																							<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
																							<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																		</td>
																	</tr>
																	<tr>
																		<td class="pl-0 py-6">
																			<label class="checkbox checkbox-lg checkbox-inline">
																				<input type="checkbox" value="1" />
																				<span></span>
																			</label>
																		</td>
																		<td class="pl-0">
																			<a href="#" class="text-dark-75 font-weight-bolder text-hover-primary ont-size-lg">00347-BCLQ</a>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">Phillipines</span>
																			<span class="text-muted font-weight-bold">Code: PH</span>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">23/12/2020</span>
																			<span class="text-muted font-weight-bold">Paid</span>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">RoadGee</span>
																			<span class="text-muted font-weight-bold">Transportation</span>
																		</td>
																		<td>
																			<span class="label label-lg label-light-success label-inline">Success</span>
																		</td>
																		<td class="pr-0 text-right">
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000" />
																							<path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
																							<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
																							<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																		</td>
																	</tr>
																	<tr>
																		<td class="pl-0 py-6">
																			<label class="checkbox checkbox-lg checkbox-inline">
																				<input type="checkbox" value="1" />
																				<span></span>
																			</label>
																		</td>
																		<td class="pl-0">
																			<a href="#" class="text-dark font-weight-bolder text-hover-primary font-size-lg">4472-QREX</a>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">Argentina</span>
																			<span class="text-muted font-weight-bold">Code: AR</span>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">17/09/2021</span>
																			<span class="text-muted font-weight-bold">Pending</span>
																		</td>
																		<td>
																			<span class="text-dark-75 font-weight-bolder d-block font-size-lg">The Hill</span>
																			<span class="text-muted font-weight-bold">Insurance</span>
																		</td>
																		<td>
																			<span class="label label-lg label-light-danger label-inline">Rejected</span>
																		</td>
																		<td class="pr-0 text-right">
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000" />
																							<path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
																							<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																			<a href="#" class="btn btn-icon btn-light btn-hover-primary btn-sm">
																				<span class="svg-icon svg-icon-md svg-icon-primary">
																					<!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
																					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																							<rect x="0" y="0" width="24" height="24" />
																							<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
																							<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
																						</g>
																					</svg>
																					<!--end::Svg Icon-->
																				</span>
																			</a>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
														<!--end::Table-->
													</div>
													<!--end::Body-->
												</div>
												<!--end::Advance Table Widget 5-->
											</div>
											<!--end::Profile Overview-->
											<!--begin::Personal Information-->
											<div class="tab-pane fade show active" id="wad_profile_personal_info">
												<!--begin::Form-->
												<form class="form<?php if(is_assigner()){ echo ' disabled'; } ?>" method="post">
													<!--begin::Card-->
													<div class="card card-custom card-stretch">
														<!--begin::Header-->
														<div class="card-header py-3">
															<div class="card-title align-items-start flex-column">
																<h3 class="card-label font-weight-bolder text-dark">Info</h3>
															</div>
															<div class="card-toolbar">
																<button type="submit" class="btn btn-primary mr-2">Save Changes</button>
																<button type="reset" class="btn btn-secondary mr-2">Cancel</button>
																<?php if( $user['is_archive']): ?>
																	<span class="text-danger">Archived Account</span>
																<?php else: ?>
																<a class="btn btn-primary2 mr-2" href="<?php echo BASE_URL; ?>?action=sign_in_as_user_using_admin&user=<?php echo $user['spp_id']; ?>">Sign in as user</a>
																<?php endif; ?>
																<a class="btn btn-danger" href="<?php echo BASE_URL; ?>?user=<?php echo $user['spp_id']; ?>&action=delete_user" onclick="return confirm('It will not restored, are you sure you want to delete?');">Delete User</a>
															</div>
														</div>
														<!--end::Header-->
														<!--begin::Body-->
														<div class="card-body">
															<?php /* <div class="row">
																<label class="col-xl-3"></label>
																<div class="col-lg-9 col-xl-6">
																	<h5 class="font-weight-bold mb-6">Customer Info</h5>
																</div>
															</div>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label">Avatar</label>
																<div class="col-lg-9 col-xl-6">
																	<div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url(assets/media/users/blank.png)">
																		<div class="image-input-wrapper" style="background-image: url(assets/media/users/300_21.jpg)"></div>
																		<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
																			<i class="fa fa-pen icon-sm text-muted"></i>
																			<input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
																			<input type="hidden" name="profile_avatar_remove" />
																		</label>
																		<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
																			<i class="ki ki-bold-close icon-xs text-muted"></i>
																		</span>
																		<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
																			<i class="ki ki-bold-close icon-xs text-muted"></i>
																		</span>
																	</div>
																	<span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
																</div>
															</div> */ ?>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label">Name</label>
																<div class="col-lg-9 col-xl-6">
																	<input name="name" class="form-control form-control-lg form-control-solid" type="text" value="<?php echo $user['name']; ?>" />
																</div>
															</div>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
																<div class="col-lg-9 col-xl-6">
																	<div class="input-group input-group-lg input-group-solid">
																		<div class="input-group-prepend">
																			<span class="input-group-text">
																				<i class="la la-at"></i>
																			</span>
																		</div>
																		<input type="text" name="email" class="form-control form-control-lg form-control-solid" value="<?php echo $user['email']; ?>" placeholder="Email" />
																	</div>
																</div>
															</div>
															<?php if( $user['role'] == 'Writer' ): ?>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label">
																	<?php echo $globals['weekly_quota_label']; ?>
																	<span class="form-text text-muted"><?php echo $globals['weekly_quota_desc']; ?></span>
																</label>
																<div class="col-lg-9 col-xl-6">
																	<input name="weekly_quota" class="form-control form-control-lg form-control-solid" type="text" value="<?php echo $user['weekly_quota']; ?>" />
																</div>
															</div>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label align-self-center">
																	<?php echo $globals['enable_weekly_quota_label']; ?>
																	<span class="form-text text-muted"><?php echo $globals['enable_weekly_quota_desc']; ?></span>
																</label>
																<div class="col-lg-9 col-xl-6 align-self-center">
																	<div class="radio-inline">
																		<label class="radio">
																			<input type="radio" <?php if( isset($enable_weekly_quota) && $enable_weekly_quota == 1) { echo 'checked'; } ?> name="enable_weekly_quota" value="1" />
																			<span></span>
																			Yes
																		</label>
																		<label class="radio">
																			<input type="radio" <?php if( isset($enable_weekly_quota) && $enable_weekly_quota != 1) { echo 'checked'; } ?> name="enable_weekly_quota" value="0" />
																			<span></span>
																			No
																		</label>
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label">
																	<?php echo $globals['onetime_quota_label']; ?>
																	<span class="form-text text-muted"><?php echo $globals['onetime_quota_desc']; ?></span>
																</label>
																<div class="col-lg-9 col-xl-6">
																	<input name="onetime_quota" class="form-control form-control-lg form-control-solid" type="text" value="<?php echo $user['onetime_quota']; ?>" />
																</div>
															</div>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label align-self-center">
																	<?php echo $globals['enable_onetime_quota_label']; ?>
																	<span class="form-text text-muted"><?php echo $globals['enable_onetime_quota_desc']; ?></span>
																</label>
																<div class="col-lg-9 col-xl-6 align-self-center">
																	<div class="radio-inline">
																		<label class="radio">
																			<input type="radio" <?php if( isset($enable_onetime_quota) && $enable_onetime_quota == 1) { echo 'checked'; } ?> name="enable_onetime_quota" value="1" />
																			<span></span>
																			Yes
																		</label>
																		<label class="radio">
																			<input type="radio" <?php if( isset($enable_onetime_quota) && $enable_onetime_quota != 1) { echo 'checked'; } ?> name="enable_onetime_quota" value="0" />
																			<span></span>
																			No
																		</label>
																	</div>
																</div>
															</div>
															<?php endif; ?>
															<?php if( $user['role'] == 'Editor' ): ?>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label">Editor Revision</label>
																<div class="col-lg-9 col-xl-6">
																	<input name="editor_revision_count_limit" class="form-control form-control-lg form-control-solid" type="number" min="1" value="<?php echo $user['editor_revision_count_limit']; ?>" />
																</div>
															</div>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label align-self-center">Claim One Order at a time.</label>
																<div class="col-lg-9 col-xl-6 align-self-center">
																	<div class="radio-inline">
																		<label class="radio">
																			<input type="radio" <?php if( isset($claim_one_order) && $claim_one_order == 1) { echo 'checked'; } ?> name="claim_one_order" value="1" />
																			<span></span>
																			Yes
																		</label>
																		<label class="radio">
																			<input type="radio" <?php if( isset($claim_one_order) && $claim_one_order != 1) { echo 'checked'; } ?> name="claim_one_order" value="0" />
																			<span></span>
																			No
																		</label>
																	</div>
																</div>
															</div>
															<?php endif; ?>
															<?php if( $user['role'] == 'Writer' || $user['role'] == 'Editor' ): ?>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label align-self-center">Allowed to claim?</label>
																<div class="col-lg-9 col-xl-6 align-self-center">
																	<div class="radio-inline">
																		<label class="radio">
																			<input type="radio" <?php if( isset($enable_claim) && $enable_claim == 1) { echo 'checked'; } ?> name="enable_claim" value="1" />
																			<span></span>
																			Yes
																		</label>
																		<label class="radio">
																			<input type="radio" <?php if( isset($enable_claim) && $enable_claim != 1) { echo 'checked'; } ?> name="enable_claim" value="0" />
																			<span></span>
																			No
																		</label>
																	</div>
																</div>
															</div>
															<?php endif; ?>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label align-self-center">Archive Account?</label>
																<div class="col-lg-9 col-xl-6 align-self-center">
																	<div class="radio-inline">
																		<label class="radio">
																			<input type="radio" <?php if( isset($is_archive) && $is_archive == 1) { echo 'checked'; } ?> name="is_archive" value="1"<?php if($user['spp_id']=='3653'): ?> disabled<?php endif; ?> />
																			<span></span>
																			Yes
																		</label>
																		<label class="radio">
																			<input type="radio" <?php if( isset($is_archive) && $is_archive != 1) { echo 'checked'; } ?> name="is_archive" value="0"<?php if($user['spp_id']=='3653'): ?> disabled<?php endif; ?> />
																			<span></span>
																			No
																		</label>
																	</div>
																	<?php if($user['spp_id']=='3653'): ?>
																	<div class="text-muted">this admin account can not be archived.</div>
																	<?php endif; ?>
																</div>
															</div>
															<?php /* <div class="row">
																<label class="col-xl-3"></label>
																<div class="col-lg-9 col-xl-6">
																	<h5 class="font-weight-bold mt-10 mb-6">Contact Info</h5>
																</div>
															</div>
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
																<div class="col-lg-9 col-xl-6">
																	<div class="input-group input-group-lg input-group-solid">
																		<div class="input-group-prepend">
																			<span class="input-group-text">
																				<i class="la la-phone"></i>
																			</span>
																		</div>
																		<input type="text" class="form-control form-control-lg form-control-solid" value="+35278953712" placeholder="Phone" />
																	</div>
																	<span class="form-text text-muted">We'll never share your email with anyone else.</span>
																</div>
															</div>
															
															<div class="form-group row">
																<label class="col-xl-3 col-lg-3 col-form-label">Company Site</label>
																<div class="col-lg-9 col-xl-6">
																	<div class="input-group input-group-lg input-group-solid">
																		<input type="text" class="form-control form-control-lg form-control-solid" placeholder="Username" value="loop" />
																		<div class="input-group-append">
																			<span class="input-group-text">.com</span>
																		</div>
																	</div>
																</div>
															</div> */ ?>
														</div>
														<!--end::Body-->
													</div>
													
													<input type="hidden" name="spp_id" value="<?php echo $user['spp_id']; ?>" />
													<input type="hidden" name="action" value="admin_edits_user" />
												</form>
												<!--end::Form-->
											</div>
											<!--end::Personal Information-->
										</div>
									</div>
									<!--end::Content-->
									<!--begin::Personal Information-->
										
								</div>
								<!--end::Profile 2-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
						
						<?php if( in_array($user['role'], array('Writer','Editor')) ): ?>
						
						<div class="d-flex mt-8">
							<div class="container">
								<div class="card card-custom">
									<div class="card-body">
										<ul class="nav align-self-end font-size-lg" role="tablist">
											<li class="nav-item">
												<a href="javascript:void(0)" class="nav-link py-4 px-6 position-relative active" data-toggle="tab" data-target="#user_all_orders_tab" role="tab" aria-selected="false">
													<span class="label label-sm label-outline-warning label-rounded w-auto position-absolute right-0 top-0 d-flex" style="padding:2px;min-width:16px"><?php echo $all_orders_total; ?></span>
													<span class="d-flex justify-content-between w-100">
														<span class="menu-text align-self-center">All</span>
													</span>
												</a>
											</li>
											<?php if( $user['role'] == 'Writer' ): ?>
											<li class="nav-item">
												<a href="javascript:void(0)" class="nav-link py-4 px-6 position-relative" data-toggle="tab" data-target="#user_working_orders_tab" role="tab" aria-selected="false">
													<span class="label label-sm label-outline-warning label-rounded w-auto position-absolute right-0 top-0 d-flex" style="padding:2px;min-width:16px"><?php echo $working_orders_total; ?></span>
													<span class="d-flex justify-content-between w-100">
														<span class="menu-text align-self-center">Working</span>
													</span>
												</a>
											</li>
											<?php endif; ?>
											
											<li class="nav-item">
												<a href="javascript:void(0)" class="nav-link py-4 px-6 position-relative" data-toggle="tab" data-target="#user_editing_orders_tab" role="tab" aria-selected="false">
													<span class="label label-sm label-outline-warning label-rounded w-auto position-absolute right-0 top-0 d-flex" style="padding:2px;min-width:16px"><?php echo $editing_orders_total; ?></span>
													<span class="d-flex justify-content-between w-100">
														<span class="menu-text align-self-center">Editing</span>
													</span>
												</a>
											</li>							
											<li class="nav-item">
												<a href="javascript:void(0)" class="nav-link py-4 px-6 position-relative" data-toggle="tab" data-target="#user_editor_revision_orders_tab" role="tab" aria-selected="false">
													<span class="label label-sm label-outline-warning label-rounded w-auto position-absolute right-0 top-0 d-flex" style="padding:2px;min-width:16px"><?php echo $editor_revision_orders_total; ?></span>
													<span class="d-flex justify-content-between w-100">
														<span class="menu-text align-self-center">Editor Revision</span>
													</span>
												</a>
											</li>			
											<li class="nav-item">
												<a href="javascript:void(0)" class="nav-link py-4 px-6 position-relative" data-toggle="tab" data-target="#user_revision_orders_tab" role="tab" aria-selected="false">
													<span class="label label-sm label-outline-warning label-rounded w-auto position-absolute right-0 top-0 d-flex" style="padding:2px;min-width:16px"><?php echo $revision_orders_total; ?></span>
													<span class="d-flex justify-content-between w-100">
														<span class="menu-text align-self-center">Client Revision</span>
													</span>
												</a>
											</li>
											
											<li class="nav-item">
												<a href="javascript:void(0)" class="nav-link py-4 px-6 position-relative" data-toggle="tab" data-target="#user_complete_orders_tab" role="tab" aria-selected="false">
													<span class="label label-sm label-outline-warning label-rounded w-auto position-absolute right-0 top-0 d-flex" style="padding:2px;min-width:16px"><?php echo $completed_orders_total; ?></span>
													<span class="d-flex justify-content-between w-100">
														<span class="menu-text align-self-center">Completed</span>
													</span>
												</a>
											</li>							
										</ul>
									</div>
								</div>
								
								<div class="tab-content mt-1">
									<div class="tab-pane active" id="user_all_orders_tab">
										<div class="card card-custom">
											<div class="card-header">
												<div class="card-title">
													<h3 class="card-label">All Orders</h3>
												</div>
											</div>
											<div class="card-body">
												<?php //require 'parts/admin/user/orders/table/all.php'; ?>
												<!--begin: Datatable-->
												<div class="datatable datatable-bordered datatable-head-custom" id="wad_admin_datatable_user_orders"></div>
												<!--end: Datatable-->
											</div>
										</div>
									</div>
									<div class="tab-pane" id="user_working_orders_tab">
										<div class="card card-custom">
											<div class="card-header">
												<div class="card-title">
													<h3 class="card-label">Working</h3>
												</div>
											</div>
											<div class="card-body">
												<?php //require 'parts/admin/user/orders/table/working.php'; ?>
												<div class="datatable datatable-bordered datatable-head-custom" id="wad_admin_datatable_user_working_orders"></div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="user_editing_orders_tab">
										<div class="card card-custom">
											<div class="card-header">
												<div class="card-title">
													<h3 class="card-label">Editing</h3>
												</div>
											</div>
											<div class="card-body">
												<?php //require 'parts/admin/user/orders/table/editing.php'; ?>
												<div class="datatable datatable-bordered datatable-head-custom" id="wad_admin_datatable_user_editing_orders"></div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="user_editor_revision_orders_tab">
										<div class="card card-custom">
											<div class="card-header">
												<div class="card-title">
													<h3 class="card-label">Editor Revisions</h3>
												</div>
											</div>
											<div class="card-body">
												<?php //require 'parts/admin/user/orders/table/revisions.php'; ?>
												<div class="datatable datatable-bordered datatable-head-custom" id="wad_admin_datatable_user_editor_revision_orders"></div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="user_revision_orders_tab">
										<div class="card card-custom">
											<div class="card-header">
												<div class="card-title">
													<h3 class="card-label">Client Revisions</h3>
												</div>
											</div>
											<div class="card-body">
												<?php //require 'parts/admin/user/orders/table/revisions.php'; ?>
												<div class="datatable datatable-bordered datatable-head-custom" id="wad_admin_datatable_user_revision_orders"></div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="user_complete_orders_tab">
										<div class="card card-custom">
											<div class="card-header">
												<div class="card-title">
													<h3 class="card-label">Completed</h3>
												</div>
											</div>
											<div class="card-body">
												<?php //require 'parts/admin/user/orders/table/complete.php'; ?>
												<div class="datatable datatable-bordered datatable-head-custom" id="wad_admin_datatable_user_complete_orders"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="d-none" id="user-spp-id"><?php echo $user_spp_id; ?></div>
								<div class="d-none" id="user-role"><?php echo $user['role']; ?></div>
							</div>
						</div>
						<?php endif; ?>
						
					</div>
					<!--end::Content-->
<?php wad_footer(); ?>