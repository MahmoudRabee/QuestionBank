<?php 
session_start(); #resume the session 
if (isset($_SESSION["profName"])){
	include  'connectDB.php' ; #connect database
$numberOfChupter =getNOchapter($_SESSION["course"],$db);
// echo "the number of ".$_SESSION["course"]."  table os :".getNOchapter( $_SESSION["course"],$db);
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Question : <input type="text" name="question" size="40" ><br><br>
	Answer1: <input type="text" name="pass" size="40" required><br><br>
	Answer2: <input type="text" name="pass" size="30" required><br><br>
	Answer3: <input type="text" name="pass" size="20" required><br><br>
	Answer4: <input type="text" name="pass" size="10" required><br><br>
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

	
</form> 

<?php
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
?>