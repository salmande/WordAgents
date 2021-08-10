<?php
$action = ( isset($_REQUEST['action']) && $_REQUEST['action'] ) ? $_REQUEST['action'] : '';

//zap link: https://zapier.com/app/editor/120703586
if( $action == 'wad_zaiper_created_google_doc')  // wad_zaiper_created_google_doc - START
{
	$doc_link = $_POST['doc_link'];
	$order_id = $_POST['order_id'];
	
	$doc_link = str_replace(array('drive','file'), array('docs','document'),$doc_link);
	
	wad_update_query("orders", "doc_link='{$doc_link}'", "order_id='{$order_id}'");
	
	if( wad_get_option('save_log') == 'yes' )
	{
		wad_insert_query( "logs",
			array( "from_type", "action", "source", "source_id", "time", "data"),
			array( "System", "google doc created", "order", $order_id, time(), $doc_link)
		);
	}
}
?>