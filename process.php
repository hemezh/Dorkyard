<?php
require_once("user_activity.php");
	require_once("template.php");

extract($_POST);
$x=$file;
	if( empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
  		/* special ajax here */
  	die();
	}
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
		
		if(!checkUserExist($userid)) {
			addUser($userid,$name,$email);
		}
		$agent = $_SERVER ['HTTP_USER_AGENT'];
        $ip = $_SERVER ['REMOTE_ADDR'];
        if (getenv ( 'HTTP_X_FORWARDED_FOR' ))
                $ip2 = getenv ( 'HTTP_X_FORWARDED_FOR' );
        else
                $ip2 = getenv ( 'REMOTE_ADDR' );
       
        addUserLog($userid,$ip2,$ip,$agent);
        
	}
	else if($x=="paginate"){
		getMorePosts($category=1,$start,$count);
	}
	else {
			echo "Fuck Off!!";
	}
?>