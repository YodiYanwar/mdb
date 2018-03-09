<?php 

	$koneksi_mdb = odbc_connect( 'att2000', "", "");

	mysql_connect("localhost", "root", "");
	mysql_select_db("simon");	
/*
	if ($koneksi) {
		echo 'Connected';
	} else{
		echo 'Failed';
	}
*/
	
	$sql = "SELECT USERID, Format(DateValue(CHECKTIME), 'yyyy-mm-d') AS tgl, Format(TimeValue(CHECKTIME)) AS wkt FROM CHECKINOUT WHERE USERID = 1352 AND Format(DateValue(CHECKTIME), 'd/mm/yyyy') BETWEEN '21/09/2017' AND '22/09/2017'";
	$result = odbc_exec($koneksi_mdb, $sql);

	//echo $koneksi;

	while($row_mdb = odbc_fetch_array($result)){

		$tapping = strtotime($row_mdb['wkt']);

		$mysql_insert = "INSERT INTO `p_shalat` (`id_mahasiswa`, `tgl`, `tapping`) VALUES ('".$row_mdb['USERID']."','".$row_mdb['tgl']."', '".$row_mdb['wkt']."')";
		mysql_query($mysql_insert);

		echo $row_mdb['USERID']."' - '".$row_mdb['tgl']."' - '".$row_mdb['wkt']." <br>";
	}

	//echo "Semua data berhasil diinput kedalam DB mysql !";
 ?> 