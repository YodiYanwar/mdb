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
 			<th>NIM</th>
 			<th>Tanggal</th>
 			<th>Shubuh</th>
 			<th>Dzuhur</th>
 			<th>Ashar</th>
 			<th>Maghrib</th>
 			<th>Isya</th>
 		</thead>
 		<tbody>
<?php 
	//$sql_hapus = "DELETE FROM USERINFO WHERE USERID = 234";
	//$result = odbc_exec($koneksi, $sql_hapus);

	$angkatan = 18;

		$from = date('Y-m-d', strtotime('2018-11-16'));
		$to = date('Y-m-d', strtotime('2018-11-17'));

		$shubuhFrom = date('H.i.s', strtotime('04.00.00'));
		$shubuhTo = date('H.i.s', strtotime('07.00.00'));
		$dzuhurFrom = date('H.i.s', strtotime('12.00.00'));
		$dzuhurTo = date('H.i.s', strtotime('14.00.00'));
		$asharFrom = date('H.i.s', strtotime('15.00.00'));
		$asharTo = date('H.i.s', strtotime('17.35.00'));
		$maghribFrom = date('H.i.s', strtotime('18.00.00'));
		$maghribTo = date('H.i.s', strtotime('18.45.00'));
		$isyaFrom = date('H.i.s', strtotime('19.00.00'));
		$isyaTo = date('H.i.s', strtotime('21.45.00'));		


	$sql = "SELECT t.Badgenumber AS nim, Format(t.tanggal, 'yyyy-mm-dd') AS tgl, Format(TimeValue(Min(t.CHECKTIME))) As shubuh, Format(TimeValue(Min(d.CHECKTIME))) As dzuhur, Format(TimeValue(Min(a.CHECKTIME))) As ashar, Format(TimeValue(Min(m.CHECKTIME))) As maghrib, Format(TimeValue(Min(i.CHECKTIME))) As isya FROM (((( SELECT Format(DateValue(CHECKTIME)) As tanggal, Format(TimeValue(CHECKTIME)) As tapping, ua.userid, ua.Badgenumber, CHECKTIME FROM CHECKINOUT ca LEFT JOIN USERINFO ua ON ca.userid = ua.userid WHERE (Format(DateValue(ca.CHECKTIME), 'yyyy-mm-dd') BETWEEN '$from' AND '$to') AND (Format(TimeValue(ca.CHECKTIME)) BETWEEN '$shubuhFrom' AND '$shubuhTo') AND (ua.Badgenumber LIKE '$angkatan%') )t LEFT JOIN ( SELECT Format(DateValue(CHECKTIME)) As tanggal, Format(TimeValue(CHECKTIME)) As tapping, ub.userid, ub.Badgenumber, CHECKTIME FROM CHECKINOUT cb LEFT JOIN USERINFO ub ON cb.userid = ub.userid WHERE (Format(DateValue(cb.CHECKTIME), 'yyyy-mm-dd') BETWEEN '$from' AND '$to') AND (Format(TimeValue(cb.CHECKTIME)) BETWEEN '$dzuhurFrom' AND '$dzuhurTo') AND (ub.Badgenumber LIKE '$angkatan%') )d ON (t.userid = d.userid) AND (t.tanggal = d.tanggal)) LEFT JOIN ( SELECT Format(DateValue(CHECKTIME)) As tanggal, Format(TimeValue(CHECKTIME)) As tapping, uc.userid, uc.Badgenumber, CHECKTIME FROM CHECKINOUT cc LEFT JOIN USERINFO uc ON cc.userid = uc.userid WHERE (Format(DateValue(cc.CHECKTIME), 'yyyy-mm-dd') BETWEEN '$from' AND '$to') AND (Format(TimeValue(cc.CHECKTIME)) BETWEEN '$asharFrom' AND '$asharTo') AND (uc.Badgenumber LIKE '$angkatan%') )a ON (t.userid = a.userid) AND (t.tanggal = a.tanggal)) LEFT JOIN ( SELECT Format(DateValue(CHECKTIME)) As tanggal, Format(TimeValue(CHECKTIME)) As tapping, ud.userid, ud.Badgenumber, CHECKTIME FROM CHECKINOUT cd LEFT JOIN USERINFO ud ON cd.userid = ud.userid WHERE (Format(DateValue(cd.CHECKTIME), 'yyyy-mm-dd') BETWEEN '$from' AND '$to') AND (Format(TimeValue(cd.CHECKTIME)) BETWEEN '$maghribFrom' AND '$maghribTo') AND (ud.Badgenumber LIKE '$angkatan%') )m ON (t.userid = m.userid) AND (t.tanggal = m.tanggal)) LEFT JOIN ( SELECT Format(DateValue(CHECKTIME)) As tanggal, Format(TimeValue(CHECKTIME)) As tapping, ue.userid, ue.Badgenumber, CHECKTIME FROM CHECKINOUT ce LEFT JOIN USERINFO ue ON ce.userid = ue.userid WHERE (Format(DateValue(ce.CHECKTIME), 'yyyy-mm-dd') BETWEEN '$from' AND '$to') AND (Format(TimeValue(ce.CHECKTIME)) BETWEEN '$isyaFrom' AND '$isyaTo') AND (ue.Badgenumber LIKE '$angkatan%') )i ON (t.userid = i.userid) AND (t.tanggal = i.tanggal) GROUP BY t.userid, t.tanggal, ua.Badgenumber ORDER BY t.userid, t.tanggal";
	$result = odbc_exec($koneksi, $sql);
	$no = 1;

	while($row = odbc_fetch_array($result)){
		
		
		
 ?> 		
 			<tr>
 				<td><?php echo $row['nim']; ?></td>
 				<td><?php echo $row['tgl']; ?></td>
 				<td><?php if($row['shubuh'] == NULL){echo NULL;}else{echo date('H:i:s', strtotime($row['shubuh']));}?></td>
 				<td><?php if($row['dzuhur'] == NULL){echo NULL;}else{echo date('H:i:s', strtotime($row['dzuhur']));}?></td>
 				<td><?php if($row['ashar'] == NULL){echo NULL;}else{echo date('H:i:s', strtotime($row['ashar']));}?></td>
 				<td><?php if($row['maghrib'] == NULL){echo NULL;}else{echo date('H:i:s', strtotime($row['maghrib']));}?></td>
 				<td><?php if($row['isya'] == NULL){echo NULL;}else{echo date('H:i:s', strtotime($row['isya']));}?></td>
 				<!-- <td><?php echo ucwords(strtolower($row['Name'])); ?></td> -->
 			</tr>
 		</tbody>
 		
 <?php $no++; } ?>
 	</table>
 </body>
 </html>