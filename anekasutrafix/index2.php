<?php

require_once 'database.php';

$sql = "select id_produk, nama_produk from produk where kategori_produk='$kiriman'";
$result = mysqli_query($con,$sql);
var_dump($result);