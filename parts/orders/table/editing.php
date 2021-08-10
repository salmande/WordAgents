<table class="table" id="orders">
	<thead>
		<tr>
			<th scope="col">Order#</th>
			<th scope="col">Words Length</th>
			<th scope="col">Article Info</th>
			<th scope="col" class="column-pay_rate">Pay Rate</th>
			<?php if( is_editor() ): ?><th scope="col">Due In</th><?php endif; ?>
			<th scope="col">Document Link</th>
			<?php if( is_editor() ): ?><th scope="col">Action</th><?php endif; ?>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($orders as $order): ?>
			<tr>
				<td><?php echo wad_order_number_html($order_id = $order['order_id']); ?></td>
				<td><?php echo $order['words_length']; ?></td>
				<td>
					<?php 
					echo wad_get_order_info_html( $order );
					?>
				</td>
				<td class="column-pay_rate"><?php echo $order['pay_rate']; ?></td>
				<?php if( is_editor() ): ?><td><?php echo $order['due_in']; ?></td><?php endif; ?>
				<td>
					<?php if( $doc_link = $order['doc_link'] ): ?>
					<a href="<?php echo $doc_link; ?>" target="_blank">Open Doc</a>
					<?php endif; ?>
				</td>
				<?php if( is_editor() ): ?>
				<td>
					<?php /* <a href="<?php echo BASE_URL; ?>?action=editor_request_revision_editing_order&order=<?php echo $order_id; ?>&employee=<?php echo wad_get_current_user('spp_id');?>" class="btn btn-danger btn-sm">Request Revision</a> */ ?>
					<div class="d-flex w-100">
						<div class="mr-2">
							<button type="button" class="btn btn-danger btn-sm mb-2 modal-request_revision-trigger" data-toggle="modal" data-target="#modal-request_revision-<?php echo $order_id; ?>">Request Revision</button>
						</div>
						<div>
							<?php /* <a href="<?php echo BASE_URL; ?>?action=editor_submit_editing_order&order=<?php echo $order_id; ?>&employee=<?php echo wad_get_current_user('spp_id');?>" class="btn btn-primary btn-sm">Complete</a>*/ ?>
							<?php /*<button type="button" class="btn btn-primary btn-sm mb-2 modal-submit_editing_order-trigger" data-toggle="modal" data-target="#modal-submit-<?php echo $order_id; ?>">Complete</button>*/ ?>
							<a class="btn btn-primary btn btn-sm mb-2 order-complete-trigger" href="javascript:;" data-order_id="<?php echo $order_id; ?>">Complete</a>
						</div>
					</div>
				</td>
				<?php endif; ?>

			</tr>

		<?php endforeach; ?>
	</tbody>
</table>

<?php foreach($orders as $order): $order_id = $order['order_id']?>
	<div class="modal fade" id="modal-request_revision-<?php echo $order_id; ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<form method="post">
				<div class="modal-header">
					<h5 class="modal-title">Request for edits Order# <?php echo $order_id; ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<textarea name="content" class="form-control" rows="3"></textarea>
					</div>
					<input type="hidden" name="order" value="<?php echo $order_id; ?>" />
					<input type="hidden" name="action" value="editor_request_revision_editing_order" />
					<input type="hidden" name="employee" value="<?php echo wad_get_current_user('spp_id');?>" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary font-weight-bold btn-submit-editor-request_revision_editing_order">Submit</button>
				</div>
				
				</form>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<?php //echo '<pre>';print_r($orders); ?>

<?php /* foreach($orders as $order): $order_id = $order['order_id']; $order_title = $order['title'] ?>
	<div class="modal fade" id="modal-submit-<?php echo $order_id; ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<form method="post">
					<div class="modal-header">
						<h5 class="modal-title"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
							<i aria-hidden="true" class="ki ki-close"></i>
						</button>
					</div>
					<div class="modal-body">
						Please confirm that you have completed the article.
						<input type="hidden" name="order" value="<?php echo $order_id; ?>" />
						<input type="hidden" name="title" value="<?php echo $order_title; ?>" />
						<input type="hidden" name="action" value="editor_submit_editing_order" />
						<input type="hidden" name="employee" value="<?php echo wad_get_current_user('spp_id');?>" />
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">STILL WRITING</button>
						<a href="<?php echo BASE_URL; ?>?action=editor_submit_editing_order&order=<?php echo $order_id; ?>&employee=<?php echo wad_get_current_user('spp_id');?>" class="btn btn-success btn-success2 font-weight-bold mb-1 editor-confirm-submit_editing_order">CONFIRM and SEND</a>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endforeach; */ ?>

<?php echo $pagination;  ?>