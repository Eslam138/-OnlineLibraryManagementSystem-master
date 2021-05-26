<?PHP include("search.php");?>
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
			<div class="title">Borrow-Book</div>
			<form action="userPage.php" class="borrowReturnForm">
			
				<input type="text" name="borrowBookId" required autofocus placeholder="Book-Id"><br>
				<input type="text" name="borrowerId" required autofocus placeholder="borrower-Id" value="<?php echo $_SESSION['uid']; ?>" readonly><br>
				
				<input type="submit" name="borrowBtn" value="Borrow">
				
			</form>
		</div>
	</body>
</html>