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
						$spp_roles = array('Admin', 'Writer', 'Editor', 'Assigner'); 
						$email = $role = $spp_id = $weekly_quota = $onetime_quota = '';
						$enable_weekly_quota = $enable_onetime_quota = 0;
						$enable_claim = 1;
						$is_archive = 0;
						$editor_revision_count_limit = 5;
						$claim_one_order = 0;
						if( $message ){
							if( $message_type != 'success' ){
								$email = isset($_POST['email']) && $_POST['email'] ? $_POST['email'] : '';
								$role = isset($_POST['role']) && $_POST['role'] ? $_POST['role'] : '';
								$spp_id = isset($_POST['spp_id']) && $_POST['spp_id'] ? $_POST['spp_id'] : '';
								$weekly_quota = isset($_POST['weekly_quota']) && $_POST['weekly_quota'] ? $_POST['weekly_quota'] : '';
								$enable_weekly_quota = isset($_POST['enable_weekly_quota']) ? $_POST['enable_weekly_quota'] : 0;
								$enable_claim = isset($_POST['enable_claim']) ? $_POST['enable_claim'] : 0;
								$onetime_quota = isset($_POST['onetime_quota']) && $_POST['onetime_quota'] ? $_POST['onetime_quota'] : '';
								$enable_onetime_quota = isset($_POST['enable_onetime_quota']) ? $_POST['enable_onetime_quota'] : 0;
								$is_archive = isset($_POST['is_archive']) ? $_POST['is_archive'] : 0;
								$editor_revision_count_limit = isset($_POST['editor_revision_count_limit']) ? $_POST['editor_revision_count_limit'] : 5;
								$claim_one_order = isset($_POST['claim_one_order']) ? $_POST['claim_one_order'] : 0;
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
							<label for="user_role">Role <span class="text-danger">*</span></label>
							<select class="form-control" name="role" id="user_role" required>
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
						<div class="form-group field-toggle field-writer">
							<label><?php echo $globals['weekly_quota_label']; ?>
							<span class="form-text text-muted"><?php echo $globals['weekly_quota_desc']; ?></span></label>
							<input type="text" name="weekly_quota" class="form-control" value="<?php echo $weekly_quota; ?>" placeholder="Weekly Quota"/>
						</div>
						<div class="form-group field-toggle field-writer">
							<label><?php echo $globals['enable_weekly_quota_label']; ?>
							<span class="form-text text-muted"><?php echo $globals['enable_weekly_quota_desc']; ?></span></label>
							<div class="radio-inline">
								<label class="radio">
									<input type="radio" <?php if( $enable_weekly_quota == 1) { echo 'checked'; } ?> name="enable_weekly_quota" value="1" />
									<span></span>
									Yes
								</label>
								<label class="radio">
									<input type="radio" <?php if( $enable_weekly_quota == 0) { echo 'checked'; } ?> name="enable_weekly_quota" value="0" />
									<span></span>
									No
								</label>
							</div>
						</div>
						<div class="form-group field-toggle field-writer">
							<label><?php echo $globals['onetime_quota_label']; ?>
							<span class="form-text text-muted"><?php echo $globals['onetime_quota_desc']; ?></span>
							<input type="text" name="onetime_quota" class="form-control" value="<?php echo $onetime_quota; ?>" placeholder="One Time Claim Quota" />
						</div>
						<div class="form-group field-toggle field-writer">
							<label><?php echo $globals['enable_onetime_quota_label']; ?>
							<span class="form-text text-muted"><?php echo $globals['enable_onetime_quota_desc']; ?></span></label>
							<div class="radio-inline">
								<label class="radio">
									<input type="radio" <?php if( $enable_onetime_quota == 1) { echo 'checked'; } ?> name="enable_onetime_quota" value="1" />
									<span></span>
									Yes
								</label>
								<label class="radio">
									<input type="radio" <?php if( $enable_onetime_quota == 0) { echo 'checked'; } ?> name="enable_onetime_quota" value="0" />
									<span></span>
									No
								</label>
							</div>
						</div>
						<div class="form-group field-toggle field-writer field-editor">
							<label>Allowed to claim?</label>
							<div class="radio-inline">
								<label class="radio">
									<input type="radio" <?php if( $enable_claim == 1) { echo 'checked'; } ?> name="enable_claim" value="1" />
									<span></span>
									Yes
								</label>
								<label class="radio">
									<input type="radio" <?php if( $enable_claim == 0) { echo 'checked'; } ?> name="enable_claim" value="0" />
									<span></span>
									No
								</label>
							</div>
						</div>
						<div class="form-group field-toggle field-editor">
							<label>Editor Revision</label>
							<input type="text" name="editor_revision_count_limit" class="form-control" value="<?php echo $editor_revision_count_limit; ?>"/>
						</div>
						<div class="form-group field-toggle field-editor">
							<label>Claim One Order at a time?</label>
							<div class="radio-inline">
								<label class="radio">
									<input type="radio" <?php if( $claim_one_order == 1) { echo 'checked'; } ?> name="claim_one_order" value="1" />
									<span></span>
									Yes
								</label>
								<label class="radio">
									<input type="radio" <?php if( $claim_one_order == 0) { echo 'checked'; } ?> name="claim_one_order" value="0" />
									<span></span>
									No
								</label>
							</div>
						</div>
						<div class="form-group">
							<label>Archive Account?</label>
							<div class="radio-inline">
								<label class="radio">
									<input type="radio" <?php if( $is_archive == 1) { echo 'checked'; } ?> name="is_archive" value="1" />
									<span></span>
									Yes
								</label>
								<label class="radio">
									<input type="radio" <?php if( $is_archive == 0) { echo 'checked'; } ?> name="is_archive" value="0" />
									<span></span>
									No
								</label>
							</div>
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