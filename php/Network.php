<?php
  /* CURL */
  $data = array("value1" => $user, "value2" => $pass);                                                                    
	$data_string = json_encode($data);                                                                                   
																														 
	$ch = curl_init('https://');                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data_string))                                                                       
	);                                                                                                                   
																														 
	$result = curl_exec($ch);
?>
