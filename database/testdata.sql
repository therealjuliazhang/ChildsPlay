SET 
@testName = "Test 1",
@description = "Testing of the new set of monsters with updated eye colors.";
INSERT INTO TEST(testName, description) VALUES (@testName, @description);

SET 
@testName = "Test 2",
@description = "Test the updated monsters for the early start day care centre.";
INSERT INTO TEST(testName, description) VALUES (@testName, @description);

SET 
@testName = "Test 3",
@description = "Ranking test of the old monsters with the updated monsters.";
INSERT INTO TEST(testName, description) VALUES (@testName, @description);

SET
@instruction = "Ask each participant individually if he/she likes the monster and ask him/her, 'if you like the monster, press the happy face, if you don't like the monster, press the sad face'.",
@questionType = "likert",
@testID=1;
INSERT INTO TASK(instruction, questionType, testID) VALUES (@instruction, @questionType, @testID);

SET
@instruction = "Ask each participant individually if he/she likes the monster and ask him/her, 'if you like the monster, press the happy face, if you don't like the monster, press the sad face'.",
@questionType = "ranking",
@testID=1;
INSERT INTO TASK(instruction, questionType, testID) VALUES (@instruction, @questionType, @testID);

SET
@instruction = "Ask each participant individually if he/she likes the monster and ask him/her, 'if you like the monster, press the happy face, if you don't like the monster, press the sad face'.",
@questionType = "likert",
@testID=2;
INSERT INTO TASK(instruction, questionType, testID) VALUES (@instruction, @questionType, @testID);

SET
@instruction = "Ask each participant individually if he/she likes the monster and ask him/her, 'if you like the monster, press the happy face, if you don't like the monster, press the sad face'.",
@questionType = "likert",
@testID=3;
INSERT INTO TASK(instruction, questionType, testID) VALUES (@instruction, @questionType, @testID);

SET
@name = "Group 1",
@testID = "1";
INSERT INTO GROUPTEST(groupName, testID) VALUES(@name, @testID);

SET
@name = "Group 2",
@testID = 2;
INSERT INTO GROUPTEST(groupName, testID) VALUES(@name, @testID);

SET
@name = "Group 3",
@testID = 3;
INSERT INTO GROUPTEST(groupName, testID) VALUES(@name, @testID);

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
