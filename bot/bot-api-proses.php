<?php

$home = array(
	array("Lapor","Informasi","Pertanyaan")
);

$info = array(
	array("Radikalisme","Hoax","Terorisme")
);
$lapor = array(
	array("Pra Terorisme","Terorisme","Pasca Terorisme")
);
$yesno = array(
	array("Ya","Tidak")
);

$yesno2 = array(
	array("Membantu","Tidak membantu")
);



//fungsi yang dipanggil pertama kali bot dirunning
function prosesApiMessage($sumber){
	//if ($GLOBALS['debug']) mypre($sumber);
    if (isset($sumber['message'])){
        $message = $sumber['message'];		
		if ($GLOBALS['debug']) mypre($message);
		
        if (isset($message['text'])) {
			prosesPesanTeks($message);
        } elseif(isset($message['sticker'])) {
            prosesPesanSticker($message);
        } elseif(isset($message['photo'])) {
            prosesPesanPhoto($message);
        }
		elseif(isset($message['document'])) {
            prosesPesanDocument($message);
        }
		elseif(isset($message['location'])) {
            prosesPesanLocation($message);
        }
		elseif(isset($message['contact'])) {
            prosesPesanContact($message);
        }
    }
    if(isset($sumber['callback_query'])){
        prosesCallAnswer($sumber['callback_query']);
		//prosesCallBackQuery($sumber['callback_query']);
    }
	$updateid = $sumber['update_id'];
    return $updateid;
}

function prosesCallBackQuery($message){
	$innew = array(
			array(array('text' => 'Not Found', 'callback_data' => 'None')),
		);
    $message_id = $message['message']['message_id'];
    $chatid = $message['message']['chat']['id'];
	$inlinetext = $message['message']['text'];
    $data = $message['data'];
	$text = $message_id. ": ".$data;
	editMessageKeyboard($chatid, $message_id,'h', $innew, true);
}

function prosesCallAnswer($message){
    $message_id = $message['message']['message_id'];
    $chatid = $message['message']['chat']['id'];
	$inlinetext = $message['message']['text'];
    $data = $message['data'];	//S30:A/S41:B
    sendApiMsg($chatid, $data, $message_id, 'HTML');
    $messageupdate = $message['message'];
    $messageupdate['text'] = $data;
    prosesPesanTeks($messageupdate);
}

function prosesPesanLocation($message){
	global $mainkeyboard;
	$chatid = $message['chat']['id'];
	
	if(isset($message['venue'])){
		$name = $message['venue']['title'];
		$lat = $message['venue']['location']['latitude'];
		$lng = $message['venue']['location']['longitude'];
	}
	else {
		$lat = $message['location']['latitude'];
		$lng = $message['location']['longitude'];
	}
	
	$text = "You are in: Lat ".$lat. ", Lng: ".$lng;
	sendApiMsg($chatid, $text);
	sendApiKeyboard($chatid,$mainkeyboard,false,"Main menu");
}

function prosesPesanContact($message){
	$chatid = $message['chat']['id'];
	$phone_number = $message['contact']['phone_number'];
}

function prosesPesanDocument($message){
	$chatid = $message['chat']['id'];
	$doctype = $message['document']['mime_type'];
	$fileid = $message['document']['file_id'];
	$text = "Doc Info - Id $fileid, type: $doctype";
	sendApiMsg($chatid, $text);
}

function prosesPesanSticker($message){
	$chatid = $message['chat']['id'];
	$firstname = $message['chat']['first_name'];
	$stickername = $message['sticker']['set_name'];
	$emoji = $message['sticker']['emoji'];
	$text = "$stickername is a good sticker".$emoji;
	sendApiMsg($chatid, $text);
}

function prosesPesanPhoto($message){
	$chatid = $message['chat']['id'];
	$messageid = $message['message_id'];
	/* Get file info */
	$fileid = $message['photo'][3]['file_id'];
	$filesize = $message['photo'][3]['file_size'];
	$width = $message['photo'][3]['width'];
	$height = $message['photo'][3]['height'];
	$ukuran = getSize($filesize);
	$text = "Photo Info - id $fileid, dimension: $width x $height, file size: $ukuran";
	sendApiMsg($chatid, $text);
}

function getSize($by){
	$mb = floor($by/1000000);
	$by -= $mb * 1000000;
	$kb = floor($by/1000);
	$by -= $kb * 1000;
	return "$mb MB $kb kb $by byte";
}

function prosesPesanTeks($message)
{
    $pesan = $message['text'];
	global $chatid,$tanggal,$jam,$t1,$h1,$t2,$h2,$t3;

	$chatid = $message['chat']['id'];
    $fromid = $message['from']['id'];
    $messageid = $message['message_id'];
	sendApiAction($chatid);
	$errmsg = "Under construction";
	global $mainkeyboard;
	global $home;
	global $yesno;
	global $yesno2;
	global $lapor;
	global $info;
	global $token;
	
	$baseu = "http://edutamamedia.com/edutamamedia.com/botxx/files";
    switch (true) {
		case $pesan == '/start' || $pesan == 'Home':
			$text = "Halo Salam Damai ! ini adalah versi beta (belum publish) dari layanan informasi virtual anu.dutadamai.id. layanan ini adalah bot (robot) yang bisa merespon laporan, kritik dan saran anda lebih cepat layaknya berkomunikasi dengan asisten di dunia nyata. Kami membutuhkan masukan rekan- rekan semua demi baiknya sistem kami! Hubungi kami di https://t.me/Nadzir14 ";
			$text2 = "Tindakan Apa yang anda ingin lakukan ?";
			sendApiKeyboard($fromid,$home,false,$text);
			sendApiKeyboard($fromid,$home,false,$text2);
		break;
		case $pesan == 'Lapor':
			$text = "Jenis laporan yang anda ajukan ?";
			sendApiKeyboard($chatid,$lapor,false,$text);
		break;
		case $pesan == 'Pra Terorisme':
			sendApiMsg($chatid, " Beri tahu kami apa yang anda ingin laporkan !");
		break;
		case $pesan == 'Terorisme':
			sendApiMsg($chatid, " Beri tahu kami apa yang anda ingin laporkan !");
		break;
		case $pesan == 'Pasca Terorisme':
			sendApiMsg($chatid, " Beri tahu kami apa yang anda ingin laporkan !");
		break;
		case $pesan == 'Informasi':
			$text = "Berikut Informasi yang bisa diakses";
			sendApiKeyboard($chatid,$info,false,$text);
		break;
		case $pesan == 'Pertanyaan':
			sendApiMsg($chatid, " Apa yang ingin anda tanyakan ?");
		break;
		case $pesan == 'Radikalisme':
			$text = "Radikalisme (dari bahasa Latin radix yang berarti akar) adalah istilah yang digunakan pada akhir abad ke-18 untuk pendukung Gerakan Radikal. Dalam sejarah, gerakan yang dimulai di Britania Raya ini meminta reformasi sistem pemilihan secara radikal. Gerakan ini awalnya menyatakan dirinya sebagai partai kiri jauh yang menentang partai kanan jauh. Begitu radikalisme historis mulai terserap dalam perkembangan liberalisme politik, pada abad ke-19 makna istilah radikal di Britania Raya dan Eropa daratan berubah menjadi ideologi liberal yang progresif. Untuk informasi lebih lanjut, jangan ragu jangkau kami di https://t.me/infodamai dan https://damailahindonesiaku.com/. Akses juga konten edukatif kami di https://jalandamai.org/ dan komunitas kami di https://www.dutadamai.id/.";
			$text2 = "Apakah info ini membantu?";
			sendApiKeyboard($chatid,$yesno2,false,$text);
			sendApiKeyboard($chatid,$yesno2,false,$text2);
		break;
		case $pesan == 'Hoax':
			$text = "Hoax adalah informasi yang sesungguhnya tidak benar, tetapi dibuat seolah-olah benar adanya (MacDougall, Curtis D, 1958). Untuk informasi lebih lanjut, jangan ragu jangkau kami di https://t.me/infodamai dan https://damailahindonesiaku.com/. Akses juga konten edukatif kami di https://jalandamai.org/ dan komunitas kami di https://www.dutadamai.id/.";
			$text2 = "Apakah info ini membantu?";
			sendApiKeyboard($chatid,$yesno2,false,$text);
			sendApiKeyboard($chatid,$yesno2,false,$text2);
		break;
		case $pesan == 'Terorisme':
			$text = "Terorisme adalah serangan-serangan terkoordinasi yang bertujuan membangkitkan perasaan teror terhadap sekelompok masyarakat. Berbeda dengan perang, aksi terorisme tidak tunduk pada tatacara peperangan seperti waktu pelaksanaan yang selalu tiba-tiba dan target korban jiwa yang acak serta seringkali merupakan warga sipil. Untuk informasi lebih lanjut, jangan ragu jangkau kami di https://t.me/infodamai dan https://damailahindonesiaku.com/. Akses juga konten edukatif kami di https://jalandamai.org/ dan komunitas kami di https://www.dutadamai.id/.";
			$text2 = "Apakah info ini membantu?";
			sendApiKeyboard($chatid,$yesno2,false,$text);
			sendApiKeyboard($chatid,$yesno2,false,$text2);
		break;
		case $pesan == 'Ya':
			$text = "Baguslah";
			$text2 = "Jangan ragu untuk mencari informasi di sini !";
			sendApiKeyboard($chatid,$info,false,$text);
			sendApiKeyboard($chatid,$info,false,$text2);
		break;
		case $pesan == 'Tidak':
			$text = "Baiklah";
			$text2 = "Jangan ragu untuk mencari informasi di sini !";
			sendApiKeyboard($chatid,$home,false,$text);
			sendApiKeyboard($chatid,$home,false,$text2);
		break;
		case $pesan == 'Membantu':
			$text = "Terima Kasih";
			$text2 = "Apakah ada pertanyaan lagi? ";
			sendApiKeyboard($chatid,$yesno,false,$text);
			sendApiKeyboard($chatid,$yesno,false,$text2);
		break;
		case $pesan == 'Tidak membantu':
			$text = "Terima Kasih";
			$text2 = "informasi apa yang anda butuhkan? silahkan pilih salah satu di bawah atau beri tahu kami melalui form di bawah ! ";
			sendApiKeyboard($chatid,$info,false,$text);
			sendApiKeyboard($chatid,$info,false,$text2);
		break;
        default:
            sendApiMsg($chatid, " Kami sedang mempelajari informasi yang anda masukkan");
            sendApiMsg($chatid, " Beri kami masukan melalui https://t.me/Nadzir14");
			break;
	}
}

function datakirim(){
	global $listbutton,$chatid,$tanggal,$jam,$t1,$h1,$t2,$h2,$t3;
	$text = 
		"chat\_id = ".$chatid."\n".
		"Tanggal = ".$tanggal."\n".
		"Jam   = ".$jam."\n".
		"t1  = ".$t1."\n".
		"h1  = ".$h1."\n".
		"Q1  = ".getQ1($t1,$h1)."\n".
		"t2  = ".$t2."\n".
		"h2  = ".$h2."\n".
		"Q2  = ".getQ2($t2,$h2)."\n".
		"t3  = ".$t3."\n".
		"Q3  = ".getQ3($t3)."\n".
		"Q4  = ".getQ4($t1,$h1,$t2,$h2,$t3)."\n"
		;
	return $text;
}

function ambildata($tanggal=null,$jam=null)
{
	global $con;
	$sql = "select * from data where tanggal='$tanggal' && jam = '$jam'";
	$result = mysqli_query($con, $sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$text = 
		"chat\_id = ".$data['chatid']."\n".
		"Tanggal = ".$data['tanggal']."\n".
		"Jam   = ".$data['jam']."\n".
		"t1  = ".$data['t1']."\n".
		"h1  = ".$data['h1']."\n".
		"t2  = ".$data['t2']."\n".
		"h2  = ".$data['h2']."\n".
		"t3  = ".$data['t3']."\n"
		;
		return $text;
	}

}

function cek_id_user($chatid)
{
	global $con;
	$sql = "select chatid from users";
	$result = mysqli_query($con, $sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		return "";
	}else {
		return "Anda Tidak Terdaftar sebagai User Bot";
	}

}

function inserttodb(){
	global $con,$listbutton,$chatid,$tanggal,$jam,$t1,$h1,$t2,$h2,$t3;
	$sql = "INSERT INTO `data`
	(`chatid`, `tanggal`, `jam`, `t1`, `h1`, `t2`, `h2`, `t3` ) 
	VALUES ('$chatid','$tanggal','$jam','$t1','$h1','$t2','$h2','$t3')";
	$result = mysqli_query($con, $sql);
	if($result){
		$text = "Data Berhasil di Input ke Database";
		sendApiKeyboard($chatid,$listbutton,false,$text);
		if(getQ4($t1,$h1,$t2,$h2,$t3)  >= 5){
			$text = "Warning Debit terlalu tinggi, awas banjir";
			sendApiKeyboard($chatid,$listbutton,false,$text);
		}
	}
}

function insertfototodb($chatid,$fileid=null,$filesize=null,$width=null,$height=null,$ukuran=null){
	global $con,$listbutton;
	$sql = "INSERT INTO `file_info`
	( `file_id`, `file_size`, `width`, `height`) 
	VALUES ('$fileid','$filesize','$width','$height')";
	$result = mysqli_query($con, $sql);
	if($result){
		$text = "Foto Berhasil di Input ke Database";
		sendApiKeyboard($chatid,$listbutton,false,$text);
	}
}

function getfoto($chatid,$fileid=null)
{
	global $con,$token;
	$sql = "select * from file_info where no='$fileid'";
	$result = mysqli_query($con, $sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$text = $data['file_id'];
		sendApiPhoto($chatid,$text);
	}

}

function sendMessage($chatid, $pesan, $token,$status) {
	if($status == 'msg'){
		$method	= "sendMessage";
		$url    = "https://api.telegram.org/bot" . $token . "/". $method;
		$post = [
		'chat_id' => $chatid,
		'text' => $pesan
		];
	}elseif ($status == 'foto') {
		$method	= "sendphoto";
		$url    = "https://api.telegram.org/bot" . $token . "/". $method;
		$post = [
		'chat_id' => $chatid,
		'photo' => $pesan
		];
	}

	$header = [
	"X-Requested-With: XMLHttpRequest",
	"User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36" 
	];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post );   
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$datas = curl_exec($ch);
	$error = curl_error($ch);
	$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	$debug['text'] = $pesan;
	$debug['code'] = $status;
	$debug['status'] = $error;
	$debug['respon'] = json_decode($datas, true);

	print_r($debug);
}