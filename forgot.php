<!DOCTYPE html><!--Template Name: Metronic - Bootstrap 4 HTML, React, Angular 10 & VueJS Admin Dashboard ThemeAuthor: KeenThemesWebsite: http://www.keenthemes.com/Contact: support@keenthemes.comFollow: www.twitter.com/keenthemesDribbble: www.dribbble.com/keenthemesLike: www.facebook.com/keenthemesPurchase: https://1.envato.market/EA4JPRenew Support: https://1.envato.market/EA4JPLicense: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.--><html lang="en">	<!--begin::Head-->
	<head><base href="<?php echo BASE_URL; ?>/" />
		<meta charset="utf-8" />
		<title>Forgot Password</title>
		<meta name="description" content="Forgot Password" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="<?php echo BASE_URL; ?>" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="<?php echo BASE_URL; ?>/assets/css/pages/login/classic/login-1.css" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
		<?php require 'head.php'; ?>	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled subheader-enabled page-loading <?php echo wad_body_classes(); ?>">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-1 login-forgot-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
				<!--begin::Content-->
				<div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
					<!--begin::Content header-->
					<!--end::Content header-->
					<!--begin::Content body-->
					<div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
						<!--begin::Signin-->						<div class="login-form login-signin">							<div class="text-center mb-15">								<img src="<?php echo BASE_URL; ?>/assets/media/logos/logo-blue.png" class="wordagents-logo" alt="WordAgents" />							</div>													<div class="text-center mb-10 mb-lg-20">								<h3 class="font-size-h1">Sign In</h3>								<p class="text-muted font-weight-bold">Enter your username and password</p>							</div>							<!--begin::Form-->							<form class="form" novalidate="novalidate" id="kt_login_signin_form">								<div class="form-group">									<input class="form-control form-control-solid h-auto py-5 px-6" type="text" placeholder="Username" name="username" autocomplete="off" />								</div>								<div class="form-group">									<input class="form-control form-control-solid h-auto py-5 px-6" type="password" placeholder="Password" name="password" autocomplete="off" />								</div>								<!--begin::Action-->								<div class="form-group d-flex flex-wrap justify-content-between align-items-center">									<a href="<?php echo BASE_URL; ?>/forgot" class="text-dark-50 text-hover-primary my-3 mr-2" id="">Forgot Password ?</a>									<button type="button" id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3">Sign In</button>								</div>								<!--end::Action-->							</form>							<!--end::Form-->						</div>						<!--end::Signin-->						<!--begin::Signup-->						<div class="login-form login-signup">							<div class="text-center mb-15">								<img src="<?php echo BASE_URL; ?>/assets/media/logos/logo-blue.png" class="wordagents-logo" alt="WordAgents" />							</div>													<div class="text-center mb-10 mb-lg-20">								<h3 class="font-size-h1">Sign Up</h3>								<p class="text-muted font-weight-bold">Enter your details to create your account</p>							</div>							<!--begin::Form-->							<form class="form" novalidate="novalidate" id="kt_login_signup_form">								<div class="form-group">									<input class="form-control form-control-solid h-auto py-5 px-6" type="text" placeholder="Full Name" name="fullname" autocomplete="off" />								</div>								<div class="form-group">									<input class="form-control form-control-solid h-auto py-5 px-6" type="email" placeholder="Email" name="email" autocomplete="off" />								</div>								<div class="form-group">									<input class="form-control form-control-solid h-auto py-5 px-6" type="password" placeholder="Password" name="password" autocomplete="off" />								</div>								<div class="form-group">									<input class="form-control form-control-solid h-auto py-5 px-6" type="password" placeholder="Confirm password" name="cpassword" autocomplete="off" />								</div>								<div class="form-group">									<label class="checkbox mb-0">									<input type="checkbox" name="agree" />									<span></span>&nbsp;I Agree the&nbsp;<a href="#">terms and conditions</a></label>								</div>								<div class="form-group d-flex flex-wrap flex-center">									<button type="button" id="kt_login_signup_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Submit</button>									<a href="<?php echo BASE_URL; ?>/login" id="" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancel</a>								</div>							</form>							<!--end::Form-->						</div>						<!--end::Signup-->						<!--begin::Forgot-->
						<div class="login-form login-forgot">
							<div class="text-center mb-15">								<img src="<?php echo BASE_URL; ?>/assets/media/logos/logo-blue.png" class="wordagents-logo" alt="WordAgents" />							</div>													<div class="text-center mb-10 mb-lg-20">
								<h3 class="font-size-h1">Forgotten Password ?</h3>
								<p class="text-muted font-weight-bold">Enter your email to reset your password</p>
							</div>
							<!--begin::Form-->
							<form class="form" novalidate="novalidate" id="kt_login_forgot_form" method="post">															<?php 								$email = '';								if( $message ){									$email = isset($_POST['email']) && $_POST['email'] ? $_POST['email'] : '';									echo wad_message($message, $message_type);								}								?>							
								<div class="form-group">
									<input class="form-control form-control-solid h-auto py-5 px-6" type="email" placeholder="Email" name="email" autocomplete="off"  value="<?php echo $email; ?>" />
								</div>
								<div class="form-group d-flex flex-wrap flex-center">
									<button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Request</button>
									<a href="<?php echo BASE_URL; ?>/login" id="" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancel</a>
								</div>								<input type="hidden" name="action" value="forgot_form_submit" />
							</form>
							<!--end::Form-->
						</div>
						<!--end::Forgot-->
					</div>
					<!--end::Content body-->
					<!--begin::Content footer for mobile-->
					<div class="d-flex d-lg-none flex-column-auto flex-column flex-sm-row justify-content-between align-items-center mt-5 p-5">
						<div class="text-dark-50 font-weight-bold order-2 order-sm-1 my-2">?? <?php echo wad_date(time(), 'Y'); ?> WordAgents</div>						<?php /* <div class="d-flex order-1 order-sm-2 my-2">
							<a href="#" class="text-dark-75 text-hover-primary">Privacy</a>
							<a href="#" class="text-dark-75 text-hover-primary ml-4">Legal</a>
							<a href="#" class="text-dark-75 text-hover-primary ml-4">Contact</a>
						</div> */ ?>
					</div>
					<!--end::Content footer for mobile-->
				</div>
				<!--end::Content-->
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		<?php require 'foot.php'; ?>
		<!--begin::Page Scripts(used by this page)-->
		<script src="<?php echo BASE_URL; ?>/assets/js/pages/custom/login/login-general.js"></script>
		<!--end::Page Scripts-->		<?php require 'before_body_close.php'; ?>
	</body>
	<!--end::Body-->
</html>