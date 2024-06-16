<?php 
$host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'dissertation';

    $connect = mysqli_connect($host, $username, $password, $dbname);
require '../Main/database.php';
require '../Main/databaseTable.php';
session_start();


	 if (isset($_POST['signup'])) {
			$firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
			$lastname = mysqli_real_escape_string($connect, $_POST['lastname']);
			$email = mysqli_real_escape_string($connect, $_POST['userEmail']);
			$password = mysqli_real_escape_string($connect, $_POST['npwd']);
			$birthday = mysqli_real_escape_string($connect, $_POST['dob']);
			$gender = mysqli_real_escape_string($connect, $_POST['gender']);
	if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($birthday) || empty($gender)) {
		?>
		<script type="text/javascript">
			alert('Please fill form all input');
		</script>
			<?php	
					}
				else{
					//check if any input are valid
					if (!preg_match("/^[a-zA-Z]*$/", $firstname)|| !preg_match("/^[a-zA-Z]*$/", $lastname)) {
					?>
						<script type="text/javascript">
							alert('Invalid firstname or lastname.');
						</script>
					<?php	
					}
					else{
						// check valid email.
						if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
							?>
							<script type="text/javascript">
								alert('Invalid email address.');
							</script>
						<?php	
						}
						else{
							$sql ="SELECT * FROM users WHERE emailAddress='$email'";
							$result = mysqli_query($connect, $sql);
							$resultCheck = mysqli_num_rows($result);


							if ($resultCheck > 0) {
							?>
							<script type="text/javascript">
								alert('The email you have entered has already been taken.');
							</script>
							<?php	
							}
							else{

								$verifyKey = md5(time().$_POST['userEmail']);
								$result = [
								'firstname' => $_POST['firstname'],
								'lastname' => $_POST['lastname'],
								'emailAddress' => strtolower($_POST['userEmail']),
								'password' => password_hash($_POST['npwd'], PASSWORD_DEFAULT),
								'date_of_birth' => $_POST['dob'],
								'gender' => $_POST['gender'],
								'verify_key' => $verifyKey,
								'activation'=> 1
							];
							$statement= new DatabaseTable($pdo, 'users');//new database table for statements.
							$statements =$statement->insert($result);
							// if () {
									$to = strtolower($_POST['userEmail']);
									$subject = "Email Verification";
									$message = "Please verify your email address to login multigram by clicking confirm.<a  href='http://localhost/DissertationProject/Layouts/verify.php?vKey=$verifyKey'>Confirm.</a>";
									$headers = "From: multigram1212@gmail.com";
									$headers .= "MIME-Version: 1.0"."\r\n";
									$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
								
							 		if(mail($to, $subject, $message, $headers)) {
									    echo "mail send";
									  }else{
									    echo "Failed";
									  }
										
						$pathname = '../Datas';
						$lower = strtolower($_POST['userEmail']);
						if(!file_exists($lower)){
							mkdir($pathname .'/'.$lower, 0777);
							$new = '../Datas/'.$lower;//new pathname
							if(!file_exists('profile')&& !file_exists('files')){
								mkdir($new .'/profile', 0777);//making profile folder.
								mkdir($new .'/files', 0777);//making files folder.
								echo 'created.';
								}
							else{
								echo 'not created.';
								}
						}
						else{
						   echo 'not created.' ;
						}
						}
							
					
						header('Refresh: 0.5; url = thank.php');

							}
						}
					}
				}

			
if(isset($_SESSION['loggedin'])){
		header('Refresh: 1; url =../HTML/userLayout.php');
	}
		else
	{
	 			
	 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<link rel="stylesheet" type="text/css" href="../Styles/Style.css">
 	
 	<!-- bootstrap property -->
 	<link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="../Bootstrap/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="../Bootstrap/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="../Bootstrap//bootstrap.min.js"></script>
 	<title>	</title>
 </head>
 <body>
 
 <header id="head">
 	<div class="logo">
 		<a href="Index.php"><b>MultiGram</b></a>
 	</div>
 </header>

 <main id="sign">
 		
	 	<div id="signup">
	 		<h1 style="text-align: center;">Create a New Account</h1>
		<form action="" id="signupForm" method="POST" autocomplete="off">
			<div id="fullname">
				<div id="fn">
				<!-- input user firstname -->	
				<input id="firstname" class="form-control" type="text" name="firstname" placeholder="Firstname" autocomplete="off">
				<span id="firstNameCheck"></span>
				<br>	
				</div>
				

				<div id="ln">
					<input id="lastname" class="form-control" type="text" name="lastname" placeholder="Lastname" autocomplete ="off">
				<span id="lastNameCheck"></span>
				<br>
				</div>

				<!-- last name -->
				
			</div>

			<div id="mail">
				<label>Email Address:</label>
			<!-- user email address -->
			<input type="text" name="userEmail" class="form-control" id="email_id" placeholder="Email Address" autocomplete="off">
			<span id="emailCheck" ></span>
			<br>
			</div>
			
			<div id="password">
			<!-- user new password -->
			<label>Password:</label>
			<input class="form-control" id="userPassword" type="password" name="npwd" placeholder="Password" autocomplete="off">
			<span id="passwordCheck" ></span>
			<br>

			<label>Confirm-Password:</label>
			<input class="form-control" id="userConPassword" type="password" placeholder="Confirm Password" disabled="true" autocomplete ="off">
			<span id="conpasswordCheck" ></span>
			</div>
			<br>

			<!-- users date of birth -->
			<div id="DOB">
			<p  id="labelBirth">Birthday</p>

			<input class="form-control" id="birthday" type="date" name="dob" min="1960" placeholder="Date_of_birth" autocomplete ="off">
			<span id="dobCheck" style=""></span>
			</div>
			<br>

			<div id="gend">
			<!-- selecting user gender. -->
			<p id="gnder">Gender:</p>
			<select class="form-control" id="gender" name="gender" autocomplete ="off">
			<option value="Male">Male</option>
			<option value="Female">Female</option>
			</select>
			<span id="genderCheck"></span>
			</div>
			<br>
			<label id="ckBox">
				<input id="checkBox" type="checkbox" name="cbox" required>I agree with the term and condition.
			</label><br>
			
			<span id="agreeCheck1">You have to agree with the term and condition of this website to create an account.</span>
			<br><br>
			<div id="signButton">
			<input class="btn btn-dark" id="signBtn" type="submit" name="signup"  value="Create Account">
			</div>
			<br><br>
			<label>If you have already a account clicking below</label><br><br>
			<a href="Index.php">Login</a>
			<br><br>
				</form>
		 	</div>
	 	</main>

<footer>
	<p>----------------------------------------</p>
	<p>(c) 2018</p>
</footer>
 </body>
 </html>

 <!-- script part -->
 <script type="text/javascript">
 	$(document).ready(function(){
 		$('#firstNamcCheck').hide();
 		$('#lastNameCheck').hide();
 		$('#emailCheck').hide();
 		$('#passwordCheck').hide();
 		$('#conpasswordCheck').hide();
 		$('#dobCheck').hide();
 		$('#genderCheck').hide();
 		$('#agreeCheck').hide();

 		var first_err = true;//error for firstname.
 		var last_err = true;//error for lastname.
 		var email_err = true;//error for email address.
 		var pass_err = true;//error for password.
 		var conpass_err = true;//error for confirm password.
 		var dob_err = true;//error for date of birth.
 		var check_err = true;//error fot aggrement.

 		// firstname verification
 			
 		
 		$('#firstname').keyup(function(){
 			firstname_check();
 		});
 		function firstname_check(){
			var pattern = /^[A-Z][a-zA-Z -]+$/;
 			var user_first = $('#firstname').val();
 			if(user_first.length == ''){
 					$('#firstNameCheck').show();
					$('#firstNameCheck').html("**Please Fill the firstname");
					$('#firstNameCheck').focus();
					$('#firstname').css("border-color", "red");
					$('#firstNameCheck').css("color", "red");
 					$('#signBtn').attr("disabled", true);
					first_err = false;
					return false;
				}
				else if ((user_first.length < 3) || (user_first.length > 20) ){
					$('#firstNameCheck').show();
					$('#firstNameCheck').html("**Firstname length must be between 3 and 20");
					$('#firstname').css("border-color", "red");
					$('#firstNameCheck').focus();
					$('#firstNameCheck').css("color", "red");
 					$('#signBtn').attr("disabled", true);
					first_err = false;
					return false;
			}
			if(user_first !== ''){
				if(pattern.test(user_first)){
						$('#firstNameCheck').hide();
						$('#firstname').css("border-color", "green");
			 			$('#signBtn').attr("disabled", false);
						}
						else{
						$('#firstNameCheck').show();
						$('#firstNameCheck').html("**Firstname mustn't contain number(0-9)/ symbol(!*)");
						$('#firstNameCheck').focus();
						$('#firstname').css("border-color", "red");
						$('#firstNameCheck').css("color", "red");
 						$('#signBtn').attr("disabled", true);
						first_err = false;
						return false;
						}
					}
			}


// ---------------------------------------------------------------------
	
 		// lastname verification
 		$('#lastname').keyup(function(){
 			lastname_check();
 		});
 		function lastname_check(){
			var pattern = /^[A-Z][a-zA-Z -]+$/;
 			var user_last = $('#lastname').val();
 			if(user_last.length == ''){
 					$('#lastNameCheck').show();
					$('#lastNameCheck').html("**Please Fill the lastname");
					$('#lastNameCheck').focus();
					$('#lastname').css("border-color", "red");
					$('#lastNameCheck').css("color", "red");
 					$('#signBtn').attr("disabled", true);
					last_err = false;
					return false;
				}
				
				else if ((user_last.length < 3) || (user_last.length > 20) ){
					$('#lastNameCheck').show();
					$('#lastNameCheck').html("**Lastname length must be between 3 and 20");
					$('#lastname').css("border-color", "red");
					$('#lastNameCheck').focus();
					$('#lastNameCheck').css("color", "red");
 					$('#signBtn').attr("disabled", true);
					last_err = false;
					return false;
				}

				if(user_last !== ''){
				if(pattern.test(user_last)){
						$('#lastNameCheck').hide();
						$('#lastname').css("border-color", "green");
			 			$('#signBtn').attr("disabled", false);
						}
						else{
						$('#lastNameCheck').show();
						$('#lastNameCheck').html("**Lastname mustn't contain number(0-9)/ symbol(!*)");
						$('#lastNameCheck').focus();
						$('#lastname').css("border-color", "red");
						$('#lastNameCheck').css("color", "red");
 						$('#signBtn').attr("disabled", true);
						last_err = false;
						return false;
						}
					}
			}

		
			
// ---------------------------------------------------------------------

		
		  	// email address check
			$('#email_id').focusout(function(){
			email_check();
			});
			function email_check(){
				var emailpattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				var email = $('#email_id').val();
				
				if (email.length == ''){
					$('#emailCheck').show();
					$('#emailCheck').html("**Please Fill the email address");
					$('#emailCheck').focus();
					$('#email_id').css("border-color", "red");
					$('#emailCheck').css("color", "red");
 					$('#signBtn').attr("disabled", true);
					email_err = false;
					return false;
				}
			
				if(email !==''){
				 if (emailpattern.test(email)){
				 	// email_address is taken or not
					$.ajax({
			 		url:'check.php',//url to check the database.
			 		method:"POST",//POST method.
			 		data:{email_address:email},
					dataType:"text",
			 		success:function(data)
			 		{
			 		if(data != 0)
			 			{
			        $('#emailCheck').show();//show the span text.
			 		$('#emailCheck').html('**Email Address already taken.');//show this text in emailCheck span.
			        $('#emailCheck').focus();//focus the text.
					$('#email_id').css("border-color", "red");
			        $('#emailCheck').css("color", "red");
			 		$('#signBtn').attr("disabled", true);
			 			}
			 		else{
			        $('#emailCheck').show();
			 		$('#emailCheck').html('Email Address is available.');
			        $('#emailCheck').focus();
					$('#email_id').css("border-color", "green");
			        $('#emailCheck').css("color", "green");
			 		$('#signBtn').attr("disabled", false);
			 			}
			 		}

				  });
					}
					else{
					$('#emailCheck').show();
					$('#emailCheck').html("**Invalid Email_Address");
					$('#emailCheck').focus();
					$('#email_id').css("border-color", "red");
					$('#emailCheck').css("color", "red");
 					$('#signBtn').attr("disabled", true);
					email_err = false;
					return false;
					}
				}
			}
					
			 
// ----------------------------------------------------------------
	
// password verification
				$('#userPassword').keyup(function(){
					password_check();
				});
				function password_check(){
					var passpattern = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
					var pass = $('#userPassword').val();
					var pass = $('#userPassword').val();
				if(pass.length == ''){
					$('#passwordCheck').show();
					$('#passwordCheck').html("**Please Fill the password");
					$('#passwordCheck').focus();
					$('#userPassword').css("border-color","red");
					$('#passwordCheck').css("color", "red");
 					$('#userConPassword').attr("disabled", true);//disable to enter input confirm password.
			 		$('#signBtn').attr("disabled", true);
					pass_err = false;
					return false;
					}
					if((pass.length < 8) || (pass.length > 30)){
					$('#passwordCheck').show();
					$('#passwordCheck').html("**Password length must be between 8 and 30");
					$('#passwordCheck').focus();
					$('#userPassword').css("border-color","red");
					$('#passwordCheck').css("color", "red");
 					$('#userConPassword').attr("disabled", true);//disable to enter input confirm password.
			 		$('#signBtn').attr("disabled", true);
					pass_err = false;
					return false;
					}
					
					if(pass !==''){
						if(passpattern.test(pass)){
							$('#userPassword').css("border-color", "green");
							$('#passwordCheck').hide();
						 	$('#userConPassword').attr("disabled", false);
						}else{
							$('#passwordCheck').show();
							$('#passwordCheck').html("**Must contain at least one number and one uppercase and lowercase letter.");
							$('#passwordCheck').focus();
							$('#userPassword').css("border-color","red");
							$('#passwordCheck').css("color","red");
							$('#userConPassword').attr("disabled", true);
							pass_err = false;
							return false;
						}
					}
				}
 		
// ------------------------------------------------------------------
				// Confirm-password
				$('#userConPassword').keyup(function(){
					con_password();
				});
				function con_password(){
					var conpass= $('#userConPassword').val();
					var passwrd = $('#userPassword').val();

					if(conpass == ''){
					$('#conpasswordCheck').show();
					$('#conpasswordCheck').html("**Please Fill to confirm the password.");
					$('#conpasswordCheck').focus();
					$('#userConPassword').css("border-color","red")
					$('#conpasswordCheck').css("color", "red");
			 		$('#signBtn').attr("disabled", true);
					conpass_err = false;
					return false;
				}
				else if(conpass != passwrd){
					$('#conpasswordCheck').show();
					$('#conpasswordCheck').html("**Password aren't matching.");
					$('#conpasswordCheck').focus();
					$('#userConPassword').css("border-color","red")
					$('#conpasswordCheck').css("color", "red");
			 		$('#signBtn').attr("disabled", true);
					conpass_err = false;
					return false;
				} else {
					$('#userConPassword').css("border-color","green")
					$('#conpasswordCheck').hide();
			 		$('#signBtn').attr("disabled", false);
				}
			}

//---------------------------------------------------------------------
		$("#birthday").focusout(function(){
			birthday_check();
		});
		function birthday_check(){
			var birthday_val = $('#birthday').val();
			if(birthday_val.length == ''){
				$('#dobCheck').show();
				$('#dobCheck').html("**Please Fill your date of birth.");
				$('#dobCheck').focus();
				$('#birthday').css("border-color","red");
				$('#dobCheck').css("color", "red");
			 		$('#signBtn').attr("disabled", true);
				dob_err=false;
				return false;
			}
			else{
				$('#birthday').css('border-color', 'green');
			 	$('#signBtn').attr("disabled", false);
				$('#dobCheck').hide();
			}
		}
// --------------------------------------------------------
//aggrement
		$('#checkBox').change(function(){
			var agree = this.checked;
			if (agree){
				$('#agreeCheck').hide();
				$('#agreeCheck1').hide();
			}
			else{
				$('#agreeCheck').show();
				check_err = false;
				return false;
			}
		});

// ---------------------------------------------------------

		// checking the input is empty or not.


		$('#firstname').focusout(function(){
		first_err = true;

 		firstname_check();

 		if((first_err == true)){
 			return true;

 		}
 		else{
 			return false;
 		}
		});

		$('#lastname').focusout(function(){
		last_err = true;

 		lastname_check();
 		if((last_err == true)){
 			return true;

 		}
 		else{
 			return false;
 		}
		});

		$('#email_id').focusout(function(){
		email_err = true

 		email_check();
 		if(femail_err == true){
 			return true;

 		}
 		else{
 			return false;
 		}
		});


		$('#userPassword').focusout(function(){
		pass_err = true;
		conpass_err = true;

		password_check();
		con_password();

 		if((pass_err == true) && (conpass_err == true)){
 			return true;

 		}
 		else{
 			return false;
 		}
		});

		$('#birthday').focusout(function(){
		
 		dob_err = true;

 		birthday_check();

 		if((dob_err == true)){
 			return true;
 		}
 		else{
 			return false;
 		}
		});

		
		

		$('#signBtn').click(function(){
		first_err = true;
 		last_err = true;
 		email_err = true;
 		pass_err = true;
 		conpass_err = true;
 		dob_err = true;

 		firstname_check();
 		lastname_check();
 		email_check();
 		password_check();
 		birthday_check();
 		con_password();
 		password_validation();
 		email_validate();

 		if((first_err == true) && (last_err == true) && (email_err == true) && (pass_err == true) && (conpass_err == true) && (dob_err == true)){
 			return true;
 		}
 		else{
 			return false;
 		}
		});

		// $('#signButton').click(function(){
		// first_err = true;
 	// 	last_err = true;
 	// 	email_err = true;
 	// 	pass_err = true;
 	// 	conpass_err = true;
 	// 	dob_err = true;

 	// 	firstname_check();
 	// 	lastname_check();
 	// 	email_check();
 	// 	password_check();
 	// 	birthday_check();
 	// 	con_password();
 	// 	password_validation();
 	// 	email_validate();

 	// 	if((first_err == true) && (last_err == true) && (email_err == true) && (pass_err == true) && (conpass_err == true) && (dob_err == true)){
 	// 		return true;
 	// 	}
 	// 	else{
 	// 		return false;
 	// 	}
		// });
 	});
 </script>
	 	<?php 
	 	}
	 	 ?>
 