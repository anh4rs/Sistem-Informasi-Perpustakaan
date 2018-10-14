<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";

// jika ditemukan data kode dari URL browser
if(isset($_GET['Kode'])){
	$Kode = $_GET['Ksode'];
	// hapus data sesuai kode yang terbaca
	$mySql = "DELETE FROM kategori WHERE kd_kategori = '$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
	if($myQry){
		// refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Data'>";
	}
}
else{
	// jika tidak ada data kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>
