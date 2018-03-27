CREATE TABLE dateperiod(
	period_id int primary key,
	date_from date,
	date_to date
)

INSERT INTO dateperiod(period_id, date_from, date_to) VALUES ('1', '01/09/2017', '02/09/2017');
INSERT INTO dateperiod(period_id, date_from, date_to) VALUES ('2', '03/09/2017', '04/09/2017');


CREATE TABLE sessionrange(
	sessionrange_id int primary key,
	session char(20),
	session_from time,
	session_to time
)

INSERT INTO sessionrange(sessionrange_id, session, session_from, session_to) VALUES ('1', 'shubuh', '04.00.00', '05.00.00');
INSERT INTO sessionrange(sessionrange_id, session, session_from, session_to) VALUES ('2', 'dzuhur', '12.00.00', '13.00.00');
INSERT INTO sessionrange(sessionrange_id, session, session_from, session_to) VALUES ('3', 'ashar', '15.00.00', '16.00.00');
INSERT INTO sessionrange(sessionrange_id, session, session_from, session_to) VALUES ('4', 'maghrib', '18.00.00', '18.35.00');
INSERT INTO sessionrange(sessionrange_id, session, session_from, session_to) VALUES ('5', 'isya', '19.00.00', '20.00.00');

INSERT INTO sessionrange(sessionrange_id, session, session_from, session_to) VALUES ('6', 'shubuh', '04.00.00', '05.00.00');
INSERT INTO sessionrange(sessionrange_id, session, session_from, session_to) VALUES ('7', 'dzuhur', '12.00.00', '13.00.00');
INSERT INTO sessionrange(sessionrange_id, session, session_from, session_to) VALUES ('8', 'ashar', '15.00.00', '16.00.00');
INSERT INTO sessionrange(sessionrange_id, session, session_from, session_to) VALUES ('9', 'maghrib', '18.00.00', '18.35.00');
INSERT INTO sessionrange(sessionrange_id, session, session_from, session_to) VALUES ('10', 'isya', '19.00.00', '20.00.00');


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