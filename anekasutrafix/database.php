<?php
$con = mysqli_connect("vpc.cbckdflvmsrf.us-east-1.rds.amazonaws.com","admin","12345678","db_vpc");
if($con){
    echo "berhasil";
}else {
    echo "gagal";
}
?>