<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";

# Bulan terpilih dari form dan URL
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari Url, jika tidak ada diisi bulan sekarang
$dataBulan = isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari from Submit, jika tidak ada diisi dari $bulan

# Tahun terpilih dari form dan URL
$tahun 	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); 
$dataTahun = isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun;

# Membuat Filter Bulan
if($dataTahun and $dataBulan){
	if($dataBulan == "00"){
		// Jika tidak memilih bulan
		$filterSQL = "WHERE LEFT(tgl_pinjam,4)='$dataTahun'";
	}
	else {
		// JIka memlilih bulan dan tahun
		$filterSQL = "WHERE LEFT(tgl_pinjam,4)='$dataTahun' AND MID(tgl_pinjam,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

# Untuk Paging (Pembagian HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 1;
$pageSql = "SELECT * FROM peminjaman $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumlah = mysql_num_rows($pageQry);
$maks = ceil($jumlah/$baris);
$mulai = $baris * ($hal - 1);
?>
<h2>LAPORAN PEMINJAMAN PER BULAN </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
	<table width="500" border="0" class="table-list">

		<tr>
			<td colspan="3" bgcolor="#f5f5f5"><strong>FILTER DATA</strong></td>
		</tr>
		<tr>
			<td><strong>Periode Bulan</strong></td>
			<td><strong>:</strong></td>
			<td><select name="cmbBulan">
			<?php
			// membat daftar bulan 1 - 12, nama bulan membaca dari file inc.pilihan.php
			for($bulan = 1; $bulan <= 12; $bulan++){
				// Skrip membuat angka 2 digit (1 - 9)
				if($bulan < 10) { $bln = "0".$bulan; } else { $bln = $bulan; }

				if($bln == $dataBulan) { $cek= "selected"; } else { $cek=""; }

				echo "<option value='$bln' $cek> $listBulan[$bln] </option>";
			}
			?>
			</select>
			<select name="cmbTahun">
			<?php
			$$awal_th = date('Y') - 3;
			for($tahun = $$awal_th; $tahun <= date('Y'); $tahun++){
				// Skrip tahun terpilih
				if($tahun == $dataTahun) { $cek = "selected"; } else { $cek= ""; }

				echo "<option value='$tahun' $cek> $tahun </option>";
			}
			?>
			</select></td>
		</tr>
		<tr>
			<td width="130">&nbsp;</td>
			<td width="5">&nbsp;</td>
			<td width="351"><input name="btnTampil" type="submit" value="Tampilkan"></td>
		</tr>
	</table>
</form>

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
	<tr>
		<td width="23" bgcolor="#f5f5f5"><strong>No</strong></td>
		<td width="75" bgcolor="#f5f5f5"><strong>No. Pinjam</strong></td>
		<td width="75" bgcolor="#f5f5f5"><strong>Tgl. Pinjam</strong></td>
		<td width="75" bgcolor="#f5f5f5"><strong>NIS</strong></td>
		<td width="182" bgcolor="#f5f5f5"><strong>Nama Siswa</strong></td>
		<td width="100" bgcolor="#f5f5f5"><strong>Lama Pinjam</strong></td>
		<td width="217" bgcolor="#f5f5f5"><strong>Keterangan</strong></td>
		<td width="42" bgcolor="#f5f5f5"><strong>Status</strong></td>
	</tr>
	<?php
	// Skrip menampilkan data Peminjaman dengan filter bulan dan tahun
	$mySql = "SELECT peminjaman.*, siswa.nisn, siswa.nm_siswa, user.nm_user
				FROM peminjaman
				LEFT JOIN siswa ON peminjaman.kd_siswa = siswa.kd_siswa
				LEFT JOIN user ON peminjaman.kd_user = user.kd_user
				$filterSQL
				ORDER BY peminjaman.no_pinjam ASC LIMIT $mulai, $baris";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Query salah : ".mysql_error());
	$nomor = $mulai;
	while($myData = mysql_fetch_array($myQry)){
		$nomor++;
	?>
	<tr>
		<td> <?php echo $nomor; ?> </td>
		<td> <?php echo $myData['no_pinjam']; ?> </td>
		<td> <?php echo $myData['tgl_pinjam']; ?> </td>
		<td> <?php echo $myData['nisn']; ?> </td>
		<td> <?php echo $myData['nm_siswa']; ?> </td>
		<td> <?php echo $myData['lama_pinjam']; ?> </td>
		<td> <?php echo $myData['keterangan']; ?> </td>
		<td> <?php echo $myData['status']; ?> </td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="3"><strong>Jumlah Data : </strong> <?php echo $jumlah; ?> </td>
		<td colspan="5" align="right"><strong>Halaman ke : </strong>
		<?php
		for($h = 1; $h <= $maks; $h++){
			echo "<a href='?open=Laporan-Peminjaman-Bulan&hal=$h&bulan=$dataBulan&tahun=$dataTahun'>$h</a>";
		}
		?></td>
		</tr>
</table>
