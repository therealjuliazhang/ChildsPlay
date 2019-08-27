/*USERS*/
SET
@username = "admin",
@password = "21232f297a57a5a743894a0e4a801fc3",
@email = "admin@gmail.com",
@accountType = true,
@fullName = "admin";
INSERT INTO USERS(username, password, email, accountType, fullName) VALUES (@username, @password, @email, @accountType, @fullName);

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
@locationID = 2,
@userID = 2;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);

SET
@locationID = 2,
@userID = 1;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);

SET
@locationID = 3,
@userID = 4;
INSERT INTO LOCATIONASSIGNMENT(locationID, userID) VALUES (@locationID, @userID);


/*TESTASSIGNMENT*/
SET
@userID = 1,
@testID = 1,
@status = "Not conducted yet";
INSERT INTO TESTASSIGNMENT(userID, testID, status) VALUES (@userID, @testID, @status);

SET
@userID = 1,
@testID = 2,
@status = "Not conducted yet";
INSERT INTO TESTASSIGNMENT(userID, testID, status) VALUES (@userID, @testID, @status);

SET
@userID = 1,
@testID = 3,
@status = "Not conducted yet";
INSERT INTO TESTASSIGNMENT(userID, testID, status) VALUES (@userID, @testID, @status);

/*TASK*/
SET
@instruction = "Touch the smiley face if you like it and touch the sad face if you don't like it.",
@taskType = "Likert Scale",
@activity = "Do you like this monster?";
INSERT INTO TASK(instruction, taskType, activity) VALUES (@instruction, @taskType, @activity);

SET
@instruction = "Touch the monster's eyes.",
@taskType = "Identify Body Parts",
@activity = "Touch the monster's eyes.";
INSERT INTO TASK(instruction, taskType, activity) VALUES (@instruction, @taskType, @activity);

SET
@instruction = "Select the monsters in order of your favourite to least favourite.",
@taskType = "Character Ranking",
@activity = "Select the monsters in order of your favourite to least favourite.";
INSERT INTO TASK(instruction, taskType, activity) VALUES (@instruction, @taskType, @activity);

SET
@instruction = "How would you make the monster bigger?",
@taskType = "Preferred Mechanic",
@activity = "Make the monster bigger.";
INSERT INTO TASK(instruction, taskType, activity) VALUES (@instruction, @taskType, @activity);

SET
@instruction = "How would you move the monster into the box?",
@taskType = "Preferred Mechanic",
@activity = "Move the monster.";
INSERT INTO TASK(instruction, taskType, activity) VALUES (@instruction, @taskType, @activity);

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
@taskID = 4,
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

SET
@address = "images/spike.jpg",
@imgType = true,
@taskID = 4;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "images/spike.jpg",
@imgType = true,
@taskID = 5;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

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
@x = 410.00,
@y = 155.00,
@taskID = 2,
@preID = 1,
@testID = 1;
INSERT INTO RESULTS(x, y, taskID, preID, testID) VALUES (@x, @y, @taskID, @preID, @testID);

SET
@x = 375.00,
@y = 107.00,
@taskID = 2,
@preID = 2,
@testID = 1;
INSERT INTO RESULTS(x, y, taskID, preID, testID) VALUES (@x, @y, @taskID, @preID, @testID);

SET
@x = 440.00,
@y = 125.00,
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
