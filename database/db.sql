DROP TABLE RANKING;
DROP TABLE RESULTS;
DROP TABLE GROUPASSIGNMENT;
DROP TABLE TESTASSIGNMENT;
DROP TABLE TASKASSIGNMENT;
DROP TABLE IMAGEASSIGNMENT;
DROP TABLE IMAGE;
DROP TABLE TASK;
DROP TABLE PRESCHOOLER;
DROP TABLE GROUPTEST;
DROP TABLE LOCATIONASSIGNMENT;
DROP TABLE LOCATION;
DROP TABLE USERS;
DROP TABLE TEST;

CREATE TABLE USERS (
	userID					INTEGER			AUTO_INCREMENT,
	username				VARCHAR(100)	NOT NULL,
	password				VARCHAR(100)	NOT NULL,
	email					VARCHAR(100)	NOT NULL,
	accountType				BOOLEAN			NOT NULL,
	fullName				VARCHAR(300)	NOT NULL,
	accepted				INTEGER			NOT NULL,
	token					VARCHAR(300)  	NULL,			
	CONSTRAINT users_pk PRIMARY KEY (userID)
);

CREATE TABLE LOCATION (
	locationID				INTEGER			AUTO_INCREMENT,
	name					VARCHAR(500)	NOT NULL,
	CONSTRAINT location_pk PRIMARY KEY (locationID)
);

CREATE TABLE GROUPTEST (
	groupID					INTEGER			AUTO_INCREMENT,
	name					VARCHAR(500)	NOT NULL,
	locationID				INTEGER			NOT NULL,
	userID					INTEGER			NOT NULL,
	CONSTRAINT group_pk PRIMARY KEY (groupID),
	CONSTRAINT group_fk1 FOREIGN KEY (locationID) REFERENCES LOCATION(locationID),
	CONSTRAINT group_fk2 FOREIGN KEY (userID) REFERENCES USERS(userID)
);

CREATE TABLE PRESCHOOLER(
	preID					INTEGER			AUTO_INCREMENT,
	name					VARCHAR(300)	NOT NULL,
	age 					INTEGER			NOT NULL,
	gender					VARCHAR(100)	NOT NULL,
	CONSTRAINT preschooler_pk PRIMARY KEY (preID)
);

CREATE TABLE GROUPASSIGNMENT(
	groupID					INTEGER			NOT NULL,
	preID					INTEGER			NOT NULL,
	CONSTRAINT ga_pk PRIMARY KEY (groupID, preID),
	CONSTRAINT ga_fk1 FOREIGN KEY (groupID) REFERENCES GROUPTEST(groupID),
	CONSTRAINT ga_fk2 FOREIGN KEY (preID) REFERENCES PRESCHOOLER(preID)
);

CREATE TABLE TEST(
	testID					INTEGER			AUTO_INCREMENT,
	title					VARCHAR(500)	NOT NULL,
	description				VARCHAR(700)	NULL,
	dateCreated				DATE			NOT NULL,
	dateEdited				DATE			NULL,
	CONSTRAINT test_pk PRIMARY KEY (testID)
);

CREATE TABLE LOCATIONASSIGNMENT(
	locationID				INTEGER			NOT NULL,
	userID					INTEGER			NOT NULL,
	CONSTRAINT la_pk PRIMARY KEY (locationID, userID),
	CONSTRAINT la_fk1 FOREIGN KEY (locationID) REFERENCES LOCATION(locationID),
	CONSTRAINT la_fk2 FOREIGN KEY (userID)	REFERENCES USERS(userID)
);

CREATE TABLE TESTASSIGNMENT(
	userID					INTEGER			NOT NULL,
	testID					INTEGER			NOT NULL,
	/*status					VARCHAR(200)	NOT NULL,*/
	dateConducted			DATE			NULL,
	CONSTRAINT ta_pk PRIMARY KEY (userID, testID),
	CONSTRAINT ta_fk1 FOREIGN KEY (userID) REFERENCES USERS(userID),
	CONSTRAINT ta_fk2 FOREIGN KEY (testID) REFERENCES TEST(testID)
);

CREATE TABLE TASK(
	taskTitle				VARCHAR(500)	NOT NULL,
	taskID					INTEGER			AUTO_INCREMENT,
	instruction				VARCHAR(700)	NOT NULL,
	activityStyle			VARCHAR(500)	NOT NULL,
	dateCreated				DATE			NOT NULL,
	CONSTRAINT task_pk PRIMARY KEY (taskID)
);

CREATE TABLE TASKASSIGNMENT(
	testID					INTEGER			NOT NULL,
	taskID					INTEGER			NOT NULL,
	orderInTest				INTEGER			NOT NULL,
	comments				VARCHAR(700)	NULL,
	pointsInterval			INTEGER			NULL,
	CONSTRAINT tska_pk PRIMARY KEY (testID, taskID),
	CONSTRAINT tska_fk1 FOREIGN KEY (testID) REFERENCES TEST(testID),
	CONSTRAINT tska_fk2 FOREIGN KEY (taskID) REFERENCES TASK(taskID)
);

CREATE TABLE IMAGE(
	imageID					INTEGER			AUTO_INCREMENT,
	address					VARCHAR(300)	NOT NULL,
	/*imgType					BOOLEAN			NOT NULL,
	taskID					INTEGER			NOT NULL,*/
	CONSTRAINT image_pk PRIMARY KEY (imageID)
);

CREATE TABLE IMAGEASSIGNMENT(
	imageID					INTEGER			NOT NULL,
	taskID					INTEGER			NOT NULL,
	CONSTRAINT image_pk PRIMARY KEY (imageID, taskID),
	CONSTRAINT image_fk1 FOREIGN KEY (imageID) REFERENCES IMAGE(imageID),
	CONSTRAINT image_fk2 FOREIGN KEY (taskID) REFERENCES TASK(taskID)
);

CREATE TABLE RESULTS(
	mechanic				VARCHAR(20)		NULL,
	x						DECIMAL(10,5)	NULL,
	y						DECIMAL(10,5)	NULL,
	happy					BOOLEAN			NULL,
	otherComment			VARCHAR(500)	NULL,
	/*dateCollected			DATE			NOT NULL,*/
	testID					INTEGER			NOT NULL,
	taskID					INTEGER			NOT NULL,
	preID					INTEGER			NOT NULL,
	CONSTRAINT result_pk PRIMARY KEY (taskID, preID, testID),
	CONSTRAINT result_fk1 FOREIGN KEY (taskID) REFERENCES TASK (taskID),
	CONSTRAINT result_fk2 FOREIGN KEY (preID) REFERENCES PRESCHOOLER (preID),
	CONSTRAINT result_fk3 FOREIGN KEY (testID) REFERENCES TEST (testID)
);

CREATE TABLE RANKING(
	imageID					INTEGER			NOT NULL,
	score					INTEGER			NOT NULL,
	testID					INTEGER			NOT NULL,
	taskID					INTEGER			NOT NULL,
	preID					INTEGER			NOT NULL
	/*CONSTRAINT ranking_pk PRIMARY KEY (taskID, preID, testID),
	CONSTRAINT ranking_fk1 FOREIGN KEY (taskID) REFERENCES TASK (taskID),
	CONSTRAINT ranking_fk2 FOREIGN KEY (preID) REFERENCES PRESCHOOLER (preID),
	CONSTRAINT ranking_fk3 FOREIGN KEY (testID) REFERENCES TEST (testID)
	CONSTRAINT ranking_fk4 FOREIGN KEY (imageID) REFERENCES IMAGE (imageID)*/
);
