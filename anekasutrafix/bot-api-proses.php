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

$kembalinope = array(
		array('🤛Kembali','🔚Batalkan'),
);




$idfoto;
$token;

//fungsi yang dipanggil pertama kali bot dirunning
function prosesApiMessage($sumber)
{
	//if ($GLOBALS['debug']) mypre($sumber);
	global $idproduk2,$total,$jumlahbrngkredit,$prov,$alamatkredit,$kabup,$namakredit,$mainmenu,$con;
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
      	elseif(isset($message['successful_payment'])) 
      	{
        prosesPesanSuccessfulPayment($message);
        	$chatid = $message['chat']['id'];

        	$sql_get_variabel = "select * from variabel where var_id=$chatid";
			$data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
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
			$ukuran = $data_variabel['ukuran'];
			$ganti = $data_variabel['ganti'];
			$ongkir2 = $data_variabel['ongkir'];
			$nono = $data_variabel['no_ganti'];

        	$sql_ceknama = "select * from konsumen where no_hp='$nono'";
			$data_ceknama = mysqli_fetch_assoc(mysqli_query($con,$sql_ceknama));
			$adanama = $data_ceknama['nama_konsumen'];
			$idkonsumen = $data_ceknama['id_konsumen'];
			$ongkir = $data_ceknama['ongkir'];
        	$idorder = rand(1,99999999);

			if(empty($adanama))
			{
				$sql3 = "INSERT INTO `konsumen`(`id_konsumen`, `id_order`, `nama_konsumen`, `alamat_konsumen`, `provinsi`, `kabupaten`, `id_telegram`,`no_hp`,`ongkir`) VALUES (Null,$idorder,'$nama','$alamat','$prov','$kabup','$chatid','$nohp',$ongkir2)";
				$result3 = mysqli_query($con,$sql3);

				$sql_id_kons = "select * from konsumen where nama_konsumen='$nama' && no_hp='$nohp'";
				$data_cekid = mysqli_fetch_assoc(mysqli_query($con,$sql_id_kons));
				$idkonsumen9 = $data_cekid['id_konsumen'];

				$sql = "INSERT INTO `order`(`id_order`, `id_sub_produk`, `id_ukuran`,`id_konsumen`, `id_bank`,`tanggal_orderan`,`status_pemesanan`,`no_resi`) VALUES ($idorder,$idproduk2,$ukuran,$idkonsumen9,$idbank,CURRENT_TIMESTAMP,'Belum Dikonfirmasi',Null)";
				$result = mysqli_query($con,$sql);
				$sql2 = "INSERT INTO `detail_order`(`id_order`,`kuantitas`,`total`) VALUES ($idorder,$jumlahpesanan,$total)";
				$result2 = mysqli_query($con,$sql2);
				$sql4 = "UPDATE `sub_produk` SET `jumlah_sub_produk`= jumlah_sub_produk - $jumlahpesanan WHERE id_sub_produk=$idproduk2";
				$result4 = mysqli_query($con,$sql4);
				print_r($sql4);
				$sql8 = "INSERT INTO `membayar`(`id_pembayaran`, `id_bank`, `id_order`, `status`, `gambar_bukti`) VALUES ('Null','Null',$idorder,1,'https://sinjhy.xyz/webtoko/gambar/lunas.png')";
				$result8 = mysqli_query($con,$sql8);
				$text = "Terima Kasih telah melakukan pemesanan di Toko Aneka Sutra\n\nUntuk mengecek status pesanan, silahkan menggunakan kode pemesanan '$idorder'";
				sendApiKeyboard($chatid,$mainmenu,false,$text);
				deleteApiMsg($chatid,$messageidkab);
				deleteApiMsg($chatid,$messageidprov);
				deleteApiMsg($chatid,$messageidprov1);
				deleteApiMsg($chatid,$messageidprov2);
				deleteApiMsg($chatid,$messageidprov3);
				deleteApiMsg($chatid,$messageidbankk);
				deleteApiMsg($chatid,$messageidpesanann);
			}

			elseif (!empty($adanama) && $ganti == 1) {
				$sql = "INSERT INTO `order`(`id_order`, `id_sub_produk`, `id_ukuran`,`id_konsumen`, `id_bank`,`tanggal_orderan`,`status_pemesanan`,`no_resi`) VALUES ($idorder,$idproduk2,$ukuran,$idkonsumen,$idbank,CURRENT_TIMESTAMP,'Belum Dikonfirmasi',Null)";
				$result = mysqli_query($con,$sql);
				print_r("\n\n".$sql."");
				$sql2 = "INSERT INTO `detail_order`(`id_detail`,`id_order`,`kuantitas`,`total`) VALUES (NULL,$idorder,$jumlahpesanan,$total)";
				$result2 = mysqli_query($con,$sql2);
				print_r("\n\n".$sql2."");
				$sql3 = "UPDATE `konsumen` SET `id_telegram`= '$chatid' WHERE id_konsumen=$idkonsumen";
				$result3 = mysqli_query($con,$sql3);
				$sql4 = "UPDATE `sub_produk` SET `jumlah_sub_produk`= jumlah_sub_produk - $jumlahpesanan WHERE id_sub_produk=$idproduk2";
				$result4 = mysqli_query($con,$sql4);
				print_r($sql4);
				$sql8 = "INSERT INTO `membayar`(`id_pembayaran`, `id_bank`, `id_order`, `status`, `gambar_bukti`) VALUES ('Null','Null',$idorder,1,'https://sinjhy.xyz/webtoko/gambar/lunas.png')";
				$result8 = mysqli_query($con,$sql8);
				$text = "Terima Kasih telah melakukan pemesanan di Toko Aneka Sutra\n\nUntuk mengecek status pesanan, silahkan menggunakan kode pemesanan '$idorder'";
				sendApiKeyboard($chatid,$mainmenu,false,$text);
				deleteApiMsg($chatid,$messageidkab);
				deleteApiMsg($chatid,$messageidprov);
				deleteApiMsg($chatid,$messageidprov1);
				deleteApiMsg($chatid,$messageidprov2);
				deleteApiMsg($chatid,$messageidprov3);
				deleteApiMsg($chatid,$messageidbankk);
				deleteApiMsg($chatid,$messageidpesanann);
			}
			
			elseif (!empty($adanama) && $ganti == 2) 
			{
				$sql = "INSERT INTO `order`(`id_order`, `id_sub_produk`, `id_ukuran`,`id_konsumen`, `id_bank`,`tanggal_orderan`,`status_pemesanan`,`no_resi`) VALUES ($idorder,$idproduk2,$ukuran,$idkonsumen,$idbank,CURRENT_TIMESTAMP,'Belum Dikonfirmasi',Null)";
				$result = mysqli_query($con,$sql);
				print_r("\n\n".$sql."");
				$sql2 = "INSERT INTO `detail_order`(`id_detail`,`id_order`,`kuantitas`,`total`) VALUES (NULL,$idorder,$jumlahpesanan,$total)";
				$result2 = mysqli_query($con,$sql2);
				print_r("\n\n".$sql2."");
				$sql3 = "UPDATE `konsumen` SET `nama_konsumen`='$nama',`alamat_konsumen`='$alamat',`no_hp`='$nohp',`provinsi`='$prov',`kabupaten`='$kabup',`ongkir`=$ongkir2,id_telegram='$chatid' WHERE `id_konsumen`='$idkonsumen'";
				$result3 = mysqli_query($con,$sql3);
				$sql4 = "UPDATE `sub_produk` SET `jumlah_sub_produk`= jumlah_sub_produk - $jumlahpesanan WHERE id_sub_produk=$idproduk2";
				$result4 = mysqli_query($con,$sql4);
				print_r($sql4);
				$sql8 = "INSERT INTO `membayar`(`id_pembayaran`, `id_bank`, `id_order`, `status`, `gambar_bukti`) VALUES ('Null','Null',$idorder,1,'https://sinjhy.xyz/webtoko/gambar/lunas.png')";
				$result8 = mysqli_query($con,$sql8);
			$text = "Terima Kasih telah melakukan pemesanan di Toko Aneka Sutra\n\nUntuk mengecek status pesanan, silahkan menggunakan kode pemesanan '$idorder'";
				sendApiKeyboard($chatid,$mainmenu,false,$text);
				deleteApiMsg($chatid,$messageidkab);
				deleteApiMsg($chatid,$messageidprov);
				deleteApiMsg($chatid,$messageidprov1);
				deleteApiMsg($chatid,$messageidprov2);
				deleteApiMsg($chatid,$messageidprov3);
				deleteApiMsg($chatid,$messageidbankk);
				deleteApiMsg($chatid,$messageidpesanann);

			}	
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
	global $con;
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
}

function prosesCallAnswer($message){
	global $con;
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
	global $con;
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
	global $con;
	$chatid = $message['chat']['id'];
	$messageid = $message['message_id'];
	/* Get file info */
	$fileid = $message['photo'][1]['file_id'];
	$filesize = $message['photo'][1]['file_size'];
	$width = $message['photo'][1]['width'];
	$height = $message['photo'][1]['height'];
	$ukuran = getSize($filesize);
	$text = "Photo Info - id $fileid, dimension: $width x $height, file size: $ukuran";
	global $idfoto,$rekeningtuj,$idorderkonfirmasi,$token;
	print_r("ini id foto".$fileid);
	sendApiMsg($chatid,$text);
	if(!empty($fileid))
	{
		$sql_get_variabel = "select * from variabel where var_id=$chatid";
		$data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
		$rekeningtuj = $data_variabel['rekeningtuj'];
		$idorderkonfirmasi = $data_variabel['idkonf'];
		$text2 = "Terima kasih telah melakukan konfirmasi pesanan\nPesanan anda akan segera kami proses setelah admin mengecek konfirmasi anda\nUntuk mengecek status pemesanan silahkan memilih menu Status Pemesanan";
		getFile($fileid);
		$imgurl = 'https://api.telegram.org/file/bot1042982923:AAHukRwZIrUPJ3TACOrAhyy8QsBuhNm8dQc/'.$idfoto.'';
		$nomor = rand(1,999);
		$namatambahan = "".$idfoto."+".$chatid."".$nomor."";  
        $namatambahanfix = md5($namatambahan);
        $namatambahanfix2 = "".$namatambahanfix.".jpg"; 
		$imagename= basename($imgurl);
		$image = file_get_contents($imgurl); 
		file_put_contents('gambar_bukti/'.$namatambahanfix2,$image);

		$idfotofix = 'https://sinjhy.xyz/anekasutrafix/gambar_bukti/'.$namatambahanfix2.'';
		 $sql = "SELECT `id_bank` FROM `rekening_tujuan` WHERE nomor_rekening = $rekeningtuj";
		$result = mysqli_query($con,$sql);
		print_r($sql);
		$data = mysqli_fetch_assoc($result);
		$idbankatm = $data['id_bank'];
		print_r("\n\n".$idbankatm."");
		$sql1 = "INSERT INTO `membayar`(`id_pembayaran`, `id_bank`, `id_order`, `status`, `gambar_bukti`) VALUES ('Null',$idbankatm,$idorderkonfirmasi,Null,'$idfotofix')";
		$result1 = mysqli_query($con,$sql1);
		print_r($sql1);
		$sql2 = "UPDATE `order` SET id_bank = $idbankatm WHERE id_order = $idorderkonfirmasi";
		$result2 = mysqli_query($con,$sql2);
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

}
function prosesPesanSuccessfulPayment($message){
	$chatid = $message['chat']['id'];
	$currency = $message['successful_payment']['currency'];
	$total_amount = $message['successful_payment']['total_amount'];
	$invoice_payload = $message['successful_payment']['invoice_payload'];
	$telegram_payment_charge_id = $message['successful_payment']['telegram_payment_charge_id'];
	$provider_payment_charge_id = $message['successful_payment']['provider_payment_charge_id'];
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
	global $total,$con;
	global $idorderkonfirmasi,$rekeningtuj,$nomorrekening,$idbank;
	global $kembalijumlah,$kembalinama,$kembalialamat,$kembalinope;
	
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
			$text = "Silahkan Pilih Kategori Produk Yang Ingin Dibeli💵";
			sendApiKeyboard($chatid,$jenis,false,$text);
		break;

		case $pesan == 'Status Pemesanan':
			$text = "Masukkan Kode Pemesanan 👇";
			$sql_get_status = "select * from status where id='$chatid'";
			$data_status = mysqli_fetch_assoc(mysqli_query($con,$sql_get_status));
			$idchat = $data_status['id'];
			if(!empty($idchat))
			{
				$sql3 = "update status set status='9' where id='$chatid'";
				mysqli_query($con,$sql3);
				sendApiKeyboard($chatid,$mainmenu,false,$text);
			}
			elseif(empty($idchat))
			{
				$sql = "INSERT INTO status (`id`,`status`) VALUES ('$chatid','9')";
				mysqli_query($con,$sql);
				sendApiKeyboard($chatid,$mainmenu,false,$text);
			}
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

			$sql_get_produk = "select * from produk left outer join sub_produk on produk.id_produk = sub_produk.id_produk WHERE nama_produk = '$namaproduk' group by sub_produk.nama_sub_produk";
			 $result1 = mysqli_query($con,$sql_get_produk);

			    $arr = [];
				if (mysqli_num_rows($result1) > 0) {
			    // output data of each row
				$a = 0;
			     while($row = mysqli_fetch_array($result1)) {

			        $text2 = "Nama Produk = ".$row["nama_sub_produk"]."\nDeskripsi Produk = ".$row["deskripsi_sub_produk"]."\n Harga Produk = ".$row["harga_sub_produk"]."";

			        $source = $row["images"];

					$buykey = 
					array(
			        	array(
				          	array('text' => 'Pesan', 'callback_data' => 'Anda Memesan '.$row["nama_sub_produk"].""),
				          	array('text' => 'Tidak', 'callback_data' => 'tidak')
		          		),
		        	);
					sendApiPhoto($chatid,$source,$text2,$buykey);
				}
			}	
        break;

        case preg_match("/^Anda Memesan (.*)/", $pesan, $hasil2):
            $namaproduk = $hasil2[1];
            $idsub = ambilidsub($namaproduk);
            $inpilihangambar = ambilgambar($namaproduk);
			$source = $inpilihangambar;
			$inpilihannamaproduk = ambilnamabarang($namaproduk);
			$nmproduk = $inpilihannamaproduk;
			$inpilihanharga = ambilhargabarang($namaproduk);
			$hargapr = $inpilihanharga;
			$inpilihandeskripsi = ambildeskripsibarang($namaproduk);
			print_r($inpilihandeskripsi);
			$deskripsi = $inpilihandeskripsi;
           	$sql_get_produk = "select * from sub_produk left outer join(SELECT ukuran.id_ukuran,ukuran.ukuran,satuan.satuan FROM ukuran left outer join satuan on ukuran.id_satuan = satuan.id_satuan) a on sub_produk.id_ukuran = a.id_ukuran WHERE nama_sub_produk='$namaproduk'";
			 $result1 = mysqli_query($con,$sql_get_produk);
			 print_r($result1);
			$sql_get_status = "select * from variabel where var_id='$chatid'";
			$data_status = mysqli_fetch_assoc(mysqli_query($con,$sql_get_status));
			$var_id = $data_status['var_id'];

			 if(empty($var_id))
			 {
				 $arr = [];
					if (mysqli_num_rows($result1) > 0) {
					$a = 0;
				     while($row = mysqli_fetch_array($result1)) {
				     	 $rows[] = $row;
				 	}
				 }
				$sql = "INSERT INTO variabel (`var_id`,`idproduk`,`nmproduk`,`hargabarang`,`gambar`,`deskripsi`) VALUES ('$chatid',$idsub,'$nmproduk',$hargapr,'$source','$deskripsi')";
	   			mysqli_query($con,$sql);
			}
			elseif (!empty($var_id)) 
			{
				$arr = [];
					if (mysqli_num_rows($result1) > 0) {
					$a = 0;
				     while($row = mysqli_fetch_array($result1)) {
				     	 $rows[] = $row;
				 	}
				 }
				 $sql1 = "update variabel set idproduk=$idsub,nmproduk='$nmproduk',hargabarang=$hargapr,gambar='$source',deskripsi='$deskripsi' where var_id='$chatid'";
				mysqli_query($con,$sql1);
			}
				$no=0;
			foreach($rows as $row){ 
			
				$arr2[0][$no]['text'] = "".$row["ukuran"]." ".$row["satuan"]."";
				$arr2[0][$no]["callback_data"] = "Anda memilih ukuran ".$row["ukuran"];
					$no++;
						
				
				}

			sendApiKeyboard($chatid,$arr2,true,"Silahkan Memilih Ukuran");
            
        break;

        case preg_match("/^Anda memilih ukuran (.*)/", $pesan, $hasil2):
            $ukuran = $hasil2[1];
            $idukuran = ambilidukuran($ukuran);
            print_r($idukuran);
             $sql_get_status = "select * from status where id='$chatid'";
			$data_status = mysqli_fetch_assoc(mysqli_query($con,$sql_get_status));
			$idchat = $data_status['id'];
			if(empty($idchat))
			{
	            $sql = "INSERT INTO `status`(`id`,`status`) VALUES ('$chatid','1')";
				mysqli_query($con,$sql);  
			}
			elseif(!empty($idchat))
			{
				 $sql3 = "update status set status='1' where id='$chatid'";
				 mysqli_query($con,$sql3); 
			}
            $sql_get_variabel = "select * from variabel where var_id='$chatid'";
			$data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
			$var_id = $data_variabel['var_id'];
			$nama_sub = $data_variabel['nmproduk'];
			$sql_get_id_sub = "SELECT `id_sub_produk` FROM `sub_produk` WHERE `nama_sub_produk` = '$nama_sub' AND `id_ukuran` = $idukuran";
			$data_sub = mysqli_fetch_assoc(mysqli_query($con,$sql_get_id_sub));
			$id_sub = $data_sub['id_sub_produk'];
			 $sql1 = "update `variabel` set ukuran=$idukuran,idproduk=$id_sub where var_id=$chatid";
            mysqli_query($con,$sql1); 
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
			mysqli_query($con,$sql); 
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
			mysqli_query($con,$sql); 
        	$text = "Masukkan Nama Pembeli 👇";
            sendApiKeyboard($chatid,$kembalijumlah,false,$text);    	
        break;

        case $pesan == '🔙Kembali':
         	$sql = "update status set status='3' where id='$chatid'";
			mysqli_query($con,$sql); 
        	$text = "Masukkan Alamat Pembeli 👇";
            sendApiKeyboard($chatid,$kembalinama,false,$text); 
        break;

        case $pesan == '🤛Kembali':
         	$sql = "update status set status='8' where id='$chatid'";
			mysqli_query($con,$sql); 
        	$text = "Masukkan Nomor Handphone 👇";
            sendApiKeyboard($chatid,$kembalialamat,false,$text); 
        break;

        case $pesan == 'Ya,ganti':
			$sql1 = "update status set status='10' where id='$chatid'";
			mysqli_query($con,$sql1); 
			$sql = "update variabel set ganti=2 where var_id='$chatid'";
				mysqli_query($con,$sql); 
			$text = "Masukkan nomor HP yang baru 👇";
			sendApiKeyboard($chatid,$kembalinope,false,$text);
        break;

        case $pesan == 'Tidak,ganti':
        	$sql_get_variabel = "select * from `variabel` where `var_id`='$chatid'";
			$data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
			$namanama = $data_variabel['nama'];
			$jumlahpesanan = $data_variabel['jumlahpesanan'];
			$nmproduk = $data_variabel['nmproduk'];
			$harga = $data_variabel['hargabarang2'];
			$gambar = $data_variabel['gambar'];
			$ukuran = $data_variabel['ukuran'];
			$nono = $data_variabel['no_ganti'];


			$namaukuran = ambilnamaukuran($ukuran);
			$idsatuan = ambilidsatuandariukuran($ukuran);
			$namasatuan = ambilnamasatuan($idsatuan);


			$sql_get_info = "select * from `konsumen` where `no_hp`='$nono'";
			$data_info = mysqli_fetch_assoc(mysqli_query($con,$sql_get_info));
			$nama = $data_info['nama_konsumen'];
			$alamat = $data_info['alamat_konsumen'];
			$nohp2 = $data_info['no_hp'];
			$kabup = $data_info['kabupaten'];
			$ongkir =$data_info['ongkir'];

			$total = $ongkir + $harga;


        	$text = "Detail pesanan anda:\nNama: ".$nama."\nAlamat: ".$alamat."\nNo.HP: ".$nohp2."\nKabupaten: ".$kabup."\nProduk: ".$nmproduk."\nJumlah: ".$jumlahpesanan."\nTotal Harga: ".$total.",00\nUkuran: ".$namaukuran." ".$namasatuan."";
	    	$buykey = 
			array(
	        	array(
		          	array('text' => 'Kartu Kredit', 'callback_data' => 'kartukredit'),
		          	array('text' => 'Transfer', 'callback_data' => 'transfer')
          		),
        	);
        	$sql = "update variabel set total=$total,ganti=1 where var_id='$chatid'";
			mysqli_query($con,$sql);
			$text2 = "Pilih metode pembayaran yang akan anda gunakan";
         	sendApiKeyboard($chatid,$kembalinope,false,$text2);
			sendApiPhotoInfo($chatid,$gambar);
			sendApiKeyboard($chatid,$buykey,true,$text);
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

	    	$sql = "update variabel set messageidprov1='$messageid' where var_id=$chatid";
			mysqli_query($con,$sql);
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
			$sql = "update variabel set messageidprov2='$messageid' where var_id=$chatid";
			mysqli_query($con,$sql);
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
			$sql = "update variabel set messageidprov2='$messageid' where var_id=$chatid";
			mysqli_query($con,$sql);
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

	    	$sql = "update variabel set messageidprov3='$messageid' where var_id=$chatid";
			mysqli_query($con,$sql);
	    	sendApiKeyboard($chatid,$inpilihan,true,$text7);
	    	sendApiKeyboard($chatid,$next2,false,$text8);
	    	// sendApiMsg($chatid,$messageid);
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
	   		mysqli_query($con,$sql); 
	   		$output = print_r($a1, true);
			file_put_contents('file.log', $output);
			$sql = "update variabel set messageidprov='$messageid' where var_id=$chatid";
			mysqli_query($con,$sql);  
			
	        sendApiKeyboard($chatid,$kabupaten,false,$text);
	   		break;

	   	case $pesan == 'Kabupaten':
	   		global $kodepro,$con;
	   		$sql_get_status = "select * from variabel where var_id=$chatid";
			$data_status = mysqli_fetch_assoc(mysqli_query($con,$sql_get_status));
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
			$data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
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
			$ukuran = $data_variabel['ukuran'];

			$namaukuran = ambilnamaukuran($ukuran);
			$idsatuan = ambilidsatuandariukuran($ukuran);
			$namasatuan = ambilnamasatuan($idsatuan);


	    	$total = $ongkir + $hargabarang; 
        	$text = "Detail pesanan anda:\nNama: ".$nama."\nAlamat: ".$alamat."\nNo.HP: ".$nohp2."\nKabupaten: ".$kabup."\nProduk: ".$nmproduk."\nUkuran: ".$namaukuran." ".$namasatuan."\nJumlah: ".$jumlahpesanan."\nTotal Harga: ".$total.",00";
	    	$buykey = 
			array(
	        	array(
		          	array('text' => 'kartu kredit', 'callback_data' => 'kartukredit'),
		          	array('text' => 'transfer', 'callback_data' => 'transfer')
          		),
        	);
	    	
        	$sql = "update variabel set idkab=$kodekb,namakabup='$kabup',total=$total,ongkir=$ongkir,messageidkab='$messageid' where var_id=$chatid";
			mysqli_query($con,$sql); 

			"\n\n\n\n\n\n\n".print_r($a2);
			$text2 = "Pilih metode pembayaran yang akan anda gunakan";
			sendApiMsg($chatid,$text2);
			sendApiPhotoInfo($chatid,$gambar);
			sendApiKeyboard($chatid,$buykey,true,$text);		
		   break;

		 case $pesan == 'kartukredit':
		 		$sql_get_variabel = "select * from variabel where var_id=$chatid";
				$data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
				$hargabarang = $data_variabel['hargabarang2'];
				$gambar = $data_variabel['gambar'];
				$nmproduk = $data_variabel['nmproduk'];
				$deskripsi = $data_variabel['deskripsi'];
				$jumlahpesanan = $data_variabel['jumlahpesanan'];
				$total = $data_variabel['total'];
		 		$total2 = $total."00";

		  		$LabeledPrice = array(array('label' => "Pesanan Anda", 'amount' => $total2));
			    $payload = 'telebot-test-invoice';
			    print_r($payload);
			    $provider = '284685063:TEST:Zjg0ZDQ0NjMxZjI3';
			    print_r($provider);
			    $parameter = 'foo';
			    print_r($parameter);
			    $currency = 'IDR';
			    sendInvoice($chatid,$nmproduk,$deskripsi,$payload,$provider,$parameter,$currency,json_encode($LabeledPrice),$gambar);
			    $sql = "update variabel set messageidpesanan='$messageid' where var_id=$chatid";
			    mysqli_query($con,$sql);
		 break;

		case $pesan == 'transfer';
			$pilihanbank = pilihanbank();
			print_r($pilihanbank);
			$text = "Pilihan banknya yaitu 👇";
			$text2 = "Pilih bank yang akan menjadi tempat pembayaran Anda";
			$sql = "update variabel set messageidpesanan='$messageid' where var_id=$chatid";
			mysqli_query($con,$sql); 
			sendApiKeyboard($chatid,$mainmenu,false,$text2);
			sendApiKeyboard($chatid,$pilihanbank,true,$text);


		break;

		case preg_match("/^Anda Memilih Bank (.*)/", $pesan, $hasil):
			global $con;
			$namabank = $hasil[1];
			$sql1 = "SELECT `nomor_rekening` from `rekening_tujuan` where nama_bank='$namabank'";
			$result2 = mysqli_query($con,$sql1);
			$data = mysqli_fetch_assoc($result2);
			$nomorrekening = $data['nomor_rekening'];
			$sql1 = "SELECT `id_bank` from `rekening_tujuan` where nama_bank='$namabank'";
			$result2 = mysqli_query($con,$sql1);
			$data = mysqli_fetch_assoc($result2);
			$idbank = $data['id_bank'];
			$sql1 = "SELECT `nama_pemilik` from `rekening_tujuan` where nama_bank='$kiriman'";
			$result2 = mysqli_query($con,$sql1);
			$data = mysqli_fetch_assoc($result2);
			$namapemilik = $data['nama_pemilik'];
			$sql = "update variabel set idbank=$idbank where var_id=$chatid";
			mysqli_query($con,$sql);
			$sql_get_variabel = "select * from variabel where var_id=$chatid";
			$data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
			$namafix = $data_variabel['nama'];
			$ganti = $data_variabel['ganti'];
			$nono = $data_variabel['no_ganti'];
			$sql_get_info = "select * from `konsumen` where `no_hp`='$nono'";
			$data_info = mysqli_fetch_assoc(mysqli_query($con,$sql_get_info));
			$nama1 = $data_info['nama_konsumen'];
			$alamat = $data_info['alamat_konsumen'];
			$nohp2 = $data_info['no_hp'];
			$kabup = $data_info['kabupaten'];
			$ongkir =$data_info['ongkir'];
			$prov = $data_info['provinsi'];
			// sendApiKeyboard($chatid,$mainmenu,false,$nama1);
			if (!empty($nohp2) && $ganti == 1) 
			{
				$sql = "update variabel set idbank=$idbank where var_id=$chatid";
				mysqli_query($con,$sql);
				$sql_get_variabel = "select * from variabel where var_id=$chatid";
				$data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
				$hargabarang = $data_variabel['hargabarang2'];
				$nmproduk = $data_variabel['nmproduk'];
				$jumlahpesanan = $data_variabel['jumlahpesanan'];
				$ukuran = $data_variabel['ukuran'];
				$total = $ongkir + $hargabarang;
				$sql = "update variabel set messageidbank='$messageid' where var_id=$chatid";
				mysqli_query($con,$sql);

				$namaukuran = ambilnamaukuran($ukuran);
				$idsatuan = ambilidsatuandariukuran($ukuran);
				$namasatuan = ambilnamasatuan($idsatuan);

				$text = "Detail transaksi anda yaitu:\nNama Pembeli : ".$nama1."\nAlamat Pembeli : ".$alamat."\nNo HP : ".$nohp2."\nProvinsi : ".$prov."\nKabupaten : ".$kabup."\nNama Produk : ".$nmproduk."\nJumlah pesanan : ".$jumlahpesanan."\nTotal Harga : ".$total.",00\nUkuran : ".$namaukuran." ".$namasatuan."\nLakukan Transfer pada bank ".$namabank." dengan nomor rekening ini ".$nomorrekening." atas nama ".$namapemilik."";
				$buykey2 = 
				array(
		        	array(
			          	array('text' => 'Setuju', 'callback_data' => 'setuju'),
	          		),
	        	);

				sendApiKeyboard($chatid,$buykey2,true,$text);
			}
			elseif (!empty($nohp2) && $ganti == 2)
			{
				$sql = "update variabel set idbank=$idbank where var_id=$chatid";
				mysqli_query($con,$sql);
				$sql_get_variabel = "select * from variabel where var_id=$chatid";
				$data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
				$hargabarang = $data_variabel['hargabarang2'];
				$nmproduk = $data_variabel['nmproduk'];
				$jumlahpesanan = $data_variabel['jumlahpesanan'];
				$gambar = $data_variabel['gambar'];
				$nama = $data_variabel['nama'];
				$alamat = $data_variabel['alamat'];
				$prov = $data_variabel['namaprov'];
				$total = $data_variabel['total'];
				$kabup = $data_variabel['namakabup'];
				$nohp = $data_variabel['nohp'];
				$ukuran = $data_variabel['ukuran'];
				$sql = "update variabel set messageidbank='$messageid' where var_id=$chatid";
				mysqli_query($con,$sql);

				$namaukuran = ambilnamaukuran($ukuran);
				$idsatuan = ambilidsatuandariukuran($ukuran);
				$namasatuan = ambilnamasatuan($idsatuan);

				$text = "Detail transaksi anda yaitu:\nNama Pembeli : ".$nama."\nAlamat Pembeli : ".$alamat."\nNo HP : ".$nohp."\nProvinsi : ".$prov."\nKabupaten : ".$kabup."\nNama Produk : ".$nmproduk."\nJumlah pesanan : ".$jumlahpesanan."\nTotal Harga : ".$total.",00\nUkuran : ".$namaukuran." ".$namasatuan."\nLakukan Transfer pada bank ".$namabank." dengan nomor rekening ini ".$nomorrekening." atas nama ".$namapemilik."";
				$buykey2 = 
				array(
		        	array(
			          	array('text' => 'Setuju', 'callback_data' => 'setuju'),
	          		),
	        	);

				sendApiKeyboard($chatid,$buykey2,true,$text);
			}
			elseif(empty($nohp2))
			{
				$sql = "update variabel set idbank=$idbank where var_id=$chatid";
				mysqli_query($con,$sql);
				$sql_get_variabel = "select * from variabel where var_id=$chatid";
				$data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
				$hargabarang = $data_variabel['hargabarang2'];
				$nmproduk = $data_variabel['nmproduk'];
				$jumlahpesanan = $data_variabel['jumlahpesanan'];
				$total = $ongkir + $hargabarang;
				$gambar = $data_variabel['gambar'];
				$nama = $data_variabel['nama'];
				$alamat = $data_variabel['alamat'];
				$prov = $data_variabel['namaprov'];
				$total = $data_variabel['total'];
				$kabup = $data_variabel['namakabup'];
				$nohp = $data_variabel['nohp'];
				$ukuran = $data_variabel['ukuran'];
				$sql = "update variabel set messageidbank='$messageid' where var_id=$chatid";
				mysqli_query($con,$sql);

				$namaukuran = ambilnamaukuran($ukuran);
				$idsatuan = ambilidsatuandariukuran($ukuran);
				$namasatuan = ambilnamasatuan($idsatuan);
				
				$text = "Detail transaksi anda yaitu:\nNama Pembeli : ".$nama."\nAlamat Pembeli : ".$alamat."\nNo HP : ".$nohp."\nProvinsi : ".$prov."\nKabupaten : ".$kabup."\nNama Produk : ".$nmproduk."\nJumlah pesanan : ".$jumlahpesanan."\nTotal Harga : ".$total.",00\nUkuran : ".$namaukuran." ".$namasatuan."\nLakukan Transfer pada bank ".$namabank." dengan nomor rekening ini ".$nomorrekening." atas nama ".$namapemilik."";
				$buykey2 = 
				array(
		        	array(
			          	array('text' => 'Setuju', 'callback_data' => 'setuju'),
	          		),
	        	);

				sendApiKeyboard($chatid,$buykey2,true,$text);
			}
		break;

		case $pesan == 'setuju';

			$idorder = rand(1,99999999);
			$sql_get_variabel = "select * from variabel where var_id=$chatid";
			$data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
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
			$ukuran = $data_variabel['ukuran'];
			$ganti = $data_variabel['ganti'];
			$ongkir2 = $data_variabel['ongkir'];
			$nono = $data_variabel['no_ganti'];
			$nonolm = $data_variabel['no_lama'];	

			$sql_ceknama = "select * from konsumen where no_hp='$nono'";
			$data_ceknama = mysqli_fetch_assoc(mysqli_query($con,$sql_ceknama));
			$adanama = $data_ceknama['nama_konsumen'];
			$idkonsumen = $data_ceknama['id_konsumen'];
			$ongkir = $data_ceknama['ongkir'];

			if(empty($nono))
			{	
				$sql3 = "INSERT INTO `konsumen`(`id_konsumen`, `id_order`, `nama_konsumen`, `alamat_konsumen`, `provinsi`, `kabupaten`, `id_telegram`,`no_hp`,`ongkir`) VALUES (Null,$idorder,'$nama','$alamat','$prov','$kabup',Null,'$nohp',$ongkir2)";
				$result3 = mysqli_query($con,$sql3);

				$sql_id_kons = "select * from konsumen where nama_konsumen='$nama' && no_hp='$nohp'";
				$data_cekid = mysqli_fetch_assoc(mysqli_query($con,$sql_id_kons));
				$idkonsumen9 = $data_cekid['id_konsumen'];

				$sql = "INSERT INTO `order`(`id_order`, `id_sub_produk`, `id_ukuran`,`id_konsumen`, `id_bank`,`tanggal_orderan`,`status_pemesanan`,`no_resi`) VALUES ($idorder,$idproduk2,$ukuran,$idkonsumen9,$idbank,CURRENT_TIMESTAMP,'Belum Dikonfirmasi',Null)";
				$result = mysqli_query($con,$sql);
				
				print_r("\n\n".$sql."");
				$sql2 = "INSERT INTO `detail_order`(`id_order`,`kuantitas`,`total`) VALUES ($idorder,$jumlahpesanan,$total)";
				$result2 = mysqli_query($con,$sql2);
				$sql4 = "UPDATE `sub_produk` SET `jumlah_sub_produk`= jumlah_sub_produk - $jumlahpesanan WHERE id_sub_produk=$idproduk2";
				$result4 = mysqli_query($con,$sql4);
				print_r($sql4);
				$text = "Terima Kasih telah melakukan pemesanan di Toko Aneka Sutra\n\nSegera lakukan pembayaran ke nomor rekening tujuan dengan menyertakan Kode Pemesanan '$idorder'\n\nSetelah itu lakukan Konfirmasi pesanan pada 🔙 Main Menu dengan menekan tombol Konfirmasi Pesanan";
				sendApiKeyboard($chatid,$mainmenu,false,$text);
				deleteApiMsg($chatid,$messageidkab);
				deleteApiMsg($chatid,$messageidprov);
				deleteApiMsg($chatid,$messageidprov1);
				deleteApiMsg($chatid,$messageidprov2);
				deleteApiMsg($chatid,$messageidprov3);
				deleteApiMsg($chatid,$messageidbankk);
				deleteApiMsg($chatid,$messageidpesanann);
			}
			elseif (!empty($nono) && $ganti == 1) {
				$sql = "INSERT INTO `order`(`id_order`, `id_sub_produk`, `id_ukuran`,`id_konsumen`, `id_bank`,`tanggal_orderan`,`status_pemesanan`,`no_resi`) VALUES ($idorder,$idproduk2,$ukuran,$idkonsumen,$idbank,CURRENT_TIMESTAMP,'Belum Dikonfirmasi',Null)";
				$result = mysqli_query($con,$sql);
				print_r("\n\n".$sql."");
				$sql2 = "INSERT INTO `detail_order`(`id_detail`,`id_order`,`kuantitas`,`total`) VALUES (NULL,$idorder,$jumlahpesanan,$total)";
				$result2 = mysqli_query($con,$sql2);
				print_r("\n\n".$sql2."");
				$sql4 = "UPDATE `sub_produk` SET `jumlah_sub_produk`= jumlah_sub_produk - $jumlahpesanan WHERE id_sub_produk=$idproduk2";
				$result4 = mysqli_query($con,$sql4);
				print_r($sql4);
				$text = "Terima Kasih telah melakukan pemesanan di Toko Aneka Sutra\n\nSegera lakukan pembayaran ke nomor rekening tujuan dengan menyertakan Kode Pemesanan '$idorder'\n\nSetelah itu lakukan Konfirmasi pesanan pada 🔙 Main Menu dengan menekan tombol Konfirmasi Pesanan";
				sendApiKeyboard($chatid,$mainmenu,false,$text);
				deleteApiMsg($chatid,$messageidkab);
				deleteApiMsg($chatid,$messageidprov);
				deleteApiMsg($chatid,$messageidprov1);
				deleteApiMsg($chatid,$messageidprov2);
				deleteApiMsg($chatid,$messageidprov3);
				deleteApiMsg($chatid,$messageidbankk);
				deleteApiMsg($chatid,$messageidpesanann);
			}
			elseif (!empty($nono) && $ganti == 2) 
			{
				$sql = "INSERT INTO `order`(`id_order`, `id_sub_produk`, `id_ukuran`,`id_konsumen`, `id_bank`,`tanggal_orderan`,`status_pemesanan`,`no_resi`) VALUES ($idorder,$idproduk2,$ukuran,$idkonsumen,$idbank,CURRENT_TIMESTAMP,'Belum Dikonfirmasi',Null)";
				$result = mysqli_query($con,$sql);
				print_r("\n\n".$sql."");
				$sql2 = "INSERT INTO `detail_order`(`id_detail`,`id_order`,`kuantitas`,`total`) VALUES (NULL,$idorder,$jumlahpesanan,$total)";
				$result2 = mysqli_query($con,$sql2);
				$sql3 = "UPDATE `konsumen` SET `nama_konsumen`='$nama',`alamat_konsumen`='$alamat',`no_hp`='$nohp',`provinsi`='$prov',`kabupaten`='$kabup',`ongkir`=$ongkir2 WHERE `no_hp`='$nonolm'";
				$result3 = mysqli_query($con,$sql3);
				$sql4 = "UPDATE `sub_produk` SET `jumlah_sub_produk`= jumlah_sub_produk - $jumlahpesanan WHERE id_sub_produk=$idproduk2";
				$result4 = mysqli_query($con,$sql4);
				print_r($sql4);
				$text = "Terima Kasih telah melakukan pemesanan di Toko Aneka Sutra\n\nSegera lakukan pembayaran ke nomor rekening tujuan dengan menyertakan Kode Pemesanan '$idorder'\n\nSetelah itu lakukan Konfirmasi pesanan pada 🔙 Main Menu dengan menekan tombol Konfirmasi Pesanan";
				sendApiKeyboard($chatid,$mainmenu,false,$text);
				deleteApiMsg($chatid,$messageidkab);
				deleteApiMsg($chatid,$messageidprov);
				deleteApiMsg($chatid,$messageidprov1);
				deleteApiMsg($chatid,$messageidprov2);
				deleteApiMsg($chatid,$messageidprov3);
				deleteApiMsg($chatid,$messageidbankk);
				deleteApiMsg($chatid,$messageidpesanann);

			}

		break;

		case $pesan == 'Konfirmasi Pesanan';
			$sql = "update status set status='4' where id='$chatid'";
			mysqli_query($con,$sql);
			// sendApiMsg($chatid,$sql);
			$text = "Masukkan kode pemesanan";
			sendApiMsg($chatid,$text);
		break;

        default:
        $sql_get_status = "select * from status where id='$chatid'";
		$data_status = mysqli_fetch_assoc(mysqli_query($con,$sql_get_status));
		$status = $data_status['status'];
		$sql_get_status1 = "select * from variabel where var_id=$chatid";
		$data_status1 = mysqli_fetch_assoc(mysqli_query($con,$sql_get_status1));
		$hargabr = $data_status1['hargabarang'];
        if($status == 1)
        {
			global $con;
        	preg_match('/^(.*)/',$pesan,$hasil);
            $jumlahbrng = $hasil[1];
            print_r($jumlahbrng);
            $hargabarang1 = $jumlahbrng * $hargabr;
			$sql1 = "update variabel set jumlahpesanan=$jumlahbrng, hargabarang2=$hargabarang1 where var_id=$chatid";
			mysqli_query($con,$sql1); 
            $jumlahbrngkredit = $jumlahbrng;
            $jumlahbrngatm = $jumlahbrng;
            $sql_get_status1 = "select * from variabel where var_id='$chatid'";
			$data_status1 = mysqli_fetch_assoc(mysqli_query($con,$sql_get_status1));
			$idproduk2 = $data_status1['idproduk'];

			$sql1 = "SELECT `jumlah_sub_produk` from `sub_produk` where id_sub_produk=$idproduk2";
			$result2 = mysqli_query($con,$sql1);
			$stokbrng = 0;
			if(!empty($result2)){
				$data = mysqli_fetch_assoc($result2);
				$stokbrng = $data['jumlah_sub_produk'];
			}else{

			}
			$output = print_r($fromid, true);
			// sendApiKeyboard($chatid,$kembalijumlah,false,$stokbrng);
			// if($stokbrng > $jumlahbrng){
			// 	sendApiKeyboard($chatid,$kembalijumlah,false,"ada");
			// }else{
			// 	sendApiKeyboard($chatid,$kembalijumlah,false,"habis");
			// }
			file_put_contents('file.log', $output);
             if($stokbrng > $jumlahbrng ) 
			    	{
			    		 $text = "Masukkan Nomor HP Pembeli 👇";
			    		 $sql = "update status set status='8' where id='$chatid'";
						 mysqli_query($con,$sql); 
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
					mysqli_query($con,$sql); 
					$sql1 = "update status set status='3' where id='$chatid'";
					 mysqli_query($con,$sql1); 
			    	$namakredit = $nama;
			    	$namaatm = $nama;
			    	$text = "Masukkan Alamat Pembeli 👇";
			    	sendApiKeyboard($chatid,$kembalinama,false,$text);
				// }
		}
	    elseif($status == 3)
		    {
		    	preg_match('/^(.*)/',$pesan,$hasil);
		    	$alamat = $hasil[1];
		    	print_r($alamat);
		    	$sql = "update variabel set alamat='$alamat' where var_id=$chatid";
				mysqli_query($con,$sql); 

		    	$text = "Lanjutkan dengan menekan tombol Provinsi untuk memilih provinsi tujuan barang";
		    	sendApiKeyboard($chatid,$provinsi,false,$text); 
		    	
		    }
	    elseif($status == 4)
		    {
		    	preg_match('/^(.*)/',$pesan,$hasil);
		    	$idorderkonfirmasi = $hasil[1];
		    	$sql_get_order = "select `id_order` from `order` where `id_order`=$idorderkonfirmasi";
				$data_order = mysqli_fetch_assoc(mysqli_query($con,$sql_get_order));
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
			    	$sql = "UPDATE `variabel` set `idkonf`='$idorderkonfirmasi' WHERE `var_id`='$chatid'";
		   			mysqli_query($con,$sql); 
		   			$sql1 = "update status set status='7' where id='$chatid'";
					 mysqli_query($con,$sql1); 	   			
			    	$text = "Masukkan nomor rekening tujuan 👇";
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
				 mysqli_query($con,$sql1); 	   
		    	$sql_get_status1 = "select * from variabel where var_id=$chatid";
				$data_status1 = mysqli_fetch_assoc(mysqli_query($con,$sql_get_status1));
				$idorderkonfirmasi = $data_status1['idkonf'];
		    	$sql = "UPDATE `konsumen` SET nomor_rekening_konsumen = $rekeningpem WHERE id_order = $idorderkonfirmasi";
				$result = mysqli_query($con,$sql);
				print_r($sql);
		        $text = "Masukkan nomor rekening tujuan 👇";
		        sendApiMsg($chatid,$text);
		    }
	    elseif($status == 7)
		    {
		    	 preg_match('/^(.*)/',$pesan,$hasil);
		    	 global $rekeningtuj,$con;
		         $rekeningtuj = $hasil[1];
		         $sql_get_variabel = "select * from rekening_tujuan where nomor_rekening=$rekeningtuj";
				 $data_variabel = mysqli_fetch_assoc(mysqli_query($con,$sql_get_variabel));
				 $idbank = $data_variabel['id_bank'];
				if(!empty($idbank) && is_numeric($rekeningtuj) )
				{
				 $sql = "update variabel set rekeningtuj='$rekeningtuj' where var_id=$chatid";
				 mysqli_query($con,$sql); 
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

		     	$sql_ceknope = "select no_hp from konsumen where no_hp='$nohp'";
				$data_ceknope = mysqli_fetch_assoc(mysqli_query($con,$sql_ceknope));
				$no_hpbaru = $data_ceknope['no_hp'];

				if($nohp2 = is_numeric($nohp) && $nohp2 >= 11 && empty($no_hpbaru))
				{
					   	$sql = "update variabel set nohp='$nohp' where var_id=$chatid";
						mysqli_query($con,$sql); 
						$sql1 = "update status set status='2' where id='$chatid'";
						mysqli_query($con,$sql1); 
						$text = "Masukkan Nama Pembeli 👇";
			    		sendApiKeyboard($chatid,$kembalinope,false,$text);
			    }
			    elseif($nohp2 = is_numeric($nohp) && !empty($no_hpbaru)) 
			    {
					$konfirmasi = 
					array(
	        			array(
		          			array('text' => 'Ya', 'callback_data' => 'Ya,ganti'),
		          			array('text' => 'Tidak', 'callback_data' => 'Tidak,ganti')
          					),
        			);
					$sql1 = "update variabel set no_ganti='$nohp', no_lama='$nohp' where var_id=$chatid";
					mysqli_query($con,$sql1);  

					$text = "Apakah anda ingin mengganti informasi Nomor Handphone,Nama dan serta Alamat Anda?";
					$text1 = "Jika ingin mengganti, maka tekan tombol 'Ya' dan Jika tidak tekan tombol 'Tidak'";
		    		sendApiKeyboard($chatid,$konfirmasi,true,$text);
		    		sendApiKeyboard($chatid,$kembalinama,false,$text1);   
			    }
				else 
				{
					   $text2 = "Nomor yang anda masukkan salah";
						sendApiMsg($chatid,$text2);
				}
		     	
		     }
		     elseif($status == 9)
		     {
		     	preg_match('/^(.*)/',$pesan,$hasil);
		     	$kodetransaksi = $hasil[1];

		     	$sql_get_order1 = "select * from `order` where `id_order`=$kodetransaksi";
				$data_order1 = mysqli_fetch_assoc(mysqli_query($con,$sql_get_order1));
				$idorder1 = $data_order1['id_order'];
				$idproduk1 = $data_order1['id_produk'];
				$tglorderan1 = $data_order1['tanggal_orderan'];
				$idkonsumen1 = $data_order1['id_konsumen'];
				$status_pemesanan1 = $data_order1['status_pemesanan'];
				$noresi1 = $data_order1['no_resi'];

				$sql_get_produk1 = "select * from `produk` where `id_produk`=$idproduk1";
				$data_produk1 = mysqli_fetch_assoc(mysqli_query($con,$sql_get_produk1));
				$linkgambar = $data_produk1['images'];
				$namaproduk1 = $data_produk1['nama_produk'];

				$sql_get_konsumen1 = "select * from `konsumen` where `id_konsumen`=$idkonsumen1";
				$data_konsumen1 = mysqli_fetch_assoc(mysqli_query($con,$sql_get_konsumen1));
				$nama_konsumen1 = $data_konsumen1['nama_konsumen'];
				$alamat_konsumen1 = $data_konsumen1['alamat_konsumen'];
				$kabupaten1 = $data_konsumen1['kabupaten'];
				$provinsi1 = $data_konsumen1['provinsi'];
				$no_hp1 = $data_konsumen1['no_hp'];

				$sql_get_detail1 = "select * from `detail_order` where `id_order`=$kodetransaksi";
				$data_detail1 = mysqli_fetch_assoc(mysqli_query($con,$sql_get_detail1));
				$kuantitas1 = $data_detail1['kuantitas'];
				$total1 = $data_detail1['total'];
			
				if(!empty($idorder1))
				{

				sendApiPhotoInfo($chatid,$linkgambar);
				$text = "Detail transaksi anda yaitu:\nNama Pembeli : ".$nama_konsumen1."\nAlamat Pembeli : ".$alamat_konsumen1."\nNo HP : ".$no_hp1."\nProvinsi : ".$provinsi1."\nKabupaten : ".$kabupaten1."\nNama Produk : ".$namaproduk1."\nJumlah pesanan : ".$kuantitas1."\nTotal Harga : ".$total1.",00\n\nStatus Pemesanan : ".$status_pemesanan1."\nNomor Resi JNE : ".$noresi1."";
				
				sendApiKeyboard($chatid,$mainmenu,false,$text);	
				}
				elseif(empty($idorder1))
				{
					$text = "Nomor Transaksi Yang Anda Masukkan Salah";	
					sendApiKeyboard($chatid,$mainmenu,false,$text);
				}
		     }
		     elseif ($status == 10) 
		     {
		     	preg_match('/^(.*)/',$pesan,$hasil);
		     	$nohp = $hasil[1];
		     	$nohp2 = strlen("$nohp");

		     	$sql = "select no_hp from konsumen where no_hp='$nohp'";
		     	$data = mysqli_fetch_assoc(mysqli_query($con,$sql));
		     	$nope = $data['no_hp'];

		     	$sql_get_status1 = "select * from variabel where var_id='$chatid'";
				$data_status1 = mysqli_fetch_assoc(mysqli_query($con,$sql_get_status1));
				$ganti = $data_status1['ganti'];

				
				if(!empty($nope))
				{
					$text = "Nomor HP yang anda masukkan telah terdaftar";
					sendApiMsg($chatid,$text);
				}
				elseif($nohp2 = is_numeric($nohp) && $nohp2 >= 11 && $ganti = 2) 
				{
						$sql = "update variabel set nohp='$nohp' where var_id=$chatid";
						mysqli_query($con,$sql); 
						$sql1 = "update status set status='2' where id='$chatid'";
						mysqli_query($con,$sql1); 
						$text = "Masukkan Nama Pembeli 👇";
			    		sendApiKeyboard($chatid,$kembalinope,false,$text);
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

function cekpilihan($kode,$kiriman=null){
	global $tabel,$con;
	$tabeln = $tabel[$kode];
	$sql = "select id_produk, nama_produk from produk where kategori_produk='$kiriman'";
	$result = mysqli_query($con,$sql);
	print_r($result);
	$arrnama = array();
	$arrid = array();
	$arr = [];
	if (mysqli_num_rows($result) > 0) {
    // output data of each row
	$i=0;
     while($row = mysqli_fetch_array($result)) {
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
	global $con;
	$sql = "select images from sub_produk where nama_sub_produk='$kiriman'";
	$result = mysqli_query($con,$sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$inpilihangambar = $data['images'];
		return $inpilihangambar;
	}
}

function ambilidsub($kiriman=null){
	global $con;
	$sql = "select id_sub_produk from sub_produk where nama_sub_produk='$kiriman'";
	$result = mysqli_query($con,$sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$idsub = $data['id_sub_produk'];
		return $idsub;
	}
}

function ambilidukuran($kiriman=null){
	global $con;
	$sql = "select id_ukuran from ukuran where ukuran='$kiriman'";
	$result = mysqli_query($con,$sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$idukuran = $data['id_ukuran'];
		return $idukuran;
	}
}

function ambilnamaukuran($kiriman=null){
	global $con;
	$sql = "select ukuran from ukuran where id_ukuran=$kiriman";
	$result = mysqli_query($con,$sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$namaukuran = $data['ukuran'];
		return $namaukuran;
	}
}

function ambilnamasatuan($kiriman=null){
	global $con;
	$sql = "select satuan from satuan where id_satuan=$kiriman";
	$result = mysqli_query($con,$sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$namasatuan = $data['satuan'];
		return $namasatuan;
	}
}


function ambilidsatuandariukuran($kiriman=null){
	global $con;
	$sql = "select id_satuan from ukuran where id_ukuran=$kiriman";
	$result = mysqli_query($con,$sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$idsatuan = $data['id_satuan'];
		return $idsatuan;
	}
}

function ambilnamabarang($kiriman=null){
	global $con;
	$sql = "select nama_sub_produk from sub_produk where nama_sub_produk='$kiriman'";
	$result = mysqli_query($con,$sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$inpilihannamaproduk = $data['nama_sub_produk'];
		return $inpilihannamaproduk;
	}

}

function ambilid($kiriman=null){
	global $con;
	$sql = "select id_sub_produk from sub_produk where nama_sub_produk='$kiriman'";
	$result = mysqli_query($con,$sql);
	print_r($result);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$inpilihanidprodukk = $data['id_sub_produk'];
		print_r($inpilihanidprodukk);
		return $inpilihanidprodukk;
	}

}

function ambildeskripsibarang($kiriman=null){
	global $con;
	$sql = "select deskripsi_sub_produk from sub_produk where nama_sub_produk='$kiriman'";
	$result = mysqli_query($con,$sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$inpilihandeskripsi = $data['deskripsi_sub_produk'];
		return $inpilihandeskripsi;
	}

}

function ambilhargabarang($kiriman=null){
	global $con;
	$sql = "select harga_sub_produk from sub_produk where nama_sub_produk='$kiriman'";
	$result = mysqli_query($con,$sql);
	if(!empty($result)){
		$data = mysqli_fetch_assoc($result);
		$inpilihanharga = $data['harga_sub_produk'];
		return $inpilihanharga;
	}

}

function ambiljumlah($kiriman){
	global $con;
	$sql1 = "SELECT `jumlah_sub_produk` from `sub_produk` where id_sub_produk=$kiriman";
	$result2 = mysqli_query($con,$sql1);
	if(!empty($result2)){
		$data = mysqli_fetch_assoc($result2);
		$jumlahbaru = $data['jumlah_sub_produk'];
		print_r($jumlahbaru);
		return $data;
	}else{
		return ;
	}
}

function pilihanbank(){
	global $tabel;
	global $con;
	$tabeln = $tabel[$kode];
	$kode2 = "Anda Memilih Bank ";
	$sql = "select `id_bank`, `nama_bank` from `rekening_tujuan` WHERE not id_bank=10";
	$result = mysqli_query($con,$sql);
	print_r($result);
	$arrnama = array();
	$arrid = array();
	$arr = [];
	if (mysqli_num_rows($result) > 0) {
    // output data of each row
	$i=0;
    while($row = mysqli_fetch_array($result)) {
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
	global $con;
	$sql1 = "SELECT `nomor_rekening` from `rekening_tujuan` where nama_bank='$kiriman'";
	$result2 = mysqli_query($con,$sql1);
	print_r("\n\nini adalah ".$result2);
	if(!empty($result2)){
			$data = mysqli_fetch_assoc($result2);
			$nomor = $data['nomor_rekening'];
			print_r($nomor);
			return $nomor;
		}
}

function ambilidbank($kiriman){
	global $con;
	$sql1 = "SELECT `id_bank` from `rekening_tujuan` where nama_bank='$kiriman'";
	$result2 = mysqli_query($con,$sql1);
	print_r("\n\nini adalah ".$result2);
	if(!empty($result2)){
			$data = mysqli_fetch_assoc($result2);
			$idbankk = $data['id_bank'];
			print_r($nomor);
			return $idbankk;
		}
}

function ambilnamapemilik($kiriman){
	global $con;
	$sql1 = "SELECT `nama_pemilik` from `rekening_tujuan` where nama_bank='$kiriman'";
	$result2 = mysqli_query($con,$sql1);
	print_r("\n\nini adalah ".$result2);
	if(!empty($result2)){
			$data = mysqli_fetch_assoc($result2);
			$namapemilik = $data['nama_pemilik'];
			print_r($nomor);
			return $namapemilik;
		}
}

		
