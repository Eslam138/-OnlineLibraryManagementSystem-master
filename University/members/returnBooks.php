<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="../../css/inputs.css">
		<link rel="stylesheet" type="text/css" href="../../css/title.css">
		<link rel="stylesheet" type="text/css" href="../../css/form.css">
	</head>
	<body>
		<div class="borrowReturn">
			<div class="title">Return Book</div>
			<form action="userPage.php" class="borrowReturnForm">
				<input type="text" name="returnId" required autofocus placeholder="Borrower-Id" value="<?php echo $_SESSION['uid']; ?>" readonly>

				<input type="text" name="returnBookId" required autofocus placeholder="Book-Id">

				<input type="submit" name="returnBtn" value="Return">
			</form>
		</div>
	</body>
</html>
