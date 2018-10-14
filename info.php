<?php
if(isset($_SESSION['SES_LOGIN'])){
	echo "<h3>Selamat datang di Sistem Informasi Perpustakaan SMA Sauqi Nusantara Boyolali</h3>";
	echo "<b>Anda login sebagai admin</b>";
	exit;
}
else{
	echo "<h3>Selamat datang di Sistem Informasi Perpustakaan SMA Sauqi Nusantara Boyolali </h3>";
	echo "<b> Anda belum login, silahkan <a href='?open=Login' alt='Login'>Login </a> untuk mengakses sistem ini ";
}	
?>