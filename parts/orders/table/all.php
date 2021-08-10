<table class="table" id="orders">
	<thead>
		<tr>
			<th scope="col">Order#</th>
			<th scope="col">Words Length</th>
			<th scope="col">Article Info</th>
			<th scope="col" class="column-pay_rate">Pay Rate</th>
			<th scope="col">Document Link</th>
			<th scope="col">Status</th>
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
				<td>
					<?php if( $doc_link = $order['doc_link'] ): ?>
					<a href="<?php echo $doc_link; ?>" target="_blank">Open Doc</a>
					<?php endif; ?>
				</td>
				<td><?php echo wad_get_status_label_in_editing_or_completed($order['status']); ?></td>
			</tr>
																
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $pagination;  ?>