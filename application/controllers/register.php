<?php

class Register extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('users');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->view('signup');
	}
	
        function sign_up(){
            $this->load->view('signup');
        }
        function temp_signup()
	{
		$this->load->library('form_validation');
		$this->load->database();
		
		$config = array(
				array(
					'field' => 'username',
					'label' => 'Username',
					'rules' => 'trim|required|min_length[4]|max_length[12]|xss_clean|alpha_numeric|is_unique[users.username]|is_unique[temp_users.username]'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required|min_length[5]|max_length[50]|xss_clean|matches[passconf]|md5'
				),
				array(
					'field' => 'passconf',
					'label' => 'PasswordConfirmation',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email'
				)
		);
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('signup');
		}
		else
		{
			$conf_code = md5(uniqid(rand(), true));
			$this->load->library('email');

			$this->email->from('collaborator', 'Collaborator');
			$this->email->to($this->input->post('email')); 
			
			$this->email->subject('Account confirmation');
			$message = "To confirm your account, click on the following link: http://localhost/taskmanager/index.php/register/confirm_account/".$conf_code;
			$this->email->message($message);	

			$this->email->send();

			$this->users->add_temp_user($conf_code);

		}
	}
	
	function confirm_account($conf_code)
	{
		if($this->users->add_user($conf_code))
		{
			echo "Account created.";
		}
		else
		{
			echo "Sorry this link has expired.";
		}
	}
}
?>