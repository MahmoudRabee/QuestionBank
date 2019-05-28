<?php 
session_start(); #resume the session 
if (isset($_SESSION["profName"])){
	include  'connectDB.php' ; #connect database
$numberOfChupter =getNOchapter($_SESSION["course"],$db);
// echo "the number of ".$_SESSION["course"]."  table os :".getNOchapter( $_SESSION["course"],$db);
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Question : <input type="text" name="question" size="40" ><br><br>
	Answer1: <input type="text" name="ans1" size="40" required><br><br>
	Answer2: <input type="text" name="ans2" size="40" required><br><br>
	Answer3: <input type="text" name="ans3" size="40" required><br><br>
	Answer4: <input type="text" name="ans4" size="40" required><br><br>
	Correct answer : <select name="correctAnswer" required>
		<option disabled selected value> -- select an option -- </option>
		<option value='1'>1</option>
		<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='4'>4</option>
	</select><br> 
	Difficulty Level : <select name="level" required>
		<option disabled selected value> -- select an option -- </option>
		<option value="hard">Hard</option>
		<option value="meduim">Meduim</option>
		<option value="easy">Easy</option>
	</select><br>


		Chapter : <select name="Chapter" required>
		<option disabled selected value> -- select an option -- </option>
		<?php for ($i = 1 ; $i<=$numberOfChupter ; $i++) {?>
		<option value='<?php echo $i; ?>'><?php echo $i; ?></option>
		<?php } ?>
	</select><br> 

	<input type="submit" name="add" value="Add Question">

	<a href="http://localhost:8080/QuestionBank/profControl.php">Back to control page</a>
</form> 

<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){
$cans = (int) $_POST["correctAnswer"] ;
if ($_POST["level"] == "hard") {$qlevel = 3;}
elseif ($_POST["level"] == "meduim") {$qlevel = 2;}
elseif ($_POST["level"] == "easy") {$qlevel = 1;}
$qcourse = $_SESSION["course"] ; 
$qchapter =(int) $_POST["Chapter"];
$qid = (getLevelID($qcourse,$qlevel,$qchapter,$db))+1 ; 
addQuestion($_POST["question"] , $_POST["ans1"] ,$_POST["ans2"],$_POST["ans3"], $_POST["ans4"],$cans , $qlevel ,$qchapter,$qid ,$qcourse,$db);
echo "Question added successfuly"."<br>";
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
function addQuestion($question , $answer1 ,$answer2,$answer3, $answer4, $correctAns , $Level ,$chapter,$ID ,$course,$db)
	{
		try {

    // our SQL statements
			$db->exec("INSERT INTO questions(question,answer1, answer2,answer3,answer4,correctAns,Level,chapter,ID,course ) 
				VALUES ('".$question."','".$answer1."','".$answer2."','".$answer3."','".$answer4."','".$correctAns."','".$Level."','".$chapter."','".$ID."','".$course."')");   
		}
		catch (PDOException $e){

			echo 'Failed' . $e->getMessage();
		}
	}
?>