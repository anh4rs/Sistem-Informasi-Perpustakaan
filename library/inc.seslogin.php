<?php
if(empty($_SESSION['SES_LOGIN'])){
	echo "<center>";
	echo "<br><br><b> Maaf akses anda ditolak !</b><br>
		Silahkan masukkan data login anda dengan benar untuk bisa mengakses halaman ini.";
	echo "</center>";

	// Refresh
	echo "<meta http-equiv='refresh' content='3; url=../index.php'>";
	exit;
}
?>