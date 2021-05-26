
<?php
	session_start();
	include("dbConfig.php");
	error_reporting(0);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Online Library Management</title>
		<link rel="stylesheet" type="text/css" href="../css/home.css">
		<link rel="stylesheet" type="text/css" href="../css/title.css">
	</head>
	<body>
		<div class="container">
			<div class="header">
				<?php include("header.php"); ?>
			</div>

			<div class="navigation">
				<?php include("navigation.php"); ?>
			</div>

			<div class="content">
				<?php
				//ACTIVITY PERFORM...
					$activity='studentLogin';
					if (!empty($_REQUEST['activity'])) {
						$activity = $_REQUEST['activity'];
					}
					switch ($activity) {
							case 'adminLogin':
							include("adminLogin.php ");
							break;
						
						case 'studentLogin':
							include("studentLogin.php");
							break;
							
						case 'register':
							include("register.php");
							break;
						case 'forgetpwd':
							include("forgetpwd.php");
							break;

						default:
							# code...
							break;
					}

				?>

				<?php
				//ADMIN LOGIN...

					if(isset($_REQUEST['adminLoginBtn'])){
		
						$username= $_REQUEST['username'];
						$pwd= $_REQUEST['pwd'];

						if(!empty($username) && !empty($pwd)){

							$query = mysqli_query($con, "SELECT id,username,pwd FROM admin WHERE username = '$username'");
							$result = mysqli_fetch_assoc($query);

								if($username == $result['username'] && $pwd == $result['pwd']){
				
									$_SESSION['username'] = $result['username'];
									$_SESSION['uid'] = $result['id'];

									header("location: admin/adminPage.php?activity=viewProfile");
								}
								else{
									include("adminLogin.php");
									$errorMsg = "Invalid User....";
								}
						}
						else{
							include("adminLogin.php");
							$errorMsg = "Enter in empty field...";
						}
					}

				?>

				<?php
				//STUDENT LOGIN...

					if(isset($_REQUEST['studentLoginBtn'])){
		
						$username= $_REQUEST['username'];
						$pwd= $_REQUEST['pwd'];

						if(!empty($username) && !empty($pwd)){

							$query = mysqli_query($con, "SELECT id,username,pwd FROM members WHERE username = '$username' && pwd = '$pwd'");
							$result = mysqli_fetch_assoc($query);

								if($username == $result['username'] && $pwd == $result['pwd']){
				
									$_SESSION['username'] = $username;
									$_SESSION['uid'] = $result['id'];

									header("location: members/userPage.php?activity=viewProfile");
								}
								else{
									include("studentLogin.php");
									$errorMsg = "Invalid User....";
								}
						}
						else{
							include("studentLogin.php");
							$errorMsg = "Enter in empty field...";
						}
						
					}

				?>	
				<?php
				//ADD student or admin...
				//add admin
                    if(isset($_REQUEST['addAdminBtn'])){
						
						$query = "SELECT Max(id) From admin";
						$returnD = mysqli_query($con, $query);
						$result = mysqli_fetch_assoc($returnD);
						$maxRows = $result['Max(id)'];
						$lastRow;
						if(empty($maxRows)){
							$lastRow = $maxRows = 1;      
						}else{
							$lastRow = $maxRows + 1 ;
						}

                        $memberId = $lastRow;
                        $firstName = $_REQUEST['firstName'];
                        $lastName = $_REQUEST['lastName'];
                        $username = $_REQUEST['username'];
                        $pwd = $_REQUEST['pwd'];
                        $mobile = $_REQUEST['mobile'];
						$email = $_REQUEST['email'];

                        if(!empty($memberId) && !empty($firstName) && !empty($lastName) && !empty($username) && !empty($pwd) && !empty($mobile)){

                        	$usernameExists = mysqli_fetch_assoc(mysqli_query($con, "SELECT username FROM admin WHERE username = '$username'"));

                            if($usernameExists['username'] != $username){

                            	$mobileExists = mysqli_fetch_assoc(mysqli_query($con, "SELECT mobile FROM admin WHERE mobile = '$mobile'"));

                            	if($mobileExists['mobile'] != $mobile){

                            		$emailExists = mysqli_fetch_assoc(mysqli_query($con, "SELECT email FROM admin WHERE email = '$email'"));

                            		if($emailExists['email'] != $email){

		                            	move_uploaded_file($tmpName, $targetLocation);

		                                $query = "Insert Into admin(id,firstName,lastName,username,pwd,mobile,email) Values('$memberId','$firstName','$lastName','$username','$pwd','$mobile','$email')";
		                                $res = mysqli_query($con, $query);

		                                if(!empty($res)){
			                                $errorMsg = "Admin Sucessfully Added.";
			                            }
			                                $query = "SELECT Max(id) From admin";
			                                $returnD = mysqli_query($con, $query);
			                                $result = mysqli_fetch_assoc($returnD);
			                                $maxRows = $result['Max(id)'];

			                                if(empty($maxRows)){
			                                    $lastRow = $maxRows = 1;      
			                                }else{
			                                    $lastRow = $maxRows + 1 ;
			                                }
		                            }
		                            else{
		                            	$errorMsg = "Email ID already exists. ";	
		                            }

		                        }
		                        else{
		                        	$errorMsg = "Mobile number already exists. ";
		                        }
                            }
                            else{
                                $errorMsg = "Username already exists.Choose another.";
                            }

                        }
                        else{
                            $errorMsg = "Please! Enter in Empty Field.";
                        }

                        include("register.php");
					}

					//add student...
                    if(isset($_REQUEST['addStudentBtn'])){
						$query = "Select Max(id) From members";
						$returnD = mysqli_query($con, $query);
						$result = mysqli_fetch_assoc($returnD);
						$maxRows = $result['Max(id)'];
						$lastRow;
						if(empty($maxRows)){
							$lastRow = $maxRows = 1;      
						}else{
							$lastRow = $maxRows + 1 ;
						}

                        $memberId = $lastRow;
                        $firstName = $_REQUEST['firstName'];
                        $lastName = $_REQUEST['lastName'];
                        $username = $_REQUEST['username'];
                        $pwd = $_REQUEST['pwd'];
                        $mobile = $_REQUEST['mobile'];
						$email = $_REQUEST['email'];

                        if(!empty($memberId) && !empty($firstName) && !empty($lastName) && !empty($username) && !empty($pwd) && !empty($mobile)){

                        	$usernameExists = mysqli_fetch_assoc(mysqli_query($con, "SELECT username FROM members WHERE username = '$username'"));

                            if($usernameExists['username'] != $username){

                            	$mobileExists = mysqli_fetch_assoc(mysqli_query($con, "SELECT mobile FROM members WHERE mobile = '$mobile'"));

                            	if($mobileExists['mobile'] != $mobile){

                            		$emailExists = mysqli_fetch_assoc(mysqli_query($con, "SELECT email FROM members WHERE email = '$email'"));

                            		if($emailExists['email'] != $email){

		                                $query = "Insert Into members(id,firstName,lastName,username,pwd,mobile,email) Values('$memberId','$firstName','$lastName','$username','$pwd','$mobile','$email')";
		                                $res = mysqli_query($con, $query);

		                                if(!empty($res)){
			                                $errorMsg = "Stydent Sucessfully Added.";
			                            }
			                                $query = "Select Max(id) From members";
			                                $returnD = mysqli_query($con, $query);
			                                $result = mysqli_fetch_assoc($returnD);
			                                $maxRows = $result['Max(id)'];

			                                if(empty($maxRows)){
			                                    $lastRow = $maxRows = 1;      
			                                }else{
			                                    $lastRow = $maxRows + 1 ;
			                                }
		                            }
		                            else{
		                            	$errorMsg = "Email ID already exists. ";	
		                            }

		                        }
		                        else{
		                        	$errorMsg = "Mobile number already exists. ";
		                        }
                            }
                            else{
                                $errorMsg = "Username already exists.Choose another.";
                            }

                        }
                        else{
                            $errorMsg = "Please! Enter in Empty Field.";
                        }

                        include("register.php");
                    }
				?>
                <?php
                //FORGET PASSWORD...

                	if(isset($_REQUEST['pwdSaveBtn'])){

                		$request = $_REQUEST['request'];

                		if($request == "admin"){
                			$regEmail = $_REQUEST['regEmail'];

							$query = mysqli_query($con, "SELECT email FROM admin WHERE email = '$regEmail'");
							$result = mysqli_fetch_assoc($query);

							if($regEmail == $result['email']){

								$newP = $_REQUEST['newP'];
								$confirmP = $_REQUEST['confirmP'];

								if($newP == $confirmP){
									$query = mysqli_query($con, "UPDATE admin SET pwd = '$newP' WHERE email = '$regEmail'");

									if(!empty($query)){
										$errorMsg = "Password successfully changed.";
										header("location: home.php?activity=adminLogin");
										
									}
								}
								else{
									//header("location: index.php?activity=forgetpwd");
									$errorMsg = "Password must be same.";
								}
							}
							else{
								//header("location: index.php?activity=forgetpwd");
								$errorMsg = "Please ! Enter authorised's user email.";
							}
                		}
                		else if($request == "user"){

							$regEmail = $_REQUEST['regEmail'];

							$query = mysqli_query($con, "SELECT email,position FROM members WHERE email = '$regEmail'");
							$result = mysqli_fetch_assoc($query);

							if($regEmail == $result['email']){

								$newP = $_REQUEST['newP'];
								$confirmP = $_REQUEST['confirmP'];

								if($newP == $confirmP){

									$query = mysqli_query($con, "UPDATE members SET pwd = '$newP' WHERE email = '$regEmail'");

									if(!empty($query)){

										if($result['position'] == 'Student')
											header("location: home.php?activity=studentLogin");
										//$errorMsg = "Password successfully changed.";
									}
								}
								else{
									//header("location: index.php?activity=forgetpwd");
									$errorMsg = "Password must be same.";
								}
							}
							else{
								//header("location: index.php?activity=forgetpwd");
								$errorMsg = "Please ! Enter authorised's user email.";
							}
						}
						include("forgetpwd.php");
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
			<div class="footer">
				<?php include("footer.php"); ?>
			</div>
		</div>
	</body>
</html>