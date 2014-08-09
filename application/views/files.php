<html>
    <head>
        <title>Files</title>
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
        <?php echo '<a href="http://localhost/taskmanager/index.php/users_controller/edit_profile_pic">Edit profile</a>';?><br>
        <a href="http://localhost/taskmanager/index.php/users_controller/logout">Logout</a>
    </div>
<div style="position:absolute;font-size:50px;font-family:Calibri;top:50px;left:50px">Files&nbsp;</div>
<div style="position:absolute; top:150px; left:100px; width:1000px">

        <?php
        if(!isset($list)){
            echo 'no files';
        }
        else {
            foreach ($list as $files){
                echo '<br><img src="http://localhost/taskmanager/images/'.$files->profile_pic.'"width="40" height="40" id="dispic"/>&nbsp&nbsp&nbsp&nbsp&nbsp';
                echo '<a href="'.$files->file_name.'">'.$files->file_name.'</a>';
            }
        }
        echo '<br><br><br><br><div class="up"><a href="http://localhost/taskmanager/index.php/file_controller/do_upload/'.$project_id.'">Upload</a></div>';
        ?>
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