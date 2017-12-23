<!DOCTYPE html>
<html>
<head>
<title>Select Tickets characteristics</title>
<link rel="stylesheet" href="//cdn.rawgit.com/yegor256/tacit/gh-pages/tacit-css-1.2.5.min.css"/>
</head>
<body>
<?php
    $prio = $_POST["priority"];
    $env = $_POST["environment"];
    $dif = $_POST["difficulty"];
    $id = $_POST["id"];
	$data = array(
		'priority' => array(
			'type' => 'string',
		    'value' =>  $prio
		),
		'environment' => array(
			'type' => 'string',
		    'value' =>  $env
		),
		'difficulty' => array(
			'type' => 'string',
		    'value' =>  $dif
		)
	);
	//echo "data: " . $data ."\n";
	$service_url = 'https://dmn.camunda.cloud/api/v1/decision/decision-2b5e0ac2-e7cb-11e7-bacd-0242ac120008';
	$curl = curl_init($service_url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
  	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$data_string = json_encode($data);
	//echo "data_string: " . $data_string . "\n";
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	$curl_response = curl_exec($curl);
	//echo "curl_response: " . $curl_response ."\n";
	curl_close($curl);
	$decoded = json_decode($curl_response);
	$person = $decoded->outputs->person->values[0];

    $email = array(
		'Student' => 'severin@th-brandenburg.de',
		'Engineer' => 'severinlx@yahoo.com',
		'IT Lead' => 'severinsasha@gmail.com'
		);

    // the message
	$msg = "The Ticket with number ". "<b>" . $id ."</b>".", with a " . "<b>" .$prio ."</b>". " priority" .  " and " . "<b>" .$dif ."</b>". " difficulty level, on " ."<b>". $env. "</b>" . " will be taken care by " . "<b>". $person ."</b>";
	echo $msg . "<br> An email was sent to " ."<b>".$email[$person]."</b>";
	$msg = wordwrap($msg,70);
	mail($email[$person],"Neuer Ticket",$msg);
?>
</body>
</html>