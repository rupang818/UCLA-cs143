-- KEY CONSTRAINTS:
-- Every movie should have a unique id number: movie id 272 already exists
INSERT INTO Movie VALUES (272,'Best Film by Jihoon',2016,'PG-13','Hoonji Corporation');
-- OUTPUT: ERROR 1062 (23000): Duplicate entry '272' for key 'PRIMARY'

-- Every director should have a unique id number: director id 45758 already exists
INSERT INTO Director VALUES (45758,'Kim','Jihoon',1988-08-18,'');
-- OUTPUT: ERROR 1062 (23000): Duplicate entry '45758' for key 'PRIMARY'

-- Every actor should have a unique id number: actor id 1 already exists
INSERT INTO Actor VALUES (1,'Hwang','Jungmin','Male',1970-09-01,'');
-- OUTPUT: ERROR 1062 (23000): Duplicate entry '1' for key 'PRIMARY'


-- REFERENTIAL INTEGRITY CONSTRAINTS (6)
-- Movie ID referred to in MovieGenre should exist in Movie: Movie id 999999999 doesn't exist in Movie table
INSERT INTO MovieGenre VALUES (999999999,'Crime');
-- OUTPUT: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

-- Movie ID referred to in MovieDirector should exist in Movie: Movie id 999999999 doesn't exist in Movie table
INSERT INTO MovieDirector VALUES (999999999,37146);
-- OUTPUT: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

-- Director ID referred to in MovieDirector should exist in Director: Director id 0 doesn't exist in Director table
INSERT INTO MovieDirector VALUES (272,0);
-- OUTPUT: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))

-- Movie ID referred to in MovieActor should exist in Movie: Movie id 999999999 doesn't exist in Movie table
INSERT INTO MovieActor VALUES (999999999,1,'laughing police');
-- OUTPUT: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

-- Actor ID referred to in MovieActor should exist in Actor: Actor id 0 doesn't exist in Actor table
INSERT INTO MovieActor VALUES (272,0,'laughing police');
-- OUTPUT: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))

-- Movie ID referred to in Review should exist in Movie: Movie id 999999999 doesn't exist in Movie table
INSERT INTO Review VALUES ('Anonymous','10-16-2016 12:00:00',999999999,10,'What a gr8 movie!');
-- OUTPUT: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))


-- CHECK CONSTRAINTS (3)
-- Sex of an actor should be 'Female' or 'Male': gender 'xe' is not recognized as a valid sex
INSERT INTO Actor VALUES (0,'District','Castro','Xe',2016-10-16,2016-10-18);

-- A movie's release year should be less than equal to 2016 and more than 0: Production year is in the future (3016)
INSERT INTO Movie VALUES (0,'Best Movie Ever',3016,'PG-13','Hoonji Corporation');

-- Review rating cannot be below 0: Review rating is a negative number
INSERT INTO Review VALUES ('Anonymous','10-16-2016 21:00:00',272,-10,'Worst movie I've ever seen!);