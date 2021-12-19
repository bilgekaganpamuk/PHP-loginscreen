<?php   

require "./configure.php";
require "./connect.php";
require "./session.php";

?>
<html>
<head>
<title >Login to Teacher Account</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />
</head>
<body>
<div class="container">
<?php


echo '<h1 style="text-align: center">Login to Teacher Account</h1>';


function show_form()
{
    
  echo ' <a href="Select.php"><button>GO Back</button></a>';
echo '<form method="post" action="Teacher.php">'."\n";
echo '<input type="hidden" name="form-insert" value="sent">'."\n";

  echo '<div class="form-group row">'."\n";
    echo '<label for="teacher_code" class="col-md-2 col-form-label">Teacher Code</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="text" class="form-control" name="teacher_code" id="teacher_code" required>'."\n";
    echo '</div>'."\n";
  echo '</div>'."\n";
  
  echo '<div class="form-group row">'."\n";
    echo '<label for="password" class="col-md-2 col-form-label">Password</label>'."\n";
    echo '<div class="col-md-10">'."\n";
      echo '<input type="password" class="form-control" name="password" id="password" required>'."\n";
    echo '</div>'."\n";
  echo '</div>'."\n";  
  
  echo '<div class="form-group row">'."\n";
    echo '<label for="note" class="col-md-2 col-form-label">&nbsp;</label>'."\n";
    echo '<div class="col-md-10">'."\n";
   
      echo '<input type="submit" class="btn btn-success" style="margin:0px auto; display:block;" name="submit" value="Login">'."\n";
    echo '</div>'."\n";
  echo '</div>'."\n";

echo '</form>'."\n";
  
}   



if(isset($_POST['form-insert']) and $_POST['form-insert'] == 'sent')
{
    
    $teacher_code = mysqli_real_escape_string($conn,$_POST['teacher_code']);
    
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $cont = false;
    $result_user_login=mysqli_query($conn,'select * from '._DB_TABLE_TEACHERS.' where teacher_code like "'.$teacher_code.'" limit 1');
    
    if(mysqli_num_rows($result_user_login) == 1)
    {
        
       $cont = true;
       while($entry_user_login=mysqli_fetch_array($result_user_login))
       {
         $user_login = $entry_user_login['teacher_code'];
         $user_password = $entry_user_login['password'];
         $student_code = $entry_user_login['teacher_code'];
       }
       if($cont and $user_password==$password)
       {
        
         $_SESSION['user_logged'] = '1';
         $_SESSION['user_login'] = $user_login;
         $_SESSION['student_code'] = $student_code;

         //Redirect
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
       else
       {
         echo '<div class="alert alert-danger" role="alert">';
           echo '<p class="text-center">Wrong login or password</p>';
         echo '</div>';
         show_form();
       }
    }
    else
    {
      echo '<div class="alert alert-danger" role="alert">';
        echo '<p class="text-center">Wrong login or password</p>';
      echo '</div>';
      show_form();
    }
  
    

}
else
{
  show_form();
}



 
?>
</div>
</body>
</html>
