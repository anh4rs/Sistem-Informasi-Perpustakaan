<?php
# pengaturan tanggal komputer
date_default_timezone_set("Asia/Jakarta");

# fungsi untuk membuat kode automatis
function buatKode($tabel, $inisial){
	$struktur 	= mysql_query("SELECT * FROM $tabel");
	$field 		= mysql_field_name($struktur, 0);
	$panjang 	= mysql_field_len($struktur, 0);

	$qry 	= mysql_query("SELECT MAX(".$field.") FROM " .$tabel);
	$row 	= mysql_fetch_array($qry);
	if($row[0]==""){
		$angka = 0;
	}
	else {
		$angka = substr($row[0], strlen($inisial));
	}

	$angka++;
	$angka = strval($angka);
	$tmp = "";
	for($i = 1; $i <= ($panjang-strlen($inisial)-strlen($angka)); $i++){
		$tmp=$tmp."0";
	}
	return $inisial.$tmp.$angka;
}

# fungsi untk membalik tanggal dari format indonesia ke inggris
function InggrisTgl($tanggal){
	$tgl = substr($tanggal, 0, 2);
	$bln = substr($tanggal, 3, 2);
	$thn = substr($tanggal, 6, 4);
	$tanggal = "$thn-$bln-$tgl";
	return $tanggal;
}

# fungsi untuk membalik tanggal dari format english ke indonesia
function IndonesiaTgl($tanggal){
	$tgl = substr($tanggal, 8, 2);
	$bln = substr($tanggal, 5, 2);
	$thn = substr($tanggal, 0, 4);
	$tanggal = "$tgl-$bln-$thn";
	return $tanggal; 
}

# fungsi untuk membalik tanggal dari forat english ke indonesia
function Indonesia2Tgl($tanggal){
	$namaBln = array("01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni",
						"07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");

	$tgl = substr($tanggal, 8, 2);
	$bln = substr($tanggal, 5, 2);
	$thn = substr($tanggal, 0, 4);
	$tanggal = "$tgl".$namaBln[$bln]. "$thn";
	return $tanggal;
}

function hitungHari($myDate1, $myDate2){
	$myDate1 = strtotime($myDate1);
	$myDate2 = strtotime($myDate2);

	return($myDate2 - $myDate1) / (24 * 3600);
}

# fungsi untuk membuat format rupiah pada angka (uang)
function format_angka($angka){
	$hasil = number_format($angka,0, ",",".");
	return $hasil;
}

# fungsi untuk format tanggal, dipakai plugins calendar
function form_tanggal($nama, $value=''){
	echo "<input type='text' name='$nama' id='$nama' size='11' maxlength='20' value='$value'/>&nbsp;
	<img src='images/calendar-add-icon.png' align='top' style='cursor:pointer; margin-top:7px;' alt='kalender' onclick=\"displayCalender(document.getElementById('$nama'),'dd-mm-yyyy',this)\">
	";
}

function angkaTerbilang($x){
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return angkaTerbilang($x - 10) . " belas";
  elseif ($x < 100)
    return angkaTerbilang($x / 10) . " puluh" . angkaTerbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . angkaTerbilang($x - 100);
  elseif ($x < 1000)
    return angkaTerbilang($x / 100) . " ratus" . angkaTerbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . angkaTerbilang($x - 1000);
  elseif ($x < 1000000)
    return angkaTerbilang($x / 1000) . " ribu" . angkaTerbilang($x % 1000);
  elseif ($x < 1000000000)
    return angkaTerbilang($x / 1000000) . " juta" . angkaTerbilang($x % 1000000);
}
?>
