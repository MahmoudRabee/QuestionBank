<?php 
creatGradeTable($db);
creatStudentTable($db) ; 
creatQestionsTable($db);
creatProfable($db) ;
creatResultTable($db);
FillGradeTable($db);




function creatStudentTable($db) {
	try {
		    // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS Students (
        Student_id INT(6)  PRIMARY KEY,
        Student_pass VARCHAR(30) NOT NULL, 
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
        Prof_pass VARCHAR(30) NOT NULL,
        Name VARCHAR(30) NOT NULL,
        course VARCHAR(30) NOT NULL
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

        course VARCHAR(30)  NOT NULL
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
        course1 VARCHAR(20) NOT NULL , 
        course2 VARCHAR(20) NOT NULL , 
        course3 VARCHAR(20) NOT NULL 
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
        Student_id INT(6)  NOT NULL,
        course VARCHAR(30) NOT NULL,
        Result INT(3) NOT NULL,
        FOREIGN KEY (Student_id) REFERENCES Students(Student_id)
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
function FillGradeTable($db) {
	try {
     $db->beginTransaction();
    // our SQL statements
     $db->exec("INSERT INTO Grede (Grade, course1,course2, course3 ) 
        VALUES ('communication', 'electronics','antenna','DSP')");
     $db->exec("INSERT INTO Grede (Grade, course1,course2, course3 ) 
        VALUES ('power', 'High voltage','machine','distribution')");
     $db->exec("INSERT INTO Grede (Grade, course1,course2, course3 ) 
        VALUES ('computer', 'Data structures','control','Database')");
    // commit the transaction
     $db->commit();
     echo "add Grade created successfully";
     echo "<br/>";
 }

 catch (PDOException $e){

  echo 'Failed' . $e->getMessage();
}
} 
?>