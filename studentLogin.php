<?php 
session_start(); #resume the session 
if (!(isset($_SESSION["studentName"]))){ ?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	Name:<br>
	<input type="text" name="name" value="Name"><br>

	Password:<br>
	<input type="Password" name="pass" ><br><br>
	<input type="submit" value="Login">
</form> 
<?php
echo "stuudent login page";
if ($_SERVER['REQUEST_METHOD']=='POST'){
include  'connectDB.php' ; #connect database
if (check($_POST['pass'],$_POST['name'],$db)){
	echo "You have loged in successfuly"."<br>";
	$_SESSION["studentName"] = $_POST['name'];
	$_SESSION["studentID"] = getid( $_POST['pass'],$db);
	$_SESSION["studentGrade"] = getGrade( $_SESSION["studentID"],$db);

header( "refresh:5;url=studentControl.php" );# go to control pages
echo ' wait to redirect to control page.';

}else {
	echo "Student Name or ID is wrong" . "<br>";
}



}







}


else {
	echo "you are logged in";
	header( "refresh:5;url=studentControl.php" );# go to control pages
	echo ' wait to redirect to control page.';
}


function check( $value,$name,$db)
{
	$tableName = 'Students' ;
	$prop      = 'Student_pass' ; 
	$columnName= 'Name';
	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE $prop='".$value."'");
	$f = $q->fetch();
	$result = $f[$columnName];

	if (is_null($result)){
		return false; 
	} else {
		if ($result == $name) {
			return true ; 
		} else {
			return false;
		}
	}
}

function getGrade( $value,$db)
{
	$tableName = 'Students' ;
	$prop      = 'Student_id' ; 
	$columnName= 'Grade';
	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE $prop='".$value."'");
	$f = $q->fetch();
	$result = $f[$columnName];
	return $result;
}
function getid( $value,$db)
{
	$tableName = 'Students' ;
	$prop      = 'Student_pass' ; 
	$columnName= 'Student_id';
	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE $prop='".$value."'");
	$f = $q->fetch();
	$result = $f[$columnName];
	return $result;
}
?>

