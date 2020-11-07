<?php session_start(); ?>
<!DOCTYPE html>
    <html lang="eng">
        <head>
            <meta charset="UTF-8">
            <title>Accounts</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style></style>
		</head>
		<body>
		    <section>
                <?php
				    if(!isset($_SESSION['verified']) || $_SESSION['verified'] !== true){
						print '<a class="" href="login.php">Account</a>';
					}else{
						print '<a class="" href="cpanel.php">CPanel</a>';
					 }
              ?>
			</section>
		</body>
    </html>
