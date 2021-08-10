<table class="table mb-0">
	<thead>
		<tr>
			<th scope="col">Order#</th>
			<th scope="col">Words Length</th>
			<th scope="col">Article Info</th>
			<th scope="col" class="column-pay_rate">Pay Rate</th>
			<th scope="col">Due In</th>
			<?php if( is_editor() || wad_test() ): ?><th scope="col">Document Link</th><?php endif; ?>
			<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($orders as $order):
			$order_id = $order['order_id'];
			$current_user = wad_get_current_user();
			$employee_id = $current_user['spp_id'];
			$weekly_quota = wad_get_user_by_id($current_user['spp_id'], 'weekly_quota');
			$employee_role = strtolower(str_replace(' ', '',$current_user['role']));
			
			$action = $employee_role."_claim_order";
			$claim_button_data = "data-order_id={$order_id} data-employee_id={$employee_id} data-action={$action}";
			$claim_button_href = '?action='.$action.'&order_id='.$order_id.'&employee_id='.$employee_id;
			
			?>
			<tr <?php $test_order = explode('_',$order_id); $test_order_id = is_array($test_order) ? $test_order[0] : $order_id;  wad_test_order($test_order_id); if( $order['title'] == 'TWH TEST - PLEASE IGNORE' ){ echo ' data-test-order="1"'; }?>>
				<td><?php echo wad_order_number_html($order_id); ?></td>
				<td><?php echo $order_words_length = $order['words_length']; ?></td>
				<td>
					<?php 
					echo wad_get_order_info_html( $order );
					?>
				</td>
				<td class="column-pay_rate"><?php echo $order['pay_rate']; ?></td>
				<td><?php echo $order['due_in']; ?></td>
				<?php if( is_editor() || wad_test() ): ?>
				<td>
					<?php if( $doc_link = $order['doc_link'] ): ?>
					<a href="<?php echo $doc_link; ?>" target="_blank">Open Doc</a>
					<?php endif; ?>
				</td>
				<?php endif; ?>
				<td>
					<?php if( is_writer() ): ?>
						<a href="<?php echo $claim_button_href; ?>" class="btn btn-primary btn-sm btn-writer-claim-order" <?php echo $claim_button_data; ?>>Claim</a>
					<?php else: ?>
						<a href="<?php echo $claim_button_href ?>" class="btn btn-primary btn-sm btn-editor-claim-order" <?php echo $claim_button_data; ?>>Claim</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $pagination;  ?>