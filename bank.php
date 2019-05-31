<?php 
include_once  'connectDB.php' ; #connect database
include 'creatTables.php' ; 	# creat tables 

echo '
<body>
	<h1>Welcom in MCQ Question Bank</h1>
	<p><h3>In this is website you can take an online auto generated exam </h3></p>

<form action="Student.html">
  <input type="submit" value="Student">
</form>
<form action="Prof.html">
  <input type="submit" value="doctor">
</form>

</body>

';



?>