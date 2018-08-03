<?php
$target_dir = "./";
// Get the Filename
$source_file = urldecode($_GET["Filename"]);
// Set the complete name of the future saved file
$target_file = $target_dir . $source_file;
// Get the content of the file
$json_data = file_get_contents("php://input");
if (stristr($source_file, 'asso_request_') == FALSE) {
// If it is not an association request: save the file
    file_put_contents($target_file, $json_data);
} else {
// It is an association request: send an OK answer file
// Get the devEUI
    $devEUI = substr($source_file, 13, 16);
// Answer
    $devStatus = "OK";
// Format the complete file
    $json_answer = "{\r\n\t\"LoRa_GW_Asso_Answer_File\":
{\r\n\t\t\"End_Device_ID\": {\r\n\t\t\t\"DevEUI\": \"$devEUI\"\r\n\t\t},\r\n\t\t\"Asso_status\": \"$devStatus\"\r\n\t}\r\n}\r\n";
// Prepare the header
    header('Content-Type: application/json');
// Send the answer
    echo $json_answer;
}
