<?php
wad_header();
?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			
			<?php if( isset($_REQUEST['submit']) ) :
			
				wad_add_all_team_members();
			
			endif; ?>
	
				<h2 class="mb-6">Add remaining team members of SPP to OG</h2>
				<form method="post">
					<div class="checkbox-inline mb-6">
					<label class="checkbox checkbox-outline checkbox-lg">
						<input type="checkbox" class="add_team" name="add_team" <?php if( isset($_REQUEST['add_team']) ) { echo "checked=checked"; } ?>  value=""/>
						<span></span>
						Add Team
					</label>
					</div><div class="checkbox-inline mb-6">
					<label class="checkbox checkbox-outline checkbox-lg">
						<input type="checkbox" class="add_users" name="add_users" <?php if( isset($_REQUEST['add_users']) ) { echo "checked=checked"; } ?>  value=""/>
						<span></span>
						Add Users
					</label>
					</div>
					<input type="submit" name="submit" class="btn btn-primary btn-lg btn-block"  tabindex="3"  value="Submit" />
				</form>
		</div>
	</div>
</div>
<?php echo wad_footer(); ?>