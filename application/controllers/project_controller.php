<?php
include_once(dirname(__FILE__)."/Discussion_controller.php");
class Project_controller extends Discussion_controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('users');
        $this->load->model('activity');
        $this->load->model('project');
	$this->load->library('session');
	$this->load->library('form_validation');
    $this->load->helper('url');

    }
    
    function new_project(){
        $data['username'] = $this->session->userdata('username');
        if($this->users->check_user_loggedin()){
            $data['error_msg'] = "";
            $this->load->view('project_form', $data);
        }
    }
    
    function create_project(){
        if($this->users->check_user_loggedin()){
            $data['username'] = $this->session->userdata('username');
            $config = array(
				array(
					'field' => 'title',
					'label' => 'Title',
					'rules' => 'trim|required|min_length[4]|max_length[20]|xss_clean|alpha_numeric'
				),
				array(
					'field' => 'description',
					'label' => 'Description',
					'rules' => 'trim|required|min_length[5]|max_length[100]|xss_clean|alpha_numeric'
				),
		);
            $this->form_validation->set_rules($config);
		
            if ($this->form_validation->run() == FALSE){
                $data['error_msg'] = "";
		$this->load->view('project_form', $data);
            }
            else{
                 $result = $this->project->add_project(); 
                 if($result){
                    $this->my_projects();
                 }
                else{
                    $data['error_msg'] = "You have previously created a project with the same title. Please enter a different title";
                    $this->load->view('project_form', $data);
                }
            }
        }        
    }
    
    //to fetch the projects list and display the projects page
    
    function my_projects(){
        if($this->users->check_user_loggedin()){
            $data['username'] = $this->session->userdata('username');
            $data['projects'] = $this->project->get_projects();
            $this->load->view('welcome',$data);
        }
    }
    
    //to fetch project info according to project id
    
    function open_project($project_id){
        if($this->users->check_user_loggedin()){
            $data['project_info'] = $this->project->get_projects($project_id);
            if(!$data['project_info']){
                echo 'sorry, project not found';
            }
            else{
                $data['username'] = $this->session->userdata('username');
                if($this->session->userdata('username')== $data['project_info']['admin']){
                    $data['previlage'] = 'admin';
                }
                elseif($this->session->userdata('username')== $data['project_info']['leader']){
                    $data['previlage'] = 'leader';
                }
                else{
                    $data['previlage'] = 'dev';
                }
                $data1=$this->topics($project_id);
                if($data1['error_msg'])
                    $data['error_msg']=$data1["error_msg"];
                $data['topics']=$data1['topics'];
                $data['project_id']=$data1['project_id'];
                
                //$this->open_project($project_id);
                $data2=$this->task_listproj($project_id);
                $data['project_id']=$data2["project_id"];
                $data['ind']=$data2['ind'];
                $data['task_list']=$data2['task_list'];
                $data3=$this->get_activitiesproj($project_id);
                $data['activities']=$data3['activities'];
                $this->load->view('individual_project',$data);
            }
        }
    }

    //to add leader to project, mails invite to user, and stores info in invites
    
    function invite_leader($project_id){
        if($this->users->check_user_loggedin()){
        $data['flagd']=0;
            $data['flagl']=1; 
            $data['username'] = $this->session->userdata('username');       
            $project_data = $this->project->get_projects($project_id);
            if(!$project_data){
                $data['error_msg'] = "sorry, project not found";
                $this->load->view('error',$data);
            }
            else{
                if(!isset($project_data['leader'])){
                    $data['error_msg']="";
                    $data['url']="http://localhost/taskmanager/index.php/project_controller/invite_leader/".$project_id;
                    $config = array(
                                        array(
                        			'field' => 'user',
                        			'label' => 'Username',
                        			'rules' => 'trim|required|min_length[4]|max_length[12]|xss_clean|alpha_numeric'
                                             )
                                    );
                    $this->form_validation->set_rules($config);
		
                    if ($this->form_validation->run() == FALSE){
                        $data['error_msg'] = "";
                        $this->load->view('invite',$data);
                    }
                    else{
                        if($project_data['admin'] != $this->session->userdata('username')){
                            $data['error_msg'] = "You do not have permission to access this page";
                            $this->load->view('error',$data);
                        }
                        else{
                            $invited = $this->project->check_invite($project_id,'lead');
                            if($invited){
                                $data['error_msg'] = "An invitation has already been sent to the user";
                                $this->load->view('error',$data);
                            }
                            else{
                                $user = $this->users->check_user_exists();
                                if($user != FALSE){
                                    $conf_code = md5(uniqid(rand(), true));
                                    $this->load->library('email');

                                    $this->email->from('collaborator', 'Collaborator');
                                    $this->email->to($user['email']); 
			
                                    $this->email->subject('Invitation to join '.$project_data['title']);
                                    $message = "You have been invited as a developer for ".$project_data['title']." by ".$this->session->userdata('username').".To accept invitation click on the following link: http://localhost/taskmanager/index.php/users_controller/accept_invite/".$conf_code." . To decline please click on http://localhost/taskmanager/index.php/users_controller/decline_invite/".$conf_code;
                                    $this->email->message($message);	

                                    $this->email->send();

                                    $this->project->add_invite($project_id,$conf_code,'lead');
                                    $this->activity->add_activity($project_id,$this->session->userdata('username').' invited '.$this->input->post('user').' to '.$project_data['title'],  $this->session->userdata('username'));
                                }
                                else{
                                    $data['error_msg'] = "The username you entered does not exist";
                                    $this->load->view('invite',$data);
                                }
                            }
                        
                        }
                    }
                }
                else{
                    $data['error_msg'] = "The user is already a developer of the project";
                    $this->load->view('error',$data);
                }
            }
        }
    }
    
    //to invite developers to project
    
    function invite_developer($project_id){
        if($this->users->check_user_loggedin()){
            $data['flagd']=1;
            $data['flagl']=0;
            $data['username'] = $this->session->userdata('username');
            $project_data = $this->project->get_projects($project_id);
            if(!$project_data){
                $data['error_msg'] = "sorry, project not found";
                $this->load->view('error',$data);
            }
            else{
                    $data['error_msg']="";
                    $data['url']="http://localhost/taskmanager/index.php/project_controller/invite_developer/".$project_id;
                    $config = array(
                                        array(
                        			'field' => 'user',
                        			'label' => 'Username',
                        			'rules' => 'trim|required|min_length[4]|max_length[12]|xss_clean|alpha_numeric'
                                             )
                                    );
                    $this->form_validation->set_rules($config);
		
                    if ($this->form_validation->run() == FALSE){
                        $data['error_msg'] = "";
                        $this->load->view('invite',$data);
                    }
                    else{
                        if($project_data['admin'] != $this->session->userdata('username') && $project_data['leader'] != $this->session->userdata('username')){
                            $data['error_msg'] = "You do not have permission to access this page";
                            $this->load->view('error',$data);
                        }
                        else{
                            $user = $this->users->check_user_exists();
                            if($user != FALSE){
                                $val = stripos($project_data['developers'],'/'.$this->input->post('user').'/');
                                if($val ==FALSE){
                                    $invited = $this->project->check_invite($project_id,'dev');
                                    if($invited){
                                        $data['error_msg'] = "An invitation has already been sent to the user";
                                        $this->load->view('error',$data);
                                    }
                                    else{
                                        $conf_code = md5(uniqid(rand(), true));
                                        $this->load->library('email');

                                        $this->email->from('collaborator', 'Collaborator');
                                        $this->email->to($user['email']); 
			
                                        $this->email->subject('Invitation to join '.$project_data['title']);
                                        $message = "You have been invited to be the project leader of ".$project_data['title']." by ".$this->session->userdata('username').".To accept invitation click on the following link: http://localhost/taskmanager/index.php/project_controller/accept_invite/".$conf_code." . To decline please click on http://localhost/taskmanager/index.php/project_controller/decline_invite/".$conf_code;
                                        $this->email->message($message);	

                                        $this->email->send();

                                        $this->project->add_invite($project_id,$conf_code,'dev');
                                        $this->activity->add_activity($project_id,$this->session->userdata('username').' invited '.$this->input->post('user').' to be a developer of '.$project_data['title'],  $this->session->userdata('username'));
                                    }
                                }
                                else{
                                    $data['error_msg'] = "user is already a developer of the project";
                                    $this->load->view('error',$data);
                                }                      
                            }
                            else{
                                        $data['error_msg'] = "The username you entered does not exist";
                                        $this->load->view('invite',$data);
                            }                        
                      }
                  }
              }
         }
    }


    //accept invitation jo join the project

    function accept_invite($conf_code){
        $data['msg'] = $this->project->accept_invite($conf_code);
        $this->load->view('invitation',$data);
        
    }
    
    //decline invitation to join project
    
    function decline_invite($conf_code){
        $data['msg'] = $this->project->decline_invite($conf_code);
        $this->load->view('invitation',$data);
    }
    
    //remove leader
    
    function remove_leader($project_id){
        if($this->users->check_user_loggedin()){
            $project_data = $this->project->get_projects($project_id);
            if($this->project->delete_leader($project_id)){
                $this->open_project($project_id);
                $this->activity->add_activity($project_id,$this->session->userdata('username').' removed '.$project_data['leader'].' to be a leader of '.$project_data['title'],  $this->session->userdata('username'));
            }
            else{
                $data['error_msg'] = 'sorry,you have no permission to access this page';
                $this->load->view('error',$data);
            }
        }
    }
    
    //remove developers
    
    function remove_developer($developer,$project_id){
        $project_data = $this->project->get_projects($project_id);
        if($this->users->check_user_loggedin()){
            if($this->project->delete_developer($project_id,$developer)){
                $this->open_project($project_id);
                 $this->activity->add_activity($project_id,$this->session->userdata('username').' removed '.$project_data['developers'].' to be a developers of '.$project_data['title'],  $this->session->userdata('username'));
            }
            else{
                $data['error_msg'] = 'sorry,you have no permission to access this page';
                $this->load->view('error',$data);
            }
        }
    }
    function get_activitiesproj($project_id = NULL){
        if($this->users->check_user_loggedin()){
            $data['activities'] = $this->activity->get_activity_list($project_id);
            $data['username'] = $this->session->userdata('username');
            if(!$data['activities']){
                $data['error_msg'] = 'Sorry you have no permission to access this page.';
                $this->load->view('error',$data);
            }
            else{
                return $data;
                //$this->load->view('activity',$data);
            }
        }
    }
}
?>
