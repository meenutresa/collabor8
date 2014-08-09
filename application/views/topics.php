<html>
    <head>
        <title>Discussion Topics</title>
    </head>
    <body>
        <?php
            if($topics!="no_topics"){
                
            foreach($topics as $t){
                echo '<a href="http://localhost/taskmanager/index.php/discussion_controller/comments/'.$project_id.'/'.$t->topic_id.'">';
                echo '<br>'.$t->topic;
                echo '<br>Created by:'.$t->username.' at '.$t->created_at;
                echo '</a>';
            }
            
            }
            echo validation_errors();
            echo form_open('http://localhost/taskmanager/index.php/discussion_controller/topics/'.$project_id);
            ?>
        <p><input type="text" name="topic"/></p>
        <input type="submit" />
    </body>
</html>