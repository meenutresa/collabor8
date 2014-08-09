<?php

class Files extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('activity');
    }
    
    //get files list according to project_id
    
    function get_files($project_id){
        $username = $this->session->userdata('username');
        $query = $this->db->query("select * from projects where project_id ='".$project_id."' and (admin = '".$username."' or leader = '".$username."' or developers like '%/".$username."/%')");
        if($query->num_rows()==0){
            return 'no_access';
        }
        else{
            $result = $this->db->query("select users.*,files.* from users,files where users.username=files.username and files.project_id='".$project_id."'");
            if($result->num_rows()==0){
                return NULL;
            }
            else{
                return $result->result();
            }
        }
    }
        //add files to project
        
        function add_files($project_id,$data){
            $username = $this->session->userdata('username');
            $query = $this->db->query("select * from projects where project_id ='".$project_id."' and (admin = '".$username."' or leader = '".$username."' or developers like '%/".$username."/%')");
            if($query->num_rows()==0){
                return FALSE;
            }
            else{
                $query = $query->row_array();
                $values = array(
                                    'project_id'    => $project_id,
                                    'username'      => $username,
                                    'file_name'     => 'http://localhost/taskmanager/uploads/'.$data['file_name']
                );
                $this->db->insert('files',$values);
                $this->activity->add_activity($project_id,  $username," uploaded file ".$data['file_name']." to project ".$query['title'],  $username);
                return TRUE;
            }
        }
    
    
}

?>