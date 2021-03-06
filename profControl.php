<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
</style>
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
		<a href="http://localhost:8080/QuestionBank/logout.php">Logout</a><br>
		<a href="http://localhost:8080/QuestionBank/bank.php">Main page</a>
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
	else if (isset($_POST['viewResults'])) {
		if (noResult($_POST['course'],$db)){echo "<h3>There is no result to View </h3>";}
			else {viewResult($_POST['course'],$db);}
}
	else if (isset($_POST['genExam'])) {$_SESSION["course"]=$_POST['course'] ;echo "generating exam";
header( "Location:exam.php" );}
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
	function viewResult($course,$db)
{

try {
   
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->prepare("SELECT s.Name,
								   r.result 
						   	FROM Result r
						   	JOIN Students s 
						   		USING (Student_id)
						   		WHERE r.course = '$course'
						   	ORDER BY r.result

						   	"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

$allResults =$stmt->fetchAll() ; 

echo "<br><h2>Results</h2><br>";

////////////////////////////
?><table style="width:100%">
  <tr>
    <th>Student Name</th>
    <th>Result</th> 
  </tr>

  <?php foreach ($allResults as $singleResulr) {
  	?>
 	<tr>
    	<td><?php echo $singleResulr["Name"]; ?></td>
    	<td><?php echo $singleResulr["result"]; ?></td>
  	</tr>

  <?php 
  } ?>
 
 
</table><?php
//////////////////////////



// print_r(new RecursiveArrayIterator($stmt->fetchAll()));
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
}
function noResult($course,$db)
	{

	
		$tableName = "Result" ; 
		$sql = "SELECT count(*) 
				FROM `$tableName` 
				WHERE course = '$course' "; 
		$result = $db->prepare($sql); 
		$result->execute(); 
		$number_of_rows = $result->fetchColumn();
		
		if ($number_of_rows >0){
			return False ; 
		} else {
			return True ; 
		}
	}
?>