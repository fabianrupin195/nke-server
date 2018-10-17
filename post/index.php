<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
?>

<!DOCTYPE html>
<html class="no-js"
      lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible"
          content="ie=edge">
    <title>MAPPED</title>
    <meta name="description"
          content="Réupération et visualisation des évènements transmises par le lidar">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
          integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M"
          crossorigin="anonymous">
    <link href="css/dashboard.css"
          rel="stylesheet">
    <link rel="apple-touch-icon"
          href="apple-touch-icon.png">
    <link rel="icon"
          type="image/png"
          href="logo.png"/>
</head>


<body>
<?php

//Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=mapped;charset=utf8', 'mapped', 'NjflYsNAJHMdGIqt', array
    (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// enregistrement de la requete POST dans la table de log
if (isset($_POST) && $_POST != NULL) {
    try {
        $stringMessage = "";
        foreach ($_POST as $key => $value) {
            $stringMessage .= $key . " => " . $value . ";";
        }
        $IPSender = $_SERVER['REMOTE_ADDR'];

        $serverReceptionDate = date('Y-m-d H:i:s');

        $req = $bdd->prepare('
          INSERT INTO 
            log(server_reception_time, ip_sender, string_message)
          VALUES
            (:server_reception_time, :ip_sender, :string_message)');
        $arrayToPass = [
            ':server_reception_time' => $serverReceptionDate,
            ':ip_sender' => $IPSender,
            ':string_message' => $stringMessage
        ];
        $req->execute($arrayToPass);
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
?>

</body>

</html>
