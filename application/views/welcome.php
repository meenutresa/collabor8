<html>
<head>
<title>welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/attempt2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/project1.css"/>
<script  type="text/javascript" src="<?php echo base_url();?>/js/jquery-1.6.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/js/attempt2.js"></script>
</head>

<body>
	
        
<div style="position:relative;font-size:50px;font-family:Calibri;top:50px;left:50px">Projects&nbsp;<a href="http://localhost/taskmanager/index.php/project_controller/new_project" style="color:black;text-decoration:none">+</a></div>
<div style="position:relative; top:150px; left:100px; width:1000px">

  
   <?php if($projects != FALSE){
            foreach($projects as $row){?>
            <div class="project-container">
            <img src="<?php echo base_url();?>/images/project.png" style="float:right"/>
            <?php

            echo '<a href="http://localhost/taskmanager/index.php/project_controller/open_project/'.$row->project_id.'"><p>Title:'.$row->title.'<br>Description:'.$row->description.'<br>Administrator:'.$row->admin.'<br>Created on:'.$row->created_at.'</p></a>';
        
        ?>
        </div>
        <?php
        }
        }
        else{
            echo 'You have no projects.';
        } ?>
  



</div>

<div class="top-nav"> <img src="<?php echo base_url();?>/images/down.png" style="float:right" id="dropdown"/> 
  <div style="float:right;font-family:Calibri;font-size:25px;color:white;line-height:50px">Welcome <?php echo $username;?>,&nbsp;</div>
  <div style="font-family:Calibri;font-size:40px;color:white">Collabor8</div>
</div>
<div class="menu">
		<?php echo '<a href="http://localhost/taskmanager/index.php/users_controller/edit_profile_pic">Edit profile</a>';?><br/>
  		<a href="http://localhost/taskmanager/index.php/users_controller/logout">Logout</a>
	</div>
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
