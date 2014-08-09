<html>
    <head>
        <title>Comments</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/attempt2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/project1.css"/>
<script  type="text/javascript" src="<?php echo base_url();?>/js/jquery-1.6.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/js/attempt2.js"></script>

        <script type="text/javascript" src="http://ajax.googleapis.com/
ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/js/jquery.form.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>/js/comment.js"></script>-->
<script type="text/javascript">
// jQuery Document
/*$(document).ready(function(){
    
    var filename='http://localhost/taskmanager/index.php/discussion_controller/commentsajax/'+'<?php echo $project_id;?>'+'/'+'<?php echo $topic_id;?>';
    //Load the file containing the chat log
    function loadLog(){     
        //var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
        $.ajax({
            url: filename,
            cache: false,
            success: function(html){        
                $("#preview").html(html); //Insert chat log into the #chatbox div               
                              
            },
        });
    }
    setInterval (loadLog, 2500);    //Reload file every 2.5 seconds
    
});*/
</script>


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
<div style="position:absolute;font-size:50px;font-family:Calibri;top:50px;left:50px"><?php foreach($topic as $t){echo $t->topic;}?>&nbsp;</div>
<div style="position:absolute; top:150px; left:100px; width:1000px">
        <div id="preview">
        <?php
        if($comments!="no_comments"){
        foreach($comments as $c){
            echo "<br>".$c->comment."<br>".$c->username." at ".$c->time;
        }}?>
        </div>
        <?php echo validation_errors(); 
        echo form_open('http://localhost/taskmanager/index.php/discussion_controller/comments/'.$project_id.'/'.$topic_id);
        ?>
    
    <div id="formbox">
        <form id="form">
        <p><input type="text" name="comment"/></p>
        <input type="submit" class="btn1" value="Comment" />
        
    </form>
    
</div>
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