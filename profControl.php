<?php 
session_start(); #resume the session 
include  'connectDB.php' ; #connect database
if (isset($_SESSION["profName"])){
	?><fieldset>
		<legend>Personal information:</legend>
		<?php echo 'PROFESSOR name: ' .$_SESSION["profName"] . '<br>'.'PROFESSOR ID: ' .$_SESSION["profID"] .'<br>'; ?>
	</fieldset>
	<br><br>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
chose the course:  
	<select name="course" required>
		<option disabled selected value> -- select an option -- </option>
		<option value="distribution">power : distribution </option>
		<option value="machine">power :machine</option>
		<option value="Highvoltage">power :High voltage</option>
		<option value="antenna">communication:antenna</option>
		<option value="DSP">communication:DSP</option>
		<option value="electronics">communication:electronics</option>
		<option value="control">computer:control</option>
		<option value="Database">computer:Database</option>
		<option value="Datastructures">computer:Data structures</option>
	</select><br> 
		What do you want to do:<br>
		<br><br>
		<input type="submit" name="addQuestion" value="Add Question"/>
		<input type="submit" name="viewResults" value="View Results"/>
		<input type="submit" name="genExam" value="Genetate Exam"/>
		<input type="submit" name="rules" value="examRules"/>
		<br><br> 
		<a href="http://localhost:8080/QuestionBank/logout.php">Logout</a>
	</form>
	<?php
	if (isset($_POST['addQuestion'])) {
		$_SESSION["course"]=$_POST['course'] ; 

		echo "the name of course os ".$_SESSION["course"]."<br>";
		echo "the name of prof os ".$_SESSION["profName"]."<br>";

if (courseValid( $_SESSION["course"],$_SESSION["profName"],$db)) {
		if (rulesValid($_SESSION["course"],$db)){
		header( "Location:addQuestion.php" );}
		else {echo "You must write the exam rules First";}
	}
		else {echo "Sorry this course is taken by other professor";}
}
	else if (isset($_POST['viewResults'])) {$_SESSION["course"]=$_POST['course'] ;echo "This is result";}
	else if (isset($_POST['genExam'])) {$_SESSION["course"]=$_POST['course'] ;echo "generating exam";}
	else if (isset($_POST['rules'])) {$_SESSION["course"]=$_POST['course'] ;header( "Location:examRules.php" );}  

	 


}
else if ((isset($_SESSION["studentName"]))){
	echo "you are logged in as student";
	header( "refresh:5;url=studentControl.php" );# go to control pages
	echo ' wait to redirect to student control page.';
}
else {echo "You should login first".'<br>';
header( "refresh:5;url=profLogin.php" );# go to control pages
echo ' wait to redirect to Login page.';} 

function courseValid( $course,$profesor,$db)
	{
		$tableName = 'courses' ;
		$prop      = 'Name' ; 
		$columnName= 'profName';
		$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE $prop='".$course."'");
		$f = $q->fetch();
		$result = $f[$columnName];
		
		if ($result == $profesor ||$result == ""  ){
			return true ; 
		} else {
			return false ; 
		}
	}
	function rulesValid( $table,$db)
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
		
		if ($number_of_rows >0){
			return true ; 
		} else {
			return false ; 
		}
	}

?>