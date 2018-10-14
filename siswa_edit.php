<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

if(isset($_POST['btnSimpan'])){
	# baca variable form
	$txtNama 		= $_POST['txtNama'];
	$txtNisn 		= $_POST['txtNisn'];
	$cmbKelamin 	= $_POST['cmbKelamin'];
	$txtAgama 		= $_POST['txtAgama'];
	$txtTempatLhr 	= $_POST['txtTempatLhr'];
	$cmbTanggalLhr 	= $_POST['cmbTanggalLhr'];
	$cmbBulanLhr 	= $_POST['cmbBulanLhr'];
	$cmbTahunLhr 	= $_POST['cmbTahunLhr'];
	$txtAlamat 		= $_POST['txtAlamat'];
	$txtNoTelepon	= $_POST['txtNoTelepon'];

	// menggabungkan tanggal
	$tanggalLahir = $cmbTahunLhr."-".$cmbBulanLhr."-".$cmbTanggalLhr;

	# validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if(trim($txtNama)==""){
		$pesanError[] = "Data <b>Nama Siswa</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($txtNisn)==""){
		$pesanError[] = "Data <b>NISN</b> tidak boleh kosong, siahkan diisi terlebih dahulu !";
	}
	if(trim($cmbKelamin)=="Kosong"){
		$pesanError[] = "Data <b>Jenis Kelamin</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($txtAgama)==""){
		$pesanError[] = "Data <b>Agama</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($txtTempatLhr)==""){
		$pesanError[] = "Data <b>Tempat Lahir</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($cmbTanggalLhr)=="Kosong"){
		$pesanError[] = "Data <b>Tanggal Lahir</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($cmbBulanLhr)=="Kosong"){
		$pesanError[] = "Data <b>Bulan Lahir</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($cmbTahunLhr)=="Kosong"){
		$pesanError[] = "Data <b>Tahun Lahir</b> tidak boleh kosong, silahkan diisi terlebih daulu !";
	}
	if(trim($txtAlamat)==""){
		$pesanError[] = "Data <b>Alamat</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}

	# jika ada pesan error dari validasi
	if(count($pesanError)>=1){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.php'> <br><hr>";
		$noPesan=0;
		foreach($pesan as $indeks => $pesan_tampil){
			$noPesan++;
			echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
		}
		echo "</div> <br>";
	}
	else {
		# simpan data ke database
		// membaca kode siswa dari form
		$Kode = $_POST['txtKode'];

		# skrip upload foto
		// periksa keberadaan file baru
		if(empty($_FILES['txtNamaFile']['tmp_name'])){
			// jika tidak ada file foto baru, maka baca foto lama
			$nama_file = $_POST['txtFileSembunyi'];
		}
		else{
			// jika file foto lama ada, akan dihapus
			$txtFileSembunyi = $_POST['txtFileSembunyi'];
			if(file_exists("foto/siswa/$txtFileSembunyi")){
				unlink("foto/siswa/$txtFileSembunyi");
			}

			// membaca file foto baru
			$nama_file = $_FILES['txtNamaFile']['name'];
			$nama_file = stripslashes($nama_file);
			$nama_file = str_replace("'", "", $nama_file);

			// mengkopi file foto baru ke folder
			$nama_file = $Kode.".".$nama_file;
			copy($_FILES['txtNamaFile']['tmp_name'], "foto/siswa".$nama_file);
		}

		// skrip simpan data ke tabel database
		$mySql = "UPDATE siswa SET nm_siswa = '$txtNama',
									nisn  	= '$txtNisn',
									kelamin = '$cmbKelamin',
									agama 	= '$txtAgama',
									tempat_lahir = '$txtTempatLhr',
									tanggal_lahir = '$cmbTanggalLhr',
									alamat 	= '$txtAlamat',
									no_telepon = '$txtNoTelepon',
									foto 	= '$nama_file'
							WHERE kd_siswa = '$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Siswa-Data'>";
		}
		exit;
	}
} // penutup post

# tampilkan data untuuk diedit
$Kode 	= $_GET['Kode'];
$mySql 	= "SELECT * FROM siswa WHERE kd_siswa = '$Kode'";
$myQry 	= mysql_query($mySql, $koneksidb) or die ("Query ambil data salah".mysql_error());
$myData = mysql_fetch_array($myQry);
// membaca data, lalu disimpan dalam variable data
$dataKode 		= $myData['kd_siswa'];
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_siswa'];
$dataNisn 		= isset($_POST['txtNisn']) ? $_POST['txtNisn'] : $myData['nisn'];
$dataKelamin 	= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : $myData['kelamin'];
$dataAgama 		= isset($_POST['txtAgama']) ? $_POST['txtAgama'] : $myData['agama'];
$dataAlamat 	= isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
$dataNoTelepon 	= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : $myData['no_telepon'];
$dataTempatLhr 	= isset($_POST['txtTempatLhr']) ? $_POST['txtTempatLhr'] : $myData['tempat_lahir'];
$dataTanggalLhr = isset($_POST['txtTanggalLhr']) ? $_POST['txtTanggalLhr'] : substr($myData['tanggal_lahir'], 9, 2 );
$dataBulanLhr 	= isset($_POST['txtBulanLhr']) ? $_POST['txtBulanLhr'] : substr($myData['tanggal_lahir'], 5, 2);
$dataTahunLhr 	= isset($_POST['txtTahunLhr']) ? $_POST['txtTahunLhr'] : substr($myData['tanggal_lahir'], 0, 4);
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" enctype="multipart/form-data">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
		<tr>
			<th colspan="3" scope="col">UBAH DATA SISWA</th>
		</tr>
		<tr>
			<td><strong>Kode</strong></td>
			<td><strong>:</strong></td>
			<td><input name="textfield" value="<?php echo $dataKode; ?>" size="14" maxlength="10" readonly="readonly">
			<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" ></td>
		</tr>
		<tr>
			<td><strong>Nama Siswa</strong></td>
			<td><strong>:</strong></td>
			<td><input name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100"></td>
		</tr>
		<tr>
			<td><strong>NISN</strong></td>
			<td><strong>:</strong></td>
			<td><input name="txtNisn" id="txtNisn" value="<?php echo $dataNisn; ?>" size="30" maxlength="30"></td>
		</tr>
		<tr>
			<td><strong>Jenis Kelamin</strong></td>
			<td><strong>:</strong></td>
			<td><select name="cmbKelamin">
				<option value="Kosong">....</option>
				<?php
				$pilihan = array("L"=> "Laki-Laki", "P" => "Perempuan");
				foreach($pilihan as $indeks => $nilai){
					if($dataKelamin==$indeks){
						$cek ="selected";
					} else { $cek = ""; }
					echo "<option value='$indeks' $cek> $nilai </option>";
				}
				?>
			</select></td>
		</tr>
		<tr>
			<td><b>Agama</b></td>
			<td><b>:</b></td>
			<td><input name="txtAgama" value="<?php echo $dataAgama; ?>" size="50" maxlength="60"></td>
		</tr>
		<tr>
			<td><b>Tempat &amp; Tgl. Lahir</b></td>
			<td><b>:</b></td>
			<td><input name="txtTempatLhr" value="<?php echo $dataTempatLhr; ?>" size="40" maxlength="100">
			,
			<select name="cmbTanggalLhr">
			<option value="Kosong">....</option>
			<?php
			for($tanggal = 1; $tanggal <= 31; $tanggal++){
				// skrip membuat angka 2 digit (1 - 9)
				if($tanggal < 10){ $ttgl = "0".$tanggal; } else { $ttgl = $tanggal; }

				// skrip tanggal terpilih
				if($ttgl == $dataTanggalLhr){ $cek = "selected"; } else { $cek = ""; }

				echo "<option value='$ttgl' $cek> $ttgl </option>";
			}
			?>
			</select>
			<select name="cmbTahunLhr">
			<option value="Kosong">....</option>
			<?php
			for($bulan = 1; $bulan <= 12; $bulan++){
				// skrip membuat angka 2 digit (1 - 9)
				if($bulan < 10){$bln = "0".$bulan;} else {$bln = $bulan; }

				if($bln == $dataBulanLhr){$cek ="selected"; } else {$cek = "";}

				echo "<option value='$bln' $cek> $listBulan[$bln] </option>";
			}
			?>
			</select>
			<select name="cmbTahunLhr">
			<option value="Kosong">....</option>
			<?php
			$thmuda = date('Y') - 25;
			$thtua = date('Y') - 10;
			for($tahun = $thmuda; $tahun <= $thtua; $tahun++){
				// skrip tahun terpilih
				if($tahun == $dataTahunLhr){$cek ="selected"; } else {$cek = "";}
				echo "<option value='$tahun' $cek> $tahun </option>";
			}
			?>
			</select></td>
		</tr>
		<tr>
			<td><strong>Alamat</strong></td>
			<td><strong>:</strong></td>
			<td><input name="txtAlamat" value="<?php echo $dataAlamat; ?>" size="80" maxlength="200"></td>
		</tr>
		<tr>
			<td><strong>No. Telepon</strong></td>
			<td><b>:</b></td>
			<td><input name="txtNoTelepon" value="<?php echo $dataNoTelepon; ?>" size="30" maxlength="20"></td>
		</tr>
		<tr>
			<td><b>Foto</b></td>
			<td><b>:</b></td>
			<td><input name="txtNamaFile" type="file" id="txtNamaFile" size="40">
			<input name="txtFIleSembunyi" type="hidden" value="<?php echo $myData['foto']; ?>"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="submit" name="btnSimpan" value="SIMPAN" style="cursor:pointer;"></td>
		</tr>
	</table>
</form>
