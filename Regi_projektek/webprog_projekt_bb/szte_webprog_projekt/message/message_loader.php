<?php
	if(!isset($_SESSION)){session_start();}
	include("message_functions.php");
	
	// save sent messages
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		if( !empty($_POST['chat-input']) and !empty($_POST['partner'])){
			
			$chat_input = $_POST['chat-input'];
			$from_user = $_SESSION["user_name"];
			$to_user = $_POST['partner'];
			
			$message_array = save_messages($from_user, $to_user, $chat_input);
			
			$_SESSION["message_array"] = $message_array;
			$_SESSION["chat-partner"] = $to_user;
		}
	}
	header('location: message_page.php');
	die;
?>