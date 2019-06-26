SET 
@dateCreated = "2019-04-12",
@dateEdited = CURRENT_DATE,
@numberOfParticipants = 2,
@numberOfQuestions = 1,
@locationID = 1;
INSERT INTO TEST(dateCreated, dateEdited, numberOfParticipants, numberOfQuestions, locationID) VALUES (@dateCreated, @dateEdited, @numberOfParticipants, @numberOfQuestions, @locationID);


SET 
@name = "Wollongong Preschool";
INSERT INTO LOCATION (name) VALUES (@name);

SET 
@name = "Group 1",
@locationID = 1;
INSERT INTO GROUPTEST (name, locationID) VALUES (@name, @locationID);

SET 
@name = "Mike",
@age = 3,
@gender = "Male",
@groupID = 1;
INSERT INTO PRESCHOOLER(name, age, gender, groupID) VALUES (@name, @age, @gender, @groupID);

SET 
@name = "Anna",
@age = 2,
@gender = "Female",
@groupID = 1;
INSERT INTO PRESCHOOLER(name, age, gender, groupID) VALUES (@name, @age, @gender, @groupID);

SET 
@name = "John",
@gender = "Male",
@groupID = 1;
INSERT INTO PRESCHOOLER(name, age, gender, groupID) VALUES (@name, @age, @gender, @groupID);