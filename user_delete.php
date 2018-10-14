<?php
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php";

// jika ditemukan data kode dari url browser
if(isset($_GET['Kode'])){
// hapus data sesuai kode yang didapat di URL
	$Kode = $_GET['Kode'];
	$mySql = "DELETE FROM user WHERE kd_user = '$Kode' AND username != 'admin'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
	if($myQry){
		// refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=User-Data'>";
	}
}
else{
	// jika tidak ada data kode ditemukan di URL
	echo "<b> Data yang dihapus tidak ada</b>";
}
?>
