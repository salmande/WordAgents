<table class="table" id="orders">
	<thead>
		<tr>
			<th scope="col">Order#</th>
			<th scope="col">Words Length</th>
			<?php if( ! is_editor() ): ?>
			<th scope="col">Pay Rate</th>
			<th scope="col">Earnings</th>
			<?php endif; ?>
			<th scope="col">Status</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($orders as $order): ?>
			<tr>
				<td><?php echo wad_order_number_html($order_id = $order['order_id']); ?></td>
				<td><?php echo $order['words_length']; ?></td>
				<?php if( ! is_editor() ): ?>
				<td><?php echo $order['pay_rate']; ?></td>
				<td><?php echo $order['earning']; ?></td>
				<?php endif; ?>
				<td><?php echo wad_get_status_label_in_editing_or_completed($order['status']); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $pagination;  ?>