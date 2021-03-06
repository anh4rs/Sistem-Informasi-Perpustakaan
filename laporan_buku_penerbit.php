<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

// Baca variable URL browser
$kodePenerbit = isset($_GET['kodePenerbit']) ? $_GET['kodePenerbit'] : 'Semua';
// baca variable dari form setelah di post
$kodePenerbit = isset($_POST['cmbPenerbit']) ? $_POST['cmbPenerbit'] : $kodePenerbit;

// Membuat filter SQL
if($kodePenerbit=="Semua"){
	// Query #1 (semua data)
	$filterSQL = "";
}
else {
	// Query #1 (filter)
	$filterSQL = "WHERE buku.kd_penerbit = '$kodePenerbit'";
}

# Untuk paging (Pembagian halaman)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 1;
$infoSql = "SELECT * FROM buku $filterSQL";
$infoQry = mysql_query($infoSql, $koneksidb) or die ("error paging".mysql_error());
$jumlah = mysql_num_rows($infoQry);
$maks = ceil($jumlah/$baris);
$mulai = $baris * ($hal-1);
?>
<h2>LAPORAN DATA BUKU PER PENERBIT</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
	<table width="500" border="0" class="table-list">
		<tr>
			<td colspan="3" bgcolor="#f5f5f5"><strong>FILTER DATA</strong></td>
		</tr>
		<tr>
			<td width="84"><strong>Penerbit</strong></td>
			<td width="5"><strong>:</strong></td>
			<td width="397"><select name="cmbPenerbit">
				<option value="Semua">....</option>
				<?php
				// skrip menampilkan data penerbit ke dalam list/ menu (combo)
				$bacaSql = "SELECT * FROM penerbit ORDER BY kd_penerbit";
				$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
				while($bacaData = mysql_fetch_array($bacaQry)){
					if($bacaData['kd_penerbit'] == $kodePenerbit){
						$cek = "selected";
					} else { $cek=""; }
				echo "<option value='$bacaData[kd_penerbit]' $cek> $bacaData[nm_penerbit] </option>";
				}
				?>
				</select>
				<input name="btnTampil" type="submit" value="Tampilkan"></td>
		</tr>
	</table>
</form>

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
	<tr>
		<td width="20" bgcolor="#f5f5f5"><strong>No</strong></td>
		<td width="44" bgcolor="#f5f5f5"><strong>Kode</strong></td>
		<td width="300" bgcolor="#f5f5f5"><strong>Judul Buku</strong></td>
		<td width="154" bgcolor="#f5f5f5"><strong>Kategori</strong></td>
		<td width="154" bgcolor="#f5f5f5"><strong>Pengarang</strong></td>
		<td width="42" bgcolor="#f5f5f5"><strong>Tahun</strong></td>
		<td width="50" align="right" bgcolor="#f5f5f5"><strong>Jumlah</strong></td>
	</tr>
	<?php
	// skrip menampilkan semua data buku dengan filter penerbit
	$mySql = "SELECT buku.*, kategori.nm_kategori FROM buku
				LEFT JOIN kategori ON buku.kd_kategori = kategori.kd_kategori
				$filterSQL ORDER BY buku.kd_buku ASC LIMIT $mulai, $baris";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Query Salah".mysql_error());
	$nomor = $mulai;
	while($myData = mysql_fetch_array($myQry)){
		$nomor++;
	?>
	<tr>
		<td> <?php echo $nomor; ?> </td>
		<td> <?php echo $myData['kd_buku']; ?> </td>
		<td> <?php echo $myData['judul']; ?> </td>
		<td> <?php echo $myData['nm_kategori']; ?> </td>
		<td> <?php echo $myData['pengarang']; ?> </td>
		<td> <?php echo $myData['th_terbit']; ?> </td>
		<td align="right"> <?php echo format_angka($myData['jumlah']); ?> </td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="3" bgcolor="#f5f5f5"><strong>Jumlah Data : </strong> <?php echo $jumlah; ?> </td>
		<td colspan="4" align="right" bgcolor="#f5f5f5">
			<strong>Halaman ke :</strong>
			<?php
			for ($h = 1; $h <= $maks; $h++){
				echo "<a href='?open=Laporan-Buku-Penerbit&hal=$h&kodePenerbit=$kodePenerbit'> $h </a>";
			}
		?></td>
	</tr>
</table>