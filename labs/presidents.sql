# Presidents of the United States
# Authors: Christopher Barnett, Daniel Jast

CREATE DATABASE IF NOT EXISTS site_db;
USE site_db;
DROP TABLE IF EXISTS presidents;
CREATE TABLE presidents
(
	id INT AUTO_INCREMENT PRIMARY KEY,
	fname TEXT NOT NULL,
	lname TEXT NOT NULL,
	number int NOT NULL,
	dob DATETIME NOT NULL
);

INSERT INTO presidents (fname, lname, number, dob)
VALUES 	("Thomas", "Jefferson", 3, '1743-04-17 00:00:00'),
		("Andrew", "Jackson", 7, '1767-03-15 00:00:00'),
		("Theodore", "Roosevelt", 26, '1858-10-27 00:00:00'),
		("John", "Kennedy", 35, '1917-05-29 00:00:00'),
		("Richard", "Nixon", 37, '1913-01-09 00:00:00');

SELECT *
FROM presidents;

SELECT lname, number, dob
FROM presidents
ORDER BY number ASC;

SELECT lname, number, dob
FROM presidents
ORDER BY lname ASC;

SELECT lname, number, dob
FROM presidents
ORDER BY dob DESC;

