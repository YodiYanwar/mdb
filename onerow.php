<?php 
	$koneksi = odbc_connect( 'att2000', "", "");

?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Access MDB Test</title>
 </head>
 <body>

<?php 
	//$sql_hapus = "DELETE FROM USERINFO WHERE USERID = 234";
	//$result = odbc_exec($koneksi, $sql_hapus);

	$sql = "SELECT USERID FROM USERINFO WHERE Badgenumber LIKE '17' & '1011%' ORDER BY Name";
	$result = odbc_exec($koneksi, $sql);
	$no = 1;

	while($row = odbc_fetch_array($result)){




	}
		
		
		
?> 

 </body>
 </html>