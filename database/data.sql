/*USERS*/
SET
@username = "admin",
@password = "21232f297a57a5a743894a0e4a801fc3",
@email = "admin@gmail.com",
@accountType = true,
@fullName = "admin",
@accepted = 1;
INSERT INTO USERS(username, password, email, accountType, fullName, accepted) VALUES (@username, @password, @email, @accountType, @fullName, @accepted);

SET
@username = "holly",
@password = "holly",
@email = "holly@gmail.com",
@accountType = true,
@fullName = "Holly Tootell",
@accepted = 1;
INSERT INTO USERS(username, password, email, accountType, fullName, accepted) VALUES (@username, @password, @email, @accountType, @fullName, @accepted);

SET
@username = "james",
@password = "james",
@email = "james@gmail.com",
@accountType = false,
@fullName = "James Bonds",
@accepted = 1;
INSERT INTO USERS(username, password, email, accountType, fullName, accepted) VALUES (@username, @password, @email, @accountType, @fullName, @accepted);

SET
@username = "emma",
@password = "emma",
@email = "emma@gmail.com",
@accountType = false,
@fullName = "Emma Greens",
@accepted = 0;
INSERT INTO USERS(username, password, email, accountType, fullName, accepted) VALUES (@username, @password, @email, @accountType, @fullName, @accepted);

SET
@username = "jasmine",
@password = "jasmine",
@email = "jasmine@gmail.com",
@accountType = false,
@fullName = "Jasmine Flores",
@accepted = 0;
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
@userID = 1;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

SET
@groupID = 1,
@preID = 2,
@userID = 1;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

SET
@groupID = 1,
@preID = 3,
@userID = 1;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

/*Group 2*/
SET
@groupID = 2,
@preID = 1,
@userID = 1;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

SET
@groupID = 2,
@preID = 4,
@userID = 1;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

SET
@groupID = 2,
@preID = 3,
@userID = 1;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

/*Group 4*/
SET
@groupID = 4,
@preID = 2,
@userID = 1;
INSERT INTO GROUPASSIGNMENT(groupID, preID, userID) VALUES (@groupID, @preID, @userID);

SET
@groupID = 4,
@preID = 5,
@userID = 1;
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
@locationID = 1,
@userID = 3;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);

SET
@locationID = 1,
@userID = 4;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);

SET
@locationID = 2,
@userID = 3;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);

SET
@locationID = 2,
@userID = 5;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);

SET
@locationID = 3,
@userID = 5;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);


/*TESTASSIGNMENT*/
SET
@userID = 1,
@testID = 1;
INSERT INTO TESTASSIGNMENT(userID, testID) VALUES (@userID, @testID);

SET
@userID = 1,
@testID = 2,
@dateConducted = "2019-07-04";
INSERT INTO TESTASSIGNMENT(userID, testID, dateConducted) VALUES (@userID, @testID, @dateConducted);

SET
@userID = 1,
@testID = 3;
INSERT INTO TESTASSIGNMENT(userID, testID) VALUES (@userID, @testID);

SET
@userID = 2,
@testID = 1;
INSERT INTO TESTASSIGNMENT(userID, testID) VALUES (@userID, @testID);

SET
@userID = 2,
@testID = 2,
@dateConducted = "2019-08-14";
INSERT INTO TESTASSIGNMENT(userID, testID, dateConducted) VALUES (@userID, @testID, @dateConducted);

/*TASK*/
SET
@instruction = "Touch the smiley face if you like it and touch the sad face if you don't like it.",
@activityStyle = "Likert Scale";
INSERT INTO TASK(instruction, activityStyle) VALUES (@instruction, @activityStyle);

SET
@instruction = "Touch the monster's eyes.",
@activityStyle = "Identify Body Parts";
INSERT INTO TASK(instruction, activityStyle) VALUES (@instruction, @activityStyle);

SET
@instruction = "Select the monsters in order of your favourite to least favourite.",
@activityStyle = "Character Ranking";
INSERT INTO TASK(instruction, activityStyle) VALUES (@instruction, @activityStyle);

SET
@instruction = "How would you make the monster bigger?",
@activityStyle = "Preferred Mechanic";
INSERT INTO TASK(instruction, activityStyle) VALUES (@instruction, @activityStyle);

SET
@instruction = "How would you move the monster into the box?",
@activityStyle = "Preferred Mechanic";
INSERT INTO TASK(instruction, activityStyle) VALUES (@instruction, @activityStyle);

/*TASKASSIGNMENT*/
SET
@taskID = 1,
@testID = 1,
@taskTitle = "Task 1",
@orderInTest = 1,
@comments = "Alex changed his mind after pressing like.";
INSERT INTO TASKASSIGNMENT(taskID, testID, taskTitle, orderInTest, comments) VALUES (@taskID, @testID, @taskTitle, @orderInTest, @comments);

SET
@taskID = 2,
@testID = 1,
@taskTitle = "Task 2",
@orderInTest = 2,
@comments = "Ren was not sure if she liked the monster.";
INSERT INTO TASKASSIGNMENT(taskID, testID, taskTitle, orderInTest, comments) VALUES (@taskID, @testID, @taskTitle, @orderInTest, @comments);

SET
@taskID = 3,
@testID = 1,
@taskTitle = "Task 3",
@orderInTest = 3,
@comments = "Kate was not sure if she liked the monster.";
INSERT INTO TASKASSIGNMENT(taskID, testID, taskTitle, orderInTest) VALUES (@taskID, @testID, @taskTitle, @orderInTest);

SET
@taskID = 4,
@testID = 1,
@taskTitle = "Task 4",
@orderInTest = 4,
@comments = "Andre was not sure if she liked the monster.";
INSERT INTO TASKASSIGNMENT(taskID, testID, taskTitle, orderInTest) VALUES (@taskID, @testID, @taskTitle, @orderInTest);

SET
@taskID = 2,
@testID = 2,
@taskTitle = "Task 1",
@orderInTest = 1;
INSERT INTO TASKASSIGNMENT(taskID, testID, taskTitle, orderInTest) VALUES (@taskID, @testID, @taskTitle, @orderInTest);

SET
@taskID = 5,
@taskTitle = "Task 2",
@testID = 2,
@orderInTest = 2;
INSERT INTO TASKASSIGNMENT(taskID, testID, taskTitle, orderInTest) VALUES (@taskID, @testID, @taskTitle, @orderInTest);

/*IMAGE*/
SET
@address = "images/Puff.png";
INSERT INTO IMAGE(address) VALUES (@address);

SET
@address = "images/Puff.png";
INSERT INTO IMAGE(address) VALUES (@address);

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

SET
@address = "images/spike.jpg";
INSERT INTO IMAGE(address) VALUES (@address);

SET
@address = "images/spike.jpg";
INSERT INTO IMAGE(address) VALUES (@address);

/*IMAGEASSIGNMENT*/
SET
@imageID = 1,
@taskID = 1;
INSERT INTO IMAGEASSIGNMENT VALUES (@imageID, @taskID);

SET
@imageID = 2,
@taskID = 2;
INSERT INTO IMAGEASSIGNMENT VALUES (@imageID, @taskID);

SET
@imageID = 3,
@taskID = 3;
INSERT INTO IMAGEASSIGNMENT VALUES (@imageID, @taskID);

SET
@imageID = 4,
@taskID = 3;
INSERT INTO IMAGEASSIGNMENT VALUES (@imageID, @taskID);

SET
@imageID = 5,
@taskID = 3;
INSERT INTO IMAGEASSIGNMENT VALUES (@imageID, @taskID);

SET
@imageID = 6,
@taskID = 3;
INSERT INTO IMAGEASSIGNMENT VALUES (@imageID, @taskID);

SET
@imageID = 7,
@taskID = 3;
INSERT INTO IMAGEASSIGNMENT VALUES (@imageID, @taskID);

SET
@imageID = 8,
@taskID = 4;
INSERT INTO IMAGEASSIGNMENT VALUES (@imageID, @taskID);

SET
@imageID = 9,
@taskID = 5;
INSERT INTO IMAGEASSIGNMENT VALUES (@imageID, @taskID);

/*RESULTS*/
SET 
@happy = true,
@taskID = 1,
@preID = 1,
@testID = 1;
INSERT INTO RESULTS(happy, taskID, preID, testID) VALUES (@happy, @taskID, @preID, @testID);

SET
@happy = false,
@taskID = 1,
@preID = 2,
@testID = 1;
INSERT INTO RESULTS(happy, taskID, preID, testID) VALUES (@happy, @taskID, @preID, @testID);

SET
@happy = true,
@taskID = 1,
@preID = 3,
@testID = 1;
INSERT INTO RESULTS(happy, taskID, preID, testID) VALUES (@happy, @taskID, @preID, @testID);

SET
@happy = true,
@taskID = 1,
@preID = 4,
@testID = 1;
INSERT INTO RESULTS(happy, taskID, preID, testID) VALUES (@happy, @taskID, @preID, @testID);

SET
@happy = true,
@taskID = 1,
@preID = 5,
@testID = 1;
INSERT INTO RESULTS(happy, taskID, preID, testID) VALUES (@happy, @taskID, @preID, @testID);

SET
@mechanic = "Press",
@taskID = 4,
@preID = 1,
@testID = 2;
INSERT INTO RESULTS(mechanic, taskID, preID, testID) VALUES (@mechanic, @taskID, @preID, @testID);

SET
@mechanic = "Zoom/Pinch",
@taskID = 4,
@preID = 2,
@testID = 2;
INSERT INTO RESULTS(mechanic, taskID, preID, testID) VALUES (@mechanic, @taskID, @preID, @testID);

SET
@mechanic = "Swipe/Drag",
@taskID = 4,
@preID = 3,
@testID = 2;
INSERT INTO RESULTS(mechanic, taskID, preID, testID) VALUES (@mechanic, @taskID, @preID, @testID);

SET
@mechanic = "Swipe/Drag",
@taskID = 5,
@preID = 3,
@testID = 2;
INSERT INTO RESULTS(mechanic, taskID, preID, testID) VALUES (@mechanic, @taskID, @preID, @testID);

SET
@x = 0.4119402985074626700000,
@y = 0.2750000000000000000000,
@taskID = 2,
@preID = 1,
@testID = 1;
INSERT INTO RESULTS(x, y, taskID, preID, testID) VALUES (@x, @y, @taskID, @preID, @testID);

SET
@x = 0.6149253731343284000000,
@y = 0.2750000000000000000000,
@taskID = 2,
@preID = 2,
@testID = 1;
INSERT INTO RESULTS(x, y, taskID, preID, testID) VALUES (@x, @y, @taskID, @preID, @testID);

SET
@x = 0.5044776119402985000000,
@y = 0.5350000000000000000000,
@taskID = 2,
@preID = 3,
@testID = 1;
INSERT INTO RESULTS(x, y, taskID, preID, testID) VALUES (@x, @y, @taskID, @preID, @testID);

SET
@imageID = 3,
@score = 5,
@taskID = 3,
@preID = 1,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 3,
@score = 10,
@taskID = 3,
@preID = 2,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 3,
@score = 10,
@taskID = 3,
@preID = 3,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 4,
@score = 10,
@taskID = 3,
@preID = 1,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 4,
@score = 5,
@taskID = 3,
@preID = 2,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 4,
@score = 5,
@taskID = 3,
@preID = 3,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 5,
@score = 15,
@taskID = 3,
@preID = 1,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 5,
@score = 15,
@taskID = 3,
@preID = 2,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 5,
@score = 20,
@taskID = 3,
@preID = 3,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 6,
@score = 20,
@taskID = 3,
@preID = 1,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 6,
@score = 20,
@taskID = 3,
@preID = 2,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 6,
@score = 15,
@taskID = 3,
@preID = 3,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 7,
@score = 25,
@taskID = 3,
@preID = 1,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 7,
@score = 25,
@taskID = 3,
@preID = 2,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);

SET
@imageID = 7,
@score = 25,
@taskID = 3,
@preID = 3,
@testID = 1;
INSERT INTO RANKING(imageID, score, taskID, preID, testID) VALUES (@imageID, @score, @taskID, @preID, @testID);
