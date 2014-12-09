#Author: Christopher Barnett, Daniel Jast
#Purpose: Create a database for lost and found items on the Marist Campus
#Version: 0

#Create the database
CREATE DATABASE IF NOT EXISTS limbo_db;
USE limbo_db;

#Remove the old table
DROP TABLE IF EXISTS users;

#Create new table for users
CREATE TABLE IF NOT EXISTS users (
	user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(20) NOT NULL,
	last_name VARCHAR(40) NOT NULL,
	email VARCHAR(60) NOT NULL,
	pass CHAR(40) NOT NULL,
	reg_date DATETIME NOT NULL,
	phone VARCHAR(15),
	PRIMARY KEY (user_id),
	UNIQUE (email)
	);
	
#Populate users
INSERT INTO users (first_name, last_name, email, pass, reg_date, phone)
VALUES ("admin", "", "admin@limbo.marist.edu", "gaze11e", now(), "(555) 555-5555"),
	   ("Tom", "Smith", "ts123@email.com", "", now(), "(555) 555-5555"),
	   ("Melissa", "Reynolds", "mr123@email.com", "", now(), "(555) 555-5555"),
	   ("Chris", "Griffin", "cg123@email.com", "", now(), "(555) 555-5555"),
       ("John", "Jackson", "jj123@email.com", "", now(), "(555) 555-5555"),
	   ("Jerry", "Anderson", "ja123@email.com", "", now(), "(555) 555-5555"),
	   ("Jack", "Johnson", "jj321@email.com", "", now(), "(555) 555-5555"),
	   ("Mike", "Jordan", "mj123@email.com", "", now(), "(555) 555-5555"),
	   ("Janet", "Day", "jd123@email.com", "", now(), "(555) 555-5555"),
	   ("Amy", "Smith", "as123@email.com", "", now(), "(555) 555-5555"),
	   ("Cave", "Johnson", "cj123@email.com", "", now(), "(555) 555-5555"),
	   ("Trevor", "Phillips", "tp123@email.com", "", now(), "(555) 555-5555"),
       ("Kristen", "Thompson", "kt123@email.com", "", now(), "(555) 555-5555"),
	   ("Joe", "Smith", "js123@email.com", "", now(), "(555) 555-5555");

#Remove the old table
DROP TABLE IF EXISTS stuff;

#Create new table for stuff
CREATE TABLE IF NOT EXISTS stuff (
	stuff_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	location_id INT NOT NULL,
	description TEXT NOT NULL,
	create_date DATETIME NOT NULL,
	update_date DATETIME NOT NULL,
	room TEXT,
	owner TEXT,
	finder TEXT,
	status SET ("found", "lost", "claimed")
	);
	
#Populate stuff
INSERT INTO stuff (location_id, description, create_date, update_date, room, owner, finder, status)
VALUES  (3, "cell phone", now(), now(), "101", "", "2", "found"),
		(5, "text book", now(), now(), "105", "3", "", "lost"),
		(20, "pen", now(), now(), "", "", "4", "found"),
		(17, "laptop", now(), now(), "201", "", "5", "found"),
		(12, "notebook", now(), now(), "106", "6", "7", "claimed"),
		(1, "pencil", now(), now(), "207", "8", "", "lost"),
		(14, "shoe", now(), now(), "0005", "9", "", "lost"),
		(14, "envelope", DATE_SUB(NOW(), INTERVAL 14 DAY), DATE_SUB(NOW(), INTERVAL 14 DAY), "0005", "", "10", "found"),
		(13, "Acura car keys", DATE_SUB(NOW(), INTERVAL 16 DAY), DATE_SUB(NOW(), INTERVAL 16 DAY), "", "", "11", "found"),
		(6, "TI-83 graphing calculator black", DATE_SUB(NOW(), INTERVAL 36 DAY), DATE_SUB(NOW(), INTERVAL 36 DAY), "", "12", "", "lost"),
		(22, "red scarf", DATE_SUB(NOW(), INTERVAL 8 DAY), DATE_SUB(NOW(), INTERVAL 8 DAY), "", "13 ", "", "lost"),
		(26, "black sunglasses", DATE_SUB(NOW(), INTERVAL 180 DAY), DATE_SUB(NOW(), INTERVAL 180 DAY), "", "13", "14", "claimed");
#Remove the old table
DROP TABLE IF EXISTS locations;

#Create new table for locations
CREATE TABLE IF NOT EXISTS locations (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	create_date DATETIME NOT NULL,
	update_date DATETIME NOT NULL,
	name TEXT NOT NULL
	);

#Populate locations
INSERT INTO locations (create_date, update_date, name)
VALUES  (now(), now(), "Byrne House"),
		(now(), now(), "Our Lady Seat of Wisdom Chapel"),
		(now(), now(), "Champagnat Hall"),
		(now(), now(), "Cornell Boathouse"),
		(now(), now(), "Donnelly Hall"),
		(now(), now(), "Dyson Center"),
		(now(), now(), "Fontaine Annex"),
		(now(), now(), "Fontaine Hall"),
		(now(), now(), "Foy Townhouses"),
		(now(), now(), "Fulton Street Townhouses"),
		(now(), now(), "New Fulton Townhouses"),
		(now(), now(), "Gartland Commons"),
		(now(), now(), "Greystone Hall"),
		(now(), now(), "Hancock Center"),
		(now(), now(), "Kieran Gatehouse"),
		(now(), now(), "Kirk House"),
		(now(), now(), "Leo Hall"),
		(now(), now(), "James A. Cannavino Library"),
		(now(), now(), "Lowell Thomas Communications Center"),
		(now(), now(), "Lower Townhouses"),
		(now(), now(), "Marian Hall"),
		(now(), now(), "Marist Boathouse"),
		(now(), now(), "James J. McCann REcreational Center"),
		(now(), now(), "Midrise Hall"),
		(now(), now(), "New Townhouses"),
		(now(), now(), "St Annes Hermitage"),
		(now(), now(), "St Peters"),
		(now(), now(), "Sheahan Hall"),
		(now(), now(), "Steel Plant Art Studios"),
		(now(), now(), "Student Center / Rotunda"),
		(now(), now(), "Tenney Stadium"),
		(now(), now(), "Tennis Pavillion"),
		(now(), now(), "Lower West Cedar Townhouses"),
		(now(), now(), "Upper West Cedar Townhouses");
	
	
#Testing
SELECT *
FROM users;

SELECT *
FROM stuff;

SELECT *
FROM locations;

		