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
					.chose-loginReset{
						display: grid;
						grid-template-columns: repeat(2, 1fr);
						grid-gap: 15px;
						width: 50%;
						text-align: center;
						margin: 0px auto;
					}
					.chose-login,
					.chose-reset,
					.chose-register{
						grid-column: span 1;
					}
					input{
						width:90%;
					}
					@media screen and (max-width:400px) {
						.chose-loginReset {
							grid-template-columns: repeat(1, 1fr);
							grid-gap: 15px;
							width: 100%;
							margin: 0px auto;
						}
						.chose-login,
						.chose-reset,
						.chose-register{
							grid-column: span 1;
						}
					}
				</style>
		</head>
		<body>
		    <section>
			    <div class="register-page">
				    <h3 class="txt-registerYourself">Login</h3>
					<form class="form-register" action="/users/login_user.php" method="post">
						<label>Your mail is?</label><br>
						<input type="text" name="mail"><br>
						<label>What is your password?</label><br>
						<input type="password" name="password"><br>
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
					<div class="chose-loginReset">
					    <div class="chose-login">
						    <a class="li-loginYourself" href="register.php">Register yourself</a>
						</div>
						<div class="chose-reset">
						    <a class="li-loginYourself" href="">Resset password</a>
						</div>
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
