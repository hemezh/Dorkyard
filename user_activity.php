<?php
		require_once("sql_functions.php");
		
    	function getTotalPosts() {
			$query = "select max(postcount) from con_confessions";
			$f=getValueByQuery($query);
    		return $f;
		}
		
		function addUser($userid,$name,$email) {
			echo $query = "insert into con_users (userid,name,email) values(\"$userid\",\"$name\",\"$email\") ";
				if(!processQuery($query)) {
	    			if($debug) echo "User not added.<br>";
					return false;		
	    	}
		}

		function addUserLog($userid,$localip,$globalip,$browser) {
			
			echo $query = "insert into con_logs (userid,localip,globalip,browser) values(\"$userid\",\"$localip\",\"$globalip\",\"$browser\") ";
				if(!processQuery($query)) {
	    			if($debug) echo "User not added.<br>";
					return false;		
	    	}
		}

		function checkUserExist($userid) {
			echo $query = "select count(*) from con_users where userid=\"$userid\" ";
			if(getValueByQuery($query)==0) {
	        	if($debug) echo "user match to message like not found<br>";
	        	return false;
	        }
	        else
	        	return true;
		}
		
		function addMessage($message,$categoryid){
			$message=trim($message);
			$error=0;
			
			if($message=="") {
				if($debug) echo "Enter any confession.<br>";
				$error=1;
			}
			if($categoryid=="0") {
				if($debug) echo "Select any category.<br>";
				$error=1;
			}
			if($error==0) {
					$messageid=getID(substr($message,0,10));
					$message = addslashes($message);
					$query = "insert into con_confessions (messageid,message,category) values(\"$messageid\",\"$message\",\"$categoryid\") ";
					if(!processQuery($query)) {
		    			if($debug) echo "Confession not added.<br>";
						return false;		
		    		}
			}
			else
				return false;

		}


		function checkUserLike($messageid,$userid) {

		$query = "select count(*) from con_confessions where messageid=\"$messageid\" and lusers like \"%$userid%\" ";
			if(getValueByQuery($query)==0) {
	        	if($debug) echo "user match to message like not found<br>";
	        	return false;
	        }
	        else
	        	return true;

		}

		function checkUserDislike($messageid,$userid) {

		$query = "select count(*) from con_confessions where messageid=\"$messageid\" and dusers like \"%$userid%\" ";
			if(getValueByQuery($query)==0) {
	        	if($debug) echo "user match to message dislike not found<br>";
	        	return false;
	        }
	        else
	        	return true;

		}

		function getMessage($postcount) {


			$query = "select messageid,postcount,message,likes,dislikes,time from con_confessions where postcount=\"$postcount\" ";
			if($result=processArray($query)) {
				return $result;
			}
			else {
				if($debug) echo "Messages Not fetched.<br>";
				return false;
			}
			return true;

		}
		
		function getMessages($categoryid,$start=0,$count=10) {

			//echo $categoryid." hello <br>";
			$query = "select messageid,postcount,message,likes,dislikes,time from con_confessions where category like \"$categoryid\" order by likes desc,time desc limit $start, $count";
			if($result=processQuery($query)) {
				return $result;
			}
			else {
				if($debug) echo "Messages Not fetched.<br>";
				return false;
			}
			return true;

		}

		function addComment($messageid,$comment){
			
			$comment=trim($comment);
			$error=0;
			if($comment=="") {
				if($debug) echo "Enter any confession.<br>";
				$error=1;
				return false;
			}
			if($error==0) {
					$query = "insert into con_comments (messageid,comment) values(\"$messageid\",\"$comment\") ";
					if(!processQuery($query)) {
		    			if($debug) echo "Comment not added.<br>";
						return false;		
		    		}
			}
			else
				return false;

			return true;

		}
	    
	    function addLike($messageid,$userid){

	    	//$debug=false;
	    	$error=0;
	    	$step=1;
	    	if(checkUserLike($messageid,$userid)) {
	    		if(!deleteUserLike($messageid,$userid)) {
	    			//echo "Your previous like was not deleted.<br>";
	    			$error=1;

	    			//return false;
	    		}
	    		else
	    			$step=0;

	    	}
	    	else if(checkUserDislike($messageid,$userid)) {
	    		if(!deleteUserDislike($messageid,$userid)) {
	    			//echo "Your previous dislike was not deleted.<br>";
	    			$error=1;
	    			//return false;
	    		}
	    	}
	    	if($step==1) {
		    	$query = "update con_confessions set lusers=concat(lusers,\"$userid\",\":\") where messageid=\"$messageid\"";
		    	if(!processQuery($query))
		        	{
		        		if($debug) echo "user in like list not added.<br>";
		        		$error=1;
		        		//return false;
		        	}
		        else {
		        	$query = "update con_confessions set likes=likes+1 where messageid=\"$messageid\"";
		        	if(!processQuery($query))
			        	{
			        		if($debug) echo "like count not added.<br>";
			        		$error=1;
			        		//return false;
			        	}
		        }

	    	}
	    	
	        $x=getLikes($messageid);
	        $y=getDislikes($messageid);
	        echo "$x:$y";
	        if($error==0)
	        	return true;
	    	else
	    		return false;
       		
		}
		function addDislike($messageid,$userid){

	    	//$debug=true;
	    	$error=0;
	    	$step=1;
	    	if(checkUserDislike($messageid,$userid)) {
	    		if(!deleteUserDislike($messageid,$userid)) {
	    			//echo "Your previous dislike was not deleted.<br>";
	    			$error=1;
	    			//return false;
	    		}
	    		else
	    			$step=0;
	    	}

	    	else if(checkUserLike($messageid,$userid)) {
	    		if(!deleteUserLike($messageid,$userid)) {
	    			//echo "Your previous like was not deleted.<br>";
	    			$error=1;
	    			//return false;
	    		}
	    	}
	    	if($step==1){
		    	$query = "update con_confessions set dusers=concat(dusers,\"$userid\",\":\") where messageid=\"$messageid\"";
		    	if(!processQuery($query))
		        	{
		        		if($debug) echo "user in dislike list not added.<br>";
		        		$error=1;
		        		//return false;
		        	}
		        else {
		        	$query = "update con_confessions set dislikes=dislikes+1 where messageid=\"$messageid\"";
		        	if(!processQuery($query))
			        	{
			        		if($debug) echo "dislike count not added.<br>";
			        		$error=1;
			        		//return false;
			        	}
		        }
	        }
	        $x=getLikes($messageid);
	        $y=getDislikes($messageid);
	        echo "$x:$y";
	        if($error==0)
	        	return true;
	    	else
	    		return false;
	        
       		
		}

		function getLikes($messageid) {

			//$debug=false;
	        $query = "select likes from con_confessions where messageid=\"$messageid\" ";
	        $f=getValueByQuery($query);
	        if($f==false) {
	       		if($debug) echo "likes not found<br>";
	       	}
	       	return $f;
		}

		function getDislikes($messageid) {

			//$debug=false;
	        $query = "select dislikes from con_confessions where messageid=\"$messageid\" ";
	        $f=getValueByQuery($query);
	        if($f==false) {
	       		if($debug) echo "dislikes not found<br>";
	       	}
	       	return $f;

		}

		function updateMessageLikeUsers($messageid,$users){

    		//$debug=false;
	        $query = "update con_confessions set lusers=\"$users\" where messageid=\"$messageid\" ";
	        //echo "<br>";
	        if(!processQuery($query))
	        	{
	        		if($debug) echo "Liked users not updated.<br>";
	        		return false;
	        	}
	            
	        return true;

    	}
		function deleteUserLike($messageid,$userid) {

    			//$debug=true;
    			$query="select lusers from con_confessions where messageid=\"$messageid\" ";
    			if(($users=getValueByQuery($query))) {
        			$pos = strpos($users, $userid);
        			if ($pos !== false) {
					   	$l=strlen($userid);
					    $new="";
					    if($pos>0)
					     	$new=$new.substr($users,0,$pos-1);
					     else
					     	$pos=1;
					    $new=$new.substr($users,$pos+$l);

					    if(!updateMessageLikeUsers($messageid,$new)) {
					    		if($debug) echo "Users list for likes not updated.<br>";
					    		return false;
					    } else {
					    	$query = "update con_confessions set likes=likes-1 where messageid=\"$messageid\"";
					    	if(!processQuery($query))
					        	{
					        		if($debug) echo "like count for message not updated but user entry deleted.<br>";
					        		return true;
					        	}
					    }
					     
					} else {
					   if($debug) echo "Some error occured while deleting like.<br>";
					}
				} else {
					if($debug) echo "Like Users not retrived for message.<br>";
				}	

	        	
	            
	        return true;
    	}

    	function updateMessageDislikeUsers($messageid,$users){

    		//$debug=false;
	        $query = "update con_confessions set dusers=\"$users\" where messageid=\"$messageid\" ";
	        //echo "<br>";
	        if(!processQuery($query))
	        	{
	        		if($debug) echo "Disliked users not updated.<br>";
	        		return false;
	        	}
	            
	        return true;

    	}

    	function deleteUserDislike($messageid,$userid) {

    			//$debug=true;
    			$query="select dusers from con_confessions where messageid=\"$messageid\" ";
    			if(($users=getValueByQuery($query))) {
        			$pos = strpos($users, $userid);
        			if ($pos !== false) {
					   	$l=strlen($userid);
					    $new="";
					    if($pos>0)
					     	$new=$new.substr($users,0,$pos-1);
					     else
					     	$pos=1;
					    $new=$new.substr($users,$pos+$l);

					    if(!updateMessageDislikeUsers($messageid,$new)) {
					    		if($debug) echo "Users list for Dislikes not updated.<br>";
					    		return false;
					    } else {
					    	$query = "update con_confessions set dislikes=dislikes-1 where messageid=\"$messageid\"";
					    	if(!processQuery($query))
					        	{
					        		if($debug) echo "dislike count for message not updated but user entry deleted.<br>";
					        		return true;
					        	}
					    }
					     
					} else {
					   if($debug) echo "Some error occured while deleting dislike.<br>";
					}
				} else {
					if($debug) echo "DisLike Users not retrived for message.<br>";
				}	

	        	
	            
	        return true;
    	}

?>