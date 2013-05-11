<?php
		require_once("configuration.php");
		connection();
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

	    function timeago( $datetime1 , $datetime2) {
	    	
	    	$d1=array();
	    	$d2=array();
	    	$d=array();
	    	$a=explode(" ",$datetime1);
	    	$b=explode("-",$a[0]);
	    	$c=explode(":",$a[1]);
	    	array_push($d1, $b[0], $b[1],$b[2],$c[0], $c[1],$c[2]);
	    	//print_r($d1);
	    	$a=explode(" ",$datetime2);
	    	$b=explode("-",$a[0]);
	    	$c=explode(":",$a[1]);
	    	array_push($d2, $b[0], $b[1],$b[2],$c[0], $c[1],$c[2]);
	    	
	    	for($i=0;$i<6;$i++) {
	    		 $d[$i]=$d1[$i]-$d2[$i];
	    	}
			//print_r($d);
	    	$names=array(" years"," months"," days"," hours"," minutes"," seconds");
	    	$name=array(" year"," month"," day"," hour"," minute"," second");
	    	$factor=array(12,30,24,60,60);
	    	$j=1;
	    	$k=-1;
	    	for ($i=0; $i <5 ; $i++) { 
	    		$x=$i+$j;
	    		//print_r($d);
	    		if($d[$i]>0) {
	    			//echo $d[$i]."<br>";
	    			if($d[$x]<0) {
		    			$d[$i]--;
		    			if($d[$i]>0)
		    				return $d[$i].(($d[$i]>$j)?$names[$i]:$name[$i])." ago";
		    			else
		    				return $factor[$i]-($k*$d[$x]).((($factor[$i]-($k*$d[$x]))>1)?$names[$x]:$name[$x])." ago";
	    			}
	    			else
	    				return $d[$i].(($d[$i]>$j)?$names[$i]:$name[$i])." ago";
	    		}
	    	}
	    	return $d[5].(($d[5]>1)?$names[5]:$name[5])." ago";
	    }
?>