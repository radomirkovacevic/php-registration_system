<?php
include '../inc/connection_data/connection-to-table.php';

class Proccess extends Exception
{
    private $proccessFirstname;
    private $proccessLastname;
    private $proccessUsermail;
    private $proccessPassword;
	private $proccessUserKey;
	
    function __construct($proccessFirstname, $proccessLastname, $proccessUsermail, $proccessPassword, $proccessUserKey)
    {
        $this->proccessFirstname  = $proccessFirstname;
        $this->proccessLastname = $proccessLastname;
        $this->proccessUsermail = $proccessUsermail;
        $this->proccessPassword = $proccessPassword;
		$this->proccessUserKey = $proccessUserKey;
    }
	
    function errorMessage()
	{
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/error.html');
        exit;
	}
	
    function exitInput()
	{
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/register.php');
        exit;
	}
	
    function c()
    {
        $mysql_Connector= new Mysql_Connector();
        return $mysql_Connector->connect();
	}

    function firstletterUpcase()
    {
        $this->proccessFirstname = ucwords($this->proccessFirstname);
        $this->proccessLastname = ucwords($this->proccessLastname);
        $this->passLen();
    }
	
    function passLen()
    {
        if (strlen($this->proccessPassword) >= (int)4)
		{
            $code = 'example2';
            $pwd_peppered = sha1($this->proccessPassword, $code);
            $pwd_hashed = sha1($pwd_peppered);
            $this->proccessPassword = $pwd_hashed;
            $this->mailValid();
        }
		else
		{
			$_SESSION['error'] = 'Your password have no enough characters.';
			sleep(5);
			$this->exitInput();
        }
    }	
	
	
    function mailValid()
    {
        if (filter_var($this->proccessUsermail, FILTER_VALIDATE_EMAIL))
		{
            $this->nameValid();
        }
		else
		{
			$_SESSION['error'] = 'Your mail have no good format.';
            sleep(5);
			$this->exitInput();
        }
    }	
	
	
	function nameValid()
    {
        if(preg_match('/^[a-zA-Z -]+$/', $this->proccessFirstname) and 
		   preg_match('/^[a-zA-Z -]+$/', $this->proccessLastname)){
         	$this->checkUserMail();
        }
		else{
			$_SESSION['error'] = 'Your first or last name has wrong characters.';
            sleep(5);
			$this->exitInput();
        }
    }
	
	function checkUserMail()
    {
		try{
			$connection=$this->c();
        	$stmt = $connection->prepare(
            # 0 doesn't exist 1 exist and validated
            	'SELECT * FROM users WHERE user_mail = ? AND user_validated = 1'
        	);
        	$stmt->bind_param(
			    's', 
			    $this->proccessUsermail
			);
        	$stmt->execute();
            $stmt->store_result();
			if($stmt->num_rows){ 
				$_SESSION['error'] = 'User with that mail already exist.';
				sleep(5);
				$this->exitInput();     
			}
			else{
				$this->createLink();
			}
		}
		catch (Proccess $e){
		    $e->$this->errorMessage();
	    }
    }	
	
	function createLink()
	{
		$key = microtime();
		$stringMixKey= $this->proccessFirstname + '#' + $this->proccessLastname + '#' + $key + 'example';
		$this->proccessUserKey = md5($stringMixKey);
		$this->insertUser();
	}	
	
    function insertUser()
    {
		try{
		    $connection=$this->c();
            $stmt = $connection->prepare('
			    INSERT INTO users (first_name, last_name, user_mail, user_password, user_key) VALUES (?, ?, ?, ?, ?)
			');
            $stmt->bind_param(
                'sssss',
                $this->proccessFirstname,
                $this->proccessLastname,
                $this->proccessUsermail,
                $this->proccessPassword,
			    $this->proccessUserKey
            );
            $stmt->execute();
			$_SESSION['error'] = 'Activation link is sended, check spam/junk folder.';
            $this->mailKey();
		    }
		catch (Proccess $e){
		    $e->$this->errorMessage();
	    }
		finally{
            $stmt->close();
            $connection->close();
		}
    }	
	
    function mailKey(){
		try{
            $to = $this->proccessUsermail;
            $subject = 'Email Veritification';
            $msg = '
            Click on folowing link to activate account:[br]
            [color=green][url]<a href="' . $_SERVER['HTTP_HOST'] . '/activate.php?uid=' . $this->proccessUserKey . '.php"></a>[/url][/color]';
            $headers = array();
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/plain; charset=UTF-8';
            $headers[] = 'From: no-reply <administration@mail.net>';
            $headers[] = 'Subject: {$subject}';
            $headers[] = 'X-Mailer: PHP/'.phpversion();
            mail($to, $subject, $msg, implode('\r\n', $headers));
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php');
            exit;
		}
		catch (Proccess $e){
		    $e->errorMessage();
	    }
    }	

	}

#END

session_start();
if (isset($_POST['insert']))
{
	array_key_exists('counter', $_SESSION) ? $_SESSION['counter']++ : ($_SESSION['counter'] = 1);
    if ($_SESSION['counter'] < 97)
	{
        $proccess = new Proccess(
            strtolower($_POST['firstnameSet']),
            strtolower($_POST['lastnameSet']),
            strtolower($_POST['mailSet']),
            $_POST['passwordSet'],
			''
    );
    $proccess->firstletterUpcase();
    }
	else
	{
        header('Location: http://'.$_SERVER['HTTP_HOST']);
        exit;
    }
}
