CREATE TABLE dateperiod(
	period_id AUTOINCREMENT primary key,
	date_from date,
	date_to date
)

INSERT INTO dateperiod(date_from, date_to) VALUES ('01/04/2018', '30/04/2018');
INSERT INTO dateperiod(date_from, date_to) VALUES ('01/05/2018', '30/05/2018');


CREATE TABLE sessionrange(
	sessionrange_id AUTOINCREMENT primary key,
	session char(20),
	session_from time,
	session_to time
)

INSERT INTO sessionrange(session, session_from, session_to) VALUES ('shubuh', '04.00.00', '06.00.00');
INSERT INTO sessionrange(session, session_from, session_to) VALUES ('dzuhur', '12.00.00', '13.00.00');
INSERT INTO sessionrange(session, session_from, session_to) VALUES ('ashar', '15.00.00', '16.00.00');
INSERT INTO sessionrange(session, session_from, session_to) VALUES ('maghrib', '18.00.00', '18.35.00');
INSERT INTO sessionrange(session, session_from, session_to) VALUES ('isya', '19.00.00', '20.00.00');

INSERT INTO sessionrange(session, session_from, session_to) VALUES ('shubuh', '04.00.00', '06.00.00');
INSERT INTO sessionrange(session, session_from, session_to) VALUES ('dzuhur', '12.00.00', '13.00.00');
INSERT INTO sessionrange(session, session_from, session_to) VALUES ('ashar', '15.00.00', '16.00.00');
INSERT INTO sessionrange(session, session_from, session_to) VALUES ('maghrib', '18.00.00', '18.35.00');
INSERT INTO sessionrange(session, session_from, session_to) VALUES ('isya', '19.00.00', '20.00.00');


CREATE TABLE timesetup(
	period_id int CONSTRAINT period_id REFERENCES dateperiod(period_id),
	sessionrange_id int CONSTRAINT sessionrange_id REFERENCES sessionrange(sessionrange_id)
)

INSERT INTO timesetup (period_id, sessionrange_id) VALUES ('1', '1');
INSERT INTO timesetup (period_id, sessionrange_id) VALUES ('1', '2');
INSERT INTO timesetup (period_id, sessionrange_id) VALUES ('1', '3');
INSERT INTO timesetup (period_id, sessionrange_id) VALUES ('1', '4');
INSERT INTO timesetup (period_id, sessionrange_id) VALUES ('1', '5');
INSERT INTO timesetup (period_id, sessionrange_id) VALUES ('2', '6');
INSERT INTO timesetup (period_id, sessionrange_id) VALUES ('2', '7');
INSERT INTO timesetup (period_id, sessionrange_id) VALUES ('2', '8');
INSERT INTO timesetup (period_id, sessionrange_id) VALUES ('2', '9');
INSERT INTO timesetup (period_id, sessionrange_id) VALUES ('2', '10');



SELECT userid, tanggal As [date], Format(TimeValue(Min(t.CHECKTIME))) As tapping_on, session FROM 
    (
        SELECT session_from, session_to, date_from, date_to, session
        FROM ((timesetup i
        LEFT JOIN dateperiod d ON i.period_id = d.period_id)
        LEFT JOIN sessionrange q ON i.sessionrange_id = q.sessionrange_id)
    ) As s
INNER JOIN 
    (SELECT Format(DateValue(CHECKTIME)) As tanggal, Format(TimeValue(CHECKTIME)) As tapping, userid, CHECKTIME
    FROM CHECKINOUT WHERE userid = 1352 ORDER BY CHECKTIME) t
ON ((t.tanggal BETWEEN s.date_from AND s.date_to) AND (t.tapping BETWEEN s.session_from AND s.session_to))
GROUP BY userid, tanggal, session

---------------------------------- TA'LIM ------------------------------------------------------------------------------


CREATE TABLE talim_dateperiod(
	talim_period_id AUTOINCREMENT primary key,
	talim_date_from date,
	talim_date_to date
)

INSERT INTO talim_dateperiod(talim_date_from, talim_date_to) VALUES ('02/03/2018', '08/03/2018');

CREATE TABLE talim_sessionrange(
	talim_sessionrange_id AUTOINCREMENT primary key,
	talim_session char(20),
	talim_session_from time,
	talim_session_to time
)

INSERT INTO talim_sessionrange(talim_session, talim_session_from, talim_session_to) VALUES ('aftershubuh', '04.00.00', '06.00.00');
INSERT INTO talim_sessionrange(talim_session, talim_session_from, talim_session_to) VALUES ('afterisya', '19.00.00', '20.00.00');

CREATE TABLE talim_timesetup(
	talim_period_id int CONSTRAINT talim_period_id REFERENCES talim_dateperiod(talim_period_id),
	talim_sessionrange_id int CONSTRAINT talim_sessionrange_id REFERENCES talim_sessionrange(talim_sessionrange_id)
)

INSERT INTO talim_timesetup (talim_period_id, talim_sessionrange_id) VALUES ('1', '1');
INSERT INTO talim_timesetup (talim_period_id, talim_sessionrange_id) VALUES ('1', '2');


SELECT userid AS id_mahasiswa, Format(DateValue(c.CHECKTIME), 'dd-mm-yyyy') AS tgl, Format(TimeValue(Min(t.CHECKTIME))) As wkt_tapping, talim_session AS wkt_shalat 
FROM (
	SELECT talim_session_from, talim_session_to, talim_date_from, talim_date_to, talim_session 
	FROM (
		(talim_timesetup i LEFT JOIN talim_dateperiod d ON i.talim_period_id = d.talim_period_id) 
		LEFT JOIN talim_sessionrange q ON i.talim_sessionrange_id = q.talim_sessionrange_id
	)
) As s 
INNER JOIN (
	SELECT Format(DateValue(CHECKTIME)) As tanggal, Format(TimeValue(CHECKTIME)) AS tapping, u.userid, u.Badgenumber, CHECKTIME 
	FROM CHECKINOUT c 
	LEFT JOIN USERINFO u ON c.userid = u.userid 
	WHERE (Format(DateValue(c.CHECKTIME), 'yyyy-mm-dd')  BETWEEN '2018-03-05' AND '2018-03-05') AND (u.Badgenumber LIKE '17%')
) t ON ((t.tanggal BETWEEN s.talim_date_from AND s.talim_date_to) AND (t.tapping BETWEEN s.talim_session_from AND s.talim_session_to)) 
GROUP BY userid, Format(DateValue(c.CHECKTIME), 'dd-mm-yyyy'), talim_session 
ORDER BY userid, Format(DateValue(c.CHECKTIME), 'dd-mm-yyyy'), Format(TimeValue(Min(t.CHECKTIME)))