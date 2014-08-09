<?php

class Fb extends CI_Controller {

    function __construct()
    {
      	parent::__construct();
		$this->load->model('facebook_user');
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->library('session');
    }

	function index()
        {
		if($this->facebook_user->check_user_logged_in())
		{
			$info = $this->facebook_user->check_user_exists();
			if(!$info == FALSE)
			{
				$this->session->set_userdata('username', $info['username']);
				$this->session->set_userdata('email', $info['email']); 
                                $this->load->view('welcome',$info);
			}
			else
			{
				$this->facebook_user->add_user();
				$info = $this->facebook_user->check_user_exists();
                                $this->session->set_userdata('username', $info['username']);
				$this->session->set_userdata('email', $info['email']);
                                $this->load->view('welcome',$info);
			}
			
		}
		else	
		{
			$login_url = $this->facebook_user->get_login_url();
			echo 'Please <a href="' . $login_url . '">login.</a>';

		}
          }
	   
	public function logout()
        {
		$this->facebook_user->logout_fb();
		index();
        }
}
?>