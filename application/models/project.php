<?php

class Project extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('activity');
        $this->load->model('todo_model');
    }
    
    //add project to 'projects' and update 'activity', returns true if added else false
        
        function add_project(){
            
               $query = $this->db->get_where('projects', array(
                                'title'         => $this->input->post('title'),
                                'admin'         => $this->session->userdata('username')));
               if($query->num_rows() == 0){
                    $values = array(	
				'title'         => $this->input->post('title'),
				'description'   => $this->input->post('description'),
                                'admin'         => $this->session->userdata('username'),
                                'developers'    => '&/',
                            );
                    $this->db->insert('projects', $values);
                    $query = $this->db->get_where('projects', array(
                                                                 'title' => $this->input->post('title'),
                                                                 'admin'=> $this->session->userdata('username')));
                    $query = $query->row_array();
                    $values = array(
                                'project_id'    => $query['project_id'],
                                'performed_at'  => $query['created_at'],
                                'action'        => $query['admin']." created project '".$query['title'],
                                'username'      => $this->session->userdata('username')
                                );
                    $this->db->insert('activities',$values);
                    return TRUE;
            }
            else{
                    return FALSE;
            }
        }
        
        //returns the list of projects if no project_id is specfied, or the info corresponding to project_id (returns false if it fails)
        
        function get_projects($project_id = NULL){
            $username = $this->session->userdata('username');
            $this->db->distinct();
            if(!isset($project_id)){
                $this->db->select('*')->from('projects')->or_where('admin', $username)->or_where('leader',$username)->or_where('developers like','%/'.$username.'/%');//->or_like('developers',$username.'/');
                $query = $this->db->get();
                if($query->num_rows() == 0){
                    return FALSE;
                }
                else{
                    return $query->result();
                }
            }
            else{
                $query = $this->db->query("select * from projects where project_id ='".$project_id."' and (admin = '".$username."' or leader = '".$username."' or developers like '%/".$username."/%')");
                if($query->num_rows() == 0){
                    return FALSE;
                }
                else{
                    return $query->row_array();
                }
            }      
        }
        
        //add the invited users to invites
        
        function add_invite($project_id,$conf_code,$post){
            $values = array(
                                'project_id'    => $project_id,
                                'username'      => $this->input->post('user'),
                                'post'          => $post,
                                'conf_code'     => $conf_code
                        );
            $this->db->insert('invites',$values);
        }
        
        //check whether the user has already been invited 
        
        function check_invite($project_id,$post){
            $query = $this->db->get_where('invites',array('project_id'   => $project_id,
                                                          'username'     => $this->input->post('user'),
                                                          'post'         => $post));
            if($query->num_rows() == 0){
                return FALSE;
            }
            else{
                return TRUE;
            } 
        }
        
        //add developers or project leader
        
        function accept_invite($conf_code){
            $query = $this->db->get_where('invites',array('conf_code'=>$conf_code));
            if($query->num_rows()==0){
                return "Sorry, this link has expired";
            }
            else{
                $query = $query->row_array();
                if($query['post']== 'lead'){
                    $this->db->update('projects',array('leader'=>$query['username']),array('project_id'=>$query['project_id']));
                    $this->db->delete('invites',array('project_id'=>$query['project_id'],'post'=>'lead'));
                }
                elseif($query['post']== 'dev'){
                    $this->db->select('developers');
                    $dev = $this->db->get_where('projects',  array('project_id'=>$query['project_id']));
                    $dev = $dev->row_array();
                    $this->db->update('projects',array('developers'=>$dev['developers'].$query['username'].'/'),array('project_id'=>$query['project_id']));
                    $this->db->delete('invites',array('conf_code' => $conf_code));                    
                }
                $this->db->select('title');
                $result = $this->db->get_where('projects',array('project_id'=>$query['project_id']));
                $result = $result->row_array();
                $this->activity->add_activity($query['project_id'], $query['username'].' joined '.$result['title'],$query['username']);
                return 'Your acceptance has been confirmed';
            }
        }
        
        //decline invite, deletes corresponding entry from invites
        
        function decline_invite($conf_code){
            $this->db->delete('invites',array('conf_code'=>$conf_code));
            return 'You have declined the invitation';
        }
        
        //remove project leader from project
        
        function delete_leader($project_id){
         if($this->db->update('projects',array('leader' => NULL),array('project_id' => $project_id, 'admin' => $this->session->userdata('username')))== 1){
             return TRUE;
         }
         else{
             return FALSE;
         }
        }
        
        //remove developers from project
        
        function delete_developer($project_id,$developer){
            $query = $this->db->query("select developers from projects where project_id = '".$project_id."' and (admin = '".$this->session->userdata('username')."' or leader = '".$this->session->userdata('username')."')");
            if($query->num_rows()== 0){
                return FALSE;
            }
            else{
                $query = $query->row_array();
                $dev = str_replace('/'.$developer.'/','/',$query['developers']);
                if($this->db->update('projects',array('developers' => $dev),array('project_id' => $project_id))){
                    return TRUE;
                }
                else{
                    return FALSE;
                }
            }
        }
        function get_members($project_id){
            $username = $this->session->userdata('username');
            $query = $this->db->query("select * from projects where project_id ='".$project_id."' and (admin = '".$username."' or leader = '".$username."' or developers like '%/".$username."/%')");
            if($query->num_rows()==0){
                return FALSE;
            }
            else{
                $query = $query->row_array();
                $members = array();
                array_push($members, $query['admin']);
                if(isset($query['leader'])){
                    array_push($members, $query['leader']);
                }
                $dev = explode('/', $query['developers']);
                foreach($dev as $d){
                    if($d != "" && $d != "&"){
                        array_push($members, $d);
                    }
                }
                return $members;
            }
        }
}
?>
