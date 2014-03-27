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