<?php
	session_start();
	error_reporting(0);
	include("../dbConfig.php");
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
        header("location: ../home.php?activity=studentLogin");
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
	</head>
	<body>
		<div class="container">
			<div class="header">
				<?php include("../header.php"); ?>
			</div>
			<div class="userContainer">
				<div class="title">
					<?php 
							echo "Student Page";
					?>
				</div>

				<div class="userWelcome">Welcome : <?php echo $_SESSION['username']; ?></div>

				<div class="logout"><a href="userPage.php?activity=logout">Logout</a></div>

				<div class="userAction">
					<ul>
						<li><a href="userPage.php?activity=viewProfile">View Profile</a></li>
						<li><a href="userPage.php?activity=editProfile">Edit Profile</a></li>
						<li><a href="userPage.php?activity=borrowBooks">Borrow Books</a></li>
						<li><a href="userPage.php?activity=BorrowedBooks">Borrowed Books</a></li>
					</ul>
				</div>

				<div class="userContent">
					<?php
					//ACTIVITY PERFORM...

						$activity = $_REQUEST['activity'];

						switch ($activity) {
							case 'borrowBooks':
								include("borrowBooks.php");
								break;
							case 'BorrowedBooks':
								include("BorrowedBooks.php");
								include("returnBooks.php");	
								break;	
							case 'bookDetails':
								include("bookDetails.php");
								break;

							case 'editProfile':
								include("editProfile.php");
								break;

							case 'viewProfile':
								include("viewProfile.php");
								break;
							default:
							//include("viewProfile.php");
								break;
						}
					?>

					<?php
	                //UPDATE MEMBER...

	                    if(isset($_REQUEST['updateMemberBtn'])){

	                        $umemberId = $_REQUEST['umemberId'];
	                        $firstName = $_REQUEST['firstName'];
	                        $lastName = $_REQUEST['lastName'];
	                        $mobile = $_REQUEST['mobile'];
	                        $email = $_REQUEST['email'];


	                        $query1 = mysqli_query($con, "UPDATE members Set firstName ='$firstName', lastName ='$lastName', mobile ='$mobile', email ='$email' Where id = '$umemberId'");

	                        if($query1){
	                            //$errorMsg = "Updation is successfully done.";
	                            header("location: userPage.php?activity=viewProfile");
	                        }
	                        //include("editProfile.php");
	                    }    
	                ?>

					<?php
					//borrow BOOK...

						if(isset($_REQUEST['borrowBtn'])){ //if click on borrow button..

	                        $borrowBookId = $_REQUEST['borrowBookId'];
	                        $borrowerId = $_REQUEST['borrowerId'];

	                        if(!empty($borrowBookId) && !empty($borrowerId)){ //checks that both fields is not empty..

	                        	$query1 = "Select bookId From books Where bookId = '$borrowBookId'";
	                            $returnD1 = mysqli_query($con, $query1);
	                            $result1 = mysqli_fetch_assoc($returnD1);

	                            $query2 = "Select id From members Where id = '$borrowerId'";
	                            $returnD2 = mysqli_query($con, $query2);
	                            $result2 = mysqli_fetch_assoc($returnD2);

	                            if($borrowBookId == $result1['bookId'] && $borrowerId == $result2['id']){ //checks that book or issuer id exists or not..

	                                $query3 = "SELECT bookId,borrowerID From borrow Where bookId = '$issueBookId'";
	                                $returnD3 = mysqli_query($con, $query3);
	                                $result3 = mysqli_fetch_assoc($returnD3);

	                                    if($borrowBookId != $result3['bookId']){//checks that book is already issued or not..

	                                        date_default_timezone_set('‘Africa/Cairo');
											$dt = date("y/m/d h:i:s");
											$rd=date("Y-m-d",time()+(86400*15)); // add 15 dayes as period

	                                        $query = "Insert Into borrow(bookId,borrowerID,borrowDate,returnDate) Values('$borrowerId','$borrowerId','$dt','$rd')";        
	                                        $returnD = mysqli_query($con, $query);

	                                        $queryForUnavailableBook = mysqli_query($con, "Update books Set available = 0 Where bookId = '$borrowBookId'");

	                                        if($returnD){
	                                            $errorMsg = "Book has been successfully Borrowed.";
	                                        }
	                                        else{
	                                            $errorMsg = "Problem in borrowing this book.";
	                                        }
	                                    }
	                                    else{
	                                        $errorMsg = "Already borrowed to ".$result3['borrowerID'].".";
	                                    }

	                            }
	                            elseif($borrowerId!= $result1['bookId']){
	                                $errorMsg = "Please! Enter valid Book-Id.";
	                            }
	                            elseif($$borrowBookId != $result2['id']){
	                                $errorMsg = "Please! Enter valid Borrower-Id.";
	                            }
	                        }
	                        else{
	                            $errorMsg = "Both fields can't be Empty.";
	                        }

	                    }

					?>

					<?php
					//RETURN BOOK...

						if(isset($_REQUEST['returnBtn'])){//checks that return button is clicked or not...

	                        $returnId = $_REQUEST['returnId'];
	                        $returnBookId = $_REQUEST['returnBookId'];

	                        if(!empty($returnId) && !empty($returnBookId)){ //checks that both fields are filled or not...

	                            $query1 = "SELECT bookId,borrowerID From borrow Where bookId = '$returnBookId' && borrowerID = '$returnId'";
	                            $returnD1 = mysqli_query($con, $query1);
	                            $result1 = mysqli_fetch_assoc($returnD1);

	                            if($returnId == $result1['borrowerID'] && $returnBookId == $result1['bookId']){ //checks that book is borred or not or student id exists or not...

	                                $query2 = "DELETE from borrow Where bookId = '$returnBookId' && borrowerID= '$returnId'";
	                                $returnD2 = mysqli_query($con, $query2);

	                                $queryForAvailableBook = mysqli_query($con, "Update books Set available = 1 Where bookId = '$returnBookId'");
	                                
									if($returnD2){ //checks that book is returned or not..
										$errorMsg = "Book has been successfully returned.";
									//	header("location:userPage.php?activity=returnBooks");

	                                }
	                                else{
									//	header("location:userPage.php?activity=returnBooks");

										$errorMsg = "Problem in returning this book.";
	                                }

	                            }
	                            else{
									$errorMsg = "Book-Id or Borrower-Id does not Exists or may not be Borrowed.";
	                            }
	                        }
	                        else{
								$errorMsg = "Both fields must be filled.";
	                        }
							include("returnBooks.php");
						//	header("location:userPage.php?activity=returnBooks");
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