<?php 
session_start(); #resume the session 
include  'connectDB.php' ; #connect database
if (isset($_SESSION["profName"])){
if (enoughQuestion($_SESSION["course"],$db)) {echo "there is enough question";}
else {echo "No enough questions";}
}
else if ((isset($_SESSION["studentName"]))){
if (enoughQuestion($_SESSION["course"],$db)) {echo "there is enough question";}
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
	$_SESSION["QuestionNum"] = 0 ; 
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
		$meduimIDS = array_slice($numOFeasyIDS,0,$requirdEasyNumber);
		foreach ($meduimIDS as $Mid){   #generate meduim question
			generateQuestion($course , $value, 2 , $Mid , $db);
		} 

		$numOFhardIDS = range(1,$existHardNumber);
		shuffle($numOFhardIDS);
		$hardIDS = array_slice($numOFeasyIDS,0,$requirdEasyNumber);
		foreach ($hardIDS as $Hid){   #generate hard queation
			generateQuestion($course , $value, 3 , $Hid , $db);
		} 
}



?></form><?php 
}

function generateQuestion($course , $chapter, $level , $ID , $db)
{
	
}

?>