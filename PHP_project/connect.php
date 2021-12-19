<?php
$conn = new mysqli(_DB_HOST,_DB_USER,_DB_PASS,_DB_NAME) or die("Connection failed: " . $conn->connect_error);