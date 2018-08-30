<?php
// Set the destination directory
$target_dir = "./Logs/";
// Get the date with the wanted format
$date = date("Ymdhis");
// Form the new file name of the file that will be saved
$underscore = "_";
$extension = ".json";
$filename = urldecode($_GET["Filename"]);
// Get the file content from the POST
$json_data = file_get_contents("php://input");

// Check if the file is an association request
if( stristr($filename, "asso_request_") == FALSE )
{
    if( stristr($filename, "d_") != FALSE )
    {
        $head = "data_";
        $devEUI = substr($filename, 2, 16);
    }
    else if( stristr($filename, "a_") != FALSE )
    {
        $head = "alarm_";
        $devEUI = substr($filename, 2, 16);
    }
    else if( stristr($filename, "topology_lora") != FALSE )
    {
        $head = "paired_devices";
        $devEUI = "";
    }

    $target_file = $target_dir . $head . $devEUI . $underscore . $date . $extension;

    // Save this content in the new created file
    file_put_contents($target_file, $json_data);
}
else
{
    // The file is an association request
    // Get the end-device devEUI
    $devEUI = substr($filename, 13, 16); // Get rid of "asso_request_" and ".json"

    // OK file
    $fileToAns = "{\n\"LoRa_GW_Asso_Answer_File\":{\n\"End_Device_ID\":{\n\"DevEUI\":\"$devEUI\",\n},\n\"Asso_status\":\"OK\"\n}\n}";

    // NOK file
    //$fileToAns = "{\n\"LoRa_GW_Asso_Answer_File\":{\n\"End_Device_ID\":{\n\"DevEUI\":\"$devEUI\",\n},\n\"Asso_status\":\"KO\"\n}\n}";

    // WAIT file
    //$fileToAns = "{\n\"LoRa_GW_Asso_Answer_File\":{\n\"End_Device_ID\":{\n\"DevEUI\":\"$devEUI\",\n},\n\"Asso_status\":\"WAIT\"\n}\n}";

    header('Content-Type: application/json');

    // Send the file as an answer to the POST
    echo $fileToAns;

    $head = "asso_request_";
    $target_file = $target_dir . $head . $devEUI . $underscore . $date . $extension;

    // Save this content in the new created file
    file_put_contents($target_file, $json_data);
}
?>