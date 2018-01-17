<?php 
	$koneksi = odbc_connect( 'att2000', "", "");
/*
	if ($koneksi) {
		echo 'Connected';
	} else{
		echo 'Failed';
	}
*/




 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Access MDB Test</title>
 </head>
 <body>
 	<table border="1">
 		<thead>
 			<th>No</th>
 			<th>User ID</th>
 			<th>NIM</th>
 			<th>Nama</th>
 		</thead>
 		<tbody>
<?php 
	//$sql_hapus = "DELETE FROM USERINFO WHERE USERID = 234";
	//$result = odbc_exec($koneksi, $sql_hapus);


	$sql = "SELECT USERID FROM USERINFO WHERE Badgenumber LIKE '17' & '1011%' ORDER BY Name";
	$result = odbc_exec($koneksi, $sql);
	$no = 1;

	while($row = odbc_fetch_array($result)){
		
		
		
 ?> 		
 			<tr>
 				<td><?php echo $no; ?></td>
 				<td><?php echo $row['USERID']; ?></td>
 				<td><?php echo $row['Badgenumber']; ?></td>
 				<td><?php echo $row['Name']; ?></td>
 			</tr>
 		</tbody>
 		
 <?php $no++; } ?>
 	</table>
 </body>
 </html>