<?php
include_once "library/inc.connection.php";

# Untuk Paging
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql = "SELECT * FROM pengadaan";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging".mysql_error());
$jumlah = mysql_num_rows($pageQry);
$maks = ceil($jumlah/$baris);
$mulai = $baris * ($hal-1);
?>
<h2> LAPORAN DATA PENGADAAN </h2>
<table class="table-list" width="750" border="0" cellspacing="1" cellpadding="2">
	<tr>
		<td width="21" align="center" bgcolor="#f5f5f5"><strong>No</strong></td>
		<td width="36" bgcolor="#f5f5f5"><strong>Kode</strong></td>
		<td width="80" bgcolor="#f5f5f5"><strong>Tanggal</strong></td>
		<td width="354" bgcolor="#f5f5f5"><strong>Judul Buku</strong></td>
		<td width="180" bgcolor="#f5f5f5"><strong>Asal Buku</strong></td>
		<td width="48" bgcolor="#f5f5f5"><strong>Jumlah</strong></td>
	</tr>
	<?php
	// Skrip menampilkan date Pengadaan ke Layar
	$mySql = "SELECT pengadaan.*, buku.judul FROM pengadaan
				LEFT JOIN buku ON pengadaan.kd_buku = buku.kd_buku ORDER BY no_pengadaan ASC LIMIT $mulai, $baris";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	$nomor = $mulai;
	while($myData = mysql_fetch_array($myQry)){
		$nomor++;
	?>
	<tr>
		<td> <?php echo $nomor; ?> </td>
		<td> <?php echo $myData['no_pengadaan']; ?> </td>
		<td> <?php echo $myData['kd_buku']; ?> </td>
		<td> <?php echo $myData['tgl_pengadaan']; ?> </td>
		<td> <?php echo $myData['judul']; ?></td>
		<td> <?php echo $myData['asal_buku']; ?> </td>
		<td> <?php echo $myData['jumlah']; ?> </td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="3"><strong>Jumlah Data : </strong> <?php echo $jumlah; ?> </td>
		<td colspan="3" align="right"><strong> Halaman Ke : </strong>
		<?php
		for($h = 1; $h <= $maks; $h++){
			echo "<a href='?open=Laporan-Pengadaan&hal=$h'>$h</a>";
		}
		?></td>
	</tr>
</table>