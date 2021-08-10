<?php
wad_header();

$offset = 1000*8;
$limit = 1000;

$orders = wad_query_with_fetch("SELECT * FROM orders LIMIT {$offset},{$limit}");

$order_ids_IN = "order_id IN('E7DD0450','670789A5_7','670789A5_3','DAE5CC0F_5','DAE5CC0F_8','DAE5CC0F_4','670789A5_5','DAE5CC0F_3','DAE5CC0F_6','C11E235D_5','DAE5CC0F_9','DAE5CC0F_7','DAE5CC0F_1','C11E235D_6','D98802AF_4','D98802AF_9','D98802AF_12','702792B1_5','702792B1_8','9698A4BB','22DF30C2_16','22DF30C2_17','22DF30C2_27','22DF30C2_21','7CF178AC_15','7CF178AC_22','7CF178AC_19','7CF178AC_18','0CA287C7_1','A040245B','0CA287C7_10','0CA287C7_17','0CA287C7_5','0CA287C7_4','0CA287C7_20','0CA287C7_13','0CA287C7_11','0CA287C7_18','0CA287C7_6','0CA287C7_3','0CA287C7_2','0CA287C7_19','0CA287C7_16','0CA287C7_7','0CA287C7_12','0CA287C7_8','0CA287C7_15','0CA287C7_9','0CA287C7_14','DB79E715','F8B61D5D','C8079EBC','2BC1FA71','DE787DAD','1B255126_8','1B255126_9','1B255126_11','458284C5_2','458284C5_5','C0C3691A_6','C0C3691A_7','C0C3691A_14','C0C3691A_19','C0C3691A_18','C0C3691A_13','C0C3691A_17','C0C3691A_10','C0C3691A_20','C0C3691A_16','C0C3691A_27','C0C3691A_29','C0C3691A_31','C0C3691A_28','C0C3691A_23','C0C3691A_34','C0C3691A_37','C0C3691A_35','C0C3691A_26','C0C3691A_30','C0C3691A_24','C0C3691A_25','C0C3691A_36','C0C3691A_39','C0C3691A_40','C0C3691A_38','9C367D32','906C856F_23','906C856F_15','906C856F_35','906C856F_32','906C856F_18','BF50A98E_4','906C856F_38','906C856F_30','906C856F_31','906C856F_29','906C856F_24','BF50A98E_1','BF50A98E_8','906C856F_39',' 	','order_id','doc_link','status','0D6FC7D6_9','88711AA9_4','88711AA9_16','88711AA9_9','83448A7F_28','83448A7F_27','83448A7F_44','83448A7F_52','83448A7F_26','83448A7F_54','83448A7F_34','83448A7F_36','83448A7F_31','83448A7F_32','83448A7F_47','83448A7F_49','83448A7F_75','83448A7F_65','83448A7F_64','83448A7F_66','83448A7F_74','83448A7F_80','83448A7F_53','83448A7F_83','83448A7F_85','83448A7F_59','83448A7F_92','83448A7F_100','83448A7F_95','83448A7F_103','83448A7F_96','83448A7F_87','83448A7F_81','83448A7F_67','83448A7F_105','83448A7F_110','83448A7F_89','83448A7F_102','83448A7F_84','83448A7F_97','83448A7F_70','83448A7F_118','83448A7F_101','83448A7F_77','83448A7F_86','83448A7F_78','83448A7F_124','83448A7F_94','83448A7F_111','83448A7F_98','83448A7F_113','83448A7F_88','83448A7F_119','83448A7F_99','83448A7F_123','83448A7F_139','83448A7F_115','83448A7F_109','83448A7F_129','83448A7F_112','83448A7F_137','83448A7F_134','83448A7F_136','83448A7F_120','83448A7F_131','83448A7F_138','83448A7F_142','83448A7F_145','84241ABE','B3ED3107','37CD3159_28','68F2F236_18','68F2F236_25','68F2F236_23','22E0DC33_41','A39403EE_16','A39403EE_17','A39403EE_25','A39403EE_20','A39403EE_18','A39403EE_21','A39403EE_24','A39403EE_23','BD40CB53_38','BD40CB53_39','C0DAAC58_40','3FC71D8C_11')";

$order_ids_IN = "order_id IN('0CA287C7_1', 'A040245B', '0CA287C7_10', '0CA287C7_17', '0CA287C7_5', '0CA287C7_4', '0CA287C7_20', '0CA287C7_13', '0CA287C7_11', '0CA287C7_18', '0CA287C7_6', '0CA287C7_3', '0CA287C7_2', '0CA287C7_19', '0CA287C7_16', '0CA287C7_7', '0CA287C7_12', '0CA287C7_8', '0CA287C7_15', '0CA287C7_9', '0CA287C7_14', 'DB79E715', 'F8B61D5D', 'C8079EBC', '1B255126_8', '1B255126_9', '1B255126_11', '458284C5_2', '458284C5_5', 'C0C3691A_6', 'C0C3691A_7', 'C0C3691A_14', 'C0C3691A_19', 'C0C3691A_18', 'C0C3691A_13', 'C0C3691A_17', 'C0C3691A_10', 'C0C3691A_20', 'C0C3691A_16', 'C0C3691A_27', 'C0C3691A_29', 'C0C3691A_31', 'C0C3691A_28', 'C0C3691A_23', 'C0C3691A_34', 'C0C3691A_37', 'C0C3691A_35', 'C0C3691A_26', 'C0C3691A_30', 'C0C3691A_24', 'C0C3691A_25', 'C0C3691A_36', 'C0C3691A_39', 'C0C3691A_40', 'C0C3691A_38', '9C367D32', 'B3ED3107')";


$orders = wad_query_with_fetch("SELECT * FROM orders WHERE {$order_ids_IN}");

$orders = wad_query_with_fetch("SELECT * FROM orders WHERE doc_link is NULL");


// $orders = array(
	// array('order_id'=>'D7C0BBD2_25'),
	// array('order_id'=>'D7C0BBD2_29'),
	// array('order_id'=>'BD40CB53_45'),
	// array('order_id'=>'BD40CB53_51'),
// );


$order_ids_arr = isset($_REQUEST['order']) ? $_REQUEST['order'] : array();

?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
		
			<?php echo 'offset: '.$offset; echo '<br><br>';
			echo 'updated';
			
			if( isset($_REQUEST['submit']) ) :
				
				// wad_get_add_order_doc_link_to_order_docs_table_from_logs($order_ids_arr);
				foreach($order_ids_arr as $order_id){
					wad_add_order_doc_link_if_not_avail($order_id);
				}
			?>
			
			<?php endif; ?>
				<form method="post">
					<div class="row">
						<div class="col-xl-12">
							<h3>Orders:</h3>
							<div class="checkbox-list">
							<?php foreach($orders as $order): ?>
								<?php /* <label class="checkbox checkbox-outline checkbox-md">
									<input type="checkbox" <?php if( in_array($order['order_id'], $order_ids_arr)) { echo "checked=checked"; } ?> name="order[]" value="<?php echo $order['order_id']; ?>"/>
									<span></span>
									<?php echo $order['order_id']; ?>
								</label> */ ?>
								<a href="https://app.wordagents.com/orders/<?php echo $order['order_id']; ?>" target="_blank">https://app.wordagents.com/orders/<?php echo $order['order_id']; ?></a><Br><br>
							<?php endforeach; ?>
							</div>
						</div>
					</div>
					<input type="submit" name="submit" class="btn btn-primary btn-lg btn-block"/>
				</form>
			
		</div>
	</div>
</div>
<?php echo wad_footer(); ?>