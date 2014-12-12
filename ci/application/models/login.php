<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Model {

	public function validate($received)
	{
		$query = "SELECT password, email FROM admins WHERE email = ?";
		$value = $received['email'];
		$results = $this->db->query($query, $value)->row_array();
		if($results){
			//email exists, check password match
			if($received['password'] == $results['password'])
				return TRUE;
			//email exists but password does not match
			else{
				$this->session->set_flashdata('msg', 'The email does not match the password.');
				return FALSE;
			}
		}
		else {
			//email doesn't exist
			$this->session->set_flashdata('msg', 'The email does not match the password.');
			return FALSE;
		}
	}
}
/* End of file login.php model */
/* Location: ./application/model/login.php */