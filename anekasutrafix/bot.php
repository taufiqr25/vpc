<?php
require_once 'bot-api-config.php';
require_once 'bot-api-fungsi.php';
require_once 'bot-api-proses.php';

$bodyupdates = file_get_contents('php://input');
$message = json_decode($bodyupdates, true);
prosesApiMessage($message);

// while (true) {
//     myloop();
// }

// function myloop()
// {
//     global $debug;

//     $idfile = 'botposesid.txt';
//     $update_id = 0;

//     if (file_exists($idfile)) {
//         $update_id = (int) file_get_contents($idfile);
//         echo '-';
//     }

//     $updates = getApiUpdate($update_id);
// 	if ((!empty($updates)) and ($debug) )  {
//         echo "\r\n===== isi diterima \r\n";
//         print_r($updates);
//     }
	
//     foreach ($updates as $message) {
//         $update_id = prosesApiMessage($message);
//         echo '+';
//     }
//     file_put_contents($idfile, $update_id + 1);
// }

?>