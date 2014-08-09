<?php

class Todo_controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('todo_model');
                $this->load->model('users');
                $this->load->model('activity');
                $this->load->model('project');
                $this->load->helper('url');
	}
	
        function add_task($project_id){
            if($this->users->check_user_loggedin()){
                $data['username'] = $this->session->userdata('username');
                $config = array(
                                    array(
					'field' => 'title',
					'label' => 'Title',
					'rules' => 'trim|required|min_length[4]|max_length[100]|xss_clean'
                                    ),
                                    array(
					'field' => 'description',
					'label' => 'Title',
					'rules' => 'trim|required|min_length[4]|max_length[500]|xss_clean'
                                    ),
                                    array(
					'field' => 'deadline',
					'label' => 'Deadline',
					'rules' => 'trim|min_length[10]|max_length[10]|xss_clean'
                                    )
                            );
                $this->form_validation->set_rules($config);
		
                if ($this->form_validation->run() == FALSE){                    
                    $data['members'] = $this->project->get_members($project_id);
                    if($data['members']!=FALSE){
                        $data['project_id'] = $project_id;
                        $this->load->view('task_form',$data);
                    }
                    else{
                        $data['error_msg']="sorry,you can't access this page";
                        $this->load->view('error',$data);
                    }
                }
                else{
                    $this->todo_model->add_todo($project_id);
                    $this->task_list($project_id);
                }
            }            
        }
        //To display in project page
        function task_listproj($project_id = NULL){
            if($this->users->check_user_loggedin()){
                $data['username'] = $this->session->userdata('username');
                $data['project_id'] = $project_id;
                $data['task_list'] = $this->todo_model->get_task_list($project_id);
                if($data['task_list'] != "no_access"){
                    if($project_id == NULL){
                        $data['ind'] = FALSE;
                    }
                    else{
                        $data['ind'] = TRUE;
                    }
                    return $data;
                    //$this->load->view('project_tasks',$data);
                }
                else{
                    $data['error_msg'] = "you have no permission to access this page";
                    $this->load->view('error',$data);
                }
            }
        }
        function task_list($project_id = NULL){
            if($this->users->check_user_loggedin()){
                $data['username'] = $this->session->userdata('username');
                $data['project_id'] = $project_id;
                $data['task_list'] = $this->todo_model->get_task_list($project_id);
                if($data['task_list'] != "no_access"){
                    if($project_id == NULL){
                        $data['ind'] = FALSE;
                    }
                    else{
                        $data['ind'] = TRUE;
                    }
                    //return $data;
                    $this->load->view('project_tasks',$data);
                }
                else{
                    $data['error_msg'] = "you have no permission to access this page";
                    $this->load->view('error',$data);
                }
            }
        }
        
        function remove_todo($task_id,$project_id){
            $remove = $this->todo_model->delete_task($task_id);
            if($remove){
                $this->task_list($project_id);
            }
            else {
                $data['error_msg'] = 'You have no permission to access this page';
                $this->load->view('error',$data);
            }
        }
	
}
?>