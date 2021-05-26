<?php
	session_start();
	include("../dbConfig.php");
	error_reporting(0);
	$username = $_SESSION['username'];

	if($_REQUEST['activity'] == 'logout'){
        $username = null;
        $username ="";
        unset($username);
        
        $_SESSION['username'] = null;
        $_SESSION['username'] ="";
        unset($_SESSION['username']);
        
        session_destroy();
    }

    if(empty($username)){
        header("location: ../home.php?activity=adminLogin");
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="../../css/title.css">
		<link rel="stylesheet" type="text/css" href="../../css/userPage.css">
		<link rel="stylesheet" type="text/css" href="../../css/home.css">
		<link rel="stylesheet" type="text/css" href="../../css/header.css">
		<link rel="stylesheet" type="text/css" href="../../css/navigation.css">
		<link rel="stylesheet" type="text/css" href="../../css/inputs.css">
		<link rel="stylesheet" type="text/css" href="../../css/form.css">
	</head>
	<body>
		<div class="container">
			<div class="header">
				<?php include("../header.php"); ?>
			</div>
			<div class="userContainer">
				<div class="title">Admin Page</div>

				<div class="userWelcome">Welcome : <?php echo $_SESSION['username']; ?></div>

				<div class="logout"><a href="adminPage.php?activity=logout">Logout</a></div>

				<div class="userAction">
					<ul>
						<li><a href="adminPage.php?activity=viewProfile">View Profile</a></li>
						<li><a href="adminPage.php?activity=editProfile">Edit Profile</a></li>
						<li><a href="adminPage.php?activity=viewUsers">View Users</a></li>
						<li><a href="adminPage.php?activity=addBooks">Add Books</a></li>
						<li><a href="adminPage.php?activity=viewBooks">View Books</a></li>
						<li><a href="adminPage.php?activity=borrowedBooks">Borrowed Books</a></li>
					</ul>
				</div>

				<div class="userContent">
					<?php
					//ACTIVITY PERFORM...

						$activity = $_REQUEST['activity'];

						switch ($activity) {							
							case 'viewProfile':
								include("viewProfile.php");
								break;
							case 'editProfile':
								include("editProfile.php");
								break;
							case 'viewUsers':
								include("viewUsers.php");	
								break;	
							case 'addBooks':
								include("addBooks.php");
								break;	
							case 'viewBooks':
								include("viewBooks.php");
								break;
							case 'borrowedBooks':
								include("borrowedBooks.php");
								break;	
							case 'bookDetails':
								include("bookDetails.php");
								break;

							case 'viewUserProfile':
								include("viewUserProfile.php");
								break;
                            case 'updateBook':
                            		
                            		$uBookId = $_REQUEST['uBookId'];

                            		if(!empty($uBookId)){

                            			$result = mysqli_fetch_assoc(mysqli_query($con,"SELECT available FROM books WHERE bookId = '$uBookId'"));

                            			if($result['available'] == 1){

	                            			$result = mysqli_fetch_assoc(mysqli_query($con,"SELECT title,author,ISBN,publisher FROM books WHERE bookId = '$uBookId'"));
	                            			?>
	                            			<div class="title">Update Book</div>
	                            			<div class="bookUpdateForm">
	                            				<form action="adminPage.php">
	                            					<input type="text" name="uBookId" value=<?php echo $uBookId; ?> readonly><br>
	                            					<input type="text" name="title" required autofocus placeholder="Book-Name" value=<?php echo $result['title']; ?>><br>
													<input type="text" name="ISBN" required autofocus placeholder="ISBN" value=<?php echo $result['ISBN']; ?>><br>
	                            					<input type="text" name="author" required autofocus placeholder="Author-Name" value=<?php echo $result['author']; ?>><br>
	                            					<input type="text" name="publisher" required autofocus placeholder="Publisher" value=<?php echo $result['publisher']; ?>><br>
	                            					<input type="submit" name="updateBookBtn" value="Update">
	                            				</form>
	                            			</div>
	                            			<?php
                            			}
                            			else{
                            				$errorMsg = "Book is borrowed to someone. So it can't be edited.";
                            			}
                            		}

                            	break;									
							default:
								break;
						}
					?>

					<?php
					//UPDATE BOOK...

						if(isset($_REQUEST['updateBookBtn'])){

							$uBookId = $_REQUEST['uBookId'];
							$title = $_REQUEST['title'];
							$author = $_REQUEST['author'];
							$ISBN = $_REQUEST['ISBN'];
							$publisher = $_REQUEST['publisher'];

							if(!empty($title) && !empty($author) && !empty($ISBN) && !empty($publisher)){

								$result = mysqli_query($con,"UPDATE books SET title = '$title', author = '$author', ISBN = '$ISBN', publisher = '$publisher' WHERE bookId = '$uBookId'");

								if(!empty($result)){
									header("location: adminPage.php?activity=viewBooks");
								}
							}
							else{
								header("location: adminPage.php?activity=viewBooks");
								$errorMsg = "Please! Enter in the Empty Field.";
							}
							//include("viewBooks.php");
						}

					?>

					<?php
	                //Edit Admin...

	                    if(isset($_REQUEST['adminUpdateBtn'])){

	                        $uadminId = $_REQUEST['uadminId'];
	                        $firstName = $_REQUEST['firstName'];
	                        $lastName = $_REQUEST['lastName'];
	                        $username = $_REQUEST['username'];
	                        $pwd = $_REQUEST['pwd'];
	                        $email = $_REQUEST['email'];

	                        $query1 = mysqli_query($con,"UPDATE admin Set firstName ='$firstName', lastName ='$lastName', username ='$username', pwd ='$pwd', email ='$email' Where id = '$uadminId'");

	                        if($query1){
	                            //$errorMsg = "Updation is successfully done.";
	                            header("location: adminPage.php?activity=viewProfile");
	                        }
	                        //include("editProfile.php");
	                    }    
	                ?>

                    <?php 
                    //ADD BOOK...

                        $query = "Select Max(bookId) From books";
                        $returnD = mysqli_query($con, $query);
                        $result = mysqli_fetch_assoc($returnD);
						$maxRows = $result['Max(bookId)'];
						$lastRow;
                        if(empty($maxRows)){
                            $lastRow = $maxRows = 1;      
                        }else{
                            $lastRow = $maxRows + 1 ;
                        }

                        if(isset($_POST['addBookBtn'])){

                            $bookId = $lastRow;
                            $bookName = $_POST['bookName'];
                            $authorName = $_POST['authorName'];
							$bookPublisher = $_POST['bookPublisher'];
							$isbn=$_POST['ISBN'];
							$filename = $_FILES['file']['name'];
    						// destination of the file on the server
    						$destination = '../../Books/' . $filename;
    						// get the file extension
    						$extension = pathinfo($filename, PATHINFO_EXTENSION);
    						// the physical file on a temporary uploads directory on the server
    						$file = $_FILES['file']['tmp_name'];
                            if(!empty($bookId) && !empty($bookName) && !empty($authorName)){
								if (in_array($extension, ['pdf'])) {
									if(move_uploaded_file($file, $destination)){
										if($maxRows){
											$query = "INSERT Into books(bookId,title,author,ISBN,publisher,available,fName)
											 Values('$bookId','$bookName','$authorName','$isbn','$bookPublisher','1','$filename')";
											if(mysqli_query($con, $query)){
												$errorMsg = "Book Sucessfully Added.";
											}
											$query = "Select Max(bookId) From books";
											$returnD = mysqli_query($con, $query);
											$result = mysqli_fetch_assoc($returnD);
											$maxRows = $result['Max(bookId)'];
											if(empty($maxRows)){
												$lastRow = $maxRows = 1;      
											}else{
												$lastRow = $maxRows + 1 ;
											}
										}

									}
									else{
										$errorMsg= "Error in Upload File";
									}
								}
								else {
									$errorMsg= "You file extension must be .pdf ";
								}	
                            }
                            else{
                                $errorMsg = "Please! Enter in Empty Field.";
                            }

                            include("addBooks.php");
                        }
                    ?>

                    <?php
			        if(isset($errorMsg)){
			            ?>
			            <div class="errorMsg"><?php echo $errorMsg; ?></div>
		                <?php	
		        	}
			  		?>

				</div>
			</div>
		</div>
	</body>
</html>