<table class="table" id="orders">
	<thead>
		<tr>
			<th scope="col">Order#</th>
			<th scope="col">Words Length</th>
			<th scope="col">Article Info</th>
			<th scope="col" class="column-pay_rate">Pay Rate</th>
			<th scope="col">Document Link</th>
			<?php if( is_writer() ): ?><th scope="col">Action</th><?php endif; ?>
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
				<?php if( is_writer() ): ?>
				<td><a href="<?php echo BASE_URL; ?>?action=writer_submit_revisions_order&order=<?php echo $order_id; ?>&employee=<?php echo wad_get_current_user('spp_id');?>" class="btn btn-primary btn-sm writer-submit_revision_order">Submit</a></td>
				<?php endif; ?>

			</tr>
																
		<?php endforeach; ?>
	</tbody>
</table>

<?php echo $pagination;  ?>