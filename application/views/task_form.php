<html>
    <head>
        <title>Add task</title>
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
<div style="position:absolute;font-size:50px;font-family:Calibri;top:50px;left:50px">Add task&nbsp;</div>
<div style="position:absolute; top:150px; left:100px; width:1000px">
        
        <?php echo validation_errors(); ?> 
        <?php echo form_open('http://localhost/taskmanager/index.php/todo_controller/add_task/'.$project_id); ?> 
        
        <p>Title: <input type="text" name="title"/></p>
        <p>Description: <input type="text" name="description"/></p>
        <p>Assign to: <select name="assigned_to[]" multiple="multiple">
                <?php foreach($members as $mem){
                    echo '<option value="'.$mem.'">'.$mem.'</option>';
                }
                ?>
            </select></p>
        <p>Deadline: <input type="date" name="deadline"/></p>
        <input type="submit" class="btn1" value="Add Task">
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