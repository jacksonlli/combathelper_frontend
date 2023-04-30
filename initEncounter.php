<?php
$id = $_GET['id'];

$jsonString = file_get_contents("https://combathelper.herokuapp.com/play/$id");
$statusArr = json_decode($jsonString);
if (!empty($statusArr)){
	header("Location: playEncounter.php?id=$id");
}
else{
	$jsonString = file_get_contents("https://combathelper.herokuapp.com/player");
	$playArr = json_decode($jsonString);
	$postfields = "{";

	foreach ($playArr as $player) { 
		$postfields = $postfields . "\"".$player->name."_initiative_roll\":".$_POST[urlencode($player->name)."_initiative_roll"].",";
	}
	$postfields = rtrim($postfields, ",");
	$postfields = $postfields . "}";


	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://combathelper.herokuapp.com/run/$id",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => $postfields,
	  CURLOPT_HTTPHEADER => array(
		"Content-Type: application/json"
	  ),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	$myjson = json_decode($response);

	header("Location: playEncounter.php?id=$id");
}