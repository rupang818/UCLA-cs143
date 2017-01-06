-- Movie: Movie(id, title, year, rating, company)
-- Key constraint: every movie should have a unique id number
-- Check constraint: Movie's release year should be <=2016 & Shouldn't be NULL
CREATE TABLE Movie(
    id int NOT NULL,
    title varchar(100) NOT NULL,
    year int NOT NULL,
    rating varchar(10),
    company varchar(50),
    PRIMARY KEY (id),
    CHECK (year <= 2016 AND year > 0)
) ENGINE = INNODB;

-- Actor: Actor(id, last, first, sex, dob, dod)
-- Key constraint: every actor should have a unique id number
-- Check constraint: Sex of an actor should be 'Female' or 'Male' & Shouldn't be NULL
-- Every Actor should a last/first name & dob that is not nULL
CREATE TABLE Actor(
    id int NOT NULL,
    last varchar(20) NOT NULL,
    first varchar(20) NOT NULL,
    sex varchar(6) NOT NULL,
    dob date NOT NULL,
    dod date,
    PRIMARY KEY (id),
    CHECK (sex='Female' OR sex='Male')
) ENGINE = INNODB;

-- Director: Director(id, last, first, dob, dod)
-- Key constraint: every director should have a unique id number
-- Every director should have a last/first name & dob that is not NULL
CREATE TABLE Director(
    id int NOT NULL,
    last varchar(20) NOT NULL,
    first varchar(20) NOT NULL,
    dob date NOT NULL,
    dod date,
    PRIMARY KEY (id)
) ENGINE = INNODB;

-- MovieGenre: MovieGenre(mid, genre)
-- Ref. Int. constraint: Movie ID referred should exist in Movie
-- Every entry should have a not NULL mid & genre (otherwise the table wouldn't be useful)
CREATE TABLE MovieGenre(
    mid int NOT NULL,
    genre varchar(20) NOT NULL,
    FOREIGN KEY (mid) references Movie(id)
) ENGINE = INNODB;

-- MovieDirector: MovieDirector(mid, did)
-- Ref. Int. constraint: Movie ID referred should exist in Movie
-- Ref. Int. constraint: Director ID referred should exist in Director
-- Every entry should have a not NULL mid & did (otherwise the table wouldn't be useful)
CREATE TABLE MovieDirector(
    mid int NOT NULL,
    did int NOT NULL,
    FOREIGN KEY (mid) references Movie(id),
    FOREIGN KEY (did) references Director(id)
) ENGINE = INNODB;

-- MovieActor: MovieActor(mid, aid, role)
-- Ref. Int. constraint: Movie ID referred should exist in Movie
-- Ref. Int. constraint: Actor ID referred should exist in Actor
-- Every entry should have a not NULL mid & aid (otherwise the table wouldn't be useful)
CREATE TABLE MovieActor(
    mid int NOT NULL,
    aid int NOT NULL,
    role varchar(20),
    FOREIGN KEY (mid) references Movie(id),
    FOREIGN KEY (aid) references Actor(id)
) ENGINE = INNODB;

-- Review: Review(name, time, mid, rating, comment)
-- Ref. Int. constraint: Movie ID referred should exist in Movie
-- Check constraint: Reviewer's rating cannot be below 0
-- Every entry should have a not NULL name, time, mid & rating (otherwise the table wouldn't be useful)
CREATE TABLE Review(
    name varchar(20) NOT NULL,
    time timestamp NOT NULL,
    mid int NOT NULL,
    rating int NOT NULL,
    comment varchar(500),
    FOREIGN KEY (mid) references Movie(id),
    CHECK (rating >= 0)
) ENGINE = INNODB;

-- MaxPersonID & MaxMovieID: MaxPersonID(id), MaxMovieID(id)
-- The only one tuple in each of the table cannot be NULL (otherwise the table wouldn't be useful)
CREATE TABLE MaxPersonID(
    id int NOT NULL
) ENGINE = INNODB;

CREATE TABLE MaxMovieID(
    id int NOT NULL
) ENGINE = INNODB;