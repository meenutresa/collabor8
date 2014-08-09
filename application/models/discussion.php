<?php

class Discussion extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('activity');
    }
    
    //add a topic for discussion to project
    
    function add_topic($project_id){
        $query = $this->db->query("select title from projects where project_id = '".$project_id."' and (admin = '".$this->session->userdata('username')."' or leader = '".$this->session->userdata('username')."' or developers like '%/".$this->session->userdata('username')."/%')");
        $values = array(
                          'project_id'    => $project_id,
                          'topic'         => $this->input->post('topic'),
                          'username'      => $this->session->userdata('username')
        );
        $this->db->insert('topics',$values);
        $query = $query->row_array();
        $this->activity->add_activity($project_id,  $this->session->userdata('username')." created a discussion topic ".$this->input->post('topic')." in ".$query['title'],  $this->session->userdata('username'));
        
    }
    
    //add comment to topic
    
    function add_comment($project_id,$topic_id){
        $result = $this->db->query("select title from projects where project_id = '".$project_id."' and (admin = '".$this->session->userdata('username')."' or leader = '".$this->session->userdata('username')."' or developers like '%/".$this->session->userdata('username')."/%')");
        if($result->num_rows()== 0){
             return FALSE;
        }
        else{
            $result = $result->row_array();
            $query = $this->db->get_where('topics',array('project_id' => $project_id, 'topic_id' => $topic_id));
            if($query->num_rows() == 0){
                return FALSE;
            }
            else{
                $values = array(
                                    'project_id'=> $project_id,
                                    'topic_id'  => $topic_id,
                                    'comment'   => $this->input->post('comment'),
                                    'username'  => $this->session->userdata('username')
                );
                $this->db->insert('comments',$values);
                $query = $query->row_array();
                $this->activity->add_activity($project_id,  $this->session->userdata('usernaeme')." commented on topic ".$query['topic']." in ".$result['title'],  $this->session->userdata('username'));
            }
        }        
    }
    
    //get all topics
    
    function get_topics($project_id){
        $result = $this->db->query("select title from projects where project_id = '".$project_id."' and (admin = '".$this->session->userdata('username')."' or leader = '".$this->session->userdata('username')."' or developers like '%/".$this->session->userdata('username')."/%')");
        if($result->num_rows()== 0){
             return FALSE;
        }
        else{
            $query = $this->db->query("select users.*,topics.* from users,topics where users.username=topics.username and topics.project_id = '".$project_id."'");
            if($query->num_rows()==0){
                return "no_topics";
            }
            else {
                return $query->result();
            }
        }
    }

    //get a topic
    function get_spec_topics($project_id,$topic_id){
        $result = $this->db->query("select title from projects where project_id = '".$project_id."' and (admin = '".$this->session->userdata('username')."' or leader = '".$this->session->userdata('username')."' or developers like '%/".$this->session->userdata('username')."/%')");
        if($result->num_rows()== 0){
             return FALSE;
        }
        else{
            $query = $this->db->query("select topic from topics where project_id = '".$project_id."' and topic_id='".$topic_id."'");
            if($query->num_rows()==0){
                return "no_topics";
            }
            else {
                return $query->result();
            }
        }
    }
    
    //get comments
    
    function get_comments($project_id,$topic_id){
        $result = $this->db->query("select title from projects where project_id = '".$project_id."' and (admin = '".$this->session->userdata('username')."' or leader = '".$this->session->userdata('username')."' or developers like '%/".$this->session->userdata('username')."/%')");
        if($result->num_rows()== 0){
             return FALSE;
        }
        else{
            $query = $this->db->query("select users.*,comments.* from users,comments where users.username=comments.username and topic_id='".$topic_id."' and project_id='".$project_id."'");
            if($query->num_rows() == 0){
                return "no_comments";
            }
            else{
                return $query->result();
            }
        }
    }
}
?>
