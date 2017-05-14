DROP DATABASE IF EXISTS `VIEWME`;
CREATE DATABASE `VIEWME`;
USE `VIEWME`;

DROP TABLE IF EXISTS `REGISTERED_USER` ;
CREATE TABLE `REGISTERED_USER`(
  `UserID` integer not null auto_increment,
  `Username` varchar(40) not null UNIQUE,
  `Name` varchar(40) not null,
  `Surname` varchar(40) not null,
  `Email` varchar(40) not null UNIQUE,
  `ContactNumber` varchar(15) not null,
  `Password` varchar(255) not null,
  `UserType` tinyint not null,
  `ProfilePicture` varchar(100) not null,
  `Private` tinyint not null,  /*1 = private, 0 = public */
  PRIMARY KEY (`UserID`)
);

DROP TABLE IF EXISTS `LOCATION` ;
CREATE TABLE `LOCATION`(
  `UserID` integer not null,
  `Latitude` VARCHAR(50) not null,
  `Longitude` VARCHAR(50) not null,
  FOREIGN KEY (`UserID`) REFERENCES REGISTERED_USER(`UserID`)
);

DROP TABLE IF EXISTS `FOLLOWERS` ;
CREATE TABLE `FOLLOWERS`(
  `UserID` integer not null,
  `FollowedByUserID` integer not null,
  FOREIGN KEY (`UserID`) REFERENCES REGISTERED_USER(`UserID`)

);

DROP TABLE IF EXISTS `FOLLOWING` ;
CREATE TABLE `FOLLOWING`(
  `UserID` integer not null,
  `FollowingUserID` integer not null,
  `Notify` TINYINT not null, /*0 = default(non-private) (1 = request sent to follow) (3 = request accepted) (4 = request denied) */
  FOREIGN KEY (`UserID`) REFERENCES REGISTERED_USER(`UserID`)
);

DROP TABLE IF EXISTS `POST` ;
CREATE TABLE `POST`(
  `PostID` integer not null auto_increment,
  `UserID` integer not null,
  `Text` varchar(255),
  `Source` varchar(100),
  `Visibility` TINYINT not null , /* 1 = to followers only, 0 = Public*/
  `TimeViewable` INTEGER not null,
  `TimePosted` DATETIME not null DEFAULT CURTIME(),
  `DatePosted` DATETIME not null DEFAULT CURDATE(),
  `Flag` TINYINT not null DEFAULT 0, /* (0 = not reported)(1=Reviewing)(2 = flagged)(determined by multiple occurences) (3 = removal) */
  PRIMARY KEY (`PostID`),
  FOREIGN KEY (`UserID`) REFERENCES REGISTERED_USER(`UserID`)
);

DROP TABLE IF EXISTS `LIKES` ;
CREATE TABLE `LIKES`(
  `LikeID` integer not null auto_increment,
  `UserID` integer not null, /* The ID of the user who likes the post */
  `PostID` integer not null,
  FOREIGN KEY (`UserID`) REFERENCES REGISTERED_USER(`UserID`),
  FOREIGN KEY (`PostID`) REFERENCES POST(`PostID`),
  PRIMARY KEY (`LikeID`)
);

DROP TABLE IF EXISTS `COMMENTS` ;
CREATE TABLE `COMMENTS`(
  `CommentID` integer not null auto_increment,
  `PostID` integer not null,
  `UserID` integer not null, /* The ID of the user who comments on the post */
  `CommentMessage` VARCHAR(300),
  FOREIGN KEY (`PostID`) REFERENCES POST(`PostID`),
  FOREIGN KEY (`UserID`) REFERENCES REGISTERED_USER(`UserID`),
  PRIMARY KEY (`CommentID`)
);

DROP TABLE IF EXISTS `NOTIFICATIONS` ;
CREATE TABLE `NOTIFICATIONS`(
  `NotificationID` INTEGER NOT NULL AUTO_INCREMENT,
  `UserID` INTEGER NOT NULL , /* ID of User recieving notifications*/
  `NotifierUserID` INTEGER NOT NULL , /*This is the ID of the user triggering a notification to another user*/
  `Type` TINYINT NOT NULL, /* (1 = like) , (2 = comment) , (3 = follow) (4= follow Request) */
  `TimeRecieved` DATETIME not null DEFAULT CURTIME(),
  `DateRecieved` DATETIME not null DEFAULT CURDATE(),
  `Description` VARCHAR(225) NOT NULL ,
  FOREIGN KEY (`UserID`)REFERENCES REGISTERED_USER(`UserID`),
  FOREIGN KEY (`NotifierUserID`)REFERENCES REGISTERED_USER(`UserID`),
  PRIMARY KEY (`NotificationID`)
);


INSERT INTO `REGISTERED_USER` (`UserID`,`Username`,`Name`, `Surname`,`Email`,`ContactNumber`,`Password`, `UserType`,`ProfilePicture`,`Private`) VALUES
  (1, 'nick', 'Nicholas', 'Rader', 'nick@email.co.za', '0834605522', '$2y$10$20lIJidCeh.z.BGGupMMrOFPtSMmNLLaOOgO1xhr3SxEQsTYKKoGW',3,'img/users/def.jpg',0),
  (2, 'byzo', 'Byron', 'Mills', 'byron@email.co.za', '0824569612', '$2y$10$20lIJidCeh.z.BGGupMMrOFPtSMmNLLaOOgO1xhr3SxEQsTYKKoGW',1,'img/users/def.jpg',0),
  (3, 'jords', 'Jordan', 'Van Vuuren', 'jordan@email.co.za', '0845621274', '$2y$10$20lIJidCeh.z.BGGupMMrOFPtSMmNLLaOOgO1xhr3SxEQsTYKKoGW',1,'img/users/def.jpg',0),
  (4, 'Noob', 'Jhon', 'Doe', 'jhond@email.co.za', '0845621274', '$2y$10$20lIJidCeh.z.BGGupMMrOFPtSMmNLLaOOgO1xhr3SxEQsTYKKoGW',1,'img/users/def.jpg',0);

INSERT INTO `FOLLOWERS` (`UserID`,`FollowedByUserID`) VALUES
  (1,2),
  (1,3),
  (2,3),
  (3,2);

INSERT INTO `FOLLOWING` (`UserID`,`FollowingUserID`,`Notify`) VALUES
  (2,3,0),
  (3,2,0),
  (1,2,0),
  (1,3,0);

INSERT INTO `POST` (`PostID`,`UserID`,`Text`,`Source`,`Visibility`,`TimeViewable`,`TimePosted`,`DatePosted`,`Flag`) VALUES
  (1,1,'User 1s first post','',0,'6','17:21:29', '2017-03-06','0'),
  (2,2,'User 2s first post','',0,'6','18:21:29', '2017-03-06','0'),
  (3,2,'User 2s second post','',1,'6','19:21:29', '2017-03-06','0'),
  (4,3,'User 3s first post','',0,'6', '20:21:29', '2017-03-06','0');