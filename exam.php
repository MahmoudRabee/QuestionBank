<?php 
session_start(); #resume the session 
include  'connectDB.php' ; #connect database
if (isset($_SESSION["profName"])){
	if (enoughQuestion($_SESSION["course"],$db)) {echo "there is enough question";

}
else {echo "No enough questions";}
}
else if ((isset($_SESSION["studentName"]))){
	if (enoughQuestion($_SESSION["course"],$db)) {echo "there is enough question";
	GenerateExam($_SESSION["course"] , $db) ;
	$FinalResult = viewResult(); 
	echo "<h2>Your result is ".$FinalResult." points</h2>";
	storeResult($FinalResult,$db) ; 
	print_r($_SESSION["correctAnswer"]);
	print_r($_SESSION["level"]); 
}
else {echo "No enough questions";}

}


else {echo "You should login first".'<br>';
header( "refresh:5;url=bank.php" );# go to control pages
echo ' wait to redirect to main page.';} 


function enoughQuestion($course,$db)
{
	$number_of_chapters = getNOchapter( $course,$db);
	for ($i = 1 ; $i <=$number_of_chapters ; $i++){
		$existEasyNumber = getLevelID($course,1,$i,$db); 
		$existMeduimNumber = getLevelID($course,2,$i,$db); 
		$existHardNumber = getLevelID($course,3,$i,$db); 
		$requirdEasyNumber = gitMinNum( $course,$i,1,$db);
		$requirdMeduimNumber = gitMinNum( $course,$i,2,$db);
		$requirdHardNumber = gitMinNum( $course,$i,3,$db) ;
		if ($existEasyNumber < $requirdEasyNumber || $existMeduimNumber < $requirdMeduimNumber || $existHardNumber < $requirdHardNumber){return False ; }
	}
	return True ; 

}
function getNOchapter( $table,$db)
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




	$sql = "SELECT count(*) FROM `$tableName` "; 
	$result = $db->prepare($sql); 
	$result->execute(); 
	$number_of_rows = $result->fetchColumn(); 

	// 		$columnName = COUNT(*) ;
	// $q = $db->query("SELECT `$columnName` FROM `$tableName` ");
	// $f = $q->fetch();
	// $result = $f[$columnName];
	return $number_of_rows;
}

function getLevelID($course,$level,$chapter,$db)
{



	$tableName="questions" ;

	$sql = "SELECT count(*) FROM `$tableName`  WHERE Level = '$level' AND chapter ='$chapter'  AND course='$course' "; 
	$result = $db->prepare($sql); 
	$result->execute(); 
	$number_of_rows = $result->fetchColumn(); 

	return $number_of_rows;
}

function gitMinNum( $table,$value ,$level,$db)
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
	if ($level == 1 ){$columnName= 'easyQnum';}
	elseif ($level == 2 ){$columnName= 'mediumQnum';}
	elseif ($level == 3 ){$columnName= 'hardQnum';}

	

	$prop= 'chapterNumber' ; 
	
	// $q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE $prop='".$chapter."'");
	// $f = $q->fetch();
	// $result = $f[$columnName];

	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE $prop='".$value."'");
	$f = $q->fetch();
	$result = $f[$columnName];

	return $result ; 
}

function GenerateExam($course , $db) 
{
	$_SESSION["QuestionNum"] = 1 ;
	$_SESSION["correctAnswer"] = array(1);
	$_SESSION["level"] = array(1);

	?><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"><?php
	$number_of_chapters = getNOchapter( $course,$db);
	$numOFchapter = range(1,$number_of_chapters);
	shuffle($numOFchapter);
	foreach ($numOFchapter as $value){
		$existEasyNumber = getLevelID($course,1,$value,$db); 
		$existMeduimNumber = getLevelID($course,2,$value,$db); 
		$existHardNumber = getLevelID($course,3,$value,$db);
		$requirdEasyNumber = gitMinNum( $course,$value,1,$db);
		$requirdMeduimNumber = gitMinNum( $course,$value,2,$db);
		$requirdHardNumber = gitMinNum( $course,$value,3,$db) ;

		$numOFeasyIDS = range(1,$existEasyNumber);
		shuffle($numOFeasyIDS);
		$easyIDS = array_slice($numOFeasyIDS,0,$requirdEasyNumber);

		foreach ($easyIDS as $Eid){  #generate easy questions
			generateQuestion($course , $value, 1 , $Eid , $db);
		} 

		$numOFmeduimIDS = range(1,$existMeduimNumber);
		shuffle($numOFmeduimIDS);
		$meduimIDS = array_slice($numOFmeduimIDS,0,$requirdMeduimNumber);
		foreach ($meduimIDS as $Mid){   #generate meduim question
			generateQuestion($course , $value, 2 , $Mid , $db);
		} 

		$numOFhardIDS = range(1,$existHardNumber);
		shuffle($numOFhardIDS);
		$hardIDS = array_slice($numOFhardIDS,0,$requirdHardNumber);

		foreach ($hardIDS as $Hid){   #generate hard queation
			generateQuestion($course , $value, 3 , $Hid , $db);
		} 
	}



	?>
	<input type="submit" name="result" value="View result">
	</form><?php 


	if ($_SERVER['REQUEST_METHOD']=='POST') {viewResult(); }
}

function generateQuestion($course , $chapter, $level , $ID , $db)
{






 # select  question
	$tableName = 'questions' ;
	$columnName= 'question';
	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE Level = '$level' AND chapter ='$chapter'  AND course='$course' AND ID='$ID' "); 
	$f = $q->fetch();
	$question = $f[$columnName];
# display question in page 
	echo "<fieldset>";
	echo "<ul>";
	echo "Q ".$_SESSION["QuestionNum"].": ".$question."<br><br><br>";




 # select ans1 
	$tableName = 'questions' ;
	$columnName= 'answer1';
	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE Level = '$level' AND chapter ='$chapter'  AND course='$course' AND ID='$ID' "); 
	$f = $q->fetch();
	$ans1 = $f[$columnName];
# display answer in page 
	?>
	<li><input type="radio" name="q<?php echo($_SESSION["QuestionNum"]);?>" id="crust1" value="ans1" /><label for="crust1"><?php echo $ans1;?></label></li><br>
	<?php 

 #select ans2
	$tableName = 'questions' ;
	$columnName= 'answer2';
	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE Level = '$level' AND chapter ='$chapter'  AND course='$course' AND ID='$ID' "); 
	$f = $q->fetch();
	$ans2 = $f[$columnName];
# display answer in page 
	?>
	<li><input type="radio" name="q<?php echo($_SESSION["QuestionNum"]);?>" id="crust2" value="ans2" /><label for="crust2"><?php echo $ans2;?></label></li> <br>
	<?php 
 #select ans3
	$tableName = 'questions' ;
	$columnName= 'answer3';
	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE Level = '$level' AND chapter ='$chapter'  AND course='$course' AND ID='$ID' "); 
	$f = $q->fetch();
	$ans3 = $f[$columnName];
# display answer in page 
	?>
	<li><input type="radio" name="q<?php echo($_SESSION["QuestionNum"]);?>" id="crust3" value="ans3" /><label for="crust3"><?php echo $ans3;?></label></li> <br>
	<?php 
 #select ans4
	$tableName = 'questions' ;
	$columnName= 'answer4';
	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE Level = '$level' AND chapter ='$chapter'  AND course='$course' AND ID='$ID' "); 
	$f = $q->fetch();
	$ans4 = $f[$columnName];
# display answer in page 
	?>
	<li><input type="radio" name="q<?php echo($_SESSION["QuestionNum"]);?>" id="crust4" value="ans4" /><label for="crust4"><?php echo $ans4;?></label></li> <br>
	<?php 

# select correct answer
	$tableName = 'questions' ;
	$columnName= 'correctAns';
	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE Level = '$level' AND chapter ='$chapter'  AND course='$course' AND ID='$ID' "); 
	$f = $q->fetch();
	$correctAnswer = $f[$columnName];
	$_SESSION["correctAnswer"][] = $correctAnswer ; 
	$_SESSION["level"][] = $level ; 
	echo "</ul> ";
	echo "</fieldset> ";
	$_SESSION["QuestionNum"] ++ ; }
	
function viewResult()
	{
		$result = 0 ; 
		for ($i =1 ;  $i<=6 ; $i++){
			if ($_POST["q".$i] == "ans1" ) {$answer = 1;}
			elseif ($_POST["q".$i] == "ans2" ) {$answer = 2;}
			elseif ($_POST["q".$i] == "ans3" ) {$answer = 3;}
			elseif ($_POST["q".$i] == "ans4" ) {$answer = 4;}

			if ($answer ==$_SESSION["correctAnswer"][$i]) {
				$result += $_SESSION["level"][$i];
			}
		}
		return $result ; 
		 
	}

	function storeResult($result,$db)
	{
		$s_ID = $_SESSION["studentID"] ; 
		$course = $_SESSION["course"] ; 
		try {

    // our SQL statements
			$db->exec("INSERT INTO Result(Student_id,course, Result) 
				VALUES ('".$s_ID."','".$course."','".$result."')");   
		}
		catch (PDOException $e){

			echo 'Failed' . $e->getMessage();
		}
	}

	?>