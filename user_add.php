<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.connection.php";

# tombol simpan diklik
if(isset($_POST['btnSimpan'])){
	# baca data dalam form
	$txtNama 	= $_POST['txtNama'];
	$txtUsername = $_POST['txtUsername'];
	$txtPassword = $_POST['txtPassword'];

	# validasi form, jika ada kotak yang kosong, buat pesan error dalam kotak
	$pesanError = array();
	if(trim($txtNama)==""){
		$pesanError[] = "Data <b>Nama User</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($txtUsername)==""){
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}
	if(trim($txtPassword)==""){
		$pesanError[] = "Data <b>Password</b> tidak boleh kosong, silahkan diisi terlebih dahulu !";
	}

	# Jika ada pesan error dari validasi
	if(count($pesanError)>=1){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks => $pesan_tampil) {
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
			}
		echo "</div><br>";
	}
	else {
		# simpan data ke database
		// jika tidak menemukan eror, simpan ke database
		$kodeBaru 	= buatKode("user", "U");
		$mySql 		= "INSERT INTO user (kd_user, nm_user, username, password)
						VALUES ('$kodeBaru', '$txtNama', '$txtUsername', MD5('$txtPassword'))";
		$myQry 		= mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=User-Data'>";
		}
		exit;
	}
} // penutup tombol simpan

# variable data untuk dibaca form

$dataKode 		= buatKode("user", "U");
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
$dataPassword 	= isset($_POST['txtPassword']) ? $_POST['txtPassword'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th height="28" colspan="3"><b>TAMBAH DATA USER </b></th>
    </tr>
    <tr>
      <td width="180"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="1098"> <input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="6" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><b>Nama User </b></td>
      <td><b>:</b></td>
      <td><input name="txtNama" type="text" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>Username</b></td>
      <td><b>:</b></td>
      <td> <input name="txtUsername" type="text"  value="<?php echo $dataUsername; ?>" size="30" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td><b>:</b></td>
      <td><input name="txtPassword" type="password"  size="30" maxlength="20" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" value=" Simpan " />      </td>
    </tr>
  </table>
</form>
