<?php 
// connect database 
$dsn = 'mysql:host=localhost;dbname=qbank'; // Data sourse name
	$user = 'root' ; // the user to connect

	$pass = '';


	try {
		$db = new PDO($dsn , $user , $pass) ; // start anew connection with PDO class
		echo 'You are connected successfully';
	}
	catch (PDOException $e){

		echo 'Failed' . $e->getMessage();
	}

creatStudentTable($db) ; 
creatProfable($db) ; 
creatSsubjectsTable($db);
creatQestionsTable($db);
creatGradeTable($db);
creatResultTable($db);


















function creatStudentTable($db) {
	try {
		    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS Students (
    Student_id INT(6)  PRIMARY KEY, 
    Name VARCHAR(30) NOT NULL,
    
    Grade CHAR(15) NOT NULL,
      FOREIGN KEY (Grade) REFERENCES Grede(Grade)
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    echo "Table Students created successfully";
    echo "<br/>";

	}
	
	catch (PDOException $e){

		echo 'Failed' . $e->getMessage();
	}
}
function creatProfable($db) {
	try {
		    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS Prof (
    Prof_id INT(6)  PRIMARY KEY, 
    Name VARCHAR(30) NOT NULL,
    
    Sub_id INT(1) NOT NULL,
      FOREIGN KEY (Sub_id) REFERENCES Subjects(Sub_id)
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    echo "Table Prof created successfully";
    echo "<br/>";
	}
	
	catch (PDOException $e){

		echo 'Failed' . $e->getMessage();
	}
}

function creatSsubjectsTable($db) {
	try {
		    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS Subjects (
    Sub_id INT(6)  PRIMARY KEY, 
    Name VARCHAR(30) NOT NULL
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    echo "Table Subjects created successfully";
    echo "<br/>";
	}
	
	catch (PDOException $e){

		echo 'Failed' . $e->getMessage();
	}
}

function creatQestionsTable($db) {
	try {
		    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS questions (

    question TEXT(255) NOT NULL ,
    answer1 VARCHAR(20) NOT NULL , 
    answer2 VARCHAR(20) NOT NULL , 
    answer3 VARCHAR(20) NOT NULL , 
    answer4 VARCHAR(20) NOT NULL ,
    correctAns INT(1) NOT NULL ,  
    Level INT(1) NOT NULL , 

    Sub_id INT(6)  NOT NULL,
    FOREIGN KEY (Sub_id) REFERENCES Subjects(Sub_id)
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    echo "Table questions created successfully";
    echo "<br/>";
	}
	
	catch (PDOException $e){

		echo 'Failed' . $e->getMessage();
	}
}

function creatGradeTable($db) {
	try {
		    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS Grede (
    Grade  CHAR(15)  PRIMARY KEY, 
     Sub1_id INT(1) NOT NULL,
     Sub2_id INT(1) NOT NULL,
     Sub3_id INT(1) NOT NULL,
      FOREIGN KEY (Sub1_id) REFERENCES Subjects(Sub_id),
      FOREIGN KEY (Sub2_id) REFERENCES Subjects(Sub_id),
      FOREIGN KEY (Sub3_id) REFERENCES Subjects(Sub_id)
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    echo "Table Grade created successfully";
    echo "<br/>";
	}
	
	catch (PDOException $e){

		echo 'Failed' . $e->getMessage();
	}
}

function creatResultTable($db) {
	try {
		    // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS Result (
    Student_id INT(6)  PRIMARY KEY,
     Sub_id INT(6) NOT NULL ,
     Result INT(3) NOT NULL
      FOREIGN KEY (Student_id) REFERENCES Students(Student_id),
      FOREIGN KEY (Sub_id) REFERENCES Subjects(Sub_id)
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    echo "Table Result created successfully";
    echo "<br/>";
	}
	
	catch (PDOException $e){

		echo 'Failed' . $e->getMessage();
	}
}
   
?>