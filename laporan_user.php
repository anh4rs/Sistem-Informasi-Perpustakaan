<?php
include_once "library/inc.connection.php";
?>
<h2> LAPORAN DATA USER </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
	<tr>
		<td width="20" align="center" bgcolor="#cccccc"><b>No</b></td>
		<td width="40" bgcolor="#cccccc"><strong>Kode</strong></td>
		<td width="381" bgcolor="#cccccc"><b>Nama User</b></td>
		<td width="138" bgcolor="#cccccc"><b>Username</b></td>
	</tr>
	<?php
	// Skrip menampilkan data user
	$mySql = "SELECT * FROM user ORDER BY kd_user";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
	$nomor = 0;
	while($myData = mysql_fetch_array($myQry)){
		$nomor++;
	?>
	<tr>
		<td> <?php echo $nomor; ?> </td>
		<td> <?php echo $myData['kd_user']; ?></td>
		<td> <?php echo $myData['nm_user']; ?> </td>
		<td> <?php echo $myData['username']; ?></td>
	</tr>
	<?php } ?>
</table>
