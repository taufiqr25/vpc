<?php
require_once 'bot-api-config.php';
require_once 'bot-api-fungsi.php';
require_once 'bot-api-proses.php';


$bodyupdates = file_get_contents('php://input');
$message = json_decode($bodyupdates, true);
prosesApiMessage($message);

?>