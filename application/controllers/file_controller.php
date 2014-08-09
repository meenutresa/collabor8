<?php

class File_controller extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('users');
        $this->load->model('files');
	$this->load->library('session');
	$this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('url');
    }
    
    function files_list($project_id){
        if($this->users->check_user_loggedin()){
            $data['username'] = $this->session->userdata('username');
            $data['list'] = $this->files->get_files($project_id);
            if($data['list'] == 'no_access'){
                $data['error_msg'] = "You are not allowed to access this page";
                $this->load->view('error',$data);
            }
            else{
                $data['project_id']=$project_id;
                $this->load->view('files',$data);
            }
        }
    }
    
    function do_upload($project_id)
	{
                if($this->users->check_user_loggedin()){
                    $username = $this->session->userdata('username');
                    
		$config['upload_path'] = 'C:/wamp/www/taskmanager/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|txt';
		//$config['max_size']	= '100';
		$config['max_width']  = '0';
		$config['max_height']  = '0';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors(),'username'=>$username);
                        $error['project_id'] = $project_id;
			$this->load->view('upload_files', $error);
		}
		else
		{

			$data = array('upload_data' => $this->upload->data(),'username'=>$username);
                        if($this->files->add_files($project_id,$data['upload_data'])){
                            $this->files_list($project_id);
                        }
                        else{
                            $data['error_msg'] = "You are not allowed to access this page";
                            $this->load->view('error',$data);
                        }
			//$this->load->view('upload_success', $data);
                        
		}
                }
	}
}
?>
