<html>
    <head>
        <title>Tasks</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/attempt2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/project1.css"/>
<script  type="text/javascript" src="<?php echo base_url();?>/js/jquery-1.6.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/js/attempt2.js"></script>
    </head>
    <body>
        <div class="top-nav"> <img src="<?php echo base_url();?>/images/down.png"  style="float:right" id="dropdown"/> 
  <div style="float:right;font-family:Calibri;font-size:25px;color:white;line-height:50px"><?php echo $username;?>&nbsp;</div>
  <div style="font-family:Calibri;font-size:40px;color:white">Collabor8</div>
</div>
<div class="menu">
        <?php echo '<a href="http://localhost/taskmanager/index.php/users_controller/edit_profile_pic">Edit profile</a>';?><br/>
        <a href="http://localhost/taskmanager/index.php/users_controller/logout">Logout</a>
    </div>
<div style="position:absolute;font-size:50px;font-family:Calibri;top:50px;left:50px">Tasks&nbsp;<?php if($ind){echo '<a href="http://localhost/taskmanager/index.php/todo_controller/add_task/'.$project_id.'" style="color:black;text-decoration:none">+</a>';}?></div>
<div style="position:absolute; top:150px; left:100px; width:1000px">
        <?php if(isset($task_list)){
            foreach($task_list as $task){
                if(isset($task->title)){
                    echo "<br>Project : <b>".$task->title."</b>";
                }
                echo "<br><br>Task: <b>".$task->task_title."</b>";
                echo "<br>Description: <b>".$task->description."</b>";
                echo "<br>Created by: <b>".$task->created_by." at ".$task->created_at."</b>";
                echo "<br>Assigned to: <b>".$task->assigned_to."</b>";
                echo '<br>Deadline: <b>'.$task->deadline."</b><br><br><br><br>";
                if($ind){
                    echo '<br><a href="http://localhost/taskmanager/index.php/todo_controller/remove_todo/'.$task->task_id.'/'.$project_id.'">'?><img src="<?php echo base_url();?>/images/delete.png" style="float:right" width="30" height="30" id="dpic" title="Remove"/><?php '</a>';
                }
            }
        }else{
                        echo 'no tasks';} ?>
        <?php if($ind){//echo '<a href="http://localhost/taskmanager/index.php/todo_controller/add_task/'.$project_id.'">ADD TASK</a>';
    } ?>
        <div class="menu-box">
        <img src="<?php echo base_url();?>/images/menu.png" style="float:right" id="dropdown"/>
        <a href="http://localhost/taskmanager/index.php/project_controller/my_projects">Project</a>
        <br>
        <a href="http://localhost/taskmanager/index.php/todo_controller/task_list">My Tasks</a>
        <br>
        <a href="http://localhost/taskmanager/index.php/users_controller/get_activities">Activities</a>
    </div>
    </body>
</html>