<?php

class Users extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
        
        function check_user_loggedin(){
            if($this->session->userdata('username') == FALSE || $this->session->userdata('email') == FALSE){
                header('Location: http://localhost/taskmanager');
                return FALSE;
            }
            else{
                return TRUE;
            }
        }
        
        //returns mail id if user exists, otherwise FALSE
        
        function check_user_exists(){
            $this->db->select('email');
            $query = $this->db->get_where('users',array('username' => $this->input->post('user')));
            if($query->num_rows()==0){
                return FALSE;
            }
            else{
                return $query->row_array();
            }
        }

        function add_temp_user($conf_code)			//add user details along with confirmation code to temp_users
	{
		$values = array(	
							'username'	=> $this->input->post('username'),
							'password'	=> $this->input->post('password'),
							'email'		=> $this->input->post('email'),
							'conf_code'	=> $conf_code
						);
						
		$this->db->insert('temp_users', $values);
	}
	
	function add_user($conf_code)		//confirm mail and register user
	{
		$query = $this->db->get_where('temp_users', array( 'conf_code' => $conf_code ));
		if($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			$result = $query->row();
			$values = array(	
							'username'	=> $result->username,
							'password'	=> $result->password,
							'email'		=> $result->email
						);
						
			$this->db->insert('users', $values);
			$this->db->delete('temp_users', array('conf_code' => $conf_code)); 
			return TRUE;
		}
	}
        
        //login function
        
        function login(){
            $query = $this->db->get_where('users', array( 'username' => $this->input->post('username'),
                                                          'password' => $this->input->post('password')
                                            ));
            if($query->num_rows() == 0){
                return FALSE;
            }
            else {
                $result = $query->row_array();
                return $result;
            }
        }
        function update_profile_pic($data){
            $this->db->update('users',array('profile_pic'=>$data['file_name']),array('username' => $this->session->userdata('username')));
        }
        
        
}
?>