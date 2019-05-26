<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  Name:<br>
  <input type="text" name="name" value="Name"><br>

 ID:<br>
 <input type="text" name="id" value="ID"><br><br>
  <input type="submit" value="Login">
</form> 


<?php
echo "stuudent login page";
if ($_SERVER['REQUEST_METHOD']=='POST'){
session_start() ; #start the session 
include  'connectDB.php' ; #connect database
if (check($_POST['id'],$_POST['name'],$db)){
echo "You have loged in successfuly"."<br>";
$_SESSION["studentName"] = $_POST['name'];
$_SESSION["studentID"] = $_POST['id'];
$_SESSION["studentGrade"] = getGrade( $_POST['id'],$db);

header( "refresh:5;url=studentControl.php" );# go to control pages
echo ' wait to redirect to control page.';

}else {
 echo "Student Name or ID is wrong" . "<br>";
}



}



function check( $value,$name,$db)
{
	$tableName = 'Students' ;
	$prop      = 'Student_id' ; 
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


?>