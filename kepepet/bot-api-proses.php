<?php

require_once 'bot-api-config.php';
require_once 'bot-api-fungsi.php';
require_once 'database.php';
require_once 'bot-api-proses.php';

$tabel = array("R"=>"Produk","P"=>"Pakaian","A"=>"Aksesoris","B"=>"Bantuan","K"=>"Keranjang","PP"=>"Pemilihan Produk","PA"=>"Pemilihan ATM");

$mainkeyboard = array(
		array("Produk","Konfirmasi Pesanan"),
		array('Status Pemesanan','Informasi'),
);

$next = array(
		array("Next"),
);

$jenis = array(
		array('Produk-Pakaian','Produk-Aksesoris'),
		array('🔙 Main Menu'),
);

$kodepp = array(
		array('PP'),
);

$alamatlengkap = array(
		array("Alamat Lengkap"),
);

$provinsi =  array(
		array("🤛Kembali","Provinsi"),
);

$kabupaten =  array(
		array('Provinsi','Kabupaten'),
);

$mainmenu = array(
		array('🔙 Main Menu'),
);

$next2 = array(
		array('👈Back','Next👉'),
);
$back = array(
		array('Back'),
);
$lanjutkan = array(
		array("Lanjutkan"),
);

$lanjutkan2 = array(
		array('👈Kembali','Lanjutkan👉'),
);


$batalkan = array(
		array('Batalkan'),
);


$kembalijumlah = array(
		array('Kembali','Batalkan'),
);

$kembalinama = array(
		array('👈Kembali','🔴Batalkan'),
);

$kembalialamat = array(
		array('🔙Kembali','🔚Batalkan'),
);



$idfoto;
$token;

//fungsi yang dipanggil pertama kali bot dirunning
function prosesApiMessage($sumber){
	//if ($GLOBALS['debug']) mypre($sumber);
	global $idproduk2,$total,$jumlahbrngkredit,$prov,$alamatkredit,$kabup,$namakredit,$mainmenu;
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
      	elseif(isset($message['successful_payment'])) {
        prosesPesanSuccessfulPayment($message);
        	$chatid = $message['chat']['id'];
        	$idorder = rand(1,99999999);
			$idkonsumen = rand(1,99999);

			$sql_get_variabel = "select * from variabel where var_id=$chatid";
			$data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
			$alamat = $data_variabel['alamat'];
			$idproduk2 = $data_variabel['idproduk'];
			$nama = $data_variabel['nama'];
			$jumlahpesanan = $data_variabel['jumlahpesanan'];
			$total = $data_variabel['total'];
			$prov = $data_variabel['namaprov'];
			$kabup = $data_variabel['namakabup'];
			$nohp = $data_variabel['nohp'];
			$messageidkab = $data_variabel['messageidkab'];
			$messageidprov = $data_variabel['messageidprov'];
			$messageidpesanann = $data_variabel['messageidpesanan'];

			$sql = "INSERT INTO `order`(`id_order`, `id_produk`, `id_konsumen`, `id_bank`,`status_pemesanan`,`no_resi`) VALUES ($idorder,$idproduk2,$idkonsumen,Null,'Belum Dikonfirmasi',Null)";
			$result = mysql_query($sql);
			print_r("\n\n".$sql."");
			$sql2 = "INSERT INTO `detail_order`(`id_produk`,`id_order`,`kuantitas`,`total`) VALUES ($idproduk2,$idorder,$jumlahpesanan,$total)";
			$result2 = mysql_query($sql2);
			print_r("\n\n".$sql2."");
			$sql3 = "INSERT INTO `konsumen`(`id_konsumen`, `id_order`, `nama_konsumen`, `alamat_konsumen`, `provinsi`, `kabupaten`, `nomor_rekening_konsumen`, `id_telegram`,`no_hp`) VALUES ($idkonsumen,$idorder,'$nama','$alamat','$prov','$kabup',Null,'$chatid','$nohp')";
			$result3 = mysql_query($sql3);
			print_r("\n\n".$sql3."");
			$sql4 = "INSERT INTO `membayar`(`id_pembayaran`, `id_bank`, `id_order`, `status`, `gambar_bukti`) VALUES ('Null','Null',$idorder,1,'https://fiqri.tatkj.poliupg.ac.id/webtoko/gambar/lunas.png')";
			$result4 = mysql_query($sql4);

			$sql5 = "UPDATE `produk` SET `jumlah`= jumlah - $jumlahpesanan WHERE id_produk=$idproduk2";
			$result5 = mysql_query($sql5);



			$sql6 = "DELETE FROM `variabel` WHERE var_id=$chatid";
			mysql_query($sql6);

			$sql7 = "DELETE FROM `status` WHERE id=$chatid";
			mysql_query($sql7);

			$text = "Terima Kasih Atas Pesanan Anda\nNomor Transaksi Anda Adalah ".$idorder."\nSilahkan mengecek pada Menu Status Pemesanan pada 🔙 Main Menu\nPesanan akan segera kami proses";
			sendApiKeyboard($chatid,$mainmenu,false,$text);
			deleteApiMsg($chatid,$messageidkab);
			deleteApiMsg($chatid,$messageidprov);
			deleteApiMsg($chatid,$messageidpesanann);
	        }
    }
    if(isset($sumber['callback_query'])){
        prosesCallAnswer($sumber['callback_query']);
		//prosesCallBackQuery($sumber['callback_query']);
    }
     elseif(isset($sumber['pre_checkout_query'])){
	prosesAnswerCheckout($sumber['pre_checkout_query']);
	
		
	

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
    //sendApiMsg($chatid, $text);
	editMessageKeyboard($chatid, $message_id,'h', $innew, true);
    //$messageupdate = $message['message'];
    //$messageupdate['text'] = $data;
    //prosesPesanTeks($messageupdate);
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
	global $idfoto,$rekeningtuj,$idorderkonfirmasi,$token;
	print_r("ini id foto".$fileid);

	if(!empty($fileid))
	{
		$sql_get_variabel = "select * from variabel where var_id=$chatid";
		$data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
		$rekeningtuj = $data_variabel['rekeningtuj'];
		$idorderkonfirmasi = $data_variabel['idkonf'];
		$text2 = "Terima kasih telah melakukan konfirmasi pesanan\nPesanan anda akan segera kami proses setelah admin mengecek konfirmasi anda\nUntuk mengecek status pemesanan silahkan memilih menu Status Pemesanan";
		getFile($fileid);
		$imgurl = 'https://api.telegram.org/file/bot457702324:AAHA8Ddo1VTSOEMpzItTgkGcjJ5sr6TjeDw/'.$idfoto.'';
		$nomor = rand(1,999);
		$namatambahan = "".$idfoto."+".$chatid."".$nomor."";  
        $namatambahanfix = md5($namatambahan);
        $namatambahanfix2 = "".$namatambahanfix.".jpg"; 
		$imagename= basename($imgurl);
		$image = file_get_contents($imgurl); 
		file_put_contents('gambar_bukti/'.$namatambahanfix2,$image);

		$idfotofix = 'https://fiqri.tatkj.poliupg.ac.id/anekasutrafix/gambar_bukti/'.$namatambahanfix2.'';

				// $idfotofix = "https://api.telegram.org/file/bot".$token."/".$idfoto;
		print_r("\n\n".$idfotofix."");
		
		 $sql = "SELECT `id_bank` FROM `rekening_tujuan` WHERE nomor_rekening = $rekeningtuj";
		$result = mysql_query($sql);
		print_r($sql);
		$data = mysql_fetch_assoc($result);
		$idbankatm = $data['id_bank'];
		print_r("\n\n".$idbankatm."");
		$sql1 = "INSERT INTO `membayar`(`id_pembayaran`, `id_bank`, `id_order`, `status`, `gambar_bukti`) VALUES ('Null',$idbankatm,$idorderkonfirmasi,Null,'$idfotofix')";
		$result1 = mysql_query($sql1);
		print_r($sql1);
		$sql2 = "UPDATE `order` SET id_bank = $idbankatm WHERE id_order = $idorderkonfirmasi";
		$result2 = mysql_query($sql2);
		if(!empty($result and $result1 and $result2))
			{
				$sql5 = "DELETE FROM `variabel` WHERE var_id=$chatid";
				mysql_query($sql5);

				$sql7 = "DELETE FROM `status` WHERE id=$chatid";
				mysql_query($sql7);
			}
		print_r($sql2);
		sendApiMsg($chatid,$text2);
	}
	
	elseif(empty($fileid))
	{
		$text2 = "Pengiriman foto gagal,silahkan menngirim ulang";
		sendApiMsg($chatid,$text2);
	}



}

function prosesAnswerCheckout($sumber){
	$method = 'answerPreCheckoutQuery';
	$id = $sumber['id'];
	// $from2 = $sumber['from']['id'];

	$postfields = array(
	'pre_checkout_query_id' => $id,
	'ok' => true,
	);
	$result = apiRequest($method, $postfields);
    if (isset($GLOBALS['debug'])){
        mypre($result);
	}
	return $result;
	print_r($result);
	
	// print_r($sumber);
	// print_r($postfields);
	// return $postfields;

}
function prosesPesanSuccessfulPayment($message){
	$chatid = $message['chat']['id'];
	$currency = $message['successful_payment']['currency'];
	$total_amount = $message['successful_payment']['total_amount'];
	$invoice_payload = $message['successful_payment']['invoice_payload'];
	// $order_info = $message['successfulpayment']['order_info'];
	$telegram_payment_charge_id = $message['successful_payment']['telegram_payment_charge_id'];
	$provider_payment_charge_id = $message['successful_payment']['provider_payment_charge_id'];
	// $text = "Mata uang = ".$currency."\ntotal harga = ".$total_amount."\npayload= ".$invoice_payload."\ntelegramcharge= ".$telegram_payment_charge_id."\nprovide= ".$provider_payment_charge_id;
	print_r($message);
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
    //if ($GLOBALS['debug']) mypre($message);
	//require_once("concon.php");
	$status;
    $pesan = $message['text'];
    $chatid = $message['chat']['id'];
    $fromid = $message['from']['id'];
    $messageid = $message['message_id'];
	sendApiAction($chatid);
	$errmsg = "Under construction";
	global $mainkeyboard,$tabel,$mainmenu,$next,$jenis,$kodepp,$alamatlengkap,$provinsi,$kabupaten,$next2,$back,$lanjutkan,$lanjutkan2,$kembali,$batalkan;
	global $id,$idproduk2;
	global $jumlahbrngkredit,$namakredit,$ongkirkredit,$alamatkredit;
	global $jumlahbrngatm,$namaatm,$ongkiratm,$alamatatm;
	global $gambar,$nmproduk,$deskripsi,$hargapr,$hargabarang;
	global $prov,$kabup;
	global $total;
	global $idorderkonfirmasi,$rekeningtuj,$nomorrekening,$idbank;
	global $kembalijumlah,$kembalinama,$kembalialamat;
	
    switch (true) {
    	case $pesan == '/start':
			$text = "Selamat Datang di Toko Aneka Sutra!";
			$text2 = "Pilih Menu Untuk Melanjutkan 👇🏻\n\nJika kurang jelas,silahkan tekan tombol Bantuan untuk membaca petunjuk penggunaan aplikasi ini";
			sendApiKeyboard($chatid,$mainkeyboard,false,$text);
			sendApiMsg($chatid,$text2);
		break;

		case $pesan == '🔙 Main Menu':
			$text = "Pilih Menu Untuk Melanjutkan 👇🏻\n\nJika kurang jelas,silahkan tekan tombol Bantuan untuk membaca petunjuk penggunaan aplikasi ini";
			sendApiKeyboard($chatid,$mainkeyboard,false,$text);
			print_r($id);

		break;	

		case $pesan == 'Informasi':
			$sumber = "http://i63.tinypic.com/28veurm.jpg";
			$text = "Selamat Datang di Toko Aneka Sutra!";
			$caption = "Toko Aneka Sutera merupakan salah satu toko yang berada di Makassar dan menyediakan produk-produk tradisional khas Sulawesi Selatan.";
			$caption2 = "Produk-produk toko aneka sutra antara lain Songkok bone, Kain sutra, Aksesoris-aksesoris yang terbuat dari kain sutra dan masih banyak lainnya.";
			sendApiPhotoInfo($chatid,$sumber,$caption);
			sendApiMsg($chatid,$caption2);
		break;

		case $pesan == 'Produk':
			$text = "Silahkan Pilih Jenis Produk Yang Ingin Dibeli💵";
			sendApiKeyboard($chatid,$jenis,false,$text);
		break;

		case $pesan == 'Status Pemesanan':
			$text = "Masukkan Kode Pemesanan 👇";
			$sql = "INSERT INTO status (`id`,`status`) VALUES ('$chatid','9')";
			mysql_query($sql);
			sendApiKeyboard($chatid,$mainmenu,false,$text);
		break;

		case $pesan == '🔙 Kembali ke Menu Utama':
			sendApiKeyboard($chatid,$mainkeyboard,false,$text);
		break;

		case preg_match("/^Produk-(.*)/", $pesan, $hasil):
			$kodesc = $hasil[1];
			print_r("\n\n\n\n\ ini adalah ".$kodesc);
			$text = "Silahkan Pilih Produk Yang Ingin Dibeli";
			$text2 = "Produk-produknya yaitu :";
			$inpilihan = cekpilihan("Anda Memilih Produk ",$kodesc);
			print($inpilihan);
			sendApiKeyboard($chatid, $inpilihan, true, $text2);
			print_r($id);
		break;
		
		case preg_match("/Anda Memilih Produk (.*)/", $pesan, $hasil):
			$namaproduk = $hasil[1];
			$iduser = $fromid;
			print_r($id);
			$inpilihangambar = ambilgambar($namaproduk);
			$source = $inpilihangambar;
			$inpilihannamaproduk = ambilnamabarang($namaproduk);
			$nmproduk = $inpilihannamaproduk;
			$inpilihanharga = ambilhargabarang($namaproduk);
			$hargapr = $inpilihanharga;
			$inpilihandeskripsi = ambildeskripsibarang($namaproduk);
			print_r($inpilihandeskripsi);
			$deskripsi = $inpilihandeskripsi;
			$sql_get_status = "select * from variabel where var_id='$chatid'";
			$data_status = mysql_fetch_assoc(mysql_query($sql_get_status));
			$var_id = $data_status['var_id'];
			if(empty($var_id))
			{
				$sql = "INSERT INTO variabel (`var_id`, `nmproduk`,`hargabarang`,`gambar`,`deskripsi`) VALUES ('$chatid','$nmproduk',$hargapr,'$source','$deskripsi')";
	   			mysql_query($sql); 
			}
			elseif(!empty($var_id))
			{
				$sql1 = "update variabel set nmproduk='$nmproduk',hargabarang=$hargapr,gambar='$source' where var_id=$chatid";
				mysql_query($sql1); 
			}

			
			$text2 = "Nama Produk = " .$inpilihannamaproduk."\nDeskripsi Produk = ".$inpilihandeskripsi."\n Harga Produk = ".$inpilihanharga. "";

			$buykey = 
			array(
	        	array(
		          	array('text' => 'Pesan', 'callback_data' => 'Anda Memesan '.$namaproduk),
		          	array('text' => 'Tidak', 'callback_data' => 'tidak')
          		),
        	);
			sendApiPhoto($chatid,$source,$text2,$buykey);
        break;

        case preg_match("/^Anda Memesan (.*)/", $pesan, $hasil2):
            $namaproduk = $hasil2[1];
             $sql_get_status = "select * from status where id='$chatid'";
			$data_status = mysql_fetch_assoc(mysql_query($sql_get_status));
			$idchat = $data_status['id'];
			if(empty($idchat))
			{
	            $sql = "INSERT INTO `status`(`id`,`status`) VALUES ('$chatid','1')";
				mysql_query($sql);  
			}
			elseif(!empty($idchat))
			{
				 $sql3 = "update status set status='1' where id='$chatid'";
				 mysql_query($sql3); 
			}
            $idproduk2 = ambilid($namaproduk);
            $sql1 = "update `variabel` set idproduk=$idproduk2 where var_id=$chatid";
            mysql_query($sql1);  
            $sql_get_variabel = "select * from variabel where var_id='$chatid'";
			$data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
			$var_id = $data_variabel['var_id'];
			if(!empty($var_id))
			{
				$sql2 = "update variabel set idproduk=$idproduk2 where var_id=$var_id";
				mysql_query($sql2);  
			}
            $text = "Masukkan jumlah barang yang ingin dipesan 👇";
            sendApiKeyboard($chatid,$batalkan,false,$text);
            
        break;

        case $pesan == 'tidak':
        	$text = "Silahkan kembali memilih jenis barang 👇";

        	sendApiKeyboard($chatid,$jenis,false,$text);
        	deleteApiMsg($chatid,$messageid);

        break;

        case $pesan == 'Kembali':
        	$sql = "update status set status='1' where id='$chatid'";
			mysql_query($sql); 
        	$text = "Masukkan jumlah barang yang ingin dipesan 👇";
            sendApiKeyboard($chatid,$batalkan,false,$text);    	
        break;

         case $pesan == 'Batalkan':
         	$text = "Silahkan Pilih Kembali Jenis Produk Yang Ingin Dibeli💵";
			sendApiKeyboard($chatid,$jenis,false,$text);
        break;

        case $pesan == '🔴Batalkan':
         	$text = "Silahkan Pilih Kembali Jenis Produk Yang Ingin Dibeli💵";
			sendApiKeyboard($chatid,$jenis,false,$text);
        break;

        case $pesan == '🔚Batalkan':
         	$text = "Silahkan Pilih Kembali Jenis Produk Yang Ingin Dibeli💵";
			sendApiKeyboard($chatid,$jenis,false,$text);
        break;

        case $pesan == '👈Kembali':
        	$sql = "update status set status='2' where id='$chatid'";
			mysql_query($sql); 
        	$text = "Masukkan Nama Pembeli 👇";
            sendApiKeyboard($chatid,$kembalijumlah,false,$text);    	
        break;

        case $pesan == '🔙Kembali':
         	$sql = "update status set status='3' where id='$chatid'";
			mysql_query($sql); 
        	$text = "Masukkan Alamat Pembeli 👇";
            sendApiKeyboard($chatid,$kembalinama,false,$text); 
        break;

        case $pesan == '🤛Kembali':
         	$sql = "update status set status='8' where id='$chatid'";
			mysql_query($sql); 
        	$text = "Masukkan Nomor Handphone 👇";
            sendApiKeyboard($chatid,$kembalialamat,false,$text); 
        break;

       

        case $pesan == 'Provinsi':
	   		$a1 = json_decode(sendOngkirProvinsi());
	   		$a1  = json_encode($a1);
			$a1 = json_decode($a1, true);
			$a1 = $a1['rajaongkir']['results'];
			$arr = [];
			$i2 = 0;
			for ($i=0; $i < count($a1); $i++) { 
			$arr[$i]["text"]= $a1[$i2]['province'];
	       $arr[$i]["callback_data"]= "Pr".$a1[$i2]['province_id'];
	        $i2++;
			}

			$inpilihan = array();
			$ia = 0;
			foreach ($arr as $key1) {
				foreach ($key1 as $key2 => $value2) {
					 $inpilihan[$ia][0][$key2] = $value2;
					 $inpilihan[$ia][0][$key2] = $value2;
				}
				if($ia==10)
				{
					break;
				}

			$ia++;
			}
			$text7 = "Pilih Provinsi Penerima";
			$text8 = "Tekan Next untuk memilih provinsi yang lainnya\nHarap tunggu setelah memilih";
			print_r($inpilihan);

	    	// print_r($inpilihan);
	    	sendApiKeyboard($chatid,$inpilihan,true,$text7);
	    	sendApiKeyboard($chatid,$next,false,$text8);
    	break;

    	case $pesan == 'Next':
	   		$a1 = json_decode(sendOngkirProvinsi());
	   		$a1  = json_encode($a1);
			$a1 = json_decode($a1, true);
			$a1 = $a1['rajaongkir']['results'];
			$arr = [];
			$i2 = 11;
			for ($i=0; $i < 10; $i++) { 
			$arr[$i]["text"]= $a1[$i2]['province'];
	       $arr[$i]["callback_data"]= "Pr".$a1[$i2]['province_id'];
	        $i2++;
			}

			$inpilihan = array();
			$ia = 0;
			foreach ($arr as $key1) {
				foreach ($key1 as $key2 => $value2) {
					 $inpilihan[$ia][0][$key2] = $value2;
					 $inpilihan[$ia][0][$key2] = $value2;
				}
			$ia++;
			}
			$inpilihan = array_values($inpilihan);
			$text7 = "Pilih Provinsi Penerima";
			$text8 = "Tekan Next untuk memilih provinsi yang lainnya\nHarap tunggu setelah memilih";
			print_r($inpilihan);

	    	// print_r($inpilihan);
	    	sendApiKeyboard($chatid,$inpilihan,true,$text7);
	    	sendApiKeyboard($chatid,$next2,false,$text8);
    	break;

    	case $pesan == '👈Back':
	   		$a1 = json_decode(sendOngkirProvinsi());
	   		$a1  = json_encode($a1);
			$a1 = json_decode($a1, true);
			$a1 = $a1['rajaongkir']['results'];
			$arr = [];
			$i2 = 0;
			for ($i=0; $i < count($a1); $i++) { 
			$arr[$i]["text"]= $a1[$i2]['province'];
	       $arr[$i]["callback_data"]= "Pr".$a1[$i2]['province_id'];
	        $i2++;
			}

			$inpilihan = array();
			$ia = 0;
			foreach ($arr as $key1) {
				foreach ($key1 as $key2 => $value2) {
					 $inpilihan[$ia][0][$key2] = $value2;
					 $inpilihan[$ia][0][$key2] = $value2;
				}
				if($ia==10)
				{
					break;
				}

			$ia++;
			}
			$text7 = "Pilih Provinsi Penerima";
			$text8 = "Tekan Next untuk memilih provinsi yang lainnya\nHarap tunggu setelah memilih";
			print_r($inpilihan);

	    	// print_r($inpilihan);
	    	sendApiKeyboard($chatid,$inpilihan,true,$text7);
	    	sendApiKeyboard($chatid,$next,false,$text8);
    	break;

    	case $pesan == 'Next👉':
	   		$a1 = json_decode(sendOngkirProvinsi());
	   		$a1  = json_encode($a1);
			$a1 = json_decode($a1, true);
			$a1 = $a1['rajaongkir']['results'];
			$arr = [];
			$i2 = 22;
			for ($i=0; $i <= 11; $i++) { 
			$arr[$i]["text"]= $a1[$i2]['province'];
	       $arr[$i]["callback_data"]= "Pr".$a1[$i2]['province_id'];
	        $i2++;
			}

			$inpilihan = array();
			$ia = 0;
			foreach ($arr as $key1) {
				foreach ($key1 as $key2 => $value2) {
					 $inpilihan[$ia][0][$key2] = $value2;
					 $inpilihan[$ia][0][$key2] = $value2;
				}

			$ia++;
			}
			$inpilihan = array_values($inpilihan);
			$text7 = "Pilih Provinsi Penerima";
			$text8 = "Tekan Back untuk kembali\nHarap tunggu setelah memilih";
			print_r($inpilihan);

	    	// print_r($inpilihan);
	    	sendApiKeyboard($chatid,$inpilihan,true,$text7);
	    	sendApiKeyboard($chatid,$back,false,$text8);
    	break;

    	case $pesan == 'Back':
	   		$a1 = json_decode(sendOngkirProvinsi());
	   		$a1  = json_encode($a1);
			$a1 = json_decode($a1, true);
			$a1 = $a1['rajaongkir']['results'];
			$arr = [];
			$i2 = 11;
			for ($i=0; $i < 10; $i++) { 
			$arr[$i]["text"]= $a1[$i2]['province'];
	       $arr[$i]["callback_data"]= "Pr".$a1[$i2]['province_id'];
	        $i2++;
			}

			$inpilihan = array();
			$ia = 0;
			foreach ($arr as $key1) {
				foreach ($key1 as $key2 => $value2) {
					 $inpilihan[$ia][0][$key2] = $value2;
					 $inpilihan[$ia][0][$key2] = $value2;
				}
			$ia++;
			}
			$inpilihan = array_values($inpilihan);
			$text7 = "Pilih Provinsi Penerima";
			$text8 = "Tekan Next untuk memilih provinsi yang lainnya\nHarap tunggu setelah memilih";
			print_r($inpilihan);

	    	// print_r($inpilihan);
	    	sendApiKeyboard($chatid,$inpilihan,true,$text7);
	    	sendApiKeyboard($chatid,$next2,false,$text8);
    	break;

    	case preg_match("/^Pr(.*)/", $pesan, $hasil):
    		global $kodepro,$prov;
	    	$kodepro = $hasil[1];
	    	$a1 = json_decode(sendOngkirProvinsi());
	   		$a1  = json_encode($a1);
			$a1 = json_decode($a1, true);
			$a1 = $a1['rajaongkir']['results'][$kodepro-1]['province'];
			print_r($a1);
			$prov = $a1;
	   		$text = "Anda memilih ".$a1." sebagai Provinsi Tujuan\nSilahkan lanjutkan dengan menekan tombol Kabupaten\nJika Ingin Kembali Memilih Provinsi, Tekan Tombol Provinsi";
	   		$sql = "update variabel set idprov=$kodepro,namaprov='$prov' where var_id=$chatid";
	   		mysql_query($sql); 
	   		$output = print_r($a1, true);
			file_put_contents('file.log', $output);
			$sql = "update variabel set messageidprov='$messageid' where var_id=$chatid";
			mysql_query($sql);  
			
	        sendApiKeyboard($chatid,$kabupaten,false,$text);
	   		break;

	   	case $pesan == 'Kabupaten':
	   		global $kodepro;
	   		$sql_get_status = "select * from variabel where var_id=$chatid";
			$data_status = mysql_fetch_assoc(mysql_query($sql_get_status));
			$kodepro = $data_status['idprov'];
	   		$a1 = json_decode(sendOngkirKota($kodepro));
	   		$a1  = json_encode($a1);
			$a1 = json_decode($a1, true);
			$a1 = $a1['rajaongkir']['results'];
			print_r($a1);
			$arr = [];
			$i2 = 0;
			for ($i=0; $i < count($a1); $i++) { 
			$arr[$i]["text"]= $a1[$i2]['city_name'];
	       $arr[$i]["callback_data"]= "Kb".$a1[$i2]['city_id'];
	        $i2++;
			}

			$inpilihan = array();
			$ia = 0;
			foreach ($arr as $key1) {
				$key1a = 0;
				foreach ($key1 as $key2 => $value2) {
					 $inpilihan[$ia][0][$key2] = $value2;
					 $inpilihan[$ia][0][$key2] = $value2;
					 $key1a++;
				}
			$ia++;
			}
			$text7 = "Pilih dengan menekan kabupaten tujuan";
			print_r($arr);
	    	sendApiKeyboard($chatid,$inpilihan,true,$text7);
			break;

		case preg_match("/^Kb(.*)/", $pesan, $hasil):
			$kodekb = $hasil[1];
	    	$a1 = cekongkos(254,$kodekb,"jne",1000);
	    	$a12 = json_decode($a1);
	    	$a2 = $a12->rajaongkir->results[0]->costs[0]->cost[0]->value;
	    	print_r("\n\n\n ".$a2);
	    	$ongkir = $a2;
	    	$kabup = $a12->rajaongkir->destination_details->city_name;
	    	
			$sql_get_variabel = "select * from variabel where var_id='$chatid'";
			$data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
			$hargabarang = $data_variabel['hargabarang2'];
			$gambar = $data_variabel['gambar'];
			$nama = $data_variabel['nama'];
			$alamat = $data_variabel['alamat'];
			$prov = $data_variabel['namaprov'];
			$nmproduk = $data_variabel['nmproduk'];
			$jumlahpesanan = $data_variabel['jumlahpesanan'];
			$nohp2 = $data_variabel['nohp'];
			$messageidkab = $data_variabel['messageidkab'];
			$messageidprov = $data_variabel['messageidprov'];
			$messageidpesanann = $data_variabel['messageidpesanan'];


	    	$total = $ongkir + $hargabarang; 
	   		$text = "Detail pesanan anda:\nNama: ".$nama."\nAlamat: ".$alamat."\nNo.HP: ".$nohp2."\nKabupaten: ".$kabup."\nProduk: ".$nmproduk."\nJumlah: ".$jumlahpesanan."\nTotal Harga: ".$total.",00";
	    	$buykey = 
			array(
	        	array(
		          	array('text' => 'kartu kredit', 'callback_data' => 'kartukredit'),
		          	array('text' => 'atm', 'callback_data' => 'transfer')
          		),
        	);
	    	
        	$sql = "update variabel set idkab=$kodekb,namakabup='$kabup',total=$total,messageidkab='$messageid' where var_id=$chatid";
			mysql_query($sql); 

			"\n\n\n\n\n\n\n".print_r($a2);
			$text2 = "Pilih metode pembayaran yang akan anda gunakan";
			sendApiMsg($chatid,$text2);
			sendApiPhotoInfo($chatid,$gambar);
			sendApiKeyboard($chatid,$buykey,true,$text);
			// sendApiMsg($chatid,$messageid);

			print_r($chatid);
			// sendApiMsg($chatid,$gambar);
			// sendApiMsg($chatid,$text);
			print_r("\n\n\n".$text);
			print_r("\n\n\n".$buykey);			
		   break;

		 case $pesan == 'kartukredit':
		 		$sql_get_variabel = "select * from variabel where var_id=$chatid";
				$data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
				$hargabarang = $data_variabel['hargabarang2'];
				$gambar = $data_variabel['gambar'];
				$nmproduk = $data_variabel['nmproduk'];
				// $deskripsi = $data_variabel['deskripsi'];
				$jumlahpesanan = $data_variabel['jumlahpesanan'];
				$total = $data_variabel['total'];
		 		$total2 = $total."00";

		  		$LabeledPrice = array(array('label' => "Pesanan Anda", 'amount' => $total2));
			    $payload = 'telebot-test-invoice';
			    print_r($payload);
			    $provider = '284685063:TEST:MzcxYWYwNzllMzhh';
			    print_r($provider);
			    $parameter = 'foo';
			    print_r($parameter);
			    $currency = 'IDR';
			    $deskripsi = 'abcadsad';
			    sendInvoice($chatid,$nmproduk,$deskripsi,$payload,$provider,$parameter,$currency,json_encode($LabeledPrice),$gambar);
			    $text = "".$chatid."\n".$nmproduk."\n".$deskripsi."\n".$payload."\n".$provider."\n".$parameter."\n".$currency."\n".$LabeledPrice."\n".$gambar."";
			    $sql = "update variabel set messageidpesanan='$messageid' where var_id=$chatid";
			    sendApiMsg($chatid,$text);
			    mysql_query($sql);
		 break;

		case $pesan == 'transfer';
			$pilihanbank = pilihanbank();
			print_r($pilihanbank);
			$text = "Pilihan banknya yaitu 👇";
			$text2 = "Pilih bank yang akan menjadi tempat pembayaran Anda";
			// deleteApiMsg($chatid,$messageid);

			$sql = "update variabel set messageidpesanan='$messageid' where var_id=$chatid";
			mysql_query($sql); 
			sendApiKeyboard($chatid,$mainmenu,false,$text2);
			sendApiKeyboard($chatid,$pilihanbank,true,$text);


		break;

		case preg_match("/^Anda Memilih Bank (.*)/", $pesan, $hasil):
			$namabank = $hasil[1];
			$nomorrekening = ambilnomorekening($namabank);
			$idbank = ambilidbank($namabank);
			$namapemilik = ambilnamapemilik($namabank);
			$sql = "update variabel set idbank=$idbank where var_id=$chatid";
			mysql_query($sql);
			$sql_get_variabel = "select * from variabel where var_id=$chatid";
			$data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
			$hargabarang = $data_variabel['hargabarang2'];
			$gambar = $data_variabel['gambar'];
			$nama = $data_variabel['nama'];
			$alamat = $data_variabel['alamat'];
			$prov = $data_variabel['namaprov'];
			$nmproduk = $data_variabel['nmproduk'];
			$jumlahpesanan = $data_variabel['jumlahpesanan'];
			$total = $data_variabel['total'];
			$kabup = $data_variabel['namakabup'];
			$nohp = $data_variabel['nohp'];

			$sql = "update variabel set messageidbank='$messageid' where var_id=$chatid";
			mysql_query($sql);

			$text = "Detail transaksi anda yaitu:\nNama Pembeli : ".$nama."\nAlamat Pembeli : ".$alamat."\nNo HP : ".$nohp."\nProvinsi : ".$prov."\nKabupaten : ".$kabup."\nNama Produk : ".$nmproduk."\nJumlah pesanan : ".$jumlahpesanan."\nTotal Harga : ".$total.",00\nLakukan Transfer pada bank ".$namabank." dengan nomor rekening ini ".$nomorrekening." atas nama ".$namapemilik."";
			$buykey2 = 
			array(
	        	array(
		          	array('text' => 'Setuju', 'callback_data' => 'setuju'),
          		),
        	);

			sendApiKeyboard($chatid,$buykey2,true,$text);
		break;

		case $pesan == 'setuju';

			$idorder = rand(1,99999999);
			$idkonsumen = rand(1,99999);
			$sql_get_variabel = "select * from variabel where var_id=$chatid";
			$data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
			$hargabarang = $data_variabel['hargabarang2'];
			$gambar = $data_variabel['gambar'];
			$nama = $data_variabel['nama'];
			$alamat = $data_variabel['alamat'];
			$prov = $data_variabel['namaprov'];
			$jumlahpesanan = $data_variabel['jumlahpesanan'];
			$idproduk2 = $data_variabel['idproduk'];
			$idbank = $data_variabel['idbank'];
			$total = $data_variabel['total'];
			$kabup = $data_variabel['namakabup'];
			$nohp = $data_variabel['nohp'];
			$messageidkab = $data_variabel['messageidkab'];
			$messageidprov = $data_variabel['messageidprov'];
			$messageidbankk = $data_variabel['messageidbank'];
			$messageidpesanann = $data_variabel['messageidpesanan'];

			print_r($nohp);


			$sql = "INSERT INTO `order`(`id_order`, `id_produk`, `id_konsumen`, `id_bank`,`tanggal_orderan`,`status_pemesanan`,`no_resi`) VALUES ($idorder,$idproduk2,$idkonsumen,$idbank,CURRENT_TIMESTAMP,'Belum Dikonfirmasi',Null)";
			$result = mysql_query($sql);
			print_r("\n\n".$sql."");
			$sql2 = "INSERT INTO `detail_order`(`id_produk`,`id_order`,`kuantitas`,`total`) VALUES ($idproduk2,$idorder,$jumlahpesanan,$total)";
			$result2 = mysql_query($sql2);
			print_r("\n\n".$sql2."");

			$sql3 = "INSERT INTO `konsumen`(`id_konsumen`, `id_order`, `nama_konsumen`, `alamat_konsumen`, `provinsi`, `kabupaten`, `nomor_rekening_konsumen`, `id_telegram`,`no_hp`) VALUES ($idkonsumen,$idorder,'$nama','$alamat','$prov','$kabup',Null,Null,'$nohp')";
			$result3 = mysql_query($sql3);
			print_r($sql3);
			if(!empty($result and $result2 and $result3))
			{
				$sql5 = "DELETE FROM `variabel` WHERE var_id=$chatid";
				mysql_query($sql5);
				$sql7 = "DELETE FROM `status` WHERE id=$chatid";
				mysql_query($sql7);
			}
			$sql4 = "UPDATE `produk` SET `jumlah`= jumlah - $jumlahpesanan WHERE id_produk=$idproduk2";
			$result4 = mysql_query($sql4);
			print_r($sql4);
			$text = "Terima Kasih telah melakukan pemesanan di Toko Aneka Sutra\n\nSegera lakukan pembayaran ke nomor rekening tujuan dengan menyertakan Kode Pemesanan '$idorder'\n\nSetelah itu lakukan Konfirmasi pesanan pada 🔙 Main Menu dengan menekan tombol Konfirmasi Pesanan";
			sendApiKeyboard($chatid,$mainmenu,false,$text);
			deleteApiMsg($chatid,$messageidkab);
			deleteApiMsg($chatid,$messageidprov);
			deleteApiMsg($chatid,$messageidbankk);
			deleteApiMsg($chatid,$messageidpesanann);

		break;

		case $pesan == 'Konfirmasi Pesanan';
			$sql = "INSERT INTO status (`id`,`status`) VALUES ('$chatid','4')";
			mysql_query($sql);
			$text = "Masukkan kode pemesanan";
			sendApiMsg($chatid,$text);
		break;

        default:
        $sql_get_status = "select * from status where id='$chatid'";
		$data_status = mysql_fetch_assoc(mysql_query($sql_get_status));
		$status = $data_status['status'];
		$sql_get_status1 = "select * from variabel where var_id=$chatid";
		$data_status1 = mysql_fetch_assoc(mysql_query($sql_get_status1));
		$hargabr = $data_status1['hargabarang'];
        if($status == 1)
        {
        	preg_match('/^(.*)/',$pesan,$hasil);
            $jumlahbrng = $hasil[1];
            print_r($jumlahbrng);
            $hargabarang1 = $jumlahbrng * $hargabr;
			$sql1 = "update variabel set jumlahpesanan=$jumlahbrng, hargabarang2=$hargabarang1 where var_id=$chatid";
			mysql_query($sql1); 
            $jumlahbrngkredit = $jumlahbrng;
            $jumlahbrngatm = $jumlahbrng;
             $sql_get_status1 = "select * from variabel where var_id='$chatid'";
			$data_status1 = mysql_fetch_assoc(mysql_query($sql_get_status1));
			$idproduk2 = $data_status1['idproduk'];
            $stokbrng = ambiljumlah($idproduk2);
            $output = print_r($fromid, true);
			file_put_contents('file.log', $output);
             if($stokbrng > $jumlahbrng ) 
			    	{
			    		 $text = "Masukkan Nama Pembeli 👇";
			    		 $sql = "update status set status='2' where id='$chatid'";
						 mysql_query($sql); 
				         sendApiKeyboard($chatid,$kembalijumlah,false,$text);
			      	}
		      	elseif( strval($jumlahbrng) != strval(intval($jumlahbrng)) )
			      	{
			      		$text3 = "maaf masukkan angka untuk jumlah pemesanan";
			      		sendApiMsg($chatid,$text3);
			      	}
		      	elseif($stokbrng < $jumlahbrng)
			      	{
			       		$text2 = "Maaf pesanan anda sedang kosong atau stok tidak mencukupi";
			        	sendApiMsg($chatid,$text2);
		      		}
        }
        elseif($status == 2)
		    {
		    	preg_match('/^(.*)/',$pesan,$hasil);
		    	$nama = $hasil[1];
		    	$sql = "update variabel set nama='$nama' where var_id=$chatid";
				mysql_query($sql); 
				$sql1 = "update status set status='3' where id='$chatid'";
				 mysql_query($sql1); 
		    	$namakredit = $nama;
		    	$namaatm = $nama;
		    	$text = "Masukkan Alamat Pembeli 👇";
		    	sendApiKeyboard($chatid,$kembalinama,false,$text);    
		    }
	    elseif($status == 3)
		    {
		    	preg_match('/^(.*)/',$pesan,$hasil);
		    	$alamat = $hasil[1];
		    	print_r($alamat);
		    	$sql = "update variabel set alamat='$alamat' where var_id=$chatid";
				mysql_query($sql); 
				$sql1 = "update status set status='8' where id='$chatid'";
				 mysql_query($sql1); 
		    	$alamatkredit = $alamat;
		    	$alamatatm = $alamat;
		    	$text = "Masukkan Nomor Handphone 👇";
		    	sendApiKeyboard($chatid,$kembalialamat,false,$text); 
		    	
		    }
	    elseif($status == 4)
		    {
		    	preg_match('/^(.*)/',$pesan,$hasil);
		    	$idorderkonfirmasi = $hasil[1];
		    	$sql_get_order = "select `id_order` from `order` where `id_order`=$idorderkonfirmasi";
				$data_order = mysql_fetch_assoc(mysql_query($sql_get_order));
				$order1 = $data_order['id_order']; 
		    	$output = print_r($order1, true);
				file_put_contents('file.log', $output);

		    	if(empty($order1))
		    	{
		    		$text2 = "Kode pemesanan yang anda masukkan salah";
		    		sendApiMsg($chatid,$text2);
		    	}
		    	elseif(!empty($order1))
		    	{
			    	$sql = "INSERT INTO variabel (`var_id`,`idkonf`) VALUES ('$chatid','$idorderkonfirmasi')";
		   			mysql_query($sql); 
		   			$sql1 = "update status set status='6' where id='$chatid'";
					 mysql_query($sql1); 	   			
			    	$text = "Masukkan nomor rekening pembeli 👇";
			        sendApiMsg($chatid,$text);
		   		}
		    }
	    elseif($status == 5)
		    {
		    	preg_match('/^(.*)/',$pesan,$hasil);
		    	$namapembayar = $hasil[1];
		    	$status = 6;
		    	$text = "Masukkan nomor rekening pembeli 👇";
		        sendApiMsg($chatid,$text);
		    }
	    elseif($status == 6)
		    {
		    	preg_match('/^(.*)/',$pesan,$hasil);
		    	$rekeningpem = $hasil[1];
		    	$sql1 = "update status set status='7' where id='$chatid'";
				 mysql_query($sql1); 	   
		    	$sql_get_status1 = "select * from variabel where var_id=$chatid";
				$data_status1 = mysql_fetch_assoc(mysql_query($sql_get_status1));
				$idorderkonfirmasi = $data_status1['idkonf'];
		    	$sql = "UPDATE `konsumen` SET nomor_rekening_konsumen = $rekeningpem WHERE id_order = $idorderkonfirmasi";
				$result = mysql_query($sql);
				print_r($sql);
		        $text = "Masukkan nomor rekening tujuan 👇";
		        sendApiMsg($chatid,$text);
		    }
	    elseif($status == 7)
		    {
		    	 preg_match('/^(.*)/',$pesan,$hasil);
		    	 global $rekeningtuj;
		         $rekeningtuj = $hasil[1];
		         $sql_get_variabel = "select * from rekening_tujuan where nomor_rekening=$rekeningtuj";
				 $data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
				 $idbank = $data_variabel['id_bank'];
				if(!empty($idbank) && is_numeric($rekeningtuj) )
				{
				 $sql = "update variabel set rekeningtuj='$rekeningtuj' where var_id=$chatid";
				 mysql_query($sql); 
		         $text = "kirimkan foto bukti transfer/pemesanan dalam bentuk JPG";
		         sendApiMsg($chatid,$text);
				}
				elseif (empty($idbank)) {
				 $text2 = "nomor rekening tujuan yang anda masukkan salah\nsilahkan ulangi";
		         sendApiMsg($chatid,$text2);
				}

				
		    }
		     elseif($status == 8)
		     {
		     	preg_match('/^(.*)/',$pesan,$hasil);
		     	$nohp = $hasil[1];
		     	$nohp2 = strlen("$nohp");

		     	
				if($nohp2 = is_numeric($nohp) && $nohp2 >= 11){
					   $sql = "update variabel set nohp='$nohp' where var_id=$chatid";
						mysql_query($sql); 
						$text = "Lanjutkan dengan menekan tombol Provinsi untuk memilih provinsi tujuan barang";
			    		sendApiKeyboard($chatid,$provinsi,false,$text);
			    		$sql7 = "DELETE FROM `status` WHERE id=$chatid";
						mysql_query($sql7);
			    }
					   
				else {
					   $text2 = "Nomor yang anda masukkan salah";
						sendApiMsg($chatid,$text2);
					}
		     	
		     }
		     elseif($status == 9)
		     {
		     	preg_match('/^(.*)/',$pesan,$hasil);
		     	$kodetransaksi = $hasil[1];

		     	$sql_get_order1 = "select * from `order` where `id_order`=$kodetransaksi";
				$data_order1 = mysql_fetch_assoc(mysql_query($sql_get_order1));
				$idorder1 = $data_order1['id_order'];
				$idproduk1 = $data_order1['id_produk'];
				$tglorderan1 = $data_order1['tanggal_orderan'];
				$idkonsumen1 = $data_order1['id_konsumen'];
				$status_pemesanan1 = $data_order1['status_pemesanan'];
				$noresi1 = $data_order1['no_resi'];

				$sql_get_produk1 = "select * from `produk` where `id_produk`=$idproduk1";
				$data_produk1 = mysql_fetch_assoc(mysql_query($sql_get_produk1));
				$linkgambar = $data_produk1['images'];
				$namaproduk1 = $data_produk1['nama_produk'];

				$sql_get_konsumen1 = "select * from `konsumen` where `id_konsumen`=$idkonsumen1";
				$data_konsumen1 = mysql_fetch_assoc(mysql_query($sql_get_konsumen1));
				$nama_konsumen1 = $data_konsumen1['nama_konsumen'];
				$alamat_konsumen1 = $data_konsumen1['alamat_konsumen'];
				$kabupaten1 = $data_konsumen1['kabupaten'];
				$provinsi1 = $data_konsumen1['provinsi'];
				$no_hp1 = $data_konsumen1['no_hp'];

				$sql_get_detail1 = "select * from `detail_order` where `id_order`=$kodetransaksi";
				$data_detail1 = mysql_fetch_assoc(mysql_query($sql_get_detail1));
				$kuantitas1 = $data_detail1['kuantitas'];
				$total1 = $data_detail1['total'];
			
				if(!empty($idorder1))
				{

				sendApiPhotoInfo($chatid,$linkgambar);
				$text = "Detail transaksi anda yaitu:\nNama Pembeli : ".$nama_konsumen1."\nAlamat Pembeli : ".$alamat_konsumen1."\nNo HP : ".$no_hp1."\nProvinsi : ".$provinsi1."\nKabupaten : ".$kabupaten1."\nNama Produk : ".$namaproduk1."\nJumlah pesanan : ".$kuantitas1."\nTotal Harga : ".$total1.",00\n\nStatus Pemesanan : ".$status_pemesanan1."\nNomor Resi JNE : ".$noresi1."";
				
				sendApiKeyboard($chatid,$mainmenu,false,$text);
				$sql7 = "DELETE FROM `status` WHERE id=$chatid";
				mysql_query($sql7);
				
				}

				elseif(empty($idorder1))
				{
					$text = "Nomor Transaksi Yang Anda Masukkan Salah";	
					sendApiKeyboard($chatid,$mainmenu,false,$text);

				}



		     }
		     else
		     {
		     	sendApiMsg($chatid, "😅 No Such Format");
				break;
		     }
	    break;

           
	}
}


//             sendApiMsg($chatid, "😅 No Such Format");
// 			break;
// 	}
// }

function cekpilihan($kode,$kiriman=null){
	global $tabel;
	$tabeln = $tabel[$kode];
	$sql = "select id_produk, nama_produk from produk where jenis='$kiriman'";
	$result = mysql_query($sql);
	print_r($result);
	$arrnama = array();
	$arrid = array();
	$arr = [];
	if (mysql_num_rows($result) > 0) {
    // output data of each row
	$i=0;
     while($row = mysql_fetch_array($result)) {

        // $arrnama[] = $row["nama_produk"];
        // $arrid[] = $row["id_produk"];
        $arr[$i]["text"]= $row["nama_produk"];
        $arr[$i]["callback_data"]= $kode.$row["nama_produk"];
        $i++;
    }
}
		$ar1 = [];
		
		$inpilihan = array();
		$ia = 0;
		foreach ($arr as $key1) {
			$key1a = 0;
			foreach ($key1 as $key2 => $value2) {
				 $inpilihan[$ia][0][$key2] = $value2;
				 $inpilihan[$ia][0][$key2] = $value2;
				 $key1a++;
			}
		$ia++;
		}
		
		return $inpilihan;
		print_r($inpilihan);
}

function ambilgambar($kiriman=null){
	$sql = "select images,nama_produk,deskripsi_produk,harga from produk where nama_produk='$kiriman'";
	$result = mysql_query($sql);
	if(!empty($result)){
		$data = mysql_fetch_assoc($result);
		$inpilihangambar = $data['images'];
		return $inpilihangambar;
	}
}

function ambilnamabarang($kiriman=null)
{
	$sql = "select nama_produk from produk where nama_produk='$kiriman'";
	$result = mysql_query($sql);
	if(!empty($result)){
		$data = mysql_fetch_assoc($result);
		$inpilihannamaproduk = $data['nama_produk'];
		return $inpilihannamaproduk;
	}

}

function ambilid($kiriman=null)
{
	$sql = "select id_produk from produk where nama_produk='$kiriman'";
	$result = mysql_query($sql);
	if(!empty($result)){
		$data = mysql_fetch_assoc($result);
		$inpilihanidprodukk = $data['id_produk'];
		return $inpilihanidprodukk;
	}

}

function ambildeskripsibarang($kiriman=null)
{
	$sql = "select deskripsi_produk from produk where nama_produk='$kiriman'";
	$result = mysql_query($sql);
	if(!empty($result)){
		$data = mysql_fetch_assoc($result);
		$inpilihandeskripsi = $data['deskripsi_produk'];
		return $inpilihandeskripsi;
	}

}

function ambilhargabarang($kiriman=null)
{
	$sql = "select harga from produk where nama_produk='$kiriman'";
	$result = mysql_query($sql);
	if(!empty($result)){
		$data = mysql_fetch_assoc($result);
		$inpilihanharga = $data['harga'];
		return $inpilihanharga;
	}

}

function ambiljumlah($kiriman){
	// global $jumlahbaru;
	$sql1 = "SELECT `jumlah` from `produk` where id_produk=$kiriman";
	$result2 = mysql_query($sql1);
	print_r("\n\nini adalah ".$result2);
	if(!empty($result2)){
			$data = mysql_fetch_assoc($result2);
			$jumlahbaru = $data['jumlah'];
			print_r($jumlahbaru);
			return $jumlahbaru;
		}
}

function pilihanbank(){
	global $tabel;
	$tabeln = $tabel[$kode];
	$kode2 = "Anda Memilih Bank ";
	$sql = "select `id_bank`, `nama_bank` from `rekening_tujuan` WHERE not id_bank=10";
	$result = mysql_query($sql);
	print_r($result);
	$arrnama = array();
	$arrid = array();
	$arr = [];
	if (mysql_num_rows($result) > 0) {
    // output data of each row
	$i=0;
     while($row = mysql_fetch_array($result)) {

        // $arrnama[] = $row["nama_produk"];
        // $arrid[] = $row["id_produk"];
        $arr[$i]["text"]= $row["nama_bank"];
        $arr[$i]["callback_data"]= $kode2.$row["nama_bank"];
        $i++;
    }
}
		$ar1 = [];
		
		$inpilihan = array();
		$ia = 0;
		foreach ($arr as $key1) {
			$key1a = 0;
			foreach ($key1 as $key2 => $value2) {
				 $inpilihan[$ia][0][$key2] = $value2;
				 $inpilihan[$ia][0][$key2] = $value2;
				 $key1a++;
			}
		$ia++;
		}
		
		return $inpilihan;
			print_r($inpilihan);
}

function ambilnomorekening($kiriman){
	// global $jumlahbaru;
	$sql1 = "SELECT `nomor_rekening` from `rekening_tujuan` where nama_bank='$kiriman'";
	$result2 = mysql_query($sql1);
	print_r("\n\nini adalah ".$result2);
	if(!empty($result2)){
			$data = mysql_fetch_assoc($result2);
			$nomor = $data['nomor_rekening'];
			print_r($nomor);
			return $nomor;
		}
}

function ambilidbank($kiriman){
	// global $jumlahbaru;
	$sql1 = "SELECT `id_bank` from `rekening_tujuan` where nama_bank='$kiriman'";
	$result2 = mysql_query($sql1);
	print_r("\n\nini adalah ".$result2);
	if(!empty($result2)){
			$data = mysql_fetch_assoc($result2);
			$idbankk = $data['id_bank'];
			print_r($nomor);
			return $idbankk;
		}
}

function ambilnamapemilik($kiriman){
	// global $jumlahbaru;
	$sql1 = "SELECT `nama_pemilik` from `rekening_tujuan` where nama_bank='$kiriman'";
	$result2 = mysql_query($sql1);
	print_r("\n\nini adalah ".$result2);
	if(!empty($result2)){
			$data = mysql_fetch_assoc($result2);
			$namapemilik = $data['nama_pemilik'];
			print_r($nomor);
			return $namapemilik;
		}
}

		
