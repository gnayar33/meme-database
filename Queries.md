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

###Find all followers of a user (jsmith)
SELECT a.username, followerView.username AS followername
FROM (Users JOIN Follower ON Users.userid = Follower.userid) AS a, followerView WHERE a.fid = followerView.fid and a.username = 'jsmith'

###Index on Userid
CREATE INDEX users ON Users(username)



###insert new user
insert into users values (DEFAULT, '$username','$email','$password','$phone')

###insert image
insert into memes values (default, '$name', 'tag', '$oid')

###check password
select password from users where username = '$username'

###check if user exists
select * from users where username = '$username'