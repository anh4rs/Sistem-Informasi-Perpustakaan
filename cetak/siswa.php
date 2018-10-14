<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>Laporan Data Siswa</title>
<link rel="stylesheet" type="text/css" href="../styles/styles_cetak.css">
</head>
<body>
<h2>LAPORAN DATA SISWA</h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
	<tr>
		<td width="23" bgcolor="#f5f5f5"><strong>No</strong></td>
		<td width="36" bgcolor="#f5f5f5"><strong>Kode</strong></td>
		<td width="56" bgcolor="#f5f5f5"><strong>NIS</strong></td>
		<td width="186" bgcolor="#f5f5f5"><strong>Nama Siswa</strong></td>
		<td width="27" bgcolor="#f5f5f5"><strong>L/P</strong></td>
		<td width="330" bgcolor="#f5f5f5"><strong>Alamat</strong></td>
		<td width="106" bgcolor="#f5f5f5"><strong>No. Telepon</strong></td>
	</tr>
	<?php
	// SQL menampilkan data semua siswa
	$mySql = "SELECT * FROM siswa ORDER BY kd_siswa ASC";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Query salah : ".mysql_error());
	$nomor = 0;
	while($myData = mysql_fetch_array($myQry)){
		$nomor++;
	?>
	<tr>
		<td> <?php echo $nomor; ?> </td>
		<td> <?php echo $myData['kd_siswa']; ?></td>
		<td> <?php echo $myData['nisn']; ?> </td>
		<td> <?php echo $myData['nm_siswa']; ?> </td>
		<td> <?php echo $myData['kelamin']; ?> </td>
		<td> <?php echo $myData['alamat']; ?> </td>
		<td> <?php echo $myData['no_telepon']; ?> </td>
	</tr>
	<?php } ?>
</table>
<img src="../images/btn_print.png" height="20" onclick="javascript:window.print()"/>
</body>
</html>
