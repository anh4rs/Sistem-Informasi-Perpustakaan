<?php
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";

# membaca tombol simpan
if(isset($_POST['btnSimpan'])){
	# baca variable form
	$txtNama		= $_POST['txtNama'];
	$txtNisn 		= $_POST['txtNisn'];
	$cmbKelamin 	= $_POST['cmbKelamin'];
	$txtAgama 		= $_POST['txtAgama'];
	$txtAlamat 		= $_POST['txtAlamat'];
	$txtNoTelepon 	= $_POST['txtNoTelepon'];
	$txtTempatLhr  	= $_POST['txtTempatLhr'];
	$cmbTanggalLhr  = $_POST['cmbTanggalLhr'];
	$cmbBulanLhr 	= $_POST['cmbBulanLhr'];
	$cmbTahunLhr 	= $_POST['cmbTahunLhr'];

	// menggabung tanggal 
	$tanggalLahir = $cmbTahunLhr."-".$cmbBulanLhr."-".$cmbTanggalLhr;

	# validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if(trim($txtNama)==""){
		$pesanError[] = "Data<b>Nama Siswa</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($txtNisn)==""){
		$pesanError[] = "Data <b>Nisn</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($cmbKelamin)=="Kosong"){
		$pesanError[] = "Data <b>Jenis Kelamin</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($txtAgama)==""){
		$pesanError[] = "Data <b>Agama</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($txtTempatLhr)==""){
		$pesanError[] = "Data <b>Tempat Lahir<b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($cmbTanggalLhr)=="Kosong"){
		$pesanError[] = "Data <b>Tanggal Lahir</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($cmbBulanLhr)=="Kosong"){
		$pesanError[] = "Data <b>Bulan Lahir</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($cmbTahunLhr)=="Kosong"){
		$pesanError[] = "Data <b>Tahun Lahir</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($txtAlamat)==""){
		$pesanError[] = "Data <b>Alamat</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
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
	else {
		// simpan data ke database
		// membuat kode siswa baru
		$kodeBaru = buatKode("siswa","S");
		# skrip mengkopi file foto ke folder
		if(! empty($_FILES['txtNamaFile']['tmp_name'])){
			// jika file foto tidak kosong (ada foto yang dipilih)
			$nama_file = $_FILES['txtNamaFile']['name'];
			$nama_file = stripslashes($nama_file);
			$nama_file = str_replace("'", "", $nama_file);

			// proses copy foto (menyimpan ke folder)
			$nama_file = $kodeBaru.".".$nama_file;
			copy($_FILES['txtNamaFile']['tmp_name'],"foto/siswa/".$nama_file);
		}
		else{
			// jika filr foto tidak dipilih, maka simpan data kosong
			$nama_file = "";
		}

		// skrip menyimpan data siswa baru ke database
		$mySql = "INSERT INTO siswa(kd_siswa, nm_siswa, nisn, kelamin, agama, tempat_lahir, tanggal_lahir, alamat, no_telepon, foto)
					VALUES ('$kodeBaru',
							'$txtNama',
							'$txtNisn',
							'$cmbKelamin',
							'$cmbAgama',
							'$txtTempatLhr',
							'$tanggalLahir',
							'$txtAlamat',
							'$txtNoTelepon',
							'$nama_file')";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Siswa-Data'>";
		}
		exit;
	}
} // penutup post

# variable data untuk kotak form
$dataKode 		= buatKode("siswa","S");
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataNisn 		= isset($_POST['txtNisn']) ? $_POST['txtNisn'] : '';
$dataKelamin 	= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataAgama 		= isset($_POST['txtAgama']) ? $_POST['txtAgama'] : '';
$dataAlamat 	= isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataNoTelepon	= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : '';
$dataTempatLhr	= isset($_POST['txtTempatLhr']) ? $_POST['txtTempatLhr'] : '';
$dataTanggalLhr = isset($_POST['cmbTanggalLhr']) ? $_POST['cmbTanggalLhr'] : '';
$dataBulanLhr 	= isset($_POST['cmbBulanLhr']) ? $_POST['cmbBulanLhr'] : '';
$dataTahunLhr 	= isset($_POST['cmbTahunLhr']) ? $_POST['cmbTahunLhr'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" encypte="multipart/form-data" name="form1" target="_self">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
		<tr>
			<th colspan="3" scope="col">TAMBAH DATA SISWA</th>
		</tr>
		<tr>
			<td width="16%"><strong>Kode</strong></td>
			<td width="1%"><strong>:</strong></td>
			<td width="83%"><input name="txtfield" value="<?php echo $dataKode; ?>" size="14" maxlength="10" readonly="readonly"></td>
		</tr>
		<tr>
			<td><strong>Nama Siswa</strong></td>
			<td><strong>:</strong></td>
			<td><input name="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100"></td>
		</tr>
		<tr>
			<td><strong>NISN</strong></td>
			<td><strong>:</strong></td>
			<td><input name="txtNisn" value="<?php echo $dataNisn; ?>" size="30" maxlength="30"></td>
		</tr>
		<tr>
			<td><strong>Kelamin</strong></td>
			<td><strong>:</strong></td>
			<td><select name="cmbKelamin">
				<option value="Kosong">...</option>
				<?php
				$pilihan = array("L"=>"Laki-laki","P" => "Perempuan");
				foreach($pilihan as $indeks => $nilai){
					if($dataKelamin==$indeks){
						$cek = "selected";
					} else { $cek = "";}
					echo "<option value='$indeks' $cek>$nilai</option>";
				}
				?>
			</select></td>
		</tr>
		<tr>
			<td><b>Agama</b></td>
			<td><b>:</b></td>
			<td><input name="txtAgama" value="<?php echo $dataAgama; ?>" size="30" maxlength="30"></td>
		</tr>
		<tr>
			<td><strong>Tempat &amp; Tgl. Lahir</strong></td>
			<td><strong>:</strong></td>
			<td><input name="txtTempatLhr" value="<?php echo $dataTempatLhr; ?>" size="40" maxlength="100">
			,
			<select name="cmbTanggalLhr">
				<option value="Kosong">....</option>
				<?php
				for($tanggal = 1; $tanggal <= 31; $tanggal++){
					//  skrip membuat angka 2 digit (1 - 9)
				if($tanggal < 10){ $ttgl = "0".$tanggal; } else { $ttgl = $tanggal;}
					// skrip tanggal terpisah
				if($tanggal == $dataTanggalLhr){ $cek = "selected"; } else { $cek = "";}
				echo "<option value='$ttgl' $cek> $ttgl </option>";
				}
				?>
			</select>
			<select name="cmbBulanLhr">
				<option value="Kosong">....</option>
				<?php
				for($bulan = 1; $bulan <= 12; $bulan++){
					// skrip membuat angka 2 digit (1 - 9)
				if($bulan < 10){$bln = "0".$bulan; } else { $bln = $bulan; }

				if($bulan == $dataBulanLhr){ $cek = "selected"; } else { $cek = "";}
				echo "<option value='$bln' $cek> $bln </option>";
				}
				?>
			</select>
			<select name="cmbTahunLhr">
				<option value="Kosong">....</option>
				<?php
				$thmuda = date('Y') - 25;
				$thtua = date('Y') - 5;
				for($tahun = $thmuda; $tahun <= $thtua; $tahun++){
					// skrip tahun terpilih
					if( $tahun == $dataTahunLhr){ $cek ="selected"; } else { $cek =""; }
					echo "<option value='$tahun' $cek> $tahun </option>";
				}
				?>
			</select></td>
		</tr>
		<tr>
			<td><b>Alamat</b></td>
			<td><b>:</b></td>
			<td><input name="txtAlamat" value="<?php echo $dataAlamat; ?>" size="80" maxlength="200"></td>
		</tr>
		<tr>
			<td><b>No. Telepon</b></td>
			<td><b>:</b></td>
			<td><input name="txtNoTelepon" value="<?php echo $dataNoTelepon; ?>" size="30" maxlength="20"></td>
		</tr>
		<tr>
			<td><b>Foto</b></td>
			<td><b>:</b></td>
			<td><input name="txtNamaFile" type="file" id="txtNamaFile" size="40"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="submit" name="btnSimpan" value="SIMPAN" style="cursor:pointer;"></td>
		</tr>
</table>
</form>