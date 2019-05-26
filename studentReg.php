<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Name:<br>
	<input type="text" name="name" value="Name"><br><br>
	ID:<br>
	<input type="text" name="id" value="ID"><br><br>
	Password:<br>
	<input type="Password" name="pass" ><br><br>
	Grade:<br>
	<select name="Grade">
		<option value="power">power</option>
		<option value="communication">communication</option>
		<option value="computer">computer</option>
	</select>
	<input type="submit" value="Regisrer">
</form>


<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){
	include  'connectDB.php' ; #connect database

	if (checkid($_POST['id'],$db)){
		register($_POST['name'] , $_POST['id'] , $_POST['pass'], $_POST['Grade'],$db);
		echo '
		<form action="studentLogin.php">
		You have created an account successfully 
		<input type="submit" value="Login">
		</form>
		';

	} else {
		echo "this student ID is allready exist"."<br>";
	}
}


function register($name , $id ,$pass, $grade ,$db){
	try {

    // our SQL statements
		$db->exec("INSERT INTO Students (Student_id,Student_pass, Name, Grade ) 
			VALUES ('".$id."','".$pass."','".$name."','".$grade."')");   
	}
	catch (PDOException $e){

		echo 'Failed' . $e->getMessage();
	}
}


function checkid( $value,$db)
{
	$tableName = 'Students' ;
	$prop      = 'Student_id' ; 
	$columnName= 'Student_id';
	$q = $db->query("SELECT `$columnName` FROM `$tableName` WHERE $prop='".$value."'");
	$f = $q->fetch();
	$result = $f[$columnName];

	if (is_null($result)){
		return true ; 
	} else {
		return false ; 
	}
}
?>