<table class="table" id="orders">
	<thead>
		<tr>
			<th scope="col">Order#</th>
			<th scope="col">Words Length</th>
			<th scope="col">Article Info</th>
			<th scope="col" class="column-pay_rate">Pay Rate</th>
			<th scope="col">Due In</th>
			<th scope="col">Due Date</th>
			<th scope="col">Document Link</th>
			<th scope="col">Action</th>
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
				<td><?php echo $order['due_in']; ?></td>
				<td><?php echo $order['date_due']; ?></td>
				<td>
					<?php if( $doc_link = $order['doc_link'] ): ?>
					<a href="<?php echo $doc_link; ?>" target="_blank">Open Doc</a>
					<?php endif; ?>
				</td>
				<td>
					<div class="d-flex w-100">
						<div class="">
							<?php /* <a href="<?php echo BASE_URL; ?>?action=writer_submit_working_order&order=<?php echo $order_id; ?>&employee=<?php echo wad_get_current_user('spp_id');?>" class="btn btn-primary btn-sm mb-1">Submit</a> */ ?>
							<button type="button" class="btn btn-primary btn-sm mb-2 modal-submit_working_order-trigger" data-toggle="modal" data-target="#modal-submit-<?php echo $order_id; ?>">Submit</button>
							<br />
							<span data-html="true" data-container="body" data-offset="" data-toggle="popover" data-trigger="click" data-placement="top" data-content="If you have questions or need clarification on your article, please message a team member in the order details thread. In the case you need to reject the assignment, <a href='<?php echo BASE_URL; ?>?action=writer_reject_working_order&order=<?php echo $order_id; ?>&employee=<?php echo wad_get_current_user('spp_id');?>'>CLICK HERE</a>. Please remember only to reject in the case of emergency once you've accepted an assignment."><a href="javascript:void(0)" style="color:#3699ff">Need Help?</a></span>
						</div>
						<?php /* <div>
							<a href="<?php echo BASE_URL; ?>?action=writer_reject_working_order&order=<?php echo $order_id; ?>&employee=<?php echo wad_get_current_user('spp_id');?>" class="btn btn-danger btn-sm">Reject</a>
						</div> */ ?>
					</div>
					
				</td>		
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php foreach($orders as $order): $order_id = $order['order_id']; $order_title = $order['title'] ?>
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
					<input type="hidden" name="action" value="writer_submit_working_order" />
					<input type="hidden" name="employee" value="<?php echo wad_get_current_user('spp_id');?>" />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal">STILL WRITING</button>
					<a href="<?php //echo BASE_URL; ?>?action=writer_submit_working_order&order=<?php echo $order_id; ?>&employee=<?php echo wad_get_current_user('spp_id');?>" class="btn btn-success btn-success2 font-weight-bold mb-1 writer-confirm-submit_working_order">CONFIRM</a>
				</div>
				
				</form>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<?php echo $pagination;  ?>