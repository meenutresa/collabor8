<?php
include_once (dirname(__FILE__) . "/todo_controller.php");

class Discussion_controller extends todo_controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
	$this->load->model('discussion');
        $this->load->model('users');
        $this->load->helper('url');
    } 
    
    //diaplay and add topics
    
    function topics($project_id){
        if($this->users->check_user_loggedin()){
            $data['error_msg']="";
                $config = array(
                                    array(
					'field' => 'topic',
					'label' => 'Topic',
					'rules' => 'trim|required|min_length[1]|max_length[100]|xss_clean'
                                    )
                            );
                $this->form_validation->set_rules($config);
		
                if ($this->form_validation->run() == FALSE){                    
                    $data['topics'] = $this->discussion->get_topics($project_id);
                    if($data['topics']!=FALSE){
                        $data['project_id'] = $project_id;
                        return $data;
                        //$this->load->view('topic',$data);
                    }
                    else{
                        $data['error_msg']="sorry,you can't access this page";
                        $this->load->view('error',$data);
                        //return $data;
                    }
                }
                else{
                    $this->discussion->add_topic($project_id);
                    $data['topics'] = $this->discussion->get_topics($project_id);
                    $data['project_id'] = $project_id;
                    //$this->load->view('topic',$data);
                    return $data;                    
                }
            }
    }
    
    //discussion page
    
    function comments($project_id,$topic_id){
        if($this->users->check_user_loggedin()){
            $data['username'] = $this->session->userdata('username');
            $data['topic']=$this->discussion->get_spec_topics($project_id,$topic_id);
                $config = array(
                                    array(
					'field' => 'comment',
					'label' => 'Comment',
					'rules' => 'trim|required|min_length[1]|max_length[100]|xss_clean'
                                    )
                            );
                $this->form_validation->set_rules($config);
		
                if ($this->form_validation->run() == FALSE){                    
                    $data['comments'] = $this->discussion->get_comments($project_id,$topic_id);
                    // $data['topic']=$this->discussion->get_spec_topics($project_id,$topic_id);
                    if($data['comments']!=FALSE){
                        $data['project_id'] = $project_id;
                        $data['topic_id'] = $topic_id;
                        $this->load->view('comments',$data);
                    }
                    else{
                        $data['error_msg']="sorry,you can't access this page";
                        $this->load->view('error',$data);
                    }
                }
                

                else{
                    $this->discussion->add_comment($project_id,$topic_id);
                    $data['comments'] = $this->discussion->get_comments($project_id,$topic_id);
                    //$data['topic']=$this->discussion->get_spec_topics($project_id,$topic_id);
                    $data['project_id'] = $project_id;
                    $data['topic_id'] = $topic_id;
                    
                    $this->load->view('comments',$data);
                }

            }
    }
   /* function ajax() {

    $data['comments'] = $this->discussion->get_comments($project_id,$topic_id);
    if ( $this->input->is_ajax_request() ) { 
        $this->load->view('test/names_list', $data);
    } else {
        $this->load->view('test/default', $data);
    }*/
}
?>
