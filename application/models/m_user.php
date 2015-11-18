<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class M_user extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', true);
	}

	function ceklogin($un='',$pass=''){
					$pass 	=sha1($pass);
			$this->db->where("(email = '$un' OR uname = '$un') AND pass= '$pass'");
			$query = $this->db->get('members',1);
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $value) {
					$send = array(
						'id'=>$value->id,
						'uname' => $value->uname, 
						'idj'=>$value->idjbtn,
						'acc'=>$value->acc
						);
				}
				return $send;
			}else{
				return false;
			}
	}
	function cekmin(){
		$query=$this->db->get('members');
		if ($query->num_rows() > 0) {
			return false;
		}else{
			return true;
		}
	}
	function userdata(){
		if($userdata=$this->session->userdata('logged_in')){
			return $this->db->get_where('members',array('id'=>$userdata['id']))->result_array();			
		}
	}
}
?>