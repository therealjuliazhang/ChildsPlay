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
@name = "Mulberry Hill Preschool",
@userID = 2;
INSERT INTO LOCATION(name, userID) VALUES (@name, @userID);

SET
@name = "Smith Preschool",
@userID = 3;
INSERT INTO LOCATION(name, userID) VALUES (@name, @userID);

SET
@name = "Miranda Kindergarten",
@userID = 4;
INSERT INTO LOCATION(name, userID) VALUES (@name, @userID);

/*GROUPTEST*/
SET
@name = "Group 1",
@locationID = "1";
INSERT INTO GROUPTEST(name, locationID) VALUES(@name, @locationID);

SET
@name = "Group 2",
@locationID = 2;
INSERT INTO GROUPTEST(name, locationID) VALUES(@name, @locationID);

SET
@name = "Group 3",
@locationID = 3;
INSERT INTO GROUPTEST(name, locationID) VALUES(@name, @locationID);

/*PRESCHOOLER*/
SET 
@name = "Julia",
@age = 6,
@gender = "Female",
@groupID = 1;
INSERT INTO PRESCHOOLER(name, age, gender, groupID) VALUES (@name, @age, @gender, @groupID);

SET 
@name = "Alex",
@age = 10,
@gender = "Male",
@groupID = 1;
INSERT INTO PRESCHOOLER(name, age, gender, groupID) VALUES (@name, @age, @gender, @groupID);

SET 
@name = "Eric",
@age = 8,
@gender = "Male",
@groupID = 1;
INSERT INTO PRESCHOOLER(name, age, gender, groupID) VALUES (@name, @age, @gender, @groupID);

SET 
@name = "Kate",
@age = 7,
@gender = "Female",
@groupID = 1;
INSERT INTO PRESCHOOLER(name, age, gender, groupID) VALUES (@name, @age, @gender, @groupID);

SET 
@name = "Ren",
@age = 8,
@gender = "Male",
@groupID = 1;
INSERT INTO PRESCHOOLER(name, age, gender, groupID) VALUES (@name, @age, @gender, @groupID);

/*GROUPASSIGNMENT*/
SET
@groupID = 1,
@preID = 1;
INSERT INTO GROUPASSIGNMENT(groupID, preID) VALUES (@groupID, @preID);

SET
@groupID = 1,
@preID = 2;
INSERT INTO GROUPASSIGNMENT(groupID, preID) VALUES (@groupID, @preID);

SET
@groupID = 1,
@preID = 3;
INSERT INTO GROUPASSIGNMENT(groupID, preID) VALUES (@groupID, @preID);

SET
@groupID = 1,
@preID = 4;
INSERT INTO GROUPASSIGNMENT(groupID, preID) VALUES (@groupID, @preID);

SET
@groupID = 1,
@preID = 5;
INSERT INTO GROUPASSIGNMENT(groupID, preID) VALUES (@groupID, @preID);

/*TEST*/
SET 
@title = "Test 1",
@description = "Testing of the new set of monsters with updated eye colors.",
@dateCreated = "2019-01-15",
@dateEdited = "2019-01-15",
@numberOfParticipants = 3,
@numberOfQuestions = 1;
INSERT INTO TEST(title, description, dateCreated, dateEdited, numberOfParticipants, numberOfQuestions) VALUES 
(@title, @description, @dateCreated, @dateEdited, @numberOfParticipants, @numberOfQuestions);

SET 
@title = "Test 2",
@description = "Test the updated monsters for the early start day care centre.",
@dateCreated = "2019-04-27",
@dateEdited = "2019-04-27",
@numberOfParticipants = 2,
@numberOfQuestions = 1;
INSERT INTO TEST(title, description, dateCreated, dateEdited, numberOfParticipants, numberOfQuestions) VALUES 
(@title, @description, @dateCreated, @dateEdited, @numberOfParticipants, @numberOfQuestions);

SET 
@title = "Test 3",
@description = "Ranking test of the old monsters with the updated monsters.",
@dateCreated = "2019-07-14",
@dateEdited = "2019-07-14",
@numberOfParticipants = 3,
@numberOfQuestions = 1;
INSERT INTO TEST(title, description, dateCreated, dateEdited, numberOfParticipants, numberOfQuestions) VALUES 
(@title, @description, @dateCreated, @dateEdited, @numberOfParticipants, @numberOfQuestions);

/*TESTASSIGNMENT*/
SET
@userID = 1,
@testID = 1,
@status = "Not yet conducted";
INSERT INTO TESTASSIGNMENT(userID, testID, status) VALUES (@userID, @testID, @status);

SET
@userID = 1,
@testID = 2,
@status = "Not yet conducted";
INSERT INTO TESTASSIGNMENT(userID, testID, status) VALUES (@userID, @testID, @status);

SET
@userID = 1,
@testID = 3,
@status = "Not yet conducted";
INSERT INTO TESTASSIGNMENT(userID, testID, status) VALUES (@userID, @testID, @status);

/*TASK*/
SET
@instruction = "Touch the smiley face if you like it and touch the sad face if you don't like it.",
@taskType = "Likert Scale",
@testID = 1;
INSERT INTO TASK(instruction, taskType, testID) VALUES (@instruction, @taskType, @testID);

SET
@instruction = "Touch the monster's eyes.",
@taskType = "Identify Body Parts",
@testID = 1;
INSERT INTO TASK(instruction, taskType, testID) VALUES (@instruction, @taskType, @testID);

SET
@instruction = "Select the monsters in order of your favourite to least favourite.",
@taskType = "Character Ranking",
@testID = 1;
INSERT INTO TASK(instruction, taskType, testID) VALUES (@instruction, @taskType, @testID);

SET
@instruction = "Drag the monster into the box.",
@taskType = "Drag and Drop",
@testID = 1;
INSERT INTO TASK(instruction, taskType, testID) VALUES (@instruction, @taskType, @testID);

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

/*IMAGE*/
SET
@address = "/images/Puff.png",
@imgType = true,
@taskID = 1;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "/images/Puff.png",
@imgType = true,
@taskID = 2;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "/images/Puff.png",
@imgType = true,
@taskID = 3;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "/images/Puff.png",
@imgType = true,
@taskID = 4;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "/images/orbi.jpg",
@imgType = true,
@taskID = 3;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "/images/peanut.jpg",
@imgType = true,
@taskID = 3;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "/images/pod.jpg",
@imgType = true,
@taskID = 3;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);

SET
@address = "/images/spike.jpg",
@imgType = true,
@taskID = 3;
INSERT INTO IMAGE(address, imgType, taskID) VALUES (@address, @imgType, @taskID);