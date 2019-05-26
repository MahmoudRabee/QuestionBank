<?php 
session_start();
session_unset();
session_destroy();
header( "refresh:5;url=bank.php" );# go to control pages
echo ' wait to redirect to main page.';
?>s