<?php 
	$koneksi = odbc_connect( 'attBackup', "", "");

/*	if ($koneksi) {
		echo 'Connected';
	} else{
		echo 'Failed';
	}*/
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Access MDB Test</title>
 </head>
 <body>
 	<table border="1">
 		<!-- <thead>
 			<th>ID Mahasiswa</th>
 			<th>Tanggal</th>
 			<th>Waktu Tapping</th>
 			<th>Waktu Shalat</th>
 		</thead> -->
 		<thead>
 			<th>ID Mahasiswa</th>
 			<th>Tanggal</th>
 			<th>Tapping</th>
 			<th>Shalat</th>
 			
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

	$sql = "SELECT userid AS id_mahasiswa, Format(tanggal, 'yyyy-mm-dd') AS tgl, Format(TimeValue(Min(t.CHECKTIME))) As wkt_tapping, session AS wkt_shalat FROM (SELECT session_from, session_to, date_from, date_to, session FROM ((timesetup i LEFT JOIN dateperiod d ON i.period_id = d.period_id) LEFT JOIN sessionrange q ON i.sessionrange_id = q.sessionrange_id)) As s INNER JOIN (SELECT Format(DateValue(CHECKTIME)) As tanggal, Format(TimeValue(CHECKTIME)) As tapping, u.userid, u.Badgenumber, CHECKTIME FROM CHECKINOUT c LEFT JOIN USERINFO u ON c.userid = u.userid WHERE (Format(DateValue(c.CHECKTIME), 'yyyy-mm-dd')  BETWEEN '2017-09-30' AND '2017-09-30') AND (u.Badgenumber LIKE '1710%') AND (u.userid = 1174)) t ON ((t.tanggal BETWEEN s.date_from AND s.date_to) AND (t.tapping BETWEEN s.session_from AND s.session_to)) GROUP BY userid, tanggal, session, u.Badgenumber ORDER BY userid, tanggal, Format(TimeValue(Min(t.CHECKTIME)))";

	//$angkatan = "1710";

	//$sql = "SELECT USERID, Badgenumber, Name FROM USERINFO WHERE Badgenumber LIKE '1710%' AND Name NOT LIKE '17%' ORDER BY Name";


	$result = odbc_exec($koneksi, $sql);

	echo $sql;


	while($row = odbc_fetch_array($result)){

		//$tapping = strtotime($row['wkt']);
		
 ?> 		
 			<tr>
 				<td><?php echo $row['id_mahasiswa'];; ?></td>
 				<td><?php echo date('Y-m-d', strtotime($row['tgl'])); ?></td>
 				<td><?php echo date('h:i:s', strtotime($row['wkt_tapping'])); ?></td>
 				<td><?php echo $row['wkt_shalat']; ?></td>
 			</tr>
 		</tbody>
 		
 <?php  } ?>
 	</table>
 </body>
 </html>