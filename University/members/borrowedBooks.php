<?php
	
	include("../dbConfig.php");

	$uid = $_SESSION['uid'];

	$query = "SELECT a.bookId,a.borrowDate,a.returnDate,b.title,b.fName FROM borrow as a,books as b Where a.borrowerID = '$uid'&&
	 a.borrowerID=b.bookId";
	$returnD = mysqli_query($con, $query);
	$returnD1 = mysqli_query($con, $query);
	$res = mysqli_fetch_assoc($returnD);
?>

<!DOCTYPE html>
	<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="../../css/inputs.css">
		<link rel="stylesheet" type="text/css" href="../../css/title.css">
		<link rel="stylesheet" type="text/css" href="../../css/form.css">
		<link rel="stylesheet" type="text/css" href="../../css/table.css">
	</head>
	<body>
		<div class="title">Borrowed-Books</div>
		<table>
			<tr>
				<th>Book-ID</th>
				<th>borrow-Date</th>
				<th>return-Date</th>
				<th>Title</th>
				<th>Open</th>
			</tr>
			
				<?php
					while($res1 = mysqli_fetch_assoc($returnD1)){
					?>
					<tr>
					<?php
					foreach ($res1 as $k => $v) {
						?>
							<td>
								<?php 
									if($k == 'bookId'){
										?>
										<a href="userPage.php?activity=bookDetails&selectedBookId=<?php echo $v; ?>"><?php echo $v; ?></a>
										<?php
									}
									elseif($k=='borrowDate'){
										echo $v;
									}
									elseif($k=='returnDate') {
										echo $v;
									}
									elseif ($k=='title') {
												echo $v;
											}	
									elseif ($k='fName') {
										?>
										<a href="readBook.php?path=../../Books/<?php echo $v; ?>" target="_blank">Read</a>

											
					<?php
												}
						}
					}?>
								</td>
					</tr>
			</tr>
		</table>
	</body>
</html>