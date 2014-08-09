<html>
    <head>
        <title>Projects</title>
    </head>
    <body>
        <h2>Projects list:</h2>
        <?php if($projects != FALSE){
            foreach($projects as $row){
            echo '<a href="http://localhost/taskmanager/index.php/project_controller/open_project/'.$row->project_id.'"><p>Title:'.$row->title.'<br>Description:'.$row->description.'<br>Administrator:'.$row->admin.'<br>Created on:'.$row->created_at.'</p></a>';
        }
        }
        else{
            echo 'You have no projects.';
        } ?>
        <a href="http://localhost/taskmanager/index.php/project_controller/new_project">New project</a>
    </body>
</html>
