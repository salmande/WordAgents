<?php wad_header(); global $current_user; ?>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<?php /* <!--begin::Subheader-->
	<div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
		<div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
			<!--begin::Details-->
			<div class="d-flex align-items-center flex-wrap mr-2">
				<!--begin::Title-->
				<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Add New User</h5>
				<!--end::Title-->
			</div>
			<!--end::Details-->
		</div>
	</div>
	<!--end::Subheader--> */ ?>
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Card-->
			<div class="card card-custom">
				<!--begin::Header-->
				<div class="card-header justify-content-center flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Profile</h3>
					</div>
				</div>
				<!--end::Header-->
				<!--begin::Body-->
				<?php //echo '<Pre>'; print_r($current_user); ?>
				<div class="card-body">
					<div class="col-md-6 offset-md-3">

					<form class="form" method="post" action="" id="kt_profile_form">
						<div class="form-group">
							<label>Full Name:</label>
							<input type="text" class="form-control" name="fullname" value="<?php echo $current_user['name']; ?>" />
						</div>
						<div class="form-group">
							<label>Email address:</label>
							<input type="text" class="form-control" name="email" disabled value="<?php echo $current_user['email']; ?>" />
						</div>
						<div class="form-group">
							<input class="form-control" type="password" placeholder="Password" name="password"/>
							<span class="form-text text-muted">Leave blank if you don't want to change it.</span>
						</div>
						<div class="form-group">
							<input class="form-control" type="password" placeholder="Confirm password" name="cpassword"/>
						</div>
						<div class="form-group">
							<label >Role:</label>
							<input type="text" class="form-control" name="role" disabled value="<?php echo $current_user['role']; ?>" />
						</div>
						<?php /* <div class="form-group">
							<label>SPP ID:</label>
							<div><?php echo $current_user['spp_id']; ?></div>
						</div>*/ ?>
						<div class="form-group">
							<label>Weekly Quota:</label>
							<input type="text" class="form-control" name="weekly_quota" disabled value="<?php echo $current_user['weekly_quota']; ?>" />
						</div>
						<input type="hidden" name="id" value="<?php echo $current_user['id']; ?>" />
						<input type="hidden" name="action" value="profile_form_submit" />
						<button type="submit" id="kt_profile_save_changes" class="btn btn-primary mr-2">Save Changes</button>
						<button type="reset" class="btn btn-secondary">Cancel</button>
					</form>
					</div>
				</div>
				<!--end::Body-->
			</div>
			<!--end::Card-->
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>
<!--end::Content-->
<?php wad_footer(); ?>