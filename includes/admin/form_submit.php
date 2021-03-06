<?php 
// no direct access!
defined('ABSPATH') or die("No direct access");

global $wpdb;
$id = (int) $_POST['id'];
$task = isset($_REQUEST['task']) ? $_REQUEST['task'] : '';

$sql = "SELECT COUNT(id) FROM ".$wpdb->prefix."cfg_forms";
$count_forms = $wpdb->get_var($sql);

if($count_forms >= 1 && $id == 0) {
	$redirect = "admin.php?page=cfg_forms&error=1";
	header("Location: ".$redirect);
	exit();
}

if($id == 0) {
	$sql = "SELECT MAX(`ordering`) FROM `".$wpdb->prefix."cfg_forms`";
	$max_order = $wpdb->get_var($sql) + 1;
	
	$wpdb->query( $wpdb->prepare(
			"
			INSERT INTO ".$wpdb->prefix."cfg_forms
			( 
				`name`, `top_text`, `pre_text`, `thank_you_text`, `send_text`, `send_new_text`, `close_alert_text`, `form_width`, `id_template`, `redirect`, `redirect_itemid`, `redirect_url`, `redirect_delay`, `send_copy_enable`, `send_copy_text`, `email_to`, `email_bcc`, `email_subject`, `email_from`, `email_from_name`,  `email_replyto`, `email_replyto_name`, `shake_count`, `shake_distanse`, `shake_duration`,  `published`, `ordering`, `show_back`,`custom_css`,`email_info_show_referrer`,`email_info_show_ip`,`email_info_show_browser`,`email_info_show_os`,`email_info_show_sc_res`
			)
			VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %d, %s, %d, %s, %d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d, %d, %d, %d, %d, %s, %s, %d, %d, %d, %d, %d )
			",
			$_POST['name'], $_POST['top_text'], $_POST['pre_text'], $_POST['thank_you_text'], $_POST['send_text'], $_POST['send_new_text'], $_POST['close_alert_text'], $_POST['form_width'], $_POST['id_template'], $_POST['redirect'], $_POST['redirect_itemid'], $_POST['redirect_url'], $_POST['redirect_delay'], $_POST['send_copy_enable'], $_POST['send_copy_text'], $_POST['email_to'], $_POST['email_bcc'], $_POST['email_subject'], $_POST['email_from'], $_POST['email_from_name'], $_POST['email_replyto'], $_POST['email_replyto_name'], $_POST['shake_count'], $_POST['shake_distanse'], $_POST['shake_duration'], $_POST['published'], $max_order, $_POST['show_back'], $_POST['custom_css'], $_POST['email_info_show_referrer'], $_POST['email_info_show_ip'], $_POST['email_info_show_browser'], $_POST['email_info_show_os'], $_POST['email_info_show_sc_res']
	) );

			
	
	$insrtid = (int) $wpdb->insert_id;
	if($insrtid != 0) {
		if($task == 'save')
			$redirect = "admin.php?page=cfg_forms&act=edit&id=".$insrtid;
		elseif($task == 'save_new')
			$redirect = "admin.php?page=cfg_forms&act=new";
		else
			$redirect = "admin.php?page=cfg_forms";
	}
	else
		$redirect = "admin.php?page=cfg_forms&error=1";
}

if($id != 0 && $task != 'save_copy') {
	$q = $wpdb->query( $wpdb->prepare(
			"
			UPDATE ".$wpdb->prefix."cfg_forms
			SET
				`name` = %s, `top_text` = %s, `pre_text` = %s, `thank_you_text` = %s, `send_text` = %s, `send_new_text` = %s, `close_alert_text` = %s, `form_width` = %s, `id_template` = %d, `redirect` = %s, `redirect_itemid` = %d, `redirect_url` = %s, `redirect_delay` = %d, `send_copy_enable` = %s, `send_copy_text` = %s, `email_to` = %s, `email_bcc` = %s, `email_subject` = %s, `email_from` = %s, `email_from_name` = %s, `email_replyto` = %s, `email_replyto_name` = %s, `shake_count` = %d, `shake_distanse` = %d, `shake_duration` = %d, `published` = %d, `show_back` = %s, `custom_css` = %s, `email_info_show_referrer` = %d, `email_info_show_ip` = %d, `email_info_show_browser` = %d, `email_info_show_os` = %d, `email_info_show_sc_res` = %d 
			WHERE
				`id` = '".$id."'
			",
			$_POST['name'], $_POST['top_text'], $_POST['pre_text'], $_POST['thank_you_text'], $_POST['send_text'], $_POST['send_new_text'], $_POST['close_alert_text'], $_POST['form_width'], $_POST['id_template'], $_POST['redirect'], $_POST['redirect_itemid'], $_POST['redirect_url'], $_POST['redirect_delay'], $_POST['send_copy_enable'], $_POST['send_copy_text'], $_POST['email_to'], $_POST['email_bcc'], $_POST['email_subject'], $_POST['email_from'], $_POST['email_from_name'], $_POST['email_replyto'], $_POST['email_replyto_name'], $_POST['shake_count'], $_POST['shake_distanse'], $_POST['shake_duration'], $_POST['published'], $_POST['show_back'], $_POST['custom_css'], $_POST['email_info_show_referrer'], $_POST['email_info_show_ip'], $_POST['email_info_show_browser'], $_POST['email_info_show_os'], $_POST['email_info_show_sc_res']
	) );
	if($q !== false) {
		if($task == 'save')
			$redirect = "admin.php?page=cfg_forms&act=edit&id=".$id;
		elseif($task == 'save_new')
			$redirect = "admin.php?page=cfg_forms&act=new";
		else
			$redirect = "admin.php?page=cfg_forms";
	}
	else
		$redirect = "admin.php?page=cfg_forms&error=1";
}

header("Location: ".$redirect);
exit();
?>