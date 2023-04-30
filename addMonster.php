<?php

$name = $_POST['name'];
$AC = $_POST['AC'];
$HP = $_POST['HP'];
$DEX = $_POST['DEX'];
$WIS = $_POST['WIS'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://combathelper.herokuapp.com/monster",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\"name\":\"$name\",\"AC\":\"$AC\",\"HP\":\"$HP\",\"DEX\":\"$DEX\",\"WIS\":\"$WIS\"}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);

header("Location: index.php");


