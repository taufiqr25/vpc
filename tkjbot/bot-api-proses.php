<?php
require_once 'bot-api-config.php';
require_once 'bot-api-fungsi.php';
require_once 'bot-api-proses.php';
require_once 'database.php';
$mainkeyboard = array(
        array("Pelaporan","Status Pelaporan"),
        array("FeedBack","Keterangan"),
);
$mainkeyboardstaf = array(
   array("Perbaikan","Informasi"),
); 
$kembali = array(
    array("Kembali"),
 );
 $kembalides = array(
    array("👈🏻Kembali"),
 ); 
 $kembalifoto = array(
    array("👈🏻👈🏻Kembali"),
 ); 
 $kblbtl= array(
    array("Kembali"),
    array("Batal"),
 ); 

 $mainmenu = array(
    array("🔙 Main Menu"),
 ); 


 $mainmenustaf = array(
    array("Main Menu"),
 ); 

 $kembalistaf = array(
    array("👈🏻Kembali👈🏻"),
 ); 
$id_mahasiswa;
$status;
$phonenumberfix;
$lokasi;
$deksripsi;
$idfoto;
$status1;
$token;
$idpelaporan3;
$phonenumber2;

function prosesApiMessage($sumber)
{
    $updateid = $sumber['update_id'];

	//if ($GLOBALS['debug']) mypre($sumber);

    if (isset($sumber['message'])) {
        $message = $sumber['message'];

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

    if (isset($sumber['callback_query'])) {
       prosesCallAnswer($sumber['callback_query']);
    }


    return $updateid;
}
function prosesPesanContact($message){

    global $mainkeyboard;
    global $mainkeyboardstaf;
    global $phonenumberfix;
    global $phonenumber2;
	$chatid = $message['chat']['id'];
	$phone_number = $message['contact']['phone_number'];
	$first_name = $message['chat']['first_name'];
	$phone_number = str_replace(" ","",$phone_number);
	$phone_number = "0".preg_replace('/(?:\+62|62|0)/','', $phone_number,1);
	$urllec ="https://simak.poliupg.ac.id/api/machine/get_pegawai/hp/".$phone_number;
	$rslec = curl_get($urllec);
	$urlstu ="https://simak.poliupg.ac.id/api/machine/get_mahasiswa/hp/".$phone_number;
    $rsstu = curl_get($urlstu);
    $username = '';
    $sqlno_tlp = "SELECT `no_tlp` FROM `staff` WHERE `no_tlp`='$phone_number'";
    $result = mysql_query($sqlno_tlp);
    $data = mysql_fetch_assoc($result);
    $nostaff = $data['no_tlp'];
    // print_r($nomortelepon);
    $phonenumber2 = $phone_number;
    $sql_get_variabel = "select * from variabel where var_id='$chatid'";
    $data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
    $var_id = $data_variabel['var_id'];
    if(empty($var_id))
    {
    $sql1 = "INSERT INTO `variabel`(`var_id`,`phone_number`,`lokasi`,`deskripsi`) VALUES ('$chatid','$phone_number',null,null)";
    mysql_query($sql1);
    }
    elseif(!empty($var_id))
    {
        $sql1 = "UPDATE `variabel` SET `phone_number`='$phone_number' WHERE var_id='$chatid'";
        mysql_query($sql1);
    } 
	elseif(isset($rslec[0]['id_pegawai'])){
	  $nama = $rslec[0]['nama_lengkap_peg'];
	  $nip = $rslec[0]['nip_peg'];
      $text = "Selamat datang di aplikasi pelayanan urusan rumah tangga PNUP.\nPilih menu untuk melanjutkan.\nJika ada yang kurang jelas, silahkan memilih menu Keterangan😊";
      $phonenumberfix = $phone_number;
    
      $username = $nip;
      $tipe = "pegawai";
     sendApiKeyboard($chatid,$mainkeyboard,false,$text);
    
      
    //   print_r($sql);
      $sql1 = "UPDATE `pelaporan` SET `id_pelaporan`= 2 WHERE `id_pelaporan`=1";
      mysql_query($sql1);
	// sendApiKeyboard($chatid,$mainkeyboard,false,$text);
	}
	elseif(isset($rsstu[0]['id_mhs'])){
        $id_mahasiswa = $rsstu[0]['id_mhs'];
	  $nama = $rsstu[0]['nama_lengkap'];
      $nim = $rsstu[0]['nim'];
      print_r($rsstu);
      $username = $nim;
      $phonenumberfix = $phone_number;
      $tipe = "mahasiswa";
	  $text = "Selamat datang di aplikasi pelayanan urusan rumah tangga PNUP.\nPilih menu untuk melanjutkan.\nJika ada yang kurang jelas, silahkan memilih menu Keterangan😊";
	 sendApiKeyboard($chatid,$mainkeyboard,false,$text);
    }
    elseif(!empty($nostaff))
    {
        print_r($chatid);
        $sql1 = "UPDATE `staff` SET `chatid`= '$chatid' WHERE `no_tlp`='$phone_number'";
        mysql_query($sql1);
        print_r($sql1);
        $text4 = "Selamat datang pada pelaporan rumah tangga";
        sendApiKeyboard($chatid,$mainkeyboardstaf,false,$text4);
    }
    else
    {
        sendApiMsg($chatid,"Nomor anda tidak terdaftar pada sistem pelaporan ini.");
    }

    // if ($username) {
    //     sendApiMsg($chatid, $username);
    // }else {
    //     sendApiMsg($chatid, "mdada agan");
    // }
    

}


function prosesPesanSticker($message)
{
    // if ($GLOBALS['debug']) mypre($message);
}

function prosesCallBackQuery($message)
{
    // if ($GLOBALS['debug']) mypre($message);

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
    $message_id = $message['message']['message_id'];
    $chatid = $message['message']['chat']['id'];
    $inlinetext = $message['message']['text'];
    $data = $message['data'];   //S30:A/S41:B
    sendApiMsg($chatid, $data, $message_id, 'HTML');
    $messageupdate = $message['message'];
    $messageupdate['text'] = $data;
    prosesPesanTeks($messageupdate);
}

function prosesPesanDocument($message){
	$chatid = $message['chat']['id'];
	$doctype = $message['document']['mime_type'];
	$fileid = $message['document']['file_id'];
	$text = "Doc Info - Id $fileid, type: $doctype";
	sendApiMsg($chatid, $text);
}


function prosesPesanPhoto($message){
    global $status,$fileid,$status1;
    global $idfoto,$fileidfoto;
    global $fotopelaporan;
    global $lokasi, $deskripsi,$phonenumberfix;
    global $idpelaporan,$token,$idpelaporan3;
    global $mainmenu;
    $chatid = $message['chat']['id'];
    $messageid = $message['message_id'];
    $first_name = $message['chat']['first_name'];
    /* Get file info */
    $fileid = $message['photo'][3]['file_id'];
    try{
        move_uploaded_file($message['photo'][3]['tmp_name'], 'gambar/test.jpg');
    }catch(Exception $e){
        echo "error";
    }
    // $filepath = $message['photo'][1]['file_path'];
    // print_r($filepath);
    $filesize = $message['photo'][3]['file_size'];
    $width = $message['photo'][3]['width'];
    $height = $message['photo'][3]['height'];
    // $ukuran = getSize($filesize);
    $text = "Photo Info - id $fileid, dimension: $width x $height, file size: $ukuran";
    // $text2 = "Terimakasih! Pelaporan Anda Akan Segera di proses";
    // sendApiMsg($chatid,$text2);
    $fileidfoto = $fileid;
    print_r($status1);
    getFile($fileid);
    print_r($idfoto);
    print_r($status1);

    $sql_get_status1 = "select * from status1 where id='$chatid'";
    $data_status1 = mysql_fetch_assoc(mysql_query($sql_get_status1));
    $status1 = $data_status1['status1'];

    if($status1==10 && !empty($idfoto))
    {
        $sql_get_variabel = "select * from variabel where var_id='$chatid'";
        $data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
        $variabellokasi = $data_variabel['lokasi'];
        $variabeldeskripsi = $data_variabel['deskripsi'];
        $variabelnomor = $data_variabel['phone_number'];
        $fotopelaporan=$fileidfoto;
        $tgl = date('Y-m-d h:i:s');
        $imgurl = 'https://api.telegram.org/file/bot474404576:AAFQNbT4ijjpzY9DhUEExnrOqDheckNROk8/'.$idfoto.'';
        $namatambahan = "".$idfoto."+".$chatid."";  
        $namatambahanfix = md5($namatambahan);
        $namatambahanfix2 = "".$namatambahanfix.".jpg"; 
        $imagename= basename($imgurl);
        $image = file_get_contents($imgurl); 
        
        file_put_contents('gambar/'.$namatambahanfix2,$image);
        // $idfotofix = 'https://yunira.tatkj.poliupg.ac.id/pnup1/gambar/'.$imagename.'';
        // $sql_insert = "INSERT INTO `db_sistem_pelaporan`.`pelaporan` (`id_pelaporan`, `id_user`, `username`, `no_tlp`, `tgl_pelaporan`, `deskripsi_kerusakan`, `status_pelaporan`, `lokasi_kerusakan`, `gambar_kerusakan`,`chatid_staf`,`gambar_hasil_perbaikan`) 
        // VALUES (NULL, '$chatid','$first_name','$variabelnomor', $variabeltanggal, '$variabeldeskripsi', 'Belum Dikerjakan', '$variabellokasi', '$idfotofix', NULL,NULL)";
        // mysql_query($sql_insert) or die(mysql_error());

        $sql_select = "SELECT * FROM `pelaporan` WHERE `deskripsi_kerusakan`='$variabeldeskripsi' AND `lokasi_kerusakan`='$variabellokasi'";
        $result = mysql_query($sql_select);
        $data = mysql_fetch_assoc($result);
        $idpelaporanfix = $data['id_pelaporan'];
        $deskripsi = $data['deskripsi_kerusakan'];
        $lokasi = $data['lokasi_kerusakan'];
        $variabeltanggal = CURRENT_TIMESTAMP;

        if(!empty($idpelaporanfix) && !empty($deskripsi) && !empty($lokasi))
	        {
	        	$text3 = "Sudah ada laporan yang sama\nSilahkan kembali ke menu utama";
	        	sendApiKeyboard($chatid,$mainmenu,false,$text3);
	        	$sql_delete1="DELETE FROM `variabel` WHERE `var_id`='$chatid'";
	       		$result1 = mysql_query($sql_delete1);
	        	print_r($idpelaporanfix);
	        	$sqldelete = "DELETE FROM `status` WHERE `id`='$chatid'";
	        	mysql_query($sqldelete);
	        }
        elseif (empty($idpelaporanfix)) 
        {
        	$idfotofix = 'https://yunira.tatkj.poliupg.ac.id/pnup1/gambar/'.$namatambahanfix2.'';
	        $sql_insert = "INSERT INTO `db_sistem_pelaporan`.`pelaporan` (`id_pelaporan`, `id_user`, `username`, `no_tlp`, `tgl_pelaporan`, `deskripsi_kerusakan`, `status_pelaporan`, `lokasi_kerusakan`, `gambar_kerusakan`,`chatid_staf`,`gambar_hasil_perbaikan`) 
	        VALUES (NULL, '$chatid','$first_name','$variabelnomor', $variabeltanggal, '$variabeldeskripsi', 'Belum Dikerjakan', '$variabellokasi', '$idfotofix', NULL,NULL)";
	        mysql_query($sql_insert) or die(mysql_error());
	        $sql_select1 = "SELECT `id_pelaporan` FROM `pelaporan` WHERE `deskripsi_kerusakan`='$variabeldeskripsi' AND `lokasi_kerusakan`='$variabellokasi'";
       		$result1 = mysql_query($sql_select1);
        	$data1 = mysql_fetch_assoc($result1);
        	$idpelaporanfix1 = $data1['id_pelaporan'];
	         $text = "Terima Kasih Atas Pelaporan Anda\nSegera Kami Tindak Lanjuti\n\nID pelaporan anda yaitu ".$idpelaporanfix1."\n\nGunakan ID Pelaporan untuk mengecek status pelaporan dan memberikan FeedBack ketika pelaporan anda selesai diproses";
        $text2 = "".$variabeltanggal."".$variabeldeskripsi."".$variabellokasi."";
        sendApiKeyboard($chatid,$mainmenu,false,$text);
        	$sql_delete="DELETE FROM `variabel` WHERE `var_id`='$chatid'";
        $result1 = mysql_query($sql_delete);
        print_r($idpelaporanfix);
        $sqldelete = "DELETE FROM `status` WHERE `id`='$chatid'";
        mysql_query($sqldelete);
        }

       

        // $sql_select = "SELECT `id_pelaporan` FROM `pelaporan` WHERE `deskripsi_kerusakan`='$variabeldeskripsi'";
        // $result = mysql_query($sql_select);
        // $data = mysql_fetch_assoc($result);
        // $idpelaporanfix = $data['id_pelaporan'];
        
        // $text = "Terima Kasih Atas Pelaporan Anda\nSegera Kami Tindak Lanjuti\n\nID pelaporan anda yaitu ".$idpelaporanfix."\n\nGunakan ID Pelaporan untuk mengecek status pelaporan dan memberikan FeedBack ketika pelaporan anda selesai diproses";
        // $text2 = "abc".$variabelnomor."".$variabeldeskripsi."".$variabellokasi."";

        
        // $konfirmasi = 
        //     array(
        //         array(
        //             array('text' => 'Terima', 'callback_data' => 'y'),
        //             array('text' => 'Tidak', 'callback_data' => 'tidak')
        //         ),
        //     );
   
    }

    elseif($status1==11 && !empty($idfoto))
    {
        $sql_get_variabel = "select * from variabel where var_id='$chatid'";
        $data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
        $variabelidpelperbaikan = $data_variabel['idpelperbaikan'];
        $deskripsi2 =  $data_variabel['deskripsi_perbaikan'];
        $imgurl = 'https://api.telegram.org/file/bot474404576:AAFQNbT4ijjpzY9DhUEExnrOqDheckNROk8/'.$idfoto.'';  
              
        $idrandom = rand(1,999);
        $namatambahan = "".$idfoto."+".$chatid."".$idrandom."";  
        $namatambahanfix3 = md5($namatambahan);
        $namatambahanfix4 = "".$namatambahanfix3.".jpg"; 
        $imagename= basename($imgurl);
        $image = file_get_contents($imgurl); 
        file_put_contents('gambar/'.$namatambahanfix4,$image);
        $idfotofix2 = 'https://yunira.tatkj.poliupg.ac.id/pnup1/gambar/'.$namatambahanfix4.'';



        $sql_insert2 = "UPDATE `pelaporan` SET `status_pelaporan`='Telah Dikerjakan',`gambar_hasil_perbaikan`='$idfotofix2',`deskripsi_perbaikan`='$deskripsi2' WHERE `id_pelaporan`=$variabelidpelperbaikan";
        mysql_query($sql_insert2) or die(mysql_error()) ;
        $text2 = "Terima Kasih telah mengerjakan";
        $sqldelete = "DELETE FROM `status` WHERE `id`='$chatid'";
        mysql_query($sqldelete); 
        sendApiMsg($chatid,$text2);
    }
    else
         {
            $text3 = "Pengiriman Gagal";
            sendApiMsg($chatid,$text3);
        }
    /**/

    //deleteApiMsg($chatid,$messageid);
}

function prosesPesanTeks($message)
{
    // if ($GLOBALS['debug']) mypre($message);

    $pesan = $message['text'];
    $chatid = $message['chat']['id'];
	$first_name = $message['chat']['first_name'];
    $fromid = $message['from']['id'];
    $messageid = $message['message_id'];
    $phone_number = $message['contact']['phone_number'];
    global $status;
    global $status1;
    global $phonenumberfix;
    global $lokasi,$deskripsi;
    global $idpelaporan3;
    global $phonenumber2;
    global $mainkeyboard,$mainmenu,$mainmenustaf;
    global $idpelaporan2,$kembali,$kembalides,$kembalifoto,$kembalistaf;
    global $mainkeyboardstaf;
   
    switch (true) {
		case $pesan == '/start':
            print_r($phone_number);
             $contactkeyboard = array( 
                array(
                    array('text' => 'Login','request_contact' => true),
                ),
                
            );
            sendApiKeyboard($chatid,$contactkeyboard,false,"sharecontact");
            print_r($chatid);
		    break;

        case $pesan == 'Pelaporan':
            $text="Masukkan Lokasi kerusakan 👇";
            // $status=1;
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
            sendApiKeyboard($chatid,$kembali,false,$text);
            break;
        case $pesan == 'Keterangan':
            $text="BOT Sistem pelaporan pada urusan rumah tangga PNUP dapat membantu civitas akademik agar dapat melaporkan kerusakan fasilitas umum serta membantu pelayanan urusan rumah tangga PNUP, BOT ini memiliki menu pelaporan, status pelaporan, feedback serta keterangan.\n- Menu pelaporan untuk mengirimkan laporan kerusakan dengan memasukkan lokasi kerusakan, deskripsi kerusakan serta bukti gambar kerusakan 😊 \n- Menu status pelaporan dapat melakukan pengecekan status pelaporan 😊 \n- Menu feedback untuk memberikan penilaian atas respon dari staf rumah tangga PNUP 😊";

            sendApikeyboard($chatid,$kembali,false,$text);
            break;
        case $pesan == 'Kembali':
            $text="Silahkan Memilih Menu Untuk Pelaporan lagi";
            sendApiKeyboard($chatid,$mainkeyboard,false,$text);
            $sql = "DELETE FROM `status` WHERE `id`='$chatid'";
            mysql_query($sql);
            break;
        case $pesan == '👈🏻Kembali':
            $text="Masukkan Lokasi kerusakan 👇";
            // $status=1;
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
            sendApiKeyboard($chatid,$kembali,false,$text);
            break;

        case $pesan == '👈🏻👈🏻Kembali':
            $text="Deskripsikan kerusakan ";
            // $status=2;
             $sql_get_status = "select * from status where id='$chatid'";
            $data_status = mysql_fetch_assoc(mysql_query($sql_get_status));
            $idchat = $data_status['id'];
            if(empty($idchat))
            {
                $sql = "INSERT INTO `status`(`id`,`status`) VALUES ('$chatid','2')";
                mysql_query($sql);  
            }
            elseif(!empty($idchat))
            {
                 $sql3 = "update status set status='2' where id='$chatid'";
                 mysql_query($sql3); 
            }
            sendApikeyboard($chatid,$kembalides,false,$text);
            break;

        case $pesan == '🔙 Main Menu':
            $text = "Silahkan Kembali Memilih Menu Yang Diinginkan 👇";
            sendApiKeyboard($chatid,$mainkeyboard,false,$text);
             $sqldelete = "DELETE FROM `status` WHERE `id`='$chatid'";
             mysql_query($sqldelete);
            break;

        case $pesan == 'y':
        $sql = "UPDATE `pelaporan` SET status = 'dikerjakan' WHERE id_pelaporan=$idpelaporan";
        $result = mysql_query($sql);
        break;

        case $pesan == 'Status Pelaporan':
            $text = "Masukkan id pelaporan 👇";
            // $status = 3;
            $sql_get_status = "select * from status where id='$chatid'";
            $data_status = mysql_fetch_assoc(mysql_query($sql_get_status));
            $idchat = $data_status['id'];
            if(empty($idchat))
            {
                $sql = "INSERT INTO `status`(`id`,`status`) VALUES ('$chatid','3')";
                mysql_query($sql);  
            }
            elseif(!empty($idchat))
            {
                 $sql3 = "update status set status='3' where id='$chatid'";
                 mysql_query($sql3); 
            }
            sendApiKeyboard($chatid,$kembali,false,$text);

            break;

        case $pesan == 'FeedBack':
            $text = "Masukkan id pelaporan 👇";
            // $status = 4;
            $sql_get_status = "select * from status where id='$chatid'";
            $data_status = mysql_fetch_assoc(mysql_query($sql_get_status));
            $idchat = $data_status['id'];
            if(empty($idchat))
            {
                $sql = "INSERT INTO `status`(`id`,`status`) VALUES ('$chatid','4')";
                mysql_query($sql);  
            }
            elseif(!empty($idchat))
            {
                 $sql3 = "update status set status='4' where id='$chatid'";
                 mysql_query($sql3); 
            }
            sendApiKeyboard($chatid,$mainmenu,false,$text);

            break;

        case $pesan == 'Pelaporan Masuk':
            $inpilihan = cekpilihan("ID Pelaporan yang masuk untuk anda ",$phonenumber2);
            print_r($phonenumber2);
            $text = "Tolong segera diproses";
            sendApiKeyboard($chatid, $inpilihan, true, $text);

           
            break;

        case preg_match("/ID Pelaporan yang masuk untuk anda (.*)/", $pesan, $hasil):
            $idpelaporan = $hasil[1];
            $idpelaporan3 = $idpelaporan;
            $inpilihandeskripsi = ambildeskripsi($idpelaporan);
            $inpilihanlokasi = ambillokasi($idpelaporan);
            $inpilihanstatus = ambilstatus($idpelaporan);
            $inpilihangambar = ambilgambar($idpelaporan);
            $inpilihantanggal = ambiltanggal($idpelaporan);
            print_r("\n\n".$inpilihandeskripsi."");
            print_r("\n\n".$inpilihanlokasi."");
            print_r("\n\n".$inpilihanstatus."");
            print_r("\n\n".$inpilihangambar."");
            print_r("\n\n".$inpilihantanggal."");

            $konfirmasi = 
            array(
                array(
                    array('text' => 'Dikerjakan', 'callback_data' => 'Laporan yang diterima dengan ID '.$idpelaporan),
                    array('text' => 'Ditolak', 'callback_data' => 'tolak')
                ),
            );

            $text = "Resi Pelaporan ".$idpelaporan."\n\nLokasi : ".$inpilihanlokasi."\nDeskripsi Pelaporan : ".$inpilihandeskripsi."\nStatus Pelaporan : ".$inpilihanstatus."\nTanggal Pelaporan : ".$inpilihantanggal."";

            $caption = "Foto Pelaporan dengan ID Pelaporan ".$idpelaporan."";

            sendApiPhoto($chatid,$inpilihangambar,$caption);
            sendApiKeyboard($chatid,$konfirmasi,true,$text);

        break;

        case preg_match("/Laporan yang diterima dengan ID (.*)/", $pesan, $hasil):
             $idpelaporan4 = $hasil[1];

             $sql = "UPDATE `pelaporan` SET `status_pelaporan` = 'dikerjakan' WHERE `id_pelaporan`=$idpelaporan4";
             $result = mysql_query($sql);

             print_r($sql);
             $text = "Pelaporan diterima";
             sendApiMsg($chatid,$text);

        break;

        case $pesan == 'Perbaikan':
            $text = "Masukkan ID Pelaporan yang telah dikerjakan 👇";
            sendApiKeyboard($chatid,$kembalistaf,false,$text);
            $sql_get_status = "select * from status where id='$chatid'";
            $data_status = mysql_fetch_assoc(mysql_query($sql_get_status));
            $idchat = $data_status['id'];
            if(empty($idchat))
            {
                $sql = "INSERT INTO `status`(`id`,`status`) VALUES ('$chatid','5')";
                mysql_query($sql);  
            }
            elseif(!empty($idchat))
            {
                 $sql3 = "update status set status='5' where id='$chatid'";
                 mysql_query($sql3); 
            }

            break;

        case $pesan == '👈🏻Kembali👈🏻':
            $text = "Silahkan Pilih Menu";

            sendApiKeyboard($chatid,$mainkeyboardstaf,false,$text);
            break;
         case $pesan == 'Informasi':
             $text = " Bot telegram dengan username @Sistem_Pelaporan_PNUP_bot berguna sebagai perantara antara staf rumah tangga PNUP dengan para staf,dosen dan mahasiswa yang akan melakukakn pelaporan kerusakan fasilitas umum, Bot ini memiliki dua menu pelaporan: \n-Menu Perbaikan, dapat membantu mengirimkan hasil perbaikan dengan memasukkan id pelaporan, deskripsi pelaporan serta gambar hasil perbaikan.\n-Menu Informasi, dapat memberikan informasi tentang bot sistem pelaporan 😊";

             sendApiMsg($chatid,$text);
             break;
        case preg_match("/Anda Memilih Bintang (.*)/", $pesan, $hasil):
            $bintanghasil = $hasil[1];
            $sql_get_variabel = "select * from variabel where var_id='$chatid'";
            $data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
            $idpelaporan2 = $data_variabel['idpelfeedback'];
            $sql = "INSERT INTO `feedback`(`id_feedback`, `id_pelaporan`, `penilaian`) VALUES (null,$idpelaporan2,$bintanghasil)";
            $result = mysql_query($sql);
            $text = "Terima Kasih Telah Memberikan Penilaian";
            sendApiKeyboard($chatid,$mainmenu,false,$text);
            deleteApiMsg($chatid,$messageid);


             break;

            default:
            $sql_get_status = "select * from status where id='$chatid'";
            $data_status = mysql_fetch_assoc(mysql_query($sql_get_status));
            $status = $data_status['status'];
            $sql_get_variabel = "select * from variabel where var_id='$chatid'";
            $data_variabel = mysql_fetch_assoc(mysql_query($sql_get_variabel));
            $var_id = $data_variabel['var_id'];

            if($status==1)
            {
                preg_match('/^(.*)/',$pesan,$hasil);
                $lokasi = $hasil[1];
                $text="Deskripsikan kerusakan ";
                $sql_get_status = "select * from status where id='$chatid'";
                $data_status = mysql_fetch_assoc(mysql_query($sql_get_status));
                $idchat = $data_status['id'];
            if(empty($idchat) && empty($var_id))
            {
                $sql = "INSERT INTO `status`(`id`,`status`) VALUES ('$chatid','2')";
                mysql_query($sql);
                $sql1 = "INSERT INTO `variabel`(`var_id`, `lokasi`) VALUES ('$chatid','$lokasi')";
                mysql_query($sql1); 
                sendApikeyboard($chatid,$kembalides,false,$text);
            }
            elseif(!empty($idchat) && empty($var_id))
            {
                 $sql3 = "update status set status='2' where id='$chatid'";
                 mysql_query($sql3); 
                $sql1 = "INSERT INTO `variabel`(`var_id`, `lokasi`) VALUES ('$chatid','$lokasi')";
                mysql_query($sql1); 
                sendApikeyboard($chatid,$kembalides,false,$text);
            }
            elseif (empty($idchat) && !empty($var_id))
            {
                $sql = "INSERT INTO `status`(`id`,`status`) VALUES ('$chatid','2')";
                mysql_query($sql);
                $sql1 = "UPDATE `variabel` SET `lokasi`='$lokasi' WHERE var_id='$chatid'";
                mysql_query($sql1);
                sendApikeyboard($chatid,$kembalides,false,$text);
            }
            elseif (!empty($idchat) && !empty($var_id))
            {
                $sql3 = "update status set status='2' where id='$chatid'";
                 mysql_query($sql3);
                  $sql1 = "UPDATE `variabel` SET `lokasi`='$lokasi' WHERE var_id='$chatid'";
                mysql_query($sql1);
                sendApikeyboard($chatid,$kembalides,false,$text);
            }
            }
            elseif($status==2)
            {
                preg_match('/^(.*)/',$pesan,$hasil);
                $deskripsi = $hasil[1];
                $sql_get_status1 = "select * from status1 where id='$chatid'";
                $data_status1 = mysql_fetch_assoc(mysql_query($sql_get_status1));
                $idchat = $data_status1['id'];
                $text="kirimkan foto kerusakan";
            if(empty($idchat) && empty($var_id))
            {
                $sql = "INSERT INTO `status1`(`id`,`status1`) VALUES ('$chatid','10')";
                mysql_query($sql);
                $sql1 = "INSERT INTO `variabel`(`var_id`, `lokasi`,`deskripsi`) VALUES ('$chatid',null,'$deskripsi')";
                mysql_query($sql1); 
                sendApikeyboard($chatid,$kembalifoto,false,$text);
            }
            elseif(!empty($idchat) && empty($var_id))
            {
                 $sql3 = "update status1 set status1='10' where id='$chatid'";
                 mysql_query($sql3); 
               $sql1 = "INSERT INTO `variabel`(`var_id`, `lokasi`,`deskripsi`) VALUES ('$chatid',null,'$deskripsi')";
                mysql_query($sql1); 
                sendApikeyboard($chatid,$kembalifoto,false,$text);
            }
            elseif (empty($idchat) && !empty($var_id))
            {
                $sql = "INSERT INTO `status1`(`id`,`status1`) VALUES ('$chatid','10')";
                mysql_query($sql);
                $sql1 = "UPDATE `variabel` SET `deskripsi`='$deskripsi' WHERE var_id='$chatid'";
                mysql_query($sql1);
               sendApikeyboard($chatid,$kembalifoto,false,$text);
            }
            elseif (!empty($idchat) && !empty($var_id))
            {
                $sql3 = "update status1 set status1='10' where id='$chatid'";
                 mysql_query($sql3);
                  $sql1 = "UPDATE `variabel` SET `deskripsi`='$deskripsi' WHERE var_id='$chatid'";
                mysql_query($sql1);
                sendApikeyboard($chatid,$kembalifoto,false,$text);
            }
               
            }
            elseif($status==3)
            {
                preg_match('/^(.*)/',$pesan,$hasil);
                $idpelaporan1 = $hasil[1];
                $sql3 = "SELECT `gambar_hasil_perbaikan` FROM `pelaporan` WHERE `id_pelaporan`=$idpelaporan1";
                $result3 = mysql_query($sql3);
                $data3 = mysql_fetch_assoc($result3);
                $gambarperbaikan2 = $data3['gambar_hasil_perbaikan'];
                $sql4 = "SELECT `id_feedback` FROM `feedback` WHERE `id_pelaporan`=$idpelaporan1";
                $result4 = mysql_query($sql4);
                $data4 = mysql_fetch_assoc($result4);
                $idfeedback3 = $data4['id_feedback'];

                if(!empty($gambarperbaikan2) && empty($var_id) && empty($idfeedback3) )
                {
                    print_r($idpelaporan1);
                    $sql4 = "SELECT `username`,`no_tlp`,`tgl_pelaporan`,`deskripsi_kerusakan`,`status_pelaporan`,`lokasi_kerusakan`,`gambar_hasil_perbaikan` FROM `pelaporan` WHERE `id_pelaporan`=$idpelaporan1";
                    // mysql_query($sql4) or die(mysql_error()) ;
                     $result4 = mysql_query($sql4);
                     $data4 = mysql_fetch_assoc($result4);
                     $username2 = $data4['username'];
                     $nomortelepon2 = $data4['no_tlp'];
                     $tglpelaporan2 = $data4['tgl_pelaporan'];
                     $deskripsi2 = $data4['deskripsi_kerusakan'];
                     $status2 = $data4['status_pelaporan'];
                     $lokasi2 = $data4['lokasi_kerusakan'];
                     // $idstaff2 = $data4['id_staff'];
                     $gambarperbaikan3 = $data4['gambar_hasil_perbaikan'];
                     print_r("ini gambarnya ".$nomortelepon2."");
                    $bintang1 = 1;
                    $bintang2 = 2;
                    $bintang3 = 3;
                    $bintang4 = 4;
                    $bintang5 = 5;

                    $bintang = 
                    array(
                    array(
                        array('text' => '⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang1),
                        array('text' => '⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang2),
                        array('text' => '⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang3),
                        ),
                    array(
                         array('text' => '⭐️⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang4),
                        array('text' => '⭐️⭐️⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang5),
                    ),
                    );
                     // $sql2 = "SELECT `nama_user` FROM `staff` WHERE `id_staff`=$idstaff2";
                     // $result2 = mysql_query($sql2);
                     // $data2 = mysql_fetch_assoc($result2);
                     // $namastaff = $data2['nama_user'];
                     sendApiPhotoInfo($chatid,$gambarperbaikan3);
                     $text = "Status pelaporan untuk ID ".$idpelaporan1."\n\nNama Pelaporan : ".$username2."\nTanggal Pelaporan : ".$tglpelaporan2."\nDeskripsi Kerusakan : ".$deskripsi2."\nLokasi Kerusakan : ".$lokasi2."\nStatus Pelaporan : ".$status2."";
                     $text2 = "Silahkan memberikan feedback";
                     sendApiKeyboard($chatid,$mainmenu,false,$text);
                     sendApiKeyboard($chatid,$bintang,true,$text2);
                    $sql1 = "INSERT INTO `variabel`(`var_id`, `lokasi`,`deskripsi`,`idpelfeedback`) VALUES ('$chatid',null,null,$idpelaporan1)";
                    mysql_query($sql1);
                    $sqldelete = "DELETE FROM `status` WHERE `id`='$chatid'";
                    mysql_query($sqldelete); 
                }
                elseif (empty($gambarperbaikan2)) {
                     $sql4 = "SELECT `username`,`no_tlp`,`tgl_pelaporan`,`deskripsi_kerusakan`,`status_pelaporan`,`lokasi_kerusakan` FROM `pelaporan` WHERE `id_pelaporan`=$idpelaporan1";
                    // mysql_query($sql4) or die(mysql_error()) ;
                     $result4 = mysql_query($sql4);
                     $data4 = mysql_fetch_assoc($result4);
                     $username2 = $data4['username'];
                     $nomortelepon2 = $data4['no_tlp'];
                     $tglpelaporan2 = $data4['tgl_pelaporan'];
                     $deskripsi2 = $data4['deskripsi_kerusakan'];
                     $status2 = $data4['status_pelaporan'];
                     $lokasi2 = $data4['lokasi_kerusakan'];
                                          // $idstaff2 = $data4['id_staff'];
                    $text2= "coba";
                      $text = "Status pelaporan untuk ID ".$idpelaporan1."\n\nNama Pelaporan : ".$username2."\nTanggal Pelaporan : ".$tglpelaporan2."\nDeskripsi Kerusakan : ".$deskripsi2."\nLokasi Kerusakan : ".$lokasi2."\nStatus Pelaporan : ".$status2."";
                     sendApiKeyboard($chatid,$mainmenu,false,$text);
                    $sqldelete = "DELETE FROM `status` WHERE `id`='$chatid'";
                    mysql_query($sqldelete);
                     
                }
                elseif(!empty($gambarperbaikan2) && !empty($var_id) && empty($idfeedback3) )
                {
                    print_r($idpelaporan1);
                    $sql4 = "SELECT `username`,`no_tlp`,`tgl_pelaporan`,`deskripsi_kerusakan`,`status_pelaporan`,`lokasi_kerusakan`,`gambar_hasil_perbaikan` FROM `pelaporan` WHERE `id_pelaporan`=$idpelaporan1";
                    // mysql_query($sql4) or die(mysql_error()) ;
                     $result4 = mysql_query($sql4);
                     $data4 = mysql_fetch_assoc($result4);
                     $username2 = $data4['username'];
                     $nomortelepon2 = $data4['no_tlp'];
                     $tglpelaporan2 = $data4['tgl_pelaporan'];
                     $deskripsi2 = $data4['deskripsi_kerusakan'];
                     $status2 = $data4['status_pelaporan'];
                     $lokasi2 = $data4['lokasi_kerusakan'];
                     // $idstaff2 = $data4['id_staff'];
                     $gambarperbaikan3 = $data4['gambar_hasil_perbaikan'];
                     print_r("ini gambarnya ".$nomortelepon2."");
                    $bintang1 = 1;
                    $bintang2 = 2;
                    $bintang3 = 3;
                    $bintang4 = 4;
                    $bintang5 = 5;

                    $bintang = 
                    array(
                    array(
                        array('text' => '⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang1),
                        array('text' => '⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang2),
                        array('text' => '⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang3),
                        ),
                    array(
                         array('text' => '⭐️⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang4),
                        array('text' => '⭐️⭐️⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang5),
                    ),
                    );
                     // $sql2 = "SELECT `nama_user` FROM `staff` WHERE `id_staff`=$idstaff2";
                     // $result2 = mysql_query($sql2);
                     // $data2 = mysql_fetch_assoc($result2);
                     // $namastaff = $data2['nama_user'];
                     sendApiPhotoInfo($chatid,$gambarperbaikan3);
                     $text = "Status pelaporan untuk ID ".$idpelaporan1."\n\nNama Pelaporan : ".$username2."\nTanggal Pelaporan : ".$tglpelaporan2."\nDeskripsi Kerusakan : ".$deskripsi2."\nLokasi Kerusakan : ".$lokasi2."\nStatus Pelaporan : ".$status2."";
                     $text2 = "Silahkan memberikan feedback";
                     sendApiKeyboard($chatid,$mainmenu,false,$text);
                     sendApiKeyboard($chatid,$bintang,true,$text2);
                    $sql1 ="UPDATE `variabel` SET `idpelfeedback`=$idpelaporan1 WHERE var_id='$chatid'";
                    mysql_query($sql1);
                    $sqldelete = "DELETE FROM `status` WHERE `id`='$chatid'";
                    mysql_query($sqldelete); 
                    
                }
                elseif(!empty($gambarperbaikan2) && empty($var_id) && !empty($idfeedback3) )
                {
                     $sql4 = "SELECT `username`,`no_tlp`,`tgl_pelaporan`,`deskripsi_kerusakan`,`status_pelaporan`,`lokasi_kerusakan`,`gambar_hasil_perbaikan` FROM `pelaporan` WHERE `id_pelaporan`=$idpelaporan1";
                    // mysql_query($sql4) or die(mysql_error()) ;
                     $result4 = mysql_query($sql4);
                     $data4 = mysql_fetch_assoc($result4);
                     $username2 = $data4['username'];
                     $nomortelepon2 = $data4['no_tlp'];
                     $tglpelaporan2 = $data4['tgl_pelaporan'];
                     $deskripsi2 = $data4['deskripsi_kerusakan'];
                     $status2 = $data4['status_pelaporan'];
                     $lokasi2 = $data4['lokasi_kerusakan'];
                     // $idstaff2 = $data4['id_staff'];
                     $gambarperbaikan3 = $data4['gambar_hasil_perbaikan'];
                    sendApiPhotoInfo($chatid,$gambarperbaikan3);
                     $text = "Status pelaporan untuk ID ".$idpelaporan1."\n\nNama Pelaporan : ".$username2."\nTanggal Pelaporan : ".$tglpelaporan2."\nDeskripsi Kerusakan : ".$deskripsi2."\nLokasi Kerusakan : ".$lokasi2."\nStatus Pelaporan : ".$status2." dan diberikan feedback";
                      $text2 = "Pelaporan telah dikerjakan dan diberikan feedback";
                     sendApiKeyboard($chatid,$mainmenu,false,$text);
                    $sql1 ="UPDATE `variabel` SET `idpelfeedback`=$idpelaporan1 WHERE var_id='$chatid'";
                    mysql_query($sql1);
                    $sqldelete = "DELETE FROM `status` WHERE `id`='$chatid'";
                    mysql_query($sqldelete); 
                }
                elseif(!empty($gambarperbaikan2) && !empty($var_id) && !empty($idfeedback3) )
                {
                    $sql4 = "SELECT `username`,`no_tlp`,`tgl_pelaporan`,`deskripsi_kerusakan`,`status_pelaporan`,`lokasi_kerusakan`,`gambar_hasil_perbaikan` FROM `pelaporan` WHERE `id_pelaporan`=$idpelaporan1";
                    // mysql_query($sql4) or die(mysql_error()) ;
                     $result4 = mysql_query($sql4);
                     $data4 = mysql_fetch_assoc($result4);
                     $username2 = $data4['username'];
                     $nomortelepon2 = $data4['no_tlp'];
                     $tglpelaporan2 = $data4['tgl_pelaporan'];
                     $deskripsi2 = $data4['deskripsi_kerusakan'];
                     $status2 = $data4['status_pelaporan'];
                     $lokasi2 = $data4['lokasi_kerusakan'];
                     // $idstaff2 = $data4['id_staff'];
                     $gambarperbaikan3 = $data4['gambar_hasil_perbaikan'];
                    sendApiPhotoInfo($chatid,$gambarperbaikan3);
                     $text = "Status pelaporan untuk ID ".$idpelaporan1."\n\nNama Pelaporan : ".$username2."\nTanggal Pelaporan : ".$tglpelaporan2."\nDeskripsi Kerusakan : ".$deskripsi2."\nLokasi Kerusakan : ".$lokasi2."\nStatus Pelaporan : ".$status2." dan diberikan feedback";
                      $text2 = "Pelaporan telah dikerjakan dan diberikan feedback";
                     sendApiKeyboard($chatid,$mainmenu,false,$text);
                    $sql1 ="UPDATE `variabel` SET `idpelfeedback`=$idpelaporan1 WHERE var_id='$chatid'";
                    mysql_query($sql1);
                    $sqldelete = "DELETE FROM `status` WHERE `id`='$chatid'";
                    mysql_query($sqldelete); 
                }
            }
            elseif($status==4)
            {
                preg_match('/^(.*)/',$pesan,$hasil);
                $idpelaporan2 = $hasil[1];
                $sql = "SELECT `id_pelaporan` FROM `feedback` WHERE `id_pelaporan`=$idpelaporan2";
                $result = mysql_query($sql);
                $data = mysql_fetch_assoc($result);
                $idpelfed = $data['id_pelaporan'];
                $sql2 = "SELECT `status_pelaporan`,`gambar_hasil_perbaikan` FROM `pelaporan` WHERE `id_pelaporan`=$idpelaporan2";
                $result2 = mysql_query($sql2);
                $data2 = mysql_fetch_assoc($result2);
                $statuspel = $data2['status_pelaporan'];
                $gambarhasilperbaikan = $data2['gambar_hasil_perbaikan'];

                if(empty($idpelfed) && empty($var_id) && !empty($gambarhasilperbaikan))
                {
                    $text = "Pelaporan anda telah dikerjakan. Silahkan memberikan penilaian atas pelayanan staf rumah tangga.";
                    $sql2 = "SELECT `gambar_hasil_perbaikan` FROM `pelaporan` WHERE `id_pelaporan`=$idpelaporan2";
                    $result2 = mysql_query($sql2);
                    $data2 = mysql_fetch_assoc($result2);
                    $fotoperbaik = $data2['gambar_hasil_perbaikan'];

                    $bintang1 = 1;
                    $bintang2 = 2;
                    $bintang3 = 3;
                    $bintang4 = 4;
                    $bintang5 = 5;

                    $bintang = 
                    array(
                    array(
                        array('text' => '⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang1),
                        array('text' => '⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang2),
                        array('text' => '⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang3),
                        ),
                    array(
                         array('text' => '⭐️⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang4),
                        array('text' => '⭐️⭐️⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang5),
                    ),
                    );
                    sendApiPhotobintang($chatid,$fotoperbaik,$text,$bintang);
                    $sql1 = "INSERT INTO `variabel`(`var_id`, `lokasi`,`deskripsi`,`idpelfeedback`) VALUES ('$chatid',null,null,$idpelaporan2)";
                    mysql_query($sql1); 
                }
                elseif(!empty($idpelfed) && !empty($gambarhasilperbaikan)) {
                    $text = "Pelaporan telah diberikan feedback";

                    sendApikeyboard($chatid,$mainmenu,false,$text);
                }

                elseif(empty($idpelfed) && !empty($var_id) && !empty($gambarhasilperbaikan))
                {
                    $text = "Pelaporan anda telah dikerjakan. Silahkan memberikan penilaian atas pelayanan staf rumah tangga.";
                    $sql2 = "SELECT `gambar_hasil_perbaikan` FROM `pelaporan` WHERE `id_pelaporan`=$idpelaporan2";
                    $result2 = mysql_query($sql2);
                    $data2 = mysql_fetch_assoc($result2);
                    $fotoperbaik = $data2['gambar_hasil_perbaikan'];

                    $bintang1 = 1;
                    $bintang2 = 2;
                    $bintang3 = 3;
                    $bintang4 = 4;
                    $bintang5 = 5;

                    $bintang = 
                    array(
                    array(
                        array('text' => '⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang1),
                        array('text' => '⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang2),
                        array('text' => '⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang3),
                        ),
                    array(
                         array('text' => '⭐️⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang4),
                        array('text' => '⭐️⭐️⭐️⭐️⭐️', 'callback_data' => 'Anda Memilih Bintang '.$bintang5),
                    ),
                    );
                    sendApiPhotobintang($chatid,$fotoperbaik,$text,$bintang);
                    $sql1 ="UPDATE `variabel` SET `idpelfeedback`=$idpelaporan2 WHERE var_id='$chatid'";
                    mysql_query($sql1); 
                }
                elseif($statuspel='Belum Dikerjakan' && empty($gambarhasilperbaikan))
                {
                    $text = "Pelaporan anda belum dikerjakan";
                    sendApikeyboard($chatid,$kembali,false,$text);

                }
            }
            elseif($status==5)
            {
                preg_match('/^(.*)/',$pesan,$hasil);
                $idpelaporan3 = $hasil[1];
                $sql3 = "SELECT * FROM `pelaporan` WHERE `id_pelaporan`=$idpelaporan3";
                $result3 = mysql_query($sql3);
                $data3 = mysql_fetch_assoc($result3);
                $deskripsiperbaikan = $data3['deskripsi_perbaikan'];
                $idpelaporan = $data3['id_pelaporan'];
                $gambarperbaikan = $data3['gambar_hasil_perbaikan'];
                
                if(empty($var_id) && empty($status) && !empty($idpelaporan) && empty($deskripsiperbaikan))
                {
                    $sql1 = "INSERT INTO `variabel`(`var_id`,`idpelperbaikan`) VALUES ('$chatid',$idpelaporan3)";
                    mysql_query($sql1);
                    $sqls = "INSERT INTO `status`(`id`,`status`) VALUES ('$chatid',6)";
                    mysql_query($sqls);
                    $text = "Deskripsikan perbaikan";
                    sendApiMsg($chatid,$text);
                }
                elseif(!empty($var_id) && empty($status) && !empty($idpelaporan) && empty($deskripsiperbaikan))
                {
                    $sql2 = "UPDATE `variabel` SET `idpelperbaikan`= $idpelaporan3 WHERE `var_id`='$chatid'";
                    mysql_query($sql2);
                    $sqls = "INSERT INTO `status`(`id`,`status`) VALUES ('$chatid',6)";
                    mysql_query($sqls);
                    $text = "Deskripsikan perbaikan";
                    sendApiMsg($chatid,$text);
                }
                elseif(empty($var_id) && !empty($status) && !empty($idpelaporan) && empty($deskripsiperbaikan))
                {
                    $sql1 = "INSERT INTO `variabel`(`var_id`,`idpelperbaikan`) VALUES ('$chatid',$idpelaporan3)";
                    mysql_query($sql1);
                    $sqlu = "UPDATE `status` SET `status`=6 WHERE `id`='$chatid'";
                    mysql_query($sqlu);
                    $text = "Deskripsikan perbaikan";
                    sendApiMsg($chatid,$text);
               }        
               elseif(!empty($var_id) && !empty($status) && !empty($idpelaporan) && empty($deskripsiperbaikan))
               {
                    $sql2 = "UPDATE `variabel` SET `idpelperbaikan`= $idpelaporan3 WHERE `var_id`='$chatid'";
                    mysql_query($sql2);
                    $sqlu = "UPDATE `status` SET `status`= 6 WHERE `id`='$chatid'";
                    mysql_query($sqlu);
                    $text = "Deskripsikan perbaikan";
                    sendApiMsg($chatid,$text);
               }
               elseif(!empty($deskripsiperbaikan) && !empty($gambarperbaikan))
               {
               		$text = "Pelaporan telah dikerjakan";
               		sendApiMsg($chatid,$text);
               }
               elseif(empty($idpelaporan))
               {
               		$text = "ID Pelaporan yang anda masukkan salah";
               		sendApiMsg($chatid,$text);
               }

      
            }
            elseif ($status==6) 
            {
                preg_match('/^(.*)/',$pesan,$hasil);
                $deskripsi_perbaikan = $hasil[1];
                $sql_get_status1 = "select * from status1 where id='$chatid'";
                $data_status1 = mysql_fetch_assoc(mysql_query($sql_get_status));
                $idchat = $data_status1['id'];
                $text = "Kirimkan Foto Perbaikan";
                if(empty($idchat) && empty($var_id))
                {
                    $sql = "INSERT INTO `status1`(`id`,`status1`) VALUES ('$chatid','11')";
                    mysql_query($sql);  
                     $sql1 = "INSERT INTO `variabel`(`var_id`,`deskripsi_perbaikan`) VALUES ('$chatid','$deskripsi_perbaikan')";
                    mysql_query($sql1); 
                    sendApiMsg($chatid,$text);
                }
                elseif(!empty($idchat) && empty($var_id))
                {
                    $sql3 = "update status1 set status1='11' where id='$chatid'";
                    mysql_query($sql3); 
                    $sql1 = "INSERT INTO `variabel`(`var_id`,`deskripsi_perbaikan`) VALUES ('$chatid','$deskripsi_perbaikan')";
                    mysql_query($sql1); 
                    sendApiMsg($chatid,$text);
                }
                elseif(empty($idchat) && !empty($var_id))
                {
                      $sql2 = "UPDATE `variabel` SET `deskripsi_perbaikan`= '$deskripsi_perbaikan' WHERE `var_id`='$chatid'";
                    mysql_query($sql2); 
                     $sql = "INSERT INTO `status1`(`id`,`status1`) VALUES ('$chatid','11')";
                    mysql_query($sql); 
                    sendApiMsg($chatid,$text); 
                }
                elseif(!empty($idchat) && !empty($var_id))
                {
                     $sql1 ="UPDATE `variabel` SET `deskripsi_perbaikan`='$deskripsi_perbaikan' WHERE var_id='$chatid'";
                    mysql_query($sql1);
                    $sql3 = "update status1 set status1='11' where id='$chatid'";
                    mysql_query($sql3); 
                    sendApiMsg($chatid,$text);
                }
            }
            else
            {
                sendApiMsg($chatid,"😅 No Such Format");
                break;
            }

            // elseif($status==3)
            // {
            //  $idpelaporan= rand(1,99999);
            //  $iduser= rand(1,99999);
            //  $sql = "INSERT INTO `pelaporan`(`id_pelaporan`,`id_user`,`deskripsi_kerusakan`,`status`,`lokasi_kerusakan`,`gambar_kerusakan`,`gambar_hasil_perbaikan`) VALUES ($idpelaporan,$iduser,$deskripsi,'belum dikerjakan',$lokasi,$fotopelaporan,'kosong')";
            //  $result = mysql_query($sql);
            //  print_r($sql);
            // }
            break;

            sendApiMsg($chatid, "😅 No Such Format");
            break;
    }
}

function cekpilihan($kode,$kiriman=null){
    global $tabel;
    $sql = "select id_pelaporan from pelaporan where no_hp_staff='$kiriman'";
    $result = mysql_query($sql);
    print_r($sql);
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
        $arr[$i]["text"]= $row["id_pelaporan"];
        $arr[$i]["callback_data"]= $kode.$row["id_pelaporan"];
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
    $sql = "select fileidkerusakan from pelaporan where id_pelaporan=$kiriman";
    $result = mysql_query($sql);
    if(!empty($result)){
        $data = mysql_fetch_assoc($result);
        $inpilihangambar = $data['fileidkerusakan'];
        return $inpilihangambar;
    }
}

function ambildeskripsi($kiriman=null){
    $sql = "select deskripsi_kerusakan from pelaporan where id_pelaporan=$kiriman";
    $result = mysql_query($sql);
    if(!empty($result)){
        $data = mysql_fetch_assoc($result);
        $inpilihandeskripsi = $data['deskripsi_kerusakan'];
        return $inpilihandeskripsi;
    }
}

function ambillokasi($kiriman=null){
    $sql = "select lokasi_kerusakan from pelaporan where id_pelaporan=$kiriman";
    $result = mysql_query($sql);
    if(!empty($result)){
        $data = mysql_fetch_assoc($result);
        $inpilihanlokasi = $data['lokasi_kerusakan'];
        return $inpilihanlokasi;
    }
}

function ambiltanggal($kiriman=null){
    $sql = "select tgl_pelaporan from pelaporan where id_pelaporan=$kiriman";
    $result = mysql_query($sql);
    if(!empty($result)){
        $data = mysql_fetch_assoc($result);
        $inpilihantanggal = $data['tgl_pelaporan'];
        return $inpilihantanggal;
    }
}

function ambilstatus($kiriman=null){
    $sql = "select status_pelaporan from pelaporan where id_pelaporan=$kiriman";
    $result = mysql_query($sql);
    if(!empty($result)){
        $data = mysql_fetch_assoc($result);
        $inpilihanstatus = $data['status_pelaporan'];
        return $inpilihanstatus;
    }
}


