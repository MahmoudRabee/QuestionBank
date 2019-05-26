
<?php 
session_start(); #resume the session 
if (isset($_SESSION["studentName"])){
	?>
	<fieldset>
		<legend>Personal information:</legend>
		<?php echo 'Student name: ' .$_SESSION["studentName"] . '<br>'.'Student ID: ' .$_SESSION["studentID"] .'<br>'.'Student class: ' .$_SESSION["studentGrade"] . '<br>'; ?>
	</fieldset>
	<?php if ($_SESSION["studentGrade"] == 'power') {$courses = array('distribution','machine', 'High voltage');}
	if ($_SESSION["studentGrade"] == 'communication') {$courses = array('electronics','antenna','DSP');}
	if ($_SESSION["studentGrade"] == 'computer'){$courses = array('Database','control','Data structures');}
	?>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

		Select course:<br>
		<select name="course">
			<option disabled selected value> -- select an option -- </option>
			<option value="<?php echo $courses[0];?>"><?php echo $courses[0];?></option>
			<option value="<?php echo $courses[1];?>"><?php echo $courses[1];?></option>
			<option value="<?php echo $courses[2];?>"><?php echo $courses[2];?></option>
		</select>
		<br><br>

		<input type="submit" name="Exam" value="Take Exam"/>

		<input type="submit" name="Result" value="View Result"/>
		<br><br> 
		<a href="http://localhost:8080/QuestionBank/logout.php">Logout</a>

	</form>

	<?php


	if ($_SERVER['REQUEST_METHOD']=='POST'){
		include 'connectDB.php' ; #connect database
		if (isset($_POST['course'])){
			if (isset($_POST['Exam'])) {
				if (Null !== getResult($_SESSION["studentID"],$_POST['course'],$db)){
					echo "You already Take exam in this course";
	   } else { header( "Location:exam.php" );# go to control pages }
	}}
	else if (isset($_POST['Result'])) {
		
	   	include  'connectDB.php' ; #connect database
	   	if (NULL !== getResult($_SESSION["studentID"],$_POST['course'],$db)){
	   		echo "Your result in ".$_POST['course']." is : " .getResult($_SESSION["studentID"],$_POST['course'],$db)."<br>";
	   	}
	   	else {echo "You have not take exam in this course";}
	   }
	}
	else {
		echo "Please selest course ";
	}
}


} else {

	echo "You should login first".'<br>';
header( "refresh:5;url=studentLogin.php" );# go to control pages
echo ' wait to redirect to Login page.';

}

function getResult( $id,$course,$db)
{
	$tableName = 'Result' ;
	$prop      = 'Student_id' ; 
	$cor       = 'course';
	$columnName= 'Result';
	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE $prop='".$id."' AND $cor='".$course."'");
	$f = $q->fetch();
	$result = $f[$columnName];
	return $result;
}
?>