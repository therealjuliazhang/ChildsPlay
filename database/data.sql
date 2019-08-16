/*USERS*/
SET
@username = "holly",
@password = "holly",
@email = "holly@gmail.com",
@accountType = true,
@fullName = "Holly Tootell";
INSERT INTO USERS(username, password, email, accountType, fullName) VALUES (@username, @password, @email, @accountType, @fullName);

SET
@username = "james",
@password = "james",
@email = "james@gmail.com",
@accountType = false,
@fullName = "James Bonds";
INSERT INTO USERS(username, password, email, accountType, fullName) VALUES (@username, @password, @email, @accountType, @fullName);

SET
@username = "emma",
@password = "emma",
@email = "emma@gmail.com",
@accountType = false,
@fullName = "Emma Greens";
INSERT INTO USERS(username, password, email, accountType, fullName) VALUES (@username, @password, @email, @accountType, @fullName);

SET
@username = "jasmine",
@password = "jasmine",
@email = "jasmine@gmail.com",
@accountType = false,
@fullName = "Jasmine Flores";
INSERT INTO USERS(username, password, email, accountType, fullName) VALUES (@username, @password, @email, @accountType, @fullName);

/*LOCATION*/
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
SET
@name = "Group 1",
@locationID = 1;
INSERT INTO GROUPTEST(name, locationID) VALUES(@name, @locationID);

SET
@name = "Group 2",
@locationID = 2;
INSERT INTO GROUPTEST(name, locationID) VALUES(@name, @locationID);

SET
@name = "Group 3",
@locationID = 3;
INSERT INTO GROUPTEST(name, locationID) VALUES(@name, @locationID);

SET
@name = "Group 4",
@locationID = 2;
INSERT INTO GROUPTEST(name, locationID) VALUES(@name, @locationID);

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
SET
@groupID = 1,
@preID = 1,
@userID = 2;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

SET
@groupID = 1,
@preID = 2,
@userID = 2;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

SET
@groupID = 1,
@preID = 3,
@userID = 2;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);
/*
SET
@groupID = 1,
@preID = 4,
@userID = 3;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);
*/
SET
@groupID = 2,
@preID = 5,
@userID = 3;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

/*Group 2*/
SET
@groupID = 2,
@preID = 1,
@userID = 3;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

SET
@groupID = 2,
@preID = 4,
@userID = 3;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

SET
@groupID = 2,
@preID = 3,
@userID = 3;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

/*Group 4*/
SET
@groupID = 4,
@preID = 4,
@userID = 2;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

SET
@groupID = 4,
@preID = 1,
@userID = 2;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);


/*TEST*/
SET 
@title = "Test 1",
@description = "Testing of the new set of monsters with updated eye colors.",
@dateCreated = "2019-01-15",
@dateEdited = "2019-01-15";
INSERT INTO TEST(title, description, dateCreated, dateEdited) VALUES 
(@title, @description, @dateCreated, @dateEdited);

SET 
@title = "Test 2",
@description = "Test the updated monsters for the early start day care centre.",
@dateCreated = "2019-04-27",
@dateEdited = "2019-04-27";
INSERT INTO TEST(title, description, dateCreated, dateEdited) VALUES 
(@title, @description, @dateCreated, @dateEdited);

SET 
@title = "Test 3",
@description = "Ranking test of the old monsters with the updated monsters.",
@dateCreated = "2019-07-14",
@dateEdited = "2019-07-14";
INSERT INTO TEST(title, description, dateCreated, dateEdited) VALUES 
(@title, @description, @dateCreated, @dateEdited);

/*LOCATIONASSIGNMENT*/
SET
@locationID = 1,
@userID = 1;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);

SET
@locationID = 1,
@userID = 2;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);

SET
@locationID = 2,
@userID = 2;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);

SET
@locationID = 2,
@userID = 3;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);

SET
@locationID = 3,
@userID = 4;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);


/*TESTASSIGNMENT*/
SET
@userID = 2,
@testID = 1,
@status = "Not conducted yet";
INSERT INTO TESTASSIGNMENT(userID, testID, status) VALUES (@userID, @testID, @status);

SET
@userID = 2,
@testID = 2,
@status = "Not conducted yet";
INSERT INTO TESTASSIGNMENT(userID, testID, status) VALUES (@userID, @testID, @status);

SET
@userID = 3,
@testID = 3,
@status = "Not conducted yet";
INSERT INTO TESTASSIGNMENT(userID, testID, status) VALUES (@userID, @testID, @status);

/*TASK*/
SET
@instruction = "Touch the smiley face if you like it and touch the sad face if you don't like it.",
@taskType = "Likert Scale";
INSERT INTO TASK(instruction, taskType) VALUES (@instruction, @taskType);

SET
@instruction = "Touch the monster's eyes.",
@taskType = "Identify Body Parts";
INSERT INTO TASK(instruction, taskType) VALUES (@instruction, @taskType);

SET
@instruction = "Select the monsters in order of your favourite to least favourite.",
@taskType = "Character Ranking";
INSERT INTO TASK(instruction, taskType) VALUES (@instruction, @taskType);
/*
SET
@instruction = "Drag the monster into the box.",
@taskType = "Drag and Drop";
INSERT INTO TASK(instruction, taskType) VALUES (@instruction, @taskType);*/

/*TASKASSIGNMENT*/
SET
@taskID = 1,
@testID = 1;
INSERT INTO TASKASSIGNMENT(taskID, testID) VALUES (@taskID, @testID);

SET
@taskID = 2,
@testID = 1;
INSERT INTO TASKASSIGNMENT(taskID, testID) VALUES (@taskID, @testID);

SET
@taskID = 3,
@testID = 1;
INSERT INTO TASKASSIGNMENT(taskID, testID) VALUES (@taskID, @testID);

SET
@taskID = 2,
@testID = 2;
INSERT INTO TASKASSIGNMENT(taskID, testID) VALUES (@taskID, @testID);

/*IMAGE*/
SET
@address = "images/Puff.png",
@imgType = true,
@taskID = 1;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "images/Puff.png",
@imgType = true,
@taskID = 2;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "images/Puff.png",
@imgType = true,
@taskID = 3;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

/*SET
@address = "images/Puff.png",
@imgType = true,
@taskID = 4;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);*/

SET
@address = "images/orbi.jpg",
@imgType = true,
@taskID = 3;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "images/peanut.jpg",
@imgType = true,
@taskID = 3;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "images/pod.jpg",
@imgType = true,
@taskID = 3;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "images/spike.jpg",
@imgType = true,
@taskID = 3;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);


/*RESULTS*/
SET 
@happy = true,
@testID = 1,
@taskID = 1,
@preID = 1;
INSERT INTO RESULTS(happy, testID, taskID, preID) VALUES (@happy, @testID, @taskID, @preID);

SET
@happy = false,
@testID = 1,
@taskID = 1,
@preID = 2;
INSERT INTO RESULTS(happy, testID, taskID, preID) VALUES (@happy, @testID, @taskID, @preID);

SET
@happy = true,
@testID = 1,
@taskID = 1,
@preID = 3;
INSERT INTO RESULTS(happy, testID, taskID, preID) VALUES (@happy, @testID, @taskID, @preID);






























