DROP DATABASE IF EXISTS `VIEWME`;
CREATE DATABASE `VIEWME`;
USE `VIEWME`;

DROP TABLE IF EXISTS `REGISTERED_USER` ;
CREATE TABLE `REGISTERED_USER`(
  `UserID` integer not null auto_increment,
  `Username` varchar(40) not null UNIQUE,
  `Name` varchar(40) not null,
  `Surname` varchar(40) not null,
  `Gender` tinyint not null,     /*1 = Male, 0 = Female */
  `Email` varchar(40) not null UNIQUE,
  `ContactNumber` varchar(15) not null,
  `Password` varchar(255) not null,
  `UserType` tinyint not null,
  `ProfilePicture` varchar(100) not null,
  `Private` tinyint not null,  /*1 = private, 0 = public */
  PRIMARY KEY (`UserID`)
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
  FOREIGN KEY (`UserID`) REFERENCES REGISTERED_USER(`UserID`)
);

DROP TABLE IF EXISTS `POST` ;
CREATE TABLE `POST`(
  `PostID` integer not null auto_increment,
  `UserID` integer not null,
  `Text` varchar(255),
  `Source` varchar(100),
  `visibility` TINYINT not null , /* 1 = to followers only, 0 = Public*/
  `TimeViewable` TIMESTAMP not null,
  `TimePosted` TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`PostID`),
  FOREIGN KEY (`UserID`) REFERENCES REGISTERED_USER(`UserID`)
);

DROP TABLE IF EXISTS `LIKES` ;
CREATE TABLE `LIKES`(
  `UserID` integer not null,
  `PostID` integer not null,
  FOREIGN KEY (`UserID`) REFERENCES REGISTERED_USER(`UserID`),
  FOREIGN KEY (`PostID`) REFERENCES POST(`PostID`)
);

DROP TABLE IF EXISTS `COMMENTS` ;
CREATE TABLE `COMMENTS`(
  `CommentID` integer not null auto_increment,
  `PostID` integer not null,
  `UserID` integer not null,
  FOREIGN KEY (`PostID`) REFERENCES POST(`PostID`),
  FOREIGN KEY (`UserID`) REFERENCES REGISTERED_USER(`UserID`),
  PRIMARY KEY (`CommentID`)
);


INSERT INTO `REGISTERED_USER` (`UserID`,`Username`,`Name`, `Surname`,`Gender`,`Email`,`ContactNumber`,`Password`, `UserType`,`ProfilePicture`,`Private`) VALUES
  (1, 'nick', 'Nicholas', 'Rader',1, 'nick@email.co.za', '0834605522', '$2y$10$20lIJidCeh.z.BGGupMMrOFPtSMmNLLaOOgO1xhr3SxEQsTYKKoGW',3,'img/users/def.jpg',0),
  (2, 'byzo', 'Byron', 'Mills',1, 'byron@email.co.za', '0824569612', '$2y$10$20lIJidCeh.z.BGGupMMrOFPtSMmNLLaOOgO1xhr3SxEQsTYKKoGW',1,'img/users/def.jpg',0),
  (3, 'jords', 'Jordan', 'Van Vuuren',1, 'jordan@email.co.za', '0845621274', '$2y$10$20lIJidCeh.z.BGGupMMrOFPtSMmNLLaOOgO1xhr3SxEQsTYKKoGW',1,'img/users/def.jpg',0);

INSERT INTO `FOLLOWERS` (`UserID`,`FollowedByUserID`) VALUES
  (1,2),
  (1,3),
  (2,3),
  (3,2);

INSERT INTO `FOLLOWING` (`UserID`,`FollowingUserID`) VALUES
  (2,3),
  (3,2),
  (1,2),
  (1,3);
