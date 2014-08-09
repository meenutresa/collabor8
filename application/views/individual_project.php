<html>
    <head>
        <title><?php if(!$project_info){
          echo 'error';}
            else {
                    echo $project_info['title'];
                    }?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/project.css"/>
        <script type="text/javascript" src="<?php echo base_url();?>/js/jquery-1.6.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>/js/project.js"></script>
    </head>
    <body>
        <div class="outbox">
<div class="top-nav">
    <img src="<?php echo base_url();?>/images/down.png" style="float:right" id="dropdown"/>
    <div style="float:right;font-family:Calibri;font-size:25px;color:white;line-height:50px"><?php echo $username; ?>&nbsp;</div>
    <div style="font-family:Calibri;font-size:40px;color:white;padding-left:0.5cm">Collabor8</div>
</div>
<div class="menu">
        <?php echo '<a href="http://localhost/taskmanager/index.php/users_controller/edit_profile_pic">Edit profile</a>';?><br>
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
</div>
<div class='box'>
</br>

        <h1><?php echo $project_info['title'];?></h1>
        <h3><?php echo $project_info['description'];?></h3>
       <!-- <div id="dp">
        <img src="<?php echo base_url();?>/images/dp.jpg" style="float:right" width="40" height="40" id="dpic" title="username2"/>
        <img src="<?php echo base_url();?>/images/dp.jpg" style="float:right" width="40" height="40" id="dpic" title="username1"/>
        

     </div>
     <input type="submit" class="btn2" value="+1" />
     <input type="submit" class="btn1" value="Invite" />-->

    <!-- <input type="submit" class="btn2" value="Invite Leader" />
     <input type="submit" class="btn1" value="Invite Developers" />-->

     
     
        <p>Created by: <?php echo $project_info['admin'];?></p>
        <p>Project leader:<?php 
                                if(isset($project_info['leader'])){
                                        echo $project_info['leader'];
                                        if($previlage == 'admin'){
                                            echo '<a href="http://localhost/taskmanager/index.php/project_controller/remove_leader/'.$project_info['project_id'].'">Remove</a>';
                                        }
                                }
                                elseif($previlage == 'admin'){
                                  echo '<a href="http://localhost/taskmanager/index.php/project_controller/invite_leader/'.$project_info['project_id'].'">Add</a>';
                                }
                                else{
                                    echo 'Not assigned';
                                }
        ?></p>
        <p>Developers:<?php     
                                $arr = explode('/', $project_info['developers']);
                                //print_r($arr);
                                foreach($arr as $a){
                                    if($a!=""&& $a !='&'){
                                        echo $a.'<a href="http://localhost/taskmanager/index.php/project_controller/remove_developer/'.$a.'/'.$project_info['project_id'].'">remove</a><br>';
                                    }
                                }
                                if($previlage == 'admin' || $previlage == 'leader'){
                                    echo '<a href="http://localhost/taskmanager/index.php/project_controller/invite_developer/'.$project_info['project_id'].'">Add</a>';
                                }
                                elseif(!isset ($project_info['developers'])){
                                    echo 'None';
                                }
        ?></p>


        
     <hr/>
     <h4>Latest Updates</h4>
     <p>
        <?php
        $activity=array();
        $i=0;
        if($activities)
        {
         foreach($activities as $a){
            $activity[$i]=$a;$i++;
        }
    }
        $i--;
        if($i>3)
            $k=$i-2;
        else
            $k=$i;
        //array_reverse($activity,false);
        if($i>=0)
        {
            for($j=$i;$j>=$k;$j--)
            {
                ?>
    
    <div class="activity-container">
  <!--<img src="<?php //echo base_url();?>/images/profile.png"/>-->
  <?php
                //var_dump($a);
            echo '<img src="http://localhost/taskmanager/images/'.$activity[$j]->profile_pic.'" width="40" height="40" id="dispic"/>';
            echo $activity[$j]->action.' , ';
            echo $activity[$j]->performed_at;
        ?>
        </div>
        
        <?php   
        }
    }
    else
        echo "No activities";?>
     <?php echo '<br><a href="http://localhost/taskmanager/index.php/users_controller/get_activities/'.$project_info['project_id'].'">See more updates</a>';?></p>

     </br></br>
     <h4>Discussions</h4>
     <div id="dis">
        <?php
            if($topics!="no_topics"){
                
            foreach($topics as $t){ ?>
                
                <br/><?php echo '<img src="http://localhost/taskmanager/images/'.$t->profile_pic.'" width="40" height="40" id="dispic"/>';?>
                <div id="diss">
                <?php
                echo '<a href="http://localhost/taskmanager/index.php/discussion_controller/comments/'.$project_id.'/'.$t->topic_id.'">';
                echo '<br>'.$t->topic;
                echo '<br>Created by:'.$t->username.' at '.$t->created_at;
                echo '</a>';
                ?>
            </div>
            
             <?php   
            }
            
            
            
            }
            echo validation_errors();
            echo form_open('http://localhost/taskmanager/index.php/project_controller/open_project/'.$project_id);
            ?>
        <p><input type="text" name="topic"/></p>
        <input type="submit" class="btn3" value="Add Topic"/>
     <!--<img src="<?php echo base_url();?>/images/dp.jpg" width="40" height="40" id="dispic" title="username1"/> <a href ='#'>Topic1 <div id="time"> june 15 </div></a>
     <img src="<?php echo base_url();?>/images/dp.jpg" width="40" height="40" id="dispic" title="username2"/> <a href ='#'>Topic2 <div id="time"> june 16 </div></a></br>-->
     </div></br>
     </br>
</br></br></br></br></br></br></br>
     
</div>
<!--
<div class="todo">
    <div id="boldicon"><img src="<?php echo base_url();?>/images/boldicon.png" width="20" height="20" id="todopic" title="bold"/></div>
    <div id="italicsicon"><img src="<?php echo base_url();?>/images/italicsicon.png" width="20" height="20" id="todopic" title="italics"/></div>
    <div id="underlineicon"><img src="<?php echo base_url();?>/images/underlineicon.png" width="20" height="20" id="todopic" title="underline"/></div>
    <div id="imgicon"><img src="<?php echo base_url();?>/images/imgicon.png" width="25" height="25" id="todopic" title="image upload"/></div>
    <div id="attachicon"><img src="<?php echo base_url();?>/images/attachicon.png" width="25" height="25" id="todopic" title="attachments"/></div>
    
</div>-->
<div id="imgicon">
<?php echo '<a href="http://localhost/taskmanager/index.php/file_controller/files_list/'.$project_id.'">'?><img src="<?php echo base_url();?>/images/imgicon.png" width="25" height="25" id="todopic" title="file upload" /><?php '</a>';?>
</div>
<div id="todoicon"><img src="<?php echo base_url();?>/images/todoicon.png" width="30" height="30" id="todopic" title="todolist"/></a></div>
<div class="todolist">
    <div id="title"><center>TODOLIST</center></div>
    <?php if(isset($task_list)){
            foreach($task_list as $task){
                if(isset($task->title)){
                    echo "<br>Project:".$task->title;
                }
                echo "<br>* Task: <b>".$task->task_title."</b>";
                echo "<br>Assigned to: <b>".$task->assigned_to."</b>";
                echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbspDeadline: <b>'.$task->deadline."</b>";
                if($ind){
                   // echo '<br><a href="http://localhost/taskmanager/index.php/todo_controller/remove_todo/'.$task->task_id.'/'.$project_id.'">Remove task</a>';
                }
            }
        }else{
                        echo 'no tasks';} ?>
        <?php if($ind){echo '<br><br><a href="http://localhost/taskmanager/index.php/todo_controller/task_list/'.$project_id.'">Manage Tasks</a>';} ?>
</div>

<div id= "footer">
</br></br></br></br></br></br></br></br>
</div>
    
        
    </body>
          
    
</html>