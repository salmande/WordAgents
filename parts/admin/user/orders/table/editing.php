<?php if(!empty($editing_orders)): global $user_profile_spp_id;?>
<table class="table">
	<thead>
		<tr>
			<th scope="col">Order#</th>
			<th scope="col">Words Length</th>
			<th scope="col">Article Info</th>
			<th scope="col" class="column-pay_rate">Pay Rate</th>
			<?php if( is_editor($user_profile_spp_id) ): ?><th scope="col">Due In</th><?php endif; ?>
			<th scope="col">Document Link</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($editing_orders as $order): ?>
			<tr>
				<td><?php echo wad_order_number_html($order_id = $order['order_id']); ?></td>
				<td><?php echo $order['words_length']; ?></td>
				<td>
					<?php 
					echo wad_get_order_info_html( $order );
					?>
				</td>
				<td class="column-pay_rate"><?php echo $order['pay_rate']; ?></td>
				<?php if( is_editor($user_profile_spp_id) ): ?><td><?php echo $order['due_in']; ?></td><?php endif; ?>
				<td>
					<?php if( $doc_link = $order['doc_link'] ): ?>
					<a href="<?php echo $doc_link; ?>" target="_blank">Open Doc</a>
					<?php endif; ?>
				</td>
			</tr>

		<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
No Records found
<?php endif; ?>