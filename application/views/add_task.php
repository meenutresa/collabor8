<html>
<head>
<title>Add Task</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php echo validation_errors(); ?>

<?php echo form_open('todo_controller/add_task'); ?>

  <p>Task : 
    <input name="task" type="text" value="" size="100">
  </p>
  <p>Description: </p>
  <p> 
    <textarea name="description"></textarea>
  </p>
  
<p>Assign To: 
  <input type="text" name="assignTo">
</p>
<p>
  <input type="submit" name="Submit" value="Submit">
</p>
  </form>
</body>
</html>
