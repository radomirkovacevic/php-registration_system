<?php
    session_start();
    if(!isset($_SESSION['activated_user'])){
?>
<!DOCTYPE html>
    <html lang="eng">
        <head>
            <meta charset="UTF-8">
            <title>Accounts</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    .register-page{
                        width:100%;
						margin:0px auto;
						text-align:center;
					}
					.txt-registerYourself{}
					.register-warning{
						color:red;
					}
					.txt-loginYourself{}
					input{
						width:90%;
					}
				</style>
		</head>
		<body>
		    <section>
			    <div class="register-page">
				    <h3 class="txt-registerYourself">Register yourself</h3>
					<form class="form-register" action="/users/reg_user.php" method="post">
						<label>What is your first name?</label><br>
						<input type="text" name="firstnameSet"><br>
						<label>What is your last name?</label><br>
						<input type="text" name="lastnameSet"><br>
						<label>Your mail is?</label><br>
						<input type="text" name="mailSet"><br>
						<label>Create password.</label><br>
						<input type="password" name="passwordSet"><br>
						<label class="register-warning">
					   	 <?php if(isset($_SESSION['error'])){
							       print $_SESSION['error'];
								   session_destroy();
								}
							?>
						</label><br>
						<input class="submit" type="submit" name="insert"><br>
					</form>
					<h3 class="txt-loginYourself">Or</h3>
					<div class="chose-login">
						<a class="li-loginYourself" href="login.php">Login yourself</a>
					</div>
				</div>
			</section>
		</body>
    </html>
			<?php
			    }else{
					header('Location: http://' . $_SERVER['HTTP_HOST']);
					exit;
					}
			?>
