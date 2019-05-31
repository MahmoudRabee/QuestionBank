* Exam result is 100 points <br>
* The questions are split into three levels {Easy (one point) - Medium (two points) - Hard (three points)} <br>
* The exam consists of 66 questions (40 easy - 18 Medium - 8 difficult) <br>
* The number of easy, medium and difficult questions in exam should be determined from each chapter <br>
* When determining the number of questions, you must follow the above restrictions <br>
 <br>
<?php 
session_start(); #resume the session 
include  'connectDB.php' ; #connect database
if (isset($_SESSION["profName"])){
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	
	Number of chapters:
	<input type="number" name="number" ><br>
	<br><input type="submit" name="edit" value="Edit" ><br><br><br><input type="submit" name="back" value="back to control page" ><br><br><br>
<?php 
if (isset($_POST['edit'])) {
	addProfToCourse( $_SESSION["profName"] ,$_SESSION["course"], $db) ; 
 
		$numOfChapter = (int)($_POST['number']);
		$_SESSION["Numofcourse"] = $numOfChapter ; 
	echo "define number of question in chapters :"."<br><br>";
for ($i = 1 ; $i <=$numOfChapter ; $i++) {?>
	Chapter <?php echo $i; ?> :  <br> 
	hard: <input type="number" name="Hchapter<?php echo $i; ?>" >
	medium: <input type="number" name="Mchapter<?php echo $i; ?>">
	easy: <input type="number" name="Echapter<?php echo $i; ?>" >
	<br><br>

	 <?php }?> <input type="submit" name="confirm" value="confirm"><br><br>
</form> 

<?php
}else if (isset($_POST['confirm'])) {
$hard = 0 ;
$medium = 0 ; 
$easy = 0 ; 
for ($i = 1 ; $i <=$_SESSION["Numofcourse"] ; $i++) {
		$hard +=(int) $_POST["Hchapter".$i] ; 
		$medium+=(int) $_POST["Mchapter".$i] ; 
		$easy += (int)$_POST["Echapter".$i] ; 
	}
	if ($hard==8 && $medium ==18 && $easy ==40){$isvalid = True;}
		else {$isvalid = False;}

	if ($isvalid) {
	for ($i = 1 ; $i <=$_SESSION["Numofcourse"] ; $i++) {
		fillcourse($_SESSION["course"] , $i ,$_POST["Hchapter".$i] ,$_POST["Mchapter".$i], $_POST["Echapter".$i] , $db);
	}
	echo "sitting is saved";
} else {echo "please write correct number"; }


}
else if (isset($_POST['back'])) {
	header( "Location:profControl.php" );# go to control pages}	
}
}
else if ((isset($_SESSION["studentName"]))){
	echo "you are logged in as student";
	header( "refresh:5;url=studentControl.php" );# go to control pages
	echo ' wait to redirect to student control page.';
}
else {echo "You should login first".'<br>';
header( "refresh:5;url=profLogin.php" );# go to control pages
echo ' wait to redirect to Login page.';} 


function fillcourse($table , $chupternum ,$hnum ,$mnum, $enum , $db)
	{
			if ($table == "Datastructures" ) {$tableName ="DataStructures";} 
			elseif ($table =="Database") {$tableName ="data" ;}
			elseif ($table =="control") {$tableName = "control";}
			elseif ($table =="electronics") {$tableName ="electronics" ;}
			elseif ($table =="DSP") {$tableName ="DSP" ;}
			elseif ($table =="antenna") {$tableName ="antenna" ;}
			elseif ($table =="Highvoltage") {$tableName ="HighVoltage";}
			elseif ($table =="machine") {$tableName ="machine";}
			elseif ($table =="distribution") {$tableName="distribution" ;}


		try {

    // our SQL statements
			$db->exec("INSERT INTO ".$tableName." (chapterNumber, hardQnum, mediumQnum, easyQnum) 
    VALUES (".$chupternum.",".$hnum.",".$mnum.",".$enum.")"); 
		}
		catch (PDOException $e){

			echo 'Failed' . $e->getMessage();
		}
	}

	function addProfToCourse(  $profName , $course, $db)
	{
			
		try {

    $sql = "UPDATE courses SET profName='".$profName."' WHERE Name='".$course."'";

    // Prepare statement
    $stmt =  $db->prepare($sql);

    // execute the query
    $stmt->execute();
		}
		catch (PDOException $e){

			echo 'Failed' . $e->getMessage();
		}
	}


?>