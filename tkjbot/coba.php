<?php
$imgurl = 'https://api.telegram.org/file/bot426325386:AAHfe2MX2eX5dt0h0xuXQ93ZNUnq1Ia4ReI/photos/file_73.jpg'; 
$imagename= basename($imgurl);
$image = file_get_contents($imgurl); 
$test = file_put_contents('gambar_bukti/'.$imagename,$image);
echo $imagename;
?>