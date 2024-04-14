<?php
	
	function store_messages_in_array($message_array, $con, $query){
		$query_result = mysqli_query($con, $query);
		
		while($row = mysqli_fetch_assoc($query_result)){
			$message_array[$row["id"]] = ["received" => $row["to_user"] == $_SESSION["user_name"] , "msg" => $row["message"]];
		}
		
		mysqli_free_result($query_result);
		return $message_array;
	}
	
	
	function get_messages(){
		if(isset($_SESSION["user_name"]) and isset($_SESSION["chat-partner"])){
			include("../connection.php");
			
			$user_name = $_SESSION["user_name"];
			$partner = $_SESSION["chat-partner"];
			$message_array = array();
			
			// get messages received
			$query = "select * from messages_01 where to_user = '$user_name' and from_user = '$partner'";
			$message_array = store_messages_in_array($message_array, $con, $query);
		
			// get messages sent
			$query = "select * from messages_01 where from_user = '$user_name' and to_user = '$partner'";
			$message_array = store_messages_in_array($message_array, $con, $query);
			
			mysqli_close($con);
			return $message_array;
		}
		return null;
	}
	
	
	function save_messages($from_user, $to_user, $chat_input){
		$message_array = array();
		
		$query = "insert into messages_01 (from_user,to_user,message) values('$from_user', '$to_user', '$chat_input')";
		include("../connection.php");
		mysqli_query($con, $query);
		
		mysqli_close($con);
		
		// Update messages
		$message_array = get_messages();
		return $message_array;
	}
	
?>