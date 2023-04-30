<?php
$id = $_GET['id'];/*base encounter id*/
$import_name = $_POST['name'];/*imported encounter name*/

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://combathelper.herokuapp.com/encounter_import/$id",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\r\n  \"import_name\": \"$import_name\"\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
header('Location: ' . $_SERVER['HTTP_REFERER']);
