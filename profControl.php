<?php 
session_start(); #resume the session 
?>
<fieldset>
	<legend>Personal information:</legend>
	<?php echo 'PROFESSOR name: ' .$_SESSION["profName"] . '<br>'.'PROFESSOR ID: ' .$_SESSION["profID"] .'<br>'.'PROFESSOR COURSE: ' .$_SESSION["profCourse"] . '<br>'; ?>
</fieldset>