CREATE TABLE Movie(
	id INT NOT NULL,
	title VARCHAR(100) NOT NULL,
	year INT NOT NULL,
	rating VARCHAR(10),
	company VARCHAR(50),
	PRIMARY KEY(id), -- unique movie id
	CHECK (year > 999 AND year <= 9999) -- make sure year is 4 digits
) ENGINE = INNODB;

CREATE TABLE Actor(
	id INT NOT NULL,
	last VARCHAR(20) NOT NULL,
	first VARCHAR(20) NOT NULL,
	sex VARCHAR(6) NOT NULL,
	dob DATE NOT NULL,
	dod DATE,
	PRIMARY KEY (id) -- unique movie id
) ENGINE = INNODB;

CREATE TABLE Director(
	id INT NOT NULL,
	last VARCHAR(20) NOT NULL,
	first VARCHAR(20) NOT NULL,
	dob DATE NOT NULL,
	dod DATE,
	PRIMARY KEY (id) -- unique director id
) ENGINE = INNODB;

CREATE TABLE MovieGenre(
	mid INT NOT NULL,
	genre VARCHAR(20) NOT NULL,
	FOREIGN KEY(mid) references Movie(id) -- ref mid with id in Movie
) ENGINE = INNODB;

CREATE TABLE MovieDirector(
	mid INT NOT NULL,
	did INT NOT NULL,
	FOREIGN KEY(mid) references Movie(id), -- ref mid with id in Movie
	FOREIGN KEY(did) references Director(id) -- ref did with id in Director
) ENGINE = INNODB;

CREATE TABLE MovieActor(
	mid INT NOT NULL,
	aid INT NOT NULL,
	role VARCHAR(50),
	FOREIGN KEY(mid) references Movie(id), -- ref mid with id in Movie
	FOREIGN KEY(aid) references Actor(id) -- ref aid with id in Actor 
) ENGINE = INNODB;

CREATE TABLE Review(
	name VARCHAR(20),
	time TIMESTAMP NOT NULL,
	mid INT NOT NULL,
	rating INT NOT NULL,
	comment VARCHAR(500),
	FOREIGN KEY(mid) references Movie(id), -- ref mid with id in Movie
	CHECK (rating >= 0 AND rating <=10) -- make sure rating between 0 and 10 only
) ENGINE = INNODB;

CREATE TABLE MaxPersonID(
	id INT NOT NULL
) ENGINE = INNODB;

CREATE TABLE MaxMovieID(
	id INT NOT NULL
) ENGINE = INNODB;