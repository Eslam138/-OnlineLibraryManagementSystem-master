<?php

?>


<!DOCTYPE html>
	<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="../css/title.css">
		<link rel="stylesheet" type="text/css" href="../css/register.css">
	</head>
	<body>
		<div class="title">Register</div>
		<div class="addMemberForm">
			<form action="home.php" method="POST" enctype="multipart/form-data" class="addform">

				<div class="inputs">
					<input type="text" name="firstName" required autofocus placeholder="First-Name" pattern="[A-Za-z]{3,}" title="First name must contain atleast 3 letters.">
				</div>

				<div class="inputs">
					<input type="text" name="lastName" required autofocus placeholder="Last-Name" pattern="[A-Za-z]{3,}" title="Last name must contain atleast 3 letters.">
				</div>

				<div class="inputs">
					<input type="text" name="username" required autofocus placeholder="Username" pattern="[A-Za-z0-9]{6,}" title="Username must be greater than 5 characters.">
				</div>

				<div class="inputs">
					<input type="password" name="pwd" required autofocus placeholder="Password">
				</div>
				<div class="inputs">
					<input type="text" name="mobile" required autofocus placeholder="Mobile" pattern="[0-9]{11}">
				</div>

				<div class="inputs">
					<input type="email" name="email" required autofocus placeholder="Email" title="example.example1@gmail.com">
				</div>
				<input type="submit" name="addStudentBtn" value="Add Student">
				<input type="submit" name="addAdminBtn" value="Add Admin">
			</form>
		</div>
	</body>
</html>