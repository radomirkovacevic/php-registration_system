<?php
    session_start();
    if(!isset($_SESSION['verified']) || $_SESSION['verified'] !== true){
        header('Location: http://' . $_SERVER['HTTP_HOST']);
        exit;
    }
    else{
        $role;
            foreach($_SESSION['activated_user'] as $aus){
				$role= $aus[5];
		    }
		}
?> 
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
        <div class="cpanel-area">
        <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Welcome, <?php foreach($_SESSION['activated_user'] as $aus){print $aus[1] . ' ' . $aus[2];}  ?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?php foreach($_SESSION['activated_user'] as $aus){print $aus[3];}  ?></h6>
    <p class="card-text">Date of your registration: <br><?php foreach($_SESSION['activated_user'] as $aus){print $aus[4];}  ?></p>
    <p class="card-text">Your role is: <br><?php foreach($_SESSION['activated_user'] as $aus){print $aus[5];}  ?></p>
    <a href="index.php" class="card-link">Homepage</a>
    <a href="logout.php" class="card-link">Logout</a>
  </div>
</div>
      </section>
