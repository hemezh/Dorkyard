<?php
    	$debug=false;

		function connection() {
			$mysqlServer = "localhost";       //the ip of the mysql server
	        $mysqlUsername = "root";          //the mysql username which will connect to the server
	        $mysqlPassword = "";    //the mysql password against the given username
	        $mysqlDatabase = "confess";      //the database where everything will be saved
	        $debug=true;

			if($connection=mysql_connect($mysqlServer, $mysqlUsername, $mysqlPassword)) {
				if(mysql_select_db($mysqlDatabase, $connection))
					return true;
				else {
					if($debug) echo "Database Not selected.<br>";
					
					return false;
				}
			}
			else {
				if($debug) echo "Connection to database failed.<br>";
				
				return false;
			}

		}
?>