/*USERS*/
/*user admin with password admin1*/
SET
@username = "admin",
@password = "e00cf25ad42683b3df678c61f42c6bda",
@email = "admin@gmail.com",
@accountType = true,
@fullName = "admin",
@accepted = 1;
INSERT INTO USERS(username, password, email, accountType, fullName, accepted) VALUES (@username, @password, @email, @accountType, @fullName, @accepted);


/*LOCATION*/
SET
@name = "University of Wollongong";
INSERT INTO LOCATION(name) VALUES (@name);

SET
@name = "Mulberry Hill Preschool";
INSERT INTO LOCATION(name) VALUES (@name);

SET
@name = "Smith Preschool";
INSERT INTO LOCATION(name) VALUES (@name);

SET
@name = "Miranda Kindergarten";
INSERT INTO LOCATION(name) VALUES (@name);

/*GROUPTEST*/
/*query below fails foreign key restraint*/
SET
@name = "Group 4",
@locationID = 2,
@userID = 5;
INSERT INTO GROUPTEST(name, locationID, userID) VALUES(@name, @locationID, @userID);

/*PRESCHOOLER*/
SET 
@name = "Julia",
@age = 6,
@gender = "Female";
INSERT INTO PRESCHOOLER(name, age, gender) VALUES (@name, @age, @gender);

SET 
@name = "Alex",
@age = 10,
@gender = "Male";
INSERT INTO PRESCHOOLER(name, age, gender) VALUES (@name, @age, @gender);

SET 
@name = "Eric",
@age = 8,
@gender = "Male";
INSERT INTO PRESCHOOLER(name, age, gender) VALUES (@name, @age, @gender);

SET 
@name = "Kate",
@age = 7,
@gender = "Female";
INSERT INTO PRESCHOOLER(name, age, gender) VALUES (@name, @age, @gender);

SET 
@name = "Ren",
@age = 8,
@gender = "Male";
INSERT INTO PRESCHOOLER(name, age, gender) VALUES (@name, @age, @gender);

/*GROUPASSIGNMENT*/
/*Group 4*/
SET
@groupID = 4,
@preID = 2;
INSERT INTO GROUPASSIGNMENT(groupID, preID) VALUES (@groupID, @preID);

SET
@groupID = 4,
@preID = 5;
INSERT INTO GROUPASSIGNMENT(groupID, preID) VALUES (@groupID, @preID);


/*TEST*/
/*no tests necessary?*/

/*LOCATIONASSIGNMENT*/
/*no location necessary?*/

/*TESTASSIGNMENT*/
/*no test assignment?*/

/*TASK*/
/*no tasks?*/

/*TASKASSIGNMENT*/
/*no taskassignment?*/

/*IMAGE*/
/*can we keep these?*/
SET
@address = "images/Puff.png";
INSERT INTO IMAGE(address) VALUES (@address);

SET
@address = "images/orbi.jpg";
INSERT INTO IMAGE(address) VALUES (@address);

SET
@address = "images/peanut.jpg";
INSERT INTO IMAGE(address) VALUES (@address);

SET
@address = "images/pod.jpg";
INSERT INTO IMAGE(address) VALUES (@address);

SET
@address = "images/spike.jpg";
INSERT INTO IMAGE(address) VALUES (@address);

/*IMAGEASSIGNMENT*/
/*no image assignment?*/

/*RESULTS*/
/*no results either?*/
