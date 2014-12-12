<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logins extends CI_Controller {

	public function index()
	{
		$this->load->view('login_view');
	}
	public function validate()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$sendToDB = array('email' => $email, 'password' => $password);
		$this->load->model('login');
		$pwCheck = $this->login->validate($sendToDB);
		if($pwCheck){
			$this->session->set_userdata('id', 1);
			redirect('orders');
		}
		else {
		redirect('logins');
		}
	}
	public function logOut(){
        $this->session->sess_destroy();
        redirect('/');
    }
}
/* End of file logins.php */
/* Location: ./application/controllers/logins.php */