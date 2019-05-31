<?php 
creatGradeTable($db);
creatStudentTable($db) ; 
creatQestionsTable($db);
creatProfable($db) ;
creatResultTable($db);
createlectronicsTable($db) ;
createlDSPTable($db) ;
creatantennaTable($db) ;
createlmachineTable($db) ;
createldistributionTable($db) ;
createlHighVoltageTable($db) ;
createlDataStructuresTable($db) ;
creatcontrolTable($db) ;
creatcoursesTable($db);
creatDataTable($db);
FillSubjectTable($db);
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
        Name VARCHAR(30) NOT NULL
    )";

    // use exec() because no results are returned
    $db->exec($sql);

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
        answer1 VARCHAR(255) NOT NULL , 
        answer2 VARCHAR(255) NOT NULL , 
        answer3 VARCHAR(255) NOT NULL , 
        answer4 VARCHAR(255) NOT NULL ,
        correctAns INT(1) NOT NULL ,  
        Level INT(1) NOT NULL , 
        chapter INT(5) NOT NULL,
        ID INT(5) NOT NULL,
        course VARCHAR(30)  NOT NULL
    )";

    // use exec() because no results are returned
    $db->exec($sql);
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
     
 }

 catch (PDOException $e){

  echo 'Failed' . $e->getMessage();
}
} 


function createlectronicsTable($db) {
    try {
            // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS electronics (

        chapterNumber int(5) NOT NULL ,
        hardQnum int(5) NOT NULL , 
        mediumQnum int(5) NOT NULL , 
        easyQnum int(5) NOT NULL 
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    
}

catch (PDOException $e){

  echo 'Failed' . $e->getMessage();
}
}

function creatcontrolTable($db) {
    try {
            // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS control (

        chapterNumber int(5) NOT NULL ,
        hardQnum int(5) NOT NULL , 
        mediumQnum int(5) NOT NULL , 
        easyQnum int(5) NOT NULL 
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    
}

catch (PDOException $e){

  echo 'Failed' . $e->getMessage();
}
}
function createlDataStructuresTable($db) {
    try {
            // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS DataStructures (

        chapterNumber int(5) NOT NULL ,
        hardQnum int(5) NOT NULL , 
        mediumQnum int(5) NOT NULL , 
        easyQnum int(5) NOT NULL 
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    
}

catch (PDOException $e){

  echo 'Failed' . $e->getMessage();
}
}
function createldistributionTable($db) {
    try {
            // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS distribution(

        chapterNumber int(5) NOT NULL ,
        hardQnum int(5) NOT NULL , 
        mediumQnum int(5) NOT NULL , 
        easyQnum int(5) NOT NULL 
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    
}

catch (PDOException $e){

  echo 'Failed' . $e->getMessage();
}
}
function createlmachineTable($db) {
    try {
            // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS machine (

        chapterNumber int(5) NOT NULL ,
        hardQnum int(5) NOT NULL , 
        mediumQnum int(5) NOT NULL , 
        easyQnum int(5) NOT NULL 
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    
}

catch (PDOException $e){

  echo 'Failed' . $e->getMessage();
}
}
function createlHighVoltageTable($db) {
    try {
            // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS HighVoltage (

        chapterNumber int(5) NOT NULL ,
        hardQnum int(5) NOT NULL , 
        mediumQnum int(5) NOT NULL , 
        easyQnum int(5) NOT NULL 
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    
}

catch (PDOException $e){

  echo 'Failed' . $e->getMessage();
}
}
function createlDSPTable($db) {
    try {
            // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS DSP (

        chapterNumber int(5) NOT NULL ,
        hardQnum int(5) NOT NULL , 
        mediumQnum int(5) NOT NULL , 
        easyQnum int(5) NOT NULL 
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    
}

catch (PDOException $e){

  echo 'Failed' . $e->getMessage();
}
}
function creatantennaTable($db) {
    try {
            // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS antenna (
                                           
        chapterNumber int(5) NOT NULL ,
        hardQnum int(5) NOT NULL , 
        mediumQnum int(5) NOT NULL , 
        easyQnum int(5) NOT NULL 
    )";

    // use exec() because no results are returned
    $db->exec($sql);
    
}

catch (PDOException $e){

  echo 'Failed' . $e->getMessage();
}
}

function creatcoursesTable($db) {
    try {
            // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS courses (
    Sub_id INT(6)  PRIMARY KEY,
    Name VARCHAR(30) NOT NULL, 
     profName VARCHAR(30) NOT NULL
    )";
    // use exec() because no results are returned
    $db->exec($sql);
    
    }
    
    catch (PDOException $e){
        echo 'Failed' . $e->getMessage();
    }
}
function FillSubjectTable($db) {
    try {
           $db->beginTransaction();
    // our SQL statements
    $db->exec("INSERT INTO courses (Sub_id, Name) 
    VALUES (1, 'electronics')");
  $db->exec("INSERT INTO courses (Sub_id, Name) 
    VALUES (2, 'antenna')");
  $db->exec("INSERT INTO courses (Sub_id, Name) 
    VALUES (3, 'DSP')");
  $db->exec("INSERT INTO courses (Sub_id, Name) 
    VALUES (4, 'High voltage')");
  $db->exec("INSERT INTO courses (Sub_id, Name) 
    VALUES (5, 'machine')");
  $db->exec("INSERT INTO courses (Sub_id, Name) 
    VALUES (6, 'distribution')");
  $db->exec("INSERT INTO courses (Sub_id, Name) 
    VALUES (7, 'Database')");
  $db->exec("INSERT INTO courses (Sub_id, Name) 
    VALUES (8, 'control')");
  $db->exec("INSERT INTO courses (Sub_id, Name) 
    VALUES (9, 'Data structures')");
    // commit the transaction
    $db->commit();
    
    }
    
    catch (PDOException $e){
        echo 'Failed' . $e->getMessage();
    }
}

function creatDataTable($db) {
    try {
            // sql to create table
    $sql = "CREATE TABLE IF NOT EXISTS data (
        chapterNumber int(5) NOT NULL ,
        hardQnum int(5) NOT NULL , 
        mediumQnum int(5) NOT NULL , 
        easyQnum int(5) NOT NULL 
    )";
    // use exec() because no results are returned
    $db->exec($sql);

    }
    
    catch (PDOException $e){
        echo 'Failed' . $e->getMessage();
    }
}

?>