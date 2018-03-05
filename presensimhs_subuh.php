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
 			<th>Tanggal</th>
 			<th>Waktu Tapping</th>
 		</thead>
 		<tbody>
<?php 
	//$sql_hapus = "DELETE FROM USERINFO WHERE USERID = 234";
	//$result = odbc_exec($koneksi, $sql_hapus);

	// Berdasar Range USERID 
	/*$sql = "SELECT USERID, Format(DateValue(CHECKTIME), 'd/mm/yyyy') AS tgl, Format(TimeValue(CHECKTIME)) AS wkt FROM CHECKINOUT WHERE USERID BETWEEN 1352 AND 1355 AND Format(DateValue(CHECKTIME), 'd/mm/yyyy') BETWEEN #21/09/2017# AND #22/09/2017# ORDER BY USERID, Format(DateValue(CHECKTIME)), Format(TimeValue(CHECKTIME))";*/

	// Range Date belum SOLVED
	/*$sql = "SELECT USERID, Format(DateValue(CHECKTIME), 'd/mm/yyyy') AS tgl, Format(TimeValue(CHECKTIME)) AS wkt FROM CHECKINOUT WHERE USERID = 1352 AND Format(DateValue(CHECKTIME), 'd/mm/yyyy') BETWEEN #18/09/2017# AND #20/09/2017# ORDER BY Format(DateValue(CHECKTIME)), Format(TimeValue(CHECKTIME))";
	*/

	$sql = "SELECT USERID, Format(CHECKTIME, 'dd-mm-yyyy') AS tgl, Format(TimeValue(CHECKTIME)) AS wkt FROM CHECKINOUT WHERE (Format(DateValue(CHECKTIME), 'yyyy-mm-dd') BETWEEN '2017-09-15' AND '2017-09-30') AND (Format(TimeValue(CHECKTIME)) BETWEEN '04:00:00' AND '06:00:00') AND (USERID = 1352) ORDER BY USERID, Format(DateValue(CHECKTIME), 'yyyy-mm-dd'), Format(TimeValue(CHECKTIME))";

	$result = odbc_exec($koneksi, $sql);
	$no = 1;

	while($row = odbc_fetch_array($result)){

		$tapping = strtotime($row['wkt']);
		
 ?> 		
 			<tr>
 				<td><?php echo $no; ?></td>
 				<td><?php echo $row['USERID']; ?></td>
 				<td><?php echo $row['tgl']; ?></td>
 				<td><?php echo $row['wkt']; ?></td>
 			</tr>
 		</tbody>
 		
 <?php $no++; } ?>
 	</table>
 </body>
 </html>