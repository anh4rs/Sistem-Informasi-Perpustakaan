<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>:: Laporan Data Kategori</title>
<link rel="stylesheet" type="text/css" href="../styles/styles_cetak.css">
</head>
<body>
<h2>LAPORAN DATA KATEGORI</h2>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
	<tr>
		<td width="24" align="center" bgcolor="#f5f5f5"><strong>No</strong></td>
		<td width="55" bgcolor="#f5f5f5"><strong>Kode</strong></td>
		<td width="605" bgcolor="#f5f5f5"><strong>Nama Kategori</strong></td>
	</tr>
	<?php
	// Skrip menampilkan data kategori
	$mySql = "SELECT * FROM kategori ORDER BY kd_kategori ASC";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Query salah : ".mysql_error());
	$nomor = 0;
	while ($mysData = mysql_fetch_array($myQry)){
		$nomor++;
	?>
	<tr>
		<td> <?php echo $nomor; ?> </td>
		<td> <?php echo $mysData['kd_kategori']; ?> </td>
		<td> <?php echo $mysData['nm_kategori']; ?> </td>
	</tr>
	<?php } ?>
</table>
<img src="../images/btn_print.png" height="20" onclick="javascript:window.print()"/>
</body>
</html>