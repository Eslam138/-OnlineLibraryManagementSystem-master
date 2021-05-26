<?php
	
	include("../dbConfig.php");

	$query = "Select Max(bookId) From books";
	$returnD = mysqli_query($con, $query);
	$result = mysqli_fetch_assoc($returnD);
	$maxRows = $result['Max(bookId)'];
	if(empty($maxRows)){
        $lastRow = $maxRows = 1001;      
    }else{
		$lastRow = $maxRows + 1 ;
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="../../css/title.css">
		<link rel="stylesheet" type="text/css" href="../../css/inputs.css">
		<link rel="stylesheet" type="text/css" href="../../css/form.css">
	</head>
	<body>
		<div class="title">Add-Book</div>
		<div class="addBookForm">
			<form action="adminPage.php" method="post" enctype="multipart/form-data">
				<input type="text" name="bookName" required autofocus placeholder="Book-Name" pattern="[A-Z a-z]{3,}" title="Name must contain atleast 3 letters."><br>
				<input type="text" name="ISBN" required autofocus placeholder="ISBN" pattern="[0-9]{3,}" title="ISBN must contain atleast 3 Numbers."><br>

				<input type="text" name="authorName" required autofocus placeholder="Author-Name" pattern="[A-Z a-z]{3,}" title="Author name must contain atleast 3 letters."><br>
				<input type="text" name="bookPublisher" required autofocus placeholder="Publisher" pattern="[A-Z a-z]{3,}" title="Publisher name must contain 3 letters."><br>
				<input type="file" name="file" value="Upload Book" required autofocus placeholder="book file"title="Book shuold be PDF File"><br>
				<input type="submit" name="addBookBtn" value="Add Book"><br>
			</form>
		</div>
	</body>
</html>