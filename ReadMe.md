ReadMe
=====

User(
	email 	VARCHAR(60)
	username VARCHAR(60)
	userid	INT PRIMARY KEY
	password VARCHAR(60)
	phone	VARCHAR(10)
)

Memes(
	mid 	INT PRIMARY KEY
	caption VARCHAR(150)
	image 	BLOB
	tag		VARCHAR(30)
)

Likes(
	userid 	INT	references User(userid)
	mid		INT references Memes (mid)
	date	DATETIME
	PRIMARY KEY (userid,mid)
)

Follower(
	fid		INT references User(userid)
	userid	INT references User(userid)
	date    DATETIME
	PRIMARY KEY (fid,userid)
)

Category(
	name	VARCHAR(30)
	userid	INT references User(userid)
	mid		INT references Meme(mid)
	PRIMARY KEY (userid, name)
)

insert queries
----------

insert into users values
(1, 'njiang', 'pw', 'njiang1209@ufl.edu', '9044002166'),
(2, 'gnayar', 'asdf', 'gnayar@ufl.edu', '3522746511'),
(3, 'jsmith', 'pw2', 'jsmith@ufl.edu', '1234567890'),
(4, 'jdoe', 'mypass', 'jdoe@ufl.edu', '1111111111'),
(5, 'bobama', 'potus', 'barack@ufl.edu', '9876543210'),
(6, 'cgrant', 'pass', 'cgrant@ufl.edu', '1029384756'),
(7, 'bmachen', 'pwpw', 'bmachen@ufl.edu', '0987654321')


INSERT INTO memes(memeid,caption,tag) VALUES (1,'samplecaption','sampletag'),
(2,'samplecaption2','sampletag2'),
(3,'samplecaption3','sampletag3'),
(4,'samplecaption4','sampletag4');


INSERT INTO likes VALUES 
(1,1,'2014-4-2'),
(2,1,'2014-4-2'),
(2,2,'2014-4-2'),
(3,1,'2014-4-2'),
(3,2,'2014-4-2');

insert into follower values
(1, 2, '2014-04-02'),
(1, 3, '2014-03-03'),
(1, 4, '2014-01-03'),
(2, 3, '2014-02-14'),
(4, 6, '2013-02-13'),
(5, 7, '2014-03-03');

INSERT INTO category VALUES 
('funny',1,1),
('funny',1,2),
('cute',2,3),
('cute',2,4);


select queries
----------
###Show categories of each user and how many pictures they've liked in that category
SELECT username, COUNT(memeid) AS numPics, category.name
FROM Users, Category
WHERE users.userid = category.userid
GROUP BY username, category.name
ORDER BY numPics


###shows all followers and their IDs
CREATE VIEW followerView AS SELECT DISTINCT username, fid FROM Users, Follower WHERE fid = Users.userid;
;

###Find all followers of a user (jsmith)
SELECT a.username, followerView.username AS followername
FROM (Users JOIN Follower ON Users.userid = Follower.userid) AS a, followerView WHERE a.fid = followerView.fid and a.username = 'jsmith'

###Index on Userid
CREATE INDEX users ON Users(username)







