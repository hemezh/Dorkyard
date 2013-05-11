<?php
		include("configuration.php");
    	function processQuery($sqlQuery){

	        $query = mysql_query($sqlQuery) or die(mysql_error());
	        if(!$query)
	            return false;
	        return $query;

    	}
		
		
	    function processArray($sqlQuery){

	        if($query = processQuery($sqlQuery)){
	            if(mysql_num_rows($query)){
	                $query = mysql_fetch_array($query);
	                return $query;
	            }
	            return false;
	        }
	        return false;
	    }

	    
	    function getValueByQuery($sqlQuery){

        if($query = processArray($sqlQuery))
                return $query[0];
        return false;
		}


	    function getValue($column, $table, $condition, $value){     
	        $query = "SELECT $column FROM $table WHERE $condition = \"$value\" LIMIT 1";
	        if($query = processArray($query))
	                return $query[0];

	        return false;

	    }

	    function getID($str) {

	    	$str=$str.date("Y-m-d H:i:s")."<br>"; 
	    	return str_shuffle(substr(md5($str),0,6));

	    }
?>