<?php
	global $globals, $current_user, $globals_admin;
	
	$name = $current_user['name'];
	$weekly_quota = isset( $current_user['weekly_quota'] ) ? $current_user['weekly_quota'] : '';
	$current_user_spp_id = $current_user['spp_id'];
	$current_url = $globals['current_url'];
	?>
<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 10 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title>Welcome to WordAgents!</title>
		<meta name="description" content="A platform for aspiring and experienced content writers." />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="-1">
		<meta http-equiv="cache-control" content="no-cache"/>
		<link rel="canonical" href="<?php echo BASE_URL; ?>" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendors Styles(used by this page)-->
		<link href="<?php echo BASE_URL; ?>/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors Styles-->
		<?php require 'head.php'; ?>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled page-loading <?php echo wad_body_classes(); ?>">
		<!--begin::Main-->
		
		<?php
			if(
				( is_writer() && in_array('writer',$globals_admin['topbar_visibility']) )
				|| ( is_editor() && in_array('editor',$globals_admin['topbar_visibility']) )
			):
		?>
			<div id="topbar_custom_mobile" class="topbar-custom text-white d-md-block d-lg-none d-xl-none">
				<div class="container">
					<?php echo $globals_admin['topbar_text']; ?>
				</div>
			</div>
		<?php endif; ?>
		
		<!--begin::Header Mobile-->
		<div id="kt_header_mobile" class="header-mobile bg-primary header-mobile-fixed">
			<!--begin::Logo-->
			<a href="index.html">
				<img alt="Logo" src="<?php echo BASE_URL; ?>/assets/media/logos/logo-mobile.png" class="max-h-30px" />
			</a>
			<!--end::Logo-->
			<!--begin::Toolbar-->
			<div class="d-flex align-items-center">
				<button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
					<span></span>
				</button>
				<button class="btn p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
				</button>
			</div>
			<!--end::Toolbar-->
		</div>
		<!--end::Header Mobile-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header flex-column header-fixed">
						
						<?php
							if(
								( is_writer() && in_array('writer',$globals_admin['topbar_visibility']) )
								|| ( is_editor() && in_array('editor',$globals_admin['topbar_visibility']) )
							):
						?>
							<div class="topbar-custom text-white d-none d-lg-block">
								<div class="container">
									<?php echo $globals_admin['topbar_text']; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<!--begin::Top-->
						<div class="header-top">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Left-->
								<div class="d-none d-lg-flex align-items-center mr-3">
									<!--begin::Logo-->
									<a href="<?php echo BASE_URL; ?>" class="mr-20">
										<img alt="Logo" src="https://d2ak7xqyq6n4ly.cloudfront.net/wordagents.spp.io/logo.png" class="max-h-35px" />
									</a>
									<!--end::Logo-->
									<!--begin::Tab Navs(for desktop mode)-->
									<ul class="header-tabs nav align-self-end font-size-lg" role="tablist">
										<?php if( is_admin() || is_assigner() ): ?>
											<!--begin::Item-->
											<li class="nav-item">
												<a href="<?php echo BASE_URL.'/users';?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"users")!==false):echo' active';endif;?>" data-toggle="tab" data-target="#wad_header_tab_3" role="tab">Users</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="nav-item">
												<a href="<?php echo BASE_URL.'/orders/all';?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"orders")!==false):echo' active';endif;?>" data-toggle="tab" data-target="#wad_header_tab_4" role="tab">Orders</a>
											</li>
											<!--end::Item-->
											<?php if( is_admin() ): ?>
											<!--begin::Item-->
											<li class="nav-item">
												<?php $admin_settings_page_url = BASE_URL.'/settings/topbar'; ?>
												<a href="<?php echo $admin_settings_page_url; ?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"settings")!==false):echo' active';endif;?>" >Settings</a>
											</li>
											<?php endif; ?>
											<li class="nav-item hide removed">
												<?php $admin_settings_page_url = BASE_URL.'/report'; ?>
												<a href="<?php echo $admin_settings_page_url; ?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"report")!==false):echo' active';endif;?>">Report</a>
											</li>
											<?php if( is_admin() ): ?>
											<!--begin::Item-->
											<li class="nav-item">
												<a href="<?php echo BASE_URL.'/stats/writers';?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"stats")!==false):echo' active';endif;?>" data-toggle="tab" data-target="#wad_header_tab_5" role="tab">Stats</a>
											</li>
											<!--end::Item-->
											<?php endif; ?>
											<?php if( $current_user_spp_id == '3653'): ?>
											<li class="nav-item hide">
												<?php $admin_settings_page_url = BASE_URL.'/assigned_orders'; ?>
												<a href="<?php echo $admin_settings_page_url; ?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"assigned_orders")!==false):echo' active';endif;?>">assigned_orders</a>
											</li>
											<li class="nav-item hide">
												<?php $admin_settings_page_url = BASE_URL.'/weekly_words'; ?>
												<a href="<?php echo $admin_settings_page_url; ?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"weekly_words")!==false):echo' active';endif;?>">weekly_words</a>
											</li>
											<li class="nav-item hide">
												<?php $admin_settings_page_url = BASE_URL.'/date_due'; ?>
												<a href="<?php echo $admin_settings_page_url; ?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"date_due")!==false):echo' active';endif;?>">date_due</a>
											</li>
											<li class="nav-item hide">
												<?php $admin_settings_page_url = BASE_URL.'/doc_link'; ?>
												<a href="<?php echo $admin_settings_page_url; ?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"doc_link")!==false):echo' active';endif;?>">doc_link</a>
											</li>
											<li class="nav-item hide">
												<?php $admin_settings_page_url = BASE_URL.'/sync_orders'; ?>
												<a href="<?php echo $admin_settings_page_url; ?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"sync_orders")!==false):echo' active';endif;?>">sync_orders</a>
											</li>
											<li class="nav-item hide">
												<?php $admin_settings_page_url = BASE_URL.'/sync_team'; ?>
												<a href="<?php echo $admin_settings_page_url; ?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"sync_team")!==false):echo' active';endif;?>">sync_team</a>
											</li>
											<?php endif; ?>
											<!--end::Item-->
										<?php else: ?>
											<!--begin::Item-->
											<li class="nav-item">
												<a href="<?php echo BASE_URL.'/orders';?>" class="nav-link py-4 px-6<?php if( strpos($current_url,"orders")!==false):echo' active';endif;?>" data-toggle="tab" data-target="#wad_header_tab_1" role="tab">Orders</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="nav-item mr-3">
												<a href="#" class="nav-link py-4 px-6<?php if( strpos($current_url,"accounting")!==false):echo' active';endif;?>" data-toggle="tab" data-target="#wad_header_tab_2" role="tab">Accounting</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="nav-item mr-3">
												<a href="<?php echo BASE_URL ?>/support" class="nav-link py-4 px-6<?php if( strpos($current_url,"support")!==false):echo' active';endif;?>">Support</a>
											</li>
											<!--end::Item-->
										<?php endif; ?>
									</ul>
									
									<!--begin::Tab Navs-->
								</div>
								<!--end::Left-->
								<!--begin::Topbar-->
								<div class="topbar bg-primary">
									<?php if( ! is_admin() && ! is_assigner() ): ?>
									<div class="topbar-item"><div class="flex-column text-center pr-7 d-none">
										<span class="text-white opacity-80 font-weight-bolder font-size-md d-sm-inline">Weekly Working Orders</span>
										<span class="text-white opacity-50 font-weight-bolder font-size-sm d-sm-inline"><?php echo isset($globals['writer_weekly_working_orders_words_legnth']) ? $globals['writer_weekly_working_orders_words_legnth'] : ''; ?></span>
									</div></div>
									<div class="topbar-item"><div class="d-flex flex-column text-center pr-7">
										<span class="text-white opacity-80 font-weight-bolder font-size-md d-sm-inline">Weekly Words <?php if( is_editor()){ echo 'Edited'; }else{ echo 'Produced'; } ?></span>
										<span class="text-white opacity-50 font-weight-bolder font-size-sm d-sm-inline text-center"><?php echo $globals['all_orders_weekly_words_count']; ?></span>
									</div></div>
									<div class="topbar-item"><div class="d-flex flex-column text-center pr-7">
										<span class="text-white opacity-80 font-weight-bolder font-size-md d-sm-inline">Weekly Quota</span>
										<span class="text-white opacity-50 font-weight-bolder font-size-sm d-sm-inline"><?php echo $weekly_quota; ?></span>
									</div></div>
									<?php endif; ?>
									<!--begin::User-->
									<div class="topbar-item">
										<div class="btn btn-icon btn-hover-transparent-white w-sm-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
											<div class="d-flex flex-column text-right pr-sm-3">
												<span class="text-white opacity-80 font-weight-bolder font-size-md d-none d-sm-inline">
												<?php echo $name; ?>
												</span>
												<span class="text-white opacity-50 font-weight-bolder font-size-sm d-none d-sm-inline">My Account</span>
											</div>
											<span class="symbol symbol-35">
												<span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-100"><?php echo $name[0]; ?></span>
											</span>
										</div>
									</div>
									<!--end::User-->
								</div>
								<!--end::Topbar-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Top-->
						<!--begin::Bottom-->
						<div class="header-bottom">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Header Menu Wrapper-->
								<div class="header-navs header-navs-left" id="kt_header_navs">
									<!--begin::Tab Navs(for tablet and mobile modes)-->
									<ul class="header-tabs p-5 p-lg-0 d-flex d-lg-none nav nav-bold nav-tabs" role="tablist">
										
										<?php if( is_admin() || is_assigner() ): ?>
											<!--begin::Item-->
											<li class="nav-item mr-2">
												<a href="<?php echo BASE_URL.'/users';?>" class="nav-link btn btn-clean<?php if( strpos($current_url,"users")!==false):echo' active';endif;?>" data-toggle="tab" data-target="#wad_header_tab_3" role="tab">Users</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="nav-item mr-2">
												<a href="<?php echo BASE_URL.'/orders/all';?>" class="nav-link btn btn-clean<?php if( strpos($current_url,"orders")!==false):echo' active';endif;?>" data-toggle="tab" data-target="#wad_header_tab_4" role="tab">Orders</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="nav-item mr-2">
												<?php $admin_settings_page_url = BASE_URL.'/settings'; ?>
												<a href="<?php echo $admin_settings_page_url; ?>" class="nav-link btn btn-clean<?php if( strpos($current_url,"settings")!==false):echo' active';endif;?>">Settings</a>
											</li>
											<?php if( $current_user_spp_id == '3653'): ?>
											<li class="nav-item">
												<?php $admin_settings_page_url = BASE_URL.'/report'; ?>
												<a href="<?php echo $admin_settings_page_url; ?>" class="nav-link btn btn-clean<?php if( strpos($current_url,"report")!==false):echo' active';endif;?>">Report</a>
											</li>
											<?php endif; ?>
											<!--end::Item-->
										<?php else: ?>
											<!--begin::Item-->
											<li class="nav-item mr-2">
												<a href="<?php echo BASE_URL.'/orders';?>" class="nav-link btn btn-clean<?php if( strpos($current_url,"orders")!==false):echo' active';endif;?>" data-toggle="tab" data-target="#wad_header_tab_1" role="tab">Orders</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="nav-item">
												<a href="#" class="nav-link btn btn-clean<?php if( strpos($current_url,"accounting")!==false):echo' active';endif;?>" data-toggle="tab" data-target="#wad_header_tab_2" role="tab">Accounting</a>
											</li>
											<!--end::Item-->
										<?php endif; ?>
									</ul>
									<!--begin::Tab Navs-->
									<!--begin::Tab Content-->
									<div class="tab-content">
										<!--begin::Tab Pane-->
										<?php if( is_admin() || is_assigner()): ?>
											<!--begin::Tab Pane-->
											<div class="tab-pane py-5 p-lg-0<?php if(strpos($current_url,"users")!==false):echo' active';endif;?>" id="wad_header_tab_3">
												<!--begin::Menu-->
												<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
													<!--begin::Nav-->
													<ul class="menu-nav">
														<li class="menu-item<?php if($current_url == 'users'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/users';?>" class="menu-link">
																<span class="menu-text">All</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'users/writers'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/users/writers';?>" class="menu-link">
																<span class="menu-text">Writers</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'users/editors'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/users/editors';?>" class="menu-link">
																<span class="menu-text">Editors</span>
															</a>
														</li>
														<?php if(is_admin() ): ?>
														<li class="menu-item<?php if($current_url == 'users/assigners'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/users/assigners';?>" class="menu-link">
																<span class="menu-text">Assigners</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'users/admins'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/users/admins';?>" class="menu-link">
																<span class="menu-text">Admins</span>
															</a>
														</li>
														<?php endif; ?>
													</ul>
													<!--end::Nav-->
												</div>
												<!--end::Menu-->
											</div>
											<!--end::Tab Pane-->
											<!--begin::Tab Pane-->
											<div class="tab-pane py-5 p-lg-0<?php if(strpos($current_url,"orders")!==false):echo' active';endif;?>" id="wad_header_tab_4">
												<!--begin::Menu-->
												<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
													<!--begin::Nav-->
													<ul class="menu-nav">
														<li class="menu-item<?php if($current_url == 'orders/all'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/all';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals_admin['all_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">All</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals_admin['all_orders_count']; ?></span>
																</span>
															</a>
														</li>
																											
														<li class="menu-item<?php if($current_url == 'orders/new'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/new';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals_admin['new_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Submitted</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals_admin['new_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'orders/overdue'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/overdue';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals_admin['overdue_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Overdue</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals_admin['overdue_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'orders/stuck'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/stuck';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals_admin['stuck_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Stuck</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals_admin['stuck_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'orders/working'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/working';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals_admin['working_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Working</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals_admin['working_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'orders/ready_to_edit'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/ready_to_edit';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals_admin['readyToEdit_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Ready to Edit</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals_admin['readyToEdit_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'orders/editing'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/editing';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals_admin['editing_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Editing</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals_admin['editing_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'orders/editor_revision'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/editor_revision';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals_admin['editorRevision_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Editor Revision</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals_admin['editorRevision_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'orders/complete'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/complete';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals_admin['complete_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Complete</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals_admin['complete_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'orders/revision'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/revision';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals_admin['revision_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Revision</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals_admin['revision_orders_count']; ?></span>
																</span>
															</a>
														</li>
													</ul>
													<!--end::Nav-->
												</div>
												<!--end::Menu-->
											</div>
											<!--end::Tab Pane-->
											<!--begin::Tab Pane-->
											<div class="tab-pane py-5 p-lg-0<?php if(strpos($current_url,"stats")!==false):echo' active';endif;?>" id="wad_header_tab_5">
												<!--begin::Menu-->
												<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
													<!--begin::Nav-->
													<ul class="menu-nav">
														<li class="menu-item<?php if($current_url == 'stats/writers'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/stats/writers';?>" class="menu-link">
																<span class="menu-text">Writers</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'stats/editors'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/stats/editors';?>" class="menu-link">
																<span class="menu-text">Editors</span>
															</a>
														</li>
													</ul>
													<!--end::Nav-->
												</div>
												<!--end::Menu-->
											</div>
											<!--end::Tab Pane-->
											
											<!--begin::Tab Pane-->
											<div class="tab-pane py-5 p-lg-0<?php if(strpos($current_url,"settings")!==false):echo' active';endif;?>" id="wad_header_tab_6">
												<!--begin::Menu-->
												<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
													<!--begin::Nav-->
													<ul class="menu-nav">
														<li class="menu-item<?php if($current_url == 'settings/topbar'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/settings/topbar';?>" class="menu-link">
																<span class="menu-text">Topbar</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'settings'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/settings';?>" class="menu-link">
																<span class="menu-text">Settings</span>
															</a>
														</li>
													</ul>
													<!--end::Nav-->
												</div>
												<!--end::Menu-->
											</div>
											<!--end::Tab Pane-->
										<?php else: ?>
											<!--begin::Tab Pane-->
											<div class="tab-pane py-5 p-lg-0<?php if( strpos($current_url,"orders")!==false):echo' active';endif;?>" id="wad_header_tab_1">
												<!--begin::Menu-->
												<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
													<!--begin::Nav-->
													<ul class="menu-nav">
														<li class="menu-item<?php if($current_url == 'orders/all'): echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/all';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals['all_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">All</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals['all_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'orders'):echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals['new_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">New Orders</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals['new_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<?php if(is_writer()): ?>
														<li class="menu-item<?php if($current_url == 'orders/working'):echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/working';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals['working_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Working</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals['working_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<?php endif; ?>
														<?php if(is_editor() || is_writer()): ?>
														<li class="menu-item<?php if($current_url == 'orders/editing'):echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/editing';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals['editing_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Editing</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals['editing_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<?php endif; ?>
														<li class="menu-item<?php if($current_url == 'orders/revisions/editor'):echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/revisions/editor';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals['editor_revision_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Editor Revisions</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals['editor_revision_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'orders/revisions/client'):echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/revisions/client';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals['revision_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Client Revisions</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals['revision_orders_count']; ?></span>
																</span>
															</a>
														</li>
														<li class="menu-item<?php if($current_url == 'orders/complete'):echo' menu-item-active';endif;?>" aria-haspopup="true">
															<a href="<?php echo BASE_URL.'/orders/complete';?>" class="menu-link">
																<span class="label label-sm label-outline-warning position-absolute right-0 top-0 d-none d-lg-flex"><?php echo $globals['complete_orders_count']; ?></span>
																<span class="d-flex justify-content-between w-100">
																	<span class="menu-text align-self-center">Completed</span>
																	<span class="label label-sm label-outline-warning d-md-flex d-lg-none ml-1 align-self-center"><?php echo $globals['complete_orders_count']; ?></span>
																</span>
															</a>
														</li>
													</ul>
													<!--end::Nav-->
												</div>
												<!--end::Menu-->
											</div>
											<!--end::Tab Pane-->
											<!--begin::Tab Pane-->
											<div class="tab-pane py-5 p-lg-0 justify-content-between<?php if( strpos($current_url,"accounting")!==false):echo' active';endif;?>" id="wad_header_tab_2">
												<?php /* <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center"> */ ?>
													<!--begin::Menu-->
													<div class="header-menu header-menu-mobile header-menu-layout-default">
														<!--begin::Nav-->
														<ul class="menu-nav">
															<li class="menu-item<?php if($current_url == 'accounting/pending'): echo' menu-item-active';endif;?>" aria-haspopup="true">
																<a href="<?php echo BASE_URL.'/accounting/pending';?>" class="menu-link">
																	<span class="menu-text">Pending Earnings</span>
																</a>
															</li>
															<li class="menu-item<?php if($current_url == 'accounting/all'): echo' menu-item-active';endif;?>" aria-haspopup="true">
																<a href="<?php echo BASE_URL.'/accounting/all';?>" class="menu-link">
																	<span class="menu-text">Total Earnings</span>
																</a>
															</li>
														</ul>
														<!--end::Nav-->
													</div>
													<!--end::Menu-->
												<?php /* </div> */ ?>
												<?php /* <div class="d-flex align-items-center">
													<!--begin::Actions-->
													<a href="#" class="btn btn-danger font-weight-bold my-2 my-lg-0">Generate Reports</a>
													<!--end::Actions-->
												</div> */ ?>
											</div>
											<!--end::Tab Pane-->
										<?php endif; ?>
										
									</div>
									<!--end::Tab Content-->
								</div>
								<!--end::Header Menu Wrapper-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Bottom-->
					</div>
					<!--end::Header-->