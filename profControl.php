<?php 
session_start(); #resume the session 
if (isset($_SESSION["profName"])){
	?><fieldset>
		<legend>Personal information:</legend>
		<?php echo 'PROFESSOR name: ' .$_SESSION["profName"] . '<br>'.'PROFESSOR ID: ' .$_SESSION["profID"] .'<br>'; ?>
	</fieldset>
	<br><br>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
chose the course:  
	<select name="course" required >
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
	if (isset($_POST['addQuestion'])) {$_SESSION["course"]=$_POST['course'] ; header( "Location:addQuestion.php" );}
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

?>