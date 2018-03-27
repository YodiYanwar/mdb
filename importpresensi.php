<?php 

	$koneksi_mdb = odbc_connect( 'att2000', "", "");

	mysql_connect("localhost", "root", "");
	mysql_select_db("simon");	
/*
	if ($koneksi) {
		echo 'Connected';
	} else{
		echo 'Failed';
	}
*/
	
	$sql = "SELECT userid AS id_mahasiswa, Format(tanggal, 'yyyy-mm-dd') AS tgl, Format(TimeValue(Min(t.CHECKTIME))) As wkt_tapping, session AS wkt_shalat FROM (SELECT session_from, session_to, date_from, date_to, session FROM ((timesetup i LEFT JOIN dateperiod d ON i.period_id = d.period_id) LEFT JOIN sessionrange q ON i.sessionrange_id = q.sessionrange_id)) As s INNER JOIN (SELECT Format(DateValue(CHECKTIME)) As tanggal, Format(TimeValue(CHECKTIME)) As tapping, u.userid, u.Badgenumber, CHECKTIME FROM CHECKINOUT c LEFT JOIN USERINFO u ON c.userid = u.userid WHERE (Format(DateValue(c.CHECKTIME), 'yyyy-mm-dd')  BETWEEN '2017-09-30' AND '2017-09-29') AND (u.Badgenumber LIKE '17101%') AND (c.userid = 1352)) t ON ((t.tanggal BETWEEN s.date_from AND s.date_to) AND (t.tapping BETWEEN s.session_from AND s.session_to)) GROUP BY userid, tanggal, session, u.Badgenumber ORDER BY userid, tanggal, Format(TimeValue(Min(t.CHECKTIME)))";

	$result = odbc_exec($koneksi_mdb, $sql);

	//echo $koneksi;

	while($row_mdb = odbc_fetch_array($result)){

		$wktNew = date('h:i:s', strtotime($row_mdb['wkt_tapping']));
		$tglNew = date('Y-m-d', strtotime($row_mdb['tgl']));	

		//if(strpos($row_mdb['Name'], $row_mdb['Badgenumber']) === FALSE){
		$mysql_insert_presensi = "INSERT INTO shalat (id_mahasiswa, tanggal, wkt_tapping, wkt_shalat) VALUES ('".$row_mdb['id_mahasiswa']."', '$tglNew', '$wktNew','".$row_mdb['wkt_shalat']."')";

		mysql_query($mysql_insert_presensi);

		echo $row_mdb['id_mahasiswa']."  ".$tglNew."  ".$wktNew."  ".$row_mdb['wkt_shalat']." <br>";
	}

	//echo "Semua data berhasil diinput kedalam DB mysql !";
 ?> 