<?php 

	header("Content-type:application/json");
	$koneksi = odbc_connect( 'att2000', "", "");
/*
	if ($koneksi) {
		echo 'Connected';
	} else{
		echo 'Failed';
	}
*/
	


	$sql = "SELECT USERID,Badgenumber,Name FROM USERINFO WHERE Badgenumber LIKE '1710209%' ORDER BY Name";
	$result = odbc_exec($koneksi, $sql);

	//echo $koneksi;

	while($row = odbc_fetch_array($result)){
		echo json_encode($row, JSON_PRETTY_PRINT);
	}
		
 ?> 		