<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Name:<br>
	<input type="text" name="name" ><br><br>
	ID:<br>
	<input type="text" name="id" ><br><br>
	Password:<br>
	<input type="Password" name="pass" ><br><br>

	<input type="submit" value="Regisrer">
</form>


<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){

	include  'connectDB.php' ; #connect database
	 
		if (checkid($_POST['id'],$db)){
			if (strlen($_POST['name']) == 0 || strlen($_POST['id']) == 0 || strlen($_POST['pass']) == 0 ){
				echo "Data missing !!! ";


			} else {
				register($_POST['name'] , $_POST['id'] , $_POST['pass'],$db);
				echo '
				<form action="profLogin.php">
				You have created an account successfully 
				<input type="submit" value="Login">
				</form>
				';

			} 
		} else {
			echo "this professor ID is allready exist"."<br>";
		}
	}


	function register($name , $id ,$pass ,$db)
	{
		try {

    // our SQL statements
			$db->exec("INSERT INTO Prof(Prof_id,Prof_pass, Name ) 
				VALUES ('".$id."','".$pass."','".$name."')");   
		}
		catch (PDOException $e){

			echo 'Failed' . $e->getMessage();
		}
	}


	function checkid( $value,$db)
	{
		$tableName = 'Prof' ;
		$prop      = 'Prof_id' ; 
		$columnName= 'Prof_id';
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