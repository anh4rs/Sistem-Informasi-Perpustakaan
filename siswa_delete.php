<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";

// jika ditemukan data Kode daru URL
if(isset($_GET['Kode'])){
	$Kode = $_GET['Kode'];
	// hapus data sesuai kode yang didapat di URL
	$mySql 	= "DELETE FROM siswa WHERE kd_siswa='$Kode'";
	$myQry 	= mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	if($myQry){
		// refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Siswa-Data'>";
	}
}
else {
	// jika tidak ada data kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>
