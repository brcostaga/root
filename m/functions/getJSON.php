<?php
	function getJSON($query){
		require('adodb_con.php');		
		$result = $con->execute($query);
		$arr = array();
		$rs = array();
		while (!$result->EOF){	    
		    $result->fetchInto($arr);	    
		    $arr = array_map('htmlentities',$arr);
		    array_push($rs,$arr);
		}		
		$json = html_entity_decode(json_encode($rs, JSON_UNESCAPED_UNICODE));	
		echo $json;	
	};
?>