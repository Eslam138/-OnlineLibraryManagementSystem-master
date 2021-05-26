<?php
	include("../dbConfig.php");

	$selectedBookId = $_REQUEST['selectedBookId'];

	$query = mysqli_query($con, "Select bookId,title,author,publisher,ISBN From books Where bookId = '$selectedBookId'");
	$result = mysqli_fetch_assoc($query);

	$query1 = mysqli_query($con, "Select borrowerID From borrow Where bookId = '$selectedBookId'");
	$result1 = mysqli_fetch_assoc($query1);
	$issueId;
	$result2;
	if(!empty($result1['borrowerID'])){
		$borrowerID= $result1['borrowerID'];
		$query2 = mysqli_query($con, "Select firstName,lastName From members Where id = '$borrowerID'");
		$result2 = mysqli_fetch_assoc($query2);
		//print_r($result2);
	}

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
			<div class="bookName"> Book Name 
				<?php echo ucfirst($result['title']); ?>
			</div>
			<?php
			if(!empty($borrowerID)){
			?>
			<div class="BorrowerInfo">
				<?php
					
					if($result2['firstName'] && $result2['lastName']){
						?>
						This book is borrwerd  to 
						<a href="adminPage.php?activity=viewUserProfile&selectedMemberId=<?php echo $borrowerID; ?>"><?php echo ucfirst($result2['firstName'])." ".ucfirst($result2['lastName']); ?>.
						</a>
						<?php
					}
				?>
			</div>
			<?php
			}
			?>
			<div class="bookInfo">
				<hr>
				<div class="label">Book id</div>
				<div class="details"><?php echo ucfirst($result['bookId']); ?></div>
				<hr>
				<div class="label">ISBN</div>
				<div class="details"><?php echo ucfirst($result['ISBN']); ?></div>
				<hr>
				<div class="label">Author</div>
				<div class="details"><?php echo ucfirst($result['author']); ?></div>
				<hr>
				<div class="label">Publisher</div>
				<div class="details"><?php echo ucfirst($result['publisher']); ?></div>
				<hr>
			</div>
		</div>
	</body>
</html>  