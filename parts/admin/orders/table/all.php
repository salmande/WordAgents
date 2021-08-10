<table class="table" id="orders">
	<thead>
		<tr>
			<th scope="col">Order#</th>
			<th scope="col">Words Length</th>
			<th scope="col">Article Info</th>
			<th scope="col">Expense</th>
			<th scope="col">Due Date</th>
			<th scope="col">Writer</th>
			<th scope="col">Editor</th>
			<th scope="col">Status</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($orders as $order): ?>
			<tr>
				<td><?php echo wad_order_number_html($order_id = $order['id']); ?></td>
				<td><?php echo $order['words_length']; ?></td>
				<td>
					<strong><?php echo $order['client_name']; ?></strong><br/><?php echo $order['title']; ?>
					<a href="javascript:;" data-toggle="modal" data-target="#modal-<?php echo $order_id; ?>"> see details</a>
					<div class="modal fade modal-order_details" id="modal-<?php echo $order_id; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $order_id; ?>ModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-body">
									<?php echo wad_order_details($order['form_data'], $order_id); ?>
								</div>
							</div>
						</div>
					</div>
				</td>
				<td><?php echo $order['pay_rate']; ?></td>
				<td><?php echo wad_get_status_label_in_editing_or_completed($order['status']); ?></td>
			</tr>
																
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $pagination;  ?>