<?php 
    $filename = $_REQUEST['path'];  
    header("Content-type: application/pdf"); 
    header("Content-Length: " . filesize($filename)); 
    readfile($filename);
?>