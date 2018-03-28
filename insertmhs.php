<?php 

	$koneksi_mdb = odbc_connect( 'attBackup', "", "");

	mysql_connect("localhost", "root", "");
	mysql_select_db("simon");	
/*
	if ($koneksi) {
		echo 'Connected';
	} else{
		echo 'Failed';
	}
*/
	
	$sql = "SELECT userid, Badgenumber, Name FROM USERINFO WHERE Badgenumber LIKE '17%' ORDER BY Name";

	$result = odbc_exec($koneksi_mdb, $sql);

	//echo $koneksi;

	$sqlTotal = "SELECT COUNT(userid) AS Total FROM USERINFO WHERE Badgenumber LIKE '17%'";

	$resultTotal = odbc_exec($koneksi_mdb, $sqlTotal);

	while($rowt = odbc_fetch_array($resultTotal)){
		echo $rowt['Total'];
	}	

	while($row_mdb = odbc_fetch_array($result)){

		$userid = mysql_real_escape_string($row_mdb['userid']);
		$badgenumber = mysql_real_escape_string($row_mdb['Badgenumber']);
		$name = mysql_real_escape_string($row_mdb['Name']);

		$mysql_insert_mhs = "INSERT INTO tesmhs VALUES ('$userid','$badgenumber','$name')";
		mysql_query($mysql_insert_mhs);

		echo $userid." , ".$badgenumber." , ".$name." <br>";
	}

	//echo "Semua data berhasil diinput kedalam DB mysql !";
 ?> 