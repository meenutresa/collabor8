<?php
class Todo_model extends CI_Model{
	
    function __construct(){
	parent::__construct();
	$this->load->database();
        $this->load->model('activity');
    }
	
    function add_todo($project_id){
        $username = $this->session->userdata('username');
        $query = $this->db->query("select * from projects where project_id ='".$project_id."' and (admin = '".$username."' or leader = '".$username."' or developers like '%/".$username."/%')");
	if($query->num_rows() == 0){
            return FALSE;
        }
        else{
            $string = "/";
            if($this->input->post('assigned_to')!=0){
                foreach ($this->input->post('assigned_to') as $mem){
                    if($mem != ""){
                        $string = $string.$mem."/";
                    }
                }
            }
            else{
                $string = NULL;
            }
            if($this->input->post('deadline')!= ""){
                $deadline_str = $this->input->post('deadline');
            }
            else{
                $deadline_str = NULL;
            }
            $values = array(
                                'project_id'    => $project_id,
                                'created_by'    => $username,
                                'task_title'    => $this->input->post('title'),
                                'description'   => $this->input->post('description'),
                                'assigned_to'   => $string,
                                'deadline'      => $deadline_str
                            );
            $this->db->insert('tasks',$values);
            $title = $this->db->get_where('projects',array('project_id'=>$project_id));
            $title = $title->row_array();
            $this->activity->add_activity($project_id,  $this->session->userdata('username')." added a task '".$this->input->post('title')." to ".$title['title'],  $this->session->userdata('username'));
        }
    }
    
    //if project_id is set, returns all the tasks of corresponding project else returns the tasks either assigned to or created by the user
    function get_task_list($project_id = NULL){
        $username = $this->session->userdata('username');            
        if(isset($project_id)){
            $query = $this->db->query("select * from projects where project_id ='".$project_id."' and (admin = '".$username."' or leader = '".$username."' or developers like '%/".$username."/%')");
            if($query->num_rows() == 0){
                return "no_access";
            }
            else{
                $result = $this->db->get_where('tasks',array('project_id' => $project_id));
                if($result->num_rows()!=0){
                    return $result->result();
                }
                else{
                    return NULL;
                }
            }
        }
        else{
            $query = $this->db->query("select tasks.*,projects.title from tasks,projects where tasks.project_id = projects.project_id and (created_by = '".$username."' or assigned_to like '%/".$username."/%')");
            if($query->num_rows()!=0){
                return $query->result();
            }
            else{
                return NULL;
            }
        }
    }
    
    //delete task depending on $task_id
    
    function delete_task($task_id){
        $username = $this->session->userdata('username');
        $query = $this->db->get_where('tasks',array('task_id' => $task_id));
        if($query->num_rows() == 0){
            return FALSE;
        }
        else{
            $query = $query->row_array();
            $result = $this->db->query("select * from projects where project_id ='".$query['project_id']."' and (admin = '".$username."' or leader = '".$username."' or developers like '%/".$username."/%')");
            if($result->num_rows() == 0){
                return FALSE;
            }
            else{
                $this->db->delete('tasks',array('task_id' => $task_id));
                return TRUE;
            }
        }
    }
    
    //to remove people from tasks when a developer from project is removed
    
    function remove_users($project_id,$user){
        $this->db->select('task_id');
        $query = $this->db->get_where('tasks',array(    'project_id'    =>  $project_id,
                                                        'created_by'    =>  $user));
        if($query->num_rows() != 0){
            $query = $query->result_array();
            foreach ($query as $task){
                $this->db->delete('tasks',array('task_id'   =>  $task['task_id']));
            }
        }
        
        $query = $this->db->query("select task_id,assigned_to from tasks where project_id = '".$project_id."' and assigned_to like '%/".$user."/%'");
        if($query->num_rows() != 0){
            $query = $query->result_array();
            foreach ($query as $task){
                $str = str_replace('/'.$user.'/', '/', $query['assigned_to']);
                $this->db->update('tasks',array('assigned_to' => $str),array('task_id' => $task['task_id']));
            }
        }
        
    }
		
}
?>