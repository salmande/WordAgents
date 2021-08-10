<?php wad_header(); ?>
<!--begin::Content-->
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
						<h3 class="card-label">Add New User</h3>
					</div>
				</div>
				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body">
					<div class="col-md-6 offset-md-3">
					
					<?php
						$spp_roles = array('Admin', 'Customer Success', 'Contractor', 'Writer', 'Team Leader', 'Director of Content Operations', 'Editor'); 
						$email = $role = $spp_id = $weekly_quota = '';
						if( $message ){
							if( $message_type != 'success' ){
								$email = isset($_POST['email']) && $_POST['email'] ? $_POST['email'] : '';
								$role = isset($_POST['role']) && $_POST['role'] ? $_POST['role'] : '';
								$spp_id = isset($_POST['spp_id']) && $_POST['spp_id'] ? $_POST['spp_id'] : '';
								$weekly_quota = isset($_POST['weekly_quota']) && $_POST['weekly_quota'] ? $_POST['weekly_quota'] : '';
							}
							echo wad_message($message, $message_type);
						}
						?>
					
					<form class="form" method="post" action="" id="wad_add_new_user_form">
						<div class="form-group">
							<label>Email address <span class="text-danger">*</span></label>
							<input type="email" name="email" class="form-control"  placeholder="Enter email" value="<?php echo $email; ?>" required />
						</div>
						<div class="form-group">
							<label for="exampleSelect1">Role <span class="text-danger">*</span></label>
							<select class="form-control" name="role" id="exampleSelect1" required>
								<option value="">Select Role</option>
								<?php foreach($spp_roles as $spp_role): ?>
								<option value="<?php echo $spp_role; ?>"<?php if($role==$spp_role){echo " selected";} ?>><?php echo $spp_role; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label>SPP ID <span class="text-danger">*</span></label>
							<input type="text" name="spp_id" class="form-control" value="<?php echo $spp_id; ?>" placeholder="SPP ID" required />
						</div>
						<div class="form-group">
							<label>Weekly Quota <span class="text-danger">*</span></label>
							<input type="text" name="weekly_quota" class="form-control" value="<?php echo $weekly_quota; ?>" placeholder="Qeekly Quota" required />
						</div>
						<input type="hidden" name="action" value="admin_add_user" />
						<button type="submit" class="btn btn-primary mr-2">Submit</button>
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