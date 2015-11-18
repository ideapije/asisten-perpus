<?php defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
ob_start();
function kirim($msg=array())
{
		$CI =& get_instance();
		$CI->db = $CI->load->database('default', true);
		$data = array('DestinationNumber'=>$msg['nohp'], 'SenderID'=>$msg['modem'], 'TextDecoded'=>$msg['pesan'], 'CreatorID'=>'Gammu 1.28.90');
		$query=$CI->db->insert('outbox',$data);
		if ($query) {
			return true;
		}else{
			return true;
		}
}
?>
	
