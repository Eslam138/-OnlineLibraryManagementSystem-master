<?php
	
	include("../dbConfig.php");

	$query = "SELECT bookId,title,author,ISBN,available FROM books";
	$returnD = mysqli_query($con, $query);
	$returnD1 = mysqli_query($con, $query);
	$result = mysqli_fetch_assoc($returnD);

?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="../../css/title.css">
		<link rel="stylesheet" type="text/css" href="../../css/table.css">
	</head>
	<body>
		
		<div class="title">Book List</div>
		<table>
			<tr>
				<th>Book Id</th>
				<th>Title</th>
				<th>ISBN</th>
				<th>Author</th>
				<th>Available</th>
			</tr>
			<?php
				while($result1 = mysqli_fetch_assoc($returnD1)){
				?>
				<tr>
					<td>
						<a href="userPage.php?activity=bookDetails&selectedBookId=<?php echo $result1['bookId']; ?>"> <?php echo $result1['bookId']; ?> </a>
					</td>
					<td><?php echo ucfirst($result1['title']); ?></td>
					<td><?php echo ucfirst($result1['ISBN']); ?></td>
					<td><?php echo ucfirst($result1['author']); ?></td>
					<td>
						<?php 
							
							if($result1['available'] == 1){
								echo 'Yes';
							}
							elseif($result1['available'] == 0){
								echo 'No';
							}
						?>
					</td>
				</tr>
				<?php
				}
			?>
			
		</table>
	</body>
</html>