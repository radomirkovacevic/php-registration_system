<?php
include '../inc/connection_data/connection-to-table.php';

class ActivationLink extends Exception{
	private $activateAddress;
	function __construct($activateAddress){
		$this->activateAddress = $activateAddress;
	}
	
	function errorMessage() {
		header('Location: http://'.$_SERVER['HTTP_HOST'].'/error.html');
		exit;
	}
	
    function c()
    {
        $mysql_Connector= new Mysql_Connector();
        return $mysql_Connector->connect();
	}
	
	function activation(){
		try {
			$connection=$this->c();
		    $temLink = $this->activateAddress;
		    $stmt = $connection->prepare('
			UPDATE users 
			SET user_validated = 1 
			WHERE user_key=?
			');
		$stmt->bind_param(
		's', $temLink
		);
		$stmt->execute();
		$stmt->store_result();
		header('Location: http://'.$_SERVER['HTTP_HOST']);
		exit;
		} catch (ActivationLink $e) {
			$e->errorMessage();
		}
	}
	

}


	$uid = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$s = explode('=', $uid);
	$activateKey = new ActivationLink($s[1]);
	$activateKey->activation();

?>
