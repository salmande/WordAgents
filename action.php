<?php

$action = ( isset($_REQUEST['action']) && $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
$message = $message_type = '';

if( $action == 'signup_form_submit' )  // signup_form_submit - START
{
	$name = $_POST['fullname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	$authtoken_hash = password_hash($password, PASSWORD_DEFAULT);
	
	$role = '';
	$spp_id = '';
	
	$query = "SELECT * FROM users WHERE email='".$email."'";
	$result = mysqli_query($con, $query);
	$is_user_exist = mysqli_num_rows($result);
	
	if($is_user_exist) {
		$message = "User already exist with this email address.";
		$message_type = 'danger';
	} else {
	
		$team = wad_get_team_member_by_email($email);
		
		$role = $team['role'];
		$spp_id = $team['spp_id'];
		$weekly_quota = $team['weekly_quota'];
		
		$insert_query = "INSERT INTO users(name, email, password, authtoken, role, spp_id, weekly_quota) VALUES('".$name."', '".$email."', '".$password_hash."', '".$authtoken_hash."', '".$role."', '".$spp_id."', '".$weekly_quota."')";
		mysqli_query($con, $insert_query);
		$message = "Your account has been created successfully";
		$message_type = 'success';
	}
	
} // signup_form_submit - END

if( $action == 'login_form_submit' )  // login_form_submit - START
{
	$redirect_to = $_POST['redirect_to'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$redirect_to_after_login = ( $redirect_to ) ? $redirect_to : BASE_URL;

	$query = "SELECT * FROM users WHERE email='".$email."'";
	$result = mysqli_query($con, $query);
	$is_user_exist = mysqli_num_rows($result);	
	
	if($is_user_exist){
		$user = mysqli_fetch_assoc($result);
		if (! password_verify($password, $user['password'])) {
			$message = "Invalid login!";
			$message_type = 'danger';
		}else{
			unset($user['password']);
			unset($user['authtoken']);
			
			setCookie('wad_user_logged_in',true, strtotime( '+10 years' ));
			setCookie('wad_user_logged_in_spp_id',openssl_encrypt($user['spp_id'], "AES-128-ECB", SECURE_KEY), strtotime( '+10 years' ));
			
			if( $user['role'] == 'Admin' ){
				$redirect_to_after_login = BASE_URL.'/admin';
			}
			
			header("Location: ".$redirect_to_after_login);
			
		}
	} else {		
		$message = "No account exist with entered email address.";
		$message_type = 'danger';
	}
	
}   // login_form_submit - END

if( $action == 'forgot_form_submit' )  // forgot_form_submit - START
{
	$email = $_POST['email'];

	$query = "SELECT * FROM users WHERE email='".$email."'";
	$result = mysqli_query($con, $query);
	$is_user_exist = mysqli_num_rows($result);	
	
	if($is_user_exist){
		$user = mysqli_fetch_assoc($result);
		$authtoken = $user['authtoken'];
		$email = $user['email'];
		$firstname = wad_get_name_part('first',$user['name']);
		$password_reset_link = BASE_URL."/reset-password?authtoken=".$authtoken."&email=".$email;
		
		$subject = "Password reset request";
		$msg = "Hi {{firstname}},<br />If you requested a password reset for the WordAgents self-service dashboard, click the link below. If you didn't make this request, please ignore this email.<p><a href='{{password_reset_link}}'>{{password_reset_link}}</a></p><p>If you need help, contact <a href='mailto:support@wordagents.com'>support@wordagents.com</a>.</p>";
		
		$msg = str_replace(
			array("{{firstname}}", "{{password_reset_link}}"),
			array($firstname, $password_reset_link),
			$msg
		);
		
		/* NEW EMAIL SMTP */
		$data['subject'] = $subject;
		$data['message'] = $msg;
		$data['to'] = $email;
		// $data['debug'] = 1;
		
		$send_email_response = wad_send_email($data);
		// if(mail($email, $subject, $msg, $headers)) {
		if( $send_email_response == 'sent'){
			wad_create_update_email_counter();
			$message =  "Password reset link send. Please check your mailbox to reset password.";
			$message_type = 'success';
		}						
	} else {		
		$message = "No account exist with entered email address.";
		$message_type = 'danger';
	}
	
}   // forgot_form_submit - END

if( $action == 'reset_form_submit' )  // reset_form_submit - START
{
	$authtoken = $_POST['authtoken'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	$query = "SELECT * FROM users WHERE email='".$email."'";
	$result = mysqli_query($con, $query);
	$is_user_exist = mysqli_num_rows($result);
	
	if($is_user_exist){
		$user = mysqli_fetch_assoc($result);
		if ( $authtoken != $user['authtoken']) {
			$message = "Invalid token!";
			$message_type = 'danger';
		}else{
			$password_hash = password_hash($password, PASSWORD_DEFAULT);
			$authtoken_hash = password_hash($password, PASSWORD_DEFAULT);
			
			$query = "UPDATE users SET password = '".$password_hash."', authtoken = '".$authtoken_hash."' WHERE email='".$email."'";
			$is_updated = mysqli_query($con, $query);
			if( $is_updated ){
				$message = "Password has been changed successfully";
				$message_type = 'success';
			}
		}
	} else {		
		$message = "No account exist with entered email address.";
		$message_type = 'danger';
	}
	
}   // reset_form_submit - END

// writer claim order - START
if( $action == 'writer_claim_order' )  
{
	wad_writer_claim_order();
}

// END - writer claim order


if( $action == 'writer_submit_working_order' )  // writer_submit_working_order - START
{
	$order_id = $_GET['order'];
	$employee_id = $_GET['employee'];
	$status = 17; // Ready to Edit
	$tag_ReadyToEdit = 'Ready to Edit';
	$order = wad_get_order($order_id);
	$spp_date_due = $order['spp_date_due'];

	$employee = wad_get_user_by_id($employee_id);
	$employee_email = $employee['email'];
	$employee_name = $employee['name'];
			
	$order_info = wad_get_spp_order_info($order_id);
	$order_title = $order_info['service'];
	$note = $order_info['note'];
	
	$post = array();
	
	$post = array(
		"date_due"		=> date('Y-m-d H:i:s', $spp_date_due)
	);
	
	$is_note_updated = false;
	if (strpos($note, 'docs.google.com') === false) {
		$doc_link = wad_get_order($order_id,"doc_link");
		if( $doc_link)
		$note .= '<br><a href="'.$doc_link.'" target="_blank">'.$doc_link.'</a>';
		$post["note"] = $note;
		$is_note_updated = true;
	}
	
	$order_tags = $order_info['tags'];
	$tags = array();
	$i=0;
	if( sizeof($order_tags) )
	{
		foreach($order_tags as $tag){
			$tags["tags[".$i."]"] = $tag;
			$i++;
		}
	}
	$tags["tags[".$i."]"] = $tag_ReadyToEdit;
	
	$post = array_merge($post, $tags);

	wad_spp_update_order($order_id, $post);
	
	wad_add_update_tags_to_order($order_id, array($tag_ReadyToEdit));
	
	$writer_submit_time_end = wad_get_due_timestamp();

	wad_update_query("orders", "status='{$status}', date_due='{$spp_date_due}', writer_submit_time='".time()."', writer_submit_time_end='".$writer_submit_time_end."'", "order_id='{$order_id}'");
	
	//NEW - Incrementing new orders total count for all editors .
	//NEW - Incrementing editing total count for the writer who submitted
	//NEW - Decrementing working orders total count for the writer who submitted
	$args = array(
		'roles' => array('Editor'),
		'add_to_Editor_fields' => array('new_orders_count'),
		'add' => array('editing_orders_count'),
		'add_user_spp_id' => $employee_id,
		'subtract' => array('working_orders_count'),
		'subtract_user_spp_id' => $employee_id,
	);
	wad_set_users_order_total_count($args);
	//NEW END
	
	if( wad_get_option('save_log') == 'yes' ){
		
		wad_insert_query( "logs",
			array( "from_type", "from_id", "action", "source", "source_id", "time", "data"),
			array( "system", $employee_id, "Added tag", "order", $order_id, time(), $tag_ReadyToEdit)
		);
		
		if( $is_note_updated ){
			wad_insert_query( "logs",
				array( "from_type", "from_id", "action", "source", "source_id", "time", "data"),
				array( "system", $employee_id, "updated note", "order", $order_id, time(),$note)
			);
		}

	}
	
	wad_store_new_created_order($order_id, 'editor');
	
	if( wad_get_option('send_emails') == 'yes' ){
	
		$subject = "Submitted: Order {$order_id}";
		
		$writer_firstname = wad_get_name_part('first',$employee_name);
		
		$link_to_OG_new_orders = BASE_URL.'/orders';	
		$order_link = "https://app.wordagents.com/orders/".$order_id;
		
		$msg = "Hi {{writer_firstname}},<br />Your order <a href='{$order_link}'>{{order_title}} - {{order_number}}</a> has been successfully submitted for editing.<p>To claim new orders, go to the <a href='{{link_to_OG_new_orders}}'>self-service dashboard</a>.</p><p>If you need help, contact <a href='mailto:talent@wordagents.com'>talent@wordagents.com</a></p>";
		
		$msg = str_replace(
			array("{{writer_firstname}}", "{{order_title}}", "{{order_number}}", "{{link_to_OG_new_orders}}"),
			array($writer_firstname, $order_title, $order_id, $link_to_OG_new_orders),
			$msg
		);
	
		/* NEW EMAIL SMTP */
		$data['subject'] = $subject;
		$data['message'] = $msg;
		$data['to'] = $employee_email;
		// $data['debug'] = 1;
		
		$send_email_response = wad_send_email($data);
		// if( mail($employee_email, $subject, $msg, $headers) ){
		if( $send_email_response == 'sent'){
			wad_create_update_email_counter();
			$from = "WordAgents Dashboard";
			$to = "Writer who submitted";
			wad_save_email_log($from, $to, $subject, $msg, $order_id);
		}
	}
		
	header("Location: ".BASE_URL."/orders/working");
	
} // END - writer_submit_working_order

if( $action == 'writer_reject_working_order' )  // writer_reject_working_order - START
{
	$order_id = $_REQUEST['order'];
	$employee_id = $_REQUEST['employee'];
	$status = 2; // Submitted
	$current_timestamp = $started = $due_in = time();
	$order = wad_get_order($order_id);
	$spp_date_due = $order['spp_date_due'];
	
	$post = array(
		"status" => $status,
		"date_due"		=> date('Y-m-d H:i:s', $spp_date_due),
		"note" => ""
	);
	
	$order_assigned_users = wad_get_assigned_users($order_id, 'spp_id');
	$employees 	= count($order_assigned_users) ? $order_assigned_users : array();
	if( count($employees) ){
		$i=0;
		foreach($employees as $employee){
			if( $employee_id == $employee['spp_id'])
			continue; // Un-assign employee/team who reject
			
			$post["employees[$i]"] = $employee['spp_id'];
			$i++;
		}
		//Check and set empty employee if not an employee assigned
		if( ! isset($post["employees[0]"] ) ){
			$post["employees[]"] = '';
		}
	}	
	
	wad_spp_update_order($order_id, $post); //uncomment
		
	$order = wad_get_order($order_id);
	$order_words = (int)$order['order_words'];
	$order_title = $order['order_title'];
	$due_in_end = $started + (60*60*48);
	if( $order_words >= 5000 ){
		$due_in_end = $started + (60*60*72);
	}
	$assigned = $assigned_end = 0;
	wad_update_query("orders","status='{$status}', started='{$started}', due_in='{$due_in}', due_in_end='{$due_in_end}', assigned='{$assigned}', assigned_end='{$assigned_end}'", "order_id='{$order_id}'"); //uncomment

	wad_reject_order_from_empolyee($order_id, $employee_id); //uncomment
	
	$writer_rejected = wad_get_user_by_id($employee_id);
	$rejected_order_ids = $writer_rejected['rejected_order_ids'];
	if( $rejected_order_ids )
		$rejected_order_ids .= ','.$order_id;
	else
		$rejected_order_ids = $order_id;
	
	wad_update_query("users","rejected_order_ids='{$rejected_order_ids}'", "spp_id='{$employee_id}'"); //uncomment
	
	//NEW - Incrementing Writers' new orders total count except rejected writers
	//NEW - Decrementing all and working orders total count for the rejected writer
	$args = array(
		'roles' => array('Writer'),
		'add_to_Writer_fields' => array('new_orders_count'),
		'rejected_user_spp_id' => $employee_id,
		'order_id' => $order_id,
		'subtract' => array('all_orders_count', 'working_orders_count'),
		'subtract_user_spp_id' => $employee_id,
		'subtract_words' => $order_words,
		'subtract_words_user_spp_id' => $employee_id
	);
	wad_set_users_order_total_count($args);
	//NEW END
	
	if( wad_get_option('save_log') == 'yes' )
	{
		wad_insert_query( "logs",
			array( "from_type", "from_id", "action", "source", "source_id", "time", "to_type", "to_id" ),
			array( "user", $employee_id, "rejected", "order", $order_id, time(), "user", $employee_id )
		);
	}
	
	$has_deleted = wad_delete_query("order_assigned_user", "spp_id='{$employee_id}' AND order_id='{$order_id}'");
	if( wad_get_option('save_log') == 'yes' )
	{
		if( $has_deleted )
		{
			wad_insert_query( "logs",
				array( "from_type", "from_id", "action", "source", "source_id", "time", "to_type", "to_id" ),
				array( "system", $employee_id, "unassigned", "order", $order_id, time(), "user", $employee_id )
			);
		}
	}				

	if( wad_get_option('save_log') == 'yes' )
	{
		wad_insert_query( "logs",
			array( "from_type", "action", "source", "source_id", "time", "data"),
			array( "System", "changed order status", "order", $order_id, time(), $status)
		);
		wad_insert_query( "logs",
			array( "from_type", "action", "source", "source_id", "time", "data"),
			array( "system", "deleted note", "order", $order_id, time(),"")
		);
		wad_insert_query( "logs",
			array( "from_type", "action", "source", "source_id", "time", "data"),
			array( "system", "changed due date", "order", $order_id, time(), $spp_date_due)
		);

	}
 	
	if( wad_get_option('send_emails') == 'yes' )
	{
		$subject = "Rejected: Order {$order_id}";
		
		$writer_firstname = wad_get_name_part('first',$writer_rejected['name']);
		$writer_rejected_spp_id = $writer_rejected['spp_id'];
		$link_to_OG_new_orders = BASE_URL.'/orders';
		$link_claim = BASE_URL.'?action=writer_claim_order&order_id='.$order_id.'&employee_id='.$writer_rejected_spp_id;
		$order_link = "https://app.wordagents.com/orders/".$order_id;
		
		$msg = "Hi {{writer_firstname}},<br/>This email is to confirm that you've rejected order <a href='{$order_link}'>{{order_title}} - {{order_number}}</a>. If you've rejected this order in error, you can re-claim it <a href='{{link_claim}}'>here</a>. Or, to claim new orders, go to the <a href='{{link_to_OG_new_orders}}'>self-service dashboard</a>.<p>If you need help, contact <a href='mailto:talent@wordagents.com'>talent@wordagents.com</a></p>.";
		
		$msg = str_replace(
			array("{{writer_firstname}}", "{{order_title}}", "{{order_number}}", "{{link_claim}}", "{{link_to_OG_new_orders}}"),
			array($writer_firstname, $order_title, $order_id, $link_claim, $link_to_OG_new_orders),
			$msg
		);

		/* NEW EMAIL SMTP */
		$data['subject'] = $subject;
		$data['message'] = $msg;
		$data['to'] = $writer_rejected['email'];
		// $data['debug'] = 1;
		
		$send_email_response = wad_send_email($data);
		// if( mail($writer['email'], $subject, $msg, $headers) ){
		if( $send_email_response == 'sent'){
			$email_sent = 1;
			wad_create_update_email_counter();
		}
		if( $email_sent )
		{
			$from = "WordAgents Dashboard";
			$to = "Rejected Writer";
			wad_save_email_log($from, $to, $subject, $msg, $order_id);
		}
	}
	
	header("Location: ".BASE_URL."/orders/working");
	
} // END - writer_reject_working_order

if( $action == 'editor_claim_order' )  // editor claim order - START
{	
	wad_editor_claim_order();
		
} // END - editor claim order


if( $action == 'editor_request_revision_editing_order' )  // editor_request_revision_editing_order - START
{
	$order_id = $_POST['order'];
	$employee_id = $_POST['employee'];
	$content = $_POST['content'];
	$status = 6; // Editor Revision
	$tag_EditorRevision = 'Editor Revision';
	
	$editor = wad_get_user_by_id($employee_id);
	$editor_name = $editor['name'];
	
	$order = wad_get_order($order_id);
	$order_title = $order['order_title'];
	$order_due_date_time = wad_date($order['date_due'], 'h:m A F j, Y') . ' EST';

	$assigned_writers_editors = wad_get_assigned_writers_and_editors($order_id);
	$assigned_writers = $assigned_writers_editors['writers'];
	$assigned_editors = $assigned_writers_editors['editors'];
	
	// $order_info = wad_get_spp_order_info($order_id);
	// $order_tags = $order_info['tags'];
	$order_tags = wad_get_order_tags($order_id);

	$tags = $post = array();

	$i=0;
	if( sizeof($order_tags) )
	{
		foreach($order_tags as $tag){
			$tags["tags[".$i."]"] = $tag;
			$i++;
		}
	}
	$tags["tags[".($i)."]"] = $tag_EditorRevision;
	
	$post["status"] = 5; //Working
	$post = array_merge($post, $tags);

	wad_spp_update_order($order_id, $post);
	
	wad_add_update_tags_to_order($order_id, array($tag_EditorRevision), $order['tags']);
	
	wad_insert_query( "order_editor_revision",
		array( "from_type", "from_id", "order_id", "time"),
		array( "System", $employee_id, $order_id, time())
	);


	//NEW - Incrementing revision orders count to the editor who requested the revision
	//NEW - Decrementing editing orders count to the editor who requested the revision
	//NEW - Incrementing revision orders count to the assigned writer.
	//NEW - Decrementing editing orders count to the assigned writer.
	$args = array(
		'add' => array('revision_orders_count'),
		'add_user_spp_id' => $employee_id,
		'subtract' => array('editing_orders_count'),
		'subtract_user_spp_id' => $employee_id,
		'add_2' => array('revision_orders_count'),
		'add_user_spp_id_2' =>$assigned_writers[0]['spp_id'],
		'subtract_2' => array('editing_orders_count'),
		'subtract_user_spp_id_2' => $assigned_writers[0]['spp_id'],
	);
	wad_set_users_order_total_count($args);
	//END
		
	if( wad_get_option('save_log') == 'yes' )
	{
		wad_insert_query( "logs",
			array( "from_type", "action", "source", "source_id", "time", "data"),
			array( "system", "Added tag", "order", $order_id, time(), $tag_EditorRevision)
		);

		wad_insert_query( "logs",
			array( "from_type", "action", "source", "source_id", "time", "data"),
			array( "System", "changed order status", "order", $order_id, time(), 5)
		);
	}

	wad_update_query("orders", "status='{$status}'", "order_id='{$order_id}'");
	
	// Request edit text
	//wad_insert_query("order_revisions", array("order_id", "content"), array($order_id, $content));
	
	if( $content ){
		$post = array(
			"message" => $content,
			"user_id" => $employee_id,
			"staff_only" => 1
		);	
		wad_add_spp_order_message($order_id, $post);
	}
	if( wad_get_option('send_emails') == 'yes' )
	{
		$email_sent = '';
		foreach($assigned_writers as $writer)
		{
			$subject = "Edits needed: Order {$order_id}";

			$writer_email = $writer['email'];
			$writer_firstname = wad_get_name_part('first',$writer['name']);
			$order_link = "https://app.wordagents.com/orders/".$order_id;
			
			$msg = " Hi {{writer_firstname}},<br />Your editor, {{editor_name}}, has requested some revisions to order <a href='{$order_link}'>{{order_title}} - {{order_number}}</a>.<br />{{message_provided_by_the_editor}}<p>Additional notes may be in the Google Doc comments. Please make the required changes and re-submit by {{due_date_time}}.</p><p>If you need help, contact <a href='mailto:talent@wordagents.com'>talent@wordagents.com</a>.</p>";
			
			$msg = str_replace(
				array("{{writer_firstname}}", "{{order_title}}", "{{order_number}}","{{editor_name}}","{{message_provided_by_the_editor}}","{{due_date_time}}"),
				array($writer_firstname, $order_title, $order_id, $editor_name, nl2br($content),$order_due_date_time),
				$msg
			);
			
			// NEW EMAIL SMTP 
			$data['subject'] = $subject;
			$data['message'] = $msg;
			$data['to'] = $writer_email;
			// $data['debug'] = 1;
			
			$send_email_response = wad_send_email($data);
			// if( mail($employee_email, $subject, $msg, $headers) ){
			if( $send_email_response == 'sent'){
				wad_create_update_email_counter();
				$email_sent = 1;
			}
		}
		if( $email_sent )
		{
			$from = "WordAgents Dashboard";
			$to = "Assigned Writers";
			wad_save_email_log($from, $to, $subject, $msg, $order_id);
		}
		
		$email_sent = '';
		foreach($assigned_editors as $editor)
		{
			$subject = "Edit request sent: Order {$order_id}";

			$editor_email = $editor['email'];
			$editor_firstname = wad_get_name_part('first',$editor['name']);
			$writer_firstname = wad_get_name_part('first',$assigned_writers[0]['name']);
			$order_link = "https://app.wordagents.com/orders/".$order_id;
			
			$msg = "Hi {{editor_firstname}},<br />Your edit request for order <a href='{$order_link}'>{{order_title}} - {{order_number}}</a> has been sent successfully to the writer, {{writer_firstname}}. Revisions are due by {{due_date_time}}.<p>If you need help, contact Chris on Slack or at <a href='mailto:chris@wordagents.com'>chris@wordagents.com</a>.</p>";
			
			$msg = str_replace(
				array("{{editor_firstname}}", "{{order_title}}", "{{order_number}}","{{writer_firstname}}","{{message_provided_by_the_editor}}","{{due_date_time}}"),
				array($editor_firstname, $order_title, $order_id, $writer_firstname, nl2br($content),$order_due_date_time),
				$msg
			);
			

			/* NEW EMAIL SMTP */
			$data['subject'] = $subject;
			$data['message'] = $msg;
			$data['to'] = $editor_email;
			// $data['debug'] = 1;
			
			$send_email_response = wad_send_email($data);
			// if( mail($employee_email, $subject, $msg, $headers) ){
			if( $send_email_response == 'sent'){
				wad_create_update_email_counter();
				$email_sent = 1;
			}
		}
		if( $email_sent )
		{
			$from = "WordAgents Dashboard";
			$to = "Assigned Editors";
			wad_save_email_log($from, $to, $subject, $msg, $order_id);
		}		
	}

	header("Location: ".BASE_URL."/orders/editing");
	
} // END - editor_request_revision_editing_order


if( $action == 'writer_submit_revisions_order' )  // writer_submit_revisions_order - START
{
	$order_id = $_GET['order'];
	$employee_id = $_GET['employee'];
	$status = 12; // Editing

	$assigned_writers_editors = wad_get_assigned_writers_and_editors($order_id);
	$assigned_writers = $assigned_writers_editors['writers'];
	$assigned_editors = $assigned_writers_editors['editors'];

	$writer_firstname = wad_get_name_part('first',$assigned_writers[0]['name']);

	$order = wad_get_order($order_id);
	$order_title = $order['order_title'];
	$editor_due_date_time = wad_date($order['editor_claim_time_end'], 'h:m A F j, Y') . ' EST';

	$post = array();
	$post["status"] = $status;
	
	wad_spp_update_order($order_id,$post);
	
	//NEW - Incrementing editing orders count to the writer who submitted
	//NEW - Decrementing revision orders count to the the who submitted
	//NEW - Incrementing editing orders count to assigned editor
	//NEW - Decrementing revision orders count to assigned editor
	$args = array(
		'add' => array('editing_orders_count'),
		'add_user_spp_id' => $employee_id,
		'subtract' => array('revision_orders_count'),
		'subtract_user_spp_id' => $employee_id,
		'add_2' => array('editing_orders_count'),
		'add_user_spp_id_2' => $assigned_editors[0]['spp_id'],
		'subtract_2' => array('revision_orders_count'),
		'subtract_user_spp_id_2' => $assigned_editors[0]['spp_id'],
	);
	wad_set_users_order_total_count($args);


	if( wad_get_option('save_log') == 'yes' )
	{
		wad_insert_query( "logs",
			array( "from_type", "action", "source", "source_id", "time", "data"),
			array( "System", "changed order status", "order", $order_id, time(), $status)
		);
	}	
	
	if( wad_get_option('send_emails') == 'yes' ){
		
		$email_sent = '';
		foreach($assigned_editors as $editor)
		{
			$editor_email = $editor['email'];
			$editor_firstname = wad_get_name_part('first',$editor['name']);
			
			if( $editor_email == 'erynn@wordagents.com' || $editor_email == 'vinci@wordagents.com' )
				continue;
			
			$subject = "Edits completed by writer: Order {$order_id}";
			$order_link = "https://app.wordagents.com/orders/".$order_id;

			$msg = "Hi {{editor_firstname}},<br />{{writer_firstname}} has completed your edits for order <a href='{$order_link}'>{{order_title}} - {{order_number}}</a>. Please review by {{editor_due_date_time}}.<p>If additional edits are needed and the order is due in <strong>LESS than 2 days</strong>, please send it to Final Review. Otherwise, please resend to {{writer_firstname}}.</p><p>Or, if the order is complete, please deliver to the client.</p><p>If you need help, contact Chris on Slack or at <a href='mailto:chris@wordagents.com'>chris@wordagents.com</a></p>.";
			
			$msg = str_replace(
				array("{{editor_firstname}}", "{{order_title}}", "{{order_number}}","{{writer_firstname}}","{{editor_due_date_time}}"),
				array($editor_firstname, $order_title, $order_id, $writer_firstname,$editor_due_date_time),
				$msg
			);

			/* NEW EMAIL SMTP */
			$data['subject'] = $subject;
			$data['message'] = $msg;
			$data['to'] = $editor_email;
			// $data['debug'] = 1;
			
			$send_email_response = wad_send_email($data);
			// if( mail($editor_email, $subject, $msg, $headers) ){
			if( $send_email_response == 'sent'){
				wad_create_update_email_counter();
				$email_sent = 1;
			}
		}
		if( $email_sent )
		{
			$from = "WordAgents Dashboard";
			$to = "Assigned Editors excluding Erynn and Vinci";
			wad_save_email_log($from, $to, $subject, $msg, $order_id);
		}
	}
	
	wad_update_query("orders", "status='{$status}'", "order_id='{$order_id}'");
	
	header("Location: ".BASE_URL."/orders/editing");
	
	
} // END - writer_submit_revisions_order


if( $action == 'send_message' ){  // send_message - START

	$order_id = $_REQUEST['order'];
	$employee_id = $_REQUEST['employee'];
	$staff_only = $_REQUEST['staff_only'];
	$message = $_REQUEST['content'];
	$redirect = $_SERVER['HTTP_REFERER'];
	
	if( $message )
	{
		$post = array(
			"message" => $message,
			"user_id" => $employee_id,
			"staff_only" => $staff_only
		);
		
		wad_add_spp_order_message($order_id, $post);
		
		if( wad_get_option('save_log') == 'yes' )
		{
			wad_insert_query( "logs",
				array( "from_type", "from_id", "action", "source", "source_id", "time", "to_type", "to_id", "data" ),
				array( "user", $employee_id, "send_message", "order", $order_id, time(), "user", $employee_id, $staff_only)
			);
		}	
	}
	
	header("Location: ".$redirect);
	
} // END - send_message

if( $action == 'admin_add_user' ){ // Add User by Admin

	$email = $_POST['email'];
	
	$is_user_exist = wad_get_total_count("spp_team","email='{$email}'");
	
	if($is_user_exist) {
		$message = "User already exist with this email address.";
		$message_type = 'danger';
	}else{
		wad_insert_query(
			"spp_team",
			array('email','role','spp_id', 'weekly_quota'),
			array($email, $_POST['role'], $_POST['spp_id'], $_POST['weekly_quota'])
		);
		
		header("Location: ".BASE_URL."/admin/users/add");
	}


}

if( $action == 'editor_submit_editing_order' )  // editor_submit_editing_order - START
{
	$order_id = $_GET['order'];
	$employee_id = $_GET['employee'];
	$status = 3; // Complete
	
	$order_info = wad_get_spp_order_info($order_id);
	$order_title = $order_info['service']; //uncomment
	
	$assigned_writers_editors = wad_get_assigned_writers_and_editors($order_id);
	$assigned_writers = $assigned_writers_editors['writers'];
	$assigned_editors = $assigned_writers_editors['editors'];

	$assigned_writer = $assigned_writers[0];
	$assigned_writer_name = $assigned_writer['name'];
	$assigned_writer_email = $assigned_writer['email'];
	$assigned_writer_spp_id = $assigned_writer['spp_id'];
	
	wad_spp_update_order($order_id, array("status"=>$status));
	if( wad_get_option('save_log') == 'yes' )
	{
		wad_insert_query( "logs",
			array( "from_type", "action", "source", "source_id", "time", "data"),
			array( "System", "changed order status", "order", $order_id, time(), $status)
		);
	}	
	
	//NEW - Incrementing complete orders count for the editor who completed
	//NEW - Decrementing editing orders count for the editor who completed
	//NEW - Decrementing editing orders count for the assigned writer
	//NEW - Incrementing complete orders count for the assigned writer
	$args = array(
		'add' => array('complete_orders_count'),
		'add_user_spp_id' => $employee_id,
		'subtract' => array('editing_orders_count'),
		'subtract_user_spp_id' => $employee_id,
		'subtract_2' => array('editing_orders_count'),
		'subtract_user_spp_id_2' => $assigned_writer_spp_id,
		'add_2' => array('complete_orders_count'),
		'add_user_spp_id_2' => $assigned_writer_spp_id,
	);
	wad_set_users_order_total_count($args);	
	
	$order_client_first_name = isset($order_info['client']['name_f']) ? $order_info['client']['name_f'] : '';
	$order_client_last_name = isset( $order_info['client']['name_l'] ) ? $order_info['client']['name_l'] : '';
	$order_client_email = $order_info['client']['email'];

	$order_folder_name = explode('_',$order_id);
	$order_folder_name = $order_folder_name[0];

	$post = array(
		'writer_id' => $assigned_writer_spp_id,
		'writer_name' => $assigned_writer_name,
		'writer_email' => $assigned_writer_email,
		'order_id' => $order_id,
		'order_title' => $order_title,
		'order_folder_name' => $order_folder_name
	);
	
	if( $order_client_first_name && $order_client_last_name )
	{
		$post['client_first_name'] = $order_client_first_name;
		$post['client_last_name'] = $order_client_last_name;
		$post['client_first_name_starting_alphabet'] = strtoupper($order_client_first_name[0]);
		$post['client_last_name_starting_alphabet'] = strtoupper($order_client_last_name[0]);
		$post['client_name_alphabat'] = $post['client_last_name_starting_alphabet'];
		$post['client_folder_name'] = $post['client_last_name'] .', '.$post['client_first_name'];
	}
	elseif( $order_client_first_name && ! $order_client_last_name)
	{
		$post['client_first_name'] = $order_client_first_name;
		$post['client_last_name'] = '(empty)';
		$post['client_first_name_starting_alphabet'] = strtoupper($order_client_first_name[0]);
		$post['client_last_name_starting_alphabet'] = '(empty)';
		$post['client_name_alphabat'] = $post['client_first_name_starting_alphabet'];	
		$post['client_folder_name'] = $post['client_first_name'] .', '.$post['client_last_name'];
	}
	else
	{
		$post['client_first_name'] = '(empty)';
		$post['client_last_name'] = '(empty)';
		$post['client_first_name_starting_alphabet'] = '(empty)';
		$post['client_last_name_starting_alphabet'] = '(empty)';
		$post['client_name_alphabat'] = strtoupper($order_client_email[0]);
		$post['client_folder_name'] = $order_client_email;	
	}

	//OLD
	// zap link: https://zapier.com/app/editor/120711013
	// $curl_url = "https://hooks.zapier.com/hooks/catch/8157470/ovnh6qe/";
	
	//NEW
	// zap link: https://zapier.com/app/editor/126595714
	$curl_url = "https://hooks.zapier.com/hooks/catch/8157470/b359pap/";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$curl_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$r = curl_exec($ch);
	
	$current_timestamp = time();
	wad_update_query("orders", "status='{$status}',editor_submit_time='{$current_timestamp}'", "order_id='{$order_id}'");
	
	if( wad_get_option('send_emails') == 'yes' )
	{
		$link_to_OG_new_orders = BASE_URL.'/orders';	
		
		$email_sent = '';
		foreach($assigned_editors as $editor)
		{
			$editor_email = $editor['email'];
			$editor_firstname = wad_get_name_part('first',$editor['name']);
			
			$doc_link = wad_get_order($order_id,'doc_link');
			
			$order_client_first_name = ($post['client_first_name'] == '(empty)') ? 'client' : $post['client_first_name'];
			
			if( $editor_email == 'erynn@wordagents.com' || $editor_email == 'vinci@wordagents.com' )
				continue;
			
			$subject = "Order submitted: {$order_id}";
			$order_link = "https://app.wordagents.com/orders/".$order_id;
			
			$msg = "Hi {{editor_firstname}},<br />Order <a href='{$order_link}'>{{order_title}} - {{order_number}}</a> has been successfully submitted to the client. Thank you!<p>To claim new orders, go to the <a href='{{link_to_OG_new_orders}}'>self-service dashboard</a></p><p>If you need help, contact Chris on Slack or at <a href='mailto:chris@wordagents.com'>chris@wordagents.com</a>.</p>";
	
			$msg = str_replace(
				array("{{editor_firstname}}", "{{order_title}}", "{{order_number}}", "{{link_to_OG_new_orders}}"),
				array($editor_firstname, $order_title, $order_id, $link_to_OG_new_orders),
				$msg
			);
		
 			// NEW EMAIL SMTP-
			$data['subject'] = $subject;
			$data['message'] = $msg;
			$data['to'] = $editor_email;
			// $data['debug'] = 1;
			
			$send_email_response = wad_send_email($data);
			// if( mail($editor_email, $subject, $msg, $headers) ){
			if( $send_email_response == 'sent'){
				wad_create_update_email_counter();
				$email_sent = 1;
			}
		}
		if( $email_sent )
		{
			$from = "WordAgents Dashboard";
			$to = "Assigned Editors excluding Erynn and Vinci";
			wad_save_email_log($from, $to, $subject, $msg, $order_id);
		}
		
		$email_sent = '';
		foreach($assigned_writers as $writer)
		{
			$writer_email = $writer['email'];
			$writer_firstname = wad_get_name_part('first',$writer['name']);

			$subject = "Order complete: {$order_id}";
			$order_link = "https://app.wordagents.com/orders/".$order_id;

			$msg = "Hi {{writer_firstname}},<br />Order <a href='{$order_link}'>{{order_title}} - {{order_number}}</a> is complete and has been submitted to the client. Thank you!<p>To claim new orders, go to the <a href='{{link_to_OG_new_orders}}'>self-service dashboard</a>.</p><p>If you need help, contact <a href='mailto:talent@wordagents.com'>talent@wordagents.com</a></p>";
			
			$msg = str_replace(
				array("{{writer_firstname}}", "{{order_title}}", "{{order_number}}", "{{link_to_OG_new_orders}}"),
				array($writer_firstname, $order_title, $order_id, $link_to_OG_new_orders),
				$msg
			);

			// NEW EMAIL SMTP 
			$data['subject'] = $subject;
			$data['message'] = $msg;
			$data['to'] = $writer_email;
			// $data['debug'] = 1;
			
			$send_email_response = wad_send_email($data);
			// if( mail($employee_email, $subject, $msg, $headers) ){
			if( $send_email_response == 'sent'){
				wad_create_update_email_counter();
				$email_sent = 1;
			}
		}
		if( $email_sent )
		{
			$from = "WordAgents Dashboard";
			$to = "Assigned Writers";
			wad_save_email_log($from, $to, $subject, $msg, $order_id);
		}
		
		$subject = "Your order {$order_id} is ready!";
		$msg = "Hi {{order_client_first_name}},<p>This article is all set for your review! You can find the completed document here: <a href='{{doc_link}}'>{{doc_link}}</a></p><p>If anything was missed, please use the Google Docs comment feature to add feedback directly in the document. Then, on the relevant order page in your Client Portal, click the gray Request Revision button to notify our team.</p>Thank you,<br>{{editor_firstname}}";
		
		$msg = str_replace(
			array("{{editor_firstname}}", "{{order_client_first_name}}", "{{doc_link}}"),
			array($editor_firstname, $order_client_first_name, $doc_link),
			$msg
		);
		
		// NEW EMAIL SMTP
		$data['subject'] = $subject;
		$data['message'] = $msg;
		$data['to'] = $order_client_email;
		// $data['debug'] = 1;
		
		$send_email_response = '';
		// $send_email_response = wad_send_email($data); //uncomment to send email to client
		if( $send_email_response == 'sent')
		{
			wad_create_update_email_counter();

			$from = "WordAgents Dashboard";
			$to = "Client";
			wad_save_email_log($from, $to, $subject, $msg, $order_id);
		}
	}

	header("Location: ".BASE_URL."/orders/complete");
	
} // END - editor_submit_editing_order


if( $action == 'profile_form_submit' )  // profile_form_submit - START
{
	$fullname = $_POST['fullname'];
	$password = $_POST['password'];
	$id = $_POST['id'];	
	
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	$authtoken_hash = password_hash($password, PASSWORD_DEFAULT);
	
	$set = "name='{$fullname}'";
	if( $password )
	$set .= ", password='{$password_hash}', authtoken='{$authtoken_hash}'";
	
	wad_update_query("users", $set, "id='{$id}'");
	
	header("Location: ".BASE_URL."/profile");
	
}   // profile_form_submit - END

if( $action == 'admin_edits_user' )  // admin_edits_user - START
{
	$name = $_POST['name'];
	$email = $_POST['email'];
	$weekly_quota = $_POST['weekly_quota'];
	$spp_id = $_POST['spp_id'];	
	
	$set = "name='{$name}', email='{$email}', weekly_quota='{$weekly_quota}'";
	wad_update_query("users", $set, "spp_id='{$spp_id}'");
	
	header("Location: ".BASE_URL."/admin/users/edit/".$spp_id);
	
}   // admin_edits_user - END

if( $action == 'add_tag' )  // add_tag - START
{
	$order_id = $_REQUEST['order'];
	$employee_id = $_REQUEST['employee'];
	$tags_add = $_REQUEST['tags'];
	$redirect = $_REQUEST['redirect'];
	$from_type = wad_get_user_by_id($employee_id, 'role');
	
	$post = array();
	// $order_info = wad_get_spp_order_info($order_id);
	// $order_tags = $order_info['tags'];
	$order_tags = wad_get_order_tags($order_id);
	$tags = array();
	$i=0;
	if( sizeof($order_tags) )
	{
		foreach($order_tags as $tag){
			$tags["tags[".$i."]"] = $tag;
			$i++;
		}
	}
	
	foreach($tags_add as $tag){
		$tags["tags[".$i."]"] = $tag;
		$i++;
	}
	
	$post = array_merge($post, $tags);

	wad_spp_update_order($order_id, $post);
	
	wad_add_update_tags_to_order($order_id, $tags_add);
	
	if( in_array("Final Review", $tags_add) ){
		wad_insert_query( "order_final_review",
			array( "from_type", "from_id", "order_id", "time"),
			array( $from_type, $employee_id, $order_id, time())
		);
	}
	
	/* if( in_array("Editor Revision", $tags_add) ){
		wad_insert_query( "order_editor_revision",
			array( "from_type", "from_id", "order_id", "time"),
			array( $from_type, $employee_id, $order_id, time())
		);
	} */

	if( wad_get_option('save_log') == 'yes' )
	{
		foreach($tags_add as $tag)
		{
			wad_insert_query( "logs",
				array( "from_type", "from_id", "action", "source", "source_id", "time", "data"),
				array( "system", $employee_id, "Added tag", "order", $order_id, time(), $tag)
			);
		}
	}

	header("Location: ".$redirect);
	
}   // add_tag - END


//Remove tag
if( $action == "remove_tag" )
{
	$order_id = $_REQUEST['order'];
	$employee_id = $_REQUEST['employee'];
	$tag_delete = $_REQUEST['tag_delete'];
	$from_type = wad_get_user_by_id($employee_id, 'role');
	
	$post = $tags = array();

	$order_tags = wad_get_order_tags($order_id);

	$i=0;
	if( sizeof($order_tags) )
	{
		foreach($order_tags as $tag){
			if( $tag == $tag_delete )
				continue;
			
			$tags["tags[".$i."]"] = $tag;
			$i++;
		}
	}
	
	if( empty($tags) ){
		$tags["tags[]"] = '';
	}
	
	$post = array_merge($post, $tags);
	
	wad_spp_update_order($order_id, $post);
	
	wad_delete_order_tags($order_id,array($tag_delete),$order_tags);
	
	if( wad_get_option('save_log') == 'yes' )
	{
		wad_insert_query( "logs",
			array( "from_type", "from_id", "action", "source", "source_id", "time", "data"),
			array( $from_type, $employee_id, "Removed tag", "order", $order_id, time(), $tag_delete)
		);
	}
	
}

//Remove tag - END

if( $action == "sign_in_as_user_using_admin" )
{
	$user_spp_id = $_REQUEST['user'];
	$admin_spp_id = wad_get_current_user('spp_id');
	
	$user = wad_get_user_by_id($user_spp_id); 
	
	setCookie('wad_admin_logged_in_as_user',true, strtotime( '+10 years' ));
	setCookie('wad_admin_logged_in_spp_id',openssl_encrypt($admin_spp_id, "AES-128-ECB", SECURE_KEY), strtotime( '+10 years' ));
	
	setCookie('wad_user_logged_in_spp_id',$user['spp_id'], strtotime( '+10 years' ));
	
	header("Location: ".BASE_URL);
	
}

if( $action == "back_to_admin" )
{
	setCookie('wad_admin_logged_in_as_user',false, strtotime( '+10 years' ));
	setCookie('wad_admin_logged_in_spp_id',false, strtotime( '+10 years' ));
	
	setCookie('wad_user_logged_in_spp_id',$_COOKIE['wad_admin_logged_in_spp_id'], strtotime( '+10 years' ));
	
	header("Location: ".BASE_URL."/admin");
	exit;
	
}
