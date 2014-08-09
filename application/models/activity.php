<?php
class Activity extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //add activity
        
    function add_activity($project_id,$action,$username){
         $values = array(
                             'project_id'    => $project_id,
                             'action'        => $action,
                             'username'      => $username
                         );
         $this->db->insert('activities',$values);         
    }
    
    //get list of activities of current user's projects (if project_id is specified only that particular project)
        
    function get_activity_list($project_id = NULL){
         if(!isset($project_id)){
             $username = $this->session->userdata('username');
             $projects_list = $this->db->query("select project_id from projects where admin = '".$username."' or leader = '".$username."' or developers like '%/".$username."/%'");
             $projects_list = $projects_list->result();
             $array = array();
             foreach($projects_list as $p){
                 array_push($array, $p->project_id);
             }
             $this->db->select('*')->from('activities,users')->where_in('activities.project_id',$array)->where('activities.username = users.username');
             $query = $this->db->get();
             $query = $query->result();
             return $query;
         }
         else{
             $username = $this->session->userdata('username');
             $query = $this->db->query("select * from projects where project_id ='".$project_id."' and (admin = '".$username."' or leader = '".$username."' or developers like '%/".$username."/%')");
             if($query->num_rows()== 0){
                 return FALSE;
             }
             else{
                $this->db->select('users.*');
                 $this->db->select('activities.*');
                 $this->db->from('activities,users');
                 $this->db->where('activities.project_id',$project_id);
                 $this->db->where('activities.username = users.username');
                 $query = $this->db->get();
                 $query = $query->result();
                 return $query;
                 //return $query->result_array();
             }
         }
    }
}
?>
