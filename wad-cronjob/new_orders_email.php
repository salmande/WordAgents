<?php

if( wad_get_option('send_emails') == 'yes' ){
	
	wad_send_new_created_orders_email();
	wad_send_new_submitted_orders_email();
	
}

?>