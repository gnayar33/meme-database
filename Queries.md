fetchproffeed.php
-----
displays all images uploaded by a user (for their profile feed)
###
select image, uploadtime, caption from memes, users where userid = ownerid
and username = '$username' order by uploadtime desc


login.php
-----
determines whether a user has supplied the correct password
###
select password from users where username = '$username'


fetchprofpic.php
-----
fetches profile picture from a specific user
###
select profpic from users where username = '$username'


followers.php
-----
fetches list of users that a user is following
###
select * from followerNames where followername = '$username'


fetchprof.php
-----
fetches profile information about a user
###
select * from users where username = '$username'


image.php
-----
adds new image to database
###
select userid from users where username = '" . $_SESSION['userName']
###
insert into memes values (default, '$name', 'tag', '$oid', '$uid', default)


newuser.php
-----
creates a new user
###
insert into users values (DEFAULT, '$username','$email','$password','$phone')


VIEWS
-----
shows usernames of all follows (following and followee)
###
CREATE VIEW followernames SELECT a.username, followerview.username AS followername
   FROM (users
   JOIN follower ON users.userid = follower.userid) a, followerview
  WHERE a.fid = followerview.fid;

###
CREATE VIEW followerView AS SELECT DISTINCT username, fid FROM Users, Follower WHERE fid = Users.userid


unused
----------
###Show categories of each user and how many pictures they've liked in that category
SELECT username, COUNT(memeid) AS numPics, category.name
FROM Users, Category
WHERE users.userid = category.userid and username = 'njiang'
GROUP BY username, category.name
ORDER BY numPics


###Find all followers of a user (jsmith)
SELECT a.username, followerView.username AS followername
FROM (Users JOIN Follower ON Users.userid = Follower.userid) AS a, followerView WHERE a.fid = followerView.fid and a.username = 'jsmith'



INDEXES
###Index on Userid
CREATE INDEX users ON Users(username)