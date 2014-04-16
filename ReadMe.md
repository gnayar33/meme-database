ReadMe
=====

create table users (
	userid serial primary key,
	username varchar(50) unique,
	email varchar(50),
	password varchar(50),
	phone varchar(10)
);


create table Memes(
	mid 	serial PRIMARY KEY,
	caption VARCHAR(150),
	image bytea,
	tag VARCHAR(30)
);

create table Likes(
	userid int references Users(userid),
	mid INT references Memes(mid),
	date		DATE,
	PRIMARY KEY (userid,mid)
)

create table Follower(
	fid INT references Users(userid),
	userid INT references Users(userid),
	date DATE,
	PRIMARY KEY (fid,userid)
)

create table Category(
	name VARCHAR(30),
	userid INT references Users(userid),
	mid INT references Memes(mid),
	PRIMARY KEY (userid, name, mid)
)

insert queries
----------

insert into users values
(default, 'njiang', 'njiang1209@ufl.edu','pw', '9044002166'),
(default, 'gnayar', 'gnayar@ufl.edu', 'asdf', '3522746511'),
(default, 'jsmith', 'jsmith@ufl.edu', 'pw2', '1234567890'),
(default, 'jdoe', 'jdoe@ufl.edu', 'mypass', '1111111111'),
(default, 'bobama', 'barack@ufl.edu', 'potus', '9876543210'),
(default, 'cgrant', 'cgrant@ufl.edu', 'pass', '1029384756'),
(default, 'bmachen', 'bmachen@ufl.edu', 'pwpw', '0987654321');


INSERT INTO memes values
(default,'samplecaption','','sampletag'),
(default,'samplecaption2','' ,'sampletag2'),
(default,'samplecaption3','' ,'sampletag3'),
(default,'samplecaption4','' ,'sampletag4');


INSERT INTO likes VALUES 
(16,9,'2014-4-2'),
(17,9,'2014-4-2'),
(17,10,'2014-4-2'),
(18,11,'2014-4-2'),
(18,12,'2014-4-2');

insert into follower values
(16, 17, '2014-04-02'),
(16, 18, '2014-03-03'),
(16, 19, '2014-01-03'),
(17, 16, '2014-02-14'),
(18, 19, '2013-02-13'),
(18, 20, '2014-03-03');

INSERT INTO category VALUES 
('funny',16,9),
('funny',16,10),
('cute',17,11),
('cute',17,12);


select queries
----------
###Show categories of each user and how many pictures they've liked in that category
SELECT username, COUNT(memeid) AS numPics, category.name
FROM Users, Category
WHERE users.userid = category.userid and username = 'njiang'
GROUP BY username, category.name
ORDER BY numPics


###shows all followers and their IDs
CREATE VIEW followerView AS SELECT DISTINCT username, fid FROM Users, Follower WHERE fid = Users.userid;
;

###translation of follower table, showing usernames instead
CREATE VIEW followerNames as (SELECT a.username, followerView.username AS followername
FROM (Users JOIN Follower ON Users.userid = Follower.userid) AS a, followerView)

###Find all users a user is following (jsmith)
select * from followerNames where followername = 'jsmith';

###Find all followers of a user (jsmith)
select * from followerNames where username = 'jsmith';

###Index on Userid
CREATE INDEX users ON Users(username)

##insert new user
