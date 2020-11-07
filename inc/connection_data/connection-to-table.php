<?php
class Mysql_Connector extends Exception{
	
    function errorMessage()
	{
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/error.html');
        exit;
	}
	
    function connect()
	{

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
		require __DIR__.'/db_credentials.php';
        $mysqli = new mysqli($host, $user, $pass, $db);
        $mysqli->set_charset($charset);
	    return $mysqli;
	}
    catch(Mysql_Connector $e){
	    $e->$this->errorMessage();
    }
    finally{
	    unset($host, $db, $user, $pass, $charset);
    }	
	}
}
?>
