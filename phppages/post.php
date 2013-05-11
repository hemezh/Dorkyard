<?php
require_once("user_activity.php");

extract($_POST);
$x=$file;

	if($x=="vote") {
			if($action=="like") 
				addLike($postid,$id);
			else if($action=="dislike")
				addDislike($postid,$id);
	}
	else if($x=="post") {
		addMessage($content,$category);

	}
	else if($x=="register") {
		
	}
	else {
			
	}
?>