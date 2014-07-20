<?php

require 'soap_config.php';


$client = new SoapClient(null, array('location' => $soap_location,
		'uri'      => $soap_uri,
		'trace' => 1,
		'exceptions' => 1));


try {
	if($session_id = $client->login($username, $password)) {
		echo 'Logged successfull. Session ID:'.$session_id.'<br />';
	}

	//* Set the function parameters.
	$client_id = 1;
	$params = array(
		'server_id' => 1,
		'priority' => 3,
		'policy_id' => 1,
		'email' => 'hmmnoe@test.int',
		'fullname' => 'Max Mustermann',
		'local' => ''
	);

	$affected_rows = $client->mail_spamfilter_user_add($session_id, $client_id, $params);

	echo "Spamfilter user ID: ".$affected_rows."<br>";

	if($client->logout($session_id)) {
		echo 'Logged out.<br />';
	}


} catch (SoapFault $e) {
	echo $client->__getLastResponse();
	die('SOAP Error: '.$e->getMessage());
}

?>
