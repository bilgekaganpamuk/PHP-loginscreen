<?php   

require "./configure.php";
require "./connect.php";
require "./session.php";

?>

<html>
<head>
<title>Student management</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />
</head>
<body>
<div class="container">
<?php
$y=0;

$user_login = $_SESSION['user_login'];
$user_logged = $_SESSION['user_logged'];

//Test if user logged in
if($user_logged == '1')
{


if(isset($_GET['action'])) $get_action = mysqli_real_escape_string($conn,$_GET['action']);
if(isset($_GET['id'])) $get_id = mysqli_real_escape_string($conn,$_GET['id']);



echo '<div class="container">'."\n";

echo '<h1>Student management</h1>'."\n";

echo '<h3 class="text-right"><span class="badge badge-secondary">
Logged user: '.$user_login.' <a style="color:#ccc;" 
href="./student.php?login_action=logout">logout</a></span></h3>'."\n";

}
$Exam_id_DB=mysqli_query($conn,'select * from '._DB_TABLE_MYDATES.' where student_code = "'.$user_login.'"');
while($entryx=mysqli_fetch_array($Exam_id_DB)){
$exam_id=$entryx['exam_id'];
$result_courses=mysqli_query($conn,'select * from '._DB_TABLE_STUDENTCOURSE.' where student_code = "'.$user_login.'"');
$course_dummy_db=mysqli_query($conn,'select * from '._DB_TABLE_STUDENTCOURSE.' where student_code = "'.$user_login.'"');
$course_dummy=mysqli_fetch_array($course_dummy_db);  
$courses = mysqli_query($conn,'select * from '._DB_TABLE_COURSES.' where lessons_num = "'.$exam_id.'"');
$entry_course = mysqli_fetch_array($courses); 
$Exam_date_DB=mysqli_query($conn,'select * from '._DB_TABLE_EXAMDATES.' where exam_id = "'.$exam_id.'"');
$dummy=mysqli_query($conn,'select * from '._DB_TABLE_EXAMDATES.' where exam_id = "'.$exam_id.'"');

$key1=isset($course_dummy['course_shortcut']) ? $course_dummy['course_shortcut']:null;
$key2=isset($entry_course['course_shortcut']) ? $entry_course['course_shortcut']:null;

if(mysqli_num_rows($result_courses) > 0)
{
    if($key1 == $key2){
echo '<table method="post"  class="table table-bordered table-striped table-hover">'."\n";
echo '<tr>'."\n";
    echo '<th>Courses</th>'."\n";
    while($dummy1 = mysqli_fetch_array($dummy)){
    echo '<th>Exam Dates</th>'."\n";
    }
echo '</tr>'."\n";
    }
$x = 0;

$z = 0;
while ($entry=mysqli_fetch_array($result_courses))
{
    $key3=isset($entry['course_shortcut']) ? $entry['course_shortcut']:null;
    if($key3==$key2){ 
  echo '<tr>'."\n";
    echo '<td>'.$entry['course_shortcut'].'</td>'."\n";
    while($entryxx = mysqli_fetch_array($Exam_date_DB)){
            $y=$y +1;
    echo '<td>'.$entryxx['exam_date'].' <form method="post" > <Input type = "submit" style="display:block"  name ="submit_date'.$y.'" value="Submit Date" align="center" style="margin-left:30px"> </form>'.'</td>';    
            
    if(isset($_POST['submit_date'.$y.''])){
    
        $date=$entryxx['exam_date'];
        $MaxRegistere =$entryxx['max_num_of_registered'];
        $query = "UPDATE "._DB_TABLE_EXAMDATES." SET max_num_of_registered=? WHERE exam_date=?";
        $stmt = $conn->prepare($query);
        $counter_number=0;
        if($counter_number < $entryxx['max_num_of_registered'] ){
        if($stmt)
        {
            $MaxRegistere=$MaxRegistere -1;
          $stmt->bind_param('is',$MaxRegistere,$date );
          $stmt->execute();
          $counter_click=0;
        }
        else
        {
          echo "<p>User not updated.</p>";
        }
        echo '<script language="javascript">';
        echo 'alert("Succesfully Updated")';
        echo '</script>';
        $x=1;
        $z=1;
         $sql_delete = mysqli_query($conn,'DELETE FROM '._DB_TABLE_EXAMDATES.' where exam_date != "'.$entryxx['exam_date'].'" and exam_id ="'.$exam_id.'"');
        
        }
        else{
            echo '<script language="javascript">';
            echo 'alert("Registiration is full")';
            echo '</script>';
        }
    }
}
}  

  echo '</tr>'."\n";  
}

echo '</form>';

}
else
{
  echo '<p><b>No entries found.</b></p>'."\n";  
}
}
mysqli_close($conn); 

if($user_logged != '1')
{
    $location = './Student.php';
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