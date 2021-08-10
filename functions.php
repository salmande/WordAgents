<?php

//live

$api_username = 'api';
$api_password = 'spp_api_uZrh1SGPM9Rxz7WgIpaKtl6EDjLi3Tsv';
$api_url = 'https://app.wordagents.com';

function wad_message($message, $type = 'info'){
	return '<div class="alert alert-'.$type.'" role="alert">'.$message.'</div>';
}

function wad_get_user_by_id($spp_id, $field = null){
	global $con;
	$query = "SELECT * FROM users WHERE spp_id='".$spp_id."'";
	$result = mysqli_query($con, $query);
	$user = mysqli_fetch_assoc($result);
	if( $field ){
		return $user[$field];
	}
	return $user;
}

function wad_get_order($order_id, $field = null){
	global $con;
	$result = wad_select_query("orders","*","order_id='{$order_id}'");
	$order = mysqli_fetch_assoc($result);
	if( $field ){
		return $order[$field];
	}
	return $order;
}

function is_user_logged_in(){
	return isset($_COOKIE["wad_user_logged_in"]) && $_COOKIE["wad_user_logged_in"] ? true : false;
}

function wad_get_current_user($field = null)
{
	if ( ! is_user_logged_in() )
		return;
	
	if( isset($_COOKIE["wad_admin_logged_in_as_user"]) )
	{
		$user_spp_id = $_COOKIE["wad_user_logged_in_spp_id"];
	}
	else
	{
		if( isset($_COOKIE["wad_user_logged_in_spp_id"]) ){
			$user_spp_id = openssl_decrypt($_COOKIE["wad_user_logged_in_spp_id"], "AES-128-ECB", SECURE_KEY);
		}else{
			$user = unserialize($_COOKIE["wad_user_logged_in_info"]);
			$user_spp_id = $user['spp_id'];
		}
	}
	
	if(empty($user_spp_id)){
		setCookie('wad_user_logged_in',false, strtotime( '+10 years' ));
		header("Location: ".BASE_URL);
	}
	
	if( $user_spp_id == '3268'){
		// $user_spp_id = 3452;
	}
	
	
	$user = wad_get_user_by_id($user_spp_id);
	
	if( !$field )
		return $user;

	return $user[$field];
}

function wad_get_spp_client_info($client_id){
	
	global $api_username, $api_password, $api_url;
	
	$curl_url = $api_url."/api/v1/clients/".$client_id;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$curl_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$api_username:$api_password");
	$client = json_decode(curl_exec($ch));
	curl_close($ch);
	$client = json_decode(json_encode($client), true);
	return $client;
}

function wad_get_spp_order_info($order_id){
	
	global $api_username, $api_password, $api_url;
	
	$curl_url = $api_url."/api/v1/orders/".$order_id;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$curl_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$api_username:$api_password");
	$order = json_decode(curl_exec($ch));
	curl_close($ch);
	$order = json_decode(json_encode($order), true);
	
	return $order;
}

function wad_spp_update_order($order_id, $post, $return = false){
	
	global $api_username, $api_password, $api_url;
	
	$curl_url = $api_url.'/api/v1/orders/'.$order_id;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$curl_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$api_username:$api_password");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$updated_order = curl_exec($ch);
	if( $return ){
		return json_decode($updated_order);
	}
}

function wad_spp_delete_order($order_id){
	
	global $api_username, $api_password, $api_url;
	
	$curl_url = $api_url.'/api/v1/orders/'.$order_id;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$curl_url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_USERPWD, "$api_username:$api_password");
	curl_exec($ch);
	curl_close($ch);
}


function wad_get_spp_order_messages($order_id){
	
	global $api_username, $api_password, $api_url;
	
	$curl_url = $api_url."/api/v1/order_messages/".$order_id;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$curl_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$api_username:$api_password");
	$order_messages = json_decode(curl_exec($ch));
	curl_close($ch);
	$order_messages = json_decode(json_encode($order_messages), true);
	return $order_messages;
}

function wad_get_spp_tags_name(){
	
	global $api_username, $api_password, $api_url;
	
	$curl_url = $api_url.'/api/v1/tags';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$curl_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$api_username:$api_password");
	$tags = json_decode(curl_exec($ch), true);
	curl_close($ch);

	$t = array();
	foreach($tags as $tag){
		$t[] = $tag['name'];
	}
	return array_unique($t);
}

function wad_add_spp_order_message($order_id, $post){
	
	global $api_username, $api_password, $api_url;
	
	$curl_url = $api_url.'/api/v1/order_messages/'.$order_id;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$curl_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$api_username:$api_password");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$updated_order = curl_exec($ch);
	
}

/*
 *- Change Order status to Instruction Review after 48 hours if no claim
 */
function wad_update_submitted_orders(){
	$result = wad_select_query("orders","order_id, due_in_end","status='2'");
	$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
	foreach($orders as $order){
		$order_id = $order['order_id'];
		$due_in_end = $order['due_in_end'];
		
		if( time() > $due_in_end ){
			$status = 14; // Instruction Review
			wad_update_query("orders","status='{$status}'", "order_id='{$order_id}'");

			$data = array(
				'status' => $status
			);
			wad_spp_update_order($order_id, $data);
			
			//NEW - Decrementing new orders count for the all writers
			$args = array(
				'roles' => array('Writer'),
				'subtract_to_Writer_fields' => array('new_orders_count'),
				'order_id' => $order_id
			);
			wad_set_users_order_total_count($args);
			//NEW END
			
		}
	}
}

// if( wad_test() ){ //remove block
	// wad_update_working_orders();
	// exit;
// }  //remove

/*
 *- Order is being missed after 48/72 hours of claim and added to available list to reclaim
 */
function wad_update_working_orders(){
	
	$current_timestamp = time();
	// $current_timestamp = time() + (60*60*24*3); // 72 hours/3 days next from the current time

	$result = wad_select_query("orders","order_id, order_title, assigned, order_words, assigned_end","status='5' AND $current_timestamp > assigned_end");
	$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	if( empty($orders) )
		return;
	
	foreach($orders as $order)
	{	
		$order_id = $order['order_id'];
		$order_title = $order['order_title'];
		$assigned_end = $order['assigned_end'];
		$order_words = $order['order_words'];
		$spp_date_due = $order['spp_date_due'];
		
		$hours_passed = 48;
		if( $order_words >= 5000 ){
			$hours_passed = 72;
		}
		
		$status = 2; // Submitted
		
		$post = array(
			'status' => $status,
			"date_due"		=> date('Y-m-d H:i:s', $spp_date_due),
			"note" => ''
		);
		
		$assigned_writers = wad_get_assigned_writers($order_id);

		// if( $order_id == 'E4D06185_2'){ //remove
			
		if( !empty($assigned_writers))
		{
			$order_assigned_users = wad_get_assigned_users($order_id, 'spp_id');
			$employees 	= count($order_assigned_users) ? $order_assigned_users : array();
			
			foreach($assigned_writers as $writer)
			{
				$assigned_writer_id = $writer['spp_id'];
				$assigned_writer_name = $writer['name'];
				$assigned_writer_email = $writer['email'];
				
				$i=0;
				if( !empty($employees) ){
					foreach($employees as $employee)
					{
						$employee_id = $employee['spp_id'];
						
						if( $assigned_writer_id == $employee_id )
							continue;
						
						$post["employees[$i]"] = $employee_id;
						$i++;
					}
				}
				
				//Unassign all employees if not assigned any employee
				if( ! isset($post["employees[0]"] ) ){
					$post["employees[]"] = '';
				}

				$missed_order_ids = wad_get_user_by_id($assigned_writer_id,'missed_order_ids');
				if( $missed_order_ids )
					$missed_order_ids .= ','.$order_id;
				else
					$missed_order_ids = $order_id;
				
				wad_update_query("users","missed_order_ids='{$missed_order_ids}'", "spp_id='{$assigned_writer_id}'");
				
				wad_missed_order_from_empolyee($order_id, $assigned_writer_id);
				
				$is_deleted = wad_delete_query("order_assigned_user", "spp_id='{$assigned_writer_id}' AND order_id='{$order_id}'"); //uncomment
				
				if( $is_deleted )//uncomment block
				{
					if( wad_get_option('save_log') == 'yes' ){
						wad_insert_query( "logs",
							array( "from_type", "from_id", "action", "source", "source_id", "time", "to_type", "to_id" ),
							array( "system", $assigned_writer_id, "unassigned", "order", $order_id, time(), "user", $assigned_writer_id )
						);
					}
				}//uncomment block
			
				//NEW - Decrementing all and working orders total count for the missed writer
				$args = array(
					'subtract' => array('all_orders_count', 'working_orders_count'),
					'subtract_user_spp_id' => $assigned_writer_id,
					'subtract_words' => $order_words,
					'subtract_words_user_spp_id' => $assigned_writer_id
				);
				wad_set_users_order_total_count($args); //uncomment
				//NEW END
				
				if( wad_get_option('send_emails') == 'yes' ) //uncomment
				{
					$email_sent = '';
					
					$subject = "Notice: Order reassigned";
					$order_link = "https://app.wordagents.com/orders/".$order_id;
					
					$msg = "Hi {{writer_firstname}},<br />Your order <a href='{$order_link}'>{{order_title}} - {{order_number}}</a> has been in Working status for over {$hours_passed} hours without completion. This order will now be reassigned to another writer.<p>If you need help, contact <a href='mailto:talent@wordagents.com'>talent@wordagents.com</a>.</p>";
					
					$writer_firstname = wad_get_name_part('first',$assigned_writer_name);
					$msg = str_replace(
						array("{{writer_firstname}}", "{{order_title}}", "{{order_number}}"),
						array($writer_firstname, $order_title, $order_id),
						$msg
					);

					/* NEW EMAIL SMTP */
					$data['subject'] = $subject;
					$data['message'] = $msg;
					$data['to'] = $assigned_writer_email;
					// $data['debug'] = 1;

					$send_email_response = wad_send_email($data);
					// if( mail($writer['email'], $subject, $msg, $headers) )
					if( $send_email_response == 'sent'){
						wad_create_update_email_counter();
						$email_sent = 1;
					}
					
					if( $email_sent )
					{
						$from = "WordAgents Dashboard";
						$to = "Rejected Writer";
						wad_save_email_log($from, $to, $subject, $msg, $order_id);
					}
				} //uncomment

			}
			
			
			wad_update_query("orders","status='{$status}', started='".time()."', assigned=0", "order_id='{$order_id}'"); //uncomment
			
			wad_spp_update_order($order_id, $post);//uncomment

			//NEW - Incrementing Writers' new orders total count except missed writer
			$args = array(
				'roles' => array('Writer'),
				'add_to_Writer_fields' => array('new_orders_count'),
			);
			wad_set_users_order_total_count($args);
			//NEW END

			if( wad_get_option('save_log') == 'yes' )
			{
				wad_insert_query( "logs",
					array( "from_type", "action", "source", "source_id", "time", "data"),
					array( "system", "changed due date", "order", $order_id, time(), $spp_date_due)
				);
				wad_insert_query( "logs",
					array( "from_type", "action", "source", "source_id", "time"),
					array( "system", "deleted note", "order", $order_id, time())
				);
			}
		}
		// } //remove
	}
}

/*
 *- Order is in Working status for 42/66 hours
 */
function wad_send_email_for_working_orders(){

	$result = wad_select_query("orders","order_id, order_title, assigned, order_words, assigned_end","status='5' AND notif_before_6_hrs=0");
	$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

	if( empty($orders) )
		return;
	
	foreach($orders as $order)
	{
		$order_id = $order['order_id'];
		$order_title = $order['order_title'];
		$assigned_end = $order['assigned_end'];
		$assigned_end_before_6_hours = $assigned_end - (60*60*6); // 6 hours
		$order_words = $order['order_words'];
		
		$current_timestamp = time() + 60*60*(48-3); //45 hours
		$hours_passed = 48-6;
		if( $order_words >= 5000 ){
			$hours_passed = 72-6;
			$current_timestamp = time() + 60*60*(72-3); //69 hours
		}
		$current_timestamp = time();
		
		// echo wad_date($assigned_end,'F d H:i') .'<br>';
		// echo wad_date($assigned_end_before_6_hours,'F d H:i') .'<br>';
		// echo wad_date($current_timestamp,'F d H:i') .'<br>';
		
		if( $current_timestamp < $assigned_end && $current_timestamp > $assigned_end_before_6_hours )
		{
			$assigned_writers = wad_get_assigned_writers($order_id);

			// if( $order_id == 'E4D06185_2'){ //remove
				
			if( !empty($assigned_writers))
			{
				foreach($assigned_writers as $writer)
				{
					$assigned_writer_id = $writer['spp_id'];
					$assigned_writer_name = $writer['name'];
					$assigned_writer_email = $writer['email'];
					
					if( wad_get_option('send_emails') == 'yes' ) //uncomment
					{
						$email_sent = '';
						
						$subject = "Action required: 6 hours left to complete order {$order_id}";
						$order_link = "https://app.wordagents.com/orders/".$order_id;
						
						$msg = "Hi {{writer_firstname}},<br />Your order <u><a href='{$order_link}'>{{order_title}} - {{order_number}}</a></u> has been in Working status for over {$hours_passed} hours. Please aim to complete it within 6 hours. Otherwise, it will be reassigned to another writer.<p>If you need help, contact <a href='mailto:talent@wordagents.com'>talent@wordagents.com</a>.</p>";
						
						$writer_firstname = wad_get_name_part('first',$assigned_writer_name);
						$msg = str_replace(
							array("{{writer_firstname}}", "{{order_title}}", "{{order_number}}"),
							array($writer_firstname, $order_title, $order_id),
							$msg
						);
						
						// NEW EMAIL SMTP
						$data['subject'] = $subject;
						$data['message'] = $msg;
						$data['to'] = $assigned_writer_email;
						// $data['debug'] = 1;
					
						$send_email_response = wad_send_email($data);
						// if( mail($writer['email'], $subject, $msg, $headers) )
						if( $send_email_response == 'sent'){
							wad_create_update_email_counter();
							$email_sent = 1;
						}
						
						if( $email_sent )
						{
							$from = "WordAgents Dashboard";
							$to = "All Writers excluding Rejected and Missed Ones";
							wad_save_email_log($from, $to, $subject, $msg, $order_id);
							
							wad_update_query("orders","notif_before_6_hrs=1", "order_id='{$order_id}'"); //uncomment
							
						}
					} //uncomment
				}
			}
			// } //remove
		}
	}
}

function wad_update_query($table, $column, $where = null, $return = null){
	global $con;
	
	//$column = mysqli_real_escape_string($column,$con);
	
	$query = "UPDATE {$table}";
	$query .= " SET {$column}";
	if( $where ){
		$query .= " WHERE {$where}";
	}
	
	if( $return ){
		if( $return == 'query')
			return $query;
		
		return;
	}
	
	
	$result = mysqli_query($con, $query);
	if( !$result ){
		return die( mysqli_error($con)."\n<br>Query: $query\n<br>");
	}

}

function wad_insert_query($table, $columns, $values){

	global $con;
	
	$query = '';
	$query .= "INSERT INTO {$table}";
	
	$query .= "(";
		$query .= implode(', ', $columns);
	$query .= ")";
	
	$query .= " VALUES(";
		$i=1;
		$total = count($values);
		foreach($values as $val){
			$val = str_replace("'","''",$val);
			$query .= "'{$val}'";

			if( $i != $total )
				$query .= ', ';
			
			$i++;
		}
	$query .= ")";
		
	$result = mysqli_query($con, $query);
	if( !$result ){
		return die( mysqli_error($con)."\n<br>Query: $query\n<br>");
	}
	return $result;
	
}
	
function wad_select_query($table, $columns, $where = null, $order_by = null, $echo = false){
	global $con;
	
	$query = "SELECT {$columns}";
	$query .= " FROM {$table}";
	if ( $where ){
		$query .= " WHERE {$where}";
	}
	if( $order_by ){
		$query .= " {$order_by}";		
	}
	if( $echo )
	return $query;
	
	$result = mysqli_query($con, $query);
	if( !$result ){
		return die( mysqli_error($con)."\n<br>Query: $query\n<br>");
	}
	return $result;
}

function wad_delete_query($table, $where){
	global $con;

	$query = "DELETE FROM {$table} WHERE {$where}";
	$result = mysqli_query($con, $query);
	
	if( !$result ){
		return die( mysqli_error($con)."\n<br>Query: $query\n<br>");
	}
	return $result;
}

function wad_get_due_in_timestamp($order){
	switch( $order['status'] ){
		case 2: //Submitted
			$due_in_timestamp = $order['due_in_end'];
			break;
		case 17: //Ready To Edit
			$due_in_timestamp = $order['writer_submit_time_end'];
			break;
		case 12: //Editting
			$due_in_timestamp = $order['editor_claim_time_end'];
			break;
		default:
			$due_in_timestamp = $order['assigned_end'];
	}
	return $due_in_timestamp;
}

function wad_get_due_in($due_in_timestamp ){
	
	$date1 = date("Y-m-d G:i:s",$due_in_timestamp);
	$date2 = date("Y-m-d G:i:s",time());

	$date1 = new DateTime($date1);
	$date2 = new DateTime($date2);
	
	$date1_timestamp = $date1->getTimestamp();
	$date2_timestamp = $date2->getTimestamp();
	
	if( $date1_timestamp < $date2_timestamp ){
		return;
	}
	
	// The diff-methods returns a new DateInterval-object...
	$diff = $date2->diff($date1);
	
	$hours = $diff->h;
	$hours = $hours + ($diff->days*24);
	if( $hours > 1 ){
		$minutes = $diff->i;
		// $seconds = $diff->s;
		$due_in = ( $hours > 1 ) ? $hours . ' Hours ' : $hours . ' Hour ';
		$due_in .= ( $minutes > 1 ) ? $minutes . ' Minutes ' : $minutes . ' Minute ';
		// $due_in .= ( $seconds > 1 ) ? $seconds . ' Seconds ' : $seconds . ' Seconed ';
	}else{
		$minutes = $diff->i;
		$due_in = ( $minutes > 1 ) ? $minutes . ' Minutes' : $minutes . ' Minute';
	}
	
	return $due_in;
}

function wad_header(){
	global $wad_url;
	require 'header.php';
}

function wad_footer(){
	global $wad_url;
	require 'footer.php';
}

function wad_order_number_html($order_number){
	ob_start();
	$current_user_id = wad_get_current_user('spp_id');
	
	if( is_admin() || wad_test() ): ?>
		<a href="https://app.wordagents.com/orders/<?php echo $order_number;?>" target="_blank"> <?php
	else: ?>
		<a class="order-details-trigger" href="javascript:;" data-order_id="<?php echo $order_number; ?>"><?php
	endif;
	
		echo $order_number; ?>
	</a>

	<?php return ob_get_clean();
}

function wad_order_details($order, $order_id = null){
	$order_id = $order['order_id'];
	$order_form_data = $order['form_data'];
	
	ob_start(); 
	
	if( !empty($order_form_data) ): ?>
	
		<div class="d-table table">
			<?php foreach($order_form_data as $key => $value ): ?>
				<div class="d-table-row">
					<div class="d-table-cell"><?php echo $key; ?></div>
					<div class="d-table-cell"><?php
						$tool_link = isset($order_form_data['Optimization Tool Link']) ? $order_form_data['Optimization Tool Link'] : '';
						switch( $key ){
							case "Order Instructions":
								if( $total = count($value) ): $a=0;
									foreach($value as $doc): ?>
										<a href="<?php echo $doc; ?>" target="_blank"><?php echo substr($doc, strrpos($doc, '/') + 1); ?></a><?php 
									if( $a < ($total-1) )
									echo '<br />';
									$a++;
									endforeach; 
								endif;
								break;
							case "How many articles do you need?";
								echo $value;
								if( $order_form_data['How many articles do you need?'] > 1 ): ?>
									</div></div>
									<div class="d-table-row">
										<div class="d-table-cell">Words Length</div>
										<div class="d-table-cell"><?php echo $order['words_length'];
								endif;
								break;
							case "Which tool would you like us to use to optimize your article?":
								if( $tool_link ) : ?> <a href="<?php echo $tool_link; ?>" target="_blank"> <?php endif; 
								echo $value; 
								if( $tool_link ) : ?> </a> <?php endif; 
								break;
							case "Optimization Tool Link":
								?> <a href="<?php echo $value; ?>" target="_blank"><?php echo $value; ?></a> <?php
								break;
							default:
								echo $value;
						}
					?></div>
				</div>
			<?php endforeach; ?>
			<?php /* if( $doc_link = $order['doc_link'] ): ?>
				<div class="d-table-row">
					<div class="d-table-cell">Doc</div>
					<div class="d-table-cell"><a href="<?php echo $doc_link; ?>" target="_blank">Open Doc</a></div>
				</div>
			<?php endif; */ ?>
			
			
			<?php /*
			// Request edit text
			if( $request_for_edit_content = $order['request_for_edit_content'] ): ?>
				<div class="d-table-row">
					<div class="d-table-cell">Request for edit</div>
					<div class="d-table-cell">
						<?php echo nl2br($request_for_edit_content['content']); ?>
					</div>
				</div>
			<?php endif; */
			?>
			
			<?php if( $client_feedback = $order['client_feedback'] ): ?>
				<div class="d-table-row">
					<div class="d-table-cell">Client notes</div>
					<div class="d-table-cell"><?php echo $client_feedback; ?></div>
				</div>
			<?php endif; ?>
			
			<?php if( $client_name = $order['client_name'] ): ?>
				<div class="d-table-row">
					<div class="d-table-cell">Client name</div>
					<div class="d-table-cell"><?php echo $client_name; ?></div>
				</div>
			<?php endif; ?>		
			
			<?php if( $order['status'] == 12 ): $assigned_writers = wad_get_assigned_writers($order_id); ?>
				<div class="d-table-row">
					<div class="d-table-cell">Writer name</div>
					<div class="d-table-cell"><?php echo $assigned_writers[0]['name']; ?></div>
				</div>
			<?php endif; ?>	
			
		</div> <?php
	
	endif;
	
	if( $order_id ){
		
		if( ( $order['status'] != 2 && $order['status'] != 17 ) ) // Submitted && ReadyToEdit
		{
			echo wad_get_order_messages($order);
			
			if( is_writer() || is_editor() )
			echo wad_get_order_tags_dropdown($order);
		
		}else{
			if( is_admin() || wad_test() ){
				echo wad_get_order_messages($order);
				echo wad_get_order_tags_dropdown($order);
			}
		}

		if( is_admin() || wad_test() ){
			echo wad_get_order_history($order);
		}
	}
	
	return ob_get_clean();
}

function wad_get_order_tags_dropdown( $order){
		
	$order_id = isset($order['order_id']) ? $order['order_id'] : $order['id'];
	
	$assigned_tags = $order['tags'];
	
	//$tags_dropdown = wad_get_spp_tags_name();
	$tags_dropdown = array(
		'Priority','Question','Waiting for Clarification','Ready to Edit','Editor Review','Final Review',
		'QA Priority', 'QA Question', 'QA Ready to Assign', 'QA Assigned', 'QA Working', 'QA Ready to Edit', 'QA Editor'
	);
	ob_start(); ?>
	
	<h3 class="mt-5">Tags</h3>
	
	<form method="post" class="form-add-tag">
		<div class="form-group">
			<div class="input-group">
				<select name="tags[]" class="form-control selectpicker" data-live-search="true" multiple="multiple" required>
					<?php foreach($tags_dropdown as $tag): ?>
						<?php if ( ! in_array($tag, $assigned_tags) ): ?>
						<option data-tokens="<?php echo $tag; ?>"><?php echo $tag; ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
				<div class="input-group-append">
					<button class="btn btn-primary btn-add-tag" type="submit">Add</button>
				</div>
			</div>
		</div>
		
		<input type="hidden" name="order" value="<?php echo $order_id; ?>" />
		<input type="hidden" name="employee" value="<?php echo wad_get_current_user("spp_id"); ?>" />
		<input type="hidden" name="action" value="add_tag" />
		<input type="hidden" name="redirect" value="<?php echo BASE_URL.'/'.$order['current_page_url']; ?>" />
	</form>
	
	<?php if( !empty($assigned_tags) ): ?>
	<div class="tags-added mt-2">
		<?php foreach($assigned_tags as $tag): ?>
			<?php if( is_admin() || wad_test() ): ?>
				<form method="post" class="d-inline-block">
					<button type="submit" class="btn btn-light-primary font-weight-bold mr-2 mb-2 tag tag-delete"><?php echo $tag; ?></button>
					<input type="hidden" name="order" value="<?php echo $order_id; ?>" />
					<input type="hidden" name="employee" value="<?php echo wad_get_current_user("spp_id"); ?>" />
					<input type="hidden" name="tag_delete" value="<?php echo $tag; ?>" />
					<input type="hidden" name="action" value="remove_tag" />
				</form>
			<?php else: ?>
				<button class="btn btn-light-primary font-weight-bold mr-2"><?php echo $tag; ?></button>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	
	<?php return ob_get_clean();
	
	
}

function wad_get_order_history( $order){
	
	$order_id = isset($order['order_id']) ? $order['order_id'] : $order['id'];
	$order_client_name = $order['client_name'];
		
	$log_html = '';
	
	$result = wad_select_query("logs","*","source = 'order' AND source_id = '{$order_id}' ORDER BY id DESC");
	
	if( ! mysqli_num_rows($result) )
		return;
		
	$order_logs = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	$total = count($order_logs);
	
	$log_html = '<h3 class="mt-5">History</h3><div class="card"><div class="p-4 card-body order-history">';
	
	for( $i=0; $i<$total; $i++){
		
		$order_log_action = $order_logs[$i]['action'];
		$order_log_data = $order_logs[$i]['data'];
		
		$order_log_from_type = ( $order_logs[$i]['from_type'] ) ? $order_logs[$i]['from_type'] : 'System';
		
		if( $order_log_action == 'email sent' )
		{
			$order_log_data = json_decode($order_log_data);
			$email_sent_subject = $order_log_data->Subject;
			$email_sent_to = $order_log_data->To;
		}
		if ( $i==0 )
		{
			$log_html .= '<div class="row">';
			
			$log_html .= '<div class="col-sm-2 text-muted">';
				$log_html .= wad_date($order_logs[$i]['time']);
			$log_html .= '</div>';
			
			$log_html .= '<div class="col">';
		}
		
		if( $i>0 && ( wad_date($order_logs[$i]['time']) != wad_date($order_logs[$i-1]['time'] ) ) ){
			
			$log_html .= '</div>'; //.col
			$log_html .= '</div>'; //.row
			
			$log_html .= '<div class="row">';
			
			$log_html .= '<div class="col-sm-2 text-muted">';
				$log_html .= wad_date($order_logs[$i]['time']);
			$log_html .= '</div>';
			
			$log_html .= '<div class="col">';
			
		}
				$log_html .= '<div class="d-flex">';
			
					$log_html .= '<div class="text-right max-w-150"><span class="badge badge-secondary mr-2">';
						if( $order_log_from_type == 'user' ){
							$log_html .= wad_get_user_by_id($order_logs[$i]['from_id'],'name');
						} else if( $order_log_from_type == 'client' ){
							$log_html .= $order_client_name;
						}else{
							$log_html .= $order_log_from_type;
						}
					$log_html .= '</span></div>';
					
					$log_html .= '<div class="flex-fill">';
					
						switch( $order_log_action )
						{
							case 'changed due date':
								$log_html .= ( ( $order_log_data ) ? 'Changed due date to ' . wad_date($order_log_data, 'M d') : 'Removed due date' );
								$log_html .= '.';
								break;

							case 'changed order status':
								$log_html .= 'Changed order status to '.wad_get_status_label($order_log_data);
								break;

							case 'assigned':
								if( $order_log_from_type == 'user' && $order_logs[$i]['from_id'] == $order_logs[$i]['to_id'] ){
									$assigned_to = 'myself';
								}else{
									$assigned_to = wad_get_user_by_id($order_logs[$i]['to_id'], 'name');
									$assigned_to = $assigned_to ? $assigned_to : "Team:{$order_logs[$i]['to_id']}";
									
								}
								$log_html .= 'Assigned order to '.$assigned_to;
								$log_html .= '.';
								break;
								
							case 'unassigned':
								if( $order_log_from_type == 'user' && $order_logs[$i]['from_id'] == $order_logs[$i]['to_id'] ){
									$unassigned_from = 'myself';
								}else{
									$unassigned_from = wad_get_user_by_id($order_logs[$i]['to_id'], 'name');
									$unassigned_from = $unassigned_from ? $unassigned_from : "Team:{$order_logs[$i]['to_id']}";
								}
								$log_html .= 'Unassigned order from '.$unassigned_from;
								$log_html .= '.';
								break;
								
							case 'rejected':
								$log_html .= 'Rejected order myself';
								$log_html .= '.';
								break;

							case 'send_message':
								$log_html .= 'Posted a ';
								$log_html .= ($order_log_data)?'team':'client';
								$log_html .= ' message';
								$log_html .= '.';
								break;
							case 'Added tag':
								$log_html .= 'Added tag ';
								$log_html .= $order_log_data;
								$log_html .= '.';
								break;
							case 'Removed tag':
								$log_html .= 'Removed tag ';
								$log_html .= $order_log_data;
								$log_html .= '.';
								break;
							case 'added note':
								$log_html .= 'Added ';
								$log_html .= $order_logs[$i]['source'];
								$log_html .= ' note.';
								break;
							case 'updated note':
								$log_html .= 'Updated ';
								$log_html .= $order_logs[$i]['source'];
								$log_html .= ' note.';
								break;
							case 'deleted note':
								$log_html .= 'Deleted ';
								$log_html .= $order_logs[$i]['source'];
								$log_html .= ' note.';
								break;
							case 'created':
								$log_html .= 'Order created.';
								break;
							case 'deleted order':
								$log_html .= 'Order deleted.';
								break;
							case 'email sent':
								$log_html .= 'Email sent (to '.$email_sent_to.'): '.$email_sent_subject;
								break;
							case 'google doc created':
								$log_html .= 'Google doc created: <a target="_blank" href="'.$order_log_data.'">Open Doc</a>';
								break;
						}
					
					$log_html .= '</div>';
					
					$log_html .= '<div class="text-muted col-auto pr-0">';
						$log_html .= wad_date($order_logs[$i]['time'],'h:i A');
					$log_html .= '</div>';
					
				$log_html .= '</div>'; //d-flex
						
		if ( $i == ($total - 1) )
		{
			$log_html .= '</div>'; //.col
			$log_html .= '</div>'; //.row
		}
	}
	
	
	$log_html .= '</div></div>'; //.card, .card-body
	
	return $log_html;
}

function wad_get_order_messages($order){
	$order_id = isset($order['order_id']) ? $order['order_id'] : $order['id'];
	$messages = wad_get_spp_order_messages($order_id);
	
	ob_start();
	?>
	<h3 class="mt-5">Messages</h3>
	
	<?php if( count($messages) ): ?>
	
	<div class="card gutter-b overflow-auto max-h-225px">
		<div class="card-body p-4">
			<?php $i=1; foreach($messages as $msg): 
				$team_msg = $msg['staff_only'];
				
				$name = wad_get_user_by_id($msg['user_id'], 'name');
				$name_class = '';
				if( $team_msg )
				{
					$name .= ' added a note';
					$name_class = 'text-primary ';
				}
				else if( is_editor($msg['user_id']) )
				{
					$name_class = 'text-dark-50 ';
				}
				else
				{
					$client = wad_get_spp_client_info($msg['user_id']);
					$name = ( isset($client['name_f']) ? ( $client['name_f'] . ( isset($client['name_l']) ? ' '.$client['name_l'] : '' ) ) : '' );
					$name .= ' replied';
				}
			?>
				<div class="d-flex">
					<div class="symbol symbol-40 <?php if($team_msg){ echo " symbol-light-primary "; } ?> mr-5 mt-1">
						<span class="symbol-label">
							<?php /* <img src="/metronic/theme/html/demo7/dist/assets/media/svg/avatars/009-boy-4.svg" class="h-75 align-self-end" alt="" /> */ ?>
							<?php echo $name[0]; ?>
						</span>
					</div>
					<div class="d-flex flex-column flex-row-fluid">
						<div class="d-flex align-items-center flex-wrap">
							<span class="<?php echo $name_class; ?>mb-1 font-size-lg font-weight-bolder pr-6"><?php echo $name; ?></span>
						</div>
						<span class="text-muted font-weight-normal flex-grow-1 font-size-sm"><?php echo wad_time_elapsed_string($msg["date_added"], false, true, 2); ?></span>
						<span class="text-dark-75 font-size-sm font-weight-normal py-5 message-text"><?php echo $msg["message"]; ?></span>
					</div>
				</div>
				
				<?php if( $i!=count($messages)) : ?>
				<div class="separator separator-solid mt-2 mb-4"></div>
				<?php endif; ?>
			
			<?php $i++; endforeach; ?>
			
		</div>
	</div>
	
	<?php endif; ?>
	
	<div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
		<div class="card">
			<div class="card-header" id="headingOne3">
				<div class="card-title" data-toggle="collapse" data-target="#collapseOne3">
					Message team
				</div>
			</div>
			<div id="collapseOne3" class="collapse show" data-parent="#accordionExample3">
				<div class="card-body">
					<form method="post">
						<textarea name="content" class="tinymce message-team"></textarea>
						<input type="hidden" name="order" value="<?php echo $order_id; ?>" />
						<input type="hidden" name="employee" value="<?php echo wad_get_current_user("spp_id"); ?>" />
						<input type="hidden" name="action" value="send_message" />
						<input type="hidden" name="staff_only" value="1" />
						<button type="submit" class="btn btn-primary font-weight-bold mt-5 btn-send-message">Send Message</button>
					</form>
				</div>
			</div>
		</div>
		
		<?php //if( is_editor() && $order['status'] == 12 ): ?>
		<?php if( $order['status'] == 5 || is_admin() ): ?>
		<div class="card">
			<div class="card-header" id="headingOne4">
				<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne4">
					Message client
				</div>
			</div>
			<div id="collapseOne4" class="collapse" data-parent="#accordionExample3">
				<div class="card-body">
					<form method="post">
						<textarea name="content" class="tinymce message-team"></textarea>
						<input type="hidden" name="order" value="<?php echo $order_id; ?>" />
						<input type="hidden" name="employee" value="<?php echo wad_get_current_user("spp_id"); ?>" />
						<input type="hidden" name="action" value="send_message" />
						<input type="hidden" name="staff_only" value="0" />
						<button type="submit" class="btn btn-primary font-weight-bold mt-5 btn-send-message">Send Message</button>
					</form>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
	
	
	
	<?php
	return ob_get_clean();
}

function wad_get_status_label($status){
	$label = '<span class="label label-lg label-color label-inline">';
	switch($status){
		case '1': 	$label .= 'Pending'; 				$label = str_replace('label-color', '',$label); break;
		case '2': 	$label .= 'Submitted'; 				$label = str_replace('label-color', '',$label); break;
		case '15': 	$label .= 'Research'; 				$label = str_replace('label-color', '',$label); break;
		case '7': 	$label .= 'Assigned to Writer'; 	$label = str_replace('label-color', 'label-warning',$label); break;
		case '14': 	$label .= 'Instruction Review'; 	$label = str_replace('label-color', '',$label); break;
		case '5': 	$label .= 'Working'; 				$label = str_replace('label-color', 'label-primary',$label); break;
		case '12': 	$label .= 'Editing'; 				$label = str_replace('label-color', '',$label); break;
		case '3': 	$label .= 'Completed'; 				$label = str_replace('label-color', 'label-success2',$label); break;
		case '9': 	$label .= 'Revision'; 				$label = str_replace('label-color', 'label-danger',$label); break;
		case '6': 	$label .= 'Editor Revision'; 		$label = str_replace('label-color', 'label-danger',$label); break;
		case '17': 	$label .= 'Ready to Edit'; 			$label = str_replace('label-color', '',$label); break;
		case '4': 	$label .= 'Canceled'; 				$label = str_replace('label-color', 'label-danger',$label); break;
	}
	$label .= '</span>';
	return $label;
}

function wad_get_status_id($label){
	$id = '';
	switch($label){
		case 'Pending': 			$id = 1; break;
		case 'Submitted': 			$id = 2; break;
		case 'Research': 			$id = 15; break;
		case 'Assigned to Writer': 	$id = 7; break;
		case 'Instruction Review': 	$id = 14; break;
		case 'Working': 			$id = 5; break;
		case 'Editing': 			$id = 12; break;
		case 'Complete': 			$id = 3; break;
		case 'Revision': 			$id = 9; break;
		case 'Editor Revision': 	$id = 6; break;
		case 'Ready to Edit': 		$id = 17; break;
		case 'Canceled': 			$id = 4; break;
	}
	return $id;
}

function wad_date($timestamp, $format = 'M d'){
	return date($format,$timestamp);
}

function wad_get_users($select="*", $where=null, $order_by = null){
	$result = wad_select_query("users",$select,$where,$order_by);
	return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function wad_get_orders_assigned_user($select="*", $where=null){
	$result = wad_select_query("order_assigned_user",$select,$where);
	return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function wad_get_option($option_name){
	$result = wad_select_query("options","value","name='{$option_name}'");
	$results = mysqli_fetch_assoc($result);
	return $results['value'];
}

function wad_update_option($name, $value){
	$result = wad_select_query("options","id","name='{$name}'");
	$is_option_exist = mysqli_num_rows($result);
	if( $is_option_exist ){
		wad_update_query("options","value='{$value}'", "name='{$name}'");
	}else{
		wad_insert_query("options",array('name','value'),array($name, $value));
	}
}

function wad_assign_employee_to_order($order_id, $employee_id, $return = null){
	$result = wad_select_query("order_assigned_user","*","order_id='{$order_id}' AND spp_id='{$employee_id}'");
	if( ! mysqli_num_rows($result) ){
		wad_insert_query("order_assigned_user", array("order_id", "spp_id"), array($order_id, $employee_id) );
	}
	if( $return == 'has_assigned')
	return mysqli_num_rows($result);
}

function wad_unassign_employee_from_order($order_id, $employee_id){
	$result = wad_select_query("order_assigned_user","*","order_id='{$order_id}' AND spp_id='{$employee_id}'");
	if( mysqli_num_rows($result) ){
		return wad_delete_query("order_assigned_user", "spp_id='{$employee_id}' AND order_id='{$order_id}'");
	}
	return false;
}

function wad_unassign_bulk_users_from_order($order_id, $employees_ids){
	
	foreach($employees_ids as $employee_id)
	{
		if( wad_has_assigned_user_to_order($order_id, $employee_id))
		{
			if( wad_unassign_employee_from_order($order_id, $employee_id) )
			{
				if( wad_get_option('save_log') == 'yes' ){
					wad_insert_query( "logs",
						array( "from_type", "action", "source", "source_id", "time", "to_type", "to_id" ),
						array( "system", "unassigned", "order", $order_id, time(), "user", $employee_id )
					);
				}
			}
		}
	}
}


function wad_get_assigned_users($order_id, $columns = '*'){
	$result = wad_select_query("order_assigned_user",$columns,"order_id='{$order_id}'");
	return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function wad_get_assigned_users_ids($order_id, $columns = 'spp_id'){
	$result = wad_select_query("order_assigned_user",$columns,"order_id='{$order_id}'");
	$records = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	if( ! count($records) )
		return;
	
	$assigned_user_ids = array();
	foreach($records as $rec){
		$spp_id = $rec['spp_id'];
		$assigned_user_ids[] = $spp_id;
	}
	return $assigned_user_ids;

}

function wad_get_assigned_editors($order_id, $columns = '*'){
	$result = wad_select_query("order_assigned_user",$columns,"order_id='{$order_id}'");
	$records = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$editors = array();
	$e = 0;
	foreach($records as $rec){
		$spp_id = $rec['spp_id'];
		if( is_editor($spp_id) ){
			$editor = wad_get_user_by_id($spp_id);
			$editors[$e]['spp_id'] = $spp_id;
			$editors[$e]['email'] = $editor['email'];
			$editors[$e]['name'] = $editor['name'];
			$e++;
		}
	}
	return $editors;
}

function wad_get_assigned_writers($order_id, $columns = '*'){
	$result = wad_select_query("order_assigned_user",$columns,"order_id='{$order_id}'");
	$records = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$writers = array();
	$w = 0;
	foreach($records as $rec){
		$spp_id = $rec['spp_id'];
		if( is_writer($spp_id) ){
			$writer = wad_get_user_by_id($spp_id);
			$writers[$w]['spp_id'] = $spp_id;
			$writers[$w]['email'] = $writer['email'];
			$writers[$w]['name'] = $writer['name'];
			$w++;
		}
	}
	return $writers;
}

function wad_get_assigned_writers_ids($order_id){
	$result = wad_select_query("order_assigned_user","*","order_id='{$order_id}'");
	$records = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	if( ! count($records) )
		return;
	
	$writers_ids = array();
	foreach($records as $rec){
		$spp_id = (int) $rec['spp_id'];
		if( is_writer($spp_id) ){
			$writers_ids[] = $spp_id;
		}
	}
	return $writers_ids;
}

function wad_get_assigned_editors_ids($order_id, $columns = 'spp_id'){
	$result = wad_select_query("order_assigned_user",$columns,"order_id='{$order_id}'");
	$records = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	if( ! count($records) )
		return;
	
	$editors_ids = array();
	foreach($records as $rec){
		$spp_id = (int) $rec['spp_id'];
		if( is_editor($spp_id) ){
			$editors_ids[] = $spp_id;
		}
	}
	return $editors_ids;
}


function wad_get_assigned_users_by_role($order_id, $role = 'Writer'){
	$result = wad_select_query("order_assigned_user","*","order_id='{$order_id}'");
	$records = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$role_var = strtolower(str_replace(array(' ',',','.'),'',$role));
	${$role_var."_ids"} = array();
	foreach($records as $rec){
		$spp_id = $rec['spp_id'];
		if( $role == 'Writer'){
			if( is_writer($spp_id) ){
				${$role_var."_ids"}[] = $spp_id;
			}
		}
		if( $role == 'Editor'){
			if( is_editor($spp_id) ){
				${$role_var."_ids"}[] = $spp_id;
			}
		}
	}
	return ${$role_var."_ids"};
}

function wad_get_assigned_writers_and_editors($order_id, $columns = '*'){
	$result = wad_select_query("order_assigned_user",$columns,"order_id='{$order_id}'");
	$records = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$writers = $editors = array();
	$w = $e = 0;
	foreach($records as $rec){
		$spp_id = $rec['spp_id'];
		$user = wad_get_user_by_id($spp_id);
		if( is_writer($spp_id) ){
			$writers[$w]['spp_id'] = $spp_id;
			$writers[$w]['email'] =  $user['email'];
			$writers[$w]['name'] =  $user['name'];
			$w++;
		}
		if( is_editor($spp_id) ){
			$editors[$e]['spp_id'] = $spp_id;
			$editors[$e]['email'] = $user['email'];
			$editors[$e]['name'] = $user['name'];
			$e++;
		}
	}
	return array('writers'=>$writers, 'editors'=>$editors);
}

function wad_has_assigned_user_to_order($order_id, $employee_id){
	$result = wad_select_query("order_assigned_user","*","order_id='{$order_id}' AND spp_id='{$employee_id}'");
	return mysqli_num_rows($result);
}

function wad_reject_order_from_empolyee($order_id, $employee_id){
	$result = wad_select_query("user_rejected_order","*","order_id='{$order_id}' AND spp_id='{$employee_id}' AND missed='0'");
	if( ! mysqli_num_rows($result) ){
		wad_insert_query("user_rejected_order", array("order_id", "spp_id", "missed"), array($order_id, $employee_id, "0") );
	}
}

function wad_missed_order_from_empolyee($order_id, $employee_id){
	$result = wad_select_query("user_rejected_order","*","order_id='{$order_id}' AND spp_id='{$employee_id}' AND missed='1'");
	if( ! mysqli_num_rows($result) ){
		wad_insert_query("user_rejected_order", array("order_id", "spp_id", "missed"), array($order_id, $employee_id, "1") );
	}
}

function wad_get_writers_excluding_rejected__and_missed_ones($order_id, $columns){
	$result = wad_select_query("users, user_rejected_order", $columns, "users.role='writer' AND user_rejected_order.spp_id != users.spp_id AND user_rejected_order.order_id = '{$order_id}'");
	$writers = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $writers;
}

function wad_get_rejected_users_ids_by_order($order_id){
	$result = wad_select_query("user_rejected_order","spp_id","order_id='{$order_id}'");
	$records = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$ids = array();
	if( ! empty($records) ){
		foreach($records as $rec){
			$ids[] = $rec['spp_id'];
		}
	}
	return $ids;
}


/**
 * Displays pagination links based on given parameters
 *
 * @param int $currentPage - current page
 * @param int $itemCount - number of items to paginate, used to calculate total number of pages
 * @param int $itemsPerPage - number of items per page, used to calculate total number of pages
 * @param boolean $showPrevNext - whether to show previous and next page links
 * @return $pagination html
 */
function wad_pagination($currentPage, $itemCount, $itemsPerPage, $adjacentCount=2, $showPrevNext = true)
{		
	$orders_per_page_dropdown = ( wad_get_option('orders_per_page_dropdown') ) ? wad_get_option('orders_per_page_dropdown') : '	2,5,10,25,50,100';
	$orders_per_page_dropdown_array = explode(',',$orders_per_page_dropdown);

    $firstPage = 1;
    $lastPage  = ceil($itemCount / $itemsPerPage);
	
	$output = '<div class="wad-pagination border-top pt-4 mb-n4">';
		$output .= '<div class="d-flex justify-content-between align-items-center flex-wrap">';
			$output .= '<div class="d-flex flex-wrap py-2 mr-3">';
			
				if ($lastPage != 1) {

					if ($currentPage <= $adjacentCount + $adjacentCount) {
						$firstAdjacentPage = $firstPage;
						$lastAdjacentPage  = min($firstPage + $adjacentCount + $adjacentCount, $lastPage);
					} elseif ($currentPage > $lastPage - $adjacentCount - $adjacentCount) {
						$lastAdjacentPage  = $lastPage;
						$firstAdjacentPage = $lastPage - $adjacentCount - $adjacentCount;
					} else {
						$firstAdjacentPage = $currentPage - $adjacentCount;
						$lastAdjacentPage  = $currentPage + $adjacentCount;
					}
							
					if ($showPrevNext) {
						if ($currentPage == $firstPage) {
							$output .= '<a href="javascript:;" class="page btn btn-icon btn-xs btn-light mr-2 my-1 cursor-default disabled"><i class="ki ki-bold-arrow-back icon-xs"></i></a>';
						} else {
							$output .= '<a data-page="'.($currentPage-1).'" data-per_page="'.$itemsPerPage.'" class="page btn btn-icon btn-xs btn-light mr-2 my-1"><i class="ki ki-bold-arrow-back icon-xs"></i></a>';
						}
					}
					if ($firstAdjacentPage > $firstPage) {
						$output .= '<a data-page="'.($firstPage).'" data-per_page="'.$itemsPerPage.'" class="page btn btn-icon btn-xs border-0 mr-2 my-1 btn-light">' . $firstPage . '</a>';
						if ($firstAdjacentPage > $firstPage + 1) {
							$output .= '<a href="javascript:;" class="page btn btn-icon btn-xs border-0 btn-light mr-2 my-1 cursor-default disabled">...</a>';
						}
					}
					for ($i = $firstAdjacentPage; $i <= $lastAdjacentPage; $i++) {
						if ($currentPage == $i) {
							$output .= '<span class="btn btn-icon btn-xs border-0 mr-2 my-1 btn-primary cursor-default disabled">' . $i . '</span>';
						} else {
							$output .= '<a data-page="'.($i).'" data-per_page="'.$itemsPerPage.'" class="page btn btn-icon btn-xs border-0 mr-2 my-1 btn-light">' . $i . '</a>';
						}
					}
					if ($lastAdjacentPage < $lastPage) {
						if ($lastAdjacentPage < $lastPage - 1) {
							$output .= '<a href="javascript:;" class="page btn btn-icon btn-xs border-0 btn-light mr-2 my-1 cursor-default disabled">...</a>';
						}
						$output .= '<a data-page="'.($lastPage).'" data-per_page="'.$itemsPerPage.'" class="page btn btn-icon btn-xs border-0 mr-2 my-1 btn-light">' . $lastPage . '</a>';
					}
					if ($showPrevNext) {
						if ($currentPage == $lastPage) {
							$output .= '<a href="javascript:;" class="page btn btn-icon btn-xs btn-light mr-2 my-1 disabled"><i class="ki ki-bold-arrow-next icon-xs"></i></a>';
						} else {
							$output .= '<a data-page="'.($currentPage+1).'" data-per_page="'.$itemsPerPage.'" class="page btn btn-icon btn-xs btn-light mr-2 my-1"><i class="ki ki-bold-arrow-next icon-xs"></i></a>';
						}
					}	
				}
			
			ob_start();
			
			?>
			
			</div>
			<div class="d-flex align-items-center py-3">
				<div class="d-flex align-items-center loader-pagination hide">
					<div class="mr-2 text-muted">Loading...</div>
					<div class="spinner mr-10"></div>
				</div>
				<form class="pagination-form">
					<select class="form-control form-control-xs font-weight-bold mr-4 border-0 bg-light select-per-page" style="width: 75px;" name="per_page">
						<?php foreach($orders_per_page_dropdown_array as $dropdown_item): ?>
							<option value="<?php echo trim($dropdown_item); ?>" <?php if($itemsPerPage==$dropdown_item){ echo 'selected';} ?>><?php echo $dropdown_item; ?></option>
						<?php endforeach; ?>
					</select>
					<input type="hidden" name="page" value="1" />
					<input type="hidden" name="action" value=""/>
				</form>
				
				<?php
					$total = $itemCount;
					$end = $currentPage*$itemsPerPage;
					$start = $end-$itemsPerPage+1;
					
					if( $itemsPerPage > $total || $start == $total || $currentPage == $lastPage ){
						$end = $total;
					}
				?>
				
				<span class="text-muted"><?php echo "Displaying $start - $end of $total records"; ?></span>
			</div> 
		</div>
	</div>

	<?php
	
	$output .= ob_get_clean();

	return $output;
}

function is_editor($employee_id = null){
	if( $employee_id ){
		$user_role = wad_get_user_by_id($employee_id, 'role');
	}else{
		$user_role = wad_get_current_user('role');
	}
		
	if( $user_role == 'Editor' ){
		return true;
	}
	return false;
}

function is_writer($employee_id = null){
	if( $employee_id ){
		$user_role = wad_get_user_by_id($employee_id, 'role');
	}else{
		$user_role = wad_get_current_user('role');
	}
		
	if( $user_role == 'Writer' ){
		return true;
	}
	return false;
}

function is_admin($user_id = null){
	if( $user_id ){
		$user_role = wad_get_user_by_id($user_id, 'role');
	}else{
		$user_role = wad_get_current_user('role');
	}
		
	if( $user_role == 'Admin' ){
		return true;
	}
	return false;
}

function wad_get_status_label_in_editing_or_completed($status){
	$before = $after = '';
	$status_label = wad_get_status_label($status);
	
	if( $status_label == 'Editing' ){
		$before = 'In '; 
	}
	if( $status_label == 'Complete' ){
		$after = 'd'; 
	}
	
	return $before.$status_label.$after;
}

function wad_set_and_get_employee_name($employee_id){
	
	$employee_email = wad_get_user_by_id($employee_id, "email");
	$employee_email = explode('@',$employee_email);
	$employee_name = ucwords(str_replace(array('.','-'),' ',$employee_email[0]));
	
	return $employee_name;
		
}

function wad_time_elapsed_string($datetime, $full = false, $show_date = false, $num_days = null) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    
	if( !$show_date || $diff->d < $num_days ){
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}else{
		return wad_date($ago->getTimestamp(), 'M jS') . ' at ' . wad_date($ago->getTimestamp(), 'g:i a');
	}
	
}

function wad_get_order_earning($order, $spp_id = null){
	
	if( !$spp_id )
	$spp_id = wad_get_current_user('spp_id');
	
	$order_id = $order['order_id'];
	$order_words_length = (int)$order['order_words'];
	
	$order_pay_rate = wad_get_pay_rate($order, $spp_id);
	
	$order_earning = $order_words_length * $order_pay_rate;
	
	return $order_earning;
}

function wad_get_pay_rate($order, $spp_id = null){
	if( !$spp_id )
		$spp_id = wad_get_current_user('spp_id');
		
	if( is_editor($spp_id) ){
		$order_pay_rate = 0.003;
	}else{
		$order_pay_rate = ($order['is_tool']) ? 0.033 : 0.03;
	}
	return $order_pay_rate;
}

function wad_get_team(){
	$result = wad_select_query("spp_team","*");
	$records = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$team = array();
	foreach($records as $r){
		$team[$r['email']] = $r;
	}
	return $team;
}

function wad_get_team_member_by_email($email = null){
	$result = wad_select_query("spp_team","*","email='{$email}'");
	$team = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $team[0];
}

function wad_get_order_info_html($order){
	$order_id = $order['order_id'];
	// $order_client_name = $order['client_name'];
	$order_title = isset($order['title']) ? $order['title'] : $order['order_title'];
	
	ob_start();
	
	/* <strong><?php echo $order_client_name; ?></strong><br/> */ ?>
	<strong><?php echo $order_title; ?></strong>
	<a class="d-inline-block order-details-trigger" href="javascript:;" data-order_id="<?php echo $order_id; ?>"> see details</a>
	<?php
	
	return ob_get_clean();
	
}

function wad_get_rejected_orders_by_id($employee_id, $total_records = false){
	$result = wad_select_query("user_rejected_order","*","spp_id='{$employee_id}' AND missed='0'");
	if( $total_records ){
		return mysqli_num_rows($result);
	}
	return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function wad_get_missed_orders_by_id($employee_id, $total_records = false){
	$result = wad_select_query("user_rejected_order","*","spp_id='{$employee_id}' AND missed='1'");
	if( $total_records ){
		return mysqli_num_rows($result);
	}
	return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function wad_get_new_created_orders($for = null){
	$option_name = 'wad_new_orders_created';
	if( $for == 'editor'){
		$option_name = 'wad_new_orders_submitted';
	}
	$new_orders_string = wad_get_option($option_name);
	
	if( $new_orders_string )
	return explode(',',$new_orders_string);
	
	return array();
}

function wad_store_new_created_order($order_id, $for = null){
	$option_name = 'wad_new_orders_created';
	if( $for == 'editor'){
		$option_name = 'wad_new_orders_submitted';
	}
	$new_orders = wad_get_new_created_orders($for);
	$new_orders_string = $order_id;
	if( is_array($new_orders) ){
		$new_orders[] = $order_id;
		$new_orders_string = implode(',',$new_orders);
	}
	wad_update_option($option_name,$new_orders_string);
}

function wad_send_new_created_orders_email()
{
	$date = wad_date(time(),'d');
	$new_orders_email_sent_today 		= wad_get_option('wad_new_orders_created_email_sent_today');
	$new_orders_email_sent_today_date 	= wad_get_option('wad_new_orders_created_email_sent_date');
	if( $date == $new_orders_email_sent_today_date && $new_orders_email_sent_today ){
		return;
	}
	
	$new_orders = wad_get_new_created_orders();
	$new_orders_total = count($new_orders);
	if( !$new_orders_total ){
		return;
	}
	
	$new_orders_with_submitted_status = array();
	foreach($new_orders as $order_id){
		if( wad_get_order($order_id, 'status') == 2){ //Submitted
			$new_orders_with_submitted_status[] = $order_id;
		}
	}
	$new_orders_total = count($new_orders_with_submitted_status);
	if( !$new_orders_total ){
		return;
	}
	
	// $time = time();
	// $hour = wad_date($time,'H');
	
	// if( $hour >= 0){
		
		$link_to_OG_login_page = BASE_URL.'/login';

		$subject = "New orders available!";
		
		$writers = wad_get_users("email, name","role='writer'");
		$email_sent = '';
		foreach($writers as $writer)
		{
			/* NEW EMAIL SMTP */
			
			$msg = "Hi {{writer_firstname}},<br />New orders are available!<p><a href='{{link_to_OG_login_page}}'>Login to the WordAgents self-service dashboard</a> to see the new orders available to claim.</p><p>If you need help, contact <a href='mailto:support@wordagents.com'>support@wordagents.com</a>.</p>";
			
			$writer_firstname = wad_get_name_part('first',$writer['name']);
			$msg = str_replace(
				array("{{writer_firstname}}", "{{link_to_OG_login_page}}"),
				array($writer_firstname, $link_to_OG_login_page),
				$msg
			);

			$data['subject'] = $subject;
			$data['message'] = $msg;
			$data['to'] = $writer['email'];
			// $data['debug'] = 1;
			
			$send_email_response = wad_send_email($data);
			// if( mail($writer['email'], $subject, $msg, $headers) )
			if( $send_email_response == 'sent'){
				wad_create_update_email_counter();
				wad_update_option('wad_new_orders_created','');
				wad_update_option('wad_new_orders_created_email_sent_today',true);
				wad_update_option('wad_new_orders_created_email_sent_date',$date);
				// echo 'mail sent';
				$email_sent = 1;
			}
		}
		if( $email_sent )
		{
			foreach($new_orders as $order_id){
				$from = "WordAgents Dashboard";
				$to = "All Writers";
				wad_save_email_log($from, $to, $subject, $msg, $order_id);
			}
		}
	// }
}

function wad_send_new_submitted_orders_email()
{
	$date = wad_date(time(),'d');
	$new_orders_email_sent_today 		= wad_get_option('wad_new_orders_submitted_email_sent_today');
	$new_orders_email_sent_today_date 	= wad_get_option('wad_new_orders_submitted_email_sent_date');
	if( $date == $new_orders_email_sent_today_date && $new_orders_email_sent_today ){
		return;
	}
	
	$new_orders = wad_get_new_created_orders('editor');
	$new_orders_total = count($new_orders);
	if( !$new_orders_total ){
		return;
	}
		
	$new_orders_with_readyToEdit_status = array();
	foreach($new_orders as $order_id){
		if( wad_get_order($order_id, 'status') == 17){ //Ready to Edit
			$new_orders_with_readyToEdit_status[] = $order_id;
		}
	}
	$new_orders_total = count($new_orders_with_readyToEdit_status);
	if( !$new_orders_total ){
		return;
	}
	
	// $time = time();
	// $hour = wad_date($time,'H');
	
	// if( $hour >= 0){
		
		$link_to_OG_login_page = BASE_URL.'/login';

		$subject = "New orders available!";
		
		$headers = "From: team@wordagents.com" . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1" . "\r\n"; 
		
		$editors = wad_get_users("email, name","role='editor'");
		$email_sent = '';
		foreach($editors as $editor)
		{
			/* NEW EMAIL SMTP */
			
			$msg = "Hi {{editor_firstname}},<br />New orders are available!<p><a href='{{link_to_OG_login_page}}'>Login to the WordAgents self-service dashboard</a> to see the new orders available to claim.</p><p>If you need help, contact <a href='mailto:support@wordagents.com'>support@wordagents.com</a>.</p>";
			
			$editor_firstname = wad_get_name_part('first',$editor['name']);
			$msg = str_replace(
				array("{{editor_firstname}}", "{{link_to_OG_login_page}}"),
				array($editor_firstname, $link_to_OG_login_page),
				$msg
			);

			$data['subject'] = $subject;
			$data['message'] = $msg;
			$data['to'] = $editor['email'];
			// $data['debug'] = 1;
			
			$send_email_response = wad_send_email($data);
			// if( mail($editor['email'], $subject, $msg, $headers) )
			if( $send_email_response == 'sent'){
				wad_create_update_email_counter();
				wad_update_option('wad_new_orders_submitted','');
				wad_update_option('wad_new_orders_submitted_email_sent_today',true);
				wad_update_option('wad_new_orders_submitted_email_sent_date',$date);
				$email_sent = 1;
			}
		}
		if( $email_sent )
		{
			foreach($new_orders as $order_id){
				$from = "WordAgents Dashboard";
				$to = "All Editors";
				wad_save_email_log($from, $to, $subject, $msg, $order_id);
			}
		}
	// }
}

function wad_set_email_log_data($data){
	$output = '';
	foreach($data as $key => $value)
	{	
		if( $key == 'Body')
			$value = base64_decode($value);
			
		$output .= $key.': '. $value. '<br>';
	}
	return $output;
	
}

function wad_save_email_log($from, $to, $subject, $msg, $order_id){
	$log_data = json_encode(
		array(
			'From' => $from,
			'To' => $to,
			'Subject' => $subject,
			'Body' => base64_encode($msg)
		)
	);
	wad_insert_query( "logs",
		array( "from_type", "action", "source", "source_id", "time", "data" ),
		array( "system", "email sent", "order", $order_id, time(),  $log_data )
	);
}

function wad_body_classes(){
	
	$class = array();

	if ( is_user_logged_in() ) {
        $class[] = 'logged-in';
		$user = wad_get_current_user();
		$role = str_replace(' ', '-',strtolower($user['role']));
		$spp_id = $user['spp_id'];
		
		$class[] = $role;
		$class[] = 'user-spp_id-'.$spp_id;
    }else{
        $class[] = 'not-logged-in';	
	}
	
	return implode(' ', $class);
}

function wad_test(){
	return ( wad_get_current_user('spp_id') == 3268 || wad_get_current_user('spp_id') == 3278 || wad_get_current_user('spp_id') == 4165 );
}

function wad_get_current_url($domain_exclude = null){
	global $wad_url;
	
	$baseurl = str_replace('wad-orders','orders',$wad_url);
	$baseurl = str_replace('wad-admin','admin',$baseurl);
	
	if( $domain_exclude )
		return $baseurl;
	
	return BASE_URL.'/'.$baseurl;
}

function wad_get_timestamp_of_monday_first_day_of_the_week(){
	$now = time();

	$is_monday_today = ( date('D',$now) ) == 'Mon' ? true : false;
	$is_sunday_today = ( date('D',$now) ) == 'Sun' ? true : false;

	$today_or_monday_timestamp = strtotime("last Monday",$now);
	$sunday_timestamp = strtotime("next Monday")-1;
	if( $is_monday_today ){
		$today_or_monday_timestamp = strtotime("today",$now);
	}
	if( $is_sunday_today ){
		$today_or_monday_timestamp = strtotime("last Monday",$now);
		$sunday_timestamp = strtotime("last Monday")-1;
	}
	
	return $today_or_monday_timestamp;
	
}

function wad_get_timestamp_of_sunday_last_day_of_the_week(){
	$now = time();

	$is_monday_today = ( date('D',$now) ) == 'Mon' ? true : false;
	$is_sunday_today = ( date('D',$now) ) == 'Sun' ? true : false;

	$today_or_monday_timestamp = strtotime("last Monday",$now);
	$sunday_timestamp = strtotime("next Monday")-1;
	if( $is_monday_today ){
		$today_or_monday_timestamp = strtotime("today",$now);
	}
	if( $is_sunday_today ){
		$today_or_monday_timestamp = strtotime("last Monday",$now);
		$sunday_timestamp = strtotime("last Monday")-1;
	}
	
	return $sunday_timestamp;
	
}

// writer claim order - START
function wad_writer_claim_order()
{
	$order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : '';
	$employee_id = isset($_REQUEST['employee_id']) ? $_REQUEST['employee_id'] : '';
	$ajax = isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : '';
	$status = 5; // Working

	if( !$order_id )
		die();
	
	// Checking either claimed already or not
	if( count(wad_get_assigned_writers($order_id)) ){
		$msg = 'This article has been claimed by another writer. Please reload the page to see the latest orders.';
		$result = array('result'=>'already_claimed','msg'=>$msg);
		if( $ajax ){
			echo json_encode($result);
		}else{
			$msg = 'This article has been claimed by another writer. Please <a href="'.BASE_URL.'/orders'.'">click here</a> to see the latest orders.';
			echo $msg;			
		}
		die();
	}
	
	// 
	if( $_SESSION['new_orders_count'] ){
		$_SESSION['new_orders_count'] = $_SESSION['new_orders_count'] - 1;
	}
	
	$employee = wad_get_user_by_id($employee_id);
	$employee_name = $employee['name'];
	$employee_email = $employee['email'];
	$rejected_order_ids = $employee['rejected_order_ids'];
	
	$order_info = wad_get_spp_order_info($order_id);
	$order_title = $order_info['service'];
	$order_words = (int) (str_replace(array(',','Words'),'',$order_info['options']['How many words?']));
	
	$current_timestamp = time();
	$order = array_merge(wad_get_order($order_id), $order_info);
	
	$date_due_timestamp = wad_get_new_orders_due_timestamp($order_words);
	
	$note = wad_get_note_for_working_order(array(
		'order' => $order,
		'order_id' => $order_id,
		'writer_spp_id' => $employee_id,
		'writer_name' => $employee_name,
		'date_due_timestamp' => $date_due_timestamp
	));
	
	$doc_link = $order["doc_link"];
	$note .= '<br><a href="'.$doc_link.'" target="_blank">'.$doc_link.'</a>';
	
	$post = array(
		"status" 		=> $status,
		"date_due"		=> date('Y-m-d H:i:s', $date_due_timestamp),
		"note"			=> $note
	);
	
	$employees 	= isset($order_info['employees']) ? $order_info['employees'] : array();
	$i=0;
	if( count($employees) ){
		foreach($employees as $employee){
			$post["employees[$i]"] = $employee['id'];
			$i++;
		}
	}
	$post["employees[$i]"] = $employee_id;
	
	$response = wad_spp_update_order($order_id,$post,true);
	
	wad_update_query("orders", "status='{$status}', assigned='{$current_timestamp}', assigned_end ='{$date_due_timestamp}', date_due ='{$date_due_timestamp}'", "order_id='{$order_id}'");
	
	//NEW - Decrementing all writers' orders total count
	//NEW - Incrementing working/all orders total count for the writer who claimed
	$args = array(
		'roles' => array('Writer'),
		'subtract_to_Writer_fields' => array('new_orders_count'),
		'order_id' => $order_id,
		'add' => array('working_orders_count', 'all_orders_count'),
		'add_user_spp_id' => $employee_id,
		'add_words' => $order_words,
		'add_words_user_spp_id' => $employee_id,
	);
	wad_set_users_order_total_count($args);
	//NEW END
	
	// Set assigned orders for user
	wad_save_assigned_orders_to_user($employee_id, $order_id);
	
	wad_delete_query("user_rejected_order", "spp_id='{$employee_id}' AND order_id='{$order_id}'");	
	
	if( !empty($rejected_order_ids) ){
		$rejected_order_ids_new = array();
		$rejected_order_ids_array = explode(',',$rejected_order_ids);
		foreach( $rejected_order_ids_array as $id){
			if( $id == $order_id )
				continue;
			
			$rejected_order_ids_new[] = $id;
		}
		
		$rejected_order_ids = implode(',',$rejected_order_ids_new);
		
		wad_update_query("users","rejected_order_ids='{$rejected_order_ids}'", "spp_id='{$employee_id}'"); //uncomment
	}

	wad_assign_employee_to_order($order_id, $employee_id);
	
	if( wad_get_option('save_log') == 'yes' ){
		
		wad_insert_query( "logs",
			array( "from_type", "from_id", "action", "source", "source_id", "time", "to_type", "to_id" ),
			array( "user", $employee_id, "assigned", "order", $order_id, time(), "user", $employee_id )
		);

		wad_insert_query( "logs",
			array( "from_type", "action", "source", "source_id", "time", "data"),
			array( "System", "changed order status", "order", $order_id, time(), $status)
		);
		
		wad_insert_query( "logs",
			array( "from_type", "from_id", "action", "source", "source_id", "time", "data"),
			array( "system", $employee_id, "changed due date", "order", $order_id, time(), $date_due_timestamp)
		);
		
		wad_insert_query( "logs",
			array( "from_type", "from_id", "action", "source", "source_id", "time"),
			array( "system", $employee_id, "added note", "order", $order_id, time())
		);
	}
	
	if( wad_get_option('send_emails') == 'yes' )
	{
		$subject = "Claimed: Order {$order_id}";
		$order_link = "https://app.wordagents.com/orders/".$order_id;
		
		$msg = "Hi {{writer_firstname}},<br>You've successfully claimed order <a href='{$order_link}'>{{order_title}} - {{order_number}}</a>. This order is due by {{writer_due_date_time}}.<p>If you need help, contact <a href='mailto:talent@wordagents.com'>talent@wordagents.com</a>.</p>";
		
		$writer_firstname = wad_get_name_part('first',$employee_name);
		$writer_due_by = wad_date($date_due_timestamp, 'h:m A F j, Y') . ' EST';

		$msg = str_replace(
			array("{{writer_firstname}}", "{{order_title}}", "{{order_number}}", "{{writer_due_date_time}}"),
			array($writer_firstname, $order_title, $order_id, $writer_due_by),
			$msg
		);
		
		// NEW EMAIL SMTP
		$data['subject'] = $subject;
		$data['message'] = $msg;
		$data['to'] = $employee_email;
		// $data['debug'] = 1;
		
		$send_email_response = wad_send_email($data);
		// if( mail($employee_email, $subject, $msg, $headers)){
		if( $send_email_response == 'sent'){
			wad_create_update_email_counter();
			$from = "WordAgents Dashboard";
			$to = "Writer claimed";
			wad_save_email_log($from, $to, $subject, $msg, $order_id);
		}
	} 
	
	if(  $ajax ){
		if( $response->status == 'Working' ){
			$result = array('result'=>'claimed','msg'=>'');
			echo json_encode($result);
			die();
		}
	}else{	
		header("Location: ".BASE_URL."/orders/working");
	}
}
// END - writer claim order

// writer claim order - START
function wad_editor_claim_order()
{
	$order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : '';
	$employee_id = isset($_REQUEST['employee_id']) ? $_REQUEST['employee_id'] : '';
	$ajax = isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : '';
	$status = 12; // Editing
	$current_timestamp = time();
	$order = wad_get_order($order_id);
	$order_title = $order['order_title'];
	$employee = wad_get_user_by_id($employee_id);
	$employee_name = $employee['name'];
	$employee_email = $employee['email'];
	$assigned_writers = wad_get_assigned_writers($order_id);

	if( !$order_id )
		die();
	
	
	// Check claimed already
	if( count(wad_get_assigned_editors($order_id)) ){
		$msg = 'This article has been claimed by another editor. Please reload the page to see the latest orders.';
		$result = array('result'=>'already_claimed','msg'=>$msg);
		if( $ajax ){
			echo json_encode($result);
		}else{
			$msg = 'This article has been claimed by another editor. Please <a href="'.BASE_URL.'/orders'.'">click here</a> to see the latest orders.';
			echo $msg;			
		}
		die();
	}
	
	// if order status has been changed through SPP
	$order_status = $order['status'];
	if( $order_status != 17 ){
		$msg = 'This article has been handled by SPP. Please reload the page to see the latest orders.';
		$result = array('result'=>'status_changed_through_SPP','msg'=>$msg);
		if( $ajax ){
			echo json_encode($result);
		}else{
			$msg = 'This article has been handled by SPP. Please <a href="'.BASE_URL.'/orders'.'">click here</a> to see the latest orders.';
			echo $msg;
		}
		die();
	}
	
	if( $_SESSION['new_orders_count'] ){
		$_SESSION['new_orders_count'] = $_SESSION['new_orders_count'] - 1;
	}	
	
	$post = array(
		"status"  => $status,
	);
	
	$order_info = wad_get_spp_order_info($order_id);

	$i=0;
	foreach($order_info['employees'] as $employee){
		$post["employees[$i]"] = $employee['id'];
		$i++;
	}
	$post["employees[$i]"] = $employee_id;
	
	$response = wad_spp_update_order($order_id,$post,true);
	
	wad_assign_employee_to_order($order_id, $employee_id);
	
	$editor_claim_time_end = wad_get_due_timestamp();
	
	wad_update_query("orders", "status='{$status}', editor_claim_time='".time()."', editor_claim_time_end='".$editor_claim_time_end."'", "order_id='{$order_id}'");
	
	//NEW - Decrementing all editors' orders total count
	//NEW - Incrementing editing and all orders total count for the editor who claimed
	$args = array(
		'roles' => array('Editor'),
		'subtract_to_Editor_fields' => array('new_orders_count'),
		'add' => array('editing_orders_count', 'all_orders_count'),
		'add_user_spp_id' => $employee_id,
		'add_words' => $order['order_words'],
		'add_words_user_spp_id' => $employee_id,
	);
	wad_set_users_order_total_count($args);
	
	//NEW END
	
	// Set assigned orders for user
	wad_save_assigned_orders_to_user($employee_id, $order_id);
	
	if( wad_get_option('save_log') == 'yes' )
	{
		wad_insert_query( "logs",
			array( "from_type", "from_id", "action", "source", "source_id", "time", "to_type", "to_id" ),
			array( "user", $employee_id, "assigned", "order", $order_id, time(), "user", $employee_id )
		);

		wad_insert_query( "logs",
			array( "from_type", "action", "source", "source_id", "time", "data"),
			array( "System", "changed order status", "order", $order_id, time(), $status)
		);
	}
	
	if( wad_get_option('send_emails') == 'yes' )
	{
		$subject = "Claimed: Order {$order_id}";
		
		$editor_firstname = wad_get_name_part('first',$employee_name);
		$editor_due_by = wad_date($editor_claim_time_end, 'h:m A F j, Y') . ' EST';
		$order_link = "https://app.wordagents.com/orders/".$order_id;

		$msg = "Hi {{editor_firstname}},<br />You've successfully claimed order <a href='{$order_link}'>{{order_title}} - {{order_number}}</a>.<p>This order is due by {{editor_due_date_time}}.</p><p>If you need help, contact Chris on Slack or at <a href='mailto:chris@wordagents.com'>chris@wordagents.com</a>.</p>";
		
		$msg = str_replace(
			array("{{editor_firstname}}", "{{order_title}}", "{{order_number}}", "{{editor_due_date_time}}"),
			array($editor_firstname, $order_title, $order_id, $editor_due_by),
			$msg
		);


		// NEW EMAIL SMTP
		$data['subject'] = $subject;
		$data['message'] = $msg;
		$data['to'] = $employee_email;
		// $data['debug'] = 1;
		
		$send_email_response = wad_send_email($data);
		// if( mail($employee_email, $subject, $msg, $headers) ){
		if( $send_email_response == 'sent'){
			wad_create_update_email_counter();
			$from = "WordAgents Dashboard";
			$to = "Editor claimed";
			wad_save_email_log($from, $to, $subject, $msg, $order_id);
		} 
		
		foreach($assigned_writers as $writer){

			$subject = "Ready to edit: Order {$order_id}";
			
			$writer_firstname = wad_get_name_part('first',$writer['name']);
			$link_to_OG_new_orders = BASE_URL.'/orders';
			$order_link = "https://app.wordagents.com/orders/".$order_id;
			
			$msg = "Hi {{writer_firstname}},<br />Your order <a href='{$order_link}'>{{order_title}} - {{order_number}}</a> has moved to Editing. You'll receive a follow up email if your editor has any notes for revision.<p>To claim new orders, go to the <a href='{{link_to_OG_new_orders}}'>self-service dashboard</a>.</p><p>If you need help, contact <a href='mailto:talent@wordagents.com'>talent@wordagents.com</a>.</p>";
				
			$msg = str_replace(
				array("{{writer_firstname}}", "{{order_title}}", "{{order_number}}", "{{link_to_OG_new_orders}}"),
				array($writer_firstname, $order_title, $order_id, $link_to_OG_new_orders),
				$msg
			);
			
			// NEW EMAIL SMTP
			$data['subject'] = $subject;
			$data['message'] = $msg;
			$data['to'] = $writer['email'];
			// $data['debug'] = 1;
			
			$send_email_response = wad_send_email($data);
			// if( mail($employee_email, $subject, $msg, $headers) ){
			if( $send_email_response == 'sent'){
				wad_create_update_email_counter();
				$from = "WordAgents Dashboard";
				$to = "Assigned Writer";
				wad_save_email_log($from, $to, $subject, $msg, $order_id);
			}
		}
	}
	
	if(  $ajax ){
		if( $response->status == 'Editing' ){
			$result = array('result'=>'claimed','msg'=>'');
			echo json_encode($result);
			die();
		}
	}else{	
		header("Location: ".BASE_URL."/orders/editing");
	}
	die();
}

function order_details_modal_content_ajax($order_id, $current_page_url)
{
	$order = wad_get_order($order_id);
	$order_info = wad_get_spp_order_info($order_id);
	
	$spp_order_status = isset($order_info['status']) ? $order_info['status'] : '';
	$spp_order_message = isset($order_info['message']) ? $order_info['message'] : 'Custom Error Message: Happened something wrong with the system.';
	
	if( $spp_order_status=='error' ){
		return $spp_order_message;
	}
	
	$order_id = $order['order_id'];
	$order_title = $order['order_title'];
	$order_status = $order['status'];
	$order_doc_link = $order['doc_link'];
	
	$order_words = isset($order_info['options']['How many words?']) ? (int) (str_replace(array(',','Words'),'',$order_info['options']['How many words?'])) : '0';

	if( $order_status == 2 ){
		$due_in_timestamp = $order['due_in_end'];
	}else{
		$due_in_timestamp = $order['assigned_end'];
	}

	$order_due_in = wad_get_due_in( $due_in_timestamp); 
			
	$order_client_name = isset($order_info['client']['name_f']) ? $order_info['client']['name_f'] : '';
	$order_client_name .= isset( $order_info['client']['name_l'] ) ? ' ' . $order_info['client']['name_l'] : '';

	$order_client_feedback = isset($order_info['client']['custom_fields'][2]) ? $order_info['client']['custom_fields'][2] : '';
	
	$order_form_data = isset($order_info['form_data']) ? $order_info['form_data'] : '';
	
	$order_pay_rate = wad_get_pay_rate($order);
	$order_earning = wad_get_order_earning($order);
	
	$order_date_due = '';
	if(isset($order_info['date_due']) ){
		$order_date_due = date('F d, Y', strtotime($order_info['date_due']));
	}
	
	$order_request_for_edit_content = '';
	$result = wad_select_query("order_revisions","content","order_id='{$order_id}'");
	if( mysqli_num_rows($result) ){
		$order_request_for_edit_content = mysqli_fetch_assoc($result);
	}
	
	//$order_tags = isset($order_info['tags']) ? $order_info['tags'] : array();
	$order_tags = ($order['tags']) ? explode('||',$order['tags']) : array();
	
	$order['order_id'] = $order_id;		
	$order['words_length'] = $order_words;		
	$order['title'] = $order_title;
	$order['earning'] = '$'.$order_earning;
	$order['status'] = $order_status;
	$order['client_name'] = $order_client_name;
	$order['client_feedback'] = $order_client_feedback;
	
	if( $current_page_url == 'orders/complete' ){
		$order['pay_rate'] = '$'.($order_pay_rate);
	}else{
		$order['pay_rate'] = '$'.$order_earning;
	}
	$order['due_in'] = $order_due_in;
	$order['doc_link'] = $order_doc_link;
	$order['date_due'] = $order_date_due;
	$order['form_data'] = $order_form_data;
	$order['request_for_edit_content'] = $order_request_for_edit_content;
	$order['tags'] = $order_tags;
	$order['current_page_url'] = $current_page_url;
	
	return wad_order_details($order);
}

function wad_get_order_tool_info($order_form_data){
	
	if(empty($order_form_data) && !is_array($order_form_data))
		return;
	
	$tool_info = array();
	
	foreach($order_form_data as $key => $value){
		
		if($key=='Which tool would you like us to use to optimize your article?'){
			$tool_info['name'] = $value;
		}
		if($key=='Optimization Tool Link'){
			$tool_info['link'] = $value;
		}
	}
	
	return $tool_info;
	
}

function order_complete_modal_content_ajax($order_id, $current_page_url)
{
	global $globals;
	$order = wad_get_order($order_id);
	$order_info = wad_get_spp_order_info($order_id);
	
	$spp_order_status = isset($order_info['status']) ? $order_info['status'] : '';
	$spp_order_message = isset($order_info['message']) ? $order_info['message'] : 'Custom Error Message: Happened something wrong with the system.';
	
	if( $spp_order_status=='error' ){
		return $spp_order_message;
	}
	
	$order_id = $order['order_id'];
	$order_title = $order['order_title'];
	$order_doc_link = $order['doc_link'];

	$assigned_writers_editors = wad_get_assigned_writers_and_editors($order_id);
	$assigned_writers = $assigned_writers_editors['writers'];
	$assigned_editors = $assigned_writers_editors['editors'];

	$assigned_writer = $assigned_writers[0];
	$assigned_writer_name = $assigned_writer['name'];
	$assigned_writer_email = $assigned_writer['email'];
	$assigned_writer_spp_id = $assigned_writer['spp_id'];
	
	$order_client_first_name = isset($order_info['client']['name_f']) ? $order_info['client']['name_f'] : '';
	$order_client_last_name = isset( $order_info['client']['name_l'] ) ? $order_info['client']['name_l'] : '';
	$order_client_email = $order_info['client']['email'];
	
	$order_form_data = isset($order_info['form_data']) ? $order_info['form_data'] : array();
	$tool_info = wad_get_order_tool_info($order_form_data);
	$tool_name = isset($tool_info['name'])	? $tool_info['name'] : '';

	$order_client_info = array();
	if( $order_client_first_name && $order_client_last_name )
	{
		$order_client_info['client_first_name'] = $order_client_first_name;
		$order_client_info['client_last_name'] = $order_client_last_name;
		$order_client_info['client_first_name_starting_alphabet'] = strtoupper($order_client_first_name[0]);
		$order_client_info['client_last_name_starting_alphabet'] = strtoupper($order_client_last_name[0]);
		$order_client_info['client_name_alphabat'] = $order_client_info['client_last_name_starting_alphabet'];
		$order_client_info['client_folder_name'] = $order_client_info['client_last_name'] .', '.$order_client_info['client_first_name'];
	}
	elseif( $order_client_first_name && ! $order_client_last_name)
	{
		$order_client_info['client_first_name'] = $order_client_first_name;
		$order_client_info['client_last_name'] = '(empty)';
		$order_client_info['client_first_name_starting_alphabet'] = strtoupper($order_client_first_name[0]);
		$order_client_info['client_last_name_starting_alphabet'] = '(empty)';
		$order_client_info['client_name_alphabat'] = $order_client_info['client_first_name_starting_alphabet'];	
		$order_client_info['client_folder_name'] = $order_client_info['client_first_name'] .', '.$order_client_info['client_last_name'];
	}
	else
	{
		$order_client_info['client_first_name'] = '(empty)';
		$order_client_info['client_last_name'] = '(empty)';
		$order_client_info['client_first_name_starting_alphabet'] = '(empty)';
		$order_client_info['client_last_name_starting_alphabet'] = '(empty)';
		$order_client_info['client_name_alphabat'] = strtoupper($order_client_email[0]);
		$order_client_info['client_folder_name'] = $order_client_email;
	}
	
	ob_start();
	?>
	<p>Please confirm that you have completed the article.</p>
	
	<input type="hidden" name="order" value="<?php echo $order_id; ?>" />
	<input type="hidden" name="title" value="<?php echo $order_title; ?>" />
	<input type="hidden" name="action" value="editor_submit_editing_order" />
	<input type="hidden" name="employee" value="<?php echo wad_get_current_user('spp_id');?>" />
	<input type="hidden" name="doc_link" value="<?php echo $order_doc_link;?>" />

	<?php $i=0; foreach($assigned_writers as $writer): $writer_spp_id = $writer['spp_id'];  ?>
		<?php foreach($writer as $key => $value): ?>
			<input type="hidden" name="assigned_writers[<?php echo $i; ?>][<?php echo $key; ?>]" value="<?php echo $value; ?>" />
		<?php endforeach; $i++;?>
	<?php endforeach; ?>
	
	<?php $i=0; foreach($assigned_editors as $editor): $editor_spp_id = $editor['spp_id']; ?>
		<?php foreach($editor as $key => $value): ?>
			<input type="hidden" name="assigned_editors[<?php echo $i; ?>][<?php echo $key; ?>]" value="<?php echo $value; ?>" />
		<?php endforeach; $i++; ?>
	<?php endforeach; ?>
	
	<?php foreach($order_client_info as $key => $value): ?>
		<input type="hidden" name="order_client_info[<?php echo $key; ?>]" value="<?php echo $value; ?>" />
	<?php endforeach; ?>
	<input type="hidden" name="order_client_info[order_client_email]" value="<?php echo $order_client_email; ?>" />
	
	<input type="hidden" name="tool_name" value="<?php echo $tool_name; ?>" />

	<?php
	
	foreach($assigned_editors as $editor)
	{
		$editor_email = $editor['email'];
		if( $editor_email == 'erynn@wordagents.com' || $editor_email == 'vinci@wordagents.com' )
			continue;

		$editor_firstname = wad_get_name_part('first',$editor['name']);
		$order_client_first_name = ($order_client_info['client_first_name'] == '(empty)') ? 'client' : $order_client_info['client_first_name'];
	}
	
	$p1 = "Hi {{order_client_first_name}},";
	
	$p2 = "<p>This article is all set for your review! You can find the completed document here: <a class='disabled' href='{{doc_link}}'>{{doc_link}}</a></p>";

	$p3 = "<p>Your article, optimized with {{optimization_tool}}, is all set for your review! You can find the completed document here: <a href='{{doc_link}}'>{{doc_link}}</a></p>";
	
	$p4 = "<p>If anything was missed, please use the Google Docs comment feature to add feedback directly in the document. Then, on the relevant order page in your Client Portal, click the gray Request Revision button to notify our team.</p>";
	$p4 .= "Thank you,<br>{{editor_firstname}}";
	
	$template1 = $p1.$p2.$p4;
	$template2 = $p1.$p3.$p4;
	
	$template1 = str_replace(
		array("{{editor_firstname}}", "{{order_client_first_name}}", "{{doc_link}}","{{optimization_tool}}"),
		array($editor_firstname, $order_client_first_name, $order_doc_link, $tool_name),
		$template1
	);
	
	$template2 = str_replace(
		array("{{editor_firstname}}", "{{order_client_first_name}}", "{{doc_link}}","{{optimization_tool}}"),
		array($editor_firstname, $order_client_first_name, $order_doc_link, $tool_name),
		$template2
	);
	
	$template_names = $globals['order_complete_client_email_templates'];
	
	?>
	
	<div class="form-group mb-0">
	   <label>Choose Template:</label>
	   <div class="row">
		<div class="col-xl-12">
		 <label class="option">
		  <span class="option-control">
		   <span class="radio">
			<input type="radio" name="order_complete_client_email_template" value="1" checked="checked"/>
			<span></span>
		   </span>
		  </span>
		  <span class="option-label">
		   <span class="option-head">
			<span class="option-title">
			 <?php echo $template_names[0]; ?>
			</span>
		   </span>
		   <span class="option-body" style="color:inherit">
			<?php echo $template1; ?>
		   </span>
		  </span>
		 </label>
		</div>
		<div class="col-xl-12">
		 <label class="option">
		  <span class="option-control">
		   <span class="radio">
			<input type="radio" name="order_complete_client_email_template" value="2"/>
			<span></span>
		   </span>
		  </span>
		  <span class="option-label">
		   <span class="option-head">
			<span class="option-title">
			 <?php echo $template_names[1]; ?>
			</span>
		   </span>
		   <span class="option-body" style="color:inherit">
			<?php echo $template2; ?>
		   </span>
		  </span>
		 </label>
		</div>
	   </div>
	</div>
	<?php

	return ob_get_clean();
	
	die();
}

function wad_get_orders($columns = "*", $where=""){
	$all_orders_result = wad_select_query(
		"orders",
		$columns,
		$where,
		"ORDER BY id DESC"
	);
	$all_orders = mysqli_fetch_all($all_orders_result, MYSQLI_ASSOC);

	return $all_orders;
	
}

function wad_get_orders_ids($columns = "order_id"){
	
	$records = wad_get_orders('order_id');
	$all_orders = array();
	foreach($records as $rec){
		$all_orders[] = $rec['order_id'];
	}
	
	return $all_orders;
	
}

function wad_get_new_orders_due_timestamp($order_words)
{
	$current_timestamp = time();
	$date_due_timestamp = strtotime('+48 hours', $current_timestamp);
	if( $order_words >= 5000 ){
		$date_due_timestamp = strtotime('+72 hours', $current_timestamp);
	}
	
	return $date_due_timestamp;
}

function wad_get_due_timestamp($t = '+24 hours')
{
	return strtotime($t, time());
}

function wad_get_total_count($query_from,$query_where = null, $query_echo = null){
	$query_select = "count(*) AS total";
	
	if( $query_echo )
		return wad_select_query( $query_from, $query_select, $query_where, true);
	
	$total_result = wad_select_query( $query_from, $query_select, $query_where);
	
	$total_records = mysqli_fetch_all($total_result, MYSQLI_ASSOC);
	
	return isset($total_records[0]) ? $total_records[0]['total'] : 0;
}

function wad_set_users_order_total_count($data = array())
{	
	$roles = ( isset($data['roles']) && ! empty($data['roles']) ) ? $data['roles'] : array();
	$add_to_Writer_fields = ( isset($data['add_to_Writer_fields']) && ! empty($data['add_to_Writer_fields']) ) ? $data['add_to_Writer_fields'] : array();
	$subtract_to_Writer_fields = ( isset($data['subtract_to_Writer_fields']) && ! empty($data['subtract_to_Writer_fields']) ) ? $data['subtract_to_Writer_fields'] : array();
	$add_to_Editor_fields = ( isset($data['add_to_Editor_fields']) && ! empty($data['add_to_Editor_fields']) ) ? $data['add_to_Editor_fields'] : array();
	$subtract_to_Editor_fields = ( isset($data['subtract_to_Editor_fields']) && ! empty($data['subtract_to_Editor_fields']) ) ? $data['subtract_to_Editor_fields'] : array();
	
	$add_counter = $subtract_counter = $add_words_counter = $subtract_words_counter = 0;
	
	$add_fields_0 = isset($data['add']) ? $data['add'] : array();
	$add_user_spp_id_0 = isset($data['add_user_spp_id']) ? $data['add_user_spp_id'] : null;
	
	$add_fields_1 = isset($data['add_2']) ? $data['add_2'] : array();
	$add_user_spp_id_1 = isset($data['add_user_spp_id_2']) ? $data['add_user_spp_id_2'] : null;	

	$subtract_fields_0 = isset($data['subtract']) ? $data['subtract'] : array();
	$subtract_user_spp_id_0 = isset($data['subtract_user_spp_id']) ? $data['subtract_user_spp_id'] : null;

	$subtract_fields_1 = isset($data['subtract_2']) ? $data['subtract_2'] : array();
	$subtract_user_spp_id_1 = isset($data['subtract_user_spp_id_2']) ? $data['subtract_user_spp_id_2'] : null;

	if( $add_fields_0 && $add_user_spp_id_0 )
		$add_counter++;

	if( $add_fields_1 && $add_user_spp_id_1 )
		$add_counter++;

	if( $subtract_fields_0 && $subtract_user_spp_id_0 )
		$subtract_counter++;

	if( $subtract_fields_1 && $subtract_user_spp_id_1 )
		$subtract_counter++;

	$rejected_user_spp_id = isset($data['rejected_user_spp_id']) ? $data['rejected_user_spp_id'] : '';
	$order_id = isset($data['order_id']) ? $data['order_id'] : null;
	$order_words = isset($data['order_words']) ? $data['order_words'] : null;

	$add_words_0 = isset($data['add_words']) ? $data['add_words'] : null;
	$add_words_user_spp_id_0 = isset($data['add_words_user_spp_id']) ? $data['add_words_user_spp_id'] : null;
	$add_words_counter++;
	
	$subtract_words_0 = isset($data['subtract_words']) ? $data['subtract_words'] : null;
	$subtract_words_user_spp_id_0 = isset($data['subtract_words_user_spp_id']) ? $data['subtract_words_user_spp_id'] : null;
	$subtract_words_counter++; 
	
	$status = isset($data['status']) ? $data['status'] : null;	
	$status_old = isset($data['status_old']) ? $data['status_old'] : null;
	
	if( $status && $status_old )
	{
		$has_tag_Editor_Revision = isset($data['has_tag_Editor_Revision']) ? $data['has_tag_Editor_Revision'] : false;
		$has_tag_Ready_to_Edit = isset($data['has_tag_Ready_to_Edit']) ? $data['has_tag_Ready_to_Edit'] : false;
		$assigned_writers_ids_old = isset($data['assigned_writers_ids_old']) ? $data['assigned_writers_ids_old'] : array();
		$assigned_editors_ids_old = isset($data['assigned_editors_ids_old']) ? $data['assigned_editors_ids_old'] : array();
		$assigned_employees_ids = isset($data['assigned_employees_ids']) ? $data['assigned_employees_ids'] : array();
		$assigned_writers_ids = isset($data['assigned_writers_ids']) ? $data['assigned_writers_ids'] : array();
		$assigned_editors_ids = isset($data['assigned_editors_ids']) ? $data['assigned_editors_ids'] : array();
		$assigned_editors_ids_auto = isset($data['assigned_editors_ids_auto']) ? $data['assigned_editors_ids_auto'] : array();
		$unassigned_editors_ids_auto = isset($data['unassigned_editors_ids_auto']) ? $data['unassigned_editors_ids_auto'] : array();
		
		$submitted_To_Working = $submitted_To_ReadyToEdit = $submitted_To_Editing = $submitted_To_EditorRevision = $submitted_To_Complete = $submitted_To_Revision = $working_To_Submitted = $working_To_Editing = $working_To_Complete = $working_To_Revision = $readyToEdit_To_Submitted = $readyToEdit_To_Editing = $readyToEdit_To_Complete = $readyToEdit_To_Revision = $editing_To_Submitted = $editing_To_Working = $editing_To_ReadyToEdit = $editing_To_EditorRevision = $editing_To_Complete = $editing_To_Revision = $editorRevision_To_Submitted = $editorRevision_To_Editing = $editorRevision_To_Complete = $editorRevision_To_Revision = $complete_To_Submitted = $complete_To_Working = $complete_To_ReadyToEdit = $complete_To_Editing = $complete_To_EditorRevision = $complete_To_Revision = $revision_To_Submitted = $revision_To_Working = $revision_To_ReadyToEdit = $revision_To_Editing = $revision_To_EditorRevision = $revision_To_Complete = $instructionReview_To_Submitted = $instructionReview_To_Working = $instructionReview_To_ReadyToEdit = $instructionReview_To_Editing = $instructionReview_To_EditorRevision = $instructionReview_To_Complete = $instructionReview_To_Revision = false;
		
		if( $status == 2 ) //Submitted
		{
			if( $status_old == 5 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ // working_To_Submitted
				$working_To_Submitted = true;
			}else if( $status_old == 17 ){ // readyToEdit_To_Submitted
				$readyToEdit_To_Submitted = true;
			}else if( $status_old == 12 ){ // editing_To_Submitted
				$editing_To_Submitted = true;
			}else if( $status_old == 6 ){ // editorRevision_To_Submitted
				$editorRevision_To_Submitted = true;
			}else if( $status_old == 3 ){ // complete_To_Submitted
				$complete_To_Submitted = true;
			}else if( $status_old == 9 ){ // revision_To_Submitted
				$revision_To_Submitted = true;
			}else if( $status_old == 14 ){ // instructionReview_To_Submitted
				$instructionReview_To_Submitted = true;
			}
		}
		else if( $status == 5 ) // Working
		{
			if( $status_old == 2 && !$has_tag_Ready_to_Edit && !$has_tag_Editor_Revision){ // submitted_To_Working
				$submitted_To_Working = true;
			}else if( $status_old == 12 && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ // editing_To_Working
				$editing_To_Working = true;
			}else if( $status_old==2 && $has_tag_Ready_to_Edit && !$has_tag_Editor_Revision ){ //submitted_To_ReadyToEdit
				$submitted_To_ReadyToEdit = true;
			}else if( $status_old == 12 && $has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //editing_To_EditorRevision
				$editing_To_EditorRevision = true;
			}else if( $status_old == 2 && $has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //submitted_To_EditorRevision
				$submitted_To_EditorRevision = true;
			}else if( $status_old == 12 && $has_tag_Ready_to_Edit && !$has_tag_Editor_Revision ){ //editing_To_ReadyToEdit
				$editing_To_ReadyToEdit = true;
			}else if( $status_old == 3 && !$has_tag_Ready_to_Edit && !$has_tag_Editor_Revision ){ //complete_To_Working
				$complete_To_Working = true;
			}else if( $status_old == 3 && $has_tag_Ready_to_Edit && !$has_tag_Editor_Revision ){ //complete_To_ReadyToEdit
				$complete_To_ReadyToEdit = true;
			}else if( $status_old == 3 && !$has_tag_Ready_to_Edit && $has_tag_Editor_Revision ){ //complete_To_EditorRevision
				$complete_To_EditorRevision = true;
			}else if( $status_old == 9 && !$has_tag_Ready_to_Edit && !$has_tag_Editor_Revision ){ //revision_To_Working
				$revision_To_Working = true;
			}else if( $status_old == 9 && $has_tag_Ready_to_Edit && !$has_tag_Editor_Revision ){ //revision_To_ReadyToEdit
				$revision_To_ReadyToEdit = true;
			}else if( $status_old == 9 && !$has_tag_Ready_to_Edit && $has_tag_Editor_Revision ){ //revision_To_EditorRevision
				$revision_To_EditorRevision = true;
			}else if( $status_old == 14 && !$has_tag_Ready_to_Edit && !$has_tag_Editor_Revision ){ //instructionReview_To_Working
				$instructionReview_To_Working = true;
			}else if( $status_old == 14 && $has_tag_Ready_to_Edit && !$has_tag_Editor_Revision ){ //instructionReview_To_ReadyToEdit
				$instructionReview_To_ReadyToEdit = true;
			}else if( $status_old == 14 && !$has_tag_Ready_to_Edit && $has_tag_Editor_Revision ){ //instructionReview_To_EditorRevision
				$instructionReview_To_EditorRevision = true;
			}
		}
		else if( $status == 12 ) // Editing
		{
			if( $status_old == 5  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ // working_To_Editing
				$working_To_Editing = true;
			}else if( $status_old == 17 && !$has_tag_Ready_to_Edit ){ // readyToEdit_To_Editing
				$readyToEdit_To_Editing = true;
			}else if( $status_old == 2 ){ //submitted_To_Editing
				$submitted_To_Editing = true;
			}else if( $status_old == 6 && !$has_tag_Editor_Revision ){ //editorRevision_To_Editing
				$editorRevision_To_Editing = true;
			}else if( $status_old == 3 ){ //complete_To_Editing
				$complete_To_Editing = true;
			}else if( $status_old == 9 ){ //revision_To_Editing
				$revision_To_Editing = true;
			}else if( $status_old == 14 ){ //instructionReview_To_Editing
				$instructionReview_To_Editing = true;
			}
		}
		else if( $status == 3 ) // Complete
		{
			if( $status_old == 2  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //submitted_To_Complete
				$submitted_To_Complete = true;
			}else if( $status_old == 5  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //working_To_Complete
				$working_To_Complete = true;
			}else if( $status_old == 17  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //readyToEdit_To_Complete
				$readyToEdit_To_Complete = true;
			}else if( $status_old == 12  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //editing_To_Complete
				$editing_To_Complete = true;
			}else if( $status_old == 6  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //editorRevision_To_Complete
				$editorRevision_To_Complete = true;
			}else if( $status_old == 9  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //revision_To_Complete
				$revision_To_Complete = true;
			}else if( $status_old == 14  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //instructionReview_To_Complete
				$instructionReview_To_Complete = true;
			}
		}
		else if( $status == 9 ) // Revision
		{
			if( $status_old == 2  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //submitted_To_Revision
				$submitted_To_Revision = true;
			}else if( $status_old == 5  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //working_To_Revision
				$working_To_Revision = true;
			}else if( $status_old == 17  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //readyToEdit_To_Revision
				$readyToEdit_To_Revision = true;
			}else if( $status_old == 12  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //editing_To_Revision
				$editing_To_Revision = true;
			}else if( $status_old == 6  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //editorRevision_To_Revision
				$editorRevision_To_Revision = true;
			}else if( $status_old == 3  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //complete_To_Revision
				$complete_To_Revision = true;
			}else if( $status_old == 14  && !$has_tag_Editor_Revision && !$has_tag_Ready_to_Edit ){ //instructionReview_To_Revision
				$instructionReview_To_Revision = true;
			}
		}
		
		if( $working_To_Submitted ){
			$roles = array('Writer');
			$add_to_Writer_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids_old) ){
				foreach($assigned_writers_ids_old as $writer_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'working_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $writer_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $working_To_Editing ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"subtract_fields_".$subtract_counter} = array('working_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
					${"add_fields_".$add_counter} = array('editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('editing_orders_count', 'all_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $submitted_To_Working ){
			$roles = array('Writer');
			$subtract_to_Writer_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('working_orders_count', 'all_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
		}
		else if( $readyToEdit_To_Submitted ){
			$roles = array("Writer", "Editor");
			$add_to_Writer_fields = array('new_orders_count');
			$subtract_to_Editor_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids_old) ){
				foreach($assigned_writers_ids_old as $writer_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $writer_id;
					$subtract_words_counter++;

				}
			}
		}
		else if ( $readyToEdit_To_Editing ){
			$roles = array("Editor");
			$subtract_to_Editor_fields = array('new_orders_count');
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('editing_orders_count', 'all_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if ( $editing_To_Submitted ){
			$roles = array('Writer');
			$add_to_Writer_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids_old) ){
				foreach($assigned_writers_ids_old as $writer_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $writer_id;
					$subtract_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids_old) ){
				foreach($assigned_editors_ids_old as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if($editing_To_Working){
			sort($assigned_writers_ids);
			sort($assigned_writers_ids_old);
			if( $assigned_writers_ids == $assigned_writers_ids_old ){
				if( !empty($assigned_writers_ids) ){
					foreach($assigned_writers_ids as $writer_id){
						${"add_fields_".$add_counter} = array('working_orders_count');
						${"add_user_spp_id_" . $add_counter} = $writer_id;
						$add_counter++;
					}
				}
				if( !empty($assigned_writers_ids_old) ){
					foreach($assigned_writers_ids_old as $writer_id){
						${"subtract_fields_".$subtract_counter} = array('editing_orders_count');
						${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
						$subtract_counter++;
					}
				}
			}else{
				if( !empty($assigned_writers_ids) ){
					foreach($assigned_writers_ids as $writer_id){
						${"add_fields_".$add_counter} = array('all_orders_count', 'working_orders_count');
						${"add_user_spp_id_" . $add_counter} = $writer_id;
						$add_counter++;
					}
				}
				if( !empty($assigned_writers_ids_old) ){
					foreach($assigned_writers_ids_old as $writer_id){
						${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'editing_orders_count');
						${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
						$subtract_counter++;
					}
				}
			}
			if( !empty($assigned_editors_ids_old) ){
				foreach($assigned_editors_ids_old as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $submitted_To_ReadyToEdit ){
			$roles = array("Writer", "Editor");
			$add_to_Editor_fields = array('new_orders_count');
			$subtract_to_Writer_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
		}
		else if( $editing_To_ReadyToEdit ){
			$roles = array("Editor");
			$add_to_Editor_fields = array('new_orders_count');
			if( !empty($assigned_editors_ids_old) ){
				foreach($assigned_editors_ids_old as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $submitted_To_EditorRevision ){
			$roles = array("Writer");
			$subtract_to_Writer_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('all_orders_count','revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count','revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $submitted_To_Editing ){
			$roles = array("Writer");
			$subtract_to_Writer_fields = array('new_orders_count');
			
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $editorRevision_To_Submitted ){
			$roles = array("Writer");
			$add_to_Writer_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids_old) ){
				foreach($assigned_writers_ids_old as $writer_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $writer_id;
					$subtract_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids_old) ){
				foreach($assigned_editors_ids_old as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $editing_To_EditorRevision ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
				}
			}
		}
		else if( $editorRevision_To_Editing ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
				}
			}
		}
		else if( $editorRevision_To_Complete || $revision_To_Complete ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
				}
			}
			if( !empty($unassigned_editors_ids_auto) ){
				foreach($unassigned_editors_ids_auto as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $editorRevision_To_Revision ){
			if( !empty($assigned_editors_ids_auto) ){
				foreach($assigned_editors_ids_auto as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $revision_To_EditorRevision ){
			if( !empty($unassigned_editors_ids_auto) ){
				foreach($unassigned_editors_ids_auto as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $complete_To_EditorRevision || $complete_To_Revision ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('complete_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('complete_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids_auto) ){
				foreach($assigned_editors_ids_auto as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $submitted_To_Complete ){
			$roles = array("Writer");
			$subtract_to_Writer_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $submitted_To_Revision ){
			$roles = array("Writer");
			$subtract_to_Writer_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids_auto) ){
				foreach($assigned_editors_ids_auto as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $working_To_Complete ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('working_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $working_To_Revision ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('working_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids_auto) ){
				foreach($assigned_editors_ids_auto as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $complete_To_Working ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('working_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('complete_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids_old) ){
				foreach($assigned_editors_ids_old as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'complete_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $revision_To_Working ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('working_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids_old) ){
				foreach($assigned_editors_ids_old as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $complete_To_Submitted ){
			$roles = array("Writer");
			$add_to_Writer_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids_old) ){
				foreach($assigned_writers_ids_old as $writer_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'complete_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $writer_id;
					$subtract_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids_old) ){
				foreach($assigned_editors_ids_old as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'complete_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $revision_To_Submitted ){
			$roles = array("Writer");
			$add_to_Writer_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids_old) ){
				foreach($assigned_writers_ids_old as $writer_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $writer_id;
					$subtract_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids_old) ){
				foreach($assigned_editors_ids_old as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $readyToEdit_To_Complete ){
			$roles = array("Editor");
			$subtract_to_Editor_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count','complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $readyToEdit_To_Revision ){
			$roles = array("Editor");
			$subtract_to_Editor_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count','revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids_auto) ){
				foreach($assigned_editors_ids_auto as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count','revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $revision_To_ReadyToEdit ){
			$roles = array("Editor");
			$add_to_Editor_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids_old) ){
				foreach($assigned_editors_ids_old as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count','revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $complete_To_ReadyToEdit ){
			$roles = array("Editor");
			$add_to_Editor_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('complete_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids_old) ){
				foreach($assigned_editors_ids_old as $editor_id){
					${"subtract_fields_".$subtract_counter} = array('all_orders_count','complete_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $editing_To_Complete ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
				}
			}
		}
		else if( $complete_To_Editing ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('complete_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('complete_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
				}
			}
		}
		else if( $editing_To_Revision ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id)
				{	
					${"add_fields_".$add_counter} = array('revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('editing_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids_auto) ){
				foreach($assigned_editors_ids_auto as $editor_id)
				{
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $revision_To_Editing ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $writer_id;
					$subtract_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id)
				{
					${"add_fields_".$add_counter} = array('editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"subtract_fields_".$subtract_counter} = array('revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;					
				}
			}
			if( !empty($unassigned_editors_ids_auto) ){
				foreach($unassigned_editors_ids_auto as $editor_id)
				{
					${"subtract_fields_".$subtract_counter} = array('all_orders_count', 'revision_orders_count');
					${"subtract_user_spp_id_" . $subtract_counter} = $editor_id;
					$subtract_counter++;
					${"subtract_words_".$subtract_words_counter} = $order_words;
					${"subtract_words_user_spp_id_" . $subtract_words_counter} = $editor_id;
					$subtract_words_counter++;
				}
			}
		}
		else if( $instructionReview_To_Submitted ){
			$roles = array("Writer");
			$add_to_Writer_fields = array('new_orders_count');
		}
		else if( $instructionReview_To_Working ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'working_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
		}
		else if( $instructionReview_To_ReadyToEdit ){
			$roles = array("Editor");
			$add_to_Editor_fields = array('new_orders_count');
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
		}
		else if( $instructionReview_To_Editing ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id)
				{
					${"add_fields_".$add_counter} = array('all_orders_count', 'editing_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $instructionReview_To_EditorRevision ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id)
				{
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $instructionReview_To_Complete ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'complete_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
		else if( $instructionReview_To_Revision ){
			if( !empty($assigned_writers_ids) ){
				foreach($assigned_writers_ids as $writer_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $writer_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $writer_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids) ){
				foreach($assigned_editors_ids as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
			if( !empty($assigned_editors_ids_auto) ){
				foreach($assigned_editors_ids_auto as $editor_id){
					${"add_fields_".$add_counter} = array('all_orders_count', 'revision_orders_count');
					${"add_user_spp_id_" . $add_counter} = $editor_id;
					$add_counter++;
					${"add_words_".$add_words_counter} = $order_words;
					${"add_words_user_spp_id_" . $add_words_counter} = $editor_id;
					$add_words_counter++;
				}
			}
		}
	}
	
	$update_query_parts = array();
	$update_query_parts_counter = 0;
		
	for($i=0;$i<$add_words_counter;$i++){
		if( ( $add_words_user_spp_id = ${"add_words_user_spp_id_".$i} ) && ( $add_words = ${"add_words_".$i} ) )
		{
			$user = wad_get_user_by_id($add_words_user_spp_id);
			
			$set = wad_get_SET_to_ADD_WORDS($user, $add_words);
			$where = "spp_id='{$add_words_user_spp_id}'";
						
			wad_update_query("users",$set, $where);
		
		}
	}
	
	for($i=0;$i<$subtract_words_counter;$i++){
		if( ($subtract_words_user_spp_id=${"subtract_words_user_spp_id_".$i}) && ($subtract_words=${"subtract_words_".$i}) )
		{
			$user = wad_get_user_by_id($subtract_words_user_spp_id);
			
			$set = wad_get_SET_to_SUBTRACT_WORDS($user, $subtract_words);
			if( $set){
				$where = "spp_id='{$subtract_words_user_spp_id}'";
				
				wad_update_query("users",$set, $where);
			}
		}
	}
	
	for($i=0;$i<$add_counter;$i++){
		if( ${"add_user_spp_id_".$i} && !empty(${"add_fields_".$i}))
		{
			$add_fields = ${"add_fields_".$i};
			$add_user_spp_id = ${"add_user_spp_id_".$i};
			
			$user = wad_get_user_by_id($add_user_spp_id);
			if( !empty($user) ){
				$set = wad_get_SET_to_ADD_for_users_order_counter($user, $add_fields);
				$where = "spp_id='{$add_user_spp_id}'";

				wad_update_query("users",$set, $where);
				
			}
		}
	}
	
	for($i=0;$i<$subtract_counter;$i++){
		if( ${"subtract_user_spp_id_".$i} && !empty(${"subtract_fields_".$i}))
		{
			$subtract_fields = ${"subtract_fields_".$i};
			$subtract_user_spp_id = ${"subtract_user_spp_id_".$i};
			
			$user = wad_get_user_by_id($subtract_user_spp_id);
			if( !empty($user) ){
				$set = wad_get_SET_to_SUBTRACT_for_users_order_counter($user, $subtract_fields);
				$where = "spp_id='{$subtract_user_spp_id}'";
				
				wad_update_query("users",$set, $where);
				
			}
		}
	}
	
	if( ! empty($roles) )
	{
		$role_where = "role='{$roles[0]}'";
		$roles_total = count($roles);
		$is_multi_roles = ( $roles_total > 1 ) ? true : false;
		if( $is_multi_roles ){
			$i=1;
			$role_where = '(';
			foreach($roles as $role){
				$role_where .= "role='{$role}'";
				if( $i!=$roles_total )
					$role_where .= ' OR ';
				$i++;
			}
			$role_where .= ')';
		}
		
		$users = wad_get_users("*",$role_where);
		
		$users_by_role = array();
		if( $is_multi_roles ){
			foreach($roles as $role){
				$role = str_replace(' ','_',$role);
				foreach($users as $user){
					if( $role == $user['role'] ){
						$users_by_role[$role][] = $user;
					}
				}				
			}
		}else{
			$users_by_role[$roles[0]] = $users;
		}
	
		if( count($users_by_role) )
		{
			foreach($users_by_role as $role => $users)
			{
				$add_to_role_fields = isset(${"add_to_".$role."_fields"}) ? ${"add_to_".$role."_fields"} : array();
				$subtract_to_role_fields = isset(${"subtract_to_".$role."_fields"}) ? ${"subtract_to_".$role."_fields"} : array();
				
				$user_spp_ids_array_by_same_set_array = array(); 
					
				foreach($users as $user)
				{
					//Do not update counter for rejected user/writer
					if( ($user['spp_id'] == $rejected_user_spp_id) )
						continue;
					
					$rejected_order_ids = explode(',',$user['rejected_order_ids']);
					$missed_order_ids = explode(',',$user['missed_order_ids']);
					
					$rejected_missed_order_ids = array_merge($rejected_order_ids, $missed_order_ids);
					
					//Do not update counter if user rejected/missed order
					if( $order_id && in_array($order_id, $rejected_missed_order_ids) )
						continue;
										
					if( !empty($add_to_role_fields) )
					$set = wad_get_SET_to_ADD_for_users_order_counter($user, $add_to_role_fields);
					
					if( !empty($subtract_to_role_fields))
					$set = wad_get_SET_to_SUBTRACT_for_users_order_counter($user, $subtract_to_role_fields);
										
					$user_spp_id = $user['spp_id'];
					
					$where = "spp_id='{$user_spp_id}'";

					wad_update_query("users",$set, $where);
				}
			}
		}
	}
}

function wad_get_SET_to_ADD_WORDS($user, $add_words){
	if( empty($add_words) )
		return;
	
	$words_weekly = (int)$user['words_weekly'] + (int) $add_words;
	$set = "words_weekly='{$words_weekly}'";
	
	return $set;
}

function wad_get_SET_to_SUBTRACT_WORDS($user, $subtract_words){
	if( empty($subtract_words) )
		return;
	
	$words_weekly = (int)$user['words_weekly'];
	if( $words_weekly < $subtract_words )
		return;
	
	$words_weekly = $words_weekly - (int) $subtract_words;
	$set = "words_weekly='{$words_weekly}'";
	
	return $set;
}

function wad_get_SET_to_ADD_for_users_order_counter($user, $add_fields){
	if( empty($add_fields) )
		return;
	
	$set = '';
	
	foreach($add_fields as $field){
		$field_old_value = $user[$field];
		$field_new_value = $field_old_value + 1;
		
		if( $set )
			$set .= ', ';
	
		$set .= "{$field}='{$field_new_value}'";
	}
	
	return $set;
}

function wad_get_SET_to_SUBTRACT_for_users_order_counter($user, $subtract_fields){
	if( empty($subtract_fields) )
		return;
	
	$set = '';
	
	foreach($subtract_fields as $field){
		$field_old_value = $user[$field];
		if( $field_old_value ){
			if( $set )
				$set .= ', ';
		
			$field_new_value = $field_old_value - 1;
			$set .= "{$field}='{$field_new_value}'";
		}
	}
	
	return $set;
}

function wad_get_note_for_working_order($atts){
	$order_id = $atts['order_id'];
	$order = ( isset($atts['order']) ) ? $atts['order'] : wad_get_order($order_id);
	$writer_name = $atts['writer_name'];
	$writer_spp_id = $atts['writer_spp_id'];
	$date_due_timestamp = $atts['date_due_timestamp'];
	
	$amount = wad_get_order_earning($order, $writer_spp_id);
	$note = $writer_name . ' - ' . 'EOD '.wad_date($date_due_timestamp, 'l m/d') . ' - $'.$amount;
	return $note;
}

function wad_spp_update_working_order($atts){
	
	$order_id = $atts['order_id'];
	$note = isset($atts['note']) ? $atts['note'] : '';
	$note_log_action = isset($atts['note_log_action']) ? $atts['note_log_action'] : '';
	$date_due_timestamp = isset($atts['date_due_timestamp']) ? $atts['date_due_timestamp'] : '';
	
	wad_spp_update_order($order_id, array("note" => $note));
	if( wad_get_option('save_log') == 'yes')
	{
		if( $note_log_action ){
			wad_insert_query( "logs",
				array( "from_type", "action", "source", "source_id", "time"),
				array( "system", $note_log_action, "order", $order_id, time())
			);
		}
		if( $date_due_timestamp ){
			wad_insert_query( "logs",
				array( "from_type", "action", "source", "source_id", "time", "data"),
				array( "system", "changed due date", "order", $order_id, time(), $date_due_timestamp)
			);
		}
	}
}

function wad_test_order($order_id){
	if( wad_test() ){
	$test_order_ids_array = array('827D1F34','AEFD57C1');
	if( in_array($order_id,$test_order_ids_array) ){
		echo 'data-test-order="1"';
	}
	}
}


function reset_orders_counter()
{	
	$new_orders = wad_get_orders("order_id, status","status='2' OR status='17'");
	$users = wad_get_users("*", "role='Writer' OR role='Editor'");
	$orders_assigned_users = wad_get_orders_assigned_user();
	$assigned_writers_ids = $assigned_editors_ids = $orders_counters_words_weekly_user_wise = $new_orders_for_writers = $new_orders_for_editors = $weekly_orders_by_order_id = array();
	
	$timestamp_of_monday_first_day_of_the_week = wad_get_timestamp_of_monday_first_day_of_the_week();
	$timestamp_of_sunday_last_day_of_the_week = wad_get_timestamp_of_sunday_last_day_of_the_week();
	$weekly_orders = wad_get_orders("order_id, status, assigned","(
		(assigned >= '{$timestamp_of_monday_first_day_of_the_week}' AND assigned <= '{$timestamp_of_sunday_last_day_of_the_week}')
		AND (status='5' OR status='17' OR status='12' OR status='6' OR status='17' OR status='9' OR status='3'))
	");
	foreach($weekly_orders as $order){
		$order_id = $order['order_id'];
		$status = $order['status'];
		$weekly_orders_by_order_id[$order_id]['status'] = $status;
	}
	
	wad_set_orders_counters_to_zero();
	wad_set_rejected_missed_orders();
	
	foreach($new_orders as $order)
	{		
		$order_id = $order['order_id'];
		$status = $order['status'];
		
		if( $status == 2 ){
			$new_orders_for_writers[] = $order_id;
		}
		if( $status == 17 ){
			$new_orders_for_editors[] = $order_id;
		}
	}
	
	foreach($users as $user)
	{
		$spp_id = $user['spp_id'];
		$role = $user['role'];
		$rejected_orders = ($user['rejected_order_ids']) ? explode(',',$user['rejected_order_ids']) : array();
		$missed_orders = ($user['missed_order_ids']) ? explode(',',$user['missed_order_ids']) : array();
		$rejected_missed_orders	= array_merge($rejected_orders, $missed_orders);
		$rejected_missed_orders_count = 0;
		foreach($rejected_missed_orders as $order_id){
			if( in_array($order_id, $new_orders_for_writers) ){
				$rejected_missed_orders_count++;
			}
		}
		
		$new_orders_for_writers_count = count($new_orders_for_writers);
		$new_orders_for_editors_count = count($new_orders_for_editors);
		
		if( $role == 'Writer' ){
			$orders_counters_words_weekly_user_wise[$spp_id]['new_orders_count'] = $new_orders_for_writers_count - $rejected_missed_orders_count;
		}
		elseif( $role == 'Editor' ){
			$orders_counters_words_weekly_user_wise[$spp_id]['new_orders_count'] = $new_orders_for_editors_count;
		}
	}
	
	
	foreach($orders_assigned_users as $a)
	{
		$order_id = $a['order_id'];
		$spp_id = $a['spp_id'];
		
		$order = wad_get_order($order_id);
		$status = $order['status'];
		if( !$status){
			continue;
		}

		$order_words = (int)$order['order_words'];

		if( is_writer($spp_id) )
		{
			$assigned_writers_ids[$spp_id] = $spp_id;
			
			if( $status==5 )//Working
			{
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = 1;
				}
					
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['working_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['working_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['working_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['working_orders_count'] = 1;
				}
					
			}
			if( $status==17 || $status==12 ) //ReadyToEdit OR Editing
			{
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = 1;
				}
					
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['editing_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['editing_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['editing_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['editing_orders_count'] = 1;
				}				
					
			}
			if( $status==6 || $status==9 ) //EditorRevision OR Revision
			{
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = 1;
				}
					
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['revision_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['revision_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['revision_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['revision_orders_count'] = 1;
				}				
					
			}
			if( $status==3 ) //Complete
			{
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = 1;
				}
					
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['complete_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['complete_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['complete_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['complete_orders_count'] = 1;
				}
			}			
		}
		
		if( is_editor($spp_id) )
		{
			$assigned_editors_ids[$spp_id] = $spp_id;
			
			if( $status==12 ) //Editing
			{
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = 1;
				}
					
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['editing_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['editing_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['editing_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['editing_orders_count'] = 1;
				}				
					
			}
			if( $status==6 || $status==9 ) //EditorRevision OR Revision
			{
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = 1;
				}
					
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['revision_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['revision_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['revision_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['revision_orders_count'] = 1;
				}				
					
			}
			if( $status==3 ) //Complete
			{
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['all_orders_count'] = 1;
				}
					
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['complete_orders_count']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['complete_orders_count'] = $orders_counters_words_weekly_user_wise[$spp_id]['complete_orders_count'] + 1;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['complete_orders_count'] = 1;
				}
			}
		}
		
		//Weekly Words
		if( array_key_exists($order_id, $weekly_orders_by_order_id) )
		{
			if( $status==5 || $status==17 || $status==12 || $status==6 || $status==3 || $status==9 )
			{
				if( isset($orders_counters_words_weekly_user_wise[$spp_id]['words_weekly']) ){
					$orders_counters_words_weekly_user_wise[$spp_id]['words_weekly'] = $orders_counters_words_weekly_user_wise[$spp_id]['words_weekly'] + $order_words;
				}else{
					$orders_counters_words_weekly_user_wise[$spp_id]['words_weekly'] = $order_words;
				}
			}					
		}
	}

	foreach($orders_counters_words_weekly_user_wise as $spp_id => $user){

		$counters = array();
		if( isset($user['new_orders_count']) )
			$counters['new_orders_count'] = $user['new_orders_count'];
		if( isset($user['all_orders_count']) )
			$counters['all_orders_count'] = $user['all_orders_count'];
		if( isset($user['working_orders_count']) )
			$counters['working_orders_count'] = $user['working_orders_count'];
		if( isset($user['editing_orders_count']) )
			$counters['editing_orders_count'] = $user['editing_orders_count'];
		if( isset($user['revision_orders_count']) )
			$counters['revision_orders_count'] = $user['revision_orders_count'];
		if( isset($user['complete_orders_count']) )
			$counters['complete_orders_count'] = $user['complete_orders_count'];
		if( isset($user['words_weekly']) )
			$counters['words_weekly'] = $user['words_weekly'];

		if( !empty($counters) ){
			foreach($counters as $field => $value){
				$set = '';
				if( $field && $value)
				$set = "{$field}='{$value}'";
			
				$where = "spp_id='{$spp_id}'";
				
				if( $set && $where )
				wad_update_query("users",$set, $where);
				
			}
		}
	}
}

function wad_set_orders_counters_to_zero(){
	wad_update_query(
		"users","all_orders_count='0',new_orders_count='0',working_orders_count='0',editing_orders_count='0',revision_orders_count='0',complete_orders_count='0',words_weekly='0'", 
		"role='Writer' || role='Editor'"
	);
}

function wad_set_rejected_missed_orders(){
	
	$rejected_missed_orders_by_users = array();
	$rejected_orders = wad_get_rejected_missed_orders();
	
	foreach($rejected_orders as $order)
	{
		$order_id = $order['order_id'];
		$spp_id = $order['spp_id'];
		$missed = $order['missed'];
		
		$rejected_missed_orders_by_users[$spp_id][$order_id]['missed'] = $missed;
		
	}
	
	foreach($rejected_missed_orders_by_users as $spp_id => $orders)
	{
		$rejected_orders_ids_array = $missed_orders_ids_array = array();
		foreach($orders as $order_id => $order){
			$missed = $order['missed'];
			if( $missed ){
				$missed_orders_ids_array[] = $order_id;				
			}else{
				$rejected_orders_ids_array[] = $order_id;
			}
		}
		if( !empty($rejected_orders_ids_array) ){
			$rejected_orders_ids = implode(',',$rejected_orders_ids_array);
			wad_update_query(
				"users",
				"rejected_order_ids='{$rejected_orders_ids}'", 
				"spp_id='{$spp_id}'"
			);
		}
		if( !empty($missed_orders_ids_array) ){
			$missed_orders_ids = implode(',',$missed_orders_ids_array);
			wad_update_query(
				"users",
				"missed_order_ids='{$missed_orders_ids}'", 
				"spp_id='{$spp_id}'"
			);			
		}
	}
}

function wad_get_rejected_missed_orders(){
	$result = wad_select_query("user_rejected_order","*");
	return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/* NEW EMAIL SMTP */
function wad_send_email($data)
{
	if( wad_test() && SITE_MOD == 'Live')
		return;
	
	$mail = new PHPMailer\PHPMailer\PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	
	if( isset($data['debug']) )
	$mail->SMTPDebug = $data['debug']; // debugging: 1 = errors and messages, 2 = messages only
	
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465; // or 587
	$mail->Username   = GMAIL_EMAIL;
	$mail->Password   = GMAIL_PASS;
	
	$mail->IsHTML(true);

	$mail->setFrom(GMAIL_EMAIL, 'WordAgents Dashboard');
	$mail->addAddress($data['to']);     // Add a recipient

	$mail->addReplyTo(GMAIL_EMAIL);
	// print_r($_FILES['file']); exit;
	// for ($i=0; $i < count($_FILES['file']['tmp_name']) ; $i++) { 
		// $mail->addAttachment($_FILES['file']['tmp_name'][$i], $_FILES['file']['name'][$i]);    // Optional name
	// }

	$mail->Subject = $data['subject'];
	$mail->Body    = $data['message'];

	if(!$mail->send()) {
		//echo 'Message could not be sent.';
		//echo 'Mailer Error: ' . $mail->ErrorInfo;
		return $mail->ErrorInfo;
	} else {
		return 'sent';
	}	
}

function wad_get_name_part($part, $fullname, $sep = ' '){
	$fullname = explode($sep,$fullname);
	if( $part == 'first'  && isset($fullname[0]) )
		return $fullname[0];
	if( $part == 'last' && isset($fullname[1]) )
		return $fullname[1];
	return;
}

function wad_create_update_email_counter()
{
	$current_timestamp = time();
	$email_counter_option_name = 'email_counter_'.wad_date($current_timestamp, 'F_j_Y');
	
	if( $email_counter_option_value = wad_get_option($email_counter_option_name) ){
		wad_update_option($email_counter_option_name, $email_counter_option_value+1);
	}else{
		wad_update_option($email_counter_option_name, 1);
	}
}

function wad_get_email_counter($a = 'today'){
	
	$current_timestamp = time();
	
	$email_counter_option_name = 'email_counter_';
	
	if( $a == 'today' ){
		$output = wad_get_option($email_counter_option_name.wad_date($current_timestamp, 'F_j_Y'));
		return $output ? $output : 'N/A';
	}
	if( $a == 'yesterday' ){
		$yesterday = strtotime('-1 day', $current_timestamp);
		$output = wad_get_option(	$email_counter_option_name.wad_date($yesterday, 'F_j_Y'));
		return $output ? $output : 'N/A';
	}
	
	return;
	
}

function wad_generate_report($user_spp_ids_array = array(), $data = array())
{
	if( empty($user_spp_ids_array) )
		return;

	$date_start = $data['date_start'];
	$date_end = $data['date_end'];
	
	$date_start_timestamp = $date_end_timestamp = $date_filter = '';
	
	if( $date_start && $date_end ){
		$date_start_timestamp = strtotime($date_start);
		$date_end_timestamp = strtotime('tomorrow', strtotime($date_end))-1;
	}
	if( $date_start_timestamp && $date_end_timestamp ){
		$date_filter = true;
	}
	
	$first_day_of_last_week_timestamp = strtotime('previous week');
	$last_week_begin_timestamp = strtotime('today',$first_day_of_last_week_timestamp);
	$last_day_of_last_week_timestamp = strtotime('this week -1 day');
	$last_week_end_timestamp = strtotime('tomorrow', $last_day_of_last_week_timestamp)-1;

	$first_day_of_last_month_timestamp = strtotime('first day of last month');
	$last_month_begin_timestamp = strtotime('today',$first_day_of_last_month_timestamp);
	$last_day_of_last_last_timestamp = strtotime('last day of last month');
	$last_month_end_timestamp = strtotime('tomorrow',$last_day_of_last_last_timestamp)-1;
	
	$where_user = array();
	foreach($user_spp_ids_array as $spp_id){
		$where_user[] = "spp_id='{$spp_id}'";
	}
	$where_user = implode(' OR ',$where_user);
	
	$users = wad_get_users("name, email, spp_id, role, assigned_orders", $where_user);
	
	$fetched_order_ids_array = $orders_array = array();

	$all_orders_by_user_array = $report_fields_by_writers = $report_fields_by_editors = array();
	
	foreach($users as $user){
		
		$user_spp_id = $user['spp_id'];
		$user_name = $user['name'];
		$user_email = $user['email'];
		$user_role = $user['role'];
		$assigned_orders_array = wad_explode_assigned_orders($user['assigned_orders']);
		
		foreach($assigned_orders_array as $order_id){
			if( in_array($order_id, $fetched_order_ids_array) ){
				$order = $orders_array[$order_id];
			}else{
				$fetched_order_ids_array[] = $order_id;
				$orders_array[$order_id] = $order = wad_get_order($order_id);
			}
			
			$writer_claim_timestamp = $order['assigned'];

			if( $date_filter )
			{
				//check order claimed in between start and end date
				if( $writer_claim_timestamp >= $date_start_timestamp && $writer_claim_timestamp <= $date_end_timestamp ){
					// do nothing
				}else{
					//skip this order
					continue;
				}
			}
			
			unset($order['doc_link']);
			unset($order['order_title']);
			unset($order['notif_before_6_hrs']);
			
			$all_orders_by_user_array[$user_spp_id]['spp_id'] = $user_spp_id;
			$all_orders_by_user_array[$user_spp_id]['user_name'] = $user_name;
			$all_orders_by_user_array[$user_spp_id]['user_email'] = $user_email;
			$all_orders_by_user_array[$user_spp_id]['user_role'] = $user_role;
			$all_orders_by_user_array[$user_spp_id]['orders'][] = $order;
			
		}
	}
	
	foreach($all_orders_by_user_array as $all_orders_by_user)
	{
		$user_spp_id = $all_orders_by_user['spp_id'];
		$user_name = $all_orders_by_user['user_name'];
		$user_email = $all_orders_by_user['user_email'];
		$user_role = $all_orders_by_user['user_role'];

		$words_produced_previous_week = $ontime_submissions_count = $overdue_submissions_count = $final_review_count = $editor_revision_count = $client_revision_count = $client_revision_previous_week_count = $client_revision_last_month_count = 0;
		$ontime_submissions = $overdue_submissions = array();
	
		$writer_response_time = $editor_response_time = 0;
		$writer_orders_count = $editor_orders_count = 0;
		$writer_earnings = 0;

		$all_orders = $all_orders_by_user['orders'];
		
		foreach($all_orders as $order)
		{
			$order_id = $order['order_id'];
			$status = $order['status'];
			$writer_claim_time = $claim_time = $order['assigned'];
			$writer_submit_time = $submit_time = $order['writer_submit_time'];
			$editor_claim_time = $order['editor_claim_time'];
			$editor_submit_time = $order['editor_submit_time'];
			
			$weekly_orders_status = array(5,6,9,12,3,17);
			if( $user_role == 'Editor' ){
				$claim_time = $order['editor_claim_time'];
				$weekly_orders_status = array(6,9,12,3);
				$submit_time = $editor_submit_time;
			}
			
			//Writer Average Time
			if( in_array($status, array(6,9,12,3,17)) ){
				if( $writer_submit_time && $writer_claim_time){
				$writer_response_time += $writer_submit_time - $writer_claim_time;
				$writer_orders_count++;
				}
			}
			
			//Editor Average Time
			if( in_array($status, array(12,6,3,9)) ){
				if( $writer_submit_time && $editor_claim_time){
				$editor_response_time += $editor_claim_time - $writer_submit_time;
				$editor_orders_count++;
				}
			}
			
			//Writer Pay Rate
			if( $user_role == 'Writer' ){
			if( in_array($status, array(3))  ){
				$writer_earnings += wad_get_order_earning($order, $user_spp_id);
			}
			}

			//Words Produced/Edited
			if( in_array($status, $weekly_orders_status) ){
				//based on start and end date else previous week
				if( $date_filter ){
					$words_produced_previous_week += $order['order_words'];					
				}else{
					if( $claim_time >= $last_week_begin_timestamp && $claim_time <= $last_week_end_timestamp)
					{
						$words_produced_previous_week += $order['order_words'];
					}
				}
			}
			
			// Ontime/Overdue submissions
			if( $order['date_due'] ){
			if( $submit_time < $order['date_due'] ){
				$ontime_submissions_count++;
				$ontime_submissions[] = $order_id;
			}else{
				$overdue_submissions_count++;
				$overdue_submissions[] = $order_id;
			}
			}
			
			// Final Review
			if( $total = wad_get_total_count("order_final_review","order_id='{$order_id}'") ){
				$final_review_count = $final_review_count + $total;
			}
			
			//Editor Revisoin
			if( $user_role == 'Writer' ){
				if( $total = wad_get_total_count("order_editor_revision","order_id='{$order_id}'") ){
					$editor_revision_count = $editor_revision_count + $total;
				}
			}
			
			//Client Revision based on start and end date else previous week/month
			if( $date_filter )
			{
				$where = " order_id='{$order_id}'";
			
				if( $total = wad_get_total_count("order_client_revision",$where) ){
					$client_revision_count = $client_revision_count + $total;
				}	
			
			}else
			{
				$where_week = "time BETWEEN {$last_week_begin_timestamp} and {$last_week_end_timestamp}";
				$where_month = "time BETWEEN {$last_month_begin_timestamp} and {$last_month_end_timestamp}";
				$where_order = " AND order_id='{$order_id}'";
				$where_week .= $where_order;
				$where_month .= $where_order;
				
				if( $total_week = wad_get_total_count("order_client_revision",$where_week) ){
					$client_revision_previous_week_count = $client_revision_previous_week_count + $total_week;
				}
				if( $total_month = wad_get_total_count("order_client_revision",$where_month) ){
					$client_revision_last_month_count = $client_revision_last_month_count + $total_month;
				}
			}
			
			$date_approved = '';
			$writer_average_response_time = $writer_orders_count ? seconds2human($writer_response_time/$writer_orders_count) : '';
			$editor_average_response_time = $editor_orders_count ? seconds2human($editor_response_time/$editor_orders_count) : '';
			$rejected_orders = wad_get_rejected_orders_by_id($user_spp_id, true);
			$missed_orders = wad_get_missed_orders_by_id($user_spp_id, true);
			$writer_earnings = $writer_earnings;
		}
		
		if( $user_role == 'Writer' )
		{
			$report_fields_by_writers[$user_spp_id]['user_name'] = $user_name;
			$report_fields_by_writers[$user_spp_id]['user_email'] = $user_email;
			$report_fields_by_writers[$user_spp_id]['words_produced_previous_week'] = $words_produced_previous_week;
			$report_fields_by_writers[$user_spp_id]['writer_earnings'] = '$'.$writer_earnings;
			$report_fields_by_writers[$user_spp_id]['date_approved'] = $date_approved;
			$report_fields_by_writers[$user_spp_id]['ontime_submissions_count'] = $ontime_submissions_count;
			$report_fields_by_writers[$user_spp_id]['overdue_submissions_count'] = $overdue_submissions_count;
			$report_fields_by_writers[$user_spp_id]['writer_average_response_time'] = $writer_average_response_time;
			$report_fields_by_writers[$user_spp_id]['final_review_count'] = $final_review_count;
			$report_fields_by_writers[$user_spp_id]['editor_revision_count'] = $editor_revision_count;
			if( $date_filter ){
				$report_fields_by_writers[$user_spp_id]['client_revision_count'] = $client_revision_count;				
			}else{
				$report_fields_by_writers[$user_spp_id]['client_revision_previous_week_count'] = $client_revision_previous_week_count;
				$report_fields_by_writers[$user_spp_id]['client_revision_last_month_count'] = $client_revision_last_month_count;
			}
			$report_fields_by_writers[$user_spp_id]['rejected_orders'] = $rejected_orders;
			$report_fields_by_writers[$user_spp_id]['missed_orders'] = $missed_orders;
		}
		elseif( $user_role == 'Editor' )
		{
			$report_fields_by_editors[$user_spp_id]['user_name'] = $user_name;
			$report_fields_by_editors[$user_spp_id]['user_email'] = $user_email;
			$report_fields_by_editors[$user_spp_id]['words_produced_previous_week'] = $words_produced_previous_week;
			$report_fields_by_editors[$user_spp_id]['ontime_submissions_count'] = $ontime_submissions_count;
			$report_fields_by_editors[$user_spp_id]['overdue_submissions_count'] = $overdue_submissions_count;
			$report_fields_by_editors[$user_spp_id]['editor_average_response_time'] = $editor_average_response_time;
			$report_fields_by_editors[$user_spp_id]['final_review_count'] = $final_review_count;
			if( $date_filter ){
				$report_fields_by_editors[$user_spp_id]['client_revision_count'] = $client_revision_count;				
			}else{
				$report_fields_by_editors[$user_spp_id]['client_revision_previous_week_count'] = $client_revision_previous_week_count;
				$report_fields_by_editors[$user_spp_id]['client_revision_last_month_count'] = $client_revision_last_month_count;
			}
			$report_fields_by_editors[$user_spp_id]['rejected_orders'] = $rejected_orders;
			$report_fields_by_editors[$user_spp_id]['missed_orders'] = $missed_orders;
		}
	}
	
	$writers_report_html = $editors_report_html = '';
	if( !empty($report_fields_by_writers) ){
		$writers_report_html = '<table>';
		ob_start();
		
		if( $date_filter ){
			?>
			<tr><td><strong>Start Date : </strong><?php echo $date_start; ?></td></tr>
			<tr><td><strong>End Date : </strong><?php echo $date_end; ?></td></tr>
			<?php 
		}
		
		?>
		<tr>
			<th><strong>Name</strong></th>
			<th><strong>Email</strong></th>
			<th><strong>Number of words<br> completed <?php if( !$date_filter ): ?>the<br> previous week<?php endif; ?></strong></th>
			<th><strong>Pay Rate</strong></th>
			<th><strong>Date Approved</strong></th>
			<th><strong>Ontime submissions</strong></th>
			<th><strong>Overdue submissions</strong></th>
			<th><strong>Average response<br> time/delay period</strong></th>
			<th><strong>Number of submissions<br> sent to FR</strong></th>
			<th><strong>Number of submissions<br> sent to ER</strong></th>
			<?php if( $date_filter ): ?>
			<th><strong>Number of revisions</strong></th>
			<?php else: ?>
			<th><strong>Number of revisions<br> over the<br> previous week</strong></th>
			<th><strong>Number of revisions<br> over the<br> previous month</strong></th>
			<?php endif; ?>
			<th><strong>Number of assignments<br> rejected</strong></th>
			<th><strong>Number of assignments<br> missed</strong></th>
		</tr>
		<?php
		$writers_report_html .= ob_get_clean();
		
		ob_start();
		foreach($report_fields_by_writers as $report_fields_by_writer)
		{
			?>
			<tr>
				<td><?php echo $report_fields_by_writer['user_name']; ?></td>
				<td><?php echo $report_fields_by_writer['user_email']; ?></td>
				<td><?php echo $report_fields_by_writer['words_produced_previous_week']; ?></td>
				<td><?php echo $report_fields_by_writer['writer_earnings']; ?></td>
				<td><?php echo $report_fields_by_writer['date_approved']; ?></td>
				<td><?php echo $report_fields_by_writer['ontime_submissions_count']; ?></td>
				<td><?php echo $report_fields_by_writer['overdue_submissions_count']; ?></td>
				<td><?php echo $report_fields_by_writer['writer_average_response_time']; ?></td>
				<td><?php echo $report_fields_by_writer['final_review_count']; ?>
				<td><?php echo $report_fields_by_writer['editor_revision_count']; ?>
				<?php if( $date_filter ): ?>
				<td><?php echo $report_fields_by_writer['client_revision_count']; ?>
				<?php else:?>
				<td><?php echo $report_fields_by_writer['client_revision_previous_week_count']; ?>
				<td><?php echo $report_fields_by_writer['client_revision_last_month_count']; ?>
				<?php endif; ?>
				<td><?php echo $report_fields_by_writer['rejected_orders'] ?>
				<td><?php echo $report_fields_by_writer['missed_orders'] ?>
			</tr>
			<?php
		}
		$writers_report_html .= ob_get_clean();
		
		$writers_report_html .= '</table>';
		
	}
	
	if( !empty($report_fields_by_editors) ){
		$editors_report_html = '<table>';
		ob_start();
		if( $date_filter ){
			?>
			<tr><td><strong>Start Date : </strong><?php echo $date_start; ?></td></tr>
			<tr><td><strong>End Date : </strong><?php echo $date_end; ?></td></tr>
			<?php 
		}
		
		?>
		<tr>
			<th><strong>Name</strong></th>
			<th><strong>Email</strong></th>
			<th><strong>Number of words<br> completed <?php if( !$date_filter ): ?>the<br> previous week<?php endif; ?></strong></th>
			<th><strong>Ontime submissions</strong></th>
			<th><strong>Overdue submissions</strong></th>
			<th><strong>Average response<br> time/delay period</strong></th>
			<th><strong>Number of submissions<br> sent to FR</strong></th>
			<?php if( $date_filter ): ?>
			<th><strong>Number of revisions</strong></th>
			<?php else: ?>
			<th><strong>Number of revisions<br> over the<br> previous week</strong></th>
			<th><strong>Number of revisions<br> over the<br> previous month</strong></th>
			<?php endif; ?>
			<th><strong>Number of assignments<br> rejected</strong></th>
			<th><strong>Number of assignments<br> missed</strong></th>
		</tr>
		<?php
		$editors_report_html .= ob_get_clean();
		
		ob_start();
		foreach($report_fields_by_editors as $report_fields_by_editor)
		{
			?>
			<tr>
				<td><?php echo $report_fields_by_editor['user_name']; ?></td>
				<td><?php echo $report_fields_by_editor['user_email']; ?></td>
				<td><?php echo $report_fields_by_editor['words_produced_previous_week']; ?></td>
				<td><?php echo $report_fields_by_editor['ontime_submissions_count']; ?></td>
				<td><?php echo $report_fields_by_editor['overdue_submissions_count']; ?></td>
				<td><?php echo $report_fields_by_editor['editor_average_response_time']; ?></td>
				<td><?php echo $report_fields_by_editor['final_review_count']; ?>
				<?php if( $date_filter ): ?>
				<td><?php echo $report_fields_by_editor['client_revision_count']; ?>
				<?php else: ?>
				<td><?php echo $report_fields_by_editor['client_revision_previous_week_count']; ?>
				<td><?php echo $report_fields_by_editor['client_revision_last_month_count']; ?>
				<?php endif; ?>
				<td><?php echo $report_fields_by_editor['rejected_orders'] ?>
				<td><?php echo $report_fields_by_editor['missed_orders'] ?>
			</tr>
			<?php
		}
		$editors_report_html .= ob_get_clean();
		
		$editors_report_html .= '</table>';
		
	}
		
	$date_time = time();
	$reports_array = array();
	
	
	if( $writers_report_html ){
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
		$spreadsheet = $reader->loadFromString($writers_report_html);
		$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(23);
		$writers_report = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
		$writers_report_filename = 'writers-report-'.$date_time.'.xls';
		$writers_report_file = BASE_DIR.'/reports/writers-report-'.$date_time.'.xls';
		$writers_report->save($writers_report_file); 
		
		$reports_array['writers'] = BASE_URL . '/reports/'.$writers_report_filename;
		
	}
	
	if( $editors_report_html ){
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
		$spreadsheet = $reader->loadFromString($editors_report_html);
		$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(23);
		$editors_report = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
		$editors_report_filename = 'editors-report-'.$date_time.'.xls';
		$editors_report_file = BASE_DIR.'/reports/editors-report-'.$date_time.'.xls';
		$editors_report->save($editors_report_file); 

		$reports_array['editors'] = BASE_URL . '/reports/'.$editors_report_filename;
	}
	
	return $reports_array;
	
}

function wad_query_with_fetch($query){
	global $con;
	$result = mysqli_query($con, $query);
	return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function wad_query($query){
	global $con;
	mysqli_query($con, $query);
}

function seconds2human($ss) {
	$s = $ss%60;
	$m = floor(($ss%3600)/60);
	$h = floor(($ss%86400)/3600);
	$d = floor(($ss%2592000)/86400);
	$M = floor($ss/2592000); //30days in a month

	$out = array();

	if($M)
		$out[] = "$M months";
	if($d)
		$out[] = "$d days";
	if($h)
		$out[] ="$h hours";
	if($m)
		$out[] ="$m minutes";
	if($s)
		$out[] ="$s seconds";

	return implode(', ',$out);
}

function wad_add_update_tags_to_order($order_id, $tags = array(), $tags_old = null){
	
	if( empty($tags) )
		return;
	
	$tags_old_array = $tags_new_array = array();
	
	if( !$tags_old )
		$tags_old = wad_get_order($order_id,'tags');
	
	if( $tags_old)
		$tags_old_array = explode('||',$tags_old);
	
	foreach($tags as $tag){
		if( !in_array($tag,$tags_old_array) ){
			$tags_new_array[] = $tag;
		}
	}
	
	$tags_array = array_merge($tags_old_array, $tags_new_array);
	
	$set = array('tags' => implode('||',$tags_array));
	$where = "order_id='{$order_id}'";
	
	wad_update_order($order_id, $set, $where);
}

function wad_update_order($order_id, $set_new_array,$where = null){
	$set_array = array();
	$set = '';
	
	
	foreach($set_new_array as $key => $val){
		$val = str_replace("'","''",$val);
		$set_array[] = "{$key}='{$val}'";
	}
	
	if( !empty($set_array))
		$set = implode(', ',$set_array);
	
	if($set)
	wad_update_query("orders",$set,$where);	
}

function wad_get_order_tags($order_id){
	$order_tags_array = explode('||',wad_get_order($order_id,'tags'));
	return $order_tags_array;
}

function wad_delete_order_tags($order_id, $tags_delete, $tags_old = null){
	
	if( in_array('Delete all', $tags_delete) )
	{
		$set = array('tags' => "");
	}
	else
	{
		
		$tags_array = array();
		
		if( !$tags_old )
			$tags_old = wad_get_order($order_id,'tags');
		
		if( is_string($tags_old) )
			$tags_old_array = explode('||',$tags_old);
		else
			$tags_old_array = $tags_old;
		
		
		foreach($tags_old_array as $tag){
			if( in_array($tag, $tags_delete) )
				continue;
			
			$tags_array[] = $tag;
		}
		
		$set = array('tags' => implode('||',$tags_array));
	}
	
	
	$where = "order_id='{$order_id}'";
	
	wad_update_order($order_id, $set, $where);
}

function wad_save_assigned_orders_to_user($user_spp_id, $order_id, $sep = '|'){
	$user = wad_get_user_by_id($user_spp_id);
	if(empty($user))
		return;
	
	$order_id_update = $sep.$order_id.$sep;
	
	$user_assigned_orders_old = $user['assigned_orders'];
	
	if( !empty($user_assigned_orders_old) ){
		
		$user_assigned_orders_array = array_filter(explode($sep,$user_assigned_orders_old));
		$user_assigned_orders_array[] = $order_id;
		$user_assigned_orders_array = array_unique($user_assigned_orders_array);
		
		$order_id_update = '';
		foreach($user_assigned_orders_array as $order_id){
			$order_id_update .= $sep.$order_id.$sep;
		}
		
		$order_id_update = str_replace(array('||','|||'),'|',$order_id_update);
	}
	
	wad_update_query("users","assigned_orders='{$order_id_update}'", "spp_id='{$user_spp_id}'");
	
}

function wad_delete_assigned_order_from_users($order_id, $sep='|'){
	
	$order_id_delete = $sep.$order_id.$sep;
	
	$Vinci_ID = 3253; //Editor
	$result = wad_select_query("users","spp_id, assigned_orders","assigned_orders LIKE '%{$order_id_delete}%' AND spp_id != '{$Vinci_ID}'");
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	if( empty($users) )
		return;
	
	$assigned_orders_array_by_users = array();
	foreach($users as $user){
		extract($user);
		$assigned_orders_array = wad_explode_assigned_orders($assigned_orders);

		if (($key = array_search($order_id, $assigned_orders_array)) !== false) {
			unset($assigned_orders_array[$key]);
		}
		$assigned_orders_array_by_users[$spp_id] = $assigned_orders_array;
	}

	foreach($assigned_orders_array_by_users as $user_spp_id => $assigned_orders){
		$order_id_update = '';
		if( empty($assigned_orders) ){
			$order_id_update = '';
		}else{
			foreach($assigned_orders as $order_id){
				$order_id_update .= $sep.$order_id.$sep;
			}
		}
		$order_id_update = str_replace(array('||','|||'),'|',$order_id_update);
		wad_update_query("users","assigned_orders='{$order_id_update}'", "spp_id='{$user_spp_id}'");
	}
}

function wad_set_previous_assigned_orders_to_users($user_spp_id = null){
	if( !$user_spp_id )
		return;
	
	wad_query("update users set assigned_orders='' where spp_id='{$user_spp_id}'");

	echo $user_spp_id;
	echo '<pre>';
	$records = wad_query_with_fetch("SELECT o.order_id
FROM users u, orders o, order_assigned_user ou
WHERE u.spp_id = ou.spp_id
AND o.order_id = ou.order_id
AND (u.spp_id='{$user_spp_id}')
AND ( o.status='5' OR o.status='6' OR o.status='9' OR o.status='12' OR o.status='3' OR o.status='17' )");

	print_r($records);

	
	$order_ids_array = array();
	$sep = '|';
	foreach($records as $rec){
		$order_ids_array[] = $sep.$rec['order_id'].$sep;
	}
	$order_ids = implode('',$order_ids_array);
	$order_ids = str_replace(array('||','|||'),'|',$order_ids);
	
	wad_query("update users set assigned_orders='{$order_ids}' where spp_id='{$user_spp_id}'");
	
	echo '</pre>';
 
}
// $order_ids_arr = array('8EE4D3AA_4');
// wad_set_date_due_for_orders($order_ids_arr);
// exit;
function wad_set_date_due_for_orders($order_ids_arr = array()){
	if( empty($order_ids_arr ))
		return;
	
	$where_order = array();
	foreach($order_ids_arr as $order_id){
		$where_order[] = "order_id='{$order_id}'";
	}
	$where_order = implode(' OR ',$where_order);
	
	$orders = wad_get_orders("*", $where_order);
	
	foreach($orders as $order){
		
		$order_id = $order['order_id'];
		$date_due = $order['created'] + 777600+14400;
		
		wad_query("update orders set spp_date_due='{$date_due}', date_due='{$date_due}' where order_id='{$order_id}'");
		
		$post = array(
			"date_due"		=> date('Y-m-d H:i:s', $date_due),
		);
		wad_spp_update_order($order_id, $post);

		
	}
	
}

function wad_explode_assigned_orders($assigned_orders_str = null, $sep = '|'){
	if( empty($assigned_orders_str) )
		return array();
	
	return array_filter(explode($sep,$assigned_orders_str));
}

function wad_delete_order($order_id, $remove_everything = null){
	wad_delete_query("orders", "order_id='{$order_id}'");
	if( $remove_everything ){
		wad_delete_query("order_assigned_user", "order_id='{$order_id}'");
		wad_delete_query("order_client_revision", "order_id='{$order_id}'");
		wad_delete_query("order_docs", "order_id='{$order_id}'");
		wad_delete_query("order_editor_revision", "order_id='{$order_id}'");
		wad_delete_query("order_final_review", "order_id='{$order_id}'");
		wad_delete_query("order_revisions", "order_id='{$order_id}'");
		wad_delete_query("logs", "source_id='{$order_id}' AND source='order'");
	}
	
	if( wad_get_option('save_log') == 'yes')
	{
		$log_columns = 	array( "from_type", "action", "source", "source_id", "time" );
		$log_values = 	array( "System", "deleted order", "order", $order_id, time() );
		wad_insert_query("logs", $log_columns, $log_values);
	}

}

function wad_set_get_order_id_IN($order_ids_arr = array()){
	if( empty($order_ids_arr) )
		return;
	
	$order_ids_IN = '';
	foreach($order_ids_arr as $order_id){
		$order_ids_IN .= "'". $order_id . "',";
	}
	$order_ids_IN = rtrim($order_ids_IN, ",");
	
	return $order_ids_IN;

}