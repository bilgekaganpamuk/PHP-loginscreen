<?php   

require "./configure.php";
require "./connect.php";
require "./session.php";

?>

<html>
<head>
<title>Teachers management</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />
</head>
<body>
<div class="container">
<?php
$user_login = $_SESSION['user_login'];
$user_logged = $_SESSION['user_logged'];

if($user_logged == '1')
{


if(isset($_GET['action'])) $get_action = mysqli_real_escape_string($conn,$_GET['action']);
if(isset($_GET['id'])) $get_id = mysqli_real_escape_string($conn,$_GET['id']);



echo '<div class="container">'."\n";

echo '<h1>Teachers management</h1>'."\n";

echo '<h3 class="text-right"><span class="badge badge-secondary">
Logged user: '.$user_login.' <a style="color:#ccc;" 
href="./Teacher.php?login_action=logout">logout</a></span></h3>'."\n";

//inserting user
if(isset($get_action) and $get_action == 'insert')
{
  if(isset($_POST['submit']))
  {
    $code_teacher_db = mysqli_query($conn,'select * from '._DB_TABLE_TEACHERSCOURSES.' where id!=99 order by id');
    while($code_teacher= mysqli_fetch_array($code_teacher_db)){
    $num_lesson_db=mysqli_query($conn,'select * from '._DB_TABLE_COURSES.' where course_shortcut = "'.$code_teacher['course_shortcut'].'"');
    while($num_lesson= mysqli_fetch_array($num_lesson_db)){
    if($num_lesson['lessons_num']==$_POST['exam_id']){
    $sql_insert = 'INSERT INTO '._DB_TABLE_EXAMDATES.' (id,exam_id,class,teacher_code,exam_date,max_num_of_registered,note) 
    VALUES ("","'.$_POST['exam_id'].'","'.$_POST['class'].'",
    "'.$user_login.'","'.$_POST['exam_date'].'","'.$_POST['max_num_of_registered'].'",
    "'.$_POST['note'].'") ';
    if($conn->query($sql_insert)===true){
      echo '<div class="alert alert-success" role="alert">';
      echo '<p class="text-center">User was successfully inserted.</p>';
    echo '</div>';
    echo '<div class="alert alert-success" role="alert">';
      echo '<p class="text-center"><a href="./teacher-info.php">Back to list of Teacher Coureses</a></p>';
    echo '</div>';
    }
    else{
      echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
  }
  }
  }
  }
  
  else
  {
    ?>
    <form method="post" action="teacher-info.php?action=insert">

<div class="form-group row">
  <label for="exam_id" class="col-md-2 col-form-label">Exam id</label>
  <div class="col-md-10">
    <input type="number" class="form-control" name="exam_id" id="exam_id" size="25" maxlength="25" required>
  </div>
</div>
  
<div class="form-group row">
  <label for="class" class="col-md-2 col-form-label">Class</label>
  <div class="col-md-10">
    <input type="text" class="form-control" name="class" id="class" size="25" maxlength="25" required>
  </div>
</div>

<div class="form-group row">
  <label for="exam_date" class="col-md-2 col-form-label">Exam Date</label>
  <div class="col-md-10">
    <input type="date" class="form-control" name="exam_date" id="exam_date" size="25" maxlength="25" required>
  </div>
</div>
  
<div class="form-group row">
  <label for="max_num_of_registered" class="col-md-2 col-form-label">Max number of registered Person</label>
  <div class="col-md-10">
    <input type="number" class="form-control" name="max_num_of_registered" id="max_num_of_registered" size="25" maxlength="25" required>
  </div>
</div>
  
<div class="form-group row">
  <label for="note" class="col-md-2 col-form-label">Note</label>
  <div class="col-md-10">
    <textarea class="form-control" id="note" name="note" rows="4" cols="50"></textarea>
  </div>
</div>
        
<div class="form-group row">
  <label for="note" class="col-md-2 col-form-label"></label>
  <div class="col-md-10">
    <input type="submit" class="btn btn-success" name="submit" value="Send">
  </div>
</div>

</form>
    <?php
  }
}

elseif(isset($get_action) and $get_action == 'edit')
{
  if(isset($_POST['submit']))
  {
    $date = mysqli_real_escape_string($conn,$_POST['exam_date']);
    $sql_update = mysqli_query($conn, 'UPDATE '._DB_TABLE_EXAMDATES.' SET exam_date="'.$date.'"WHERE id="'.$get_id.'"') or print("<p>User not edited.</p>");
    if($sql_update){
        redirect_to_url('./teacher-info.php');
    }
  }
  else
  {
    echo '<h2>Edit date</h2>'."\n";
    $result_date=mysqli_query($conn,'select * from '._DB_TABLE_EXAMDATES.' where id = '.$get_id.' limit 1');
    while($entry_date=mysqli_fetch_array($result_date)) 
    {
      $course_date = $entry_date['exam_date'];
    }
    echo '<form method="post" action="teacher-info.php?action=edit&id='.$get_id.'">'."\n";
    echo '<div class="form-group row">'."\n";
    echo '<label for="exam_date" class="col-md-2 col-form-label">Exam Date</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="exam_date" id="exam_date" value="'.$course_date.'" >'."\n";
    echo '</div>'."\n";
    echo '</div>'."\n";

    echo '<div class="form-group row">'."\n";
    echo '<label for="note" class="col-md-2 col-form-label">&nbsp;</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="submit" class="btn btn-success" name="submit" value="Edit">'."\n";
    echo '</div>'."\n";
    echo '</div>'."\n";

  }  
      
}

//deleting user
elseif(isset($get_action) and $get_action == 'delete')
{
  $sql_delete = mysqli_query($conn,'DELETE FROM '._DB_TABLE_EXAMDATES.' where id = "'.$get_id.'"')
  or print("<p>User not deleted.</p>");
  if($sql_delete)
  {
    echo '<div class="alert alert-success" role="alert">';
      echo '<p class="text-center">User sucessfully deleted.</p>';
    echo '</div>'; 
    echo '<div class="alert alert-primary" role="alert">';
      echo '<p class="text-center"><a href="./teacher-info.php">Back to the table of users</a></p>';
    echo '</div>';

  }
}
else
{
  echo '<p><a class="btn btn-success" href="./teacher-info.php?action=insert">Insert new date</a></p>'."\n";
$result_teached_courses=mysqli_query($conn,'select * from '._DB_TABLE_TEACHERSCOURSES.' where id!=11 order by id');
$result_examdate_dummy1=mysqli_query($conn,'select * from '._DB_TABLE_EXAMDATES.' where teacher_code = "'.$user_login.'"');
$result_examdate_dummy2=mysqli_query($conn,'select * from '._DB_TABLE_EXAMDATES.' where teacher_code = "'.$user_login.'"');
$counter_id=0;
while($dummy_date1=mysqli_fetch_array($result_examdate_dummy1)){
    while($dummy_date2=mysqli_fetch_array($result_examdate_dummy2)){
    if($dummy_date1['exam_id']==$dummy_date2['exam_id'])
    $counter_id = $counter_id +1;
    }
}
if(mysqli_num_rows($result_teached_courses) > 0)
{
echo '<table class="table table-bordered table-striped table-hover">'."\n";
echo '<tr>'."\n";
    echo '<th>Teached Courses</th>'."\n";
    $i=0;   
    while($i<$counter_id){
    echo '<th>Exam Dates of Courses </th>'."\n";
    $i=$i+1;
    }
    
echo '</tr>'."\n";
while ($entry=mysqli_fetch_array($result_teached_courses))
{
  echo '<tr>'."\n";
    echo '<td>'.$entry['course_shortcut'].'</td>'."\n";
    $result_examdate=mysqli_query($conn,'select * from '._DB_TABLE_EXAMDATES.' where teacher_code = "'.$user_login.'"');
    while($dates=mysqli_fetch_array($result_examdate)){
        $courses_db=mysqli_query($conn,'select * from '._DB_TABLE_COURSES.' where course_shortcut = "'.$entry['course_shortcut'].'"');
        while($courses=mysqli_fetch_array($courses_db)){
          if($courses['lessons_num']==$dates['exam_id']){
            echo '<td>'.$dates['exam_date']."\n".'<a class="btn btn-success" href="./teacher-info.php?action=edit&id='.$dates['id'].'">edit</a>
            <a class="btn btn-primary" href="./teacher-info.php?action=delete&id='.$dates['id'].'">delete</a>'.'</td>'."\n";
            }
        }
    }

  echo '</tr>'."\n";  
}
echo '</table>'."\n";
}
else
{
  echo '<p><b>No entries found.</b></p>'."\n";  
}
}

mysqli_close($conn); 

}
else
{
    $location = './teacher-info.php';
    if (!headers_sent())
    {
      Header("Location: $location");
    }
    else
    {
      echo '<script type="text/javascript">';
      echo 'window.location.href="'.$location.'";';
      echo '</script>';
      echo '<noscript>';
      echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
      echo '</noscript>';
    }
}

echo '</div>'."\n";
echo '</body>'."\n";
echo '</html> '."\n";

?>