<?php 

	$koneksi_mdb = odbc_connect( 'att2000', "", "");

	mysql_connect("localhost", "root", "");
	mysql_select_db("belajar_json");	
/*
	if ($koneksi) {
		echo 'Connected';
	} else{
		echo 'Failed';
	}
*/
	
	$sql = "SELECT USERID,Badgenumber,Name FROM USERINFO WHERE Badgenumber LIKE '17%' ORDER BY Name";
	$result = odbc_exec($koneksi_mdb, $sql);

	//echo $koneksi;

	while($row_mdb = odbc_fetch_array($result)){
		$mysql_insert = "INSERT INTO mahasiswa VALUES ('".$row_mdb['USERID']."', '".$row_mdb['Badgenumber']."', '".$row_mdb['Name']."')";
		mysql_query($mysql_insert);
		echo $row_mdb['Name']." Berhasil diinput <br>";
	}

	//echo "Semua data berhasil diinput kedalam DB mysql !";
 ?> 		