<?php 
include_once  'connectDB.php' ; #connect database
include 'creatTables.php' ; 	# creat tables 

echo '
<body>
	<h1>Welcom in Question Bank</h1>
	<p>This is website you can take an online auto generated exam </p>

<form action="Student.html">
  <input type="submit" value="Student">
</form>
<form action="Prof.html">
  <input type="submit" value="doctor">
</form>

</body>

';



?>