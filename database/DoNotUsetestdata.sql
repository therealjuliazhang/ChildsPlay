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

/*TASK*/
SET
@instruction = "Ask each participant individually if he/she likes the monster and ask him/her, 'if you like the monster, press the happy face, if you don't like the monster, press the sad face'.",
@taskType = "likert",
@testID=1;
INSERT INTO TASK(instruction, taskType, testID) VALUES (@instruction, @taskType, @testID);

SET
@instruction = "Ask each participant individually if he/she likes the monster and ask him/her, 'if you like the monster, press the happy face, if you don't like the monster, press the sad face'.",
@taskType = "ranking",
@testID=1;
INSERT INTO TASK(instruction, taskType, testID) VALUES (@instruction, @taskType, @testID);

SET
@instruction = "Ask each participant individually if he/she likes the monster and ask him/her, 'if you like the monster, press the happy face, if you don't like the monster, press the sad face'.",
@taskType = "likert",
@testID=2;
INSERT INTO TASK(instruction, taskType, testID) VALUES (@instruction, @taskType, @testID);

SET
@instruction = "Ask each participant individually if he/she likes the monster and ask him/her, 'if you like the monster, press the happy face, if you don't like the monster, press the sad face'.",
@taskType = "likert",
@testID=3;
INSERT INTO TASK(instruction, taskType, testID) VALUES (@instruction, @taskType, @testID);

/*USERS*/
SET
@username = "holly",
@password = "holly",
@email = "holly@gmail.com",
@accountType = true,
@fullName = "Holly Tootle";
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
