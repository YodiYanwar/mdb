<?php 
	$koneksi = odbc_connect( 'attBackup', "", "");
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
 			<th>Waktu Shalat</th>
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

	$sql = "SELECT USERID, Format(CHECKTIME, 'dd-mm-yyyy') AS tgl, Format(TimeValue(CHECKTIME)) AS wkt FROM CHECKINOUT WHERE (Format(DateValue(CHECKTIME), 'yyyy-mm-dd') BETWEEN '2017-09-30' AND '2017-09-30') AND (USERID BETWEEN 1352 AND 1360) ORDER BY USERID, Format(DateValue(CHECKTIME), 'yyyy-mm-dd'), Format(TimeValue(CHECKTIME))";

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
 				<td><?php if($tapping > strtotime('04:00:00') && $tapping < strtotime('06:00:00')) {
					echo 'Subuh';
				} else
				if($tapping > strtotime('11:45:00') && $tapping < strtotime('13:00:00')){
					echo 'Dzuhur';
				} else
				if($tapping > strtotime('14:45:00') && $tapping < strtotime('17:00:00')){
					echo 'Ashar';
				} else
				if($tapping > strtotime('18:00:00') && $tapping < strtotime('19:00:00')){
					echo 'Maghrib';
				} else
				if($tapping > strtotime('19:15:00') && $tapping < strtotime('20:30:00')){
					echo 'Isya';
				}?></td>
 			</tr>
 		</tbody>
 		
 <?php $no++; } ?>
 	</table>
 </body>
 </html>