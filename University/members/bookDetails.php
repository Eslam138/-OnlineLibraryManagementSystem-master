<?php
	include("../dbConfig.php");

	$selectedBookId = $_REQUEST['selectedBookId'];

	$query = mysqli_query($con, "Select bookId,title,author,ISBN,publisher From books Where bookId = '$selectedBookId'");
	$result = mysqli_fetch_assoc($query);

	$query1 = mysqli_query($con, "Select borrowerID From borrow Where bookId = '$selectedBookId'");
	$result1 = mysqli_fetch_assoc($query1);

	$borrowerID = $result1['borrowerID'];



?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="../../css/title.css">
		<link rel="stylesheet" type="text/css" href="../../css/bookDetails.css">
	</head>
	<body>
		<div class="title">Book Information</div>
		<div class="infoContainer">
			<div class="bookName">
			book name: <?php echo ucfirst($result['title']); ?>id: [<?php echo $selectedBookId; ?>]
			</div>
			<div class="bookInfo">
				<hr>
				<div class="label">Author</div>
				<div class="details"><?php echo ucfirst($result['author']); ?></div>
				<hr>
				<div class="label">ISBN</div>
				<div class="details"><?php echo $result['ISBN']; ?></div>
				<hr>
				<div class="label">Publisher</div>
				<div class="details"><?php echo ucfirst($result['publisher']); ?></div>
				<hr>
			</div>

			
		</div>
	</body>
</html>  