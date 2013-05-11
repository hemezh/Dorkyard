<?php
    	
    	
    	require_once("user_activity.php");
        

    	connection();
        //echo getID("sachin");

        $arr['message']="test message :-)";
        $arr['categoryid']="n43kjl";
        
        //addMessage($arr);
       // addLike("c8d488","hemezh");
       // addDislike("c8d488","sacgup");
        echo getLikes("ec8608");
        echo getDislikes("ec8608");
        //deletePlaylist("ID012","hindi");
        deleteUserLike("ec8608","sachin");
        deleteUserDislike("ec8608","spandey");
        echo getLikes("ec8608");
        echo getDislikes("ec8608");
/*
    	addPlaylist($u,"hindi");
    	addPoints($u,5);
    	
        addSongToPlaylist($u,"hindi","wahwah");
    	echo getFancount($u);
    	echo getPoints($u);
        echo "<br>";
*/
    	//deletePlaylist("ID012","hindi");
    	//deleteSongFromPlaylist("ID012","hindi","wahwah");
       
?> 