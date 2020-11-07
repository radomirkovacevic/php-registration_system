<?php
include '../inc/connection_data/connection-to-table.php';

class Login{
    private $proccessUsermail ;
    private $proccessPassword;
    function __construct($proccessUsermail,$proccessPassword) {
        $this->proccessUsermail = $proccessUsermail ;
        $this->proccessPassword = $proccessPassword ;
      }
    function errorMessage()
	{
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/error.html');
        exit;
	}

    function exitInput()
	{
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/login.php');
        exit;
	}

    function c()
    {
        $mysql_Connector= new Mysql_Connector();
        return $mysql_Connector->connect();
	}

    function checkUser(){
		try{
			$connection=$this->c();
            $valid=1;
            $proccessUsermailOverride = $connection->real_escape_string($this->proccessUsermail);
            $code='example';
            $pwd_peppered = sha1($this->proccessPassword, $code);
            $pwd_hashed = sha1($pwd_peppered);
            $proccessPasswordOverride= $connection->real_escape_string($pwd_hashed);
            $stmt = $connection->prepare('
			    SELECT id, first_name, last_name, user_mail, date, user_role FROM users WHERE user_mail=? AND user_password=? AND user_validated=? LIMIT 1'
			);
            $stmt->bind_param('sss',
                $proccessUsermailOverride,
                $proccessPasswordOverride,
                $valid);
            $stmt->execute();
            $stmt->store_result();
			$stmt->bind_result($id, $first_name, $last_name, $user_mail, $user_date, $user_role);
            if($stmt->num_rows === 1){
                $_SESSION['verified'] = true;
				while ($stmt->fetch()){
					$user_values = array($id, $first_name, $last_name, $user_mail, $user_date, $user_role);
					$_SESSION['activated_user'][] = $user_values;
				}
                header('Location: http://'.$_SERVER['HTTP_HOST']);
                exit;
            }
			else{
				$_SESSION['error'] = 'Your login details are incorect.';
	            sleep(5);
				$this->exitInput();
            }
		}
		catch (Proccess $e){
		    $e->errorMessage();
	    }
		finally{
            $stmt->close();
            $connection->close();
		}
    }
}

    session_start();
    if(isset($_POST['insert'])){
        array_key_exists('counter', $_SESSION) ? $_SESSION['counter']++ : ($_SESSION['counter'] = 1);
        if ($_SESSION['counter'] < 5) {
        $login = new Login(
        strtolower($_POST['mail']),
        $_POST['password']
    );
    $login->checkUser();
    }
    else{
        sleep(5);
		$login->exitInput();
    }
}
