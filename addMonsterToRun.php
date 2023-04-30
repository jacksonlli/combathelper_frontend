<?php
$encounter_id = $_GET['encounter_id'];
$monster_name = $_POST['monster_name'];
$monster_name = urlencode($monster_name);
$jsonString = file_get_contents("https://combathelper.herokuapp.com/monster/$monster_name");
$thisMonster = json_decode($jsonString);
$monster_id = $thisMonster->id;
$quantity = $_POST['quantity'];
$AC = $_POST['AC'];
$HP = $_POST['HP'];
$DEX = $_POST['DEX'];
$WIS = $_POST['WIS'];

$postfields = "{\r\n  \"monster_id\": $monster_id,\r\n  \"quantity\": $quantity";

if (is_numeric($AC)){
	$postfields = $postfields . ",\r\n  \"AC\": $AC";
}
if (is_numeric($HP)){
	$postfields = $postfields . ",\r\n  \"HP\": $HP";
}
if (is_numeric($DEX)){
	$postfields = $postfields . ",\r\n  \"DEX\": $DEX";
}
if (is_numeric($WIS)){
	$postfields = $postfields . ",\r\n  \"WIS\": $WIS";
}
$postfields = $postfields . "\r\n}";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://combathelper.herokuapp.com/run_monster/$encounter_id",
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
header('Location: ' . $_SERVER['HTTP_REFERER']);
