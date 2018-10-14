<?php
include_once "../library/inc.seslogin.php";

// periksa data sesuai kode yang didapat di URL
if(isset($_GET['Kode'])){
	$Kode = $_GET['Kode'];

	// Hapus data sesuai kode yang didapat di URL
	$mysql = "DELETE FROM peminjaman WHERE no_pinjam='$Kode'";
	$myQry = mysql_query($mysql, $koneksidb) or die ("Error Hapus Data".mysql_error());
	if($myQry){
		// hapus data pada tabel anak (peminjaman_tindakan)
		$mySql = "DELETE FROM peminjaman_detil WHERE no_pinjam='$Kode'";
		mysql_query($mySql, $koneksidb) or die ("Error hapus data".mysql_error());

		// refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?open=Peminjaman-Tampil'>";
	}
}
else {
	// Jika tidak ada data kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>
