<?php 
	$koneksi = odbc_connect( 'att2000', "", "");
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Access MDB Test</title>
 </head>
 <body>
 	<table border="1">
 		<thead>
 			<th>ID Mahasiswa</th>
 			<th>Tanggal</th>
 			<th>Tapping</th>
 			<th>Ta'lim</th>
 		</thead>
 		<tbody>
<?php

	$sql = "SELECT userid AS id_mahasiswa, Format(DateValue(c.CHECKTIME), 'dd-mm-yyyy') AS tgl, Format(TimeValue(Min(t.CHECKTIME))) As wkt_tapping, talim_session AS talim FROM ( SELECT talim_session_from, talim_session_to, talim_date_from, talim_date_to, talim_session FROM ( (talim_timesetup i LEFT JOIN talim_dateperiod d ON i.talim_period_id = d.talim_period_id) LEFT JOIN talim_sessionrange q ON i.talim_sessionrange_id = q.talim_sessionrange_id ) ) As s INNER JOIN ( SELECT Format(DateValue(CHECKTIME)) As tanggal, Format(TimeValue(CHECKTIME)) AS tapping, u.userid, u.Badgenumber, CHECKTIME FROM CHECKINOUT c LEFT JOIN USERINFO u ON c.userid = u.userid WHERE (Format(DateValue(c.CHECKTIME), 'yyyy-mm-dd') BETWEEN '2018-03-05' AND '2018-03-05') AND (u.Badgenumber LIKE '17%') ) t ON ((t.tanggal BETWEEN s.talim_date_from AND s.talim_date_to) AND (t.tapping BETWEEN s.talim_session_from AND s.talim_session_to)) GROUP BY userid, Format(DateValue(c.CHECKTIME), 'dd-mm-yyyy'), talim_session ORDER BY userid, Format(DateValue(c.CHECKTIME), 'dd-mm-yyyy'), Format(TimeValue(Min(t.CHECKTIME)))";

	//$angkatan = "1710";

	$result = odbc_exec($koneksi, $sql);

	while($row = odbc_fetch_array($result)){
 ?> 		
 			<tr>
 				<td><?php echo $row['id_mahasiswa'];; ?></td>
 				<td><?php echo date('d-m-Y', strtotime($row['tgl'])); ?></td>
 				<td><?php echo date('h:i:s', strtotime($row['wkt_tapping'])); ?></td>
 				<td><?php echo $row['talim']; ?></td>
 			</tr>
 		</tbody>
 		
 <?php  } ?>
 	</table>
 </body>
 </html>