DROP TABLE IMAGE;
DROP TABLE BODYPARTS;
DROP TABLE LIKERT;
DROP TABLE RESULTS;
DROP TABLE TASK;
DROP TABLE PRESCHOOLER;
DROP TABLE GROUPTEST;
DROP TABLE TEST;
DROP TABLE LOCATION;
/**/
CREATE TABLE LOCATION(
	locationID				INTEGER			AUTO_INCREMENT,
	name					VARCHAR(500)	NOT NULL,
	CONSTRAINT location_pk PRIMARY KEY (locationID)
);

CREATE TABLE TEST(
	testID					INTEGER			AUTO_INCREMENT,
	testName				VARCHAR(300)	NOT NULL,
	description				VARCHAR(800)	NOT NULL,
	CONSTRAINT test_pk PRIMARY KEY (testID)
);

CREATE TABLE GROUPTEST(
	groupID					INTEGER			AUTO_INCREMENT,
	groupName				VARCHAR(500)	NOT NULL,
	testID					INTEGER			NOT NULL,
	CONSTRAINT group_pk PRIMARY KEY (groupID),
	CONSTRAINT group_fk FOREIGN KEY (testID) REFERENCES TEST(testID)
);

CREATE TABLE PRESCHOOLER(
	preID					INTEGER			AUTO_INCREMENT,
	name					VARCHAR(300)	NOT NULL,
	age 					INTEGER			NOT NULL,
	gender					VARCHAR(100)	NOT NULL,
	groupID					INTEGER			NULL,
	CONSTRAINT preschooler_pk PRIMARY KEY (preID),
	CONSTRAINT preschooler_fk FOREIGN KEY (groupID) REFERENCES GROUPTEST(groupID)
);

CREATE TABLE TASK(
	taskID				INTEGER			AUTO_INCREMENT,
	instruction				VARCHAR(700)	NOT NULL,
	questionType			VARCHAR(500)	NOT NULL,
	comments				VARCHAR(700)	NULL,
	testID					INTEGER			NOT NULL,
	CONSTRAINT task_pk PRIMARY KEY (taskID),
	CONSTRAINT task_fk FOREIGN KEY (testID) REFERENCES TEST(testID)
);

CREATE TABLE IMAGE(
	imageID					INTEGER			AUTO_INCREMENT,
	address					VARCHAR(300)	NOT NULL,
	taskID					INTEGER			NOT NULL,
	CONSTRAINT image_pk PRIMARY KEY (imageID),
	CONSTRAINT image_fk FOREIGN KEY (taskID) REFERENCES TASK(taskID)
);

CREATE TABLE RESULTS(
	dateCollected			DATE			NOT NULL,
	taskID					INTEGER			NOT NULL,
	preID					INTEGER			NOT NULL,
	CONSTRAINT results_pk PRIMARY KEY (taskID, preID),
	CONSTRAINT results_fk1 FOREIGN KEY (taskID) REFERENCES TASK(taskID),
	CONSTRAINT results_fk2 FOREIGN KEY (preID) REFERENCES PRESCHOOLER(preID)
);

CREATE TABLE LIKERT(
	answer					VARCHAR(100)	NOT NULL,
	dateCollected			DATE			NOT NULL,
	taskID					INTEGER			NOT NULL,
	preID					INTEGER			NOT NULL,
	CONSTRAINT likert_pk PRIMARY KEY (taskID, preID),
	CONSTRAINT likert_fk1 FOREIGN KEY (taskID) REFERENCES TASK(taskID),
	CONSTRAINT likert_fk2 FOREIGN KEY (preID) REFERENCES PRESCHOOLER(preID)
	/*CONSTRAINT likert_fk3 FOREIGN KEY (dateCollected) REFERENCES RESULTS(dateCollected)*/
);

CREATE TABLE BODYPARTS(
	x						DECIMAL(5,2)	NOT NULL,
	y						DECIMAL(5,2)	NOT NULL
	/*dateCollected			DATE			NOT NULL,
	taskID					INTEGER			NOT NULL,
	preID					INTEGER			NOT NULL,
	CONSTRAINT likert_pk PRIMARY KEY (taskID, preID),
	CONSTRAINT likert_fk1 FOREIGN KEY (taskID) REFERENCES TASK(taskID),
	CONSTRAINT likert_fk2 FOREIGN KEY (preID) REFERENCES PRESCHOOLER(preID)*/
);

CREATE TABLE RANKING(
	x						DECIMAL(5,2)	NOT NULL,
	y						DECIMAL(5,2)	NOT NULL
	/*dateCollected			DATE			NOT NULL,
	taskID					INTEGER			NOT NULL,
	preID					INTEGER			NOT NULL,
	CONSTRAINT likert_pk PRIMARY KEY (taskID, preID),
	CONSTRAINT likert_fk1 FOREIGN KEY (taskID) REFERENCES TASK(taskID),
	CONSTRAINT likert_fk2 FOREIGN KEY (preID) REFERENCES PRESCHOOLER(preID)*/
);
