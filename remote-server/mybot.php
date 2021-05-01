<?php

function openDoor($ngrok_domain){
 $url = "http://" . $ngrok_domain . "/hook.php";
 $client = curl_init($url);
 curl_setopt($client, CURLOPT_POST, 1);
 curl_setopt($client, CURLOPT_POSTFIELDS,"password=testtest");
 curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
 $response = curl_exec($client);
 return $response;
}

//parameters
$hubVerifyToken = 'testtest';
$accessToken = "YOUR-FACEBOOK-ACCESS-TOKEN";

// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
}

// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);

$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];
$response = null;

// $senderId;

$fb_bot_id = ID-OF-BOT;

//set Message

if(substr($messageText,0,5) == "@echo") {
	$answer = substr($messageText,(6 - strlen($messageText)));
}
else if (substr($messageText,0,4) == "@md5"){
	$answer = md5(substr($messageText, (5 - strlen($messageText)))); 
}
else if (substr($messageText,0,8) == "@reverse"){
	$answer = strrev(substr($messageText, (9 - strlen($messageText))));
}
else if (substr($messageText,0,10) == "@wordcount"){
	$answer = str_word_count(substr($messageText, (11 - strlen($messageText))));
}
else if (substr($messageText,0,6) == "O"){
	if ($senderId == YOUR-FACEBOOK-ID){
		$ngrok_domain = "mydomain.ngrok.io";
		$response = openDoor($ngrok_domain);
		if($response == " 1")
			$answer = "You are authorized!\nEntrace Door Opened!";
		else if ($response == " 2")
			$answer = "Incorrect Password.\nStop hacking :P";
		else if ($response == " 3")
			$answer = "Password not set.\nUnauthorized!";
	}
	else
		$answer = "You are unauthorized.\nAsk Owner for permissions.";
}
else if ($messageText == "@whoami"){
	$id = exec('whoami');
	$answer = "The current OS user is:\n" . $id . "\n";
}
else{
	$answer = "Type a command followed by a space, then your text:\n\n";
	$answer = $answer . "@help to display  this menu.\n";
	$answer = $answer . "@md5 generate md5 hash.\n";
	$answer = $answer . "@whoami to get current user.\n";
	$answer = $answer . "@reverse reverses the text.\n";
	$answer = $answer . "@wordcount to count words.\n";
	$answer = $answer . "@echo to echo text.\n";
	$answer = $answer . "'O' to open the Entrace Door.\n";
}

//send message to facebook bot
$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];


$ch = curl_init('https://graph.facebook.com/v3.3/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
if(!empty($input['entry'][0]['messaging'][0]['message'])){
	$result = curl_exec($ch);
}
curl_close($ch);
?>
