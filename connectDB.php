<?php 
 $dsn = 'mysql:host=localhost;dbname=qbank'; // Data sourse name
	$user = 'root' ; // the user to connect

	$pass = '';


	try {
		$db = new PDO($dsn , $user , $pass) ; // start anew connection with PDO class
	}
	catch (PDOException $e){

		echo 'Failed' . $e->getMessage();
	}

?> 