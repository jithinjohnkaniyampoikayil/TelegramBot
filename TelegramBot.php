<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('BOT_TOKEN', '**********');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

$content = file_get_contents("php://input");
$update = json_decode($content, true);

	if (!$update) {
		// receive wrong update, must not happen
		exit;
	}
	
	if (isset($update["message"])) {
		savemessage($update["message"]);
		processMessage($update["message"]);
	}

	function apiRequestWebhook($method, $parameters) {
	  if (!is_string($method)) {
	    error_log("Method name must be a string\n");
	    return false;
	  }
	
	  if (!$parameters) {
	    $parameters = array();
	  } else if (!is_array($parameters)) {
	    error_log("Parameters must be an array\n");
	    return false;
	  }
	
	  $parameters["method"] = $method;
	
	  header("Content-Type: application/json");
	  echo json_encode($parameters);
	  return true;
	}
	
	
	
	function processMessage($message) {
	  // process incoming message
	  $salutation=array("hai","da","hello","daaa","kooi","hi","bro");
	  
	  $message_id = $message['message_id'];
	  $chat_id = $message['chat']['id'];
	  $messagetext=strtolower($message['text']);
	  if (isset($message['text'])) {
	    
	  	if(array_filter($salutation, function($el) use ($messagetext) {
	        return ( strpos($el, $messagetext) !== false );
	    })){
	  		apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "text" => 'Hi, How can i help you? Are you a student?','reply_markup' => array(
	  		'keyboard' => array(array('Yes', 'No')),
	        'one_time_keyboard' => true,
	        'resize_keyboard' => true)));
	  		
	  	}
	  	
	  	
	  	
	  } 
	  else {
	    apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => 'I understand only text messages'));
	  }
	}



