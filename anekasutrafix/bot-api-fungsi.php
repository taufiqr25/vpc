<?php

$idfoto;
function myPre($value)
{
    print_r($value);
}

function apiRequest($method, $data){
    if (!is_string($method)) {
        error_log("Nama method harus bertipe string!\n");
        return false;
    }

    if (!$data) {
        $data = array();
    } elseif (!is_array($data)) {
        error_log("Data harus bertipe array\n");
        return false;
    }

    $url = 'https://api.telegram.org/bot'.$GLOBALS['token'].'/'.$method;

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context = stream_context_create($options);

    $result = file_get_contents($url, false, $context);   
	return $result;
}

function curl_get($url){
	if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'X-API-KEY: cda0ab4415e9156218390f36f5b90526'));
	$result=curl_exec($ch);
	curl_close($ch);
	return json_decode($result,true);
}

function curl_post($url,$uid,$password){
	if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'X-API-KEY: cda0ab4415e9156218390f36f5b90526'));
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('uid'=> $uid, 'password'=> $password)));
	$result=curl_exec($ch);
	curl_close($ch);
	return json_decode($result,true);
}

//long poll
function getApiUpdate($offset){
    $method = 'getUpdates';
    $data['offset'] = $offset;

    $result = apiRequest($method, $data);

    $result = json_decode($result, true);
    if ($result['ok'] == 1) {
        return $result['result'];
    }

    return array();
}

function deleteApiMsg($chatid, $messageid){
	// sendApiMsg($chatid,"Message only");
	$method = 'deleteMessage';
	$data = array('chat_id' => $chatid, 'message_id'  => $messageid);
	$result = apiRequest($method, $data);
}

function sendApiMsg($chatid, $text, $msg_reply_id = false, $parse_mode = false, $disablepreview = false){
    $method = 'sendMessage';
    $data = array('chat_id' => $chatid, 'text'  => $text);

    if ($msg_reply_id) {
        $data['reply_to_message_id'] = $msg_reply_id;
    }
    if ($parse_mode) {
        $data['parse_mode'] = $parse_mode;
    }
    if ($disablepreview) {
        $data['disable_web_page_preview'] = $disablepreview;
    }
	
	/* ke database  *
	$chatid = $chatid; 
	$command = $text;
	require_once("concon.php");
	$sql = "insert into temp values(null,now(),'$chatid','$command')";
	mysql_query($sql);
	/**/
	
	//ke API TELEGRAM
	$result = apiRequest($method, $data);
	//ke cmd
	if ($GLOBALS['debug']){
		echo "\r\n===== ApiMsg dikirim \r\n";
		mypre($result);
	}
}

function sendApiAction($chatid, $action = 'typing'){
    $method = 'sendChatAction';
    $data = array(
        'chat_id' => $chatid,
        'action'  => $action,
    );
    $result = apiRequest($method, $data);
	if ($GLOBALS['debug']){
		echo "\r\n===== Api Action dikirim \r\n";
		mypre($result);
	}
}

function sendApiKeyboard($chatid,$keyboard = array(), $inline = false, $text){
	$method = 'sendMessage';
    $replyMarkup = array(
        'keyboard'        => $keyboard,
        'resize_keyboard' => true,	//smaller keyboard
		//'one_time_keyboard' => true, //dismiss keyboard after used
		//'selective' => true, //personal chat
    );
	
	$data = array('chat_id' => $chatid,'text' => $text,'parse_mode' => 'Markdown');

    $inline ? $data['reply_markup'] = json_encode(array('inline_keyboard' => $keyboard)) : $data['reply_markup'] = json_encode($replyMarkup);
	
	print_r($data);
    $result = apiRequest($method, $data);
	if ($GLOBALS['debug']){
		echo "\r\n===== Api keyboard dikirim \r\n";
		mypre($result);
	}
}


function editMessageKeyboard($chatid, $message_id, $text, $keyboard = array(), $inline = false){
    $method = 'editMessageText';
    $replyMarkup = array(
        'keyboard'        => $keyboard,
        'resize_keyboard' => true,
    );

    $data = array(
        'chat_id'    => $chatid,
        'message_id' => $message_id,
        'text'       => $text,
        'parse_mode' => 'Markdown',
    );

    $inline ? $data['reply_markup'] = json_encode(array('inline_keyboard' => $keyboard)) : $data['reply_markup'] = json_encode($replyMarkup);

    $result = apiRequest($method, $data);
	if ($GLOBALS['debug']){
		echo "\r\n===== Edit Message Text dikirim \r\n";
		mypre($result);
	}
}

function editMessageText($chatid, $message_id, $text){
    $method = 'editMessageText';
    $data = array(
        'chat_id'    => $chatid,
        'message_id' => $message_id,
        'text'       => $text,
        'parse_mode' => 'Markdown',
    );

    $result = apiRequest($method, $data);
	if ($GLOBALS['debug']){
		echo "\r\n===== Edit Message Text dikirim \r\n";
		mypre($result);
	}
}

function sendApiHideKeyboard($chatid, $text){
    $method = 'sendMessage';
    $data = array(
        'chat_id'       => $chatid,
        'text'          => $text,
        'parse_mode'    => 'Markdown',
        'reply_markup'  => json_encode(array('hide_keyboard' => true)),
    );

    $result = apiRequest($method, $data);
	if ($GLOBALS['debug']){
		echo "\r\n===== Hide keyboard dikirim \r\n";
		mypre($result);
	}
}

function sendApiSticker($chatid, $sticker, $msg_reply_id = false){
    $method = 'sendSticker';
    $data = array(
        'chat_id'  => $chatid,
        'sticker'  => $sticker,
    );

    if ($msg_reply_id) {
        $data['reply_to_message_id'] = $msg_reply_id;
    }

    $result = apiRequest($method, $data);
	if ($GLOBALS['debug']){
		echo "\r\n===== Api Sticker dikirim \r\n";
		mypre($result);
	}
}

function sendApiAudio($chatid, $fileinfo, $msg_reply_id = false, $parse_mode = false, $disablepreview = false){
    $method = 'sendAudio';
	//$file_id = "BQADBAADpp0AAqYbZAcbQ3PW_bV35gI";
	$data = array('chat_id' => $chatid, "title" => "Title","performer"=> "Artist", 'audio'  => $fileinfo);
	//ke API TELEGRAM
	//print_r($data);
	$result = apiRequest($method, $data);
	//ke cmd
	if ($GLOBALS['debug']){
		echo "\r\n===== ApiMsg dikirim \r\n";
		mypre($result);
	}
}

function sendApiPhotoInfo($chatid, $fileinfo, $caption){
  $method = 'sendPhoto';
  $data = array('chat_id' => $chatid, 'photo'  => $fileinfo, 'caption'=>$caption);
  
  $result = apiRequest($method,$data);
  if ($GLOBALS['debug']){
    echo "\r\n===== ApiMsg dikirim \r\n";
    mypre($result);
  }
  
}

function sendApiPhoto($chatid, $fileinfo, $caption, $keyboard){
  $method = 'sendPhoto';
  $replyMarkup = array(
        'keyboard'        => $keyboard,
        'resize_keyboard' => true,  //smaller keyboard
    //'one_time_keyboard' => true, //dismiss keyboard after used
    //'selective' => true, //personal chat
    );
  
  $data = array('chat_id' => $chatid, 'photo'  => $fileinfo, 'caption'=>$caption);
  $data['reply_markup'] = json_encode(array('inline_keyboard' => $keyboard));
  
  $result = apiRequest($method,$data);
  if ($GLOBALS['debug']){
    echo "\r\n===== ApiMsg dikirim \r\n";
    mypre($result);
  }
  
}

function sendOngkirProvinsi() {

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "key: 24349f0a5dbad51077a33f697a8db3b6"
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
    return $response;

}

function sendOngkirKota($prov) {

$prov;

$curl = curl_init();
curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=$prov",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "key: 24349f0a5dbad51077a33f697a8db3b6"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    return $response;

}

function cekongkos($asal,$id_kabupaten,$kurir,$berat){

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "origin=".$asal."&destination=".$id_kabupaten."&weight=".$berat."&courier=".$kurir."",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "key: 24349f0a5dbad51077a33f697a8db3b6"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      return $response;
    }

}

function sendInvoice($chatid, $title, $description, $payload, $providertoken, $parameter, $currency, $prices, $photo)
{
    $method = 'sendinvoice';
   

    $data = array('chat_id' => $chatid, 'title' => $title, 'description' => $description, 'payload' => $payload, 'provider_token' => $providertoken, 'start_parameter' => $parameter, 'currency' => $currency, 'prices' => $prices, 'photo_url' => $photo);
    // $data['reply_markup'] = json_encode(array('inline_keyboard' => $keyboard));
  
  $result = apiRequest($method,$data);
  if ($GLOBALS['debug']){
    echo "\r\n===== ApiMsg dikirim \r\n";
    mypre($result);
    print_r($data);
  }
  print_r($data);

}

  function sendApiPhoto2($chatid, $fileinfo, $caption){
    global $idfoto;
    $method = 'sendPhoto';
    
    $data = array('chat_id' => $chatid, 'photo'  => $fileinfo, 'caption' => $caption);
    
    print_r($data);
    $result = apiRequest($method,$data);
    $result = json_decode($result);
    $idfoto = $result->result->photo[3]->file_path;
    print_r("\n\n\n\n".$idfoto."");
    // print_r("\n\n");
    // $resultdecode = json_decode($result);
    // $result_encode = json_encode($result);
    // print_r("\n\n\n");
    // print_r($result_encode);
    if ($GLOBALS['debug']){
      echo "\r\n===== ApiMsg dikirim \r\n";
      print_r("berhasil");
      mypre($result);
    }
    
  }

   function getFile($fileid){
    global $idfoto;
    $method = 'getFile';
    
    $data = array('file_id' => $fileid);
    
    print_r($data);
    $result = apiRequest($method,$data);
    $result = json_decode($result);
    $idfoto = $result->result->file_path;
    print_r("\n\n\n\n".$idfoto."");
    // print_r("\n\n");
    // $resultdecode = json_decode($result);
    // $result_encode = json_encode($result);
    // print_r("\n\n\n");
    // print_r($result_encode);
    if ($GLOBALS['debug']){
      echo "\r\n===== ApiMsg dikirim \r\n";
      print_r("berhasil");
      mypre($result);
    }
    
  }