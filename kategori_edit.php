<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";

#tombol simpan diklik
if(isset($_POST['btnSimpan'])){
	# Baca Variable form
	$txtNama = $_POST['txtNama'];

	# validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if(trim($txtNama)==""){
		$pesanError[] = "Data <b>Nama Kategori</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}

	# jika ada pesan error dari validasi
	if(count($pesanError)>=1){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan = 0;
			foreach($pesanError as $indeks => $pesan_tampil){
				$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
			}
		echo "</div> <br>";
	}
	else{
		# simpan data ke database
		// jika menemukan error, simpan data ke database
		$txtKode = $_POST['txtKode'];
		$mySql = "UPDATE kategori SET nm_kategori = '$txtNama' WHERE kd_kategori = '$txtKode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Data'>";
		}
		exit;
	}
}

# tampilkan data untuk diedit
$Kode 	= $_GET['Kode'];
$mySql  = "SELECT * FROM kategori WHERE kd_kategori = '$Kode'";
$myQry 	= mysql_query($mySql, $koneksidb) or die ("Query ambil data salah".mysql_error());
$myData = mysql_fetch_array($myQry);

// menyimpan data ke variable temporary
$dataKode = $myData['kd_kategori'];
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_kategori'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
	<table width="100%" class="table-list" border="0" cellpadding="4" cellspacing="1">
		<tr>
			<th colspan="3" scope="col">UBAH DATA KATEGORI</th>
		</tr>
		<tr>
			<td width="181"><strong>Kode</strong></td>
			<td width="3"><b>:</b></td>
			<td width="1019"><input name="txtfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly="readonly">
			<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>"></td>
		</tr>
		<tr>
			<td><strong>Nama Kategori</strong></td>
			<td><b>:</b></td>
			<td><input name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="submit" name="btnSimpan" value="SIMPAN"></td>
		</tr>
	</table>
</form>
