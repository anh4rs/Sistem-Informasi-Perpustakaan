<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";

# tombol simpan diklik
if(isset($_POST['btnSimpan'])){
	# baca data dalam form
	$txtNama 	= $_POST['txtNama'];
	$txtUsername 	= $_POST['txtUsername'];
	$txtPassword 	= $_POST['txtPassword'];

	# validasi form, jika ada pesan error, buat pesan error ke dalam kotak
	$pesanError = array();
	if(trim($txtNama)==""){
		$pesanError[] = "Data <b> Nama User </b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($txtUsername)==""){
		$pesanError[] = "Data <b> Username </b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}

	# jika ada pesan error dari validasi
	if(count($pesanError)>=1){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach($pesanError as $indeks => $pesan_tampil){
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
			}
		echo "</div><br>";
	}
	else{
		# skrip simpan data
		# cek password baru
		if(trim($txtPassword)==""){
			$txtPassLama = $_POST['txtPassLama'];
			$passwSQL = ", password='$txtPassLama'";
		}
		else{
			$passwSQL = ", password ='".md5($txtPassword)."'";
		}

		// membaca kode dari form hidden
		$Kode = $_POST['txtKode'];

		# simpan data ke database
		$mySql = "UPDATE user SET nm_user='$txtNama', username='$txtUsername'
				$passwSQL
				WHERE kd_user = '$Kode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=User-Data'>";
		}
		exit;
	}
} // penutup tombol simpan


# tampilkan data dari database, untuk ditampilkan ke form edit
$Kode 	= $_GET['Kode'];
$mySql 	= "SELECT * FROM user WHERE kd_user = '$Kode'";
$myQry 	= mysql_query($mySql, $koneksidb) or die ("Query ambil data salah".mysql_error());
$myData = mysql_fetch_array($myQry);

// Data variable temporary(sementara)
$dataKode		= $myData['kd_user'];
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_user'];
$dataUsername 	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : $myData['username'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
	<table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
		<tr>
			<th colspan="3"><b>UBAH DATA USER</b></th>
		</tr>
		<tr>
			<td width="180"><b>Kode</b></td>
			<td width="5"><b>:</b></td>
			<td width="1098"><input type="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="5" readonly="readonly">
			<input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>"></td>
		</tr>
		<tr>
			<td><b>Nama User</b></td>
			<td><b>:</b></td>
			<td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100"></td>
		</tr>
		<tr>
			<td><b>Username</b></td>
			<td><b>:</b></td>
			<td><input name="txtUsername" type="text" value="<?php echo $dataUsername; ?>" size="30" maxlength="20"></td>
		</tr>
		<tr>
			<td><b>Password</b></td>
			<td><b>:</b></td>
			<td><input name="txtPassword" type="password" size="30" maxlength="20" >
			<input name="txtPassLama" type="hidden" value="<?php echo $myData['password']; ?>"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>
				<input type="submit" name="btnSimpan" value="Simpan"></td>
		</tr>
	</table>
</form>
