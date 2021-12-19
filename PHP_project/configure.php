<?php

define('_DB_HOST', 'localhost');
define('_DB_USER', 'root');
define('_DB_PASS', '');
define('_DB_NAME', 'php_project');

define('_DB_TABLE_STUDENTS', 'student');
define('_DB_TABLE_COURSES', 'courses');
define('_DB_TABLE_STUDENTCOURSE', 'students_courses');
define('_DB_TABLE_TEACHERS', 'teachers');
define('_DB_TABLE_MYDATES', 'my_dates'); 
define('_DB_TABLE_EXAMDATES', 'exam_dates'); 
define('_DB_TABLE_TEACHERSCOURSES', 'teachers_courses'); 


function redirect_to_url($location)
{
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

