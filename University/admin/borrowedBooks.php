<?php
	
	include("../dbConfig.php");

	$query = "SELECT bookId,borrowerID,borrowDate,returnDate,borrowerID as borower FROM borrow WHERE borrowerID> 0";
	$returnD = mysqli_query($con, $query);
	$returnD1 = mysqli_query($con, $query);
	$res = mysqli_fetch_assoc($returnD);
?>
<?php
	function sendmail($id){
		$query = "SELECT email FROM members WHERE id='$id'";
		$email=mysqli_query($con,$query);
		while ($reselt = mysqli_fetch_assoc($email)) {
			foreach($reselt as $k => $v)
			{
				$subject = "Universty libirary";
				$txt = "You must return the books whose borrowing has expired for others to use";
				$headers = "From: webmaster@example.com" . "\r\n" .
							"CC: somebodyelse@example.com";

				mail($v,$subject,$txt);
			}
		}
		
	}
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
		<div class="title">borrowed-Book</div>
		<table>
			<tr>
				<th>Book-ID</th>
				<th> Borrower-profile</th>
				<th>Borrow-Date</th>
				<th>Return-Date</th>
				<th>Send Mail for late borrow</th>
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
										<a href="adminPage.php?activity=bookDetails&selectedBookId=<?php echo $v; ?>"><?php echo $v; ?></a>
										<?php
									}
									else if($k == 'borrowerID'){
										?>
										<a href="adminPage.php?activity=viewUserProfile&selectedMemberId=<?php echo $v; ?>">view profile</a>
										<?php
									}
									else if($k == 'borrowDate'){
										echo $v;
									}
									else if($k=='returnDate'){
										echo $v;																		
									}
									else{
										?> <button type="button"onclick="sendmail($v);">sendmail</button>
										<?php
									}

								?>
							</td>
						<?php
					}
					?>
					</tr>
					<?php
				}
				?>
			</tr>
		</table>
	</body>
</html>